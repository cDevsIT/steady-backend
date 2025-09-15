@extends('admin.layouts.master')
@push('title')
    Orders Management
@endpush
@push('css')
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern">Orders Management</h1>
                    <p class="page-subtitle-modern">Manage customer orders and company formations</p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary-modern" onclick="exportToCSV()">
                        <i class="fas fa-download me-2"></i>Export CSV
                    </button>
                </div>
            </div>
        </div>

        <!-- Modern Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card-modern card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-primary-subtle rounded-lg me-3">
                                <i class="fas fa-shopping-cart text-primary"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Total Orders</h6>
                                <h3 class="stats-value-modern mb-0">{{ $orders->total() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card-modern card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-success-subtle rounded-lg me-3">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Completed</h6>
                                <h3 class="stats-value-modern mb-0">{{ $orders->where('complete_status', 'complete')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card-modern card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-warning-subtle rounded-lg me-3">
                                <i class="fas fa-clock text-warning"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Processing</h6>
                                <h3 class="stats-value-modern mb-0">{{ $orders->where('complete_status', 'processing')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card-modern card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-info-subtle rounded-lg me-3">
                                <i class="fas fa-dollar-sign text-info"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Total Revenue</h6>
                                <h3 class="stats-value-modern mb-0">${{ number_format($orders->sum('total_amount'), 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Search and Filters Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-filter me-2 text-primary"></i> Search & Filters
                </h5>
            </div>
            <div class="card-body">
                <form action="" method="GET">
                    <div class="row align-items-end">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-calendar me-1 text-info"></i>Date Range
                            </label>
                            <input type="text" 
                                   class="form-control form-control-sm" 
                                   placeholder="Select Date Range"
                                   value="{{request()->daterange}}" 
                                   name="daterange" 
                                   id="daterange">
                        </div>
                        <div class="col-md-5 mb-3">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-search me-1 text-primary"></i>Search
                            </label>
                            <input type="text" 
                                   class="form-control form-control-sm" 
                                   placeholder="Client Name, Customer Name, or Order ID..." 
                                   value="{{request()->q}}" 
                                   name="q">
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="d-flex gap-2">
                                <button type="submit" name="submit_type" value="search" class="btn btn-primary-modern" style="height: 38px; line-height: 1;">
                                    <i class="fas fa-search me-1"></i> Search
                                </button>
                                <button type="submit" name="submit_type" value="csv" class="btn btn-outline-secondary-modern" style="height: 38px; line-height: 1;">
                                    <i class="fas fa-download me-1"></i> Export
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modern Main Content Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-list me-2 text-primary"></i>Orders List
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 40px;">#</th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 80px;">
                                    <i class="fas fa-cogs me-1"></i>Actions
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 100px;">
                                    <i class="fas fa-calendar me-1"></i>Date
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 100px;">
                                    <i class="fas fa-user me-1"></i>Customer
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 120px;">
                                    <i class="fas fa-building me-1"></i>Company
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 70px;">
                                    <i class="fas fa-map-marker-alt me-1"></i>State
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 100px;">
                                    <i class="fas fa-box me-1"></i>Package
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 70px;">
                                    <i class="fas fa-credit-card me-1"></i>Payment
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 80px;">
                                    <i class="fas fa-shield-alt me-1"></i>Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr class="border-bottom">
                                    <td class="py-2 px-2 fw-semibold small text-center">{{++$i}}</td>
                                    <td class="py-2 px-2 text-center">
                                        <a class="btn btn-outline-info btn-sm" href="{{route("admin.ordersDetails",$order->id)}}">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="text-muted small">{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</span>
                                        <br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($order->created_at)->format('h:i A') }}</small>
                                    </td>
                                    <td class="py-2 px-2">
                                        <a href="{{route('admin.customers',$order->user_id)}}" class="text-primary text-decoration-none">
                                            {{$order->customer_first_name ." ". $order->customer_last_name }}
                                        </a>
                                    </td>
                                    <td class="py-2 px-2">
                                        <a href="{{route('admin.companies',['company'=>$order->company_id])}}" class="text-primary text-decoration-none">
                                            {{$order->company_name}}
                                        </a>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill">{{$order->state_name}}</span>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="fw-semibold small">{{$order->package_name}}</span>
                                    </td>
                                    <td class="py-2 px-2 text-center">
                                        @if($order->payment_status == 'paid')
                                            <span class="badge bg-success-subtle text-success rounded-pill">
                                                <i class="fas fa-check me-1"></i>Paid
                                            </span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning rounded-pill">
                                                <i class="fas fa-clock me-1"></i>Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-2 text-center">
                                        @if($order->compliance_status == 'active')
                                            <span class="badge bg-success-subtle text-success rounded-pill">
                                                <i class="fas fa-check me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger rounded-pill">
                                                <i class="fas fa-times me-1"></i>Expired
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Modern Pagination -->
            @if($orders->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="text-muted mb-0 small">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} entries
                            </p>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Page navigation" class="d-flex justify-content-md-end">
                                {{ $orders->render() }}
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('js')
    <!-- Moment.js (required for Date Range Picker) -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <!-- Date Range Picker JS -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        function exportToCSV() {
            // Add CSV export functionality here
            console.log('Export to CSV functionality');
        }

        $(function () {
            var dateRangeVal = $('#daterange').val();
            if (dateRangeVal){
                $('#daterange').daterangepicker({
                    startDate: dateRangeVal ? moment(dateRangeVal.split(' to ')[0], 'YYYY-MM-DD') : null,
                    endDate: dateRangeVal ? moment(dateRangeVal.split(' to ')[1], 'YYYY-MM-DD') : null,
                    opens: 'right',
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear'
                    },
                });
            }else{
                $('#daterange').daterangepicker({
                    opens: 'right',
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear'
                    },
                });
            }

            $('#daterange').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
            });

            $('#daterange').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
        });
    </script>
@endpush
