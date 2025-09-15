<?php

namespace App\Http\Controllers;

use App\Jobs\RenewJob;
use App\Models\Comment;
use App\Models\Company;
use App\Models\CompanyRenewalHistory;
use App\Models\Order;
use App\Models\RenewalHistory;
use App\Models\StateFee;
use App\Models\Transition;
use App\Models\User;
use App\Services\PayPalService;
use App\Services\RenewPayPalService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\SchemaOrg\Car;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;

class RenewalController extends Controller
{
    protected $payPalService;

    public function __construct(RenewPayPalService $payPalService)
    {
        $this->payPalService = $payPalService;
    }

    public function getRenewal(Request $request, Company $company)
    {
        $type = $request->type;
        $order = $company->order;

        if (!$type || !$order) {
            return redirect()->back()->with('warning', "Something went wrong");
        }

        if ($order->compliance_status != 'expired') {
            return redirect()->back()->with('warning', "Company Not Expired Yet");
        }
        $state = $order->state ? $order->state : StateFee::where('state_name', $order->state_name)->first();

        if (!$state) {
            return redirect()->back()->with('warning', "State Not Found");
        }
        $data['company'] = $company;
        $data['order'] = $order;
        $data['state'] = $state;
        $data['state_fee'] = $state->renewal_fee;
        $data['service_fee'] = 99;

        $data['business_address_fee'] = 0;
        if ($company->package_name == 'monthly-plan') {
            $data['business_address_fee'] = 10;
        } elseif ($company->package_name == 'yearly-plan') {

            $data['business_address_fee'] = 99;
        }
        $data['total_amount'] = $data['state_fee'] + $data['service_fee'] + $data['business_address_fee'];


        return view('web.dashboard.renewal', $data);

    }


    public function postRenewal(Request $request, Company $company)
    {
        $paymentMethod = $request->paymentMethod;
        $order = $company->order;

        if (!$order) {
            return redirect()->back()->with('warning', "Something went wrong");
        }

        if ($order->compliance_status != 'expired') {
            return redirect()->back()->with('warning', "Company Not Expired Yet");
        }
        $state = $order->state ? $order->state : StateFee::where('state_name', $order->state_name)->first();

        if (!$state) {
            return redirect()->back()->with('warning', "State Not Found");
        }


        $data['company'] = $company;

        $total_amount = $request->service_fee + $request->state_fee + ($request->business_address_fee ?: 0);
        if ($paymentMethod == "stripe") {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Company Renewal Service Fee',
                    ],
                    'unit_amount' => $request->service_fee * 100,
                ],
                'quantity' => 1,
            ];


            //Renewal Fee
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'State Fee',
                    ],
                    'unit_amount' => $request->state_fee * 100, // Stripe expects amounts in cents
                ],
                'quantity' => 1,
            ];

            $data['package_name'] = $company->package_name;
            if ($request->business_address_fee) {
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Registered Agent and Business Address Fee',
                        ],
                        'unit_amount' => $request->business_address_fee * 100,
                    ],
                    'quantity' => 1,
                ];
            }
            //Store Renewal History


            $history = new CompanyRenewalHistory();
            $history->company_id = $company->id;
            $history->user_id = $company->user_id;
            $history->order_id = $order->id;
            $history->service_fee = $request->service_fee;
            $history->business_address_fee = $request->business_address_fee ?: 0;
            $history->state_fee = $request->state_fee;
            $history->total_amount = $request->state_fee + $request->service_fee + ($request->business_address_fee ?: 0);
            $history->save();


            Stripe::setApiKey(env('STRIPE_SECRET'));
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $line_items,  // Pass the dynamically created line_items array
                'mode' => 'payment',
                'success_url' => route('renew.success') . '?session_id={CHECKOUT_SESSION_ID}&m=s&c_id=' . $company->id . "&h_id=" . $history->id,
                'cancel_url' => route('renew.cancel') . '?session_id={CHECKOUT_SESSION_ID}&&m=s&c_id=' . $company->id . "&h_id=" . $history->id,
            ]);


            return redirect($checkout_session->url);
        }


        if ($paymentMethod == "payPal") {
            return redirect()->back()->with('warning','We Are Working With Paypal');
            //Store Renewal History
            $history = new CompanyRenewalHistory();
            $history->company_id = $company->id;
            $history->user_id = $company->user_id;
            $history->order_id = $order->id;
            $history->service_fee = $request->service_fee;
            $history->business_address_fee = $request->business_address_fee ?: 0;
            $history->state_fee = $request->state_fee;
            $history->total_amount = $total_amount;
            $history->save();

            $response = $this->payPalService->createPayment($history->total_amount);
            if (isset($response['id']) && $response['id'] != null) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        $params = http_build_query([
                            'm' => 'p',
                            'c_id' => $company->id,
                            'h_id' => $history->id
                        ]);
                        return redirect()->away($link['href'] . '?' . $params);
//
//                        return redirect()->away($link['href'] . '&m=s&c_id=' . $company->id . "&h_id=" . $history->id);
                    }
                }
            } else {
                return redirect()->route('renew.cancel',[ 'c_id' => $company->id]);
            }
        }

    }

    public function paymentSuccess(Request $request)
    {
        if ($request->m == "s") {
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

                // Retrieve the payment intent
                $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

                $paymentMethodId = $paymentIntent->payment_method;
                $paymentMethod = PaymentMethod::retrieve($paymentMethodId);

                // Check the payment status
                $paymentStatus = $paymentIntent->status;


                $company = Company::find($request->c_id);
                $user = User::find($company->user_id);
                $order = Order::where('company_id', $company->id)->first();

                $transation = new Transition();
                $transation->company_id = $company->id;
                $transation->user_id = $company->user_id;
                $transation->charge_id = $paymentIntentId;
                $transation->status = $paymentStatus == "succeeded" ? "COMPLETED" : $paymentStatus;
                $transation->payment_method = "Stripe";
                $transation->receipt_url = $paymentIntent->receipt_url;
                $transation->card_type = $paymentMethod->card->brand;
                $transation->amount = $paymentIntent->amount / 100;
                $transation->player_name = $user->first_name . ' ' . $user->last_name;
                $transation->payment_type = "renew";
                $transation->save();

                $history = CompanyRenewalHistory::find($request->h_id);
                if ($history) {
                    $history->prev_expired_at = $order->renewal_date;
                    $history->new_expired_at = Carbon::parse($order->renewal_date)->addYear();
                    $history->completed = 1;
                    $history->save();
                }
                if ($order) {
                    $order->compliance_status = "active";
                    $order->renewal_date = Carbon::parse($order->renewal_date)->addYear();
                    $order->save();
                }
                $route = route('web.companies', $company);

                dispatch(new RenewJob($transation, $route, $user, $history));
                return redirect()->route('web.companies', $company)->with('success', 'Payment Success');
            } catch (\Exception $e) {
                return redirect()->route('web.companies', $company)->with('warning', 'Payment Failed');
            }
        }
        if ($request->m == "p") {
            dd("TOKEN:::::>> ". $request->token);
            $response = $this->payPalService->capturePayment($request->token);
            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                $company = Company::find($request->c_id);
                $user = User::find($company->user_id);
                $order = Order::where('company_id', $company->id)->first();

                $transation = new Transition();
                $transation->company_id = $company->id;
                $transation->user_id = $company->user_id;
                $transation->charge_id = $response['id'];
                $transation->status = $response['status'];
                $transation->payment_method = "PayPal";
                $transation->receipt_url = "";
                $transation->card_type = 'PayPal';
                $transation->player_name = $response['payer']['name']['given_name'] . ' ' . $response['payer']['name']['surname'];
                $transation->payment_type = "renew";
                $transation->save();

                $history = CompanyRenewalHistory::find($request->h_id);
                if ($history) {
                    $history->prev_expired_at = $order->renewal_date;
                    $history->new_expired_at = Carbon::parse($order->renewal_date)->addYear();
                    $history->completed = 1;
                    $history->save();
                }
                if ($order) {
                    $order->compliance_status = "active";
                    $order->renewal_date = Carbon::parse($order->renewal_date)->addYear();
                    $order->save();
                }
                $route = route('web.companies', $company);

                dispatch(new RenewJob($transation, $route, $user, $history));
                return redirect()->route('web.companies', $company)->with('success', 'Payment Success');

            } else {
                return redirect()->route('renew.cancel', ['c_id' => $request->c_id]);
            }
        }
    }

    public function paymentCancel(Request $request)
    {
        $company = Company::find($request->c_id);
        return redirect()->route('web.companies', $company)->with('warning', 'Payment Canceled');
    }
}
