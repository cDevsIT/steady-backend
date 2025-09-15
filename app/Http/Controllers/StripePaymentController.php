<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Order;
use App\Models\Transition;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Exception\CardException;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Services\StoreDataService;

class StripePaymentController extends Controller
{
    public $user;
    public $company;

    public function pay(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            $request->localStorageData = json_decode($request->localStorageData, true);
            $result = StoreDataService::storeData($request);
            if (!$result['success']) {
                return back()->with("warning", $result['error']);
            }
            $user = User::find($result['user_id']);
            $company = Company::find($result['company_id']);
            $this->user = $user;
            $this->company = $company;

            $customer = \Stripe\Customer::create([
                'email' => $user->email,
                'source' => $request->stripeToken,
            ]);

//            Log::info("Stripe Amount: " . $company->total_amount);

            // Charge the customer
            $charge = \Stripe\Charge::create([
                'customer' => $customer->id,
                'amount' => $company->total_amount * 100,
                'currency' => 'usd',
            ]);

            $status = $charge->status;
            $paymentMethod = $charge->payment_method_details->type;
            $cardType = $charge->payment_method_details->card->brand;
            $amount = $charge->amount;
            $transactionId = $charge->id;
            if ($status === 'succeeded') {
                // Payment was successful
                $data = [
                    'success' => true,
                    'paymentBY' => "Stripe",
                    'message' => 'Payment successful. Please check email for login credentials. if you didn\'t receive any email then please contact us',
                    'charge_id' => $charge->id,
                    'amount' => $charge->amount,
                    'currency' => $charge->currency,
                    'payment_method' => $charge->payment_method,
                    'receipt_url' => $charge->receipt_url,
                ];
                $transation = new Transition();
                $transation->company_id = $company->id;
                $transation->user_id = $user->id;
                $transation->charge_id = $charge->id;
                $transation->status = $charge->status;
                $transation->payment_method = "Stripe";
                $transation->receipt_url = $charge->receipt_url;
                $transation->card_type = $charge->payment_method_details->card->brand;
                $transation->amount = $charge->amount;
                $transation->player_name = $user->first_name . ' ' . $user->last_name;;
                $transation->save();

                $company->transition_id = $transation->id;
                $company->save();
                $order =  Order::where('company_id', $company->id)->first();
                if ($order){
                    $order->transition_id = $transation->id;
                    $order->payment_status =$transation->status;
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

                return redirect()->route('payment_success')->with('success', 'Payment Success')->with('data', $data);
            } else {
                $company->owners->delete();
                $company->delete();
                $user->delete();
                $data = [
                    'success' => false,
                    'message' => 'Payment failed. Status: ' . $status . "Please Try Again",
                ];
                return redirect()->route('payment_success')->with('success', 'Payment Success')->with('data', $data);
            }
        } catch (CardException $e) {
            $error = $e->getError();
            if($this->company){
                if($this->company->owners) {$this->company->owners->delete();}
                if($this->company->order) {$this->company->order->delete();}
                if($this->company) {$this->company->delete();}
                if($this->user) {$this->user->delete();}
            }
            $payment_intent_id = $e->getError()->payment_intent->id;
            $data = [
                'success' => false,
                'message' => 'Payment failed: ' . $error->message . "payment_intent_id: " . $payment_intent_id,
            ];
            return redirect()->route('payment_success')->with('error', $error->message)->with('data', $data);
        } catch (\Exception $e) {

            $this->company->owners->delete();
            $this->company->order->delete();
            $this->company->delete();
            $this->user->delete();

            $data = [
                'success' => false,
                'message' => 'Payment failed! ' . $e->getMessage(),
            ];
            return redirect()->route('payment_success')->with('error', $e->getMessage())->with('data', $data);
        }
    }
}
