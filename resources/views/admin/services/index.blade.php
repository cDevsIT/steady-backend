@extends('admin.layouts.master')
@push('title')
    Service Management
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header-modern mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern mb-2">Service Management</h1>
                    <p class="page-subtitle-modern">Manage your business formation services and track their status</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.services.create') }}" class="btn btn-primary-modern">
                        <i class="fas fa-plus me-2"></i> New Service
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6 col-sm-6">
                <div class="stats-card-modern card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-primary-subtle rounded-lg me-3">
                                <i class="fas fa-cogs text-primary"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Total Services</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">{{ $stats['total_services'] }}</h3>
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
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Active Services</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">{{ $stats['active_services'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6">
                <div class="stats-card-modern card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-secondary-subtle rounded-lg me-3">
                                <i class="fas fa-times-circle text-secondary"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Inactive Services</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">{{ $stats['inactive_services'] }}</h3>
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
                                <i class="fas fa-eye text-warning"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Funnel Visible</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">{{ $stats['funnel_visible'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribution and Revenue Sections -->
        <!-- <div class="row g-4 mb-4">
            
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h5 class="card-title-modern mb-0">
                            <i class="fas fa-chart-pie text-primary me-2"></i>
                            Service Distribution
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-4">
                                <div class="text-center">
                                    <h4 class="fw-bold text-primary mb-1">{{ $distributionStats['transferable'] }}</h4>
                                    <p class="text-muted mb-0 small">Transferable</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center">
                                    <h4 class="fw-bold text-success mb-1">{{ $distributionStats['renewable'] }}</h4>
                                    <p class="text-muted mb-0 small">Renewable</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center">
                                    <h4 class="fw-bold text-info mb-1">{{ $distributionStats['state_fees'] }}</h4>
                                    <p class="text-muted mb-0 small">State Fees</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h5 class="card-title-modern mb-0">
                            <i class="fas fa-dollar-sign text-success me-2"></i>
                            $ Revenue Overview
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-4">
                                <div class="text-center">
                                    <h4 class="fw-bold text-success mb-1">${{ number_format($revenueStats['total_value'], 0) }}</h4>
                                    <p class="text-muted mb-0 small">Total Value</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center">
                                    <h4 class="fw-bold text-primary mb-1">${{ number_format($revenueStats['avg_price'], 0) }}</h4>
                                    <p class="text-muted mb-0 small">Avg. Price</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center">
                                    <h4 class="fw-bold text-info mb-1">${{ number_format($revenueStats['renewal_value'], 0) }}</h4>
                                    <p class="text-muted mb-0 small">Renewal Value</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- All Services Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-list me-2 text-primary"></i>All Services
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end align-items-center gap-3">
                            <button type="button" class="btn btn-outline-secondary-modern" data-bs-toggle="modal" data-bs-target="#advancedFiltersModal" style="height: 38px;">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                            <div class="search-container-modern" style="width: 300px;">
                                <div class="search-wrapper-modern">
                                    <div class="search-icon-modern">
                                        <i class="fas fa-search"></i>
                                    </div>
                                    <input type="text" class="search-input-modern" id="searchInput" placeholder="Search services by name...">
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
                    <table class="table table-modern mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="sortable">
                                    ID <i class="fas fa-sort ms-1"></i>
                                </th>
                                <th class="sortable">
                                    Name <i class="fas fa-sort ms-1"></i>
                                </th>
                                <th class="sortable">
                                    Price <i class="fas fa-sort ms-1"></i>
                                </th>
                                <th class="sortable">
                                    Transfer Fee <i class="fas fa-sort ms-1"></i>
                                </th>
                                <th class="sortable">
                                    Renewal Fee <i class="fas fa-sort ms-1"></i>
                                </th>
                                <th class="sortable">
                                    Transferable <i class="fas fa-sort ms-1"></i>
                                </th>
                                <th class="sortable">
                                    Renewable <i class="fas fa-sort ms-1"></i>
                                </th>
                                <th class="sortable">
                                    Status <i class="fas fa-sort ms-1"></i>
                                </th>
                                <th class="sortable">
                                    Visible On Funnel <i class="fas fa-sort ms-1"></i>
                                </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                                <tr>
                                    <td class="fw-semibold">{{ $service->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="mb-0">{{ $service->name }}</h6>
                                                <small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-semibold">${{ number_format($service->initial_price, 2) }}</td>
                                    <td class="fw-semibold">${{ number_format($service->transfer_fee, 2) }}</td>
                                    <td class="fw-semibold">${{ number_format($service->renewal_fee, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $service->is_transferable ? 'primary' : 'secondary' }}">
                                            {{ $service->is_transferable ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $service->is_renewable ? 'primary' : 'secondary' }}">
                                            {{ $service->is_renewable ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $service->status_badge }}">
                                            {{ $service->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $service->visibility_badge }}">
                                            {{ $service->visibility_text }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-link text-muted" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.services.show', $service) }}">
                                                        <i class="fas fa-eye me-2"></i>View Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.services.edit', $service) }}">
                                                        <i class="fas fa-edit me-2"></i>Edit Service
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.services.formBuilder', $service) }}">
                                                        <i class="fas fa-form me-2"></i>User Info
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.services.toggleStatus', $service) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-toggle-{{ $service->is_active ? 'off' : 'on' }} me-2"></i>
                                                            {{ $service->is_active ? 'Deactivate' : 'Activate' }}
                                                        </button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.services.toggleVisibility', $service) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-eye{{ $service->visible_on_funnel ? '-slash' : '' }} me-2"></i>
                                                            {{ $service->visible_on_funnel ? 'Hide from Funnel' : 'Show on Funnel' }}
                                                        </button>
                                                    </form>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" 
                                                          onsubmit="return confirm('Are you sure you want to delete this service?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash me-2"></i>Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-2x mb-3"></i>
                                            <p>No services found. <a href="{{ route('admin.services.create') }}">Create your first service</a></p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($services->hasPages())
                <div class="card-footer bg-transparent border-0 py-3">
                    {{ $services->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- Advanced Filters Modal -->
    <div class="modal fade" id="advancedFiltersModal" tabindex="-1" role="dialog" aria-labelledby="advancedFiltersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-white border-0 py-3">
                    <h5 class="modal-title fw-bold text-dark" id="advancedFiltersModalLabel">
                        <i class="fas fa-filter me-2 text-primary"></i>Advanced Service Filters
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="filterStatus" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-toggle-on me-2 text-primary"></i>Status
                                </label>
                                <select class="form-select form-select-sm" id="filterStatus">
                                    <option value="all">All</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="filterTransferable" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-exchange-alt me-2 text-primary"></i>Transferable
                                </label>
                                <select class="form-select form-select-sm" id="filterTransferable">
                                    <option value="all">All</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="filterStateFees" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-dollar-sign me-2 text-primary"></i>State Fees
                                </label>
                                <select class="form-select form-select-sm" id="filterStateFees">
                                    <option value="all">All</option>
                                    <option value="required">Required</option>
                                    <option value="not_required">Not Required</option>
                                </select>
                            </div>
                        </div>
                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="filterVisibility" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-eye me-2 text-primary"></i>Funnel Visibility
                                </label>
                                <select class="form-select form-select-sm" id="filterVisibility">
                                    <option value="all">All</option>
                                    <option value="visible">Visible</option>
                                    <option value="hidden">Hidden</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="filterRenewable" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-sync-alt me-2 text-primary"></i>Renewable
                                </label>
                                <select class="form-select form-select-sm" id="filterRenewable">
                                    <option value="all">All</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="filterPriceRange" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-dollar-sign me-2 text-primary"></i>Price Range
                                </label>
                                <select class="form-select form-select-sm" id="filterPriceRange">
                                    <option value="all">All Prices</option>
                                    <option value="0-100">$0 - $100</option>
                                    <option value="100-500">$100 - $500</option>
                                    <option value="500-1000">$500 - $1,000</option>
                                    <option value="1000+">$1,000+</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-outline-secondary-modern" id="resetFilters">
                        <i class="fas fa-undo me-2"></i>Reset All
                    </button>
                    <button type="button" class="btn btn-primary-modern" id="applyFilters">
                        <i class="fas fa-search me-2"></i>Apply Filters
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
<style>
    .search-container-modern {
        height: 38px;
    }
    
    .search-input-modern {
        height: 24px;
        line-height: 24px;
    }
    
    .search-icon-modern {
        height: 24px;
        line-height: 24px;
    }
    
    .search-clear-modern {
        height: 24px;
        line-height: 3px;
        position: absolute;
        right: 8px;
        top: 11px;
    }
    
</style>
@endpush

@push('js')
<script>
    // Enhanced Search and Filter functionality
    const searchInput = document.getElementById('searchInput');
    const searchClear = document.getElementById('searchClear');
    const table = document.querySelector('.table-modern');
    
    // Filter elements
    const filterStatus = document.getElementById('filterStatus');
    const filterTransferable = document.getElementById('filterTransferable');
    const filterStateFees = document.getElementById('filterStateFees');
    const filterVisibility = document.getElementById('filterVisibility');
    const filterRenewable = document.getElementById('filterRenewable');
    const filterPriceRange = document.getElementById('filterPriceRange');
    const resetFilters = document.getElementById('resetFilters');
    const applyFilters = document.getElementById('applyFilters');
    
    // Store original rows for filtering
    let originalRows = [];
    
    document.addEventListener('DOMContentLoaded', function() {
        // Store original rows
        const tbody = table.getElementsByTagName('tbody')[0];
        originalRows = Array.from(tbody.getElementsByTagName('tr'));
        
        // Debug: Log table structure
        console.log('Page loaded, checking table structure...');
        console.log('Total rows found:', originalRows.length);
        
        if (originalRows.length > 0 && originalRows[0].getElementsByTagName('td').length > 1) {
            const cells = originalRows[0].getElementsByTagName('td');
            console.log('First row has', cells.length, 'columns');
            console.log('Sample row data:', {
                status: cells[7]?.textContent?.trim(),
                transferable: cells[5]?.textContent?.trim(),
                renewable: cells[6]?.textContent?.trim(),
                visibility: cells[8]?.textContent?.trim(),
                price: cells[2]?.textContent?.trim()
            });
        }
        
        // Add event listeners
        applyFilters.addEventListener('click', function() {
            console.log('Apply filters button clicked');
            applyTableFilters();
        });
        
        resetFilters.addEventListener('click', function() {
            console.log('Reset filters button clicked');
            resetAllFilters();
        });
    });
    
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        let visibleCount = 0;
        
        for (let i = 0; i < rows.length; i++) {
            // Check if it's the "no services" row
            if (rows[i].getElementsByTagName('td').length === 1) {
                continue;
            }
            
            // Get service name from the second column (index 1)
            const nameCell = rows[i].getElementsByTagName('td')[1];
            const serviceName = nameCell ? nameCell.textContent.toLowerCase() : '';
            
            if (serviceName.includes(searchTerm)) {
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
            console.log('No results found for:', searchTerm);
        }
    }
    
    function applyTableFilters() {
        const tbody = table.getElementsByTagName('tbody')[0];
        const rows = tbody.getElementsByTagName('tr');
        let visibleCount = 0;
        let visibleRows = [];
        
        console.log('Applying filters...');
        console.log('Status:', filterStatus.value);
        console.log('Transferable:', filterTransferable.value);
        console.log('Renewable:', filterRenewable.value);
        console.log('Visibility:', filterVisibility.value);
        console.log('Price Range:', filterPriceRange.value);
        
        // First hide all rows
        for (let i = 0; i < rows.length; i++) {
            rows[i].style.display = 'none';
        }
        
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            
            // Check if it's the "no services" row
            if (row.getElementsByTagName('td').length === 1) {
                continue;
            }
            
            let showRow = true;
            
            // Get row data - correct column indices based on table structure
            const cells = row.getElementsByTagName('td');
            if (cells.length < 10) {
                console.log('Row has insufficient columns:', cells.length);
                continue;
            }
            
            // Column indices: 0:ID, 1:Name, 2:Price, 3:Transfer Fee, 4:Renewal Fee, 5:Transferable, 6:Renewable, 7:Status, 8:Visibility, 9:Actions
            const statusCell = cells[7]; // Status column
            const transferableCell = cells[5]; // Transferable column
            const renewableCell = cells[6]; // Renewable column
            const visibilityCell = cells[8]; // Visibility column
            const priceCell = cells[2]; // Price column
            
            // Get text content from badges/spans
            const statusBadge = statusCell.querySelector('.badge');
            const transferableBadge = transferableCell.querySelector('.badge');
            const renewableBadge = renewableCell.querySelector('.badge');
            const visibilityBadge = visibilityCell.querySelector('.badge');
            
            const statusText = statusBadge ? statusBadge.textContent.toLowerCase().trim() : statusCell.textContent.toLowerCase().trim();
            const transferableText = transferableBadge ? transferableBadge.textContent.toLowerCase().trim() : transferableCell.textContent.toLowerCase().trim();
            const renewableText = renewableBadge ? renewableBadge.textContent.toLowerCase().trim() : renewableCell.textContent.toLowerCase().trim();
            const visibilityText = visibilityBadge ? visibilityBadge.textContent.toLowerCase().trim() : visibilityCell.textContent.toLowerCase().trim();
            const priceText = priceCell.textContent.replace(/[$,]/g, '').trim();
            const price = parseFloat(priceText);
            
            console.log('Row', i, 'data:', {
                status: statusText,
                transferable: transferableText,
                renewable: renewableText,
                visibility: visibilityText,
                price: price
            });
            
            // Status filter
            if (filterStatus.value !== 'all') {
                if (filterStatus.value === 'active' && statusText !== 'active') {
                    showRow = false;
                } else if (filterStatus.value === 'inactive' && statusText !== 'inactive') {
                    showRow = false;
                }
            }
            
            // Transferable filter
            if (filterTransferable.value !== 'all' && showRow) {
                if (filterTransferable.value === 'yes' && transferableText !== 'yes') {
                    showRow = false;
                } else if (filterTransferable.value === 'no' && transferableText !== 'no') {
                    showRow = false;
                }
            }
            
            // Renewable filter
            if (filterRenewable.value !== 'all' && showRow) {
                if (filterRenewable.value === 'yes' && renewableText !== 'yes') {
                    showRow = false;
                } else if (filterRenewable.value === 'no' && renewableText !== 'no') {
                    showRow = false;
                }
            }
            
            // Visibility filter
            if (filterVisibility.value !== 'all' && showRow) {
                if (filterVisibility.value === 'visible' && visibilityText !== 'visible') {
                    showRow = false;
                } else if (filterVisibility.value === 'hidden' && visibilityText !== 'hidden') {
                    showRow = false;
                }
            }
            
            // Price range filter
            if (filterPriceRange.value !== 'all' && showRow) {
                console.log('Checking price:', price, 'against range:', filterPriceRange.value);
                
                switch (filterPriceRange.value) {
                    case '0-100':
                        if (price > 100) {
                            showRow = false;
                        }
                        break;
                    case '100-500':
                        if (price < 100 || price > 500) {
                            showRow = false;
                        }
                        break;
                    case '500-1000':
                        if (price < 500 || price > 1000) {
                            showRow = false;
                        }
                        break;
                    case '1000+':
                        if (price <= 1000) {
                            showRow = false;
                        }
                        break;
                }
            }
            
            // Add to visible rows if it passes all filters
            if (showRow) {
                visibleRows.push(row);
                visibleCount++;
                console.log('Row', i, 'matches filters');
            } else {
                console.log('Row', i, 'filtered out');
            }
        }
        
        // Show the filtered rows
        visibleRows.forEach(row => {
            row.style.display = '';
        });
        
        // Hide pagination when filtering
        const paginationSection = document.querySelector('.card-footer');
        if (paginationSection) {
            paginationSection.style.display = 'none';
        }
        
        // Show filtered count
        showFilteredInfo(visibleCount);
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('advancedFiltersModal'));
        if (modal) {
            modal.hide();
        }
        
        console.log('Filters applied. Total visible rows:', visibleCount);
    }
    
    function showFilteredInfo(count) {
        // Remove existing filtered info
        const existingInfo = document.getElementById('filteredInfo');
        if (existingInfo) {
            existingInfo.remove();
        }
        
        // Create new filtered info
        const filteredInfo = document.createElement('div');
        filteredInfo.className = 'card-footer bg-white border-0 py-3';
        filteredInfo.id = 'filteredInfo';
        filteredInfo.innerHTML = `
            <div class="row align-items-center">
                <div class="col-md-12">
                    <p class="text-muted mb-0 small">
                        <i class="fas fa-filter me-1 text-primary"></i>
                        Showing ${count} filtered services
                        <button type="button" class="btn btn-sm btn-outline-secondary ms-3" onclick="clearAllFilters()">
                            <i class="fas fa-times me-1"></i>Clear Filters
                        </button>
                    </p>
                </div>
            </div>
        `;
        
        // Insert after table
        const cardBody = document.querySelector('.card-body.p-0');
        cardBody.parentElement.appendChild(filteredInfo);
    }
    
    function resetAllFilters() {
        // Reset filter dropdowns
        filterStatus.value = 'all';
        filterTransferable.value = 'all';
        filterStateFees.value = 'all';
        filterVisibility.value = 'all';
        filterRenewable.value = 'all';
        filterPriceRange.value = 'all';
        
        // Reset search
        searchInput.value = '';
        searchClear.style.display = 'none';
        searchClear.classList.remove('active');
        
        // Show all rows
        const tbody = table.getElementsByTagName('tbody')[0];
        const rows = tbody.getElementsByTagName('tr');
        for (let i = 0; i < rows.length; i++) {
            rows[i].style.display = '';
        }
        
        // Show pagination
        const paginationSection = document.querySelector('.card-footer');
        if (paginationSection && paginationSection.id !== 'filteredInfo') {
            paginationSection.style.display = 'block';
        }
        
        // Remove filtered info
        const filteredInfo = document.getElementById('filteredInfo');
        if (filteredInfo) {
            filteredInfo.remove();
        }
        
        console.log('All filters reset');
    }
    
    // Global function for clear button in filtered info
    function clearAllFilters() {
        resetAllFilters();
    }
    
    
    // Event listeners
    searchInput.addEventListener('input', performSearch);
    searchInput.addEventListener('keyup', performSearch);
    
    searchClear.addEventListener('click', function() {
        searchInput.value = '';
        searchInput.focus();
        performSearch();
    });
    
    applyFilters.addEventListener('click', applyTableFilters);
    resetFilters.addEventListener('click', resetAllFilters);
    
    // Focus effects for search
    searchInput.addEventListener('focus', function() {
        this.parentElement.style.transform = 'scale(1.02)';
    });
    
    searchInput.addEventListener('blur', function() {
        this.parentElement.style.transform = 'scale(1)';
    });
</script>
@endpush

