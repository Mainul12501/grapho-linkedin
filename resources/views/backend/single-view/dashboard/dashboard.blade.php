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
                                    <p><b><a href="javascript:void(0)" class="nav-link text-dark view-job" data-job-id="{{ $latestJob->id }}">{{ $latestJob->job_title }}</a></b></p>
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
                                    <p><b><a href="javascript:void(0)" class="nav-link text-dark view-post" data-post-id="{{ $latestPost->id }}">{{ $latestPost->title }}</a></b></p>
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

{{--    job modal--}}
    <div class="modal fade" id="showJob">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Job</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body" id="appendJobHere">
                    <p>Modal body text goes here.</p>
                </div>

            </div>
        </div>
    </div>

{{--    post modal--}}
    <div class="modal fade" id="showPost">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Post</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body" id="appendPostHere">
                    <p>Modal body text goes here.</p>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .p-t-5 .nav-link {
            color: green!important;
            font-size: 18px!important;
            padding: 0px 3px 5px 0px !important;
        }
        .job-type .badge {background-color: gray}
    </style>
@endpush

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

    <script>
        $(document).on('click', '.view-job', function () {
            var jobId = $(this).attr('data-job-id');
            $.ajax({
                url: "/get-job-details/"+jobId+"?render=1",
                method: "GET",
                success: function (response) {
                    $('#appendJobHere').empty().append(response);
                    $('#showJob').modal('show');
                }
            })
        })
        $(document).on('click', '.view-post', function () {
            var postData = $(this).attr('data-post-id');
            $.ajax({
                url: "/admin/view-post/"+postData+"?req_from=admin",
                method: "GET",
                success: function (response) {
                    $('#appendPostHere').empty().append(response);
                    $('#showPost').modal('show');
                }
            })
        })
    </script>
@endpush
