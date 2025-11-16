@extends('backend.master')

@section('title', 'Dashboard')

@section('body')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW-1 -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card ">
                        <div class="card-body">
                            <h4 class="fw-bolder f-s-25">Total Jobs</h4>
                            <span class="fw-bold f-s-25" style="">{{ $totalJobs ?? 0 }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card ">
                        <div class="card-body">
                            <h4 class="fw-bolder f-s-25">Total Employers</h4>
                            <span class="fw-bold f-s-25" style="">{{ $totalEmployers ?? 0 }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card ">
                        <div class="card-body">
                            <h4 class="fw-bolder f-s-25">Total Employees</h4>
                            <span class="fw-bold f-s-25" style="">{{ $totalEmployees ?? 0 }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-body">
                            <h4 class="fw-bolder f-s-22">Current Month Total Transactions</h4>
                            <span class="fw-bold f-s-25" style="">{{ $thisMonthTransaction ?? 0 }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-body">
                            <h4 class="fw-bolder f-s-22">Total Transactions</h4>
                            <span class="fw-bold f-s-25" style="">{{ $totalTransaction ?? 0 }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-header">
                            <h3>Latest Jobs</h3>
                        </div>
                        <div class="card-body">
                            @forelse($latestJobs as $latestJob)
                                <div>
                                    <p><b>{{ $latestJob->job_title }}</b></p>
                                </div>
                            @empty
                                <div>
                                    <p>No Jobs published yet</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-header">
                            <h3>Latest Posts</h3>
                        </div>
                        <div class="card-body">
                            @forelse($latestPosts as $latestPost)
                                <div>
                                    <p><b>{{ $latestPost->title }}</b></p>
                                </div>
                            @empty
                                <div>
                                    <p>No Posts published yet</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ROW-1 END-->



@endsection

@push('script')
    <!-- APEXCHART JS -->
    <script src="{{ asset('/') }}backend/assets/js/apexcharts.js"></script>

    <!-- INDEX JS -->
    <script src="{{ asset('/') }}backend/assets/js/index1.js"></script>
{{--    <script src="{{ asset('/') }}backend/assets/js/index.js"></script>--}}

    <!-- Reply JS-->
    <script src="{{ asset('/') }}backend/assets/js/reply.js"></script>

    <!-- CHART-CIRCLE JS-->
    <script src="{{ asset('/') }}backend/assets/plugins/circle-progress/circle-progress.min.js"></script>
@endpush
