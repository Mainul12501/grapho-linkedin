@extends('frontend.employee.master')

@section('title', 'My Profile Viewers')

@section('body')


    <section class="bg-white forSmall smallTop">
        <a href=""><img src="{{ asset('/') }}frontend/employee/images/profile/leftArrowDark.png" alt="" class="me-2"> Profile Viewers</a>
    </section>

    <!-- Main Content -->
    <div class="container container-main mt-md-5 mt-2 ">
        <!-- Left Side Menu -->
        @include('frontend.employee.jobs.left-menu')

        <!-- Right Scrollable Jobs -->
        <section class="w-100 profileOptionRight">
            <h1 class="forLarge">{{ trans('employee.profiler_viewers') }}</h1>
            <p class="">You have {{ count($myProfileViewers) ?? 0 }} {{ trans('employee.profiler_viewers') }}</p>
            <div class="right-panel w-100 profileViewer" id="viewer-container">
                @include(
                        'frontend.employee.base-functionalities.partials.profile-viewer-items',
                        ['profileViewerIds' => $myProfileViewers]
                    )
                <!-- Row 1 -->
{{--                @foreach($myProfileViewers as $myProfileViewer)--}}
{{--                    <div class="profileViewer-row">--}}
{{--                        <div class="company">--}}
{{--                            <img src="{{ asset($myProfileViewer?->employer?->employerCompanyInfo?->logo ?? '/frontend/company-vector.jpg') }}" alt="UCB Logo"  style="max-width: 58px" />--}}
{{--                            <div class="company-info">--}}
{{--                                <a href="{{ route('view-company-profile', $myProfileViewer?->employer?->employerCompanyInfo?->id) }}" style="text-decoration: none"><span>{{ $myProfileViewer?->employer?->employerCompanyInfo?->name ?? 'Company Name' }}</span></a>--}}
{{--                                <span>{{ $myProfileViewer?->employerCompanyInfo?->address ?? 'Company Address' }}</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="time">Viewed {{ \Illuminate\Support\Carbon::parse($myProfileViewer?->created_at)->diffForHumans() ?? 0 }} </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
            </div>
            <div id="loader" style="display:none;text-align:center;padding:15px">
                Loading...
            </div>
        </section>




    </div>




@endsection

@push('script')
    <script>
        let page = 1;
        let loading = false;

        $(window).on('scroll', function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 150) {

                if (loading) return;
                loading = true;
                page++;

                $('#loader').show();

                $.get('?page=' + page, function (data) {
                    if (data.trim() === '') {
                        $('#loader').hide();
                        return;
                    }

                    $('#viewer-container').append(data);
                    loading = false;
                    $('#loader').hide();
                });
            }
        });
    </script>

@endpush

