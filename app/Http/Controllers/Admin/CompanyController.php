<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CompanyController extends Controller
{
    public function companies(Request $request)
    {
        menuSubmenu("companies", 'companies');
        $paginate = 20;

        $query = Company::leftJoin('users', 'users.id', '=', 'companies.user_id')
            ->orderBy('companies.created_at', 'desc');
        if ($request->user) {
            $query->where('companies.user_id', $request->user);
        }
        if ($request->company) {
            $query->where('companies.id', $request->company);
        }
        if ($request->q) {
            $query->where('companies.company_name', 'LIKE', '%' . $request->q . '%')
                ->orWhere('users.first_name', 'LIKE', '%' . $request->q . '%')
                ->orWhere('users.last_name', 'LIKE', '%' . $request->q . '%')
                ->orWhereRaw("CONCAT(users.first_name, ' ', users.last_name) LIKE ?", ['%' . $request->q . '%']);
        }
        if ($request->from_date && $request->to_date) {
            $startDate = Carbon::parse($request->from_date)->startOfDay();
            $endDate = Carbon::parse($request->to_date)->startOfDay();
            $query->whereBetween('companies.created_at', [$startDate, $endDate]);
        } elseif ($request->from_date) {
            $startDate = Carbon::parse($request->from_date)->startOfDay();
            $query->whereDate('companies.created_at', $startDate);
        }

       $query->select(
            'companies.id',
            'companies.created_at',
            'companies.company_name',
            'companies.business_type',
            'companies.type_of_industry',
            'companies.number_of_ownership',
            'users.first_name',
            'users.last_name'
        );

        // Get statistics before pagination
        $totalCompanies = Company::count();
        $llcCompanies = Company::where('business_type', 'llc')->count();
        $corporationCompanies = Company::where('business_type', 'corporation')->count();
        $cCorpCompanies = Company::where('business_type', 'c_corp')->count();
        $sCorpCompanies = Company::where('business_type', 's_corp')->count();
        $partnershipCompanies = Company::where('business_type', 'partnership')->count();
        $nonProfitCompanies = Company::where('business_type', 'non_profit')->count();
        
        $customers = User::where('active', true)->paginate($paginate);

        if ($request->submit_type == 'csv'){
            $companies  =  $query->get();
            // Create CSV file content
            $csvData = [];
            $csvData[] = ['ID', 'Created At', 'Company Name', 'Business Type', 'Industry Type', 'Number of Ownership', 'Customer Name'];

            foreach ($companies as $company) {
                $csvData[] = [
                    $company->id,
                    $company->created_at,
                    $company->company_name,
                    $company->business_type,
                    $company->type_of_industry,
                    $company->number_of_ownership,
                    $company->first_name ." ".$company->last_name,

                ];
            }

            // Generate CSV file

            $filename = "companies_" . date('Y-m-d_H-i-s') . ".csv";
            if ($request->daterange){
                $filename = "companies_" . $request->daterange. ".csv";
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
        $companies  =  $query->paginate($paginate);
        return view('admin.companies.companies', compact('companies', 'customers', 'totalCompanies', 'llcCompanies', 'corporationCompanies', 'cCorpCompanies', 'sCorpCompanies', 'partnershipCompanies', 'nonProfitCompanies'))->with('i', ($request->input('page', 1) - 1) * $paginate);

    }

    public function companyCreate(Request $request)
    {

    }

    public function companyDateUpdate(Request $request, $id)
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json(["success" => false, "message" => "Company not found"]);
        }

        $company[$request->name] = $request->value;
        $company->save();
        return response()->json(["success" => true, "message" => $request->name . "Updated Succesfully"]);
    }
}
