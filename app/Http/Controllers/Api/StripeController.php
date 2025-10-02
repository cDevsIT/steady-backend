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
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use App\Services\StoreDataService;

class StripeController extends Controller
{
    public function createCheckoutSession(Request $request): JsonResponse
    {
        try {
            // Check if Stripe is configured
            if (!$this->getStripeSecretKey()) {
                Log::error('Stripe secret key not configured');
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

            $order = $result['order'];
            $user = User::find($result['user_id']);
            $company = Company::find($result['company_id']);

            // Create line items for Stripe
            $line_items = [];
            
            // Add State Filing Fee
            if ($order->state_filing_fee) {
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'State Filing Fee',
                        ],
                        'unit_amount' => $order->state_filing_fee * 100,
                    ],
                    'quantity' => 1,
                ];
            }

            // Add Package Amount
            if ($order->package_amount) {
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Business Address Fee',
                        ],
                        'unit_amount' => $order->package_amount * 100,
                    ],
                    'quantity' => 1,
                ];
            }

            // Add EN Amount
            if ($order->en_amount) {
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'EIN Upgrade',
                        ],
                        'unit_amount' => $order->en_amount * 100,
                    ],
                    'quantity' => 1,
                ];
            }

            // Add Agreement Amount
            if ($order->agreement_amount) {
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Agreements',
                        ],
                        'unit_amount' => $order->agreement_amount * 100,
                    ],
                    'quantity' => 1,
                ];
            }

            // Add Processing Amount
            if ($order->processing_amount) {
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Rush Processing',
                        ],
                        'unit_amount' => $order->processing_amount * 100,
                    ],
                    'quantity' => 1,
                ];
            }

            // Add Multimember Fee
            if ($order->multimember_fee) {
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Multimember Fee',
                        ],
                        'unit_amount' => $order->multimember_fee * 100,
                    ],
                    'quantity' => 1,
                ];
            }

            Stripe::setApiKey($this->getStripeSecretKey());
            
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => $this->getApiUrl() . '/payments/stripe/success?session_id={CHECKOUT_SESSION_ID}&user_id=' . $result['user_id'] . '&order_id=' . $order->id,
                'cancel_url' => $this->getApiUrl() . '/payments/stripe/cancel?session_id={CHECKOUT_SESSION_ID}&user_id=' . $result['user_id'] . '&order_id=' . $order->id,
                'metadata' => [
                    'user_id' => $result['user_id'],
                    'company_id' => $result['company_id'],
                    'order_id' => $order->id,
                ],
            ]);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'session_id' => $checkout_session->id,
                    'checkout_url' => $checkout_session->url,
                    'user_id' => $result['user_id'],
                    'company_id' => $result['company_id'],
                    'order_id' => $order->id,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Stripe checkout session creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create checkout session: ' . $e->getMessage()
            ], 500);
        }
    }

    private function transformDataForLaravel($nextJsData)
    {
        Log::info('Transforming Next.js data to Laravel format:', $nextJsData);
        
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
        
        // Get dynamic state fee from database
        $stateName = $nextJsData['businessDetails']['stateName'] ?? '';
        $stateFee = StateFee::where('state_name', $stateName)->first();
        $laravelData['s3_start_fee'] = $stateFee ? $stateFee->fees : 100; // Use dynamic fee or fallback to 100
        
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
        
        // Step 8: Multimember Fee
        $laravelData['s8_multimember_fee'] = $nextJsData['multimemberFee'] ?? 0;
        
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
        
        Log::info('Transformed Laravel data:', $laravelData);
        
        return $laravelData;
    }

    public function success(Request $request)
    {
        try {
            $sessionId = $request->query('session_id');
            $userId = $request->query('user_id');
            $orderId = $request->query('order_id');

            if (!$sessionId || !$userId || !$orderId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Missing required parameters'
                ], 400);
            }

            Stripe::setApiKey($this->getStripeSecretKey());

            // Retrieve the session
            $session = Session::retrieve($sessionId);
            $paymentIntentId = $session->payment_intent;
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            $paymentMethodId = $paymentIntent->payment_method;
            $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
            $paymentStatus = $paymentIntent->status;

            $user = User::find($userId);
            $order = Order::find($orderId);
            $company = $order->company;

            if ($paymentStatus === 'succeeded') {
                // Create transaction record
                $transaction = new Transition();
                $transaction->company_id = $company->id;
                $transaction->user_id = $user->id;
                $transaction->charge_id = $paymentIntentId;
                $transaction->status = 'COMPLETED';
                $transaction->payment_method = 'Stripe';
                $transaction->receipt_url = $paymentIntent->receipt_url;
                $transaction->card_type = $paymentMethod->card->brand;
                $transaction->amount = $paymentIntent->amount / 100;
                $transaction->player_name = $user->first_name . ' ' . $user->last_name;
                $transaction->save();

                // Update company and order
                $company->transition_id = $transaction->id;
                $company->save();

                $order->transition_id = $transaction->id;
                $order->payment_status = $transaction->status;
                $order->save();

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

                // Redirect to setup-company page with success parameters and temp token
                return redirect($this->getFrontendUrl() . '/setup-company?payment=success&session_id=' . $sessionId . '&user_id=' . $userId . '&order_id=' . $orderId . '&temp_login_token=' . $tempToken);
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

                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment failed. Status: ' . $paymentStatus
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Stripe payment success processing failed:', [
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
            $userId = $request->query('user_id');
            $orderId = $request->query('order_id');

            if ($userId && $orderId) {
                $user = User::find($userId);
                $order = Order::find($orderId);
                
                if ($order && $order->company) {
                    $company = $order->company;
                    
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
            }

            // Redirect to frontend cancel page
            return redirect($this->getFrontendUrl() . '/setup-company?payment=cancel');

        } catch (\Exception $e) {
            Log::error('Stripe payment cancel processing failed:', [
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

    /**
     * Get API URL based on environment
     */
    private function getApiUrl()
    {
        return env('APP_URL', 'http://localhost:8000') . '/api';
    }

    /**
     * Get Stripe secret key - force test mode in production
     */
    private function getStripeSecretKey()
    {
        // Force test mode in production - use test keys
        return env('STRIPE_TEST_SECRET', env('STRIPE_SECRET'));
    }
} 