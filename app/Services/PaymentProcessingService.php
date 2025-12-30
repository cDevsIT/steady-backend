<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Order;
use App\Models\Service;
use App\Models\Subscription;
use App\Models\Transition;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PaymentProcessingService
{
    /**
     * Extract services array from transformed data or session metadata
     * This centralizes the service extraction logic used by all payment controllers
     * 
     * @param array|null $transformedData Transformed data array (for PayPal/Wallet)
     * @param object|null $sessionMetadata Stripe session metadata object (for Stripe)
     * @return array Array of service data
     */
    public static function extractServicesFromData(?array $transformedData = null, ?object $sessionMetadata = null): array
    {
        $services = [];
        
        // Extract from transformed data (PayPal/Wallet)
        if ($transformedData !== null) {
            if (isset($transformedData['registered_agent_service'])) {
                $services[] = $transformedData['registered_agent_service'];
            }
            if (isset($transformedData['ein_service'])) {
                $services[] = $transformedData['ein_service'];
            }
            if (isset($transformedData['operating_agreement_service'])) {
                $services[] = $transformedData['operating_agreement_service'];
            }
        }
        
        // Extract from Stripe session metadata
        if ($sessionMetadata !== null) {
            if (isset($sessionMetadata->registered_agent_service)) {
                $registeredAgentService = json_decode($sessionMetadata->registered_agent_service, true);
                if ($registeredAgentService) {
                    $services[] = $registeredAgentService;
                }
            }
            if (isset($sessionMetadata->ein_service)) {
                $einService = json_decode($sessionMetadata->ein_service, true);
                if ($einService) {
                    $services[] = $einService;
                }
            }
            if (isset($sessionMetadata->operating_agreement_service)) {
                $operatingAgreementService = json_decode($sessionMetadata->operating_agreement_service, true);
                if ($operatingAgreementService) {
                    $services[] = $operatingAgreementService;
                }
            }
        }
        
        return $services;
    }
    
    /**
     * Process payment completion for all payment methods
     * 
     * @param array $paymentData
     * @return array
     */
    public static function processPaymentCompletion(array $paymentData): array
    {
        try {
            $user = $paymentData['user'] ?? null;
            $company = $paymentData['company'] ?? null;
            $order = $paymentData['order'] ?? null;
            $chargeId = $paymentData['charge_id'] ?? null;
            $paymentMethod = $paymentData['payment_method'] ?? 'Unknown';
            $amount = $paymentData['amount'] ?? 0;
            $status = $paymentData['status'] ?? 'COMPLETED';
            $cardType = $paymentData['card_type'] ?? null;
            $receiptUrl = $paymentData['receipt_url'] ?? null;
            $playerName = $paymentData['player_name'] ?? null;

            // Validate required data
            if (!$user || !$company || !$order || !$chargeId) {
                throw new \Exception('Missing required payment data: user, company, order, or charge_id');
            }

            // Generate player name if not provided
            if (!$playerName) {
                $playerName = $user->first_name . ' ' . $user->last_name;
            }

            // Create transition record
            $transition = new Transition();
            $transition->company_id = $company->id;
            $transition->user_id = $user->id;
            $transition->charge_id = $chargeId;
            $transition->status = $status;
            $transition->payment_method = $paymentMethod;
            $transition->card_type = $cardType;
            $transition->amount = $amount;
            $transition->player_name = $playerName;
            $transition->receipt_url = $receiptUrl;
            $transition->save();

            // Update company with transition_id
            $company->transition_id = $transition->id;
            $company->save();

            // Update order with transition_id and payment_status
            $order->transition_id = $transition->id;
            // Normalize payment status: COMPLETED -> paid, otherwise use lowercase status
            $order->payment_status = ($status === 'COMPLETED') ? 'paid' : strtolower($status);
            $order->save();

            // Process subscriptions dynamically from services data or extract from order/company
            $services = $paymentData['services'] ?? null;
            
            // Always check for Business Address service (service_id = 6) from order/company for backward compatibility
            // This handles Business Address service from the funnel
            if ($order->package_amount > 0 || $company->package_name) {
                $serviceId = self::extractServiceIdFromOrder($order, $company);
                if ($serviceId) {
                    $planName = $company->package_name;
                    $planPrice = $order->package_amount ?? 0;
                    $serviceType = self::mapPlanNameToServiceType($planName);
                    
                    // Get renewal_fee from paymentData first, then fallback to service default
                    $renewalFee = $paymentData['renewal_fee'] ?? null;
                    if ($renewalFee === null) {
                        $renewalFee = self::extractRenewalFeeFromOrder($order, $company, $serviceId);
                    }
                    
                    self::createOrUpdateSubscription(
                        $order,
                        $user,
                        $transition,
                        $serviceId,
                        $planPrice,
                        $serviceType,
                        $planName,
                        $renewalFee,
                        $company
                    );
                }
            }
            
            // Additionally, process any services from the services array (e.g., Registered Agent service_id = 5)
            if ($services && is_array($services)) {
                Log::info('Processing services array:', ['services' => $services]);
                foreach ($services as $serviceData) {
                    Log::info('Creating subscription for service:', ['service_data' => $serviceData]);
                    self::createOrUpdateSubscription(
                        $order,
                        $user,
                        $transition,
                        $serviceData['service_id'] ?? null,
                        $serviceData['service_fee'] ?? 0,
                        $serviceData['service_type'] ?? 'yearly',
                        $serviceData['plan_name'] ?? null,
                        $serviceData['renewal_fee'] ?? null,
                        $company
                    );
                }
            } else {
                Log::info('No services array provided in paymentData');
            }

            // Update all subscriptions associated with this order with transition_id
            $allSubscriptions = Subscription::where('order_id', $order->id)->get();
            foreach ($allSubscriptions as $subscription) {
                if (!$subscription->transition_id) {
                    $subscription->transition_id = $transition->id;
                    $subscription->save();
                }
            }

            // Generate temporary login token
            $tempToken = Str::random(32);
            $user->temp_login_token = $tempToken;
            $user->temp_token_expires_at = now()->addMinutes(30); // Token expires in 30 minutes
            $user->save();

            // Send registration email
            self::sendRegistrationEmail($user);

            Log::info('Payment processed successfully:', [
                'user_id' => $user->id,
                'company_id' => $company->id,
                'order_id' => $order->id,
                'transition_id' => $transition->id,
                'payment_method' => $paymentMethod,
                'amount' => $amount
            ]);

            return [
                'success' => true,
                'transition' => $transition,
                'temp_token' => $tempToken,
                'user_id' => $user->id,
                'company_id' => $company->id,
                'order_id' => $order->id,
            ];

        } catch (\Exception $e) {
            Log::error('Payment processing failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payment_data' => $paymentData
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Create or update subscription for a service
     * 
     * @param Order $order
     * @param User $user
     * @param Transition $transition
     * @param int|null $serviceId
     * @param float $serviceFee
     * @param string $serviceType
     * @param string|null $planName
     * @param float|null $renewalFee
     * @return Subscription|null
     */
    private static function createOrUpdateSubscription(
        Order $order,
        User $user,
        Transition $transition,
        ?int $serviceId,
        float $serviceFee,
        string $serviceType,
        ?string $planName = null,
        ?float $renewalFee = null,
        ?Company $company = null
    ): ?Subscription {
        if (!$serviceId) {
            return null;
        }

        // Check if subscription already exists for this order and service
        $subscription = Subscription::where('order_id', $order->id)
            ->where('service_id', $serviceId)
            ->first();

        if (!$subscription) {
            // Create new subscription
            $orderDate = Carbon::now();
            $renewalDate = self::calculateRenewalDate($serviceType, $orderDate, $serviceId);
            
            // Use renewal_fee from parameter if provided, otherwise get from Service model as fallback
            if ($renewalFee === null) {
                $service = Service::find($serviceId);
                $renewalFee = $service ? $service->renewal_fee : 0;
            }
            
            // For one-time services (like EIN service_id = 4, Operating Agreement service_id = 7), force renewal_fee to 0 and set service_type
            if ($serviceId === 4 || $serviceId === 7) {
                $renewalFee = 0;
                $serviceType = 'one_time'; // Ensure one-time services use the correct service_type
            }

            // If service_type is not provided, try to map from plan_name
            if ($serviceType === 'yearly' && $planName) {
                $serviceType = self::mapPlanNameToServiceType($planName);
                $renewalDate = self::calculateRenewalDate($serviceType, $orderDate, $serviceId);
            }
            
            // If service_type is 'one_time', ensure renewal_date is null
            if ($serviceType === 'one_time') {
                $renewalDate = null;
            }

            $subscription = new Subscription();
            $subscription->service_id = $serviceId;
            $subscription->order_id = $order->id;
            $subscription->company_id = $company ? $company->id : $order->company_id;
            $subscription->user_id = $user->id;
            $subscription->transition_id = $transition->id;
            $subscription->order_date = $orderDate;
            $subscription->renewal_date = $renewalDate;
            $subscription->service_type = $serviceType;
            $subscription->service_fee = $serviceFee;
            $subscription->renewal_fee = $renewalFee;
            $subscription->save();

            Log::info('Subscription created:', [
                'subscription_id' => $subscription->id,
                'service_id' => $serviceId,
                'order_id' => $order->id,
                'service_type' => $serviceType,
                'service_fee' => $serviceFee,
                'renewal_fee' => $renewalFee
            ]);
        } else {
            // Update existing subscription with transition_id if not set
            if (!$subscription->transition_id) {
                $subscription->transition_id = $transition->id;
                $subscription->save();
            }
        }

        return $subscription;
    }

    /**
     * Extract service_id from order/company data (backward compatibility)
     * 
     * @param Order $order
     * @param Company $company
     * @return int|null
     */
    private static function extractServiceIdFromOrder(Order $order, Company $company): ?int
    {
        // Default to Business Address service (service_id = 6) if package_name/package_amount exists
        // This is for backward compatibility with the funnel
        if ($order->package_amount > 0 || $company->package_name) {
            return 6; // Business Address service
        }

        return null;
    }

    /**
     * Extract renewal_fee from order/company or paymentData
     * 
     * @param Order $order
     * @param Company $company
     * @param int $serviceId
     * @return float
     */
    private static function extractRenewalFeeFromOrder(Order $order, Company $company, int $serviceId): float
    {
        // First try to get renewal_fee from order (stored when order is created)
        if (isset($order->package_renewal_fee) && $order->package_renewal_fee !== null) {
            return (float) $order->package_renewal_fee;
        }
        
        // Fallback to Service model if not stored in order
        $service = Service::find($serviceId);
        return $service ? (float) $service->renewal_fee : 0;
    }

    /**
     * Map plan name to service_type
     * 
     * @param string|null $planName
     * @return string
     */
    private static function mapPlanNameToServiceType(?string $planName): string
    {
        if ($planName === 'Free') {
            return 'free';
        } elseif ($planName === 'Half-Yearly') {
            return 'half_yearly';
        } elseif ($planName === 'Yearly') {
            return 'yearly';
        }

        return 'yearly'; // default
    }

    /**
     * Calculate renewal_date based on service_type and service_id
     * For one-time services (like EIN service_id = 4, Operating Agreement service_id = 7), return null
     * 
     * @param string $serviceType
     * @param Carbon $orderDate
     * @param int|null $serviceId Optional service_id to check if it's a one-time service
     * @return Carbon|null
     */
    private static function calculateRenewalDate(string $serviceType, Carbon $orderDate, ?int $serviceId = null): ?Carbon
    {
        // One-time services don't have renewal_date (e.g., EIN service_id = 4, Operating Agreement service_id = 7)
        if ($serviceId === 4 || $serviceId === 7 || $serviceType === 'one_time') {
            return null;
        }
        
        if ($serviceType === 'half_yearly') {
            return $orderDate->copy()->addMonths(6);
        } elseif ($serviceType === 'yearly') {
            return $orderDate->copy()->addYear();
        }

        // free plans don't have renewal_date
        return null;
    }

    /**
     * Send registration email to user
     * 
     * @param User $user
     * @return void
     */
    private static function sendRegistrationEmail(User $user): void
    {
        try {
            $to = $user->email;
            $subject = "Steady Formation Access";
            $password = $user->temp_password;

            Mail::send('email_templates.registration', compact('user', 'password'), function ($message) use ($subject, $to) {
                $message->from('noreply@funnel.com', env('APP_NAME', 'Steady Formation Access'));
                $message->to($to);
                $message->subject($subject);
            });

            Log::info('Registration email sent:', ['user_id' => $user->id, 'email' => $to]);
        } catch (\Exception $e) {
            Log::error('Failed to send registration email:', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            // Don't throw exception - email failure shouldn't break payment processing
        }
    }
}

