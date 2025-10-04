@extends('admin.layouts.master')
@push('title')
    Wallet Transactions
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern mb-2">Transactions - {{ $wallet->user->first_name }} {{ $wallet->user->last_name }}</h1>
                    <p class="page-subtitle-modern">View all wallet transactions</p>
                </div>
                <a href="{{ route('admin.wallets.show', $wallet->id) }}" class="btn btn-outline-secondary-modern btn-sm">
                    <i class="fas fa-arrow-left me-2"></i>Back to Wallet
                </a>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-filter me-2 text-primary"></i>Filters
                </h5>
            </div>
            <div class="card-body">
                <form method="GET">
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
                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-tag me-1 text-info"></i>Type
                            </label>
                            <select class="form-select form-select-sm" name="type">
                                <option value="all" {{ request()->type == 'all' ? 'selected' : '' }}>All Types</option>
                                <option value="Deposit" {{ request()->type == 'Deposit' ? 'selected' : '' }}>Deposit</option>
                                <option value="Withdrawal" {{ request()->type == 'Withdrawal' ? 'selected' : '' }}>Withdrawal</option>
                                <option value="Transfer" {{ request()->type == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                                <option value="Adjustment" {{ request()->type == 'Adjustment' ? 'selected' : '' }}>Adjustment</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-toggle-on me-1 text-success"></i>Status
                            </label>
                            <select class="form-select form-select-sm" name="status">
                                <option value="all" {{ request()->status == 'all' ? 'selected' : '' }}>All Status</option>
                                <option value="Completed" {{ request()->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Pending" {{ request()->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Failed" {{ request()->status == 'Failed' ? 'selected' : '' }}>Failed</option>
                                <option value="Cancelled" {{ request()->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-list me-2 text-primary"></i>All Transactions
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">Date</th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">Type</th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">Amount</th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">Status</th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">Reference</th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">Description</th>
                                <th class="border-0 py-3 px-4 fw-semibold text-muted small">Created By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr class="border-bottom">
                                    <td class="py-3 px-4">
                                        <span class="text-muted small">{{ $transaction->created_at->format('M d, Y') }}</span>
                                        <br>
                                        <small class="text-muted">{{ $transaction->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="badge rounded-pill
                                            @if($transaction->type === 'Deposit') bg-success
                                            @elseif($transaction->type === 'Withdrawal') bg-danger
                                            @elseif($transaction->type === 'Transfer') bg-info
                                            @else bg-warning
                                            @endif">
                                            {{ $transaction->type }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="fw-bold {{ $transaction->type === 'Withdrawal' ? 'text-danger' : 'text-success' }}">
                                            {{ $transaction->type === 'Withdrawal' ? '-' : '+' }}${{ number_format($transaction->amount, 2) }}
                                        </span>
                                        <br>
                                        <small class="text-muted">Balance: ${{ number_format($transaction->balance_after, 2) }}</small>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="badge rounded-pill
                                            @if($transaction->status === 'Completed') bg-success-subtle text-success
                                            @elseif($transaction->status === 'Pending') bg-warning-subtle text-warning
                                            @elseif($transaction->status === 'Failed') bg-danger-subtle text-danger
                                            @else bg-secondary-subtle text-secondary
                                            @endif">
                                            {{ $transaction->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <small class="text-muted">{{ $transaction->reference ?? 'N/A' }}</small>
                                    </td>
                                    <td class="py-3 px-4">
                                        <small class="text-muted">{{ $transaction->description ?? 'N/A' }}</small>
                                    </td>
                                    <td class="py-3 px-4">
                                        <small class="text-muted">
                                            @if($transaction->creator)
                                                {{ $transaction->creator->first_name }} {{ $transaction->creator->last_name }}
                                            @else
                                                System
                                            @endif
                                        </small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No transactions found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination -->
            @if($transactions->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="text-muted mb-0 small">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of {{ $transactions->total() }} entries
                            </p>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Page navigation" class="d-flex justify-content-md-end">
                                {{ $transactions->appends(request()->query())->render() }}
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

