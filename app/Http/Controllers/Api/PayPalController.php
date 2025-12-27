<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use App\Models\Transition;
use App\Models\User;
use App\Models\StateFee;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Services\PayPalService;
use App\Services\PaymentProcessingService;
use App\Services\StoreDataService;
use App\Services\DataTransformationService;

class PayPalController extends Controller
{
    protected $payPalService;

    public function __construct(PayPalService $payPalService)
    {
        $this->payPalService = $payPalService;
    }

    public function createPayment(Request $request): JsonResponse
    {
        try {
            // Check if PayPal is configured
            $mode = env('PAYPAL_MODE', 'sandbox');
            $clientId = $mode === 'sandbox' ? env('PAYPAL_SANDBOX_CLIENT_ID') : env('PAYPAL_LIVE_CLIENT_ID');
            $clientSecret = $mode === 'sandbox' ? env('PAYPAL_SANDBOX_CLIENT_SECRET') : env('PAYPAL_LIVE_CLIENT_SECRET');
            
            if (!$clientId || !$clientSecret) {
                Log::error('PayPal credentials not configured', [
                    'mode' => $mode,
                    'client_id_exists' => !empty($clientId),
                    'client_secret_exists' => !empty($clientSecret)
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment gateway not configured'
                ], 500);
            }

            // Store the company formation data first
            $request->localStorageData = json_decode($request->localStorageData, true);
            
            // Transform Next.js data structure to Laravel expected structure
            $transformedData = DataTransformationService::transformNextJsToLaravel($request->localStorageData);
            $request->localStorageData = $transformedData;
            
            // Store transformed data in session for later use in success callback
            session(['transformed_data' => $transformedData]);
            
            $result = StoreDataService::storeData($request);
            
            if (!$result['success']) {
                $errorMessage = $result['error'];
                
                // Handle specific error cases
                if (strpos($errorMessage, 'Email Already Exists') !== false) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'An account with this email already exists. Please login first or use a different email address.',
                        'error_type' => 'email_exists'
                    ], 400);
                }
                
                return response()->json([
                    'status' => 'error',
                    'message' => $errorMessage
                ], 400);
            }

            $company = Company::find($result['company_id']);
            $user = User::find($result['user_id']);

            // Create PayPal payment
            $response = $this->payPalService->createPayment($company->total_amount);
            
            if (isset($response['id']) && $response['id'] != null) {
                // Find the approval URL
                $approvalUrl = null;
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        $approvalUrl = $link['href'];
                        break;
                    }
                }

                if ($approvalUrl) {
                    // Store session data for later use
                    session(['company_id' => $result['company_id']]);
                    session(['user_id' => $result['user_id']]);
                    session(['paypal_payment_id' => $response['id']]);

                    return response()->json([
                        'status' => 'success',
                        'data' => [
                            'payment_id' => $response['id'],
                            'approval_url' => $approvalUrl,
                            'user_id' => $result['user_id'],
                            'company_id' => $result['company_id'],
                        ]
                    ]);
                } else {
                    throw new \Exception('PayPal approval URL not found');
                }
            } else {
                throw new \Exception('Failed to create PayPal payment');
            }

        } catch (\Exception $e) {
            Log::error('PayPal payment creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create PayPal payment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function success(Request $request)
    {
        try {
            $token = $request->query('token');
            $paymentId = $request->query('PayerID');

            if (!$token || !$paymentId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Missing required parameters'
                ], 400);
            }

            // Capture the payment
            $response = $this->payPalService->capturePayment($token);
            
            $user = User::find(session('user_id'));
            $company = Company::find(session('company_id'));

            if (!$user || !$company) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User or company not found'
                ], 400);
            }

            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                // Get order if not already available
                $order = Order::where('company_id', $company->id)->first();

                if (!$order) {
                    throw new \Exception('Order not found for company');
                }

                // Extract services from transformed data (stored in createPayment)
                $transformedData = session('transformed_data');
                $services = PaymentProcessingService::extractServicesFromData($transformedData);

                // Process payment completion using PaymentProcessingService
                $paymentData = [
                    'user' => $user,
                    'company' => $company,
                    'order' => $order,
                    'charge_id' => $response['id'],
                    'payment_method' => 'PayPal',
                    'amount' => $company->total_amount,
                    'status' => $response['status'],
                    'card_type' => 'PayPal',
                    'receipt_url' => null,
                    'player_name' => $response['payer']['name']['given_name'] . ' ' . $response['payer']['name']['surname'],
                ];
                
                // Add services array if services exist
                if (!empty($services)) {
                    $paymentData['services'] = $services;
                }
                
                $paymentResult = PaymentProcessingService::processPaymentCompletion($paymentData);

                if (!$paymentResult['success']) {
                    throw new \Exception($paymentResult['error'] ?? 'Failed to process payment completion');
                }

                $tempToken = $paymentResult['temp_token'];

                // Clear session data
                session()->forget(['user_id', 'company_id', 'paypal_payment_id', 'transformed_data']);

                // Redirect to setup-company page with success parameters and temp token
                return redirect($this->getFrontendUrl() . '/setup-company?payment=success&token=' . $token . '&PayerID=' . $paymentId . '&temp_login_token=' . $tempToken);
            } else {
                // Payment failed - clean up
                if ($company && $company->owners) {
                    $company->owners()->delete();
                }
                if ($company->order) {
                    $company->order->delete();
                }
                if ($company) {
                    $company->delete();
                }
                if ($user) {
                    $user->delete();
                }

                // Clear session data
                session()->forget(['user_id', 'company_id', 'paypal_payment_id']);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment failed. Status: ' . ($response['status'] ?? 'unknown')
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('PayPal payment success processing failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process payment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cancel(Request $request)
    {
        try {
            $user = User::find(session('user_id'));
            $company = Company::find(session('company_id'));

            if ($company) {
                // Clean up data
                if ($company->owners) {
                    $company->owners()->delete();
                }
                if ($company->order) {
                    $company->order->delete();
                }
                if ($company) {
                    $company->delete();
                }
                if ($user) {
                    $user->delete();
                }
            }

            // Clear session data
            session()->forget(['user_id', 'company_id', 'paypal_payment_id']);

            // Redirect to frontend cancel page
            return redirect($this->getFrontendUrl() . '/setup-company?payment=cancel');

        } catch (\Exception $e) {
            Log::error('PayPal payment cancel processing failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process cancellation: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get frontend URL based on environment
     */
    private function getFrontendUrl()
    {
        return env('FRONTEND_URL', 'http://localhost:3000');
    }
} 