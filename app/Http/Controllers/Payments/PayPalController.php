<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use App\Models\Transition;
use App\Models\User;
use App\Services\PayPalService;
use Illuminate\Http\Request;
use App\Services\StoreDataService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    protected $payPalService;
    protected $company_id;
    protected $user_id;

    public function __construct(PayPalService $payPalService)
    {
        $this->payPalService = $payPalService;
    }

    public function createPayment(Request $request)
    {

//        dd($request->localStorageData);
        $request->localStorageData = json_decode($request->localStorageData, true);
        $result = StoreDataService::storeData($request);

        if (!$result['success']) {
            return back()->with("warning", $result['error']);
        }
        $this->company_id = $result['company_id'];
        $this->user_id = $result['user_id'];

        session(['company_id' => $result['company_id']]);
        session(['user_id' => $result['user_id']]);

        $company = Company::find($result['company_id']);

//        Log::info("Paypal Amount: " . $company->total_amount);
        $response = $this->payPalService->createPayment($company->total_amount);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('paypal.cancel');
        }

        return redirect()->back()->with('error', 'Something went wrong.');
    }

    public function success(Request $request)
    {
        $response = $this->payPalService->capturePayment($request->token);
        $user = User::find(session('user_id'));
        $company = Company::find(session('company_id'));

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $transation = new Transition();
            $transation->company_id = $company->id;
            $transation->user_id = $user->id;
            $transation->charge_id = $response['id'];
            $transation->status = $response['status'] ;
            $transation->payment_method = "PayPal";
            $transation->receipt_url = "";
            $transation->card_type = 'PayPal';
            $transation->amount = $company->total_amount;
            $transation->player_name = $response['payer']['name']['given_name'] . ' ' . $response['payer']['name']['surname'];
            $transation->save();

            $company->transition_id = $transation->id;
            $company->save();

            $order = Order::where('company_id', $company->id)->first();
            if ($order) {
                $order->transition_id = $transation->id;
                $order->payment_status = $transation->status;
                $order->save();
            }

            $data = [
                'success' => true,
                'paymentBY' => "PayPal",
                'message' => 'Payment Success. Please Check your Email for Login credential Information. if you didn\'t receive any emails please get in touch with us',
                'charge_id' => $transation->charge_id,
                'amount' => $transation->amount,
                'currency' => "",
                'payment_method' => "",
                'receipt_url' => "",
            ];

            $to = $user->email;
            $subject = "Steady Formation Access";
            $password = $user->temp_password;
            if (Auth::check()) {
                Mail::send('email_templates.company_added', compact('user'), function ($message) use ($subject, $to) {
                    $message->from('noreply@funnel.com', env('APP_NAME', 'Steady Formation Order'));
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
            session()->forget('user_id');
            session()->forget('company_id');

            return redirect()->route('payment_success')->with('success', 'Payment Success')->with('data', $data);
        } else {
            if ($company && $company->owners) {
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


            session()->forget('user_id');
            session()->forget('company_id');
            return redirect()->route('paypal.cancel');
        }
    }

    public function cancel()
    {
        $user = User::find(session('user_id'));
        $company = Company::find(session('company_id'));


        if ($company && $company->owners) {
            $company->owners->delete();
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
        $data = [
            'success' => false,
            'message' => 'Payment Cancelled!!. Please try again',
        ];

        session()->forget('user_id');
        session()->forget('company_id');

        return redirect()->route('payment_success')->with('error', 'Payment Cancelled!!. Please try again')->with('data', $data);

    }
}
