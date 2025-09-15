<?php
$activeCompany = session('active_company_id');
$company = \App\Models\Company::where("id", $activeCompany)->where('user_id', \Illuminate\Support\Facades\Auth::id())->first();
if (!$company){
    $company = \App\Models\Company::where("user_id", \Illuminate\Support\Facades\Auth::id())->latest()->first();

}

$companies =  \App\Models\Company::where('user_id', \Illuminate\Support\Facades\Auth::id())->select('company_name', 'business_type', 'id')->orderBy('created_at', 'DESC')->get();
?>
<style>
    select#company{
        background: gray;
        color: #fff;
    }
</style>

<div class="left-sidebar d-flex flex-column flex-shrink-0 p-3 bg-light active" id="left-sidebar">
    <div class="mt-3">
        <select name="" id="company" class="company nav-link" >
            @foreach($companies as $company)
                <option {{session('active_company_id') == $company->id ? "selected" : ''}} data-route="{{route('web.companies',$company)}}" value="{{$company->id}}">{{$company->company_name}} {{$company->business_type}}</option>
            @endforeach
        </select>
    </div>

    <ul class="nav nav-pills flex-column mb-auto ">

        <li class="nav-item">

            @if(auth()->user()->role == 1)
                <a style="background: gray; color: #fff;" class="nav-link" href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>
            @else
                <a style="background: gray; color: #fff;" class="nav-link" href="{{ route('web.dashboard') }}">
                    Dashboard
                </a>
            @endif

{{--            <a style="background: gray; color: #fff;" href="{{route('web.tickets',session('active_company_id'))}}" class="nav-link {{ session('lsbm') == 'tickets' ? ' menu-open ' : '' }}" aria-current="page">--}}
{{--                <i class="bi bi-house-door-fill"></i>--}}
{{--                Tickets--}}
{{--            </a>--}}
        </li>

        <li class="nav-item">
            <a style="background: gray; color: #fff;" href="{{route('web.tickets',session('active_company_id'))}}" class="nav-link {{ session('lsbm') == 'tickets' ? ' menu-open ' : '' }}" aria-current="page">
                <i class="bi bi-house-door-fill"></i>
                Tickets
            </a>
        </li>

    </ul>
</div>
