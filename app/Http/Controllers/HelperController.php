<?php

namespace App\Http\Controllers;

use App\Models\PrimaryContact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function Nette\Utils\first;

class HelperController extends Controller
{
    public function emailCheck(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true]);
    }

    public function paymentSuccess(Request $request)
    {

        $session_data = session('data');
        if (isset($session_data)) {
            if ($session_data['success']) {
                $data = [
                    'success' => $session_data['success'],
                    'paymentBY' => $session_data['paymentBY'],
                    'message' => $session_data['message'],
                    'charge_id' => $session_data['charge_id'],
                    'amount' => $session_data['amount'],
                    'currency' => $session_data['currency'],
                    'payment_method' => $session_data['payment_method'],
                    'receipt_url' => $session_data['receipt_url']
                ];
            } else {
                $data = [
                    'success' => false,
                    'paymentBY' => "",
                    'message' => isset($session_data['message']) ? $session_data['message'] : "Payment Failed",
                    'charge_id' => "",
                    'amount' => "",
                    'currency' => "",
                    'payment_method' => "",
                    'receipt_url' => "",
                ];
                return redirect()->route('payment_error')->with('error', $data['message'])->with('errorData', $data);
            }

            return view('web.payment_success', $data);
        }
  // abort(404);
 return redirect()->route('web.home');
        abort(404);
        $data = [
            'success' => false,
            'paymentBY' => "s",
            'message' => 'Try Again',
            'charge_id' => "",
            'amount' => "",
            'currency' => "",
            'payment_method' => "",
            'receipt_url' => "",
        ];
        return view('web.payment_success', $data);
    }


    public function paymentError()
    {
        $errorData = session('errorData');
        if (!$errorData) {
            // abort(404);
            
 return redirect()->route('web.home');
        }
        $data = [
            'success' => false,
            'paymentBY' => "s",
            'message' => isset($errorData) ? $errorData['message'] : "Payment Failed",
            'charge_id' => "",
            'amount' => "",
            'currency' => "",
            'payment_method' => "",
            'receipt_url' => "",
        ];

        return view('web.payment_success', $data);
    }

    public function passwordUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8,confirmed'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = implode(' ', $errors);
            return redirect()->back()->with('error', $errorMessage);
        }
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Please Login First');
        }

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->temp_password = $request->password;
        $user->save();
        return redirect()->back()->with('success', 'Password Updated Successfully');
    }

    public function storeUser(Request $request)
    {
        try {
            $data = $request->localStorageData;
            $user = new User();
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->email = $data['emails'];
            $user->email = $data['emails'];
            $user->phone = $data['phone_number'];
            $user->password = Hash::make("112233445566");
            $user->temp_password = 112233445566;
            $user->active = false;
            $user->save();
            return response()->json([
                'success' => false,
                "active_user_id" => $user->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function storePrimaryData(Request $request)
    {
        if (!Auth::check()) {
            $stepTowData = $request->stepTowData;
            $primaryData = PrimaryContact::where('email', $stepTowData['email'])->first();
            if (!$primaryData) {
                $primaryData = new PrimaryContact;
                $primaryData->first_name = $stepTowData['first_name'];
                $primaryData->last_name = $stepTowData['last_name'];
                $primaryData->email = $stepTowData['email'];
                $primaryData->phone_number = $stepTowData['phone_number'];
                $primaryData->save();
            }

        }
    }

}
