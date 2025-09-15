@extends('admin.layouts.master')
@push('title')
    Tickets Management
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
                    <h1 class="page-title-modern">Tickets Management</h1>
                    <p class="page-subtitle-modern">Manage customer support tickets and inquiries</p>
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
                                <i class="fas fa-ticket-alt text-primary"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Total Tickets</h6>
                                <h3 class="stats-value-modern mb-0">{{ $totalTickets ?? 0 }}</h3>
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
                                <i class="fas fa-door-open text-success"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Open Tickets</h6>
                                <h3 class="stats-value-modern mb-0">{{ $openTickets ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card-modern card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-danger-subtle rounded-lg me-3">
                                <i class="fas fa-door-closed text-danger"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Closed Tickets</h6>
                                <h3 class="stats-value-modern mb-0">{{ $closedTickets ?? 0 }}</h3>
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
                                <i class="fas fa-users text-info"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Unique Customers</h6>
                                <h3 class="stats-value-modern mb-0">{{ $uniqueCustomers ?? 0 }}</h3>
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
                        <div class="col-md-2 mb-0">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-calendar me-1 text-info"></i>From Date
                            </label>
                            <input type="date" 
                                   class="form-control form-control-sm" 
                                   value="{{request()->from_date}}" 
                                   name="from_date">
                        </div>
                        <div class="col-md-2 mb-0">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-calendar me-1 text-info"></i>To Date
                            </label>
                            <input type="date" 
                                   class="form-control form-control-sm" 
                                   value="{{request()->to_date}}" 
                                   name="to_date">
                        </div>
                        <div class="col-md-3 mb-0">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-search me-1 text-primary"></i>Search
                            </label>
                            <input type="text" 
                                   class="form-control form-control-sm" 
                                   placeholder="Company or customer name..." 
                                   value="{{request()->search}}" 
                                   name="search">
                        </div>
                        <div class="col-md-2 mb-0">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-filter me-1 text-warning"></i>Status
                            </label>
                            <select name="status" class="form-control form-control-sm">
                                <option value="">All Status</option>
                                <option value="Open" {{request()->status == 'Open' ? 'selected' : ''}}>Open</option>
                                <option value="Close" {{request()->status == 'Close' ? 'selected' : ''}}>Closed</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-0">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-sm flex-fill">
                                    <i class="fas fa-search me-1"></i>Search
                                </button>
                                <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-times me-1"></i>Clear
                                </a>
                                <button type="submit" name="submit_type" value="csv" class="btn btn-success btn-sm">
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
                    <i class="fas fa-list me-2 text-primary"></i>Tickets List
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 50px;">#</th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 120px;">
                                    <i class="fas fa-calendar me-1"></i>Date & Time
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 200px;">
                                    <i class="fas fa-ticket-alt me-1"></i>Title
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 150px;">
                                    <i class="fas fa-user me-1"></i>Customer
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 180px;">
                                    <i class="fas fa-envelope me-1"></i>Email
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 120px;">
                                    <i class="fas fa-phone me-1"></i>Phone
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 100px;">
                                    <i class="fas fa-info-circle me-1"></i>Status
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 100px;">
                                    <i class="fas fa-cogs me-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                                <tr class="border-bottom">
                                    <td class="py-2 px-2 fw-semibold small text-center">{{ $ticket->id }}</td>
                                    <td class="py-2 px-2">
                                        <span class="text-muted small">{{ \Carbon\Carbon::parse($ticket->created_at)->format('M d, Y') }}</span>
                                        <br>
                                        <small class="text-muted small">{{ \Carbon\Carbon::parse($ticket->created_at)->format('h:i A') }}</small>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="fw-semibold small">{{ Str::limit($ticket->title, 50) }}</span>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="fw-semibold small">{{ $ticket->first_name ." ". $ticket->last_name }}</span>
                                    </td>
                                    <td class="py-2 px-2">
                                        <a href="mailto:{{ $ticket->email }}" class="text-primary small">
                                            <i class="fas fa-envelope me-1"></i>{{ $ticket->email }}
                                        </a>
                                    </td>
                                    <td class="py-2 px-2">
                                        <a href="tel:{{ $ticket->phone }}" class="text-primary small">
                                            <i class="fas fa-phone me-1"></i>{{ $ticket->phone }}
                                        </a>
                                    </td>
                                    <td class="py-2 px-2 text-center">
                                        @if($ticket->status == 'Open')
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                                <i class="fas fa-door-open me-1"></i>Open
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                                <i class="fas fa-door-closed me-1"></i>Closed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-2 text-center">
                                        <a href="{{route('tickets.show', $ticket->id)}}" 
                                           class="btn btn-outline-primary btn-sm" 
                                           title="View Details">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Modern Pagination -->
            @if($tickets->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="text-muted mb-0 small">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing {{ $tickets->firstItem() ?? 0 }} to {{ $tickets->lastItem() ?? 0 }} of {{ $tickets->total() }} entries
                            </p>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Page navigation" class="d-flex justify-content-md-end">
                                {{ $tickets->render() }}
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
    </script>
@endpush
