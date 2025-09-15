<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use App\Models\Transition;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;
use Stripe\Exception\CardException;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Refund;
use App\Services\StoreDataService;

class StripePaymentController extends Controller
{
    public $user;
    public $company;

    public function pay(Request $request)
    {
        $request->localStorageData = json_decode($request->localStorageData, true);
        $result = StoreDataService::storeData($request);
        if (!$result['success']) {
            return back()->with("warning", $result['error']);
        }
        $order = $result['order'];

        // Create a new Checkout Session
        $line_items = [];
        // Add State Filing Fee
        if ($order->state_filing_fee) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'State Filing Fee',
                    ],
                    'unit_amount' => $order->state_filing_fee * 100, // Stripe expects amounts in cents
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

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,  // Pass the dynamically created line_items array
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}&user_id=' . $result['user_id'] . '&order_id=' . $order->id,
            'cancel_url' => route('stripe.cancel') . '?session_id={CHECKOUT_SESSION_ID}&user_id=' . $result['user_id'] . '&order_id=' . $order->id,
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

            // Retrieve the payment intent
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            $paymentMethodId = $paymentIntent->payment_method;
            $paymentMethod = PaymentMethod::retrieve($paymentMethodId);

            // Check the payment status
            $paymentStatus = $paymentIntent->status;


            $user = User::find($request['user_id']);
            $order = Order::find($request['order_id']);
            $company = $order->company;

            $transation = new Transition();
            $transation->company_id = $company->id;
            $transation->user_id = $user->id;
            $transation->charge_id = $paymentIntentId;
            $transation->status = $paymentStatus == "succeeded" ? "COMPLETED" : $paymentStatus;
            $transation->payment_method = "Stripe";
            $transation->receipt_url = $paymentIntent->receipt_url;
            $transation->card_type = $paymentMethod->card->brand;
            $transation->amount = $paymentIntent->amount / 100;
            $transation->player_name = $user->first_name . ' ' . $user->last_name;;
            $transation->save();

            $company->transition_id = $transation->id;
            $company->save();

            if ($order) {
                $order->transition_id = $transation->id;
                $order->payment_status = $transation->status;
                $order->save();
            }

            $to = $user->email;
            $subject = "Steady Formation Access";
            $password = $user->temp_password;

            if (Auth::check()) {
                Mail::send('email_templates.company_added', compact('user'), function ($message) use ($subject, $to) {
                    $message->from('noreply@funnel.com', env('APP_NAME', 'Steady Formation'));
                    $message->to($to); // $to
                    $message->subject($subject);
                });
            } else {
                Mail::send('email_templates.registration', compact('user', 'password'), function ($message) use ($subject, $to) {
                    $message->from('noreply@funnel.com', env('APP_NAME', 'Steady Formation Access'));
                    $message->to($to); // $to
                    $message->subject($subject);
                });
            }
            $data = [
                'success' => true,
                'paymentBY' => "Stripe",
                'message' => 'Payment successful. Please check emails for login credentials. if you didn\'t receive any emails then please contact us',
                'charge_id' => $paymentIntentId,
                'amount' => $transation->amount,
                'currency' => $paymentIntent->currency,
                'payment_method' => $transation->payment_method,
                'receipt_url' => $transation->receipt_url,
            ];
            return redirect()->route('payment_success')->with('success', 'Payment Success')->with('data', $data);
        } catch (\Exception $e) {
            $data = [
                'success' => true,
                'paymentBY' => "Stripe",
                'message' => 'Payment successful.',
                'charge_id' => "",
                'amount' => "",
                'currency' => "",
                'payment_method' => "",
                'receipt_url' => "",
            ];
            return redirect()->route('payment_success')->with('success', 'Payment Success')->with('data', $data);
        }
    }

    public function cancel(Request $request)
    {
        $user = User::find($request['user_id']);
        $company = Company::find($request['company_id']);
        if ($company) {
            if ($company->owners) {
                $company->owners()->delete();
            }
            if ($company->order) {
                $company->order->delete();
            }
            if ($company) {
                $company->delete();
            }
            if (!Auth::check() && $user) {
                $user->delete();
            }
        }
        $data = [
            'success' => false,
            'message' => 'Payment Cancelled',
        ];
        return redirect()->route('payment_success')->with('error', $data['message'])->with('data', $data);
    }


    public function refund(Request $request)
    {
        dd("We Are Working On It");

        $transition = Transition::find($request->transition_id);
        if ($transition->payment_method != "Stripe") {
            return redirect()->back()->with('warning', 'You are not able to refund');
        }
        $amount = $transition->amount * 100; // Convert to cents

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Retrieve the payment intent
            $paymentIntent = PaymentIntent::retrieve($transition->charge_id);

            // Retrieve the charges associated with the payment intent
            $charges = $paymentIntent->charges->data;

            if (count($charges) === 0) {
                return 'No charges found for this Payment Intent.';
            }

            // Get the charge ID from the first charge (assuming only one charge per payment)
            $chargeId = $charges[0]->id;

            // Create a refund
            $refund = Refund::create([
                'charge' => $chargeId,
                'amount' => $amount, // Refund amount in cents
            ]);

            return redirect()->back()->with('success', "Refund Successful! Refund ID: " . $refund->id);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create refund: ' . $e->getMessage());
        }
    }
}
