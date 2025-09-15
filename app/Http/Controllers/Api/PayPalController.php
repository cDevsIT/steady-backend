<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use App\Models\Transition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Services\PayPalService;
use App\Services\StoreDataService;

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
            $transformedData = $this->transformDataForLaravel($request->localStorageData);
            $request->localStorageData = $transformedData;
            
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
                // Create transaction record
                $transaction = new Transition();
                $transaction->company_id = $company->id;
                $transaction->user_id = $user->id;
                $transaction->charge_id = $response['id'];
                $transaction->status = $response['status'];
                $transaction->payment_method = 'PayPal';
                $transaction->receipt_url = '';
                $transaction->card_type = 'PayPal';
                $transaction->amount = $company->total_amount;
                $transaction->player_name = $response['payer']['name']['given_name'] . ' ' . $response['payer']['name']['surname'];
                $transaction->save();

                // Update company and order
                $company->transition_id = $transaction->id;
                $company->save();

                $order = Order::where('company_id', $company->id)->first();
                if ($order) {
                    $order->transition_id = $transaction->id;
                    $order->payment_status = $transaction->status;
                    $order->save();
                }

                // Generate temporary login token
                $tempToken = \Illuminate\Support\Str::random(32);
                $user->temp_login_token = $tempToken;
                $user->temp_token_expires_at = now()->addMinutes(30); // Token expires in 30 minutes
                $user->save();

                // Send email
                $to = $user->email;
                $subject = "Steady Formation Access";
                $password = $user->temp_password;

                Mail::send('email_templates.registration', compact('user', 'password'), function ($message) use ($subject, $to) {
                    $message->from('noreply@funnel.com', env('APP_NAME', 'Steady Formation Access'));
                    $message->to($to);
                    $message->subject($subject);
                });

                // Clear session data
                session()->forget(['user_id', 'company_id', 'paypal_payment_id']);

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

    private function transformDataForLaravel($nextJsData)
    {
        Log::info('Transforming Next.js data to Laravel format (PayPal):', $nextJsData);
        
        $laravelData = [];
        
        // Step 1: Company Name
        $laravelData['s1_company_name'] = $nextJsData['companyName'] ?? '';
        
        // Step 2: User Info
        $laravelData['s2_stepTowData'] = [
            'first_name' => $nextJsData['userInfo']['first_name'] ?? '',
            'last_name' => $nextJsData['userInfo']['last_name'] ?? '',
            'email' => $nextJsData['userInfo']['email'] ?? '',
            'phone_number' => $nextJsData['userInfo']['phone_number'] ?? '',
        ];
        
        // Check if user is authenticated (for existing users)
        if (auth()->check()) {
            $laravelData['active_user'] = auth()->id();
        }
        
        // Step 3: Business Details
        $laravelData['s3_business_type'] = $nextJsData['businessType'] ?? '';
        $laravelData['s3_business_type_sub'] = $nextJsData['businessDetails']['llcType'] ?? '';
        $laravelData['s3_type_of_industry'] = $nextJsData['businessDetails']['industryType'] ?? '';
        $laravelData['s3_state_name'] = $nextJsData['businessDetails']['stateName'] ?? '';
        $laravelData['s3_number_of_ownership'] = $nextJsData['businessDetails']['number_of_ownership'] ?? 1;
        $laravelData['s3_start_fee'] = 100; // Default state filing fee
        
        // Step 4: Plan Selection
        $laravelData['s4_plan'] = [
            'plan_name' => $nextJsData['plan']['plan_name'] ?? '',
            'plan_price' => $nextJsData['plan']['plan_price'] ?? 0,
        ];
        
        if (isset($nextJsData['plan']['free_plan_details'])) {
            $laravelData['s4_free_plan_details'] = $nextJsData['plan']['free_plan_details'];
        }
        
        // Step 5: EIN Amount
        $laravelData['s5_en_amount'] = $nextJsData['en_amount'] ?? 0;
        
        // Step 6: Agreement Amount
        $laravelData['s6_agreement_amount'] = $nextJsData['agreement_amount'] ?? 0;
        
        // Step 7: Rush Processing Amount
        $laravelData['s7_rush_processing_amount'] = $nextJsData['rush_processing_amount'] ?? 0;
        
        // Step 8: Agent Information
        if (isset($nextJsData['agent_information'])) {
            $laravelData['s8_agent_information'] = $nextJsData['agent_information'];
        }
        
        // Agent info fields that StoreDataService expects
        $laravelData['agentInfo'] = $nextJsData['agentInfo'] ?? '';
        $laravelData['agentInfoTwo'] = $nextJsData['agentInfoTwo'] ?? '';
        $laravelData['step_5_agent_information'] = $nextJsData['agent_information'] ?? [];
        
        // Step 9: Multi-member info (owners)
        if (isset($nextJsData['businessDetails']['multi_member_info'])) {
            $laravelData['s3_multi_member_info'] = $nextJsData['businessDetails']['multi_member_info'];
        } else {
            // Provide default single member info if not provided
            $laravelData['s3_multi_member_info'] = [
                [
                    'name' => ($nextJsData['userInfo']['first_name'] ?? '') . ' ' . ($nextJsData['userInfo']['last_name'] ?? ''),
                    'email' => $nextJsData['userInfo']['email'] ?? '',
                    'phone' => $nextJsData['userInfo']['phone_number'] ?? '',
                    'ownership_percentage' => 100,
                    'street_address' => '',
                    'city' => '',
                    'state' => '',
                    'zip_code' => '',
                    'country' => ''
                ]
            ];
        }
        
        Log::info('Transformed Laravel data (PayPal):', $laravelData);
        
        return $laravelData;
    }

    /**
     * Get frontend URL based on environment
     */
    private function getFrontendUrl()
    {
        return env('FRONTEND_URL', 'http://localhost:3000');
    }
} 