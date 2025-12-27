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
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use App\Services\PaymentProcessingService;
use App\Services\StoreDataService;
use App\Services\DataTransformationService;

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
            $transformedData = DataTransformationService::transformNextJsToLaravel($request->localStorageData);
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

            // Add Business Address service fee from subscriptions table (service_id = 6)
            $businessAddressSubscription = \App\Models\Subscription::where('order_id', $order->id)
                ->where('service_id', 6)
                ->first();
            if ($businessAddressSubscription && $businessAddressSubscription->service_fee > 0) {
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Business Address Fee',
                        ],
                        'unit_amount' => $businessAddressSubscription->service_fee * 100,
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
            
            // Get logo URL for branding
            $logoUrl = $this->getLogoUrl();
            
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
                    'renewal_fee' => $transformedData['s4_plan']['renewal_fee'] ?? $transformedData['s4_plan']['plan_price'] ?? '0',
                    'registered_agent_service' => isset($transformedData['registered_agent_service']) ? json_encode($transformedData['registered_agent_service']) : null,
                    'ein_service' => isset($transformedData['ein_service']) ? json_encode($transformedData['ein_service']) : null,
                    'operating_agreement_service' => isset($transformedData['operating_agreement_service']) ? json_encode($transformedData['operating_agreement_service']) : null,
                ],
                // Add branding with logo at the top of checkout page
                'custom_text' => [
                    'submit' => [
                        'message' => 'Complete your company formation payment securely.',
                    ],
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
                // Get renewal_fee from session metadata (stored when creating checkout session)
                $renewalFee = isset($session->metadata->renewal_fee) ? (float) $session->metadata->renewal_fee : null;
                
                // Extract services from session metadata
                $services = PaymentProcessingService::extractServicesFromData(null, $session->metadata);
                
                // Process payment completion using PaymentProcessingService
                $paymentData = [
                    'user' => $user,
                    'company' => $company,
                    'order' => $order,
                    'charge_id' => $paymentIntentId,
                    'payment_method' => 'Stripe',
                    'amount' => $paymentIntent->amount / 100,
                    'status' => 'COMPLETED',
                    'card_type' => $paymentMethod->card->brand ?? null,
                    'receipt_url' => $paymentIntent->receipt_url ?? null,
                    'renewal_fee' => $renewalFee, // Pass renewal_fee from frontend plan data (Business Address)
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

    /**
     * Handle Stripe Webhook Events (RECOMMENDED FOR PRODUCTION)
     */
    public function webhook(Request $request)
    {
        try {
            $payload = $request->getContent();
            $sigHeader = $request->header('Stripe-Signature');
            $webhookSecret = env('STRIPE_WEBHOOK_SECRET');

            if (!$webhookSecret) {
                Log::error('Stripe webhook secret not configured');
                return response()->json(['error' => 'Webhook secret not configured'], 500);
            }

            // Verify webhook signature
            try {
                $event = \Stripe\Webhook::constructEvent(
                    $payload,
                    $sigHeader,
                    $webhookSecret
                );
            } catch (\Stripe\Exception\SignatureVerificationException $e) {
                Log::error('Stripe webhook signature verification failed: ' . $e->getMessage());
                return response()->json(['error' => 'Invalid signature'], 400);
            }

            // Handle the event
            switch ($event->type) {
                case 'checkout.session.completed':
                    $session = $event->data->object;
                    $this->handleCheckoutSessionCompleted($session);
                    break;

                case 'payment_intent.succeeded':
                    $paymentIntent = $event->data->object;
                    Log::info('PaymentIntent succeeded: ' . $paymentIntent->id);
                    break;

                case 'payment_intent.payment_failed':
                    $paymentIntent = $event->data->object;
                    $this->handlePaymentFailed($paymentIntent);
                    break;

                default:
                    Log::info('Unhandled Stripe webhook event: ' . $event->type);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Stripe webhook processing failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle successful checkout session
     */
    private function handleCheckoutSessionCompleted($session)
    {
        try {
            $userId = $session->metadata->user_id ?? null;
            $orderId = $session->metadata->order_id ?? null;
            $companyId = $session->metadata->company_id ?? null;

            if (!$userId || !$orderId) {
                Log::error('Missing metadata in checkout session', ['session_id' => $session->id]);
                return;
            }

            Stripe::setApiKey($this->getStripeSecretKey());

            $user = User::find($userId);
            $order = Order::find($orderId);
            
            if (!$user || !$order) {
                Log::error('User or Order not found', ['user_id' => $userId, 'order_id' => $orderId]);
                return;
            }

            $company = $order->company;
            $paymentIntentId = $session->payment_intent;
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            $paymentMethodId = $paymentIntent->payment_method;
            $paymentMethod = PaymentMethod::retrieve($paymentMethodId);

            // Extract services from session metadata
            $services = PaymentProcessingService::extractServicesFromData(null, $session->metadata);
            
            // Process payment completion using PaymentProcessingService
            $paymentData = [
                'user' => $user,
                'company' => $company,
                'order' => $order,
                'charge_id' => $paymentIntentId,
                'payment_method' => 'Stripe',
                'amount' => $paymentIntent->amount / 100,
                'status' => 'COMPLETED',
                'card_type' => $paymentMethod->card->brand ?? 'unknown',
                'receipt_url' => $paymentIntent->receipt_url ?? null,
                'renewal_fee' => isset($session->metadata->renewal_fee) ? (float) $session->metadata->renewal_fee : null,
            ];
            
            // Add services array if services exist
            if (!empty($services)) {
                $paymentData['services'] = $services;
            }
            
            $paymentResult = PaymentProcessingService::processPaymentCompletion($paymentData);

            if (!$paymentResult['success']) {
                throw new \Exception($paymentResult['error'] ?? 'Failed to process payment completion');
            }

            Log::info('Checkout session completed successfully', [
                'session_id' => $session->id,
                'user_id' => $userId,
                'order_id' => $orderId,
                'transition_id' => $paymentResult['transition']->id
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to handle checkout session completed:', [
                'error' => $e->getMessage(),
                'session_id' => $session->id ?? 'unknown'
            ]);
        }
    }

    /**
     * Handle failed payment
     */
    private function handlePaymentFailed($paymentIntent)
    {
        try {
            Log::warning('Payment failed', [
                'payment_intent_id' => $paymentIntent->id,
                'error' => $paymentIntent->last_payment_error->message ?? 'Unknown error'
            ]);

            // You can add cleanup logic here if needed
            
        } catch (\Exception $e) {
            Log::error('Failed to handle payment failure:', [
                'error' => $e->getMessage()
            ]);
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
     * Get Stripe secret key based on environment
     */
    private function getStripeSecretKey()
    {
        // Use live key in production, test key otherwise
        if (env('APP_ENV') === 'production' && env('STRIPE_LIVE_MODE', false)) {
            return env('STRIPE_SECRET'); // Live key
        }
        return env('STRIPE_TEST_SECRET', env('STRIPE_SECRET')); // Test key
    }

    /**
     * Get logo URL for Stripe checkout
     */
    private function getLogoUrl()
    {
        // Construct full URL for the logo
        // Stripe requires a publicly accessible HTTPS URL
        $appUrl = rtrim(env('APP_URL', 'http://localhost:8000'), '/');
        return $appUrl . '/assets/images/logo.png';
    }
} 