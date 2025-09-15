<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CompanyStatusController extends Controller
{
    /**
     * Get company status for a specific order/company
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getCompanyStatus(Request $request): JsonResponse
    {
        try {
            // Get order ID from request
            $orderId = $request->input('order_id');
            $companyId = $request->input('company_id');
            $userId = $request->input('user_id');

            if (!$orderId && !$companyId && !$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order ID, Company ID, or User ID is required',
                    'data' => null
                ], 400);
            }

            $query = Order::with(['company', 'user']);

            if ($orderId) {
                $query->where('id', $orderId);
            } elseif ($companyId) {
                $query->where('company_id', $companyId);
            } elseif ($userId) {
                $query->where('user_id', $userId);
            }

            $order = $query->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found',
                    'data' => null
                ], 404);
            }

            // Map database fields to frontend labels
            $statusSteps = [
                [
                    'id' => 'name_availability_search',
                    'label' => 'Name Availability Search',
                    'status' => $order->name_availability_search_status ?? 'pending',
                    'order' => 1
                ],
                [
                    'id' => 'state_filing',
                    'label' => 'State Filing',
                    'status' => $order->state_filing_status ?? 'pending',
                    'order' => 2
                ],
                [
                    'id' => 'setup_business_address',
                    'label' => 'Registered Business Address',
                    'status' => $order->setup_business_address_status ?? 'pending',
                    'order' => 3
                ],
                [
                    'id' => 'mail_forwarding',
                    'label' => 'Mail Forwarding',
                    'status' => $order->mail_forwarding_status ?? 'pending',
                    'order' => 4
                ],
                [
                    'id' => 'ein_filing',
                    'label' => 'EIN',
                    'status' => $order->ein_filing_status ?? 'pending',
                    'order' => 5
                ],
                [
                    'id' => 'operating_agreement',
                    'label' => 'Operating Agreement',
                    'status' => $order->operating_agreement_status ?? 'pending',
                    'order' => 6
                ]
            ];

            // Calculate progress
            $completedSteps = collect($statusSteps)->where('status', 'complete')->count();
            $totalSteps = count($statusSteps);
            $progressPercentage = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;

            // Determine current step
            $currentStep = null;
            $currentStepIndex = -1;
            
            foreach ($statusSteps as $index => $step) {
                if ($step['status'] === 'processing') {
                    $currentStep = $step;
                    $currentStepIndex = $index;
                    break;
                } elseif ($step['status'] === 'complete') {
                    $currentStepIndex = $index;
                }
            }

            // Get next step
            $nextStep = null;
            if ($currentStepIndex >= 0 && $currentStepIndex < count($statusSteps) - 1) {
                $nextStep = $statusSteps[$currentStepIndex + 1];
            }

            return response()->json([
                'success' => true,
                'message' => 'Company status retrieved successfully',
                'data' => [
                    'order_id' => $order->id,
                    'company_id' => $order->company_id,
                    'company_name' => $order->company->company_name ?? null,
                    'user_id' => $order->user_id,
                    'customer_name' => $order->user ? $order->user->first_name . ' ' . $order->user->last_name : null,
                    'progress' => [
                        'percentage' => $progressPercentage,
                        'completed_steps' => $completedSteps,
                        'total_steps' => $totalSteps
                    ],
                    'current_step' => $currentStep,
                    'next_step' => $nextStep,
                    'steps' => $statusSteps,
                    'overall_status' => $order->complete_status ?? 'pending',
                    'payment_status' => $order->payment_status ?? 'pending',
                    'compliance_status' => $order->compliance_status ?? 'active',
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving company status: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Get all orders for a user
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserOrders(Request $request): JsonResponse
    {
        try {
            $userId = $request->input('user_id');
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User ID is required',
                    'data' => null
                ], 400);
            }

            $orders = Order::with(['company', 'user'])
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();

            $ordersData = $orders->map(function ($order) {
                $statusSteps = [
                    [
                        'id' => 'name_availability_search',
                        'label' => 'Name Availability Search',
                        'status' => $order->name_availability_search_status ?? 'pending'
                    ],
                    [
                        'id' => 'state_filing',
                        'label' => 'State Filing',
                        'status' => $order->state_filing_status ?? 'pending'
                    ],
                    [
                        'id' => 'setup_business_address',
                        'label' => 'Registered Business Address',
                        'status' => $order->setup_business_address_status ?? 'pending'
                    ],
                    [
                        'id' => 'mail_forwarding',
                        'label' => 'Mail Forwarding',
                        'status' => $order->mail_forwarding_status ?? 'pending'
                    ],
                    [
                        'id' => 'ein_filing',
                        'label' => 'EIN',
                        'status' => $order->ein_filing_status ?? 'pending'
                    ],
                    [
                        'id' => 'operating_agreement',
                        'label' => 'Operating Agreement',
                        'status' => $order->operating_agreement_status ?? 'pending'
                    ]
                ];

                $completedSteps = collect($statusSteps)->where('status', 'complete')->count();
                $totalSteps = count($statusSteps);
                $progressPercentage = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;

                return [
                    'order_id' => $order->id,
                    'company_id' => $order->company_id,
                    'company_name' => $order->company->company_name ?? null,
                    'progress_percentage' => $progressPercentage,
                    'overall_status' => $order->complete_status ?? 'pending',
                    'payment_status' => $order->payment_status ?? 'pending',
                    'compliance_status' => $order->compliance_status ?? 'active',
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'User orders retrieved successfully',
                'data' => [
                    'orders' => $ordersData,
                    'total_orders' => $ordersData->count()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving user orders: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
