@extends('admin.layouts.master')
@push('title')
    Customer Management
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header-modern mb-5">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern mb-2">Customers</h1>
                    <p class="page-subtitle-modern">Manage customer accounts and their information</p>
                </div>
                <a href="{{route('admin.createCustomer')}}" class="btn btn-primary-modern">
                    <i class="fas fa-plus me-2"></i>Add New Customer
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6 col-sm-6">
                <div class="stats-card-modern card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-primary-subtle rounded-lg me-3">
                                <i class="fas fa-users text-primary"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Total Customers</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">{{ $totalCustomers }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6">
                <div class="stats-card-modern card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-success-subtle rounded-lg me-3">
                                <i class="fas fa-user-check text-success"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Active Customers</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">{{ $activeCustomers }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6">
                <div class="stats-card-modern card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-warning-subtle rounded-lg me-3">
                                <i class="fas fa-user-times text-warning"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Inactive Customers</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">{{ $inactiveCustomers }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6">
                <div class="stats-card-modern card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-info-subtle rounded-lg me-3">
                                <i class="fas fa-building text-info"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Total Companies</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">{{ $totalCompanies }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-filter me-2 text-primary"></i>Search & Filters
                </h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.customers')}}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-calendar me-1 text-primary"></i>From Date
                            </label>
                            <input type="date" class="form-control form-control-sm" name="from_date" value="{{request()->from_date}}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-calendar me-1 text-primary"></i>To Date
                            </label>
                            <input type="date" class="form-control form-control-sm" name="to_date" value="{{request()->to_date}}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-search me-1 text-success"></i>Search
                            </label>
                            <input type="text" class="form-control form-control-sm" name="q" placeholder="Search by name or email..." value="{{request()->q}}">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <div class="d-flex gap-2 w-100">
                                <button type="submit" name="submit_type" value="search" class="btn btn-primary btn-sm flex-fill">
                                    <i class="fas fa-search me-1"></i>Search
                                </button>
                                <button type="submit" name="submit_type" value="csv" class="btn btn-success btn-sm">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-list me-2 text-primary"></i>Customers List
                        </h5>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="search-container-modern">
                            <div class="search-wrapper-modern">
                                <div class="search-icon-modern">
                                    <i class="fas fa-search"></i>
                                </div>
                                <input type="text" class="search-input-modern" id="searchInput" placeholder="Search customers by name or email...">
                                <div class="search-clear-modern" id="searchClear" style="display: none;">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="customersTable">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">#</th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">
                                    <i class="fas fa-calendar me-1"></i>Registration Date
                                </th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">
                                    <i class="fas fa-user me-1"></i>Customer Name
                                </th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">
                                    <i class="fas fa-envelope me-1"></i>Email
                                </th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">
                                    <i class="fas fa-phone me-1"></i>Phone
                                </th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small text-center">
                                    <i class="fas fa-toggle-on me-1"></i>Status
                                </th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small text-center">
                                    <i class="fas fa-cogs me-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $key => $customer)
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold small">{{$key + 1}}</td>
                                    <td class="py-3 px-4">
                                        <span class="text-muted small">{{ \Carbon\Carbon::parse($customer->created_at)->format('M d, Y') }}</span>
                                        <br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($customer->created_at)->format('h:i A') }}</small>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="fw-semibold small">{{$customer->first_name}} {{$customer->last_name}}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="text-dark small">{{$customer->email}}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="text-muted small">{{$customer->phone ?: 'N/A'}}</span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if($customer->active)
                                            <span class="badge bg-success-subtle text-success rounded-pill">Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger rounded-pill">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.companies',$customer->id) }}" class="btn btn-outline-info btn-sm me-1" title="View Companies">
                                                <i class="fas fa-building"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#customer_user_update{{$customer->id}}" title="Edit">
                                                <i class="fas fa-edit"></i>
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
            @if($customers->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="text-muted mb-0 small">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing {{ $customers->firstItem() ?? 0 }} to {{ $customers->lastItem() ?? 0 }} of {{ $customers->total() }} entries
                            </p>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Page navigation" class="d-flex justify-content-md-end">
                                {{ $customers->render() }}
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

{{-- Edit Modals --}}
@foreach($customers as $customer)
    <div class="modal fade" id="customer_user_update{{$customer->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white position-relative">
                    <h5 class="modal-title" id="editModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit Customer
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{route("admin.customerUpdate",$customer->id)}}" method="post">
                        @csrf
                        @method("PUT")
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-user me-1 text-primary"></i>First Name
                                </label>
                                <input type="text" required class="form-control form-control-sm" id="first_name" value="{{$customer->first_name}}" name="first_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-user me-1 text-primary"></i>Last Name
                                </label>
                                <input type="text" required class="form-control form-control-sm" value="{{$customer->last_name}}" id="last_name" name="last_name">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-envelope me-1 text-success"></i>Email Address
                            </label>
                            <input type="email" required class="form-control form-control-sm" value="{{$customer->email}}" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-phone me-1 text-warning"></i>Phone Number
                            </label>
                            <input type="text" class="form-control form-control-sm" value="{{$customer->phone}}" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-lock me-1 text-danger"></i>Password
                            </label>
                            <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Leave blank to keep current password">
                        </div>
                        <div class="mb-4">
                            <div class="d-flex align-items-center">
                                <label class="form-label fw-semibold text-muted me-3 mb-0 small" style="min-width: 120px;">Account Status</label>
                                <div class="toggle-switch d-flex align-items-center">
                                    <input type="checkbox" class="toggle-input" name="active" id="active" {{$customer->active ? 'checked' : ''}}>
                                    <label class="toggle-label" for="active">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Customer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection

@push('js')
<script>
    // Enhanced Search functionality
    const searchInput = document.getElementById('searchInput');
    const searchClear = document.getElementById('searchClear');
    const table = document.getElementById('customersTable');
    
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        let visibleCount = 0;
        
        for (let i = 0; i < rows.length; i++) {
            const nameCell = rows[i].getElementsByTagName('td')[2].textContent.toLowerCase();
            const emailCell = rows[i].getElementsByTagName('td')[3].textContent.toLowerCase();
            
            if (nameCell.includes(searchTerm) || emailCell.includes(searchTerm)) {
                rows[i].style.display = '';
                visibleCount++;
            } else {
                rows[i].style.display = 'none';
            }
        }
        
        // Show/hide clear button
        if (searchTerm.length > 0) {
            searchClear.style.display = 'flex';
            searchClear.classList.add('active');
        } else {
            searchClear.style.display = 'none';
            searchClear.classList.remove('active');
        }
    }
    
    // Search input event
    searchInput.addEventListener('input', performSearch);
    searchInput.addEventListener('keyup', performSearch);
    
    // Clear search functionality
    searchClear.addEventListener('click', function() {
        searchInput.value = '';
        searchInput.focus();
        performSearch();
    });
    
    // Focus effects
    searchInput.addEventListener('focus', function() {
        this.parentElement.style.transform = 'scale(1.02)';
    });
    
    searchInput.addEventListener('blur', function() {
        this.parentElement.style.transform = 'scale(1)';
    });
</script>
@endpush
