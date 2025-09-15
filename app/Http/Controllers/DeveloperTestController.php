<?php

namespace App\Http\Controllers;

use App\Jobs\RegistrationEmail;
use App\Models\Company;
use App\Models\Order;
use App\Models\OwnerInfo;
use App\Models\User;
use App\Services\StoreDataService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class DeveloperTestController extends Controller
{
    public function test(Request $request)
    {

        DB::table('companies')->get()->each(function($customer) {
            $createdAtUTC = Carbon::parse($customer->created_at, 'Asia/Dhaka')->setTimezone('UTC');
            $updatedAtUTC = Carbon::parse($customer->updated_at, 'Asia/Dhaka')->setTimezone('UTC');

            DB::table('companies')->where('id', $customer->id)->update([
                'created_at' => $createdAtUTC,
                'updated_at' => $updatedAtUTC,
            ]);
        });

        die;
        $renewalDate = '2024-08-19'; // This should be in 'YYYY-MM-DD' format

        $renewalDate = Carbon::parse($renewalDate);

        $currentDate = Carbon::now();

        if ($currentDate->greaterThan($renewalDate)) {
            // Current date is greater than or equal to the renewal date
            echo "Expired";
        } else {
            // Current date is before the renewal date
            echo "The renewal date is in the future.";
        }


        die;
        $order = Order::find(14);
        $renewDate = Carbon::parse($order->renewal_date);

        if ($renewDate->lessThanOrEqualTo(Carbon::today())) {
            dd("yes");
        }
        dd("No");


        $data = $request->localStorageData;
        try {
            $result = DB::transaction(function () use ($data) {
                $userData = $data['s2_stepTowData'];
                $password = $this->generateStrongPassword();

                $exestingUser = User::where('emails', $userData['emails'])->first();
                if ($exestingUser) {
                    throw new \Exception('Email Already Exists');
                }

                $user = new User();
                $user->first_name = $userData['first_name'];
                $user->last_name = $userData['last_name'];
                $user->email = $userData['emails'];
                $user->phone = $userData['phone_number'];
                $user->password = Hash::make($password);
                $user->save();

                $company = new Company();
                $company->user_id = $user->id;
                $company->company_name = $data['s1_company_name'];
                $company->business_type = $data['s3_business_type'];
                $company->type_of_industry = $data['s3_type_of_industry'];
                $company->number_of_ownership = $data['s3_number_of_ownership'];
                $company->state_name = $data['s3_state_name'];
                $company->state_filing_fee = $data['s3_start_fee'];
                $company->package_name = $data['s4_plan']['plan_name'];
                $company->package_amount = $data['s4_plan']['plan_price'];
                if ($company->package_amount == 0) {
                    $company->plan_street_address = $data['s4_free_plan_details']['street_address'];
                    $company->plan_city = $data['s4_free_plan_details']['step4_city'];
                    $company->plan_state = $data['s4_free_plan_details']['step4_state'];
                    $company->plan_zip_code = $data['s4_free_plan_details']['step4_zip_code'];
                    $company->plan_zip_code = $data['s4_free_plan_details']['step4_country'];
                }
                $company->en_amount = $data['s5_en_amount'];
                if ($company->en_amount > 0) {
                    $company->has_en = 1;
                }
                $company->en_agreement_amount = $data['s6_agreement_amount'];
                if ($company->en_agreement_amount > 0) {
                    $company->has_agreement = 1;
                }
                $company->en_processing_amount = $data['s7_rush_processing_amount'];
                if ($company->en_processing_amount > 0) {
                    $company->has_processing = 1;
                }
                $company->save();

                $memberInfos = $data['s3_multi_member_info'];
                foreach ($memberInfos as $memberInfo) {
                    $owner = new OwnerInfo();
                    $owner->company_id = $company->id;
                    $owner->user_id = $user->id;
                    $owner->name = $memberInfo['name'];
                    $owner->email = $memberInfo['emails'];
                    $owner->phone = $memberInfo['phone'];
                    $owner->ownership_percentage = $memberInfo['ownership_percentage'];
                    $owner->street_address = $memberInfo['street_address'];
                    $owner->city = $memberInfo['city'];
                    $owner->state = $memberInfo['state'];
                    $owner->zip_code = $memberInfo['zip_code'];
                    $owner->country = $memberInfo['country'];
                    $owner->save();
                }

                $to = $user->email;
                $subject = env("APP_NAME", 'Your Application');
                Mail::send('email_templates.registration', compact('user', 'password'), function ($message) use ($subject, $to) {
                    $message->from('noreply@funnel.com', env('APP_NAME', 'Your Application'));
                    $message->to($to); // $to
                    $message->subject($subject);
                });


                return [
                    "success" => true,
                    "user_id" => $user->id,
                    "company_id" => $company->id,
                ];
            });
            return $result;


        } catch (\Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage(),
            ];
        }
    }


    function generateStrongPassword($length = 10)
    {
        $upperCase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowerCase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialCharacters = '!@#$%^&*()-_=+[]{}|;:,.<>?';
        $password = '';
        $password .= $upperCase[rand(0, strlen($upperCase) - 1)];
        $password .= $lowerCase[rand(0, strlen($lowerCase) - 1)];
        $password .= $numbers[rand(0, strlen($numbers) - 1)];
        $password .= $specialCharacters[rand(0, strlen($specialCharacters) - 1)];
        $allCharacters = $upperCase . $lowerCase . $numbers . $specialCharacters;

        for ($i = 4; $i < $length; $i++) {
            $password .= $allCharacters[rand(0, strlen($allCharacters) - 1)];
        }
        // Shuffle the password to ensure random order
        return str_shuffle($password);
    }


//    public function checkout(Request $request)
//    {
//        // Set the Stripe API Key
//
//        $result = StoreDataService::storeData($request);
//        if (!$result['success']) {
//            return back()->with("warning", $result['error']);
//        }
//        $order = $result['order'];
////        $order->state_filing_fee +
////        $order->package_amount +
////        $order->en_amount +
////        $order->agreement_amount
////        $order->processing_amount;
//        // Create a new Checkout Session
//        $line_items = [];
//        // Add State Filing Fee
//        if ($order->state_filing_fee) {
//            $line_items[] = [
//                'price_data' => [
//                    'currency' => 'usd',
//                    'product_data' => [
//                        'name' => 'State Filing Fee',
//                    ],
//                    'unit_amount' => $order->state_filing_fee * 100, // Stripe expects amounts in cents
//                ],
//                'quantity' => 1,
//            ];
//        }
//
//        // Add Package Amount
//        if ($order->package_amount) {
//            $line_items[] = [
//                'price_data' => [
//                    'currency' => 'usd',
//                    'product_data' => [
//                        'name' => 'Business Address Fee',
//                    ],
//                    'unit_amount' => $order->package_amount * 100,
//                ],
//                'quantity' => 1,
//            ];
//        }
//
//        // Add EN Amount
//        if ($order->en_amount) {
//            $line_items[] = [
//                'price_data' => [
//                    'currency' => 'usd',
//                    'product_data' => [
//                        'name' => 'EIN Upgrade',
//                    ],
//                    'unit_amount' => $order->en_amount * 100,
//                ],
//                'quantity' => 1,
//            ];
//        }
//
//        // Add Agreement Amount
//        if ($order->agreement_amount) {
//            $line_items[] = [
//                'price_data' => [
//                    'currency' => 'usd',
//                    'product_data' => [
//                        'name' => 'Agreements',
//                    ],
//                    'unit_amount' => $order->agreement_amount * 100,
//                ],
//                'quantity' => 1,
//            ];
//        }
//
//        // Add Processing Amount
//        if ($order->processing_amount) {
//            $line_items[] = [
//                'price_data' => [
//                    'currency' => 'usd',
//                    'product_data' => [
//                        'name' => 'Rush Processing',
//                    ],
//                    'unit_amount' => $order->processing_amount * 100,
//                ],
//                'quantity' => 1,
//            ];
//        }
//        Stripe::setApiKey(env('STRIPE_SECRET'));
//        $checkout_session = Session::create([
//            'payment_method_types' => ['card'],
//            'line_items' => $line_items,  // Pass the dynamically created line_items array
//            'mode' => 'payment',
//            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
//            'cancel_url' => route('stripe.cancel'),
//        ]);
//        return redirect($checkout_session->url);
//    }

    public function checkout()
    {
        // Set the Stripe API Key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Create a new Checkout Session
        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Sample Product',
                    ],
                    'unit_amount' => 5000, // Amount in cents ($50.00)
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),
        ]);

        return redirect($checkout_session->url);
    }


    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        if (!$sessionId) {
            return 'No session ID provided.';
        }
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Retrieve the session
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            // Get the payment intent ID (transaction ID)
            $paymentIntentId = $session->payment_intent;


            return "Payment Successful! Transaction ID: " . $paymentIntentId;
        } catch (\Exception $e) {
            return 'Failed to retrieve session: ' . $e->getMessage();
        }
    }

    public function cancel()
    {
        return 'Payment Cancelled.';
    }
}
