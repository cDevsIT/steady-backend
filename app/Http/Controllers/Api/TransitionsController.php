<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransitionsController extends Controller
{
    /**
     * Get payment history (transitions) for a user or company
     * Params: company_id? user_id? page? per_page?
     */
    public function getUserTransitions(Request $request)
    {
        try {
            $authUser = Auth::user();
            $userId = $request->query('user_id');
            $companyId = $request->query('company_id');
            $perPage = (int) $request->query('per_page', 20);

            // If neither provided and no auth, return empty success
            if (!$userId && !$companyId && !$authUser) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No selector provided',
                    'data' => [
                        'history' => [],
                        'pagination' => [
                            'current_page' => 1,
                            'last_page' => 1,
                            'per_page' => $perPage,
                            'total' => 0,
                        ],
                    ],
                ]);
            }

            // Default to authenticated user if no explicit selector but auth exists
            if (!$userId && !$companyId && $authUser) {
                $userId = $authUser->id;
            }

            $query = Transition::with(['company', 'user'])
                ->orderBy('created_at', 'desc');

            if ($companyId) {
                $query->where('company_id', $companyId);
            } elseif ($userId) {
                $query->where('user_id', $userId);
            }

            $paginator = $query->paginate($perPage);

            // Map to frontend-friendly structure
            $items = $paginator->items();
            $history = array_map(function ($tr) {
                $status = strtoupper($tr->status);
                $mappedStatus = $status === 'COMPLETED' ? 'Paid' : ($status === 'PENDING' ? 'Pending' : 'Fail');
                $statusColor = $mappedStatus === 'Paid' ? 'bg-green-100 text-green-600'
                    : ($mappedStatus === 'Pending' ? 'bg-gray-100 text-gray-500' : 'bg-red-100 text-red-500');

                return [
                    'id' => $tr->id,
                    'date' => date('M d, Y', strtotime($tr->created_at)),
                    'description' => $tr->company ? ('Company Payment (' . $tr->company->company_name . ')') : 'Company Payment',
                    'amount' => '$' . number_format((float) $tr->amount, 2),
                    'status' => $mappedStatus,
                    'statusColor' => $statusColor,
                    'action' => $mappedStatus === 'Paid' ? 'Download PDF' : ($mappedStatus === 'Pending' ? 'Pay Now' : 'Retry Payment'),
                    'actionType' => $mappedStatus === 'Paid' ? 'download' : ($mappedStatus === 'Pending' ? 'pay' : 'retry'),
                    // Additional fields for modal/invoice
                    'invoiceId' => 'INV ' . str_pad($tr->id, 4, '0', STR_PAD_LEFT),
                    'transactionId' => $tr->charge_id,
                    'paymentMethod' => $tr->payment_method,
                    'userEmail' => optional($tr->user)->email,
                    'userId' => optional($tr->user)->id,
                    'companyName' => optional($tr->company)->company_name,
                    'entityType' => optional($tr->company)->business_type,
                    'billingName' => $tr->player_name,
                ];
            }, $items);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment history retrieved',
                'data' => [
                    'history' => $history,
                    'pagination' => [
                        'current_page' => $paginator->currentPage(),
                        'last_page' => $paginator->lastPage(),
                        'per_page' => $paginator->perPage(),
                        'total' => $paginator->total(),
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get payment history: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }
}


