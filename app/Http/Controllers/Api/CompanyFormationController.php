<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StoreDataService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CompanyFormationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            // Validate the request
            $request->validate([
                'localStorageData' => 'required|array',
                'localStorageData.businessType' => 'required|string',
                'localStorageData.companyName' => 'required|string',
                'localStorageData.userInfo' => 'required|array',
                'localStorageData.userInfo.first_name' => 'required|string',
                'localStorageData.userInfo.last_name' => 'required|string',
                'localStorageData.userInfo.email' => 'required|email',
                'localStorageData.userInfo.phone_number' => 'required|string',
                'localStorageData.businessDetails' => 'required|array',
                'localStorageData.businessDetails.stateName' => 'required|string',
                'localStorageData.businessDetails.industryType' => 'required|string',
                'localStorageData.plan' => 'required|array',
                'localStorageData.plan.plan_name' => 'required|string',
                'localStorageData.plan.plan_price' => 'required|numeric',
            ]);

            // Transform the data to match StoreDataService expectations
            $localStorageData = $request->input('localStorageData');
            
            // Calculate state fee
            $stateFee = 0;
            if (isset($localStorageData['businessDetails']['stateName'])) {
                $state = \App\Models\StateFee::where('state_name', $localStorageData['businessDetails']['stateName'])->first();
                $stateFee = $state ? $state->fees : 0;
            }
            
            $transformedData = [
                's1_company_name' => $localStorageData['companyName'],
                's2_stepTowData' => [
                    'first_name' => $localStorageData['userInfo']['first_name'],
                    'last_name' => $localStorageData['userInfo']['last_name'],
                    'email' => $localStorageData['userInfo']['email'],
                    'phone_number' => $localStorageData['userInfo']['phone_number'],
                ],
                's3_business_type' => $localStorageData['businessType'],
                's3_business_type_sub' => $localStorageData['businessDetails']['llcType'] ?? '',
                's3_type_of_industry' => $localStorageData['businessDetails']['industryType'],
                's3_state_name' => $localStorageData['businessDetails']['stateName'],
                's3_number_of_ownership' => $localStorageData['businessDetails']['number_of_ownership'] ?? 1,
                's3_multi_member_info' => $localStorageData['businessDetails']['multi_member_info'] ?? [],
                's3_start_fee' => $stateFee,
                's4_plan' => [
                    'plan_name' => $localStorageData['plan']['plan_name'],
                    'plan_price' => $localStorageData['plan']['plan_price'],
                ],
                's4_free_plan_details' => $localStorageData['plan']['free_plan_details'] ?? [],
                's5_en_amount' => $localStorageData['en_amount'] ?? 0,
                's6_agreement_amount' => $localStorageData['agreement_amount'] ?? 0,
                's7_rush_processing_amount' => $localStorageData['rush_processing_amount'] ?? 0,
                'agentInfo' => $localStorageData['agentInfo'] ?? '',
                'agentInfoTwo' => $localStorageData['agentInfoTwo'] ?? '',
                'step_5_agent_information' => $localStorageData['agent_information'] ?? [],
            ];

            // Create a new request with transformed data
            $transformedRequest = new \Illuminate\Http\Request();
            $transformedRequest->merge(['localStorageData' => $transformedData]);

            // Log the transformed data for debugging
            \Log::info('Company Formation Data:', [
                'original_data' => $localStorageData,
                'transformed_data' => $transformedData,
                'state_fee' => $stateFee
            ]);

            // Use the existing StoreDataService
            $result = StoreDataService::storeData($transformedRequest);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => 'Company formation data stored successfully',
                    'data' => [
                        'user_id' => $result['user_id'],
                        'company_id' => $result['company_id'],
                        'order_id' => $result['order']->order_id ?? null,
                        'total_amount' => $result['order']->total_amount ?? 0,
                    ]
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to store company formation data',
                    'error' => $result['error']
                ], 400);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 