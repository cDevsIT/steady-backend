<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceFeature;
use App\Models\ServiceForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Set session for sidebar highlighting
            session(['lsbsm' => 'services']);
            
            $query = Service::with(['features', 'forms']);

            // Search functionality
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            // Filter by status
            if ($request->has('status') && $request->status) {
                if ($request->status === 'active') {
                    $query->where('is_active', true);
                } elseif ($request->status === 'inactive') {
                    $query->where('is_active', false);
                }
            }

            // Filter by visibility
            if ($request->has('visibility') && $request->visibility) {
                if ($request->visibility === 'visible') {
                    $query->where('visible_on_funnel', true);
                } elseif ($request->visibility === 'hidden') {
                    $query->where('visible_on_funnel', false);
                }
            }

            $services = $query->orderBy('created_at', 'desc')->paginate(10);

            // Calculate statistics
            $stats = [
                'total_services' => Service::count(),
                'active_services' => Service::where('is_active', true)->count(),
                'inactive_services' => Service::where('is_active', false)->count(),
                'funnel_visible' => Service::where('visible_on_funnel', true)->count(),
                'transferable' => Service::where('is_transferable', true)->count(),
                'renewable' => Service::where('is_renewable', true)->count(),
                'state_fees' => Service::where('requires_state_fees', true)->count(),
            ];

            // Calculate revenue overview (simplified for current database structure)
            $revenueStats = [
                'total_value' => Service::sum('initial_price'),
                'avg_price' => Service::avg('initial_price'),
                'renewal_value' => Service::where('is_renewable', true)->sum('renewal_fee'),
            ];

            // Service distribution
            $distributionStats = [
                'transferable' => Service::where('is_transferable', true)->count(),
                'renewable' => Service::where('is_renewable', true)->count(),
                'state_fees' => Service::where('requires_state_fees', true)->count(),
            ];

            return view('admin.services.index', compact('services', 'stats', 'revenueStats', 'distributionStats'));
        } catch (\Exception $e) {
            Log::error('Error fetching services: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error fetching services data.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Set session for sidebar highlighting
        session(['lsbsm' => 'services']);
        
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'initial_price' => 'required|numeric|min:0',
            'renewal_fee' => 'nullable|numeric|min:0',
            'transfer_fee' => 'nullable|numeric|min:0',
            'renewal_period' => 'nullable|integer|min:0',
            'purchase_type' => 'required|string|in:direct,funnel,both',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'forms' => 'nullable|array',
            'forms.*.form_type' => 'required|string',
            'forms.*.title' => 'required|string|max:255',
            'forms.*.description' => 'nullable|string',
            'forms.*.icon' => 'nullable|string',
            'forms.*.is_required' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            // Create service
            $service = Service::create([
                'name' => $request->name,
                'description' => $request->description,
                'initial_price' => $request->initial_price,
                'renewal_fee' => $request->renewal_fee ?? 0,
                'transfer_fee' => $request->transfer_fee ?? 0,
                'renewal_period' => $request->renewal_period ?? 12,
                'purchase_type' => $request->purchase_type,
                'is_active' => $request->has('is_active'),
                'is_renewable' => $request->has('is_renewable'),
                'auto_renewal' => $request->has('auto_renewal'),
                'visible_on_funnel' => $request->has('visible_on_funnel'),
                'is_transferable' => $request->has('is_transferable'),
                'requires_state_selection' => $request->has('requires_state_selection'),
                'requires_state_fees' => $request->has('requires_state_fees'),
                'is_for_address' => $request->has('is_for_address'),
                'last_updated_by' => auth()->id(),
            ]);

            // Add features
            if ($request->has('features') && is_array($request->features)) {
                foreach ($request->features as $feature) {
                    if (!empty($feature)) {
                        ServiceFeature::create([
                            'service_id' => $service->id,
                            'feature' => $feature,
                        ]);
                    }
                }
            }

            // Add forms
            if ($request->has('forms') && is_array($request->forms)) {
                foreach ($request->forms as $form) {
                    if (!empty($form['form_type']) && !empty($form['title'])) {
                        ServiceForm::create([
                            'service_id' => $service->id,
                            'form_type' => $form['form_type'],
                            'title' => $form['title'],
                            'description' => $form['description'] ?? null,
                            'icon' => $form['icon'] ?? null,
                            'is_required' => $form['is_required'] ?? true,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating service: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating service.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        // Set session for sidebar highlighting
        session(['lsbsm' => 'services']);
        
        $service->load(['features', 'forms']);
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        // Set session for sidebar highlighting
        session(['lsbsm' => 'services']);
        
        $service->load(['features', 'forms']);
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'initial_price' => 'required|numeric|min:0',
            'renewal_fee' => 'nullable|numeric|min:0',
            'transfer_fee' => 'nullable|numeric|min:0',
            'renewal_period' => 'nullable|integer|min:0',
            'purchase_type' => 'required|string|in:direct,funnel,both',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'forms' => 'nullable|array',
            'forms.*.form_type' => 'required|string',
            'forms.*.title' => 'required|string|max:255',
            'forms.*.description' => 'nullable|string',
            'forms.*.icon' => 'nullable|string',
            'forms.*.is_required' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            // Update service
            $service->update([
                'name' => $request->name,
                'description' => $request->description,
                'initial_price' => $request->initial_price,
                'renewal_fee' => $request->renewal_fee ?? 0,
                'transfer_fee' => $request->transfer_fee ?? 0,
                'renewal_period' => $request->renewal_period ?? 12,
                'purchase_type' => $request->purchase_type,
                'is_active' => $request->has('is_active'),
                'is_renewable' => $request->has('is_renewable'),
                'auto_renewal' => $request->has('auto_renewal'),
                'visible_on_funnel' => $request->has('visible_on_funnel'),
                'is_transferable' => $request->has('is_transferable'),
                'requires_state_selection' => $request->has('requires_state_selection'),
                'requires_state_fees' => $request->has('requires_state_fees'),
                'is_for_address' => $request->has('is_for_address'),
                'last_updated_by' => auth()->id(),
            ]);

            // Update features
            $service->features()->delete();
            if ($request->has('features') && is_array($request->features)) {
                foreach ($request->features as $feature) {
                    if (!empty($feature)) {
                        ServiceFeature::create([
                            'service_id' => $service->id,
                            'feature' => $feature,
                        ]);
                    }
                }
            }

            // Update forms
            $service->forms()->delete();
            if ($request->has('forms') && is_array($request->forms)) {
                foreach ($request->forms as $form) {
                    if (!empty($form['form_type']) && !empty($form['title'])) {
                        ServiceForm::create([
                            'service_id' => $service->id,
                            'form_type' => $form['form_type'],
                            'title' => $form['title'],
                            'description' => $form['description'] ?? null,
                            'icon' => $form['icon'] ?? null,
                            'is_required' => $form['is_required'] ?? true,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.services.show', $service)->with('success', 'Service updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating service: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating service.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        try {
            $service->delete();
            return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting service: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error deleting service.');
        }
    }

    /**
     * Toggle service status
     */
    public function toggleStatus(Service $service)
    {
        try {
            $service->update(['is_active' => !$service->is_active]);
            $status = $service->is_active ? 'activated' : 'deactivated';
            return redirect()->back()->with('success', "Service {$status} successfully.");
        } catch (\Exception $e) {
            Log::error('Error toggling service status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating service status.');
        }
    }

    /**
     * Toggle funnel visibility
     */
    public function toggleVisibility(Service $service)
    {
        try {
            $service->update(['visible_on_funnel' => !$service->visible_on_funnel]);
            $status = $service->visible_on_funnel ? 'shown' : 'hidden';
            return redirect()->back()->with('success', "Service {$status} on funnel successfully.");
        } catch (\Exception $e) {
            Log::error('Error toggling service visibility: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating service visibility.');
        }
    }
}