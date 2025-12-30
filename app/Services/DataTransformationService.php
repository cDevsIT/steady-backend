<?php

namespace App\Services;

use App\Models\StateFee;
use Illuminate\Support\Facades\Log;

class DataTransformationService
{
    /**
     * Transform Next.js data structure to Laravel expected structure
     * This is a shared method used by all payment controllers
     * 
     * @param array $nextJsData
     * @return array
     */
    public static function transformNextJsToLaravel(array $nextJsData): array
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
            'secondary_phone' => $nextJsData['userInfo']['secondary_phone'] ?? null,
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
            'renewal_fee' => $nextJsData['plan']['renewal_fee'] ?? $nextJsData['plan']['plan_price'] ?? 0,
        ];
        
        // Set free_plan_details if it exists, otherwise try to extract from top-level fields (fallback)
        if (isset($nextJsData['plan']['free_plan_details']) && !empty($nextJsData['plan']['free_plan_details'])) {
            $laravelData['s4_free_plan_details'] = $nextJsData['plan']['free_plan_details'];
        } elseif (isset($nextJsData['plan']['plan_price']) && $nextJsData['plan']['plan_price'] == 0 && 
                   isset($nextJsData['streetAddress']) && isset($nextJsData['city']) && isset($nextJsData['state']) && isset($nextJsData['zipCode'])) {
            // Fallback: Extract from top-level fields if plan is Free and address fields exist
            $laravelData['s4_free_plan_details'] = [
                'street_address' => $nextJsData['streetAddress'] ?? '',
                'step4_city' => $nextJsData['city'] ?? '',
                'step4_state' => $nextJsData['state'] ?? '',
                'step4_zip_code' => $nextJsData['zipCode'] ?? '',
                'step4_country' => $nextJsData['country'] ?? 'USA',
            ];
        } else {
            $laravelData['s4_free_plan_details'] = [];
        }
        
        // Registered Agent Service (service_id = 5)
        if (isset($nextJsData['registeredAgent']) && $nextJsData['registeredAgent']['type'] === 'steady') {
            $laravelData['registered_agent_service'] = [
                'service_id' => $nextJsData['registeredAgent']['service_id'] ?? 5,
                'service_fee' => $nextJsData['registeredAgent']['service_fee'] ?? 0,
                'renewal_fee' => $nextJsData['registeredAgent']['renewal_fee'] ?? 99,
                'service_type' => $nextJsData['registeredAgent']['service_type'] ?? 'yearly',
            ];
        }
        
        // EIN Service (service_id = 4) - One-time service
        if (isset($nextJsData['einService']) && $nextJsData['einService']['service_fee'] > 0) {
            $laravelData['ein_service'] = [
                'service_id' => $nextJsData['einService']['service_id'] ?? 4,
                'service_fee' => $nextJsData['einService']['service_fee'] ?? 0,
                'renewal_fee' => 0,
                'service_type' => $nextJsData['einService']['service_type'] ?? 'one_time',
            ];
        }
        
        // Operating Agreement Service (service_id = 7) - One-time service
        if (isset($nextJsData['operatingAgreementService']) && $nextJsData['operatingAgreementService']['service_fee'] > 0) {
            $laravelData['operating_agreement_service'] = [
                'service_id' => $nextJsData['operatingAgreementService']['service_id'] ?? 7,
                'service_fee' => $nextJsData['operatingAgreementService']['service_fee'] ?? 0,
                'renewal_fee' => 0,
                'service_type' => $nextJsData['operatingAgreementService']['service_type'] ?? 'one_time',
            ];
        }
        
        // Step 5: EIN Amount
        $laravelData['s5_en_amount'] = $nextJsData['en_amount'] ?? 0;
        
        // Step 5: SSN (Social Security Number) for express EIN
        $laravelData['s5_ssn'] = $nextJsData['ssn'] ?? null;
        
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
        $laravelData['step_5_agent_information'] = $nextJsData['step_5_agent_information'] ?? [];
        
        // New format: agent_information from FourthFunnel (when user selects "own registered agent")
        if (isset($nextJsData['agent_information'])) {
            $laravelData['agent_information'] = $nextJsData['agent_information'];
        }
        
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
        
        return $laravelData;
    }
    
    /**
     * Transform Next.js data for Wallet payment (handles slightly different structure)
     * 
     * @param array $nextJsData
     * @return array
     */
    public static function transformNextJsToLaravelForWallet(array $nextJsData): array
    {
        // Use the main transformation method
        $laravelData = self::transformNextJsToLaravel($nextJsData);
        
        // Override wallet-specific fields if they exist in different format
        // Step 5: EIN (Wallet uses different structure - ein.amount instead of en_amount)
        if (isset($nextJsData['ein']['amount'])) {
            $laravelData['s5_en_amount'] = $nextJsData['ein']['amount'] ?? 0;
        }
        
        // Step 6: Operating Agreement (Wallet uses different structure - operatingAgreement.amount instead of agreement_amount)
        if (isset($nextJsData['operatingAgreement']['amount'])) {
            $laravelData['s6_agreement_amount'] = $nextJsData['operatingAgreement']['amount'] ?? 0;
        }
        
        // Step 7: Rush Processing (Wallet uses different structure - rushProcessing.amount instead of rush_processing_amount)
        if (isset($nextJsData['rushProcessing']['amount'])) {
            $laravelData['s7_rush_processing_amount'] = $nextJsData['rushProcessing']['amount'] ?? 0;
        }
        
        // Step 8: Multi-member info (Wallet uses 'owners' instead of 'businessDetails.multi_member_info')
        if (isset($nextJsData['owners'])) {
            $laravelData['s3_multi_member_info'] = $nextJsData['owners'];
        }
        
        // Agent information (Wallet uses step_5_agent_information directly)
        if (isset($nextJsData['step_5_agent_information'])) {
            $laravelData['step_5_agent_information'] = $nextJsData['step_5_agent_information'];
        }
        
        return $laravelData;
    }
}

