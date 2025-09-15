<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\OwnersJob;
use App\Models\Company;
use App\Models\OwnerEmailLog;
use App\Models\OwnerInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyOwnerController extends Controller
{
    public function companyOwner(Request $request, Company $company)
    {
        $owners = OwnerInfo::where('company_id', $company->id)->get();
        return view('admin.companies.owners', compact('owners', 'company'));
    }

    public function ownerInfo(Request $request, OwnerInfo $owner)
    {
        $owner_email_logs = OwnerEmailLog::where('owner_id', $owner->id)->latest()->get();
        return view('admin.companies.email.sended_owner_email', compact('owner', 'owner_email_logs'));
    }

    public function ownerEmailSend(Request $request, OwnerInfo $owner)
    {
        $request->validate([
            'body' => 'required',
            'subject' => 'required|string',
        ]);
        $history = new OwnerEmailLog;
        $history->owner_id = $owner->id;
        $history->subject = $request->subject;
        $history->body = $request->body;
        $history->addedBy_id = Auth::id();
        $history->save();
        dispatch(new OwnersJob($owner, $history));
        return back()->with('success', 'Email Sending');
    }
}
