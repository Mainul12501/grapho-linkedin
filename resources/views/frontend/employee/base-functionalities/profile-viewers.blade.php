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
            <h1 class="forLarge">Profile viewers</h1>
            <p class="">You have {{ count($myProfileViewers) ?? 0 }} profile viewers</p>
            <div class="right-panel w-100 profileViewer">

                <!-- Row 1 -->
                @foreach($myProfileViewers as $myProfileViewer)
                    <div class="profileViewer-row">
                        <div class="company">
                            <img src="{{ asset($myProfileViewer?->employerCompany?->logo ?? '/frontend/employee/images/profile/profileViewerLogo1.png') }}" alt="UCB Logo"  style="max-width: 58px" />
                            <div class="company-info">
                                <span>{{ $myProfileViewer?->employerCompany?->name ?? 'Company Name' }}</span>
                                <span>{{ $myProfileViewer?->employerCompany?->address ?? 'Company Address' }}</span>
                            </div>
                        </div>
                        <div class="time">Viewed {{ \Illuminate\Support\Carbon::now()->diffForHumans(\Illuminate\Support\Carbon::parse($myProfileViewer?->created_at)) ?? 0 }} </div>
                    </div>
                @endforeach


{{--                <!-- Row 2 -->--}}
{{--                <div class="profileViewer-row">--}}
{{--                    <div class="company">--}}
{{--                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileViewerLogo2.png" alt="Unilever Logo" />--}}
{{--                        <div class="company-info">--}}
{{--                            <span>Unilever Bangladesh</span>--}}
{{--                            <span>Gulshan, Dhaka</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="time">Viewed 5h ago</div>--}}
{{--                </div>--}}

{{--                <!-- Row 3 -->--}}
{{--                <div class="profileViewer-row">--}}
{{--                    <div class="company">--}}
{{--                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileViewerLogo3.png" alt="Grameenphone Logo" />--}}
{{--                        <div class="company-info">--}}
{{--                            <span>Grameenphone Ltd</span>--}}
{{--                            <span>Bashundhara, Dhaka</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="time">Viewed 12h ago</div>--}}
{{--                </div>--}}

{{--                <!-- Row 4 -->--}}
{{--                <div class="profileViewer-row">--}}
{{--                    <div class="company">--}}
{{--                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileViewerLogo4.png" alt="BRAC Bank Logo" />--}}
{{--                        <div class="company-info">--}}
{{--                            <span>BRAC Bank Limited</span>--}}
{{--                            <span>Mohakhali, Dhaka</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="time">Viewed 2d ago</div>--}}
{{--                </div>--}}

{{--                <!-- Row 5 -->--}}
{{--                <div class="profileViewer-row">--}}
{{--                    <div class="company">--}}
{{--                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileViewerLogo5.png" alt="Apex Footwear Logo" />--}}
{{--                        <div class="company-info">--}}
{{--                            <span>Apex Footwear Ltd</span>--}}
{{--                            <span>Shyamoli, Dhaka</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="time">Viewed 1w ago</div>--}}
{{--                </div>--}}
            </div>
        </section>




    </div>




@endsection

