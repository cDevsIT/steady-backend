@extends('admin.layouts.master')
@push('title')
    Tickets Management
@endpush
@push('css')
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern">Tickets Management</h1>
                    <p class="page-subtitle-modern">Manage customer support tickets and inquiries</p>
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
                                <i class="fas fa-ticket-alt text-primary"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Total Tickets</h6>
                                <h3 class="stats-value-modern mb-0">{{ $totalTickets ?? 0 }}</h3>
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
                                <i class="fas fa-door-open text-success"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Open Tickets</h6>
                                <h3 class="stats-value-modern mb-0">{{ $openTickets ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card-modern card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-danger-subtle rounded-lg me-3">
                                <i class="fas fa-door-closed text-danger"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Closed Tickets</h6>
                                <h3 class="stats-value-modern mb-0">{{ $closedTickets ?? 0 }}</h3>
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
                                <i class="fas fa-users text-info"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Unique Customers</h6>
                                <h3 class="stats-value-modern mb-0">{{ $uniqueCustomers ?? 0 }}</h3>
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
                                   placeholder="Company, customer name, or email..." 
                                   value="{{request()->search}}" 
                                   name="search">
                        </div>
                        <div class="col-md-2 mb-0">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-filter me-1 text-warning"></i>Status
                            </label>
                            <select name="status" class="form-control form-control-sm">
                                <option value="">All Status</option>
                                <option value="admin_ticket" {{request()->status == 'admin_ticket' ? 'selected' : ''}}>Admin Tickets</option>
                                <option value="Open" {{request()->status == 'Open' ? 'selected' : ''}}>Open</option>
                                <option value="Close" {{request()->status == 'Close' ? 'selected' : ''}}>Closed</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-0">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-sm flex-fill">
                                    <i class="fas fa-search me-1"></i>Search
                                </button>
                                <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary btn-sm">
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
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-list me-2 text-primary"></i>Tickets List
                </h5>
                <button class="btn btn-primary btn-sm d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createTicketModal">
                    <i class="fas fa-plus me-2"></i>Create Ticket
                </button>
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
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 200px;">
                                    <i class="fas fa-ticket-alt me-1"></i>Title
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 150px;">
                                    <i class="fas fa-user me-1"></i>Customer
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 150px;">
                                    <i class="fas fa-building me-1"></i>Company
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 180px;">
                                    <i class="fas fa-envelope me-1"></i>Email
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 120px;">
                                    <i class="fas fa-phone me-1"></i>Phone
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 135px;">
                                    <i class="fas fa-reply me-1"></i>Answered
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 100px;">
                                    <i class="fas fa-info-circle me-1"></i>Status
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 100px;">
                                    <i class="fas fa-cogs me-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                                <tr class="border-bottom">
                                    <td class="py-2 px-2 fw-semibold small text-center">{{ $ticket->id }}</td>
                                    <td class="py-2 px-2">
                                        <span class="text-muted small">{{ \Carbon\Carbon::parse($ticket->created_at)->format('M d, Y') }}</span>
                                        <br>
                                        <small class="text-muted small">{{ \Carbon\Carbon::parse($ticket->created_at)->format('h:i A') }}</small>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="fw-semibold small">{{ Str::limit($ticket->title, 50) }}</span>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="fw-semibold small">{{ $ticket->first_name ." ". $ticket->last_name }}</span>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="fw-semibold small">{{ $ticket->company_name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="py-2 px-2">
                                        <a href="mailto:{{ $ticket->email }}" class="text-primary small">
                                            <i class="fas fa-envelope me-1"></i>{{ $ticket->email }}
                                        </a>
                                    </td>
                                    <td class="py-2 px-2">
                                        <a href="tel:{{ $ticket->phone }}" class="text-primary small">
                                            <i class="fas fa-phone me-1"></i>{{ $ticket->phone }}
                                        </a>
                                    </td>
                                    <td class="py-2 px-2 text-center">
                                        @php
                                            $lastComment = \App\Models\Comment::where('ticket_id', $ticket->id)
                                                ->with('user')
                                                ->orderBy('created_at', 'desc')
                                                ->first();
                                            $isAnswered = $lastComment && $lastComment->user && $lastComment->user->role == 1;
                                        @endphp
                                        @if($isAnswered)
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                                <i class="fas fa-check me-1"></i>Yes
                                            </span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">
                                                <i class="fas fa-clock me-1"></i>No
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-2 text-center">
                                        @if($ticket->status == 'Open')
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                                <i class="fas fa-door-open me-1"></i>Open
                                            </span>
                                        @elseif($ticket->status == 'admin_ticket')
                                            <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">
                                                <i class="fas fa-user-shield me-1"></i>Admin Ticket
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                                <i class="fas fa-door-closed me-1"></i>{{ $ticket->status == 'Close' ? 'Closed' : $ticket->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-2 text-center">
                                        <a href="{{route('tickets.show', $ticket->id)}}" 
                                           class="btn btn-outline-primary btn-sm" 
                                           title="View Details">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Modern Pagination -->
            @if($tickets->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="text-muted mb-0 small">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing {{ $tickets->firstItem() ?? 0 }} to {{ $tickets->lastItem() ?? 0 }} of {{ $tickets->total() }} entries
                            </p>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Page navigation" class="d-flex justify-content-md-end">
                                {{ $tickets->render() }}
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Create Ticket Modal -->
    <div class="modal fade" id="createTicketModal" tabindex="-1" aria-labelledby="createTicketModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTicketModalLabel"><i class="fas fa-plus-circle me-2 text-primary"></i>Create New Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('tickets.adminStore') }}" enctype="multipart/form-data" id="adminCreateTicketForm">
                    @csrf
                    <div class="modal-body">
                        <div id="adminTicketError" class="alert alert-danger d-none py-2 px-3 small" role="alert">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Please fill required fields.
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Company</label>
                                <select name="company_id" id="company_id" class="form-select" required data-placeholder="Search company by name...">
                                    <option value="">Select a company</option>
                                    @foreach(\App\Models\Company::orderBy('company_name')->limit(200)->get() as $company)
                                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Start typing to filter.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">User (optional)</label>
                                <select name="user_id" id="user_id" class="form-select" data-placeholder="Search user by name/email...">
                                    <option value="">Auto-detect from company</option>
                                    @foreach(\App\Models\User::orderBy('first_name')->limit(200)->get() as $user)
                                        <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }} - {{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold text-muted small">Subject</label>
                                <input type="text" name="title" class="form-control" placeholder="Subject" required />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold text-muted small">Message</label>
                                <textarea name="content" id="admin_ticket_content" class="form-control" rows="5" placeholder="Write message..." required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Attachment</label>
                                <input type="file" name="attachment" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Status</label>
                                <select name="status" class="form-select">
                                    <option value="admin_ticket">Admin Ticket</option>
                                    <option value="Open">Open</option>
                                    <option value="Closed">Closed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
    <script>
        (function(){
            const companySelect = document.getElementById('company_id');
            const userSelect = document.getElementById('user_id');
            const form = document.getElementById('adminCreateTicketForm');
            const errorBox = document.getElementById('adminTicketError');
            // Company -> User map (server-rendered)
            const companyUserMap = {
@php($companyUsers = \App\Models\Company::select('id','user_id')->get())
@foreach($companyUsers as $c)
                "{{ $c->id }}": "{{ $c->user_id }}",
@endforeach
            };
            // Minimal user display map for all users referenced by companies
            const userDisplayMap = {
@php($userIds = $companyUsers->pluck('user_id')->unique())
@foreach(\App\Models\User::whereIn('id', $userIds)->get(['id','first_name','last_name','email']) as $u)
                "{{ $u->id }}": "{{ trim($u->first_name.' '.$u->last_name) }} - {{ $u->email }}",
@endforeach
            };

            function filterSelect(select, query){
                const q = query.toLowerCase();
                Array.from(select.options).forEach((opt, idx)=>{
                    if(idx===0) return;
                    opt.hidden = !opt.text.toLowerCase().includes(q);
                });
            }

            // Simple search: when typing in select, filter options
            [companySelect, userSelect].forEach((sel)=>{
                sel.addEventListener('keyup', (e)=>{
                    filterSelect(sel, e.target.value || '');
                });
            });

            // Auto-select user when company changes
            function autoSelectUser(){
                const companyId = companySelect.value;
                const mappedUserId = companyUserMap[companyId];
                if(mappedUserId){
                    // Try select if option exists
                    const optExists = Array.from(userSelect.options).some(o => o.value === mappedUserId);
                    if(!optExists){
                        // Create option on the fly if not present
                        const opt = document.createElement('option');
                        opt.value = mappedUserId;
                        opt.text = userDisplayMap[mappedUserId] || ("User #"+mappedUserId);
                        userSelect.appendChild(opt);
                    }
                    userSelect.value = mappedUserId;
                }
            }
            companySelect.addEventListener('change', autoSelectUser);
            // Also run when modal becomes visible
            const modalEl = document.getElementById('createTicketModal');
            if (modalEl) {
                modalEl.addEventListener('shown.bs.modal', autoSelectUser);
            }

            form.addEventListener('submit', function(e){
                errorBox.classList.add('d-none');
                if(!companySelect.value || !form.title.value.trim() || !form.content.value.trim()){
                    e.preventDefault();
                    errorBox.classList.remove('d-none');
                }
            });

            // Auto-open Create Ticket modal if ?create=1 is present
            try {
                const params = new URLSearchParams(window.location.search);
                if (params.get('create') === '1') {
                    const modalEl = document.getElementById('createTicketModal');
                    if (modalEl && window.bootstrap && window.bootstrap.Modal) {
                        const modal = new bootstrap.Modal(modalEl);
                        modal.show();
                    } else if (modalEl) {
                        // Fallback for Bootstrap 4
                        $(modalEl).modal('show');
                    }
                }
            } catch (e) {}
        })();
    </script>
    @endpush
@endsection

@push('js')
    <!-- Moment.js (required for Date Range Picker) -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <!-- Date Range Picker JS -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        function exportToCSV() {
            // Add CSV export functionality here
            console.log('Export to CSV functionality');
        }
    </script>
@endpush
