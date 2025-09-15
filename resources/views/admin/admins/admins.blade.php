@extends('admin.layouts.master')
@push('title')
    Admin User Management
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern">Admin Users</h1>
                    <p class="page-subtitle-modern">Manage system administrators and their permissions</p>
                </div>
                <button class="btn btn-primary-modern" data-bs-toggle="modal" data-bs-target="#admin_user_add">
                    <i class="fas fa-plus-circle me-2"></i>Add New Admin
                </button>
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
                                <h6 class="stats-label-modern text-muted mb-1">Total Admins</h6>
                                <h3 class="stats-value-modern mb-0">{{ $admins->count() }}</h3>
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
                                <i class="fas fa-user-check text-success"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Active Admins</h6>
                                <h3 class="stats-value-modern mb-0">{{ $admins->where('active', true)->count() }}</h3>
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
                                <i class="fas fa-user-times text-warning"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Inactive Admins</h6>
                                <h3 class="stats-value-modern mb-0">{{ $admins->where('active', false)->count() }}</h3>
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
                                <i class="fas fa-shield-alt text-info"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">System Access</h6>
                                <h3 class="stats-value-modern mb-0">{{ $admins->where('active', true)->count() }}/{{ $admins->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Main Content Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-list me-2 text-primary"></i>Admin Users List
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            <div class="search-container-modern" style="width: 300px;">
                                <div class="search-wrapper-modern">
                                    <div class="search-icon-modern">
                                        <i class="fas fa-search"></i>
                                    </div>
                                    <input type="text" class="search-input-modern" id="searchInput" placeholder="Search admins by name or email...">
                                    <div class="search-clear-modern" id="searchClear" style="display: none;">
                                        <i class="fas fa-times"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="adminsTable">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 50px;">#</th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 150px;">
                                    <i class="fas fa-user me-1"></i>Name
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 200px;">
                                    <i class="fas fa-envelope me-1"></i>Email
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 120px;">
                                    <i class="fas fa-phone me-1"></i>Phone
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 100px;">
                                    <i class="fas fa-toggle-on me-1"></i>Status
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 100px;">
                                    <i class="fas fa-cogs me-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $key => $admin)
                                <tr class="border-bottom">
                                    <td class="py-2 px-2 fw-semibold small text-center">{{$key + 1}}</td>
                                    <td class="py-2 px-2">
                                        <span class="fw-semibold small">{{$admin->first_name}} {{$admin->last_name}}</span>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="text-dark small">{{$admin->email}}</span>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="text-muted small">{{$admin->phone ?: 'N/A'}}</span>
                                    </td>
                                    <td class="py-2 px-2 text-center">
                                        @if($admin->active)
                                            <span class="badge bg-success-subtle text-success rounded-pill">Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger rounded-pill">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-2 text-center">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#admin_user_edit{{$admin->id}}" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#admin_user_delete{{$admin->id}}" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

{{--    Add Modal--}}
    <div class="modal fade" id="admin_user_add" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-white border-0 py-3">
                    <h5 class="modal-title fw-bold text-dark" id="addModalLabel">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>Add New Admin
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{route("admin.user")}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-user me-2 text-primary"></i>First Name
                                </label>
                                <input type="text" required class="form-control form-control-sm" id="first_name" name="first_name" placeholder="Enter first name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-user me-2 text-primary"></i>Last Name
                                </label>
                                <input type="text" required class="form-control form-control-sm" id="last_name" name="last_name" placeholder="Enter last name">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-envelope me-2 text-success"></i>Email Address
                            </label>
                            <input type="email" required class="form-control form-control-sm" id="email" name="email" placeholder="Enter email address">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-phone me-2 text-warning"></i>Phone Number
                            </label>
                            <input type="text" class="form-control form-control-sm" id="phone" name="phone" placeholder="Enter phone number">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-lock me-2 text-danger"></i>Password
                            </label>
                            <input type="password" required class="form-control form-control-sm" id="password" name="password" placeholder="Enter password">
                        </div>
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="active" id="active">
                                <label class="form-check-label fw-semibold text-muted small" for="active">
                                    <i class="fas fa-toggle-on me-2 text-success"></i>Active Account
                                </label>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-outline-secondary-modern btn-sm" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary-modern btn-sm">
                                <i class="fas fa-save me-2"></i>Create Admin User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

{{-- Edit Modals --}}
@foreach($admins as $admin)
    <div class="modal fade" id="admin_user_edit{{$admin->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-white border-0 py-3">
                    <h5 class="modal-title fw-bold text-dark" id="editModalLabel">
                        <i class="fas fa-edit me-2 text-primary"></i>Edit Admin User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{route("admin.update",$admin->id)}}" method="post">
                        @csrf
                        @method("PUT")
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-user me-2 text-primary"></i>First Name
                                </label>
                                <input type="text" required class="form-control form-control-sm" id="first_name" value="{{$admin->first_name}}" name="first_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-user me-2 text-primary"></i>Last Name
                                </label>
                                <input type="text" required class="form-control form-control-sm" value="{{$admin->last_name}}" id="last_name" name="last_name">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-envelope me-2 text-success"></i>Email Address
                            </label>
                            <input type="email" required class="form-control form-control-sm" value="{{$admin->email}}" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-phone me-2 text-warning"></i>Phone Number
                            </label>
                            <input type="text" class="form-control form-control-sm" value="{{$admin->phone}}" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-lock me-2 text-danger"></i>Password
                            </label>
                            <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Leave blank to keep current password">
                        </div>
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="active" id="active" {{$admin->active ? 'checked' : ''}}>
                                <label class="form-check-label fw-semibold text-muted small" for="active">
                                    <i class="fas fa-toggle-on me-2 text-success"></i>Active Account
                                </label>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-outline-secondary-modern btn-sm" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary-modern btn-sm">
                                <i class="fas fa-save me-2"></i>Update Admin User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- Delete Confirmation Modals --}}
@foreach($admins as $admin)
    <div class="modal fade" id="admin_user_delete{{$admin->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-white border-0 py-3">
                    <h5 class="modal-title fw-bold text-dark" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2 text-danger"></i>Confirm Delete
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="mb-4">
                        <i class="fas fa-user-times fa-3x text-danger mb-3"></i>
                        <h5 class="fw-bold">Are you sure?</h5>
                        <p class="text-muted">You want to delete the admin user <strong class="text-dark">{{$admin->first_name}} {{$admin->last_name}}</strong>?</p>
                        <p class="text-danger small">
                            <i class="fas fa-info-circle me-1"></i>This action cannot be undone and will remove all access.
                        </p>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary-modern btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <form action="{{route('admin.delete', $admin->id)}}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-trash me-2"></i>Delete
                        </button>
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
    const table = document.getElementById('adminsTable');
    
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        let visibleCount = 0;
        
        for (let i = 0; i < rows.length; i++) {
            const nameCell = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
            const emailCell = rows[i].getElementsByTagName('td')[2].textContent.toLowerCase();
            
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
