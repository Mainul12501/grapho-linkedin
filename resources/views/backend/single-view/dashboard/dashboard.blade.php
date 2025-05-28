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
