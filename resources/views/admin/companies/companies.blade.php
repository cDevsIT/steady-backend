@extends('admin.layouts.master')
@push('title')
    Company Management
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header-modern mb-5">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern mb-2">Companies</h1>
                    <p class="page-subtitle-modern">Manage company registrations and business information</p>
                </div>
                <a href="{{route('admin.companyCreate')}}" data-toggle="modal" data-target="#add" data-whatever="@mdo" class="btn btn-primary-modern">
                    <i class="fas fa-plus me-2"></i>Add New Company
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="stats-card-modern card border-0 shadow-sm h-100" style="cursor: pointer;" onclick="filterByType('all')">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-primary-subtle rounded-lg me-3">
                                <i class="fas fa-building text-primary"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Total Companies</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">{{ $totalCompanies }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="stats-card-modern card border-0 shadow-sm h-100" style="cursor: pointer;" onclick="filterByType('llc')">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-success-subtle rounded-lg me-3">
                                <i class="fas fa-chart-line text-success"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">LLC</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">{{ $llcCompanies }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="stats-card-modern card border-0 shadow-sm h-100" style="cursor: pointer;" onclick="filterByType('s_corp')">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-warning-subtle rounded-lg me-3">
                                <i class="fas fa-file-contract text-warning"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">S Corp</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">{{ $sCorpCompanies }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="stats-card-modern card border-0 shadow-sm h-100" style="cursor: pointer;" onclick="filterByType('c_corp')">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-info-subtle rounded-lg me-3">
                                <i class="fas fa-briefcase text-info"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">C Corp</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">{{ $cCorpCompanies }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="stats-card-modern card border-0 shadow-sm h-100" style="cursor: pointer;" onclick="filterByType('non_profit')">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-danger-subtle rounded-lg me-3">
                                <i class="fas fa-heart text-danger"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Non Profit</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">{{ $nonProfitCompanies }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="stats-card-modern card border-0 shadow-sm h-100" style="cursor: pointer;" onclick="filterByType('partnership')">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-secondary-subtle rounded-lg me-3">
                                <i class="fas fa-handshake text-secondary"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Partnership</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">{{ $partnershipCompanies }}</h3>
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
                <form action="{{route('admin.companies')}}" method="GET">
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
                            <input type="text" class="form-control form-control-sm" name="q" placeholder="Search by company or customer name..." value="{{request()->q}}">
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
                            <i class="fas fa-list me-2 text-primary"></i>Companies List
                        </h5>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="search-container-modern">
                            <div class="search-wrapper-modern">
                                <div class="search-icon-modern">
                                    <i class="fas fa-search"></i>
                                </div>
                                <input type="text" class="search-input-modern" id="searchInput" placeholder="Search companies by name or customer...">
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
                    <table class="table table-hover mb-0" id="companiesTable">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">#</th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">
                                    <i class="fas fa-building me-1"></i>Company Name
                                </th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">
                                    <i class="fas fa-calendar me-1"></i>Registration Date
                                </th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">
                                    <i class="fas fa-user me-1"></i>Customer
                                </th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">
                                    <i class="fas fa-briefcase me-1"></i>Business Type
                                </th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">
                                    <i class="fas fa-industry me-1"></i>Industry
                                </th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small text-center">
                                    <i class="fas fa-users me-1"></i>Ownership
                                </th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">
                                    <i class="fas fa-cogs me-1"></i>Actions
                                </th>
                    </tr>
                    </thead>
                    <tbody>
                            @foreach($companies as $key => $company)
                                <tr class="border-bottom" data-business-type="{{ $company->business_type }}">
                                    <td class="py-3 px-4 fw-semibold small">{{ ($companies->currentPage() - 1) * $companies->perPage() + $key + 1 }}</td>
                                    <td class="py-3 px-4">
                                        <span class="fw-semibold text-dark">{{$company->company_name}}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="text-muted small">{{ \Carbon\Carbon::parse($company->created_at)->format('M d, Y') }}</span>
                                        <br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($company->created_at)->format('h:i A') }}</small>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="fw-semibold small">{{$company->first_name}} {{$company->last_name}}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="badge bg-primary-subtle text-primary rounded-pill">
                                            @php
                                                $businessTypeDisplay = '';
                                                switch($company->business_type) {
                                                    case 'LLC':
                                                        $businessTypeDisplay = 'LLC';
                                                        break;
                                                    case 's_corp':
                                                        $businessTypeDisplay = 'S Corp';
                                                        break;
                                                    case 'c_corp':
                                                        $businessTypeDisplay = 'C Corp';
                                                        break;
                                                    case 'non_profit':
                                                        $businessTypeDisplay = 'Non Profit';
                                                        break;
                                                    case 'partnership':
                                                        $businessTypeDisplay = 'Partnership';
                                                        break;
                                                    case 'corporation':
                                                        $businessTypeDisplay = 'Corporation';
                                                        break;
                                                    default:
                                                        $businessTypeDisplay = ucfirst(str_replace('_', ' ', $company->business_type));
                                                }
                                            @endphp
                                            {{ $businessTypeDisplay }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="text-muted small">{{$company->type_of_industry ?: 'N/A'}}</span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <a href="{{route('admin.companyOwner',$company)}}" class="badge bg-success-subtle text-success rounded-pill">
                                            {{$company->number_of_ownership}} Owner{{$company->number_of_ownership > 1 ? 's' : ''}}
                                        </a>
                            </td>
                                    <td class="py-3 px-4">
                                        <div class="btn-group" role="group">
                                            <a href="{{route('admin.orders',$company->id)}}" class="btn btn-outline-success btn-sm me-1" title="View Orders">
                                                <i class="fas fa-shopping-cart"></i>
                                            </a>
                                            <a href="{{route('admin.companyOwner',$company->id)}}" class="btn btn-outline-info btn-sm" title="View Owners">
                                                <i class="fas fa-users"></i>
                                            </a>
                                        </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>

            <!-- Modern Pagination -->
            @if($companies->hasPages())
                <div class="card-footer bg-white border-0 py-3" id="paginationSection">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="text-muted mb-0 small">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing {{ $companies->firstItem() ?? 0 }} to {{ $companies->lastItem() ?? 0 }} of {{ $companies->total() }} entries
                            </p>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Page navigation" class="d-flex justify-content-md-end">
                                {{ $companies->render() }}
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Add Company Modal --}}
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white position-relative">
                    <h5 class="modal-title" id="addModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Add New Company
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{route("admin.companyCreate")}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="customer" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-user me-1 text-primary"></i>Customer
                            </label>
                            <select name="customer" id="customer" required class="form-control form-control-sm">
                                <option value="">Select a Customer</option>
                                @foreach($customers as $customer)
                                    <option {{request()->user == $customer->id ? 'selected' : ''}} value="{{$customer->id }}">{{$customer->first_name}} {{ $customer->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="company_name" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-building me-1 text-success"></i>Company Name
                            </label>
                            <input type="text" required class="form-control form-control-sm" id="company_name" name="company_name">
                        </div>
                        <div class="mb-3">
                            <label for="business_type" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-briefcase me-1 text-warning"></i>Business Type
                            </label>
                            <input type="text" required class="form-control form-control-sm" id="business_type" name="business_type">
                        </div>
                        <div class="mb-3">
                            <label for="type_of_industry" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-industry me-1 text-info"></i>Industry Type
                            </label>
                            <input type="text" required class="form-control form-control-sm" id="type_of_industry" name="type_of_industry">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-phone me-1 text-danger"></i>Phone
                            </label>
                            <input type="text" class="form-control form-control-sm" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-lock me-1 text-secondary"></i>Password
                            </label>
                            <input type="password" class="form-control form-control-sm" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-lock me-1 text-secondary"></i>Confirm Password
                            </label>
                            <input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation">
                        </div>
                        <div class="mb-4">
                            <div class="d-flex align-items-center">
                                <label class="form-label fw-semibold text-muted me-3 mb-0 small" style="min-width: 120px;">Account Status</label>
                                <div class="toggle-switch d-flex align-items-center">
                                    <input type="checkbox" class="toggle-input" name="active" id="active" checked>
                                    <label class="toggle-label" for="active">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Company
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    // Enhanced Search functionality
    const searchInput = document.getElementById('searchInput');
    const searchClear = document.getElementById('searchClear');
    const table = document.getElementById('companiesTable');
    
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        let visibleCount = 0;
        
        for (let i = 0; i < rows.length; i++) {
            const customerCell = rows[i].getElementsByTagName('td')[3].textContent.toLowerCase();
            const companyCell = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
            
            if (customerCell.includes(searchTerm) || companyCell.includes(searchTerm)) {
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
        // Also clear any active filters
        filterByType('all');
    });
    
    // Focus effects
    searchInput.addEventListener('focus', function() {
        this.parentElement.style.transform = 'scale(1.02)';
    });
    
    searchInput.addEventListener('blur', function() {
        this.parentElement.style.transform = 'scale(1)';
    });

    function filterByType(type) {
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        let visibleCount = 0;
        const paginationSection = document.getElementById('paginationSection');
        const itemsPerPage = 20;
        let visibleRows = [];
        
        console.log(`Filtering by type: ${type}`);
        
        // First, hide all rows
        for (let i = 0; i < rows.length; i++) {
            rows[i].style.display = 'none';
        }
        
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const businessTypeData = row.getAttribute('data-business-type');
            const businessTypeCell = row.getElementsByTagName('td')[4]; // Business type column (5th column, index 4)
            const businessTypeText = businessTypeCell.textContent.trim();
            
            console.log(`Row ${i + 1}: Data attribute = "${businessTypeData}", Display text = "${businessTypeText}"`);
            
            if (type === 'all') {
                row.style.display = '';
                visibleCount++;
                visibleRows.push(row);
            } else {
                // Check for exact matches and partial matches
                let shouldShow = false;
                
                switch(type) {
                    case 'llc':
                        shouldShow = businessTypeData === 'llc' || businessTypeText === 'LLC';
                        break;
                    case 's_corp':
                        shouldShow = businessTypeData === 's_corp' || businessTypeText === 'S Corp' || 
                                   businessTypeData.includes('S Corp') || businessTypeText.includes('S Corp') ||
                                   businessTypeData.includes('S Corporation') || businessTypeText.includes('S Corporation');
                        break;
                    case 'c_corp':
                        shouldShow = businessTypeData === 'c_corp' || businessTypeText === 'C Corp' ||
                                   businessTypeData.includes('C Corp') || businessTypeText.includes('C Corp') ||
                                   businessTypeData.includes('C Corporation') || businessTypeText.includes('C Corporation');
                        break;
                    case 'non_profit':
                        shouldShow = businessTypeData === 'non_profit' || businessTypeText === 'Non-Profit' ||
                                   businessTypeData.includes('Non Profit') || businessTypeText.includes('Non Profit');
                        break;
                    case 'partnership':
                        shouldShow = businessTypeData === 'partnership' || businessTypeText === 'Partnership';
                        break;
                    default:
                        shouldShow = businessTypeData.toLowerCase().includes(type.toLowerCase()) || 
                                   businessTypeText.toLowerCase().includes(type.toLowerCase());
                }
                
                if (shouldShow) {
                    visibleRows.push(row);
                    visibleCount++;
                    console.log(`✓ Row ${i + 1} matches - showing`);
                } else {
                    console.log(`✗ Row ${i + 1} doesn't match - hiding`);
                }
            }
        }
        
        // Handle pagination visibility
        if (type !== 'all') {
            // Hide original pagination when filtering
            if (paginationSection) {
                paginationSection.style.display = 'none';
            }
            
            // Show filtered results with pagination if needed
            showFilteredResultsWithPagination(visibleRows, type, visibleCount, itemsPerPage);
            
            searchClear.style.display = 'flex';
            searchClear.classList.add('active');
            // Update search input to show current filter
            searchInput.value = `Filtered by: ${type}`;
        } else {
            // Show original pagination when no filter
            if (paginationSection) {
                paginationSection.style.display = 'block';
            }
            
            // Remove filtered info
            const existingFilteredInfo = document.getElementById('filteredInfo');
            if (existingFilteredInfo) {
                existingFilteredInfo.remove();
            }
            
            searchClear.style.display = 'none';
            searchClear.classList.remove('active');
            searchInput.value = '';
        }
        
        console.log(`Filtered by: ${type}, Showing: ${visibleCount} companies`);
    }
    
    function showFilteredResultsWithPagination(visibleRows, filterType, totalCount, itemsPerPage) {
        const currentPage = 1; // Always start from page 1 when filtering
        const totalPages = Math.ceil(totalCount / itemsPerPage);
        
        // If 20 or fewer results, show all rows
        if (totalCount <= itemsPerPage) {
            visibleRows.forEach((row, index) => {
                row.style.display = '';
                // Update serial number for filtered results
                const serialCell = row.getElementsByTagName('td')[0];
                if (serialCell) {
                    serialCell.textContent = index + 1;
                }
            });
        } else {
            // If more than 20 results, apply pagination
            visibleRows.forEach(row => {
                row.style.display = 'none';
            });
            
            // Show only rows for current page
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, totalCount);
            
            for (let i = startIndex; i < endIndex; i++) {
                if (visibleRows[i]) {
                    visibleRows[i].style.display = '';
                    // Update serial number for filtered results
                    const serialCell = visibleRows[i].getElementsByTagName('td')[0];
                    if (serialCell) {
                        serialCell.textContent = i + 1;
                    }
                }
            }
        }
        
        // Remove existing filtered info
        const existingFilteredInfo = document.getElementById('filteredInfo');
        if (existingFilteredInfo) {
            existingFilteredInfo.remove();
        }
        
        // Create filtered info with pagination if needed
        const filteredInfo = document.createElement('div');
        filteredInfo.className = 'card-footer bg-white border-0 py-3';
        filteredInfo.id = 'filteredInfo';
        
        let paginationHTML = '';
        let startIndex = 0;
        let endIndex = totalCount;
        
        if (totalPages > 1) {
            startIndex = (currentPage - 1) * itemsPerPage;
            endIndex = Math.min(startIndex + itemsPerPage, totalCount);
            
            paginationHTML = `
                <div class="col-md-6">
                    <nav aria-label="Filtered results pagination" class="d-flex justify-content-md-end">
                        <ul class="pagination pagination-sm mb-0">
                            ${currentPage > 1 ? `
                                <li class="page-item">
                                    <button class="page-link" onclick="changeFilteredPage(${currentPage - 1}, '${filterType}')">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                </li>
                            ` : ''}
                            
                            ${generatePageNumbers(currentPage, totalPages, filterType)}
                            
                            ${currentPage < totalPages ? `
                                <li class="page-item">
                                    <button class="page-link" onclick="changeFilteredPage(${currentPage + 1}, '${filterType}')">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </li>
                            ` : ''}
                        </ul>
                    </nav>
                </div>
            `;
        }
        
        filteredInfo.innerHTML = `
            <div class="row align-items-center">
                <div class="col-md-${totalPages > 1 ? '6' : '12'}">
                    <p class="text-muted mb-0 small">
                        <i class="fas fa-filter me-1 text-primary"></i>
                        Showing ${startIndex + 1} to ${endIndex} of ${totalCount} filtered companies of type: <strong>${filterType.toUpperCase()}</strong>
                        <button type="button" class="btn btn-sm btn-outline-secondary ms-3" onclick="clearAllFilters()">
                            <i class="fas fa-times me-1"></i>Clear Filter
                        </button>
                    </p>
                </div>
                ${paginationHTML}
            </div>
        `;
        
        // Insert filtered info after the table
        const tableContainer = document.querySelector('.table-responsive').parentElement;
        tableContainer.parentElement.insertBefore(filteredInfo, tableContainer.nextSibling);
        
        // Store filtered data for pagination
        window.filteredData = {
            rows: visibleRows,
            type: filterType,
            totalCount: totalCount,
            itemsPerPage: itemsPerPage,
            currentPage: currentPage
        };
    }
    
    function generatePageNumbers(currentPage, totalPages, filterType) {
        let pageNumbers = '';
        const maxVisiblePages = 5;
        
        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
        
        if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }
        
        for (let i = startPage; i <= endPage; i++) {
            pageNumbers += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <button class="page-link" onclick="changeFilteredPage(${i}, '${filterType}')">${i}</button>
                </li>
            `;
        }
        
        return pageNumbers;
    }
    
    function changeFilteredPage(page, filterType) {
        if (!window.filteredData || window.filteredData.type !== filterType) {
            return;
        }
        
        const { rows, totalCount, itemsPerPage } = window.filteredData;
        const totalPages = Math.ceil(totalCount / itemsPerPage);
        
        if (page < 1 || page > totalPages) {
            return;
        }
        
        // Hide all rows
        rows.forEach(row => {
            row.style.display = 'none';
        });
        
        // Show rows for current page
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, totalCount);
        
        for (let i = startIndex; i < endIndex; i++) {
            if (rows[i]) {
                rows[i].style.display = '';
                // Update serial number
                const serialCell = rows[i].getElementsByTagName('td')[0];
                if (serialCell) {
                    serialCell.textContent = i + 1;
                }
            }
        }
        
        // Update filtered info
        const filteredInfo = document.getElementById('filteredInfo');
        if (filteredInfo) {
            let paginationHTML = '';
            if (totalPages > 1) {
                paginationHTML = `
                    <div class="col-md-6">
                        <nav aria-label="Filtered results pagination" class="d-flex justify-content-md-end">
                            <ul class="pagination pagination-sm mb-0">
                                ${page > 1 ? `
                                    <li class="page-item">
                                        <button class="page-link" onclick="changeFilteredPage(${page - 1}, '${filterType}')">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                    </li>
                                ` : ''}
                                
                                ${generatePageNumbers(page, totalPages, filterType)}
                                
                                ${page < totalPages ? `
                                    <li class="page-item">
                                        <button class="page-link" onclick="changeFilteredPage(${page + 1}, '${filterType}')">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </li>
                                ` : ''}
                            </ul>
                        </nav>
                    </div>
                `;
            }
            
            filteredInfo.innerHTML = `
                <div class="row align-items-center">
                    <div class="col-md-${totalPages > 1 ? '6' : '12'}">
                        <p class="text-muted mb-0 small">
                            <i class="fas fa-filter me-1 text-primary"></i>
                            Showing ${startIndex + 1} to ${endIndex} of ${totalCount} filtered companies of type: <strong>${filterType.toUpperCase()}</strong>
                            <button type="button" class="btn btn-sm btn-outline-secondary ms-3" onclick="clearAllFilters()">
                                <i class="fas fa-times me-1"></i>Clear Filter
                            </button>
                        </p>
                    </div>
                    ${paginationHTML}
                </div>
            `;
        }
        
        // Update stored data
        window.filteredData.currentPage = page;
    }
    
    // Function to clear all filters
    function clearAllFilters() {
        filterByType('all');
        searchInput.value = '';
        performSearch();
        
        // Ensure pagination is visible
        const paginationSection = document.getElementById('paginationSection');
        if (paginationSection) {
            paginationSection.style.display = 'block';
        }
        
        // Remove any filtered info
        const existingFilteredInfo = document.getElementById('filteredInfo');
        if (existingFilteredInfo) {
            existingFilteredInfo.remove();
        }
    }
    </script>
@endpush
