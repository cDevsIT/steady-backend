<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * Return services for direct purchase.
     */
    public function index(Request $request): JsonResponse
    {
        $services = Service::with('features')
            ->whereIn('purchase_type', ['direct', 'both'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function (Service $service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'description' => $service->description,
                    'initial_price' => $service->initial_price,
                    'features' => $service->features->map(function ($feature) {
                        return [
                            'text' => $feature->feature,
                            'included' => true,
                        ];
                    })->values(),
                ];
            });

        return response()->json([
            'data' => $services,
        ]);
    }
}
