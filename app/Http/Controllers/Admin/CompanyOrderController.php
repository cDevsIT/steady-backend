<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\StatusJob;
use App\Models\Company;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CompanyOrderController extends Controller
{
    public function orders(Request $request)
    {

        menuSubmenu("orders", 'orders_' . $request->type);
        $paginate = 50;
        $query = Order::leftJoin('users as customers', 'customers.id', '=', 'orders.user_id')
            ->leftJoin('companies', 'companies.id', '=', 'orders.company_id')
            ->leftJoin('transitions', 'transitions.id', '=', 'orders.transition_id')
            ->orderBy('created_at', 'desc');
        if ($request->company) {
            $query->where('orders.company_id', $request->company);
        }
        if ($request->order) {
            $query->where('orders.id', $request->order);
        }

        if ($request->daterange) {
            $dates = explode(' to ', $request->daterange);
            $query->whereBetween('orders.created_at', [Carbon::parse($dates[0])->startOfDay(), Carbon::parse($dates[1])->endOfDay()]);
        }
        if ($request->q) {
            $query->where('orders.id', 'LIKE', $request->q)
                ->orWhere('companies.company_name', 'LIKE', '%' . $request->q . '%')
                ->orWhere('customers.first_name', 'LIKE', '%' . $request->q . '%')
                ->orWhere('customers.last_name', 'LIKE', '%' . $request->q . '%')
                ->orWhereRaw("CONCAT(customers.first_name, ' ', customers.last_name) LIKE ?", ['%' . $request->q . '%']);
        }


        if ($request->type == "active") {
            menuSubmenu("orders", 'orders_active');
            $query->where('orders.compliance_status', 'active');
            $query->where('transitions.charge_id', '!=', null);
            $query->where('transitions.status', 'COMPLETED');
        }
        if ($request->type == "expired") {
            menuSubmenu("orders", 'orders_expired');
            $query->where('orders.compliance_status', 'expired');
        }

        if ($request->type == "fail") {
            menuSubmenu("orders", 'fail');
            $query->where('orders.transition_id', null);
//            $query->where('transitions.charge_id', '=', null);
//            $query->where('transitions.status', '!=', 'COMPLETED');
        }

        $query = $query->select(
            'orders.id',
            'orders.created_at',
            'transitions.charge_id AS transition_id',
            'customers.first_name AS customer_first_name',
            'customers.last_name AS customer_last_name',
            'companies.company_name',
            'orders.company_id',
            'orders.user_id',
            'orders.state_name',
            'orders.package_name',
            DB::raw("CASE
                WHEN orders.name_availability_search_status = 'processing' THEN 'Name Availability Search'
                WHEN orders.state_filing_status = 'processing' THEN 'State Filing'
                WHEN orders.setup_business_address_status = 'processing' THEN 'Setup Business Address'
                WHEN orders.mail_forwarding_status = 'processing' THEN 'Mail Forwarding'
                WHEN orders.ein_filing_status = 'processing' THEN 'EIN Filing'
                WHEN orders.operating_agreement_status = 'processing' THEN 'Operating Agreement'
                WHEN orders.complete_status = 'processing' THEN 'Complete'
                ELSE ''
            END AS last_status"),
            'orders.payment_status',
            'orders.compliance_status'
        );
        if ($request->submit_type == 'csv') {
            $orders = $query->get();
            // Create CSV file content
            $csvData = [];
            $csvData[] = ['ID', 'Created At', 'Transition ID', 'Customer Name', 'Company Name', 'State Name', 'Package Name', "Last Update", "Payment Status", "Compliance Status"];

            foreach ($orders as $order) {
                $csvData[] = [
                    $order->id,
                    $order->created_at,
                    ($order->transition_id) ? $order->transition_id : 'failed',
                    $order->customer_first_name . " " . $order->customer_last_name,
                    $order->company_name,
                    $order->state_name,
                    $order->package_name,
                    $order->last_status,
                    $order->payment_status,
                    $order->compliance_status


                ];
            }

            // Generate CSV file

            $filename = $request->type . "_orders" . date('Y-m-d_H-i-s') . ".csv";
            if ($request->daterange) {
                $filename = $request->type . "_orders" . $request->daterange . ".csv";
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
        $orders = $query->paginate($paginate);
//        dd($orders);

        return view('admin.orders.orders', compact('orders'))->with('i', ($request->input('page', 1) - 1) * $paginate);

    }

    public function ordersDetails(Request $request, Order $order)
    {
        $data['user'] = User::find($order->user_id);
        $data['company'] = Company::find($order->company_id);
        $data['transition'] = $order->transition;
        $data['order'] = $order;
        $data['countries'] = ['Afghanistan', 'Åland Islands', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bangladesh', 'Barbados', 'Bahamas', 'Bahrain', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Brazil', 'British Indian Ocean Territory', 'British Virgin Islands', 'Brunei Darussalam', 'Bulgaria', 'Burkina Faso', 'Burma', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island', 'Cocos (Keeling) Islands', 'Colombia', 'Comoros', 'Congo-Brazzaville', 'Congo-Kinshasa', 'Cook Islands', 'Costa Rica', '$_[', 'Croatia', 'Curaçao', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'El Salvador', 'Egypt', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Falkland Islands', 'Faroe Islands', 'Federated States of Micronesia', 'Fiji', 'Finland', 'France', 'French Guiana', 'French Polynesia', 'French Southern Lands', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guernsey', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Heard and McDonald Islands', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iraq', 'Ireland', 'Isle of Man', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jersey', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Montserrat', 'Morocco', 'Mozambique', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'Northern Mariana Islands', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn Islands', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Réunion', 'Romania', 'Russia', 'Rwanda', 'Saint Barthélemy', 'Saint Helena', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Martin', 'Saint Pierre and Miquelon', 'Saint Vincent', 'Samoa', 'San Marino', 'São Tomé and Príncipe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Sint Maarten', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Georgia', 'South Korea', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Svalbard and Jan Mayen', 'Sweden', 'Swaziland', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tokelau', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks and Caicos Islands', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City', 'Vietnam', 'Venezuela', 'Wallis and Futuna', 'Western Sahara', 'Yemen', 'Zambia', 'Zimbabwe'];
//        dd($data['order']);
        return view('admin/orders/ordersDetails', $data);
    }

    public function orderDocumentUpdate(Request $request)
    {
        $order = Order::find($request->order);
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:jpeg,png,gif,pdf,doc,docx',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = implode(' ', $errors);
            return redirect()->back()->with('error', $errorMessage);
        }
        if ($request->hasFile('file')) {
            if ($request->document_type == 'article_of_organization_file') {

//                // Get the uploaded file
//                $file = $request->file('file');
//
//                // Define the path to save the file (inside 'public/uploads' directory)
//                $destinationPath = public_path('uploads');
//
//                // Define the file name (you can customize it as per your requirement)
//                $fileName = time() . '_' . $file->getClientOriginalName();
//
//                // Move the file to the desired location
//                $file->move($destinationPath, $fileName);
//
//                // Optionally, you can return the file path or store it in the database
//                $filePath = 'uploads/' . $fileName;
//


                $existingFilePath = 'uploads/' . $order->article_of_organization_file;
                if (Storage::disk('public')->exists($existingFilePath)) {
                    Storage::disk('public')->delete($existingFilePath);
                }
                $file = $request->file('file');
                $fileName = $order->id . "-" . $file->getClientOriginalName();
                $path = $file->storeAs('uploads', $fileName, 'public');

                $file = $request->file('file');
                $path = $file->store('uploads', 'public');
                $order->article_of_organization_file = $fileName;
                $order->save();

                return redirect()->back()->with("success", 'File uploaded successfully');
            }
            if ($request->document_type == 'package_file') {
                $existingFilePath = 'uploads/' . $order->package_file;
                if (Storage::disk('public')->exists($existingFilePath)) {
                    Storage::disk('public')->delete($existingFilePath);
                }
                $file = $request->file('file');
                $fileName = $order->id . "-" . $file->getClientOriginalName();
                $path = $file->storeAs('uploads', $fileName, 'public');

                $file = $request->file('file');
                $path = $file->store('uploads', 'public');
                $order->package_file = $fileName;
                $order->save();

                return redirect()->back()->with("success", 'File uploaded successfully');
            }
            if ($request->document_type == 'en_file') {
                $existingFilePath = 'uploads/' . $order->en_file;
                if (Storage::disk('public')->exists($existingFilePath)) {
                    Storage::disk('public')->delete($existingFilePath);
                }
                $file = $request->file('file');
                $fileName = $order->id . "-" . $file->getClientOriginalName();
                $path = $file->storeAs('uploads', $fileName, 'public');

                $file = $request->file('file');
                $path = $file->store('uploads', 'public');
                $order->en_file = $fileName;
                $order->save();

                return redirect()->back()->with("success", 'File uploaded successfully');
            }

            if ($request->document_type == 'agreement_file') {
                $existingFilePath = 'uploads/' . $order->agreement_file;
                if (Storage::disk('public')->exists($existingFilePath)) {
                    Storage::disk('public')->delete($existingFilePath);
                }
                $file = $request->file('file');
                $fileName = $order->id . "-" . $file->getClientOriginalName();
                $path = $file->storeAs('uploads', $fileName, 'public');

                $file = $request->file('file');
                $path = $file->store('uploads', 'public');
                $order->agreement_file = $fileName;
                $order->save();

                return redirect()->back()->with("success", 'File uploaded successfully');
            }

            if ($request->document_type == 'processing_file') {
                $existingFilePath = 'uploads/' . $order->processing_file;
                if (Storage::disk('public')->exists($existingFilePath)) {
                    Storage::disk('public')->delete($existingFilePath);
                }
                $file = $request->file('file');
                $fileName = $order->id . "-" . $file->getClientOriginalName();
                $path = $file->storeAs('uploads', $fileName, 'public');

                $file = $request->file('file');
                $path = $file->store('uploads', 'public');
                $order->processing_file = $fileName;
                $order->save();

                return redirect()->back()->with("success", 'File uploaded successfully');
            }
        }

        return redirect()->back()->with("success", 'Something Wrong');

    }

    public function companyDateUpdate(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(["success" => false, "message" => "Order not found"]);
        }

        $order[$request->name] = $request->value;
        $order->save();
        return response()->json(["success" => true, "message" => $request->name . "Updated Succesfully"]);
    }


    public function orderStatusUpdate(Request $request, $id)
    {
//        dd($request->except('_token'));
        $order = Order::find($id);
        if (!$order) {
            return response()->json(["success" => false, "message" => "Order not found"]);
        }
        $fieldName = array_keys($request->except(['_token', 'isStatus']))[0];

        $order->update($request->except(['_token', 'isStatus']));

        if ($request->isStatus) {
            if ($order[$fieldName] == 'complete') {
                $currentStep = Str::title(str_replace(['status', '_'], ' ', $fieldName));
                $status = $order[$fieldName];
                $company = $order->company;
                $user = $order->user;

                $nextStep = null;
                if ($fieldName == 'name_availability_search_status') {
                    $nextStep = "State Filing";
                } elseif ($fieldName == 'state_filing_status') {
                    $nextStep = "Setup Business Address";
                } elseif ($fieldName == 'setup_business_address_status') {
                    $nextStep = "Mail Forwarding ";
                } elseif ($fieldName == 'mail_forwarding_status') {
                    $nextStep = "EIN Filing ";
                } elseif ($fieldName == 'ein_filing_status') {
                    $nextStep = "Operating Agreement ";
                } elseif ($fieldName == 'operating_agreement_status') {
                    $nextStep = "Completed";
                }

                dispatch(new StatusJob($user, $company, $currentStep, $status, $nextStep));
                return redirect()->back()->with('success', $currentStep . " Status Updated and mailed successfully");


            } else {
                return redirect()->back()->with('success', "Status Updated successfully");

            }

        }
        return redirect()->back()->with('success', "Updated successfully");
    }

    public function updateCompanyDetailsOnOrderDetails(Request $request, $id)
    {

        $company = Company::find($id);
        if (!$company) {
            return response()->json(["success" => false, "message" => "Order not found"]);
        }
        $company->update($request->except('token'));
        return redirect()->back()->with('success', "Company Details Updated successfully");
    }


}
