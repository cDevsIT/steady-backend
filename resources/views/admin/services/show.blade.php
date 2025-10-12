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
                                <div class="fw-semibold">{{ $service->renewal_period ?? 12 }} months</div>
                            </div>
                            <div class="text-center">
                                <small class="text-muted mb-1">Auto Renewal</small>
                                <div class="fw-semibold">{{ $service->auto_renewal ? 'Enabled' : 'Disabled' }}</div>
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
                                                    @if($form->form_type === 'custom')
                                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                            <i class="{{ $form->icon }} text-white" style="font-size: 14px;"></i>
                                                        </div>
                                                    @else
                                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                            <i class="{{ $form->icon }} text-white" style="font-size: 14px;"></i>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                        <i class="fas fa-user text-white" style="font-size: 14px;"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <small class="mb-1 fw-semibold">{{ $form->title }}</small>
                                                <div class="text-muted" style="font-size: 12px;">
                                                    {{ $form->description ?: ($form->form_type === 'custom' ? 'Collect customer information and files' : $form->description) }}
                                                </div>
                                                @if($form->form_type === 'custom' && $form->form_data)
                                                    @php
                                                        $formData = is_array($form->form_data) ? $form->form_data : json_decode($form->form_data, true);
                                                        $fieldCount = isset($formData['fields']) ? count($formData['fields']) : 0;
                                                    @endphp
                                                    <div class="mt-1">
                                                        <span class="badge bg-info" style="font-size: 10px;">
                                                            {{ $fieldCount }} field{{ $fieldCount !== 1 ? 's' : '' }}
                                                        </span>
                                                        @if(isset($formData['status']) && $formData['status'] === 'active')
                                                            <span class="badge bg-success" style="font-size: 10px;">Active</span>
                                                        @else
                                                            <span class="badge bg-warning" style="font-size: 10px;">Inactive</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ms-2">
                                                @if($form->form_type === 'custom')
                                                    <a href="{{ route('admin.services.formBuilder', $service) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit me-1"></i>Edit
                                                    </a>
                                                @else
                                                    <i class="fas fa-chevron-right text-muted" style="font-size: 12px;"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-3">No forms defined for this service.</p>
                                <a href="{{ route('admin.services.formBuilder', $service) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-2"></i>Create User Info Form
                                </a>
                            </div>
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
    /* Light, clean styling */
    body {
        background-color: #f8f9fa;
    }
    
    .card {
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        border: 1px solid #e9ecef;
        background-color: #ffffff;
    }
    
    .card-header {
        border-bottom: 1px solid #f1f3f4;
        background-color: #fafbfc;
    }
    
    .badge {
        border-radius: 16px;
        font-weight: 500;
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
    }
    
    .list-group-item {
        border-bottom: 1px solid #f5f6f7;
        background-color: transparent;
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
        border-radius: 6px;
    }
    
    .service-form-item:hover {
        background-color: #f8f9fa;
        transform: translateX(2px);
    }
    
    /* Typography - light and clean */
    .card-title-modern {
        font-weight: 600 !important;
        font-size: 1rem;
        color: #495057;
    }
    
    .fw-semibold {
        font-weight: 500 !important;
        color: #343a40;
    }
    
    .fw-bold {
        font-weight: 600 !important;
        color: #2c3e50;
    }
    
    h5, h6 {
        font-weight: 600 !important;
        color: #495057;
    }
    
    .text-muted {
        font-weight: 400 !important;
        color: #6c757d !important;
    }
    
    /* Light button styling */
    .btn-outline-secondary {
        font-weight: 500;
        border-width: 1px;
        transition: all 0.2s ease;
        font-size: 0.875rem;
        border-color: #dee2e6;
        color: #6c757d;
    }
    
    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
        border-color: #adb5bd;
        color: #495057;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    
    /* Smaller text sizes */
    small {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    /* Light badge colors */
    .bg-success {
        background-color: #d4edda !important;
        color: #155724 !important;
        border: 1px solid #c3e6cb;
    }
    
    .bg-warning {
        background-color: #fff3cd !important;
        color: #856404 !important;
        border: 1px solid #ffeaa7;
    }
    
    .bg-secondary {
        background-color: #e9ecef !important;
        color: #495057 !important;
        border: 1px solid #dee2e6;
    }
    
    .bg-primary {
        background-color: #e3f2fd !important;
        color: #1976d2 !important;
        border: 1px solid #bbdefb;
    }
    
    .bg-info {
        background-color: #d1ecf1 !important;
        color: #0c5460 !important;
        border: 1px solid #bee5eb;
    }
    
    /* Light page header */
    .page-header-modern {
        background-color: transparent;
    }
    
    .page-title-modern {
        color: #2c3e50;
        font-weight: 700;
    }
    
    .page-subtitle-modern {
        color: #6c757d;
        font-weight: 400;
    }
    
    /* Light status badge */
    .badge.fs-6 {
        font-size: 0.9rem !important;
        padding: 0.6rem 1.2rem;
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
            background-color: white !important;
        }
    }
</style>
@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    function printServiceDetails() {
        // Get service data
        const serviceData = {
            name: '{{ $service->name }}',
            description: '{{ addslashes($service->description) }}',
            status: '{{ $service->status }}',
            initialPrice: '{{ number_format($service->initial_price, 2) }}',
            renewalFee: '{{ number_format($service->renewal_fee, 2) }}',
            transferFee: '{{ number_format($service->transfer_fee, 2) }}',
            renewalPeriod: '{{ $service->renewal_period ?? 12 }}',
            autoRenewal: '{{ $service->auto_renewal ? "Enabled" : "Disabled" }}',
            isTransferable: '{{ $service->is_transferable ? "Yes" : "No" }}',
            isRenewable: '{{ $service->is_renewable ? "Yes" : "No" }}',
            requiresStateFees: '{{ $service->requires_state_fees ? "Yes" : "No" }}',
            visibleOnFunnel: '{{ $service->visible_on_funnel ? "Yes" : "No" }}',
            requiresStateSelection: '{{ $service->requires_state_selection ? "Yes" : "No" }}',
            createdDate: '{{ $service->created_at->format("M d, Y h:i A") }}',
            updatedDate: '{{ $service->updated_at->format("M d, Y h:i A") }}'
        };

        // Create PDF
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        
        // Set font
        doc.setFont("helvetica");
        
        // Title
        doc.setFontSize(20);
        doc.setTextColor(40, 40, 40);
        doc.text('Service Details', 20, 30);
        
        // Service Name
        doc.setFontSize(16);
        doc.setTextColor(60, 60, 60);
        doc.text(serviceData.name, 20, 50);
        
        // Line separator
        doc.setDrawColor(200, 200, 200);
        doc.line(20, 60, 190, 60);
        
        let yPosition = 80;
        
        // Basic Information Section
        doc.setFontSize(14);
        doc.setTextColor(40, 40, 40);
        doc.text('Basic Information', 20, yPosition);
        yPosition += 15;
        
        doc.setFontSize(10);
        doc.setTextColor(80, 80, 80);
        
        const basicInfo = [
            ['Service Name:', serviceData.name],
            ['Status:', serviceData.status],
            ['Description:', serviceData.description || 'No description provided'],
            ['Created Date:', serviceData.createdDate],
            ['Last Updated:', serviceData.updatedDate]
        ];
        
        basicInfo.forEach(([label, value]) => {
            doc.text(label, 25, yPosition);
            doc.text(value, 80, yPosition);
            yPosition += 8;
        });
        
        yPosition += 10;
        
        // Pricing Information Section
        doc.setFontSize(14);
        doc.setTextColor(40, 40, 40);
        doc.text('Pricing Information', 20, yPosition);
        yPosition += 15;
        
        doc.setFontSize(10);
        doc.setTextColor(80, 80, 80);
        
        const pricingInfo = [
            ['Initial Price:', '$' + serviceData.initialPrice],
            ['Renewal Fee:', '$' + serviceData.renewalFee],
            ['Transfer Fee:', '$' + serviceData.transferFee],
            ['Renewal Period:', serviceData.renewalPeriod + ' months'],
            ['Auto Renewal:', serviceData.autoRenewal]
        ];
        
        pricingInfo.forEach(([label, value]) => {
            doc.text(label, 25, yPosition);
            doc.text(value, 80, yPosition);
            yPosition += 8;
        });
        
        yPosition += 10;
        
        // Service Properties Section
        doc.setFontSize(14);
        doc.setTextColor(40, 40, 40);
        doc.text('Service Properties', 20, yPosition);
        yPosition += 15;
        
        doc.setFontSize(10);
        doc.setTextColor(80, 80, 80);
        
        const propertiesInfo = [
            ['Transferable:', serviceData.isTransferable],
            ['Renewable:', serviceData.isRenewable],
            ['Requires State Fees:', serviceData.requiresStateFees],
            ['Visible on Funnel:', serviceData.visibleOnFunnel],
            ['Requires State Selection:', serviceData.requiresStateSelection]
        ];
        
        propertiesInfo.forEach(([label, value]) => {
            doc.text(label, 25, yPosition);
            doc.text(value, 80, yPosition);
            yPosition += 8;
        });
        
        // Footer
        doc.setFontSize(8);
        doc.setTextColor(120, 120, 120);
        doc.text('Generated on ' + new Date().toLocaleString(), 20, 280);
        
        // Download PDF
        doc.save('Service_Details_' + serviceData.name.replace(/[^a-zA-Z0-9]/g, '_') + '.pdf');
    }
</script>
@endpush

