<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\Company;
use App\Models\Order;
use App\Models\Transition;
use App\Models\StateFee;
use App\Services\PaymentProcessingService;
use App\Services\StoreDataService;
use App\Services\DataTransformationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WalletController extends Controller
{
    /**
     * Get user's wallet balance
     */
    public function getBalance(Request $request)
    {
        try {
            $user = Auth::guard('sanctum')->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated',
                    'balance' => 0
                ], 401);
            }

            $wallet = Wallet::where('user_id', $user->id)
                ->where('status', 'Active')
                ->first();

            if (!$wallet) {
                return response()->json([
                    'success' => true,
                    'balance' => 0,
                    'currency' => 'USD',
                    'wallet_exists' => false
                ]);
            }

            return response()->json([
                'success' => true,
                'balance' => (float) $wallet->balance,
                'currency' => $wallet->currency,
                'wallet_exists' => true,
                'wallet_type' => $wallet->type,
                'status' => $wallet->status
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching wallet balance',
                'error' => $e->getMessage(),
                'balance' => 0
            ], 500);
        }
    }

    /**
     * Process payment using wallet balance
     */
    public function processWalletPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'company_data' => 'required|array',
        ]);

        DB::beginTransaction();
        
        try {
            $user = Auth::guard('sanctum')->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $wallet = Wallet::where('user_id', $user->id)
                ->where('status', 'Active')
                ->lockForUpdate()
                ->first();

            if (!$wallet) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'No active wallet found'
                ], 404);
            }

            $amount = $request->input('amount');

            // Check if wallet is frozen
            if ($wallet->status === 'Frozen') {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Your wallet is currently frozen. Please contact support.'
                ], 403);
            }

            // Check if sufficient balance
            if ($wallet->balance < $amount) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient wallet balance',
                    'available_balance' => (float) $wallet->balance,
                    'required_amount' => (float) $amount
                ], 400);
            }

            // Transform company data to match StoreDataService format
            $companyData = $request->input('company_data');
            $transformedData = DataTransformationService::transformNextJsToLaravelForWallet($companyData);
            
            // Create a new request for StoreDataService
            $storeRequest = new Request();
            $storeRequest->merge(['localStorageData' => $transformedData]);
            
            // Use StoreDataService to create company and order
            $result = StoreDataService::storeData($storeRequest);
            
            if (!$result['success']) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create company and order',
                    'error' => $result['error'] ?? 'Unknown error'
                ], 400);
            }

            $company = Company::find($result['company_id']);
            $order = $result['order'];

            // Deduct from wallet
            $balanceBefore = $wallet->balance;
            $wallet->balance -= $amount;
            $wallet->last_activity_at = now();
            $wallet->save();

            // Create wallet transaction first
            $transactionReference = 'WLT-' . strtoupper(uniqid());
            $walletTransaction = $wallet->transactions()->create([
                'type' => 'Withdrawal',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $wallet->balance,
                'status' => 'Completed',
                'reference' => $transactionReference,
                'description' => 'Payment for company formation: ' . ($company->company_name ?? 'N/A'),
                'created_by' => $user->id,
            ]);

            // Extract services from transformed data
            $services = PaymentProcessingService::extractServicesFromData($transformedData);

            // Process payment completion using PaymentProcessingService
            $paymentData = [
                'user' => $user,
                'company' => $company,
                'order' => $order,
                'charge_id' => $transactionReference,
                'payment_method' => 'Wallet',
                'amount' => $amount,
                'status' => 'COMPLETED',
                'card_type' => null,
                'receipt_url' => null,
            ];
            
            // Add services array if services exist
            if (!empty($services)) {
                $paymentData['services'] = $services;
            }
            
            $paymentResult = PaymentProcessingService::processPaymentCompletion($paymentData);

            if (!$paymentResult['success']) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to process payment completion',
                    'error' => $paymentResult['error'] ?? 'Unknown error'
                ], 500);
            }

            $tempToken = $paymentResult['temp_token'];

            DB::commit();

            Log::info('Wallet payment processed successfully:', [
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'transaction_id' => $transactionReference,
                'amount' => $amount,
                'remaining_balance' => $wallet->balance
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment processed successfully',
                'data' => [
                    'transaction_id' => $transactionReference,
                    'company_id' => $company->id,
                    'order_id' => $order->id,
                    'amount_paid' => (float) $amount,
                    'remaining_balance' => (float) $wallet->balance,
                    'temp_login_token' => $tempToken,
                    'user_id' => $user->id,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Wallet payment failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error processing wallet payment',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

