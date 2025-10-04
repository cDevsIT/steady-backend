@extends('admin.layouts.master')
@push('title')
    Activity Log
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern mb-2">Activity Log - {{ $wallet->user->first_name }} {{ $wallet->user->last_name }}</h1>
                    <p class="page-subtitle-modern">View all wallet activities and changes</p>
                </div>
                <a href="{{ route('admin.wallets.show', $wallet->id) }}" class="btn btn-outline-secondary-modern btn-sm">
                    <i class="fas fa-arrow-left me-2"></i>Back to Wallet
                </a>
            </div>
        </div>

        <!-- Activity Log Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-history me-2 text-primary"></i>Activity Timeline
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="timeline">
                    @forelse($activities as $activity)
                        <div class="timeline-item mb-4 pb-4 border-bottom">
                            <div class="d-flex">
                                <div class="timeline-marker me-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px; 
                                         @if($activity->type === 'Deposit') background: #d4edda; 
                                         @elseif($activity->type === 'Withdrawal') background: #f8d7da;
                                         @elseif($activity->type === 'Transfer') background: #d1ecf1;
                                         @else background: #fff3cd;
                                         @endif">
                                        <i class="fas fa-{{ $activity->type === 'Deposit' ? 'arrow-down' : ($activity->type === 'Withdrawal' ? 'arrow-up' : ($activity->type === 'Transfer' ? 'exchange-alt' : 'edit')) }}"
                                           style="@if($activity->type === 'Deposit') color: #155724;
                                           @elseif($activity->type === 'Withdrawal') color: #721c24;
                                           @elseif($activity->type === 'Transfer') color: #0c5460;
                                           @else color: #856404;
                                           @endif"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="fw-bold mb-1">{{ $activity->type }}</h6>
                                            <p class="text-muted mb-2 small">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $activity->created_at->format('M d, Y h:i A') }}
                                                ({{ $activity->created_at->diffForHumans() }})
                                            </p>
                                        </div>
                                        <span class="badge rounded-pill
                                            @if($activity->type === 'Deposit') bg-success
                                            @elseif($activity->type === 'Withdrawal') bg-danger
                                            @elseif($activity->type === 'Transfer') bg-info
                                            @else bg-warning
                                            @endif">
                                            {{ $activity->type === 'Withdrawal' ? '-' : '+' }}${{ number_format($activity->amount, 2) }}
                                        </span>
                                    </div>
                                    <div class="row g-3 mb-2">
                                        <div class="col-md-4">
                                            <small class="text-muted">Balance Before:</small>
                                            <div class="fw-semibold">${{ number_format($activity->balance_before, 2) }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted">Balance After:</small>
                                            <div class="fw-semibold">${{ number_format($activity->balance_after, 2) }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted">Status:</small>
                                            <div>
                                                <span class="badge rounded-pill
                                                    @if($activity->status === 'Completed') bg-success-subtle text-success
                                                    @elseif($activity->status === 'Pending') bg-warning-subtle text-warning
                                                    @elseif($activity->status === 'Failed') bg-danger-subtle text-danger
                                                    @else bg-secondary-subtle text-secondary
                                                    @endif">
                                                    {{ $activity->status }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @if($activity->reference)
                                        <div class="mb-2">
                                            <small class="text-muted">Reference:</small>
                                            <span class="fw-semibold ms-2">{{ $activity->reference }}</span>
                                        </div>
                                    @endif
                                    @if($activity->description)
                                        <div class="mb-2">
                                            <small class="text-muted">Description:</small>
                                            <p class="mb-0 mt-1">{{ $activity->description }}</p>
                                        </div>
                                    @endif
                                    @if($activity->creator)
                                        <div>
                                            <small class="text-muted">
                                                <i class="fas fa-user me-1"></i>
                                                Created by: {{ $activity->creator->first_name }} {{ $activity->creator->last_name }}
                                            </small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No activity found</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Pagination -->
            @if($activities->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="text-muted mb-0 small">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing {{ $activities->firstItem() ?? 0 }} to {{ $activities->lastItem() ?? 0 }} of {{ $activities->total() }} entries
                            </p>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Page navigation" class="d-flex justify-content-md-end">
                                {{ $activities->render() }}
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

