@extends('admin.layouts.master')
@push('title')
    Wallet Management
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header-modern mb-5">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern mb-2">Wallet Management</h1>
                    <p class="page-subtitle-modern">Manage user wallets and monitor transactions</p>
                </div>
                @php
                    $usersWithWalletsCount = \App\Models\Wallet::distinct('user_id')->count();
                    $totalCustomersCount = \App\Models\User::where('role', 2)->count();
                    $hasAvailableUsers = $usersWithWalletsCount < $totalCustomersCount;
                @endphp
                <button type="button" class="btn btn-primary-modern" data-bs-toggle="modal" data-bs-target="#addWalletModal" {{ !$hasAvailableUsers ? 'disabled' : '' }}>
                    <i class="fas fa-plus me-2"></i>Add New Wallet
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6 col-sm-6">
                <div class="stats-card-modern card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-primary-subtle rounded-lg me-3">
                                <i class="fas fa-wallet text-primary"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Total Wallets</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">{{ $totalWallets }}</h3>
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
                                <h6 class="stats-label-modern text-muted mb-1">Active Wallets</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">{{ $activeWallets }}</h3>
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
                                <i class="fas fa-dollar-sign text-info"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Total Balance</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">${{ number_format($totalBalance, 2) }}</h3>
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
                                <i class="fas fa-snowflake text-warning"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Frozen Wallets</h6>
                                <h3 class="stats-value-modern fw-bold mb-0">{{ $frozenWallets }}</h3>
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
                <form action="{{route('admin.wallets.index')}}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-tag me-1 text-info"></i>Type
                            </label>
                            <select class="form-select form-select-sm" name="type">
                                <option value="all" {{ request()->type == 'all' ? 'selected' : '' }}>All Types</option>
                                <option value="Personal" {{ request()->type == 'Personal' ? 'selected' : '' }}>Personal</option>
                                <option value="Business" {{ request()->type == 'Business' ? 'selected' : '' }}>Business</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-toggle-on me-1 text-success"></i>Status
                            </label>
                            <select class="form-select form-select-sm" name="status">
                                <option value="all" {{ request()->status == 'all' ? 'selected' : '' }}>All Status</option>
                                <option value="Active" {{ request()->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Frozen" {{ request()->status == 'Frozen' ? 'selected' : '' }}>Frozen</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-arrow-down me-1 text-warning"></i>Min Balance
                            </label>
                            <input type="number" step="0.01" class="form-control form-control-sm" name="min_balance" placeholder="0.00" value="{{request()->min_balance}}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-arrow-up me-1 text-danger"></i>Max Balance
                            </label>
                            <input type="number" step="0.01" class="form-control form-control-sm" name="max_balance" placeholder="0.00" value="{{request()->max_balance}}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="d-flex gap-2 w-100">
                                <button type="submit" name="submit_type" value="search" class="btn btn-primary btn-sm flex-fill">
                                    <i class="fas fa-filter"></i>
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
                            <i class="fas fa-list me-2 text-primary"></i>Wallets List
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            <div class="search-container-modern">
                                <div class="search-wrapper-modern">
                                    <div class="search-icon-modern">
                                        <i class="fas fa-search"></i>
                                    </div>
                                    <input type="text" class="search-input-modern" id="searchInput" placeholder="Quick search...">
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
                    <table class="table table-hover mb-0" id="walletsTable">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">#ID</th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">
                                    <i class="fas fa-user me-1"></i>User
                                </th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">
                                    <i class="fas fa-tag me-1"></i>Type
                                </th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">
                                    <i class="fas fa-dollar-sign me-1"></i>Balance
                                </th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small text-center">
                                    <i class="fas fa-toggle-on me-1"></i>Status
                                </th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">
                                    <i class="fas fa-calendar me-1"></i>Created
                                </th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">
                                    <i class="fas fa-clock me-1"></i>Last Activity
                                </th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small text-center">
                                    <i class="fas fa-cogs me-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wallets as $wallet)
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold small">#{{$wallet->id}}</td>
                                    <td class="py-3 px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2" style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold; font-size: 14px;">
                                                {{strtoupper(substr($wallet->user->first_name, 0, 1))}}{{strtoupper(substr($wallet->user->last_name, 0, 1))}}
                                            </div>
                                            <div>
                                                <div class="fw-semibold small">{{$wallet->user->first_name}} {{$wallet->user->last_name}}</div>
                                                <small class="text-muted">{{$wallet->user->email}}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="badge rounded-pill {{ $wallet->type == 'Personal' ? 'bg-primary' : 'bg-info' }}">
                                            {{$wallet->type}}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="fw-bold text-dark">${{number_format($wallet->balance, 2)}}</span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if($wallet->status === 'Active')
                                            <span class="badge bg-success-subtle text-success rounded-pill">Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger rounded-pill">Frozen</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="text-muted small">{{ \Carbon\Carbon::parse($wallet->created_at)->format('M d, Y') }}</span>
                                        <br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($wallet->created_at)->format('h:i A') }}</small>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($wallet->last_activity_at)
                                            <span class="text-muted small">{{ \Carbon\Carbon::parse($wallet->last_activity_at)->diffForHumans() }}</span>
                                        @else
                                            <span class="text-muted small">No activity</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <a href="{{route('admin.wallets.show', $wallet->id)}}" class="btn btn-outline-primary btn-sm" title="View Details">
                                            <i class="fas fa-eye me-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fas fa-wallet fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No wallets found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Modern Pagination -->
            @if($wallets->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="text-muted mb-0 small">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing {{ $wallets->firstItem() ?? 0 }} to {{ $wallets->lastItem() ?? 0 }} of {{ $wallets->total() }} entries
                            </p>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Page navigation" class="d-flex justify-content-md-end">
                                {{ $wallets->appends(request()->query())->render() }}
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

{{-- Add New Wallet Modal --}}
<div class="modal fade" id="addWalletModal" tabindex="-1" aria-labelledby="addWalletLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-0 py-3">
                <h5 class="modal-title fw-bold text-dark" id="addWalletLabel">
                    <i class="fas fa-plus me-2 text-primary"></i>Add New Wallet
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{route('admin.wallets.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">
                            <i class="fas fa-user me-1 text-primary"></i>Select User <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-sm" name="user_id" id="userSelect" required>
                            <option value="">Choose a user...</option>
                            @php
                                $usersWithWallets = \App\Models\Wallet::pluck('user_id')->toArray();
                                $availableUsers = \App\Models\User::where('role', 2)
                                    ->whereNotIn('id', $usersWithWallets)
                                    ->orderBy('first_name')
                                    ->get();
                            @endphp
                            @forelse($availableUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})</option>
                            @empty
                                <option value="" disabled>No users available</option>
                            @endforelse
                        </select>
                        <small class="text-muted">Only users without existing wallets are shown</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">
                            <i class="fas fa-tag me-1 text-info"></i>Wallet Type <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-sm" name="type" required>
                            <option value="Personal" selected>Personal</option>
                            <option value="Business">Business</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">
                            <i class="fas fa-dollar-sign me-1 text-success"></i>Initial Balance
                        </label>
                        <input type="number" step="0.01" class="form-control form-control-sm" name="initial_balance" placeholder="0.00" value="0.00">
                        <small class="text-muted">Leave as 0.00 for no initial balance</small>
                    </div>
                    <input type="hidden" name="currency" value="USD">
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted small">
                            <i class="fas fa-toggle-on me-1 text-success"></i>Status
                        </label>
                        <select class="form-select form-select-sm" name="status">
                            <option value="Active" selected>Active</option>
                            <option value="Frozen">Frozen</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="button" class="btn btn-outline-secondary-modern btn-sm" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary-modern btn-sm">
                            <i class="fas fa-save me-2"></i>Create Wallet
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
    const table = document.getElementById('walletsTable');
    
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let i = 0; i < rows.length; i++) {
            if (rows[i].querySelector('.text-center.py-5')) continue; // Skip "no results" row
            
            const cells = rows[i].getElementsByTagName('td');
            const id = cells[0].textContent.toLowerCase();
            const user = cells[1].textContent.toLowerCase();
            const type = cells[2].textContent.toLowerCase();
            
            if (id.includes(searchTerm) || user.includes(searchTerm) || type.includes(searchTerm)) {
                rows[i].style.display = '';
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

