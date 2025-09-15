<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       if (Auth::check()){
           if (Auth::user()->role == RoleEnum::ADMIN){
               return  redirect()->route('admin.dashboard');
           }elseif (Auth::user()->role == RoleEnum::CUSTOMER){
               return  redirect()->route('web.dashboard');
           }
       }
        abort(405);
        return view('home');
    }
}
