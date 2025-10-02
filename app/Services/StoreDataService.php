<?php

namespace App\Services;


use App\Models\Company;
use App\Models\Order;
use App\Models\OwnerInfo;
use App\Models\RegisterAgentInformation;
use App\Models\StateFee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StoreDataService
{

    public static function storeData($request)
    {
        $data = $request->localStorageData;

        // Log the incoming data
        Log::info('StoreDataService received data:', $data);

        try {
            $result = DB::transaction(function () use ($data) {
                $userData = $data['s2_stepTowData'];
                
                // Validate email format
                if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
                    throw new \Exception('Invalid email format: ' . $userData['email']);
                }
                
                $password = generateStrongPassword();

                if (Auth::check()) {
                    $user = Auth::user();
                } elseif (isset($data['active_user'])) {
                    $activeUser = User::find($data["active_user"]);
                    if ($activeUser && !$activeUser->hasCompany()) {
                        $user = $activeUser;
                        $user->active = true;
                        $user->save();
                    } else {
                        throw new \Exception('User already has a company or not found');
                    }
                } else {
                    $exestingUser = User::where('email', $userData['email'])->first();
                    if ($exestingUser) {
                        // For testing purposes, allow existing users to proceed
                        // In production, you might want to redirect to login
                        $user = $exestingUser;
                        Log::info('Using existing user for payment:', ['user_id' => $user->id, 'email' => $user->email]);
                    } else {
                        $user = new User();
                        $user->first_name = $userData['first_name'];
                        $user->last_name = $userData['last_name'];
                        $user->email = $userData['email'];
                        $user->phone = $userData['phone_number'];
                        $user->password = Hash::make($password);
                        $user->temp_password = $password;
                        $user->active = true;
                        $user->save();
                    }
                }


                $company = new Company();
                $company->user_id = $user->id;
                $company->company_name = $data['s1_company_name'];
                $company->business_type = $data['s3_business_type'];

                if ($company->business_type == "LLC") {
                    $company->llc_type = $data['s3_business_type_sub'];
                }
                if ($company->business_type == "Corporation") {
                    $company->corporation_type = $data['s3_business_type_sub'];
                }

                $company->type_of_industry = $data['s3_type_of_industry'];
                $company->number_of_ownership = $data['s3_number_of_ownership'];
                $company->package_name = $data['s4_plan']['plan_name'];
                if ($data['s4_plan']['plan_price'] == 0) {
                    $company->plan_street_address = $data['s4_free_plan_details']['street_address'];
                    $company->plan_city = $data['s4_free_plan_details']['step4_city'];
                    $company->plan_state = $data['s4_free_plan_details']['step4_state'];
                    $company->plan_zip_code = $data['s4_free_plan_details']['step4_zip_code'];
                    $company->plan_zip_country = $data['s4_free_plan_details']['step4_country'];
                }
                $company->save();

                $order = new Order;
                $order->company_id = $company->id;
                $order->user_id = $user->id;
                $order->state_name = $data['s3_state_name'];
                $state = StateFee::where('state_name', $data['s3_state_name'])->first();
                $order->state_id = $state ? $state->id : null;

                $order->state_filing_fee = $data['s3_start_fee'];
                $order->package_name = $data['s4_plan']['plan_name'];
                $order->package_amount = $data['s4_plan']['plan_price'];
                $order->renewal_date = Carbon::now()->addYear();

                $order->en_amount = $data['s5_en_amount'];
                if ($order->en_amount > 0) {
                    $order->has_en = 1;
                }
                $order->agreement_amount = $data['s6_agreement_amount'];
                if ($order->agreement_amount > 0) {
                    $order->has_agreement = 1;
                }
                $order->processing_amount = $data['s7_rush_processing_amount'];
                if ($order->processing_amount > 0) {
                    $order->has_processing = 1;
                }
                $order->multimember_fee = $data['s8_multimember_fee'] ?? 0;
                if ($order->multimember_fee > 0) {
                    $order->has_multimember = 1;
                }
                $order->register_agent_type = isset($data['agentInfo']) ? $data['agentInfo'] : '';
                if ($order->register_agent_type == 'own registered agent') {
                    $order->register_agent_infos = isset($data['agentInfoTwo']) ? $data['agentInfoTwo'] : '';
                    $order->agent_information_details = isset($data['step_5_agent_information']) ? json_encode($data['step_5_agent_information']) : null;
                }


                $order->total_amount =
                    $order->state_filing_fee +
                    $order->package_amount +
                    $order->en_amount +
                    $order->agreement_amount +
                    $order->processing_amount +
                    $order->multimember_fee;
                $order->save();

                $company->order_id = $order->order_id;
                $company->total_amount = $order->total_amount;
                $company->save();

                if ($order->register_agent_type == 'own registered agent') {
                    if ($order->register_agent_infos == "Individual") {
                        $infoData = $data['step_5_agent_information'];

                        $regInfo = new RegisterAgentInformation;
                        $regInfo->company_id = $company->id;
                        $regInfo->order_id = $order->id;
                        $regInfo->first_name = $infoData['ind_first_name'];
                        $regInfo->last_name = $infoData['ind_last_name'];
                        $regInfo->street_address = $infoData['ind_street_address'];
                        $regInfo->address_cont = $infoData['ind_address_cont'];
                        $regInfo->city = $infoData['ind_city'];
                        $regInfo->state = $infoData['ind_state'];
                        $regInfo->country = $infoData['ind_country'];
                        $regInfo->zip_code = $infoData['ind_zip_code'];
                        $regInfo->save();
                        $order->update(['register_agent_id' => $regInfo->id]);

                    }
                    if ($order->register_agent_infos == "Company") {
                        $infoData = $data['step_5_agent_information'];
                        $regInfo = new RegisterAgentInformation;
                        $regInfo->company_id = $company->id;
                        $regInfo->order_id = $order->id;
                        $regInfo->first_name = $infoData['com_company_name'];
                        $regInfo->street_address = $infoData['com_street_address'];
                        $regInfo->address_cont = $infoData['com_address_cont'];
                        $regInfo->city = $infoData['com_city'];
                        $regInfo->state = $infoData['com_state'];
                        $regInfo->country = $infoData['com_country'];
                        $regInfo->zip_code = $infoData['com_zip_code'];
                        $regInfo->save();
                        $order->update(['register_agent_id' => $regInfo->id]);
                    }
                }

//                Log::info("Company Order Amount: " . $company->total_amount);

                $memberInfos = $data['s3_multi_member_info'];
                $ownerIds = [];
                foreach ($memberInfos as $memberInfo) {
                    $owner = new OwnerInfo();
                    $owner->company_id = $company->id;
                    $owner->user_id = $user->id;
                    $owner->name = $memberInfo['name'];
                    $owner->email = $memberInfo['email'];
                    $owner->phone = $memberInfo['phone'];
                    $owner->ownership_percentage = $memberInfo['ownership_percentage'];
                    $owner->street_address = $memberInfo['street_address'];
                    $owner->city = $memberInfo['city'];
                    $owner->state = $memberInfo['state'];
                    $owner->zip_code = $memberInfo['zip_code'];
                    $owner->country = $memberInfo['country'];
                    $owner->save();
                    $ownerIds[] = $owner->id;
                }
                // Log successful creation
                Log::info('Company formation successful:', [
                    'user_id' => $user->id,
                    'company_id' => $company->id,
                    'order_id' => $order->id,
                    'total_amount' => $order->total_amount
                ]);

                return [
                    "success" => true,
                    "user_id" => $user->id,
                    "company_id" => $company->id,
                    "order" => $order,
                    "owner_ids" => $ownerIds,
                ];
            });
            return $result;

        } catch (\Exception $e) {
            Log::error('Company formation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                "success" => false,
                "error" => $e->getMessage(),
            ];
        }

        return [
            "success" => false,
            "error" => "Not Execute Anything",
        ];
    }


}
