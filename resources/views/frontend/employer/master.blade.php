<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($siteSetting) ? $siteSetting->site_title : 'Grapho' }} - @yield('title')</title>
    @include('frontend.employer.includes.assets.css')
</head>

<body class="">
<div class="d-flex employeHome">
    <!-- Sidebar -->
    @include('frontend.employer.includes.menu')

    <!-- Main Content Area -->
    <div class="mainContent flex-grow-1">
        <!-- Topbar -->
       @include('frontend.employer.includes.topbar')

        <!-- Dashboard Content -->
        @yield('body')

    </div>

    <!-- bottom nav --- menu for mobile view -->
    <nav class="bottom-nav employeMobileNav d-md-none border-top">

        <a href="{{ route('employer.home') }}" class="nav-link text-center flex-fill {{ request()->is('employer/home') ? 'active' : '' }}"><img src="{{ asset('/frontend/employer/images/employersHome/HomeDesk.png') }}" alt=""><br />Home</a>
        <a href="{{ route('employer.dashboard') }}" class="nav-link text-center flex-fill {{ request()->is('employer/dashboard') ? 'active' : '' }}"><img src="{{ asset('/backend/assets/images/dashboard.png') }}" alt=""><br />Dashboard</a>
        <a href="{{ route('employer.my-jobs') }}" class="nav-link text-center flex-fill {{ request()->is('employer/my-jobs') ? 'active' : '' }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/myJobs.png" alt=""><br />My Jobs</a>
        <a href="{{ route('employer.my-job-wise-applicants') }}" class="nav-link text-center flex-fill {{ request()->is('employer/my-job-wise-applicants') ? 'active' : '' }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Applicants.png" alt=""></i><br />Applicants</a>
{{--        <a href="#" class="nav-link text-center flex-fill"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Headhunt.png" alt=""><br />Headhunt</a>--}}
{{--        <a href="#" class="nav-link text-center flex-fill"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Inbox.png" alt=""><br />Inbox</a>--}}
    </nav>
</div>

@yield('modal')

@include('frontend.employer.includes.assets.js')
</body>

</html>
