<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StateFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StateFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        menuSubmenu('fees', 'fees');
        $paginate = 50;
        $fees = StateFee::latest()->paginate($paginate);
        return view('admin.fees.fees', compact('fees'))->with('i', ($request->input('page', 1) - 1) * $paginate);
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
            'fees' => 'nullable|numeric',
            'renewal_fee' => 'nullable|numeric',
            'transfer_fee' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = implode(' ', $errors);
            return redirect()->back()->with('error',$errorMessage);
        }
       $fee = new StateFee;
       $fee->state_name = $request->state_name;
       $fee->fees = $request->fees ?? 0;
       $fee->renewal_fee = $request->renewal_fee ?? 0;
       $fee->transfer_fee = $request->transfer_fee ?? 0;
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
            'fees' => 'nullable|numeric',
            'renewal_fee' => 'nullable|numeric',
            'transfer_fee' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = implode(' ', $errors);
            return redirect()->back()->with('error',$errorMessage);
        }

        $fee->state_name = $request->state_name;
        $fee->fees = $request->fees ?? 0;
        $fee->renewal_fee = $request->renewal_fee ?? 0;
        $fee->transfer_fee = $request->transfer_fee ?? 0;
        $fee->editedBy = Auth::id();
        $fee->save();

        return redirect()->back()->with('success',"State Fees Updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fee = StateFee::find($id);
        if (!$fee) {
            return redirect()->back()->with('error', "State fee not found");
        }

        try {
            $fee->delete();
            return redirect()->back()->with('success', "State fee deleted successfully");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Failed to delete state fee. Please try again.");
        }
    }
}
