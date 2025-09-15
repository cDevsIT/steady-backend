<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StateFee;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StateFeeController extends Controller
{
    /**
     * Get state fees by field name
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getFeesByField(Request $request): JsonResponse
    {
        // Validate the request
        $request->validate([
            'field_name' => 'required|string|in:fees,renewal_fee,transfer_fee'
        ]);

        $fieldName = $request->input('field_name');
        
        // Get states with the specified fee field, excluding zero/null values
        $stateFees = StateFee::select('state_name', $fieldName)
            ->whereNotNull($fieldName)
            ->where($fieldName, '>', 0)
            ->orderBy('state_name')
            ->get();

        // Format the response
        $formattedFees = $stateFees->map(function ($state) use ($fieldName) {
            return [
                'state_name' => $state->state_name,
                'fee' => (float) $state->$fieldName
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'State fees retrieved successfully',
            'data' => [
                'field_name' => $fieldName,
                'total_states' => $formattedFees->count(),
                'states' => $formattedFees
            ]
        ]);
    }

    /**
     * Get all fee types for all states
     * 
     * @return JsonResponse
     */
    public function getAllFees(): JsonResponse
    {
        $stateFees = StateFee::select('state_name', 'fees', 'renewal_fee', 'transfer_fee')
            ->orderBy('state_name')
            ->get();

        $formattedFees = $stateFees->map(function ($state) {
            return [
                'state_name' => $state->state_name,
                'fees' => [
                    'registration_fee' => (float) $state->fees,
                    'renewal_fee' => (float) $state->renewal_fee,
                    'transfer_fee' => (float) $state->transfer_fee
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'All state fees retrieved successfully',
            'data' => [
                'total_states' => $formattedFees->count(),
                'states' => $formattedFees
            ]
        ]);
    }

    /**
     * Get fees for a specific state
     * 
     * @param string $stateName
     * @return JsonResponse
     */
    public function getFeesByState(string $stateName): JsonResponse
    {
        $stateFee = StateFee::where('state_name', $stateName)
            ->select('state_name', 'fees', 'renewal_fee', 'transfer_fee')
            ->first();

        if (!$stateFee) {
            return response()->json([
                'success' => false,
                'message' => 'State not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'State fees retrieved successfully',
            'data' => [
                'state_name' => $stateFee->state_name,
                'fees' => [
                    'registration_fee' => (float) $stateFee->fees,
                    'renewal_fee' => (float) $stateFee->renewal_fee,
                    'transfer_fee' => (float) $stateFee->transfer_fee
                ]
            ]
        ]);
    }
}






