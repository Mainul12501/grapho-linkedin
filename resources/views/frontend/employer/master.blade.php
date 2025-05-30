<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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
{{--    <nav class="bottom-nav employeMobileNav d-md-none border-top">--}}

{{--        <a href="employerHome.html" class="nav-link text-center flex-fill active"><img src="{{ asset('/') }}frontend/employer/images/employersHome/myJobs.png" alt=""><br />My Jobs</a>--}}
{{--        <a href="myJobs.html" class="nav-link text-center flex-fill"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Applicants.png" alt=""></i><br />Applicants</a>--}}
{{--        <a href="#" class="nav-link text-center flex-fill"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Headhunt.png" alt=""><br />Headhunt</a>--}}
{{--        <a href="#" class="nav-link text-center flex-fill"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Inbox.png" alt=""><br />Inbox</a>--}}
{{--    </nav>--}}
</div>

@yield('modal')

@include('frontend.employer.includes.assets.js')
</body>

</html>
