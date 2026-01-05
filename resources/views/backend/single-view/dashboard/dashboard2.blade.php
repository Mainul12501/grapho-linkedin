@extends('backend.master')

@section('title', 'Dashboard')

@section('body')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="text-muted mb-0">Welcome back, {{ $loggedInUser->name ?? 'Admin' }}!</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- STATS CARDS ROW -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <p class="mb-1 text-muted fw-semibold">Total Revenue</p>
                            <h3 class="mb-1 fw-bold text-dark">{{ number_format($totalTransaction, 2) }} BDT</h3>
                            <span class="badge {{ $revenueGrowth >= 0 ? 'bg-success-transparent text-success' : 'bg-danger-transparent text-danger' }}">
                                <i class="fe {{ $revenueGrowth >= 0 ? 'fe-trending-up' : 'fe-trending-down' }}"></i>
                                {{ $revenueGrowth >= 0 ? '+' : '' }}{{ $revenueGrowth }}%
                            </span>
                            <span class="text-muted ms-1 fs-12">vs last month</span>
                        </div>
                        <div class="avatar avatar-lg bg-primary-transparent text-primary rounded-circle">
                            <i class="fe fe-dollar-sign fs-20"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <span class="text-muted fs-12">This Month: {{ number_format($thisMonthTransaction, 2) }} BDT</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <p class="mb-1 text-muted fw-semibold">Total Users</p>
                            <h3 class="mb-1 fw-bold text-dark">{{ number_format($totalEmployees + $totalEmployers) }}</h3>
                            <span class="badge {{ $userGrowth >= 0 ? 'bg-success-transparent text-success' : 'bg-danger-transparent text-danger' }}">
                                <i class="fe {{ $userGrowth >= 0 ? 'fe-trending-up' : 'fe-trending-down' }}"></i>
                                {{ $userGrowth >= 0 ? '+' : '' }}{{ $userGrowth }}%
                            </span>
                            <span class="text-muted ms-1 fs-12">vs last month</span>
                        </div>
                        <div class="avatar avatar-lg bg-success-transparent text-success rounded-circle">
                            <i class="fe fe-users fs-20"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <span class="text-muted fs-12">New this week: {{ $newUsersThisWeek }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <p class="mb-1 text-muted fw-semibold">Total Jobs</p>
                            <h3 class="mb-1 fw-bold text-dark">{{ number_format($totalJobs) }}</h3>
                            <span class="badge bg-info-transparent text-info">
                                <i class="fe fe-check-circle"></i> {{ $activeJobs }} Active
                            </span>
                        </div>
                        <div class="avatar avatar-lg bg-warning-transparent text-warning rounded-circle">
                            <i class="fe fe-briefcase fs-20"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <span class="text-muted fs-12">Posted by {{ $totalEmployers }} employers</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <p class="mb-1 text-muted fw-semibold">Total Orders</p>
                            <h3 class="mb-1 fw-bold text-dark">{{ number_format($totalOrders) }}</h3>
                            <span class="badge bg-success-transparent text-success">
                                <i class="fe fe-check"></i> {{ $completedOrders }} Completed
                            </span>
                        </div>
                        <div class="avatar avatar-lg bg-danger-transparent text-danger rounded-circle">
                            <i class="fe fe-shopping-cart fs-20"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <span class="text-muted fs-12">{{ $totalPosts }} total posts</span>
                </div>
            </div>
        </div>
    </div>
    <!-- STATS CARDS END -->

    <!-- USER TYPE CARDS -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-xl bg-primary-transparent text-primary rounded-circle mx-auto mb-3">
                        <i class="fe fe-user fs-24"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ number_format($totalEmployees) }}</h4>
                    <p class="text-muted mb-2">Total Employees</p>
                    <span class="badge bg-primary">{{ $subscribedEmployees }} Subscribed</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-xl bg-success-transparent text-success rounded-circle mx-auto mb-3">
                        <i class="fe fe-briefcase fs-24"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ number_format($totalEmployers) }}</h4>
                    <p class="text-muted mb-2">Total Employers</p>
                    <span class="badge bg-success">{{ $subscribedEmployers }} Subscribed</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-xl bg-info-transparent text-info rounded-circle mx-auto mb-3">
                        <i class="fe fe-user-check fs-24"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ number_format($subscribedEmployees) }}</h4>
                    <p class="text-muted mb-0">Subscribed Employees</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-xl bg-warning-transparent text-warning rounded-circle mx-auto mb-3">
                        <i class="fe fe-award fs-24"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ number_format($subscribedEmployers) }}</h4>
                    <p class="text-muted mb-0">Subscribed Employers</p>
                </div>
            </div>
        </div>
    </div>
    <!-- USER TYPE CARDS END -->

    <!-- CHARTS ROW -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <h3 class="card-title">Revenue Overview</h3>
{{--                    <div class="card-options">--}}
{{--                        <a href="javascript:void(0)" class="btn btn-sm btn-primary-light">--}}
{{--                            <i class="fe fe-download"></i> Export--}}
{{--                        </a>--}}
{{--                    </div>--}}
                </div>
                <div class="card-body pt-0">
                    <div id="revenueChart" style="height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- CHARTS ROW END -->

    <!-- USER & JOBS CHARTS -->
    <div class="row">
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <h3 class="card-title">User Registration Trend</h3>
                </div>
                <div class="card-body pt-0">
                    <div id="userRegistrationChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <h3 class="card-title">Jobs Posted (Monthly)</h3>
                </div>
                <div class="card-body pt-0">
                    <div id="jobsChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- USER & JOBS CHARTS END -->

    <!-- TRANSACTIONS & ACTIVITY ROW -->
    <div class="row">
        <div class="col-xl-8 col-lg-12">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <h3 class="card-title">Recent Transactions</h3>
                    <div class="card-options">
                        <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-vcenter mb-0">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>User</th>
                                    <th>Plan</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransactions as $transaction)
                                <tr>
                                    <td>
                                        <span class="fw-semibold">#{{ $transaction->invoice_number }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle me-2">
                                                {{ strtoupper(substr($transaction->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <span>{{ $transaction->user->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $transaction->subscriptionPlan->title ?? 'N/A' }}</td>
                                    <td class="fw-semibold">{{ number_format($transaction->paid_amount, 2) }} BDT</td>
                                    <td>
                                        @if($transaction->payment_status == 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($transaction->payment_status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger">{{ ucfirst($transaction->payment_status) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">{{ $transaction->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No transactions found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <h3 class="card-title">Orders Overview</h3>
                </div>
                <div class="card-body pt-0">
                    <div id="ordersChart" style="height: 250px;"></div>
                    <div class="mt-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <span class="bg-primary rounded-circle p-1 me-2"></span>
                                <span>Total Orders</span>
                            </div>
                            <span class="fw-bold">{{ $totalOrders }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <span class="bg-success rounded-circle p-1 me-2"></span>
                                <span>Completed</span>
                            </div>
                            <span class="fw-bold">{{ $completedOrders }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- TRANSACTIONS & ACTIVITY END -->

    <!-- LATEST JOBS & POSTS -->
    <div class="row">
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <h3 class="card-title">Latest Jobs</h3>
                </div>
                <div class="card-body pt-0">
                    <div class="list-group list-group-flush">
                        @forelse($latestJobs as $job)
                        <div class="list-group-item px-0 border-top-0">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md bg-primary-transparent text-primary rounded me-3">
                                    <i class="fe fe-briefcase"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <a href="javascript:void(0)" class="fw-semibold text-dark d-block view-job" data-job-id="{{ $job->id }}">
                                        {{ Str::limit($job->job_title, 40) }}
                                    </a>
                                    <span class="text-muted fs-12">by {{ $job->Employer->name ?? 'N/A' }} - {{ $job->created_at->diffForHumans() }}</span>
                                </div>
                                <span class="badge bg-{{ $job->status == 1 ? 'success' : 'secondary' }}">
                                    {{ $job->status == 1 ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-4">No jobs posted yet</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <h3 class="card-title">Latest Posts</h3>
                </div>
                <div class="card-body pt-0">
                    <div class="list-group list-group-flush">
                        @forelse($latestPosts as $post)
                        <div class="list-group-item px-0 border-top-0">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md bg-info-transparent text-info rounded me-3">
                                    <i class="fe fe-file-text"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <a href="javascript:void(0)" class="fw-semibold text-dark d-block view-post" data-post-id="{{ $post->id }}">
                                        {{ Str::limit($post->title, 40) }}
                                    </a>
                                    <span class="text-muted fs-12">by {{ $post->employer->name ?? 'N/A' }} - {{ $post->created_at->diffForHumans() }}</span>
                                </div>
                                <span class="badge bg-{{ $post->status == 1 ? 'success' : 'secondary' }}">
                                    {{ $post->status == 1 ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-4">No posts published yet</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- LATEST JOBS & POSTS END -->

    <!-- Job Modal -->
    <div class="modal fade" id="showJob">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Job</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body" id="appendJobHere">
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Post Modal -->
    <div class="modal fade" id="showPost">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Post</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body" id="appendPostHere">
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
<style>
    .avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    .avatar-lg {
        width: 48px;
        height: 48px;
    }
    .avatar-xl {
        width: 64px;
        height: 64px;
    }
    .avatar-md {
        width: 40px;
        height: 40px;
    }
    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 12px;
    }
    .bg-primary-transparent {
        background-color: rgba(98, 89, 202, 0.1) !important;
    }
    .bg-success-transparent {
        background-color: rgba(25, 177, 89, 0.1) !important;
    }
    .bg-warning-transparent {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }
    .bg-danger-transparent {
        background-color: rgba(220, 53, 69, 0.1) !important;
    }
    .bg-info-transparent {
        background-color: rgba(23, 162, 184, 0.1) !important;
    }
    .text-primary {
        color: #6259ca !important;
    }
    .text-success {
        color: #19b159 !important;
    }
    .text-warning {
        color: #ffc107 !important;
    }
    .text-danger {
        color: #dc3545 !important;
    }
    .text-info {
        color: #17a2b8 !important;
    }
    .card {
        border: none;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        border-radius: 10px;
    }
    .card-header {
        background: transparent;
    }
    .card-footer {
        padding: 0.75rem 1.25rem;
    }
    .fs-12 {
        font-size: 12px;
    }
    .fs-20 {
        font-size: 20px;
    }
    .fs-24 {
        font-size: 24px;
    }
    .list-group-item {
        border-left: 0;
        border-right: 0;
        padding: 1rem 0;
    }
    .rounded-circle.p-1 {
        width: 8px;
        height: 8px;
        display: inline-block;
    }
    .table-vcenter td {
        vertical-align: middle;
    }
    .highcharts-credits {
        display: none !important;
    }
</style>
@endpush

@push('script')
<!-- Highcharts JS -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    // Chart color palette
    const chartColors = {
        primary: '#6259ca',
        success: '#19b159',
        warning: '#ffc107',
        danger: '#dc3545',
        info: '#17a2b8',
        secondary: '#6c757d',
        light: '#f8f9fa',
        primaryGradient: {
            linearGradient: { x1: 0, x2: 0, y1: 0, y2: 1 },
            stops: [
                [0, 'rgba(98, 89, 202, 0.4)'],
                [1, 'rgba(98, 89, 202, 0.05)']
            ]
        },
        successGradient: {
            linearGradient: { x1: 0, x2: 0, y1: 0, y2: 1 },
            stops: [
                [0, 'rgba(25, 177, 89, 0.4)'],
                [1, 'rgba(25, 177, 89, 0.05)']
            ]
        }
    };

    // Revenue Chart (Area/Spline)
    Highcharts.chart('revenueChart', {
        chart: {
            type: 'areaspline',
            backgroundColor: 'transparent'
        },
        title: { text: null },
        xAxis: {
            categories: {!! json_encode($months) !!},
            labels: {
                style: { color: '#6c757d', fontSize: '11px' }
            },
            lineColor: '#e9ecef',
            tickColor: '#e9ecef'
        },
        yAxis: {
            title: { text: null },
            labels: {
                style: { color: '#6c757d', fontSize: '11px' },
                formatter: function() {
                    return this.value.toLocaleString() + ' BDT';
                }
            },
            gridLineColor: '#f1f1f1'
        },
        legend: {
            enabled: true,
            align: 'right',
            verticalAlign: 'top'
        },
        tooltip: {
            shared: true,
            backgroundColor: '#fff',
            borderColor: '#e9ecef',
            borderRadius: 8,
            shadow: true,
            useHTML: true,
            headerFormat: '<span style="font-size:12px;font-weight:600">{point.key}</span><br/>',
            pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: <b>{point.y:,.0f}</b><br/>'
        },
        plotOptions: {
            areaspline: {
                fillOpacity: 0.3,
                marker: {
                    enabled: false,
                    symbol: 'circle',
                    radius: 4,
                    states: {
                        hover: { enabled: true }
                    }
                }
            }
        },
        series: [{
            name: 'Revenue (BDT)',
            data: {!! json_encode($monthlyRevenue) !!},
            color: chartColors.primary,
            fillColor: chartColors.primaryGradient
        }, {
            name: 'Orders',
            data: {!! json_encode($monthlyOrders) !!},
            color: chartColors.success,
            fillColor: chartColors.successGradient
        }],
        credits: { enabled: false },
        exporting: { enabled: false }
    });

    // User Registration Chart (Column)
    Highcharts.chart('userRegistrationChart', {
        chart: {
            type: 'column',
            backgroundColor: 'transparent'
        },
        title: { text: null },
        xAxis: {
            categories: {!! json_encode($months) !!},
            labels: {
                style: { color: '#6c757d', fontSize: '10px' },
                rotation: -45
            },
            lineColor: '#e9ecef'
        },
        yAxis: {
            title: { text: null },
            labels: {
                style: { color: '#6c757d', fontSize: '11px' }
            },
            gridLineColor: '#f1f1f1'
        },
        legend: {
            enabled: true,
            align: 'right',
            verticalAlign: 'top'
        },
        tooltip: {
            shared: true,
            backgroundColor: '#fff',
            borderColor: '#e9ecef',
            borderRadius: 8
        },
        plotOptions: {
            column: {
                borderRadius: 4,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Employees',
            data: {!! json_encode($monthlyEmployees) !!},
            color: chartColors.primary
        }, {
            name: 'Employers',
            data: {!! json_encode($monthlyEmployers) !!},
            color: chartColors.success
        }],
        credits: { enabled: false },
        exporting: { enabled: false }
    });

    // Jobs Chart (Spline)
    Highcharts.chart('jobsChart', {
        chart: {
            type: 'spline',
            backgroundColor: 'transparent'
        },
        title: { text: null },
        xAxis: {
            categories: {!! json_encode($months) !!},
            labels: {
                style: { color: '#6c757d', fontSize: '10px' },
                rotation: -45
            },
            lineColor: '#e9ecef'
        },
        yAxis: {
            title: { text: null },
            labels: {
                style: { color: '#6c757d', fontSize: '11px' }
            },
            gridLineColor: '#f1f1f1'
        },
        tooltip: {
            backgroundColor: '#fff',
            borderColor: '#e9ecef',
            borderRadius: 8,
            pointFormat: '<b>{point.y}</b> jobs posted'
        },
        plotOptions: {
            spline: {
                marker: {
                    enabled: true,
                    symbol: 'circle',
                    radius: 4
                },
                lineWidth: 3
            }
        },
        series: [{
            name: 'Jobs Posted',
            data: {!! json_encode($monthlyJobs) !!},
            color: chartColors.warning
        }],
        credits: { enabled: false },
        exporting: { enabled: false }
    });

    // Orders Donut Chart
    Highcharts.chart('ordersChart', {
        chart: {
            type: 'pie',
            backgroundColor: 'transparent'
        },
        title: { text: null },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b> ({point.y})'
        },
        plotOptions: {
            pie: {
                innerSize: '60%',
                dataLabels: { enabled: false },
                showInLegend: false,
                colors: [chartColors.primary, chartColors.success]
            }
        },
        series: [{
            name: 'Orders',
            data: [
                { name: 'Total Orders', y: {{ $totalOrders }} },
                { name: 'Completed', y: {{ $completedOrders }} }
            ]
        }],
        credits: { enabled: false },
        exporting: { enabled: false }
    });

    // View Job Modal
    $(document).on('click', '.view-job', function() {
        var jobId = $(this).attr('data-job-id');
        $('#appendJobHere').html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $('#showJob').modal('show');
        $.ajax({
            url: "/get-job-details/" + jobId + "?render=1",
            method: "GET",
            success: function(response) {
                $('#appendJobHere').html(response);
            },
            error: function() {
                $('#appendJobHere').html('<div class="text-center text-danger py-4">Failed to load job details</div>');
            }
        });
    });

    // View Post Modal
    $(document).on('click', '.view-post', function() {
        var postId = $(this).attr('data-post-id');
        $('#appendPostHere').html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $('#showPost').modal('show');
        $.ajax({
            url: "/admin/view-post/" + postId + "?req_from=admin",
            method: "GET",
            success: function(response) {
                $('#appendPostHere').html(response);
            },
            error: function() {
                $('#appendPostHere').html('<div class="text-center text-danger py-4">Failed to load post details</div>');
            }
        });
    });
</script>
@endpush
