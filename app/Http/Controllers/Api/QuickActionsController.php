<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class QuickActionsController extends Controller
{
    /**
     * Get quick actions for the authenticated user
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getQuickActions(Request $request): JsonResponse
    {
        try {
            $userId = $request->query('user_id');
            $companyId = $request->query('company_id');
            
            if (!$userId && !$companyId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User ID or Company ID is required',
                    'data' => null
                ], 400);
            }

            // Find the order for the user or company
            $query = Order::with(['company', 'user']);
            
            if ($companyId) {
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

            $quickActions = [];

            // 1. Renew US Business Address - Check business address status and renewal date
            $businessAddressStatus = $order->setup_business_address_status ?? 'pending';
            $renewalDate = $order->renewal_date ? Carbon::parse($order->renewal_date) : null;
            $today = Carbon::today();
            
            $status = 'Pending';
            $statusClass = 'bg-[#F3F4F6] text-[#7C8493]';
            $actionLabel = 'Renew Now';
            $actionEnabled = false;
            $daysUntilRenewal = null;
            $dueDate = '....';
            
            // First check the setup status
            if ($businessAddressStatus === 'pending') {
                $status = 'Pending';
                $statusClass = 'bg-[#F3F4F6] text-[#7C8493]';
                $actionLabel = 'Setup';
                $actionEnabled = false;
            } elseif ($businessAddressStatus === 'processing') {
                $status = 'Processing';
                $statusClass = 'bg-[#FEF6EE] text-[#DC6803]';
                $actionLabel = 'View Status';
                $actionEnabled = false;
            } elseif ($businessAddressStatus === 'complete') {
                // If complete, check renewal date
                if ($renewalDate) {
                    $daysUntilRenewal = $today->diffInDays($renewalDate, false);
                    $dueDate = $renewalDate->format('M d, Y');
                    
                    if ($daysUntilRenewal < 0) {
                        $status = 'Past Due';
                        $statusClass = 'bg-[#FEE4E2] text-[#D92D20]';
                        $actionEnabled = true;
                    } elseif ($daysUntilRenewal <= 30) {
                        $status = 'Due Soon';
                        $statusClass = 'bg-[#FEF6EE] text-[#DC6803]';
                        $actionEnabled = true;
                    } else {
                        $status = 'Active';
                        $statusClass = 'bg-[#D1FADF] text-[#039855]';
                        $actionEnabled = false;
                    }
                } else {
                    $status = 'Active';
                    $statusClass = 'bg-[#D1FADF] text-[#039855]';
                    $actionEnabled = false;
                }
            }
            
            $quickActions[] = [
                'id' => 1,
                'name' => 'Renew US Business Address',
                'due_date' => $dueDate,
                'status' => $status,
                'status_class' => $statusClass,
                'action_label' => $actionLabel,
                'action_enabled' => $actionEnabled,
                'action_type' => 'renew',
                'action_url' => null,
                'days_until_due' => $daysUntilRenewal
            ];

            // 2. Download EIN Letter - Check if EIN file exists
            if ($order->has_en) {
                $hasEinFile = !empty($order->en_file);
                $einStatus = $order->ein_filing_status ?? 'pending';
                
                $status = 'Pending';
                $statusClass = 'bg-[#F3F4F6] text-[#7C8493]';
                $actionLabel = 'View';
                $actionEnabled = false;
                $actionUrl = null;
                
                if ($hasEinFile && $einStatus === 'complete') {
                    $status = 'Complete';
                    $statusClass = 'bg-[#D1FADF] text-[#039855]';
                    $actionEnabled = true;
                    // Use direct storage URL
                    $actionUrl = url('storage/uploads/' . $order->en_file);
                } elseif ($einStatus === 'processing') {
                    $status = 'Processing';
                    $statusClass = 'bg-[#FEF6EE] text-[#DC6803]';
                }
                
                $quickActions[] = [
                    'id' => 2,
                    'name' => 'Download EIN Letter',
                    'due_date' => '....',
                    'status' => $status,
                    'status_class' => $statusClass,
                    'action_label' => $actionLabel,
                    'action_enabled' => $actionEnabled,
                    'action_type' => 'view',
                    'action_url' => $actionUrl,
                    'file_path' => $hasEinFile ? $order->en_file : null
                ];
            }

            // 3. Registered Agent Reminder - Check renewal date
            if ($order->renewal_date) {
                $renewalDate = Carbon::parse($order->renewal_date);
                $today = Carbon::today();
                $daysUntilRenewal = $today->diffInDays($renewalDate, false);
                
                $status = 'Pending';
                $statusClass = 'bg-[#F3F4F6] text-[#7C8493]';
                $actionLabel = 'Renew';
                $actionEnabled = false;
                
                if ($daysUntilRenewal <= 30 && $daysUntilRenewal > 0) {
                    $status = 'Due Soon';
                    $statusClass = 'bg-[#FEF6EE] text-[#DC6803]';
                    $actionEnabled = true;
                } elseif ($daysUntilRenewal < 0) {
                    $status = 'Past Due';
                    $statusClass = 'bg-[#FEE4E2] text-[#D92D20]';
                    $actionEnabled = true;
                } elseif ($order->compliance_status === 'active') {
                    $status = 'Active';
                    $statusClass = 'bg-[#D1FADF] text-[#039855]';
                }
                
                $quickActions[] = [
                    'id' => 3,
                    'name' => 'Registered Agent Reminder',
                    'due_date' => $renewalDate->format('M d, Y'),
                    'status' => $status,
                    'status_class' => $statusClass,
                    'action_label' => $actionLabel,
                    'action_enabled' => $actionEnabled,
                    'action_type' => 'renew',
                    'action_url' => null
                ];
            }

            // 5. Annual Filing Reminder - Check business filing date
            if ($order->business_filing_date) {
                $filingDate = Carbon::parse($order->business_filing_date);
                $today = Carbon::today();
                $daysUntilFiling = $today->diffInDays($filingDate, false);
                
                $status = 'Pending';
                $statusClass = 'bg-[#F3F4F6] text-[#7C8493]';
                $actionLabel = 'Schedule Filing';
                $actionEnabled = false;
                
                if ($daysUntilFiling <= 60 && $daysUntilFiling > 30) {
                    $status = 'Scheduled';
                    $statusClass = 'bg-[#EEF4FF] text-[#3538CD]';
                } elseif ($daysUntilFiling <= 30 && $daysUntilFiling > 0) {
                    $status = 'Due Soon';
                    $statusClass = 'bg-[#FEF6EE] text-[#DC6803]';
                    $actionEnabled = true;
                } elseif ($daysUntilFiling < 0) {
                    $status = 'Past Due';
                    $statusClass = 'bg-[#FEE4E2] text-[#D92D20]';
                    $actionEnabled = true;
                }
                
                $quickActions[] = [
                    'id' => 4,
                    'name' => 'Annual Filing Reminder',
                    'due_date' => $filingDate->format('M d, Y'),
                    'status' => $status,
                    'status_class' => $statusClass,
                    'action_label' => $actionLabel,
                    'action_enabled' => $actionEnabled,
                    'action_type' => 'schedule',
                    'action_url' => null,
                    'days_until_due' => $daysUntilFiling
                ];
            }

            // 6. Tax Filing Reminder - Use business filing date or calculate from incorporation date
            $taxFilingDate = null;
            if ($order->incorporation_date) {
                $incorporationDate = Carbon::parse($order->incorporation_date);
                // Tax filing is typically due on April 15th or the next year after incorporation
                $taxFilingDate = $incorporationDate->copy()->addYear()->month(4)->day(15);
                
                // If tax filing date has passed, move to next year
                if ($taxFilingDate->isPast()) {
                    $taxFilingDate = Carbon::now()->year($incorporationDate->year + 1)->month(4)->day(15);
                }
            } elseif ($order->business_filing_date) {
                $taxFilingDate = Carbon::parse($order->business_filing_date);
            }
            
            if ($taxFilingDate) {
                $today = Carbon::today();
                $daysUntilTaxFiling = $today->diffInDays($taxFilingDate, false);
                
                $status = 'Pending';
                $statusClass = 'bg-[#F3F4F6] text-[#7C8493]';
                $actionLabel = 'Start Processing';
                $actionEnabled = false;
                
                if ($daysUntilTaxFiling <= 30 && $daysUntilTaxFiling > 0) {
                    $status = 'Due Soon';
                    $statusClass = 'bg-[#FEF6EE] text-[#DC6803]';
                    $actionEnabled = true;
                } elseif ($daysUntilTaxFiling < 0) {
                    $status = 'Past Due';
                    $statusClass = 'bg-[#FEE4E2] text-[#D92D20]';
                    $actionEnabled = true;
                }
                
                $quickActions[] = [
                    'id' => 5,
                    'name' => 'Tax Filing Reminder',
                    'due_date' => $taxFilingDate->format('M d, Y'),
                    'status' => $status,
                    'status_class' => $statusClass,
                    'action_label' => $actionLabel,
                    'action_enabled' => $actionEnabled,
                    'action_type' => 'process',
                    'action_url' => null,
                    'days_until_due' => $daysUntilTaxFiling
                ];
            }

            // 7. Operating Agreement - Check if available for download
            if ($order->has_agreement) {
                $hasAgreementFile = !empty($order->agreement_file);
                $agreementStatus = $order->operating_agreement_status ?? 'pending';
                
                $status = 'Pending';
                $statusClass = 'bg-[#F3F4F6] text-[#7C8493]';
                $actionLabel = 'View';
                $actionEnabled = false;
                $actionUrl = null;
                
                if ($hasAgreementFile && $agreementStatus === 'complete') {
                    $status = 'Complete';
                    $statusClass = 'bg-[#D1FADF] text-[#039855]';
                    $actionEnabled = true;
                    // Use direct storage URL
                    $actionUrl = url('storage/uploads/' . $order->agreement_file);
                } elseif ($agreementStatus === 'processing') {
                    $status = 'Processing';
                    $statusClass = 'bg-[#FEF6EE] text-[#DC6803]';
                }
                
                $quickActions[] = [
                    'id' => 6,
                    'name' => 'Download Operating Agreement',
                    'due_date' => '....',
                    'status' => $status,
                    'status_class' => $statusClass,
                    'action_label' => $actionLabel,
                    'action_enabled' => $actionEnabled,
                    'action_type' => 'view',
                    'action_url' => $actionUrl,
                    'file_path' => $hasAgreementFile ? $order->agreement_file : null
                ];
            }

            // 7. Article of Organization - Check if available for download
            if ($order->article_of_organization_file && $order->state_filing_status === 'complete') {
                $quickActions[] = [
                    'id' => 7,
                    'name' => 'Download Article of Organization',
                    'due_date' => '....',
                    'status' => 'Complete',
                    'status_class' => 'bg-[#D1FADF] text-[#039855]',
                    'action_label' => 'View',
                    'action_enabled' => true,
                    'action_type' => 'view',
                    // Use direct storage URL
                    'action_url' => url('storage/uploads/' . $order->article_of_organization_file),
                    'file_path' => $order->article_of_organization_file
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Quick actions retrieved successfully',
                'data' => [
                    'quick_actions' => $quickActions,
                    'total_actions' => count($quickActions),
                    'order_id' => $order->id,
                    'company_id' => $order->company_id,
                    'company_name' => $order->company->company_name ?? null
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving quick actions: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}

