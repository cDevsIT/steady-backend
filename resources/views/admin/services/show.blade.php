@extends('admin.layouts.master')
@push('title')
    {{ $service->name }} - Service Details & Configuration
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern mb-2">{{ $service->name }}</h1>
                    <p class="page-subtitle-modern">Service Details & Configuration</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary-modern">
                        <i class="fas fa-arrow-left me-2"></i>Back to Services
                    </a>
                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-primary-modern">
                        <i class="fas fa-edit me-2"></i>Edit Service
                    </a>
                </div>
            </div>
        </div>

        <!-- Service Status and Pricing Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-4">
                    <span class="badge bg-{{ $service->status_badge }} fs-6 px-4 py-3">
                        <i class="fas fa-check-circle me-2"></i>{{ $service->status }}
                    </span>
                        <div class="d-flex justify-content-between gap-3 flex-grow-1">
                            <div class="text-center">
                                <small class="text-muted mb-1">Initial Price</small>
                                <div class="fw-semibold">${{ number_format($service->initial_price, 2) }}</div>
                            </div>
                            <div class="text-center">
                                <small class="text-muted mb-1">Renewal Fee</small>
                                <div class="fw-semibold">${{ number_format($service->renewal_fee, 2) }}</div>
                            </div>
                            <div class="text-center">
                                <small class="text-muted mb-1">Transfer Fee</small>
                                <div class="fw-semibold">${{ number_format($service->transfer_fee, 2) }}</div>
                            </div>
                            <div class="text-center">
                                <small class="text-muted mb-1">Renewal Period</small>
                                <div class="fw-semibold">12 months</div>
                            </div>
                            <div class="text-center">
                                <small class="text-muted mb-1">Auto Renewal</small>
                                <span class="badge bg-secondary">{{ $service->auto_renewal ? 'Enabled' : 'Disabled' }}</span>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Service Overview -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h6 class="card-title-modern mb-0">
                            <i class="fas fa-info-circle me-2"></i>Service Overview
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Service Name:</small>
                                    <small class="fw-semibold">{{ $service->name }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Last Updated:</small>
                                    <small class="fw-semibold">{{ $service->updated_at->format('M d, Y h:i A') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Created Date:</small>
                                    <small class="fw-semibold">{{ $service->created_at->format('M d, Y h:i A') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Service Status:</small>
                                    <span class="badge bg-secondary">{{ $service->status }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Funnel Visibility:</small>
                                    <span class="badge bg-secondary">{{ $service->visibility_text }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Requires State Fees:</small>
                                    <span class="badge bg-secondary">
                                        {{ $service->requires_state_fees ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Transferable:</small>
                                    <span class="badge bg-secondary">
                                        {{ $service->is_transferable ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Requires State Selection:</small>
                                    <span class="badge bg-secondary">
                                        {{ $service->requires_state_selection ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Description -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h6 class="card-title-modern mb-0">
                            <i class="fas fa-file-alt me-2"></i>Description
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <small class="mb-0">{{ $service->description ?: 'No description provided.' }}</small>
                    </div>
                </div>

                <!-- Features -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-title-modern mb-0">
                                <i class="fas fa-star me-2"></i>Features
                            </h6>
                            <span class="badge bg-secondary">{{ $service->features->count() }} features</span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @if($service->features->count() > 0)
                            <ul class="list-unstyled mb-0">
                                @foreach($service->features as $feature)
                                    <li class="d-flex align-items-center mb-2">
                                        <i class="fas fa-check-circle me-2"></i>
                                        <small>{{ $feature->feature }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <small class="text-muted mb-0">No features defined for this service.</small>
                        @endif
                    </div>
                </div>

                <!-- Service Forms -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h6 class="card-title-modern mb-0">
                            <i class="fas fa-file-alt me-2"></i>Service Forms
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        @if($service->forms->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($service->forms as $form)
                                    <div class="list-group-item border-0 px-0 py-3 service-form-item">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                @if($form->icon)
                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                        <i class="{{ $form->icon }} text-white" style="font-size: 14px;"></i>
                                                    </div>
                                                @else
                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                        <i class="fas fa-user text-white" style="font-size: 14px;"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <small class="mb-1 fw-semibold">{{ $form->title }}</small>
                                                <div class="text-muted" style="font-size: 12px;">{{ $form->description }}</div>
                                            </div>
                                            <div class="ms-2">
                                                <i class="fas fa-chevron-right text-muted" style="font-size: 12px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <small class="text-muted mb-0">No forms defined for this service.</small>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h6 class="card-title-modern mb-0">
                            <i class="fas fa-bolt me-2"></i>Quick Actions
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-edit me-2"></i>Edit Service
                            </a>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="printServiceDetails()">
                                <i class="fas fa-print me-2"></i>Print Details
                            </button>
                            <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-list me-2"></i>All Services
                            </a>
                        </div>
                    </div>
                </div>

                <!-- No Activity Logs -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 text-center">
                        <i class="fas fa-sync-alt fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No activity logs found.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
<style>
    /* Custom styling to match screenshot */
    .card {
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .card-header {
        border-bottom: 1px solid #f0f0f0;
    }
    
    .badge {
        border-radius: 20px;
        font-weight: 400;
        font-size: 0.85rem;
    }
    
    .list-group-item {
        border-bottom: 1px solid #f8f9fa;
    }
    
    .list-group-item:last-child {
        border-bottom: none;
    }
    
    .rounded-circle {
        border-radius: 50% !important;
    }
    
    /* Service forms styling */
    .service-form-item {
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .service-form-item:hover {
        background-color: #f8f9fa;
        transform: translateX(2px);
    }
    
    /* Typography improvements - smaller, cleaner fonts */
    .card-title-modern {
        font-weight: 500 !important;
        font-size: 1rem;
        color: #495057;
    }
    
    .fw-semibold {
        font-weight: 500 !important;
    }
    
    .fw-bold {
        font-weight: 600 !important;
    }
    
    h5, h6 {
        font-weight: 500 !important;
    }
    
    .text-muted {
        font-weight: 400 !important;
        color: #6c757d !important;
    }
    
    /* Button styling - smaller and less colorful */
    .btn-outline-secondary {
        font-weight: 400;
        border-width: 1px;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }
    
    .btn-outline-secondary:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(108,117,125,0.2);
    }
    
    /* Smaller text sizes */
    small {
        font-size: 0.875rem;
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    /* Badge colors matching screenshot */
    .bg-primary {
        background-color: #007bff !important;
    }
    
    .bg-success {
        background-color: #28a745 !important;
    }
    
    .bg-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }
    
    .bg-secondary {
        background-color: #6c757d !important;
    }
    
    .bg-dark {
        background-color: #343a40 !important;
    }
    
    /* Print styles */
    @media print {
        .btn, .card-header, .page-header-modern {
            display: none !important;
        }
        
        .card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }
        
        body {
            font-size: 12pt;
            line-height: 1.4;
        }
    }
</style>
@endpush

@push('js')
<script>
    function printServiceDetails() {
        // Create a new window for printing
        const printWindow = window.open('', '_blank');
        
        // Get the service data
        const serviceData = {
            name: '{{ $service->name }}',
            description: '{{ $service->description }}',
            status: '{{ $service->status }}',
            initialPrice: '{{ number_format($service->initial_price, 2) }}',
            renewalFee: '{{ number_format($service->renewal_fee, 2) }}',
            transferFee: '{{ number_format($service->transfer_fee, 2) }}',
            isTransferable: '{{ $service->is_transferable ? "Yes" : "No" }}',
            isRenewable: '{{ $service->is_renewable ? "Yes" : "No" }}',
            requiresStateFees: '{{ $service->requires_state_fees ? "Yes" : "No" }}',
            visibleOnFunnel: '{{ $service->visible_on_funnel ? "Yes" : "No" }}',
            createdDate: '{{ $service->created_at->format("M d, Y h:i A") }}',
            updatedDate: '{{ $service->updated_at->format("M d, Y h:i A") }}'
        };
        
        // Create print content
        const printContent = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Service Details - ${serviceData.name}</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
                    .section { margin-bottom: 20px; }
                    .section h3 { color: #333; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
                    .info-row { display: flex; justify-content: space-between; margin-bottom: 8px; }
                    .label { font-weight: 500; }
                    .value { font-weight: 400; }
                    .badge { padding: 2px 8px; border-radius: 4px; font-size: 12px; }
                    .badge-success { background-color: #28a745; color: white; }
                    .badge-warning { background-color: #ffc107; color: #212529; }
                    .badge-secondary { background-color: #6c757d; color: white; }
                    .badge-primary { background-color: #007bff; color: white; }
                    @media print { body { margin: 0; } }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>Service Details</h1>
                    <h2>${serviceData.name}</h2>
                </div>
                
                <div class="section">
                    <h3>Basic Information</h3>
                    <div class="info-row">
                        <span class="label">Service Name:</span>
                        <span class="value">${serviceData.name}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Status:</span>
                        <span class="value"><span class="badge badge-success">${serviceData.status}</span></span>
                    </div>
                    <div class="info-row">
                        <span class="label">Description:</span>
                        <span class="value">${serviceData.description || 'No description provided'}</span>
                    </div>
                </div>
                
                <div class="section">
                    <h3>Pricing Information</h3>
                    <div class="info-row">
                        <span class="label">Initial Price:</span>
                        <span class="value">$${serviceData.initialPrice}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Renewal Fee:</span>
                        <span class="value">$${serviceData.renewalFee}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Transfer Fee:</span>
                        <span class="value">$${serviceData.transferFee}</span>
                    </div>
                </div>
                
                <div class="section">
                    <h3>Service Properties</h3>
                    <div class="info-row">
                        <span class="label">Transferable:</span>
                        <span class="value"><span class="badge ${serviceData.isTransferable === 'Yes' ? 'badge-primary' : 'badge-secondary'}">${serviceData.isTransferable}</span></span>
                    </div>
                    <div class="info-row">
                        <span class="label">Renewable:</span>
                        <span class="value"><span class="badge ${serviceData.isRenewable === 'Yes' ? 'badge-primary' : 'badge-secondary'}">${serviceData.isRenewable}</span></span>
                    </div>
                    <div class="info-row">
                        <span class="label">Requires State Fees:</span>
                        <span class="value"><span class="badge ${serviceData.requiresStateFees === 'Yes' ? 'badge-warning' : 'badge-secondary'}">${serviceData.requiresStateFees}</span></span>
                    </div>
                    <div class="info-row">
                        <span class="label">Visible on Funnel:</span>
                        <span class="value"><span class="badge ${serviceData.visibleOnFunnel === 'Yes' ? 'badge-primary' : 'badge-secondary'}">${serviceData.visibleOnFunnel}</span></span>
                    </div>
                </div>
                
                <div class="section">
                    <h3>Timestamps</h3>
                    <div class="info-row">
                        <span class="label">Created Date:</span>
                        <span class="value">${serviceData.createdDate}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Last Updated:</span>
                        <span class="value">${serviceData.updatedDate}</span>
                    </div>
                </div>
                
                <div style="margin-top: 30px; text-align: center; font-size: 12px; color: #666;">
                    Generated on ${new Date().toLocaleString()}
                </div>
            </body>
            </html>
        `;
        
        // Write content and print
        printWindow.document.write(printContent);
        printWindow.document.close();
        
        // Wait for content to load then print
        printWindow.onload = function() {
            printWindow.print();
            printWindow.close();
        };
    }
</script>
@endpush

