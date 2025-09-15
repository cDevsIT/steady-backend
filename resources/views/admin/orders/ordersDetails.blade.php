@extends('admin.layouts.master')
@push('title')
    Order Details
@endpush
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
    <style>
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .grid .gird_item {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            min-height: 200px;
        }

        .upload {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .upload .form-group {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .upload .form-group label {
            margin-bottom: 10px;
        }

        .upload .form-group .d-flex {
            margin-top: auto;
            align-items: center;
            gap: 8px;
        }

        .input-file {
            display: none;
        }

        .input-file-label {
            display: inline-block;
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border-radius: 4px;
            border: 1px solid #007bff;
            transition: all 0.3s ease;
            white-space: nowrap;
            min-width: 120px;
            text-align: center;
            flex-shrink: 0;
        }

        .input-file-label:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .upload-name {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #e9ecef;
        }

        .upload-name a {
            display: inline-flex;
            align-items: center;
            color: #007bff;
            text-decoration: none;
        }

        .upload-name a:hover {
            color: #0056b3;
        }

        /* New Document Section Styles */
        .document-card {
            background: #fff;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef !important;
        }

        .document-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .document-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .upload-area {
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px dashed #dee2e6 !important;
        }

        .upload-area:hover {
            background: #e9ecef;
            border-color: #007bff !important;
        }

        .upload-label {
            cursor: pointer;
            display: block;
            padding: 20px;
        }

        .upload-label:hover {
            color: #007bff !important;
        }

        .document-preview {
            background: #f8f9fa !important;
            border: 1px solid #e9ecef;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-processing {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-complete {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-pending {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern">Order Details</h1>
                    <p class="page-subtitle-modern">Order #{{ $order->id }} - {{ $order->company_name }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary-modern">
                        <i class="fas fa-arrow-left me-2"></i>Back to Orders
                    </a>
                </div>
            </div>
        </div>

        <!-- Order Information Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-info-circle me-2 text-primary"></i>Order Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-calendar me-2 text-primary"></i>Order Date
                                </label>
                                <p class="form-control-plaintext fw-semibold">{{ \Carbon\Carbon::parse($order->created_at)->format("M d, Y") }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-map-marker-alt me-2 text-info"></i>State
                                </label>
                                <p class="form-control-plaintext fw-semibold">{{ $order->state_name }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-dollar-sign me-2 text-success"></i>State Fee
                                </label>
                                <p class="form-control-plaintext fw-semibold">${{ number_format($order->state_filing_fee, 2) }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-box me-2 text-warning"></i>Package
                                </label>
                                <p class="form-control-plaintext fw-semibold">{{ $order->package_name }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-dollar-sign me-2 text-info"></i>Package Fee
                                </label>
                                <p class="form-control-plaintext fw-semibold">${{ number_format($order->package_amount, 2) }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-hashtag me-2 text-primary"></i>EIN Service
                                </label>
                                <p class="form-control-plaintext fw-semibold">{{ $order->has_en ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-dollar-sign me-2 text-success"></i>EIN Amount
                                </label>
                                <p class="form-control-plaintext fw-semibold">${{ number_format($order->en_amount, 2) }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-file-contract me-2 text-warning"></i>Operating Agreement
                                </label>
                                <p class="form-control-plaintext fw-semibold">{{ $order->has_agreement ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-dollar-sign me-2 text-info"></i>Agreement Amount
                                </label>
                                <p class="form-control-plaintext fw-semibold">${{ number_format($order->agreement_amount, 2) }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-rocket me-2 text-danger"></i>Expedited Filing
                                </label>
                                <p class="form-control-plaintext fw-semibold">{{ $order->has_processing ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-dollar-sign me-2 text-danger"></i>Expedited Amount
                                </label>
                                <p class="form-control-plaintext fw-semibold">${{ number_format($order->processing_amount, 2) }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-dollar-sign me-2 text-success"></i>Total Amount
                                </label>
                                <p class="form-control-plaintext fw-bold text-success fs-5">${{ number_format($order->total_amount, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-info-circle me-2 text-primary"></i>Current Status
                                </label>
                                <p class="form-control-plaintext fw-semibold">
                    @if($order->name_availability_search_status == 'processing')
                                        <span class="status-badge status-processing">Name Availability Search</span>
                    @elseif($order->state_filing_status == "processing")
                                        <span class="status-badge status-processing">State Filing</span>
                    @elseif($order->setup_business_address_status == "processing")
                                        <span class="status-badge status-processing">Setup Business Address</span>
                    @elseif($order->mail_forwarding_status == "processing")
                                        <span class="status-badge status-processing">Mail Forwarding</span>
                    @elseif($order->ein_filing_status == "processing")
                                        <span class="status-badge status-processing">EIN Filing</span>
                    @elseif($order->operating_agreement_status == "processing")
                                        <span class="status-badge status-processing">Operating Agreement</span>
                    @elseif($order->complete_status == "processing")
                                        <span class="status-badge status-processing">Complete</span>
                                    @else
                                        <span class="status-badge status-pending">Pending</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-credit-card me-2 text-primary"></i>Payment Status
                                </label>
                                <p class="form-control-plaintext fw-semibold">
                                    @if($order->payment_status == 'paid')
                                        <span class="status-badge status-complete">Paid</span>
                    @else
                                        <span class="status-badge status-pending">Pending</span>
                    @endif
                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Incorporation & Renewal Dates Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-calendar-alt me-2 text-primary"></i>Important Dates
                </h5>
    </div>
            <div class="card-body">
        <form action="">
            <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="incorporation_date" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-calendar-plus me-2 text-success"></i>Incorporation Date
                            </label>
                            <input type="date" name="incorporation_date" id="incorporation_date" 
                                   class="form-control form-control-sm changeDate" value="{{$order->incorporation_date}}">
                </div>
                        <div class="col-md-4 mb-3">
                            <label for="renewal_date" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-calendar-check me-2 text-warning"></i>Renewal Date
                            </label>
                            <input type="date" name="renewal_date" id="renewal_date" 
                                   class="form-control form-control-sm changeDate" value="{{$order->renewal_date}}">
                </div>
                        <div class="col-md-4 mb-3">
                            <label for="business_filing_date" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-calendar-day me-2 text-info"></i>Business Filing Date
                            </label>
                    <input type="date" name="business_filing_date" id="business_filing_date"
                           class="form-control form-control-sm changeDate" value="{{$order->business_filing_date}}">
                </div>
            </div>
        </form>
            </div>
    </div>

        <!-- Company Details Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-building me-2 text-primary"></i>Company Details
                </h5>
            </div>
            <div class="card-body">
        <form action="{{route('admin.updateCompanyDetailsOnOrderDetails',$company)}}" method="post">
            @csrf
            <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="company_name" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-building me-2 text-primary"></i>Company Name
                            </label>
                    <input type="text" class="form-control form-control-sm" name="company_name" value="{{$company->company_name}}">
                </div>
                        <div class="col-md-6 mb-3">
                            <label for="business_type" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-briefcase me-2 text-info"></i>Company Type
                            </label>
                    <select name="business_type" onchange="changeBusinessType(event)"
                                    class="form-control form-control-sm" required id="business_type">
                        <option {{$company->business_type == "" ? 'selected' : ''}} value="">Select One</option>
                        <option {{$company->business_type == "LLC" ? 'selected' : ''}} value="LLC">LLC</option>
                                <option {{$company->business_type == "Corporation" ? 'selected' : ''}} value="Corporation">Corporation</option>
                                <option {{$company->business_type == "Partnership" ? 'selected' : ''}} value="Partnership">Partnership</option>
                                <option {{$company->business_type == "Non-Profit" ? 'selected' : ''}} value="Non-Profit">Non-Profit</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3" id="businessTypeOptions">
                            @if($company->business_type == "Corporation")
                                <label for="corporation_type" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-industry me-2 text-warning"></i>Corporation Type
                                </label>
                                <select name="corporation_type" class="form-control form-control-sm" required id="corporation_type">
                                    <option value="">Select One</option>
                                    <option {{$company->corporation_type == "C Corporation" ? 'selected' : ''}} value="C Corporation">C Corporation</option>
                                    <option {{$company->corporation_type == "S Corporation (Owners must be U.S Resident)" ? 'selected' : ''}} value="S Corporation (Owners must be U.S Resident)">S Corporation (Owners must be U.S Resident)</option>
                                </select>
                    @elseif($company->business_type == "LLC")
                                <label for="llc_type" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-industry me-2 text-warning"></i>LLC Type
                                </label>
                                <select name="llc_type" class="form-control form-control-sm" required id="llc_type">
                                <option value="">Select One</option>
                                    <option {{$company->llc_type == "Single Member LLC" ? 'selected' : ''}} value="Single Member LLC">Single Member LLC</option>
                                    <option {{$company->llc_type == "Multi-member LLC" ? 'selected' : ''}} value="Multi-member LLC">Multi-member LLC</option>
                                    <option {{$company->llc_type == "S Corp (Owners must be U.S Resident)" ? 'selected' : ''}} value="S Corp (Owners must be U.S Resident)">S Corp (Owners must be U.S Resident)</option>
                            </select>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type_of_industry" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-industry me-2 text-info"></i>Type of Industry
                            </label>
                            <input type="text" class="form-control form-control-sm" name="type_of_industry" value="{{$company->type_of_industry}}">
                </div>
                </div>
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-bold text-dark mb-3">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>Registered Agent Address
                            </h6>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="street_address" class="form-label fw-semibold text-muted small">Street Address</label>
                            <input type="text" name="plan_street_address" value="{{$company->plan_street_address}}"
                                           id="street_address" class="form-control form-control-sm">
                        </div>
                                <div class="col-md-6 mb-3">
                                    <label for="step4_city" class="form-label fw-semibold text-muted small">City</label>
                                    <input type="text" name="plan_city" value="{{$company->plan_city}}" 
                                           id="step4_city" class="form-control form-control-sm">
                        </div>
                                <div class="col-md-6 mb-3">
                                    <label for="step4_state" class="form-label fw-semibold text-muted small">State</label>
                                    <input type="text" name="plan_state" value="{{$company->plan_state}}" 
                                           id="step4_state" class="form-control form-control-sm">
                        </div>
                                <div class="col-md-6 mb-3">
                                    <label for="step4_zip_code" class="form-label fw-semibold text-muted small">Zip Code</label>
                            <input type="text" name="plan_zip_code" value="{{$company->plan_zip_code}}"
                                           id="step4_zip_code" class="form-control form-control-sm">
                        </div>
                                <div class="col-md-6 mb-3">
                                    <label for="country1" class="form-label fw-semibold text-muted small">Country</label>
                                    <select name="plan_zip_country" id="country1" class="form-control form-control-sm">
                            @foreach($countries as $country)
                                            <option {{$company->plan_zip_country == $country ? "selected" : ""}} value="{{$country}}">{{$country}}</option>
                                @endforeach
                                </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary-modern">
                            <i class="fas fa-save me-2"></i>Update Company Details
                        </button>
                </div>
                </form>
            </div>
        </div>

        <!-- Status Updates Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-cogs me-2 text-primary"></i>Status Management
                </h5>
    </div>
            <div class="card-body">
        <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="ein_number" class="form-label fw-semibold text-muted small">
                            <i class="fas fa-hashtag me-2 text-primary"></i>EIN Number
                        </label>
                <form action="{{route('admin.orderStatusUpdate',$order)}}" method="post">
                    @csrf
                    <input type="hidden" name="isStatus" value="false">
                    <div class="input-group">
                                <input type="text" name="ein_number" id="ein_number" value="{{$order->ein_number}}" class="form-control form-control-sm">
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-save"></i>
                                </button>
                        </div>
                        </form>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="compliance_status" class="form-label fw-semibold text-muted small">
                            <i class="fas fa-shield-alt me-2 text-success"></i>Compliance Status
                        </label>
                <form action="{{route('admin.orderStatusUpdate',$order)}}" method="post">
                    @csrf
                    <input type="hidden" name="isStatus" value="true">
                    <div class="input-group">
                                <select name="compliance_status" id="compliance_status" class="form-control form-control-sm">
                                    <option {{$order->compliance_status == 'active' ? 'selected' : ''}} value="active">Active</option>
                                    <option {{$order->compliance_status == 'expired' ? 'selected' : ''}} value="expired">Expired</option>
                        </select>
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-save"></i>
                                </button>
                        </div>
                        </form>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="name_availability_search_status" class="form-label fw-semibold text-muted small">
                            <i class="fas fa-search me-2 text-info"></i>Name Search Status
                        </label>
                <form action="{{route('admin.orderStatusUpdate',$order)}}" method="post">
                    @csrf
                    <input type="hidden" name="isStatus" value="true">
                    <div class="input-group">
                                <select name="name_availability_search_status" id="name_availability_search_status" class="form-control form-control-sm">
                                    <option {{$order->name_availability_search_status == 'pending' ? 'selected' : ''}} value="pending">Pending</option>
                                    <option {{$order->name_availability_search_status == 'processing' ? 'selected' : ''}} value="processing">Processing</option>
                                    <option {{$order->name_availability_search_status == 'complete' ? 'selected' : ''}} value="complete">Complete</option>
                        </select>
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-save"></i>
                                </button>
                        </div>
                        </form>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="state_filing_status" class="form-label fw-semibold text-muted small">
                            <i class="fas fa-file-alt me-2 text-warning"></i>State Filing Status
                        </label>
                <form action="{{route('admin.orderStatusUpdate',$order)}}" method="post">
                    @csrf
                    <input type="hidden" name="isStatus" value="true">
                    <div class="input-group">
                                <select name="state_filing_status" id="state_filing_status" class="form-control form-control-sm">
                                    <option {{$order->state_filing_status == 'pending' ? 'selected' : ''}} value="pending">Pending</option>
                                    <option {{$order->state_filing_status == 'processing' ? 'selected' : ''}} value="processing">Processing</option>
                                    <option {{$order->state_filing_status == 'complete' ? 'selected' : ''}} value="complete">Complete</option>
                        </select>
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-save"></i>
                                </button>
                        </div>
                        </form>
                    </div>
            </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="setup_business_address_status" class="form-label fw-semibold text-muted small">
                            <i class="fas fa-map-marker-alt me-2 text-success"></i>Business Address Status
                        </label>
                <form action="{{route('admin.orderStatusUpdate',$order)}}" method="post">
                    @csrf
                    <input type="hidden" name="isStatus" value="true">
                    <div class="input-group">
                                <select name="setup_business_address_status" id="setup_business_address_status" class="form-control form-control-sm">
                                    <option {{$order->setup_business_address_status == 'pending' ? 'selected' : ''}} value="pending">Pending</option>
                                    <option {{$order->setup_business_address_status == 'processing' ? 'selected' : ''}} value="processing">Processing</option>
                                    <option {{$order->setup_business_address_status == 'complete' ? 'selected' : ''}} value="complete">Complete</option>
                        </select>
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-save"></i>
                                </button>
                        </div>
                        </form>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="mail_forwarding_status" class="form-label fw-semibold text-muted small">
                            <i class="fas fa-envelope me-2 text-info"></i>Mail Forwarding Status
                        </label>
                <form action="{{route('admin.orderStatusUpdate',$order)}}" method="post">
                    @csrf
                    <input type="hidden" name="isStatus" value="true">
                    <div class="input-group">
                                <select name="mail_forwarding_status" id="mail_forwarding_status" class="form-control form-control-sm">
                                    <option {{$order->mail_forwarding_status == 'pending' ? 'selected' : ''}} value="pending">Pending</option>
                                    <option {{$order->mail_forwarding_status == 'processing' ? 'selected' : ''}} value="processing">Processing</option>
                                    <option {{$order->mail_forwarding_status == 'complete' ? 'selected' : ''}} value="complete">Complete</option>
                        </select>
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-save"></i>
                                </button>
                        </div>
                        </form>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="ein_filing_status" class="form-label fw-semibold text-muted small">
                            <i class="fas fa-hashtag me-2 text-warning"></i>EIN Filing Status
                        </label>
                <form action="{{route('admin.orderStatusUpdate',$order)}}" method="post">
                    @csrf
                    <input type="hidden" name="isStatus" value="true">
                    <div class="input-group">
                                <select name="ein_filing_status" id="ein_filing_status" class="form-control form-control-sm">
                                    <option {{$order->ein_filing_status == 'pending' ? 'selected' : ''}} value="pending">Pending</option>
                                    <option {{$order->ein_filing_status == 'processing' ? 'selected' : ''}} value="processing">Processing</option>
                                    <option {{$order->ein_filing_status == 'complete' ? 'selected' : ''}} value="complete">Complete</option>
                        </select>
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-save"></i>
                                </button>
                        </div>
                        </form>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="operating_agreement_status" class="form-label fw-semibold text-muted small">
                            <i class="fas fa-file-contract me-2 text-success"></i>Operating Agreement Status
                        </label>
                <form action="{{route('admin.orderStatusUpdate',$order)}}" method="post">
                    @csrf
                    <input type="hidden" name="isStatus" value="true">
                    <div class="input-group">
                                <select name="operating_agreement_status" id="operating_agreement_status" class="form-control form-control-sm">
                                    <option {{$order->operating_agreement_status == 'pending' ? 'selected' : ''}} value="pending">Pending</option>
                                    <option {{$order->operating_agreement_status == 'processing' ? 'selected' : ''}} value="processing">Processing</option>
                                    <option {{$order->operating_agreement_status == 'complete' ? 'selected' : ''}} value="complete">Complete</option>
                        </select>
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-save"></i>
                                </button>
                        </div>
                        </form>
                    </div>
            </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="complete_status" class="form-label fw-semibold text-muted small">
                            <i class="fas fa-check-circle me-2 text-success"></i>Completion Status
                        </label>
                <form action="{{route('admin.orderStatusUpdate',$order)}}" method="post">
                    @csrf
                    <input type="hidden" name="isStatus" value="true">
                    <div class="input-group">
                        <select name="complete_status" id="complete_status" class="form-control form-control-sm">
                                    <option {{$order->complete_status == 'pending' ? 'selected' : ''}} value="pending">Pending</option>
                                    <option {{$order->complete_status == 'processing' ? 'selected' : ''}} value="processing">Processing</option>
                                    <option {{$order->complete_status == 'complete' ? 'selected' : ''}} value="complete">Complete</option>
                        </select>
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-save"></i>
                                </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-file-alt me-2 text-primary"></i>Documents
                </h5>
    </div>
            <div class="card-body">
        <div class="grid">
            <div class="gird_item">
                <div class="upload">
                    <form action="{{ route('admin.orderDocumentUpdate',[$order->id,"article_of_organization_file"]) }}"
                          enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group">
                                    <label for="" class="form-label fw-semibold text-muted small">
                                        <i class="fas fa-file-contract me-2 text-primary"></i>Article of Organization
                                    </label>
                                    <div class="d-flex">
                            <input type="file" class="input-file" id="article_of_organization_file" name="file">
                            <label for="article_of_organization_file" class="input-file-label">Choose File</label>
                                        <button type="submit" class="submitFile btn btn-primary btn-sm">Upload</button>
                                    </div>
                        </div>
                    </form>
                </div>
                <div class="upload-name">
                    @if($order->article_of_organization_file)
                                <a href="{{asset('storage/uploads/'.$order->article_of_organization_file)}}" download class="text-decoration-none">
                                    <i class="fas fa-download me-2"></i>{{$order->article_of_organization_file}}
                                </a>
                    @endif
                </div>
            </div>

            <div class="gird_item">
                <div class="upload">
                    <form action="{{ route('admin.orderDocumentUpdate',[$order->id,"package_file"]) }}"
                          enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group">
                                    <label for="" class="form-label fw-semibold text-muted small">
                                        <i class="fas fa-building me-2 text-info"></i>Registered Agent & Business Address
                                    </label>
                                    <div class="d-flex">
                            <input type="file" class="input-file" name="file" id="package_file">
                            <label for="package_file" class="input-file-label">Choose File</label>
                                        <button type="submit" class="submitFile btn btn-primary btn-sm">Upload</button>
                                    </div>
                        </div>
                    </form>
                </div>
                <div class="upload-name">
                    @if($order->package_file)
                                <a href="{{asset('storage/uploads/'.$order->package_file)}}" download class="text-decoration-none">
                                    <i class="fas fa-download me-2"></i>{{$order->package_file}}
                                </a>
                    @endif
                </div>
            </div>

            @if($order->has_en)
                <div class="gird_item">
                    <div class="upload">
                        <form action="{{ route('admin.orderDocumentUpdate',[$order->id,"en_file"]) }}"
                              enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="form-group">
                                        <label for="" class="form-label fw-semibold text-muted small">
                                            <i class="fas fa-hashtag me-2 text-warning"></i>EIN Document
                                        </label>
                                        <div class="d-flex">
                                <input type="file" class="input-file" id="en_file" name="file">
                                <label for="en_file" class="input-file-label">Choose File</label>
                                            <button type="submit" class="submitFile btn btn-primary btn-sm">Upload</button>
                                        </div>
                            </div>
                        </form>
                    </div>
                    <div class="upload-name">
                        @if($order->en_file)
                                    <a href="{{asset('storage/uploads/'.$order->en_file)}}" download class="text-decoration-none">
                                        <i class="fas fa-download me-2"></i>{{$order->en_file}}
                                    </a>
                        @endif
                    </div>
                </div>
            @endif

            @if($order->has_agreement)
                <div class="gird_item">
                    <div class="upload">
                        <form action="{{ route('admin.orderDocumentUpdate',[$order->id,"agreement_file"]) }}"
                              enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="form-group">
                                        <label for="" class="form-label fw-semibold text-muted small">
                                            <i class="fas fa-file-contract me-2 text-success"></i>Operating Agreement
                                        </label>
                                        <div class="d-flex">
                                <input type="file" class="input-file" id="agreement_file" name="file">
                                <label for="agreement_file" class="input-file-label">Choose File</label>
                                            <button type="submit" class="submitFile btn btn-primary btn-sm">Upload</button>
                                        </div>
                            </div>
                        </form>
                    </div>
                    <div class="upload-name">
                        @if($order->agreement_file)
                                    <a href="{{asset('storage/uploads/'.$order->agreement_file)}}" download class="text-decoration-none">
                                        <i class="fas fa-download me-2"></i>{{$order->agreement_file}}
                                    </a>
                        @endif
                    </div>
                </div>
            @endif

            @if($order->has_processing)
                <div class="gird_item">
                    <div class="upload">
                        <form action="{{ route('admin.orderDocumentUpdate',[$order->id,"processing_file"]) }}"
                              enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="form-group">
                                        <label for="" class="form-label fw-semibold text-muted small">
                                            <i class="fas fa-rocket me-2 text-danger"></i>Expedited Filing
                                        </label>
                                        <div class="d-flex">
                                <input type="file" class="input-file" id="processing_file" name="file">
                                <label for="processing_file" class="input-file-label">Choose File</label>
                                            <button type="submit" class="submitFile btn btn-primary btn-sm">Upload</button>
                                        </div>
                            </div>
                        </form>
                    </div>
                    <div class="upload-name">
                        @if($order->processing_file)
                                    <a href="{{asset('storage/uploads/'.$order->processing_file)}}" download class="text-decoration-none">
                                        <i class="fas fa-download me-2"></i>{{$order->processing_file}}
                                    </a>
                        @endif
                    </div>
                </div>
            @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <script>
        function enNumberUpdate(event) {
            setTimeout(function () {
                submitOnAjax(event, isStatus = false)
            }, 2000);
        }

        function submitOnAjax(event, isStatus = true) {
            const route = "{{route('admin.orderStatusUpdate',$order)}}";
            const fieldName = event.target.name;
            const fieldValue = event.target.value
            $.ajax({
                url: route,
                method: "POST",
                data: {
                    [fieldName]: fieldValue,
                    fieldName: fieldName,
                    fieldValue: fieldValue,
                    isStatus: isStatus,
                    _token: "{{csrf_token()}}"
                },
                success: function (response) {
                    if (response.success) {
                        if (response.isStatus) {
                            alertMessage('success', response.message);
                        }
                    } else {
                        alertMessage('error', response.message);
                    }
                }
            })
        }

        $(document).ready(function () {
            $('.input-file').change(function () {
                let form = $(this).closest('.gird_item').find('.upload-name');
                if (this.files && this.files.length > 0) {
                    let name = this.files[0].name;
                    form.html('<i class="fas fa-file me-2"></i>' + name);
                } else {
                    form.text("No file chosen");
                }
            });
        });

        $(document).on('change', '.changeDate', function () {
            let that = $(this);
            let name = that.attr('name');
            let value = that.val();
            const route = "{{route('admin.companyDateUpdate',$order)}}"
            $.ajax({
                url: route,
                method: 'post',
                data: {
                    name: name,
                    value: value,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {
                    if (response.success) {
                        alertMessage('success', response.message);
                    } else {
                        alertMessage('error', response.message);
                    }
                }
            })
        })

        function changeBusinessType(event) {
            const value = event.target.value;
            const businessTypeOptions = document.getElementById("businessTypeOptions");
            businessTypeOptions.innerHTML = '';
            
            if (value == 'LLC') {
                const label = document.createElement('label');
                label.setAttribute('for', 'llc_type');
                label.className = 'form-label fw-semibold text-muted';
                label.innerHTML = '<i class="fas fa-industry me-2 text-warning"></i>LLC Type';

                const llcSelect = document.createElement('select');
                llcSelect.name = 'llc_type';
                llcSelect.className = 'form-control';
                llcSelect.id = 'llc_type';
                llcSelect.required = true;

                const options = [
                    {value: '', text: 'Select One'},
                    {value: 'Single Member LLC', text: 'Single Member LLC'},
                    {value: 'Multi-member LLC', text: 'Multi-member LLC'},
                    {value: 'S Corp (Owners must be U.S Resident)', text: 'S Corp (Owners must be U.S Resident)'}
                ];

                options.forEach(optionData => {
                    const option = document.createElement('option');
                    option.value = optionData.value;
                    option.textContent = optionData.text;
                    llcSelect.appendChild(option);
                });

                businessTypeOptions.appendChild(label);
                businessTypeOptions.appendChild(llcSelect);
            }
            
            if (value == 'Corporation') {
                const coLabel = document.createElement('label');
                coLabel.setAttribute('for', 'corporation_type');
                coLabel.className = 'form-label fw-semibold text-muted';
                coLabel.innerHTML = '<i class="fas fa-industry me-2 text-warning"></i>Corporation Type';

                const corpSelect = document.createElement('select');
                corpSelect.name = 'corporation_type';
                corpSelect.className = 'form-control';
                corpSelect.id = 'corporation_type';
                corpSelect.required = true;

                const corpOptions = [
                    {value: '', text: 'Select One'},
                    {value: 'C Corporation', text: 'C Corporation'},
                    {value: 'S Corporation (Owners must be U.S Resident)', text: 'S Corporation (Owners must be U.S Resident)'}
                ];

                corpOptions.forEach(option => {
                    const opt = document.createElement('option');
                    opt.value = option.value;
                    opt.textContent = option.text;
                    corpSelect.appendChild(opt);
                });
                
                businessTypeOptions.appendChild(coLabel);
                businessTypeOptions.appendChild(corpSelect);
            }
        }
    </script>
@endpush
