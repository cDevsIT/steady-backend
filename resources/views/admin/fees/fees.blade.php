@extends('admin.layouts.master')
@push('title')
    State Fees Management
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern">State Fees</h1>
                    <p class="page-subtitle-modern">Manage state registration fees and renewal costs</p>
                </div>
                <button class="btn btn-primary-modern" data-bs-toggle="modal" data-bs-target="#state_fee_add">
                    <i class="fas fa-plus-circle me-2"></i>Add New Fee
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
                                <i class="fas fa-map-marker-alt text-primary"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Total States</h6>
                                <h3 class="stats-value-modern mb-0">{{ $fees->total() }}</h3>
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
                                <i class="fas fa-dollar-sign text-success"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Avg. Fee</h6>
                                <h3 class="stats-value-modern mb-0">${{ number_format($fees->avg('fees'), 0) }}</h3>
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
                                <i class="fas fa-sync-alt text-warning"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Avg. Renewal</h6>
                                <h3 class="stats-value-modern mb-0">${{ number_format($fees->avg('renewal_fee'), 0) }}</h3>
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
                                <i class="fas fa-exchange-alt text-info"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Avg. Transfer</h6>
                                <h3 class="stats-value-modern mb-0">${{ number_format($fees->avg('transfer_fee'), 0) }}</h3>
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
                            <i class="fas fa-list me-2 text-primary"></i>State Fees List
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            <div class="search-container-modern" style="width: 300px;">
                                <div class="search-wrapper-modern">
                                    <div class="search-icon-modern">
                                        <i class="fas fa-search"></i>
                                    </div>
                                    <input type="text" class="search-input-modern" id="searchInput" placeholder="Search states by name...">
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
                    <table class="table table-hover mb-0" id="feesTable">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 50px;">#</th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 150px;">
                                    <i class="fas fa-map-marker-alt me-1"></i>State Name
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 120px;">
                                    <i class="fas fa-dollar-sign me-1"></i>Registration Fee
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 120px;">
                                    <i class="fas fa-sync-alt me-1"></i>Renewal Fee
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 120px;">
                                    <i class="fas fa-exchange-alt me-1"></i>Transfer Fee
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 100px;">
                                    <i class="fas fa-cogs me-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fees as $fee)
                                <tr class="border-bottom">
                                    <td class="py-2 px-2 fw-semibold small text-center">{{++$i}}</td>
                                    <td class="py-2 px-2">
                                        <span class="fw-semibold small">{{$fee->state_name}}</span>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="badge bg-success-subtle text-success rounded-pill fw-semibold">
                                            ${{number_format($fee->fees, 2)}}
                                        </span>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="badge bg-warning-subtle text-warning rounded-pill fw-semibold">
                                            ${{number_format($fee->renewal_fee, 2)}}
                                        </span>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="badge bg-info-subtle text-info rounded-pill fw-semibold">
                                            ${{number_format($fee->transfer_fee, 2)}}
                                        </span>
                                    </td>
                                    <td class="py-2 px-2 text-center">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#state_fee_edit{{$fee->id}}" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete_modal{{$fee->id}}" title="Delete">
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
            
            <!-- Modern Pagination -->
            @if($fees->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="text-muted mb-0 small">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing {{ $fees->firstItem() ?? 0 }} to {{ $fees->lastItem() ?? 0 }} of {{ $fees->total() }} entries
                            </p>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Page navigation" class="d-flex justify-content-md-end">
                                <ul class="pagination pagination-sm mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($fees->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $fees->previousPageUrl() }}" rel="prev">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($fees->getUrlRange(1, $fees->lastPage()) as $page => $url)
                                        @if ($page == $fees->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($fees->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $fees->nextPageUrl() }}" rel="next">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

{{--    Add Modal--}}
    <div class="modal fade" id="state_fee_add" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-white border-0 py-3">
                    <h5 class="modal-title fw-bold text-dark" id="addModalLabel">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>Add New State Fee
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{route('admin.fees.store')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="state_name" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>State Name
                            </label>
                            <input type="text" class="form-control form-control-sm" id="state_name" name="state_name" placeholder="Enter state name">
                        </div>
                        <div class="mb-3">
                            <label for="fees" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-dollar-sign me-2 text-success"></i>Registration Fee
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="any" class="form-control form-control-sm" id="fees" name="fees" placeholder="0.00">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="renewal_fee" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-sync-alt me-2 text-warning"></i>Renewal Fee
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="any" class="form-control form-control-sm" id="renewal_fee" name="renewal_fee" placeholder="0.00">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="transfer_fee" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-exchange-alt me-2 text-info"></i>Transfer Fee
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="any" class="form-control form-control-sm" id="transfer_fee" name="transfer_fee" placeholder="0.00">
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-outline-secondary-modern btn-sm" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary-modern btn-sm">
                                <i class="fas fa-save me-2"></i>Save State Fee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

{{-- Edit Modals --}}
@foreach($fees as $fee)
    <div class="modal fade" id="state_fee_edit{{$fee->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-white border-0 py-3">
                    <h5 class="modal-title fw-bold text-dark" id="editModalLabel">
                        <i class="fas fa-edit me-2 text-primary"></i>Edit State Fee
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{route('admin.fees.update', $fee)}}" method="post">
                        @csrf
                        @method("PUT")
                        <div class="mb-3">
                            <label for="state_name" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>State Name
                            </label>
                            <input type="text" value="{{$fee->state_name}}" class="form-control form-control-sm" id="state_name" name="state_name">
                        </div>
                        <div class="mb-3">
                            <label for="fees" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-dollar-sign me-2 text-success"></i>Registration Fee
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" value="{{$fee->fees}}" step="any" class="form-control form-control-sm" id="fees" name="fees">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="renewal_fee" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-sync-alt me-2 text-warning"></i>Renewal Fee
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" value="{{$fee->renewal_fee}}" step="any" class="form-control form-control-sm" id="renewal_fee" name="renewal_fee">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="transfer_fee" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-exchange-alt me-2 text-info"></i>Transfer Fee
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" value="{{$fee->transfer_fee}}" step="any" class="form-control form-control-sm" id="transfer_fee" name="transfer_fee">
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-outline-secondary-modern btn-sm" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary-modern btn-sm">
                                <i class="fas fa-save me-2"></i>Update State Fee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- Delete Confirmation Modals --}}
@foreach($fees as $fee)
    <div class="modal fade" id="delete_modal{{$fee->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                        <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                        <h5 class="fw-bold">Are you sure?</h5>
                        <p class="text-muted">You want to delete the state fee for <strong class="text-dark">{{$fee->state_name}}</strong>?</p>
                        <p class="text-danger small">
                            <i class="fas fa-info-circle me-1"></i>This action cannot be undone.
                        </p>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary-modern" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <form action="{{route('admin.fees.destroy', $fee->id)}}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
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
    const table = document.getElementById('feesTable');
    
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        let visibleCount = 0;
        
        for (let i = 0; i < rows.length; i++) {
            const stateName = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
            if (stateName.includes(searchTerm)) {
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
        
        // Add visual feedback for no results
        if (visibleCount === 0 && searchTerm.length > 0) {
            // You can add a "no results" message here if needed
            console.log('No results found for:', searchTerm);
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




