<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use App\Models\StateFee;
use App\Models\Ticket;
use App\Models\Transition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        menuSubmenu("dashboard", 'dashboard');
        $customerCount = User::where("role", 2)->count();
        $adminCount = User::where("role", 1)->count();
        $companyCount = Company::count();
        $orderCount = Order::count();
        $transactionCount = Transition::count();
        $totalState = StateFee::count();
        $openTickets = Ticket::where('status','open')->count();
        $closedTickets = Ticket::where('status','close')->count();
        $year = date('Y'); // Current year
        $month = date('m'); // Current month

        // Get the total number of days in the month
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Generate all days of the month
        $allDays = [];
        for ($day = 1; $day <= $totalDays; $day++) {
            $allDays[] = sprintf('%04d-%02d-%02d', $year, $month, $day);
        }

        // Fetch transaction data
        $transactions = DB::table('transitions')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('date')
            ->pluck('total', 'date'); // Get totals indexed by date

        // Prepare the chart data
        $transactionChartData = [
            'dates' => $allDays,
            'totals' => array_map(function($date) use ($transactions) {
                return $transactions[$date] ?? 0; // Default to 0 if no transactions for that day
            }, $allDays)
        ];


        return view('admin.dashboard', compact('customerCount', 'adminCount', 'companyCount', 'orderCount', 'transactionCount','totalState', 'openTickets', 'closedTickets','transactionChartData'));
    }

}
