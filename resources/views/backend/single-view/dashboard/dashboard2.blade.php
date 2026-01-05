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
