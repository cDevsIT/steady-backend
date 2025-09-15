<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transition;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TransitionsController extends Controller
{
    public function transitions(Request $request)
    {
        menuSubmenu("transitions", 'transitions');
        $paginate = 50;
        $query = Transition::orderBy('created_at', 'desc');
        if ($request->order) {
            $query->whereHas('order', function ($q) use ($request) {
                $q->where('id', $request->order);
            });
        }
        if ($request->from_date && $request->to_date) {
            $startDate = Carbon::parse($request->from_date)->startOfDay();
            $endDate = Carbon::parse($request->to_date)->startOfDay();
            $query = $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($request->from_date) {
            $startDate = Carbon::parse($request->from_date)->startOfDay();
            $query = $query->whereDate('created_at', $startDate);
        }
        if ($request->search) {
            $query->where('id', $request->search);
        }

        if ($request->payment_method) {
            if ($request->payment_method == 'PayPal') {
                $query->where('payment_method', 'PayPal');
            } elseif ($request->payment_method == 'Stripe') {
                $query->where('payment_method', 'Stripe');
            } else {
                $query->where('payment_method', "!=", "PayPal")
                    ->where('payment_method', "!=", "Stripe");
            }
        }

        if ($request->submit_type == 'csv') {
            $transitions = $query->get();
            // Create CSV file content
            $csvData = [];
            $csvData[] = ['ID', 'DateTime', 'OrderID', 'Company name', 'Charge ID', 'Payment Method	', 'Payment By', 'Amount', 'Payment Status'];
            foreach ($transitions as $transition) {
                $csvData[] = [
                    $transition->id,
                    $transition->created_at,
                    $transition->order ? $transition->order->id : '',
                    $transition->company ? $transition->company->company_name : '',
                    $transition->charge_id,
                    $transition->payment_method,
                    $transition->player_name,
                    $transition->amount,
                    $transition->status,

                ];
            }

            // Generate CSV file

            $filename = "transition_" . date('Y-m-d_H-i-s') . ".csv";
            if ($request->daterange) {
                $filename = "transition_" . $request->daterange . ".csv";
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

        $transitions = $query->paginate($paginate);
        return view('admin.transitions.transitions', compact('transitions'))->with('i', ($request->input('page', 1) - 1) * $paginate);

    }
}
