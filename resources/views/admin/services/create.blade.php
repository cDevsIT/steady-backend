@extends('admin.layouts.master')
@push('title')
    Create New Service
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern mb-2">Create New Service</h1>
                    <p class="page-subtitle-modern">Define a new service for your business formation platform</p>
                </div>
                <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary-modern">
                    <i class="fas fa-arrow-left me-2"></i> Service List
                </a>
            </div>
        </div>

        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Main Form -->
                <div class="col-lg-8">
                    <!-- Service Details -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-transparent border-0 py-3">
                            <h5 class="card-title-modern mb-0">Service Details</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Service Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    <div class="form-text">Enter a descriptive name for this service.</div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="initial_price" class="form-label">Initial Price ($)</label>
                                    <input type="number" step="0.01" min="0" 
                                           class="form-control @error('initial_price') is-invalid @enderror" 
                                           id="initial_price" name="initial_price" value="{{ old('initial_price') }}" required>
                                    <div class="form-text">Enter the initial service price in dollars.</div>
                                    @error('initial_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="renewal_fee" class="form-label">Renewal Fee ($)</label>
                                    <input type="number" step="0.01" min="0" 
                                           class="form-control @error('renewal_fee') is-invalid @enderror" 
                                           id="renewal_fee" name="renewal_fee" value="{{ old('renewal_fee', 0) }}">
                                    <div class="form-text">Enter the renewal fee in dollars (if applicable).</div>
                                    @error('renewal_fee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="transfer_fee" class="form-label">Transfer Fee ($)</label>
                                    <input type="number" step="0.01" min="0" 
                                           class="form-control @error('transfer_fee') is-invalid @enderror" 
                                           id="transfer_fee" name="transfer_fee" value="{{ old('transfer_fee', 0) }}">
                                    <div class="form-text">Enter the transfer fee in dollars (if applicable).</div>
                                    @error('transfer_fee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="renewal_period" class="form-label">Renewal Period (months)</label>
                                    <input type="number" min="0" 
                                           class="form-control @error('renewal_period') is-invalid @enderror" 
                                           id="renewal_period" name="renewal_period" value="{{ old('renewal_period', 12) }}">
                                    <div class="form-text">Enter the renewal period in months (0 for no renewal).</div>
                                    @error('renewal_period')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="purchase_type" class="form-label">Service Purchase Type</label>
                                    <select class="form-select @error('purchase_type') is-invalid @enderror" 
                                            id="purchase_type" name="purchase_type" required>
                                        <option value="">-- Select an option --</option>
                                        <option value="direct" {{ old('purchase_type') == 'direct' ? 'selected' : '' }}>Direct Purchase</option>
                                        <option value="funnel" {{ old('purchase_type') == 'funnel' ? 'selected' : '' }}>In Funnel</option>
                                        <option value="both" {{ old('purchase_type') == 'both' ? 'selected' : '' }}>Both</option>
                                    </select>
                                    <div class="form-text">How will this service be purchased?</div>
                                    @error('purchase_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                    <div class="form-text">Provide details about this service (what's included, benefits, etc.).</div>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-transparent border-0 py-3">
                            <h5 class="card-title-modern mb-0">Features</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <button type="button" class="btn btn-outline-primary-modern btn-sm" id="addFeature">
                                    <i class="fas fa-plus me-2"></i> Add Feature
                                </button>
                                <small class="text-muted ms-3">Add key features included in this service.</small>
                            </div>
                            <div id="featuresContainer">
                                @if(old('features'))
                                    @foreach(old('features') as $index => $feature)
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="features[]" 
                                                   value="{{ $feature }}" placeholder="Enter feature">
                                            <button type="button" class="btn btn-outline-danger remove-feature">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Service Options -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-0 py-3">
                            <h5 class="card-title-modern mb-0">Service Options</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Active Status</label>
                                        <div class="form-text">Enable this option to make the service active and available for use.</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_renewable" name="is_renewable" 
                                               {{ old('is_renewable') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_renewable">Renewable</label>
                                        <div class="form-text">Enable this option if this service can be renewed.</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="auto_renewal" name="auto_renewal" 
                                               {{ old('auto_renewal') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="auto_renewal">Auto Renewal</label>
                                        <div class="form-text">Enable this option if this service should be automatically renewed.</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="visible_on_funnel" name="visible_on_funnel" 
                                               {{ old('visible_on_funnel') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="visible_on_funnel">Visible On Funnel</label>
                                        <div class="form-text">Enable this option to show this service in the sales funnel.</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_transferable" name="is_transferable" 
                                               {{ old('is_transferable') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_transferable">Transferable</label>
                                        <div class="form-text">Enable this option if this service can be transferred.</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="requires_state_selection" name="requires_state_selection" 
                                               {{ old('requires_state_selection') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="requires_state_selection">Requires State Selection</label>
                                        <div class="form-text">Enable this option if the service requires state selection.</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="requires_state_fees" name="requires_state_fees" 
                                               {{ old('requires_state_fees') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="requires_state_fees">Requires State Fees</label>
                                        <div class="form-text">Enable this option if this service requires additional state fees.</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_for_address" name="is_for_address" 
                                               {{ old('is_for_address') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_for_address">Is this for address?</label>
                                        <div class="form-text">Enable this option if this service is related to address.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 2rem;">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary-modern">
                                        <i class="fas fa-save me-2"></i>Create Service
                                    </button>
                                    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary-modern">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing features functionality');
        
        // Add feature functionality
        const addFeatureBtn = document.getElementById('addFeature');
        const featuresContainer = document.getElementById('featuresContainer');

        if (!addFeatureBtn) {
            console.error('Add feature button not found');
            return;
        }

        if (!featuresContainer) {
            console.error('Features container not found');
            return;
        }

        console.log('Elements found, adding event listeners');

        addFeatureBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Add feature button clicked');
            
            const featureHtml = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="features[]" placeholder="Enter feature">
                    <button type="button" class="btn btn-outline-danger remove-feature">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            featuresContainer.insertAdjacentHTML('beforeend', featureHtml);
            console.log('Feature input added');
        });

        // Remove feature functionality
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-feature') || e.target.parentElement.classList.contains('remove-feature')) {
                e.preventDefault();
                console.log('Remove feature clicked');
                const featureGroup = e.target.closest('.input-group');
                if (featureGroup) {
                    featureGroup.remove();
                    console.log('Feature removed');
                }
            }
        });
    });
</script>
@endpush
