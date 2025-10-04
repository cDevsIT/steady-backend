@extends('admin.layouts.master')
@push('title')
    Dashboard
@endpush

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.16.0/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.js"></script>
@endpush

@section('content')
    <!-- Modern Page Header -->
    <div class="container-fluid px-4">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title-modern">Dashboard</h1>
                <p class="page-subtitle-modern">Welcome back! Here's what's happening with your business today.</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary btn-sm" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt me-2"></i>Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Modern Stats Cards Row -->
    <div class="row g-4 mb-4">
        <!-- Total Customers -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="h2 mb-1 fw-bold">{{ number_format($customerCount) }}</h3>
                        <p class="mb-0 text-muted">Total Customers</p>
                    </div>
                    <div class="stats-icon text-primary">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.customers') }}" class="text-decoration-none">
                        <span class="text-primary small">View Details</span>
                        <i class="fas fa-arrow-right ms-1 text-primary small"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Admins -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="stats-card success">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="h2 mb-1 fw-bold">{{ number_format($adminCount) }}</h3>
                        <p class="mb-0 text-muted">Total Admins</p>
                    </div>
                    <div class="stats-icon text-success">
                        <i class="fas fa-user-shield fa-2x"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.user') }}" class="text-decoration-none">
                        <span class="text-primary small">View Details</span>
                        <i class="fas fa-arrow-right ms-1 text-primary small"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Companies -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="h2 mb-1 fw-bold">{{ number_format($companyCount) }}</h3>
                        <p class="mb-0 text-muted">Total Companies</p>
                    </div>
                    <div class="stats-icon text-warning">
                        <i class="fas fa-building fa-2x"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.companies') }}" class="text-decoration-none">
                        <span class="text-primary small">View Details</span>
                        <i class="fas fa-arrow-right ms-1 text-primary small"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="stats-card danger">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="h2 mb-1 fw-bold">{{ number_format($orderCount) }}</h3>
                        <p class="mb-0 text-muted">Total Orders</p>
                    </div>
                    <div class="stats-icon text-danger">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.orders') }}" class="text-decoration-none">
                        <span class="text-primary small">View Details</span>
                        <i class="fas fa-arrow-right ms-1 text-primary small"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Transitions -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="stats-card info">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="h2 mb-1 fw-bold">{{ number_format($transactionCount) }}</h3>
                        <p class="mb-0 text-muted">Total Transitions</p>
                    </div>
                    <div class="stats-icon text-info">
                        <i class="fas fa-hand-holding-dollar fa-2x"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.transitions') }}" class="text-decoration-none">
                        <span class="text-primary small">View Details</span>
                        <i class="fas fa-arrow-right ms-1 text-primary small"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total States -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="stats-card secondary">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="h2 mb-1 fw-bold">{{ number_format($totalState) }}</h3>
                        <p class="mb-0 text-muted">Total States</p>
                    </div>
                    <div class="stats-icon text-secondary">
                        <i class="fas fa-flag-usa fa-2x"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.fees.index') }}" class="text-decoration-none">
                        <span class="text-primary small">View Details</span>
                        <i class="fas fa-arrow-right ms-1 text-primary small"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Open Tickets -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="h2 mb-1 fw-bold">{{ number_format($openTickets) }}</h3>
                        <p class="mb-0 text-muted">Open Tickets</p>
                    </div>
                    <div class="stats-icon text-warning">
                        <i class="fas fa-ticket-alt fa-2x"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('tickets.index',['status'=>'Open']) }}" class="text-decoration-none">
                        <span class="text-primary small">View Details</span>
                        <i class="fas fa-arrow-right ms-1 text-primary small"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Closed Tickets -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="stats-card success">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="h2 mb-1 fw-bold">{{ number_format($closedTickets) }}</h3>
                        <p class="mb-0 text-muted">Closed Tickets</p>
                    </div>
                    <div class="stats-icon text-success">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('tickets.index',['status'=>'Close']) }}" class="text-decoration-none">
                        <span class="text-primary small">View Details</span>
                        <i class="fas fa-arrow-right ms-1 text-primary small"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="modern-card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-chart-line me-2 text-primary"></i>Transaction Overview
                    </h5>
                    <p class="text-muted mb-0 small">Monthly transaction trends and performance</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-primary" onclick="refreshChart()">
                        <i class="fas fa-sync-alt me-1"></i>Refresh
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="chart" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
    </div>
@endsection

@push('js')
    <script>
        // Convert chartData from Laravel into JavaScript format
        const chartData = @json($transactionChartData);

        // Generate the C3 chart
        const chart = c3.generate({
            bindto: '#chart',
            data: {
                x: 'x',
                columns: [
                    ['x', ...chartData.dates],
                    ['Transactions', ...chartData.totals]
                ],
                type: 'area',
                colors: {
                    Transactions: '#6366f1'
                },
                line: {
                    connect: true,
                    smooth: true
                },
                area: {
                    opacity: 0.1
                }
            },
            axis: {
                x: {
                    type: 'timeseries',
                    tick: {
                        format: '%b %Y',
                        count: 6
                    }
                },
                y: {
                    label: {
                        text: 'Number of Transactions',
                        position: 'outer-middle'
                    },
                    tick: {
                        format: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }
            },
            grid: {
                y: {
                    show: true
                }
            },
            point: {
                r: 4,
                focus: {
                    expand: {
                        r: 6
                    }
                }
            },
            tooltip: {
                format: {
                    title: function(d) {
                        return moment(d).format('MMM DD, YYYY');
                    },
                    value: function(value) {
                        return value.toLocaleString() + ' transactions';
                    }
                }
            },
            padding: {
                top: 20,
                right: 20,
                bottom: 20,
                left: 60
            }
        });

        // Function to refresh chart
        function refreshChart() {
            window.location.reload();
        }

        // Responsive chart
        window.addEventListener('resize', function() {
            chart.resize();
        });
    </script>
@endpush
