<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\Company;
use App\Models\Order;
use App\Models\Transition;
use App\Models\StateFee;
use App\Services\StoreDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
            $transformedData = $this->transformDataForStorage($companyData);
            
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

            // Create transition record (following StripeController pattern)
            $transition = new Transition();
            $transition->company_id = $company->id;
            $transition->user_id = $user->id;
            $transition->charge_id = $transactionReference;
            $transition->status = 'COMPLETED';
            $transition->payment_method = 'Wallet';
            $transition->card_type = null;
            $transition->amount = $amount;
            $transition->player_name = $user->first_name . ' ' . $user->last_name;
            $transition->save();

            // Update company and order with transition_id
            $company->transition_id = $transition->id;
            $company->save();

            $order->transition_id = $transition->id;
            $order->payment_status = 'paid';
            $order->save();

            // Generate temporary login token (same as Stripe)
            $tempToken = \Illuminate\Support\Str::random(32);
            $user->temp_login_token = $tempToken;
            $user->temp_token_expires_at = now()->addMinutes(30); // Token expires in 30 minutes
            $user->save();

            // Send email (same as Stripe)
            $to = $user->email;
            $subject = "Steady Formation Access";
            $password = $user->temp_password;

            Mail::send('email_templates.registration', compact('user', 'password'), function ($message) use ($subject, $to) {
                $message->from('noreply@funnel.com', env('APP_NAME', 'Steady Formation Access'));
                $message->to($to);
                $message->subject($subject);
            });

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

    /**
     * Transform Next.js data format to Laravel StoreDataService format
     */
    private function transformDataForStorage($nextJsData)
    {
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
        
        // Mark as authenticated user if logged in
        if (auth()->check()) {
            $laravelData['active_user'] = auth()->id();
        }
        
        // Step 3: Business Details
        $laravelData['s3_business_type'] = $nextJsData['businessType'] ?? '';
        $laravelData['s3_business_type_sub'] = $nextJsData['businessDetails']['llcType'] ?? '';
        $laravelData['s3_type_of_industry'] = $nextJsData['businessDetails']['industryType'] ?? '';
        $laravelData['s3_state_name'] = $nextJsData['businessDetails']['stateName'] ?? '';
        $laravelData['s3_number_of_ownership'] = $nextJsData['businessDetails']['number_of_ownership'] ?? 1;
        
        // Get dynamic state fee from database
        $stateName = $nextJsData['businessDetails']['stateName'] ?? '';
        $stateFee = StateFee::where('state_name', $stateName)->first();
        $laravelData['s3_start_fee'] = $stateFee ? $stateFee->fees : 100;
        
        // Step 4: Plan Selection
        $laravelData['s4_plan'] = [
            'plan_name' => $nextJsData['plan']['plan_name'] ?? '',
            'plan_price' => $nextJsData['plan']['plan_price'] ?? 0,
        ];
        
        if (isset($nextJsData['plan']['free_plan_details'])) {
            $laravelData['s4_free_plan_details'] = $nextJsData['plan']['free_plan_details'];
        }
        
        // Step 5: EIN
        $laravelData['s5_en_amount'] = $nextJsData['ein']['amount'] ?? 0;
        
        // Step 6: Operating Agreement
        $laravelData['s6_agreement_amount'] = $nextJsData['operatingAgreement']['amount'] ?? 0;
        
        // Step 7: Rush Processing
        $laravelData['s7_rush_processing_amount'] = $nextJsData['rushProcessing']['amount'] ?? 0;
        
        // Step 8: Multi-member info
        $laravelData['s8_multimember_fee'] = $nextJsData['multimemberFee'] ?? 0;
        $laravelData['s3_multi_member_info'] = $nextJsData['owners'] ?? [
            [
                'name' => ($nextJsData['userInfo']['first_name'] ?? '') . ' ' . ($nextJsData['userInfo']['last_name'] ?? ''),
                'email' => $nextJsData['userInfo']['email'] ?? '',
                'phone' => $nextJsData['userInfo']['phone_number'] ?? '',
                'ownership_percentage' => 100,
                'street_address' => '',
                'city' => '',
                'state' => '',
                'zip_code' => '',
                'country' => '',
            ]
        ];
        
        // Agent information
        $laravelData['agentInfo'] = $nextJsData['agentInfo'] ?? '';
        $laravelData['agentInfoTwo'] = $nextJsData['agentInfoTwo'] ?? '';
        $laravelData['step_5_agent_information'] = $nextJsData['step_5_agent_information'] ?? null;
        
        return $laravelData;
    }
}

