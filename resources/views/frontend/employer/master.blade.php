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
    <nav class="bottom-nav employeMobileNav d-md-none border-top shadow dropdown" style="background-color: lightgrey">

        <a href="{{ route('employer.home') }}" class="nav-link text-center flex-fill {{ request()->is('employer/home') ? 'active' : '' }}"><img src="{{ asset('/frontend/employer/images/employersHome/HomeDesk.png') }}" alt=""><br />{{ trans('home.home') }}</a>
        <a href="{{ route('employer.dashboard') }}" class="nav-link text-center flex-fill {{ request()->is('employer/dashboard') ? 'active' : '' }}"><img src="{{ asset('/backend/assets/images/dashboard.png') }}" alt="" style="height: 22px"><br />{{ trans('home.dashboard') }}</a>
{{--        <a href="{{ route('employer.my-jobs') }}" class="nav-link text-center flex-fill {{ request()->is('employer/my-jobs') ? 'active' : '' }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/myJobs.png" alt=""><br />{{ trans('employer.my_jobs') }}</a>--}}
        <a href="{{ route('employer.my-jobs') }}" class="nav-link text-center flex-fill {{ request()->is('employer/my-jobs') ? 'active' : '' }}"><img src="{{ asset('/frontend/employee/images/header images/mobileJobIcon.png') }}" style="height: 22px" alt=""><br />{{ trans('employer.my_jobs') }}</a>
{{--        <a href="{{ route('employer.my-job-wise-applicants') }}" class="nav-link text-center flex-fill {{ request()->is('employer/my-job-wise-applicants') ? 'active' : '' }}">--}}
{{--            <img src="{{ asset('/') }}frontend/employer/images/employersHome/Applicants.png" alt="">--}}
{{--            <br />--}}
{{--            {{ trans('employer.applicants') }}--}}
{{--        </a>--}}
        <a class=" dropdown-toggle nav-link text-center flex-fill" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('/') }}frontend/employer/images/employersHome/Applicants.png" alt="">
            <br />
            {{ trans('employee.options') }}
        </a>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <li><a class="dropdown-item" href="{{ route('employer.settings') }}">Settings</a></li>
            <li><a class="dropdown-item" href="{{ route('employer.company-profile') }}">Profile</a></li>
            <li><a class="dropdown-item" href="{{ route('employer.employer-user-management') }}">User Management</a></li>
            <li><a class="dropdown-item" href="{{ url('/chat') }}">Chat</a></li>
            <li><a class="dropdown-item" href="{{ route('employer.posts.index') }}">Posts</a></li>
            <li><a class="dropdown-item" href="{{ route('employer.employer-subscriptions') }}">Subscriptions</a></li>
            <li><a class="dropdown-item" href="{{ route('employer.my-job-wise-applicants') }}">Applicants</a></li>
            <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('employerLogoutForm').submit()">Logout</a></li>
        </ul>
        <form action="{{ route('logout') }}" method="post" id="employerLogoutForm">@csrf</form>
{{--        <a href="#" class="nav-link text-center flex-fill"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Inbox.png" alt=""><br />Inbox</a>--}}
    </nav>
</div>

@yield('modal')

@include('frontend.employer.includes.assets.js')
</body>

</html>
