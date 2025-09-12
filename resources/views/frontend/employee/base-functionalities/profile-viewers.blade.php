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
                            <img src="{{ asset($myProfileViewer?->employerCompany?->logo ?? '/frontend/company-vector.jpg') }}" alt="UCB Logo"  style="max-width: 58px" />
                            <div class="company-info">
                                <span>{{ $myProfileViewer?->employerCompany?->name ?? 'Company Name' }}</span>
                                <span>{{ $myProfileViewer?->employerCompany?->address ?? 'Company Address' }}</span>
                            </div>
                        </div>
                        <div class="time">Viewed {{ \Illuminate\Support\Carbon::now()->diffForHumans(\Illuminate\Support\Carbon::parse($myProfileViewer?->created_at)) ?? 0 }} </div>
                    </div>
                @endforeach
            </div>
        </section>




    </div>




@endsection

