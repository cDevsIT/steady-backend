@extends('admin.layouts.master')
@push('title')
    Transitions
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern">Transitions</h1>
                    <p class="page-subtitle-modern">Manage and monitor all payment transitions</p>
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
                                <i class="fas fa-exchange-alt text-primary"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Total Transitions</h6>
                                <h3 class="stats-value-modern mb-0">{{ $transitions->total() }}</h3>
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
                                <h3 class="stats-value-modern mb-0">{{ $transitions->where('status', 'COMPLETED')->count() }}</h3>
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
                                <h6 class="stats-label-modern text-muted mb-1">Pending</h6>
                                <h3 class="stats-value-modern mb-0">{{ $transitions->where('status', 'pending')->count() }}</h3>
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
                                <h6 class="stats-label-modern text-muted mb-1">Total Amount</h6>
                                <h3 class="stats-value-modern mb-0">${{ number_format($transitions->sum('amount'), 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Filters Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-filter me-2 text-primary"></i>Search & Filters
                </h5>
            </div>
            <div class="card-body">
                <form action="" method="GET">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-calendar me-1 text-primary"></i>From Date
                            </label>
                            <input type="date" class="form-control form-control-sm" name="from_date" value="{{request()->from_date}}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-calendar me-1 text-primary"></i>To Date
                            </label>
                            <input type="date" class="form-control form-control-sm" name="to_date" value="{{request()->to_date}}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-search me-1 text-success"></i>Search
                            </label>
                            <input type="text" class="form-control form-control-sm" name="search" placeholder="Search by transition ID..." value="{{request()->search}}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-credit-card me-1 text-warning"></i>Payment Method
                            </label>
                            <select name="payment_method" class="form-control form-control-sm">
                                <option value="">All Payment Methods</option>
                                <option {{request()->payment_method == "Stripe" ? 'selected' : ''}} value="Stripe">Stripe</option>
                                <option {{request()->payment_method == "PayPal" ? 'selected' : ''}} value="PayPal">PayPal</option>
                                <option {{request()->payment_method == "Bank" ? 'selected' : ''}} value="Bank">Bank</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="d-flex gap-2 w-100">
                                <button type="submit" name="submit_type" value="search" class="btn btn-primary-modern flex-fill" style="height: 38px; line-height: 1;">
                                    <i class="fas fa-search me-1"></i>Search
                                </button>
                                <button type="submit" name="submit_type" value="csv" class="btn btn-outline-secondary-modern" style="height: 38px; line-height: 1;">
                                    <i class="fas fa-download"></i>
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
                    <i class="fas fa-list me-2 text-primary"></i>Transitions List
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 50px;">ID</th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 100px;">
                                    <i class="fas fa-calendar me-1"></i>DateTime
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 80px;">
                                    <i class="fas fa-shopping-cart me-1"></i>Order ID
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 120px;">
                                    <i class="fas fa-building me-1"></i>Company Name
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 120px;">
                                    <i class="fas fa-hashtag me-1"></i>Charge ID
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 100px;">
                                    <i class="fas fa-credit-card me-1"></i>Payment Method
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 100px;">
                                    <i class="fas fa-user me-1"></i>Payment By
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 80px;">
                                    <i class="fas fa-dollar-sign me-1"></i>Amount
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 80px;">
                                    <i class="fas fa-info-circle me-1"></i>Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transitions as $tr)
                                <tr class="border-bottom">
                                    <td class="py-2 px-2 fw-semibold small text-center">#{{$tr->id}}</td>
                                    <td class="py-2 px-2">
                                        <span class="text-muted small">{{ \Carbon\Carbon::parse($tr->created_at)->format('M d, Y') }}</span>
                                        <br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($tr->created_at)->format('h:i A') }}</small>
                                    </td>
                                    <td class="py-2 px-2">
                                        @if($tr->order)
                                            <a class="badge bg-success-subtle text-success rounded-pill text-decoration-none" href="{{route('admin.orders',['order'=>$tr->order->id])}}">
                                                #{{$tr->order->id}}
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-2">
                                        @if($tr->company)
                                            <span class="fw-semibold small">{{$tr->company->company_name}}</span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-2">
                                        <code class="text-primary small">{{$tr->charge_id ?: '-'}}</code>
                                    </td>
                                    <td class="py-2 px-2">
                                        @php
                                            $methodColors = [
                                                'Stripe' => 'primary',
                                                'PayPal' => 'info',
                                                'Bank' => 'success'
                                            ];
                                            $color = $methodColors[$tr->payment_method] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }}-subtle text-{{ $color }} rounded-pill">{{$tr->payment_method}}</span>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="small">{{$tr->player_name ?: '-'}}</span>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="fw-bold text-success small">${{ number_format($tr->amount, 2) }}</span>
                                    </td>
                                    <td class="py-2 px-2 text-center">
                                        @php
                                            $statusColors = [
                                                'completed' => 'success',
                                                'COMPLETED' => 'success',
                                                'pending' => 'warning',
                                                'PENDING' => 'warning',
                                                'failed' => 'danger',
                                                'FAILED' => 'danger',
                                                'cancelled' => 'secondary',
                                                'CANCELLED' => 'secondary'
                                            ];
                                            $statusColor = $statusColors[strtolower($tr->status)] ?? 'secondary';
                                            $statusText = ucfirst(strtolower($tr->status));
                                        @endphp
                                        <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} rounded-pill">{{ $statusText }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Modern Pagination -->
            @if($transitions->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="text-muted mb-0 small">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing {{ $transitions->firstItem() ?? 0 }} to {{ $transitions->lastItem() ?? 0 }} of {{ $transitions->total() }} entries
                            </p>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Page navigation" class="d-flex justify-content-md-end">
                                {{ $transitions->render() }}
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('js')

@endpush
