@extends('admin.layouts.master')
@push('title')
    Primary Contacts
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern">Primary Contacts</h1>
                    <p class="page-subtitle-modern">Manage customer registration attempts and inquiries</p>
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
                                <i class="fas fa-users text-primary"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Total Contacts</h6>
                                <h3 class="stats-value-modern mb-0">{{ $contacts->total() }}</h3>
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
                                <i class="fas fa-calendar-day text-success"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Today</h6>
                                <h3 class="stats-value-modern mb-0">{{ $contacts->where('created_at', '>=', \Carbon\Carbon::now()->startOfDay())->count() }}</h3>
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
                                <i class="fas fa-calendar-week text-info"></i>
                                </i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">This Week</h6>
                                <h3 class="stats-value-modern mb-0">{{ $contacts->where('created_at', '>=', \Carbon\Carbon::now()->startOfWeek())->count() }}</h3>
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
                                <i class="fas fa-calendar-alt text-warning"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">This Month</h6>
                                <h3 class="stats-value-modern mb-0">{{ $contacts->where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->count() }}</h3>
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
                                   placeholder="Name, email, or phone..." 
                                   value="{{request()->search}}" 
                                   name="search">
                        </div>
                        <div class="col-md-2 mb-0">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-sort me-1 text-warning"></i>Sort By
                            </label>
                            <select name="sort" class="form-control form-control-sm">
                                <option value="latest" {{request()->sort == 'latest' ? 'selected' : ''}}>Latest First</option>
                                <option value="oldest" {{request()->sort == 'oldest' ? 'selected' : ''}}>Oldest First</option>
                                <option value="name" {{request()->sort == 'name' ? 'selected' : ''}}>Name A-Z</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-0">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-sm flex-fill">
                                    <i class="fas fa-search me-1"></i>Search
                                </button>
                                <a href="{{ route('admin.try_to_register_list') }}" class="btn btn-outline-secondary btn-sm">
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
                    <i class="fas fa-list me-2 text-primary"></i> Contacts List
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
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 180px;">
                                    <i class="fas fa-user me-1"></i>Contact Name
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 200px;">
                                    <i class="fas fa-envelope me-1"></i>Email
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 150px;">
                                    <i class="fas fa-phone me-1"></i>Phone
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 150px;">
                                    <i class="fas fa-cogs me-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $contact)
                                <tr class="border-bottom">
                                    <td class="py-2 px-2 fw-semibold small text-center">{{++$i}}</td>
                                    <td class="py-2 px-2">
                                        <span class="text-muted small">{{ \Carbon\Carbon::parse($contact->created_at)->format('M d, Y') }}</span>
                                        <br>
                                        <small class="text-muted small">{{ \Carbon\Carbon::parse($contact->created_at)->format('h:i A') }}</small>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="fw-semibold small">{{ $contact->first_name ." ". $contact->last_name }}</span>
                                    </td>
                                    <td class="py-2 px-2">
                                        @if($contact->email)
                                            <a href="mailto:{{ $contact->email }}" class="text-primary small">
                                                <i class="fas fa-envelope me-1"></i>{{ $contact->email }}
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-2">
                                        @if($contact->phone_number)
                                            <a href="tel:{{ $contact->phone_number }}" class="text-primary small">
                                                <i class="fas fa-phone me-1"></i>{{ $contact->phone_number }}
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-2 text-center">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-outline-primary btn-sm me-1" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-success btn-sm me-1" title="Contact">
                                                <i class="fas fa-phone"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-info btn-sm" title="Email">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Modern Pagination -->
            @if($contacts->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="text-muted mb-0 small">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing {{ $contacts->firstItem() ?? 0 }} to {{ $contacts->lastItem() ?? 0 }} of {{ $contacts->total() }} entries
                            </p>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Page navigation" class="d-flex justify-content-md-end">
                                {{ $contacts->render() }}
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('js')
<script>
function exportToCSV() {
    // Add CSV export functionality here
    console.log('Export to CSV functionality');
}
</script>
@endpush
