@extends('admin.layouts.master')
@push('title')
    Wallet Details
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern mb-2">Wallet Details - {{ $wallet->user->first_name }} {{ $wallet->user->last_name }}</h1>
                    <p class="page-subtitle-modern">View and manage wallet information</p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-primary-modern btn-sm" data-bs-toggle="modal" data-bs-target="#adjustBalanceModal">
                        <i class="fas fa-edit me-2"></i>Adjust Balance
                    </button>
                    <a href="{{ route('admin.wallets.index') }}" class="btn btn-outline-secondary-modern btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column - Wallet Information -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold text-dark">Wallet Information</h5>
                    </div>
                    <div class="card-body p-3 text-center">
                        <div class="mb-3">
                            <div class="avatar-circle mx-auto" style="width: 80px; height: 80px; background: linear-gradient(135deg, #A8B7E5 0%, #9FA6D6 100%); color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold; font-size: 28px;">
                                {{strtoupper(substr($wallet->user->first_name, 0, 1))}}{{strtoupper(substr($wallet->user->last_name, 0, 1))}}
                            </div>
                        </div>
                        <h5 class="fw-bold mb-1">{{ $wallet->user->first_name }} {{ $wallet->user->last_name }}</h5>
                        <p class="text-muted mb-3 small">{{ $wallet->user->email }}</p>

                        <div class="mb-0 py-2 border-top">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Wallet ID:</small>
                                <small class="fw-semibold">{{ $wallet->id }}</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Type:</small>
                                <span class="badge rounded-pill {{ $wallet->type == 'Personal' ? 'bg-primary' : 'bg-info' }}">
                                    {{ $wallet->type }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Status:</small>
                                @if($wallet->status === 'Active')
                                    <span class="badge bg-success-subtle text-success rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger rounded-pill">Frozen</span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Currency:</small>
                                <small class="fw-semibold">{{ $wallet->currency }}</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Created:</small>
                                <small class="fw-semibold">{{ \Carbon\Carbon::parse($wallet->created_at)->format('M d, Y h:i A') }}</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Last Activity:</small>
                                <small class="fw-semibold">
                                    @if($wallet->last_activity_at)
                                        {{ \Carbon\Carbon::parse($wallet->last_activity_at)->diffForHumans() }}
                                    @else
                                        No activity
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Balance and Activity -->
            <div class="col-lg-8">
                <!-- Balance Information Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold text-dark">Balance Information</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="text-center mb-3 pb-3 border-bottom">
                            <h2 class="display-6 fw-bold mb-1">${{ number_format($wallet->balance, 2) }}</h2>
                            <p class="text-muted mb-0 small">Current Balance</p>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="text-center p-2 bg-success-subtle rounded">
                                    <h6 class="text-success fw-bold mb-0">${{ number_format($totalDeposits, 2) }}</h6>
                                    <small class="text-muted" style="font-size: 0.7rem;">Total Deposits</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-2 bg-danger-subtle rounded">
                                    <h6 class="text-danger fw-bold mb-0">${{ number_format($totalWithdrawals, 2) }}</h6>
                                    <small class="text-muted" style="font-size: 0.7rem;">Total Withdrawals</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-2 bg-info-subtle rounded">
                                    <h6 class="text-info fw-bold mb-0">${{ number_format($totalAdjustments, 2) }}</h6>
                                    <small class="text-muted" style="font-size: 0.7rem;">Total Adjustments</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3 pb-2">
                        <h5 class="mb-0 fw-bold text-dark">Quick Actions</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#adjustBalanceModal">
                                    <i class="fas fa-edit me-1"></i>Adjust Balance
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-info btn-sm w-100" data-bs-toggle="modal" data-bs-target="#editWalletModal">
                                    <i class="fas fa-cog me-1"></i>Edit Wallet
                                </button>
                            </div>
                            <div class="col-md-4">
                                <form action="{{ route('admin.wallets.toggleFreeze', $wallet->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $wallet->status === 'Frozen' ? 'btn-success' : 'btn-warning' }} w-100">
                                        <i class="fas fa-{{ $wallet->status === 'Frozen' ? 'unlock' : 'snowflake' }} me-1"></i>
                                        {{ $wallet->status === 'Frozen' ? 'Unfreeze Wallet' : 'Freeze Wallet' }}
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('admin.wallets.transactions', $wallet->id) }}" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fas fa-list me-1"></i>View Transactions
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('admin.wallets.activityLog', $wallet->id) }}" class="btn btn-outline-secondary btn-sm w-100">
                                    <i class="fas fa-history me-1"></i>Activity Log
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Summary Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3 pb-2">
                <h5 class="mb-0 fw-bold text-dark">Activity Summary</h5>
            </div>
            <div class="card-body p-3">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="text-center p-2 border rounded">
                            <h4 class="fw-bold mb-0">{{ $totalTransactions }}</h4>
                            <small class="text-muted" style="font-size: 0.75rem;">Total Transactions</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-2 border rounded">
                            <h4 class="fw-bold mb-0">{{ $totalTransfers }}</h4>
                            <small class="text-muted" style="font-size: 0.75rem;">Total Transfers</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-2 border rounded">
                            <h4 class="text-danger fw-bold mb-0">${{ number_format($totalFees, 2) }}</h4>
                            <small class="text-muted" style="font-size: 0.75rem;">Total Fees</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-2 border rounded">
                            <h4 class="text-info fw-bold mb-0">${{ number_format($totalAdjustments, 2) }}</h4>
                            <small class="text-muted" style="font-size: 0.75rem;">Total Adjustments</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions Section -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">Recent Transactions</h5>
                    <a href="{{ route('admin.wallets.transactions', $wallet->id) }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $transaction)
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No transactions found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

{{-- Edit Wallet Modal --}}
<div class="modal fade" id="editWalletModal" tabindex="-1" aria-labelledby="editWalletLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-0 py-3">
                <h5 class="modal-title fw-bold text-dark" id="editWalletLabel">
                    <i class="fas fa-cog me-2 text-info"></i>Edit Wallet
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{route('admin.wallets.update', $wallet->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">
                            <i class="fas fa-tag me-1 text-info"></i>Wallet Type <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-sm" name="type" required>
                            <option value="Personal" {{ $wallet->type == 'Personal' ? 'selected' : '' }}>Personal</option>
                            <option value="Business" {{ $wallet->type == 'Business' ? 'selected' : '' }}>Business</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted small">
                            <i class="fas fa-toggle-on me-1 text-success"></i>Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-sm" name="status" required>
                            <option value="Active" {{ $wallet->status == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Frozen" {{ $wallet->status == 'Frozen' ? 'selected' : '' }}>Frozen</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="button" class="btn btn-outline-secondary-modern btn-sm" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary-modern btn-sm">
                            <i class="fas fa-save me-2"></i>Update Wallet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Adjust Balance Modal --}}
<div class="modal fade" id="adjustBalanceModal" tabindex="-1" aria-labelledby="adjustBalanceLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-0 py-3">
                <h5 class="modal-title fw-bold text-dark" id="adjustBalanceLabel">
                    <i class="fas fa-edit me-2 text-primary"></i>Adjust Balance
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{route('admin.wallets.adjustBalance', $wallet->id)}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Current Balance</label>
                        <input type="text" class="form-control form-control-sm" value="${{number_format($wallet->balance, 2)}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">
                            <i class="fas fa-exchange-alt me-1 text-primary"></i>Action Type
                        </label>
                        <select class="form-select form-select-sm" name="type" required>
                            <option value="add">Add Balance</option>
                            <option value="subtract">Subtract Balance</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">
                            <i class="fas fa-dollar-sign me-1 text-success"></i>Amount
                        </label>
                        <input type="number" step="0.01" class="form-control form-control-sm" name="amount" placeholder="0.00" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted small">
                            <i class="fas fa-comment me-1 text-info"></i>Description (Optional)
                        </label>
                        <textarea class="form-control form-control-sm" name="description" rows="3" placeholder="Enter reason for adjustment..."></textarea>
                    </div>
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="button" class="btn btn-outline-secondary-modern btn-sm" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary-modern btn-sm">
                            <i class="fas fa-save me-2"></i>Apply Adjustment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

