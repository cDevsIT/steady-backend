<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentsController extends Controller
{
    /**
     * Get documents for a specific user/order
     */
    public function getUserDocuments(Request $request)
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
            $query = Order::query();
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

            $documents = [];

            // Article of Organization - Available if state filing is complete
            if ($order->state_filing_status === 'complete' && $order->article_of_organization_file) {
                $documents[] = [
                    'id' => 1,
                    'name' => 'Article of Organization',
                    'icon' => '/client/formation-icon.svg',
                    'issuedDate' => $order->updated_at ? \Carbon\Carbon::parse($order->updated_at)->format('M d, Y') : 'N/A',
                    'status' => 'Available',
                    'statusColor' => 'bg-green-100 text-green-600',
                    'action' => 'Download',
                    'file_path' => asset('storage/uploads/' . $order->article_of_organization_file)
                ];
            }

            // Registered Agent & Business Address - Available if business address is complete
            if ($order->setup_business_address_status === 'complete' && $order->package_file) {
                $documents[] = [
                    'id' => 2,
                    'name' => 'Registered Agent & Business Address',
                    'icon' => '/client/registered-agent-agreement-icon.svg',
                    'issuedDate' => $order->updated_at ? \Carbon\Carbon::parse($order->updated_at)->format('M d, Y') : 'N/A',
                    'status' => 'Available',
                    'statusColor' => 'bg-green-100 text-green-600',
                    'action' => 'Download',
                    'file_path' => asset('storage/uploads/' . $order->package_file)
                ];
            }

            // EIN Document - Available if EIN filing is complete and EIN service is enabled
            if ($order->has_en && $order->ein_filing_status === 'complete' && $order->en_file) {
                $documents[] = [
                    'id' => 3,
                    'name' => 'EIN Confirmation Letter',
                    'icon' => '/client/ein-confirmation-letter-icon.svg',
                    'issuedDate' => $order->updated_at ? \Carbon\Carbon::parse($order->updated_at)->format('M d, Y') : 'N/A',
                    'status' => 'Available',
                    'statusColor' => 'bg-green-100 text-green-600',
                    'action' => 'Download',
                    'file_path' => asset('storage/uploads/' . $order->en_file)
                ];
            }

            // Operating Agreement - Available if operating agreement is complete and service is enabled
            if ($order->has_agreement && $order->operating_agreement_status === 'complete' && $order->agreement_file) {
                $documents[] = [
                    'id' => 4,
                    'name' => 'Operating Agreement',
                    'icon' => '/client/operation-agreement-icon.svg',
                    'issuedDate' => $order->updated_at ? \Carbon\Carbon::parse($order->updated_at)->format('M d, Y') : 'N/A',
                    'status' => 'Available',
                    'statusColor' => 'bg-green-100 text-green-600',
                    'action' => 'Download',
                    'file_path' => asset('storage/uploads/' . $order->agreement_file)
                ];
            }

            // Expedited Filing - Available if expedited service is enabled and processing is complete
            if ($order->has_processing && $order->processing_file) {
                $documents[] = [
                    'id' => 5,
                    'name' => 'Expedited Filing Receipt',
                    'icon' => '/client/expedited-filing-icon.svg',
                    'issuedDate' => $order->updated_at ? \Carbon\Carbon::parse($order->updated_at)->format('M d, Y') : 'N/A',
                    'status' => 'Available',
                    'statusColor' => 'bg-green-100 text-green-600',
                    'action' => 'Download',
                    'file_path' => asset('storage/uploads/' . $order->processing_file)
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Documents retrieved successfully',
                'data' => [
                    'documents' => $documents,
                    'total_count' => count($documents)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve documents: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Download a specific document
     */
    public function downloadDocument(Request $request, $orderId, $type)
    {
        try {
            $order = Order::findOrFail($orderId);
            
            $filePath = null;
            $fileName = null;

            switch ($type) {
                case 'article_of_organization':
                    if ($order->article_of_organization_file) {
                        $filePath = 'uploads/' . $order->article_of_organization_file;
                        $fileName = 'Article_of_Organization_' . $order->company_name . '.pdf';
                    }
                    break;
                case 'package':
                    if ($order->package_file) {
                        $filePath = 'uploads/' . $order->package_file;
                        $fileName = 'Registered_Agent_Agreement_' . $order->company_name . '.pdf';
                    }
                    break;
                case 'ein':
                    if ($order->en_file) {
                        $filePath = 'uploads/' . $order->en_file;
                        $fileName = 'EIN_Confirmation_Letter_' . $order->company_name . '.pdf';
                    }
                    break;
                case 'agreement':
                    if ($order->agreement_file) {
                        $filePath = 'uploads/' . $order->agreement_file;
                        $fileName = 'Operating_Agreement_' . $order->company_name . '.pdf';
                    }
                    break;
                case 'processing':
                    if ($order->processing_file) {
                        $filePath = 'uploads/' . $order->processing_file;
                        $fileName = 'Expedited_Filing_Receipt_' . $order->company_name . '.pdf';
                    }
                    break;
            }

            if (!$filePath) {
                return response()->json([
                    'success' => false,
                    'message' => 'Document not found or not available',
                    'data' => null
                ], 404);
            }

            if (Storage::exists($filePath)) {
                return Storage::download($filePath, $fileName);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found in storage',
                    'data' => null
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to download document: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Download file by filename with proper headers
     */
    public function downloadFile(Request $request, $filename)
    {
        try {
            // Try different possible paths
            $possiblePaths = [
                'uploads/' . $filename,
                'public/uploads/' . $filename,
                'storage/uploads/' . $filename,
                $filename
            ];
            
            $foundPath = null;
            foreach ($possiblePaths as $path) {
                if (Storage::exists($path)) {
                    $foundPath = $path;
                    break;
                }
            }
            
            if (!$foundPath) {
                // List files in uploads directory for debugging
                $files = Storage::files('uploads');
                $allFiles = Storage::allFiles();
                
                return response()->json([
                    'success' => false,
                    'message' => 'File not found',
                    'data' => [
                        'filename' => $filename,
                        'searched_paths' => $possiblePaths,
                        'uploads_files' => $files,
                        'all_files' => $allFiles
                    ]
                ], 404);
            }

            // Force download with proper headers
            return Storage::download($foundPath, $filename, [
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to download file: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
