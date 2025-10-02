<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OwnerInfo;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OwnerDocumentsController extends Controller
{
    /**
     * Upload owner documents (passport copy and bank statement)
     */
    public function uploadDocuments(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'owner_id' => 'required|integer|exists:owner_infos,id',
                'scanned_passport_copy' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240', // 10MB max
                'bank_statement' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240', // 10MB max
            ]);

            $owner = OwnerInfo::findOrFail($request->owner_id);
            
            $uploadedFiles = [];

            // Handle passport copy upload
            if ($request->hasFile('scanned_passport_copy')) {
                $passportFile = $request->file('scanned_passport_copy');
                $passportFileName = 'owner_' . $owner->id . '_passport_' . time() . '.' . $passportFile->getClientOriginalExtension();
                $passportPath = $passportFile->storeAs('owner_documents', $passportFileName, 'public');
                
                // Delete old file if exists
                if ($owner->scanned_passport_copy && Storage::disk('public')->exists('owner_documents/' . $owner->scanned_passport_copy)) {
                    Storage::disk('public')->delete('owner_documents/' . $owner->scanned_passport_copy);
                }
                
                // Store only the filename, not the full path
                $owner->scanned_passport_copy = $passportFileName;
                $uploadedFiles['scanned_passport_copy'] = $passportPath;
            }

            // Handle bank statement upload
            if ($request->hasFile('bank_statement')) {
                $bankFile = $request->file('bank_statement');
                $bankFileName = 'owner_' . $owner->id . '_bank_' . time() . '.' . $bankFile->getClientOriginalExtension();
                $bankPath = $bankFile->storeAs('owner_documents', $bankFileName, 'public');
                
                // Delete old file if exists
                if ($owner->bank_statement && Storage::disk('public')->exists('owner_documents/' . $owner->bank_statement)) {
                    Storage::disk('public')->delete('owner_documents/' . $owner->bank_statement);
                }
                
                // Store only the filename, not the full path
                $owner->bank_statement = $bankFileName;
                $uploadedFiles['bank_statement'] = $bankPath;
            }

            $owner->save();

            Log::info('Owner documents uploaded successfully:', [
                'owner_id' => $owner->id,
                'uploaded_files' => $uploadedFiles,
                'database_values' => [
                    'scanned_passport_copy' => $owner->scanned_passport_copy,
                    'bank_statement' => $owner->bank_statement
                ]
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Documents uploaded successfully',
                'data' => [
                    'owner_id' => $owner->id,
                    'uploaded_files' => $uploadedFiles,
                    'database_values' => [
                        'scanned_passport_copy' => $owner->scanned_passport_copy,
                        'bank_statement' => $owner->bank_statement
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Owner document upload failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to upload documents: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get owner documents
     */
    public function getDocuments(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'owner_id' => 'required|integer|exists:owner_infos,id',
            ]);

            $owner = OwnerInfo::findOrFail($request->owner_id);
            
            $documents = [];
            
            if ($owner->scanned_passport_copy) {
                $passportPath = 'owner_documents/' . $owner->scanned_passport_copy;
                $documents['scanned_passport_copy'] = [
                    'filename' => $owner->scanned_passport_copy,
                    'url' => Storage::disk('public')->url($passportPath),
                    'path' => $passportPath
                ];
            }
            
            if ($owner->bank_statement) {
                $bankPath = 'owner_documents/' . $owner->bank_statement;
                $documents['bank_statement'] = [
                    'filename' => $owner->bank_statement,
                    'url' => Storage::disk('public')->url($bankPath),
                    'path' => $bankPath
                ];
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'owner_id' => $owner->id,
                    'documents' => $documents
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Get owner documents failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get documents: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all owners for a company
     */
    public function getCompanyOwners(Request $request, $companyId): JsonResponse
    {
        try {
            $owners = OwnerInfo::where('company_id', $companyId)
                ->select('id', 'name', 'email', 'company_id')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'owners' => $owners
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Get company owners failed:', [
                'error' => $e->getMessage(),
                'company_id' => $companyId,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get company owners: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create/update owners for a company
     */
    public function storeOwners(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'company_id' => 'required|integer|exists:companies,id',
                'owners' => 'required|array',
                'owners.*.name' => 'required|string',
                'owners.*.email' => 'required|email',
                'owners.*.phone' => 'required|string',
                'owners.*.ownership_percentage' => 'required|numeric|min:0|max:100',
                'owners.*.street_address' => 'required|string',
                'owners.*.city' => 'required|string',
                'owners.*.state' => 'required|string',
                'owners.*.zip_code' => 'required|string',
                'owners.*.country' => 'required|string',
            ]);

            $company = Company::findOrFail($request->company_id);

            DB::beginTransaction();

            try {
                // Delete existing owners for this company
                OwnerInfo::where('company_id', $company->id)->delete();

                // Create new owners
                $ownerIds = [];
                foreach ($request->owners as $ownerData) {
                    $owner = new OwnerInfo();
                    $owner->company_id = $company->id;
                    $owner->user_id = $company->user_id;
                    $owner->name = $ownerData['name'];
                    $owner->email = $ownerData['email'];
                    $owner->phone = $ownerData['phone'];
                    $owner->ownership_percentage = $ownerData['ownership_percentage'];
                    $owner->street_address = $ownerData['street_address'];
                    $owner->city = $ownerData['city'];
                    $owner->state = $ownerData['state'];
                    $owner->zip_code = $ownerData['zip_code'];
                    $owner->country = $ownerData['country'];
                    $owner->save();
                    $ownerIds[] = $owner->id;
                }

                DB::commit();

                Log::info('Owners created successfully:', [
                    'company_id' => $company->id,
                    'owner_ids' => $ownerIds,
                    'count' => count($ownerIds)
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Owners created successfully',
                    'data' => [
                        'company_id' => $company->id,
                        'owner_ids' => $ownerIds,
                        'count' => count($ownerIds)
                    ]
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Store owners failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store owners: ' . $e->getMessage()
            ], 500);
        }
    }
}
