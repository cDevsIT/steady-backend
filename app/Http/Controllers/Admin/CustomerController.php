<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerCreateRequest;
use App\Models\Company;
use App\Models\Order;
use App\Models\OwnerInfo;
use App\Models\StateFee;
use App\Models\Transition;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function customers(Request $request)
    {
        menuSubmenu("customers", 'customers');
        $paginate = 50;
        $query = User::where("role", 2)->where(function ($q) use ($request) {
            if ($request->customer) {
                $q->where('id', $request->customer);
            }
        })->where(function ($query) use ($request) {
            if ($request->from_date && $request->to_date) {
                $startDate = Carbon::parse($request->from_date)->startOfDay();
                $endDate = Carbon::parse($request->to_date)->startOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($request->from_date) {
                $startDate = Carbon::parse($request->from_date)->startOfDay();
                $query->whereDate('created_at', $startDate);
            }
            if ($request->q) {
                $query->where('id', $request->q)
                    ->orWhere('first_name', 'LIKE', '%' . $request->q . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $request->q . '%')
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $request->q . '%']);
            }
        })->orderBy('created_at', "DESC");

        if ($request->submit_type == 'csv') {
            $customers = $query->get();
            // Create CSV file content
            $csvData = [];
            $csvData[] = ['ID', 'Created At', 'Status', 'First Name', 'Last Name', 'Email', 'Phone'];

            foreach ($customers as $customer) {
                $csvData[] = [
                    $customer->id,
                    $customer->created_at,
                    $customer->active ? "Active" : "Inactive",
                    $customer->first_name,
                    $customer->last_name,
                    $customer->email,
                    $customer->phone,

                ];
            }

            // Generate CSV file

            $filename = "customers_" . date('Y-m-d_H-i-s') . ".csv";
            if ($request->daterange) {
                $filename = "customers_" . $request->daterange . ".csv";
            }

            $fileContent = '';
            foreach ($csvData as $row) {
                $fileContent .= implode(",", $row) . "\n";
            }

            // Return response as a download
            return Response::make($fileContent, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        }

        // Get statistics before pagination
        $totalCustomers = User::where("role", 2)->count();
        $activeCustomers = User::where("role", 2)->where('active', true)->count();
        $inactiveCustomers = User::where("role", 2)->where('active', false)->count();
        $totalCompanies = Company::count();
        
        $customers = $query->paginate($paginate);
        return view('admin.customers.customers', compact('customers', 'totalCustomers', 'activeCustomers', 'inactiveCustomers', 'totalCompanies'))->with('i', ($request->input('page', 1) - 1) * $paginate);
    }

    public function createCustomer(Request $request)
    {
        if ($request->method() == 'GET') {
            $states = StateFee::all();
            return view('admin.customers.createCustomer', compact('states'));
        }


//dd($request->all());
        try {
            $result = DB::transaction(function () use ($request) {

                $exestingUser = User::where('email', $request->p_email)->first();
                if ($exestingUser) {
                    return redirect()->back()->with('warning', 'Email Already Exist');
                }
                $user = new User();
                $user->first_name = $request->p_first_name;
                $user->last_name = $request->p_last_name;
                $user->email = $request->p_email;
                $user->phone = $request->p_phone;
                $user->password = Hash::make($request->password);
                $user->temp_password = $request->password;
                $user->role = 2;
                $user->active = true;
                $user->save();


                $company = new Company();
                $company->user_id = $user->id;
                $company->company_name = $request->business_name;
                $company->business_type = $request->business_type;
                $company->type_of_industry = $request->type_of_industry;
                $company->number_of_ownership = $request->number_of_ownership;
                $company->package_name = $request->package_name;

                if ($company->package_name == "free-plan") {
                    $company->plan_street_address = $request->step4_street_address;
                    $company->plan_city = $request->step4_city;
                    $company->plan_state = $request->step4_state;
                    $company->plan_zip_code = $request->step4_zip_code;
                    $company->plan_zip_country = $request->step4_country;
                }

                $company->save();

                $order = new Order;
                $order->company_id = $company->id;
                $order->user_id = $user->id;
                $state = StateFee::find($request->state_name);
                $order->state_name = $state->state_name;

                $order->state_filing_fee = $state->fees;
                $order->package_name = $company->package_name;

                if ($company->package_name == "monthly-plan") {
                    $order->package_amount = 25.00;
                } elseif ($company->package_name == "yearly-plan") {
                    $order->package_amount = 259.00;
                } else {
                    $order->package_amount = 0.00;
                }


                if ($request->has_en == 'Yes') {
                    $order->has_en = 1;
                    $order->en_amount = 69.00;
                }

                if ($request->en_agreement == 'Yes') {
                    $order->has_agreement = 1;
                    $order->agreement_amount = 99.00;
                }

                if ($request->expedited_processing == 'Yes') {
                    $order->has_processing = 1;
                    $order->processing_amount = 25;
                }

                $order->total_amount =
                    $order->state_filing_fee +
                    $order->package_amount +
                    $order->en_amount +
                    $order->agreement_amount +
                    $order->processing_amount;

                $order->save();
//                Log::info("Order Amount: " . $order->total_amount);

                $company->order_id = $order->order_id;
                $company->total_amount = $order->total_amount;
                $company->save();

                $name = $request->name;
                if ($name) {
                    foreach ($name as $key => $value) {
                        $owner = new OwnerInfo();
                        $owner->company_id = $company->id;
                        $owner->user_id = $user->id;
                        $owner->name = $request['name'][$key];
                        $owner->email = $request['email'][$key];
                        $owner->phone = $request['phone'][$key];
                        $owner->ownership_percentage = $request['ownership_percentage'][$key];
                        $owner->street_address = $request['street_address'][$key];
                        $owner->city = $request['city'][$key];
                        $owner->state = $request['state'][$key];
                        $owner->zip_code = $request['zip_code'][$key];
                        $owner->country = $request['country'][$key];
                        $owner->save();
                    }
                }

                $transation = new Transition();
                $transation->company_id = $company->id;
                $transation->user_id = $user->id;
                $transation->charge_id = 'manual';
                $transation->status = "COMPLETED";
                $transation->payment_method = $request->payment_method;
                $transation->receipt_url = "";
                $transation->card_type = $request->payment_method;
                $transation->amount = $company->total_amount;
                $transation->player_name = Auth::user()->first_name . " " . Auth::user()->last_name;
                $transation->save();

                $company->transition_id = $transation->id;
                $company->save();

                $order = Order::where('company_id', $company->id)->first();
                if ($order) {
                    $order->transition_id = $transation->id;
                    $order->payment_status = $transation->status;
                    $order->save();
                }

                return redirect()->back()->with('success', 'Success');
            });
            return redirect()->back()->with('success', 'Success');


        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());

        }


        $validator = Validator::make($request->all(), [
            "first_name" => 'required',
            "last_name" => 'required',
            "email" => 'required|email|unique:users,email',
            "phone" => 'required',
            "password" => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = implode(' ', $errors);
            return redirect()->back()->with('error', $errorMessage);
        }

        $customer = new User();
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->password = Hash::make($request->password);
        $customer->temp_password = $request->password;
        $customer->role = 2;
        $customer->active = $request->active ? 1 : 0;
        $customer->save();
        return redirect()->back()->with('success', 'Customer created successfully');
    }

    public function customerUpdate(Request $request, $customer_id)
    {
        $customer = User::where("role", 2)->where('id', $customer_id)->first();

        if (!$customer) return redirect()->back()->with('error', 'Customer not found');
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $customer_id,
            'phone' => 'nullable',
            'active' => 'nullable',
        ]);
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->active = $request->active ? 1 : 0;
        if ($request->password) {
            $customer->password = Hash::make($request->password);
            $customer->temp_password = $request->password;
        }
        $customer->save();
        return redirect()->back()->with('success', 'Customer updated successfully');
    }

    public function admins(Request $request)
    {
        menuSubmenu("admins", 'admins');
        if ($request->method() == "POST") {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email||unique:users,email',
                'phone' => 'nullable',
                'password' => 'required|min:8',
                'active' => 'nullable',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errorMessage = implode(' ', $errors);
                return redirect()->back()->with('error', $errorMessage);
            }

            $user = new User;
            $user->role = 1;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->temp_password = $request->password;
            $user->active = $request->active ? 1 : 0;
//            dd($user);
            $user->save();
            return redirect()->back()->with('success', 'Admin added successfully');
        }


        $admins = User::where("role", 1)->orderBy('created_at', "DESC")->get();
        return view('admin.admins.admins', compact('admins'));
    }

    public function adminsUpdate(Request $request, $id)
    {
        $user = User::find($id);
        if ((Auth::id() == $user->id) && !$request->active) {
            return redirect()->back()->with('error', 'Cannot Inactive your own account');
        }
        if ($request->method() == "PUT") {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email||unique:users,email,' . $user->id,
                'phone' => 'nullable',
                'password' => 'nullable|min:8',
                'active' => 'nullable',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errorMessage = implode(' ', $errors);
                return redirect()->back()->with('error', $errorMessage);
            }

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;

            if ($request->password) {
                $user->password = Hash::make($request->password);
                $user->temp_password = $request->password;
            }

            $user->active = $request->active ? 1 : 0;
            $user->save();
            return redirect()->back()->with('success', 'Admin Updated successfully');
        }


        return back();
    }

    public function adminDelete($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return redirect()->back()->with('error', 'Admin user not found');
        }
        
        // Prevent deleting own account
        if (Auth::id() == $user->id) {
            return redirect()->back()->with('error', 'Cannot delete your own account');
        }
        
        // Prevent deleting if it's the only admin
        $adminCount = User::where('role', 1)->count();
        if ($adminCount <= 1) {
            return redirect()->back()->with('error', 'Cannot delete the only admin user');
        }
        
        try {
            $user->delete();
            return redirect()->back()->with('success', 'Admin user deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete admin user. Please try again.');
        }
    }

}
