<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrimaryContact;
use App\Models\StateFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class PrimaryContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        menuSubmenu('primaryContact', 'primaryContact');
    
        $paginate = 50;
    
        // Start building the query
        $query = PrimaryContact::query();
    
        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('phone_number', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$search}%"]);
            });
        }
    
        // Filter by from_date and to_date
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        } elseif ($request->filled('from_date')) {
            $query->whereDate('created_at', $request->from_date);
        } elseif ($request->filled('to_date')) {
            $query->whereDate('created_at', $request->to_date);
        }

        // Sort functionality
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->orderBy('created_at', 'ASC');
                    break;
                case 'name':
                    $query->orderBy('first_name', 'ASC')->orderBy('last_name', 'ASC');
                    break;
                case 'latest':
                default:
                    $query->orderBy('created_at', 'DESC');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'DESC'); // Default sort
        }
        
        $submitType = $request->query('submit_type', 'search');
        
        if($submitType == 'csv') {
            $contacts = $query->get();
            $csvData = [];
            $csvData[] = ['ID', 'Created At', 'Name', 'Email', 'Phone'];

            foreach ($contacts as $contact) {
                $csvData[] = [
                    $contact->id,
                    $contact->created_at,
                    $contact->first_name ." ".$contact->last_name,
                    $contact->email,
                    $contact->phone_number,
                ];
            }

            // Generate CSV file
            $filename = "Try_to_register_list_" . date('Y-m-d_H-i-s') . ".csv";
            
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $filename = "Try_to_register_list_" . $request->from_date."-".$request->to_date. ".csv";
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
    
        $contacts = $query->paginate($paginate);
    
        return view('admin.primaryContact.primaryContact', compact('contacts'))
            ->with('i', ($request->input('page', 1) - 1) * $paginate);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'state_name' => 'required|unique:state_fees,state_name',
            'state_fees' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = implode(' ', $errors);
            return redirect()->back()->with('error',$errorMessage);
        }
       $fee = new StateFee;
       $fee->state_name = $request->state_name;
       $fee->fees = $request->state_fees;
       $fee->addedBy = Auth::id();
       $fee->save();

       return redirect()->back()->with('success',"State Fees Added");


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $fee= StateFee::find($id);
        if (!$fee) {
            return redirect()->back()->with('error',"Fees not found");
        }
        $validator = Validator::make($request->all(), [
            'state_name' => 'required|unique:state_fees,state_name,'.$fee->id,
            'state_fees' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = implode(' ', $errors);
            return redirect()->back()->with('error',$errorMessage);
        }

        $fee->state_name = $request->state_name;
        $fee->fees = $request->state_fees;
        $fee->editedBy = Auth::id();
        $fee->save();

        return redirect()->back()->with('success',"State Fees Updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
