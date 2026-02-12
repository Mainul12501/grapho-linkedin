<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($siteSetting) ? $siteSetting->site_title : 'LikewiseBd' }} - @yield('title')</title>
    @include('frontend.employer.includes.assets.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .site-base-color-bg {background-color: #FFCB11!important;}
        .drawer-menu a span {font-weight: bolder}
        /*.drawer-menu a i {color: #FFCB11!important;}*/
    </style>
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
{{--    <nav class="bottom-nav employeMobileNav d-md-none border-top shadow dropdown" style="background-color: lightgrey">--}}

{{--        <a href="{{ route('employer.home') }}" class="nav-link text-center flex-fill {{ request()->is('employer/home') ? 'active' : '' }}"><img src="{{ asset('/frontend/employer/images/employersHome/HomeDesk.png') }}" alt=""><br />{{ trans('home.home') }}</a>--}}
{{--        <a href="{{ route('employer.dashboard') }}" class="nav-link text-center flex-fill {{ request()->is('employer/dashboard') ? 'active' : '' }}"><img src="{{ asset('/backend/assets/images/dashboard.png') }}" alt="" style="height: 22px"><br />{{ trans('home.dashboard') }}</a>--}}
{{--        <a href="{{ route('employer.my-jobs') }}" class="nav-link text-center flex-fill {{ request()->is('employer/my-jobs') ? 'active' : '' }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/myJobs.png" alt=""><br />{{ trans('employer.my_jobs') }}</a>--}}
{{--        <a href="{{ route('employer.my-jobs') }}" class="nav-link text-center flex-fill {{ request()->is('employer/my-jobs') ? 'active' : '' }}"><img src="{{ asset('/frontend/employee/images/header images/mobileJobIcon.png') }}" style="height: 22px" alt=""><br />{{ trans('employer.my_jobs') }}</a>--}}
{{--        <a class=" dropdown-toggle nav-link text-center flex-fill" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--            <img src="{{ asset('/') }}frontend/employer/images/employersHome/Applicants.png" alt="">--}}
{{--            <br />--}}
{{--            {{ trans('employee.options') }}--}}
{{--        </a>--}}

{{--        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">--}}
{{--            <li><a class="dropdown-item" href="{{ route('employer.settings') }}">Settings</a></li>--}}
{{--            <li><a class="dropdown-item" href="{{ route('employer.company-profile') }}">Profile</a></li>--}}
{{--            <li><a class="dropdown-item" href="{{ route('employer.employer-user-management') }}">User Management</a></li>--}}
{{--            <li><a class="dropdown-item" href="{{ url('/chat') }}">Chat</a></li>--}}
{{--            <li><a class="dropdown-item" href="{{ route('employer.posts.index') }}">Posts</a></li>--}}
{{--            <li><a class="dropdown-item" href="{{ route('employer.employer-subscriptions') }}">Subscriptions</a></li>--}}
{{--            <li><a class="dropdown-item" href="{{ route('employer.my-job-wise-applicants') }}">Applicants</a></li>--}}
{{--            <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('employerLogoutForm').submit()">Logout</a></li>--}}
{{--        </ul>--}}
{{--        <form action="{{ route('logout') }}" method="post" id="employerLogoutForm">@csrf</form>--}}
{{--        <a href="#" class="nav-link text-center flex-fill"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Inbox.png" alt=""><br />Inbox</a>--}}
{{--    </nav>--}}






{{--    drawer html contents--}}
    <div class="employer-mobile-menu">
        <!-- Drawer Overlay -->
        <div class="drawer-overlay" id="drawerOverlay"></div>

        <!-- Side Drawer -->
        <div class="side-drawer" id="sideDrawer">
            <div class="drawer-header bg-primary" style="background: rgba(var(--bs-primary-rgb),var(--bs-bg-opacity))!important; height: 55px;">
                <h5 class="drawer-title">
                    <i class="fas fa-bars me-2"></i>{{--{{ trans('employee.options') }}--}} Menu
                </h5>
                <button class="drawer-close" id="closeDrawer">
                    {{--                <i class="fas fa-times"></i>--}}
                    <img src="{{ asset('/frontend/close.png') }}" alt="close icon" style="max-height: 12px;">
                </button>
            </div>

            <div class="drawer-menu">
                <a href="{{ route('employer.settings') }}" class="drawer-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>

                <a href="{{ route('employer.company-profile') }}" class="drawer-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>

                <a href="{{ route('employer.employer-user-management') }}" class="drawer-item">
                    <i class="fas fa-users-cog"></i>
                    <span>User Management</span>
                </a>

                <a href="{{ url('/chat') }}" class="drawer-item">
                    <i class="fas fa-comments"></i>
                    <span>Chat</span>
                </a>

                <a href="{{ route('employer.posts.index') }}" class="drawer-item">
                    <i class="fas fa-newspaper"></i>
                    <span>Posts</span>
                </a>

                <a href="{{ route('employer.employer-subscriptions') }}" class="drawer-item">
                    <i class="fas fa-crown"></i>
                    <span>Subscriptions</span>
                </a>

                <a href="{{ route('employer.my-job-wise-applicants') }}" class="drawer-item">
                    <i class="fas fa-user-check"></i>
                    <span>Applicants</span>
                </a>

                <div class="drawer-divider"></div>

                <a href="#" class="drawer-item logout" onclick="event.preventDefault(); document.getElementById('employerLogoutForm').submit()">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>

        <style>
            .employer-bottom-menu {
                max-height: 91px!important;
                background-color: #141C25!important;
            }
            .employer-bottom-menu-item {
                padding: 10px 4px 16px 4px!important;
                gap: 6px;
            }
            .text-light-gray {color: gray!important;}
        </style>

        <!-- Bottom Navigation -->
        <nav class="bottom-nav employeMobileNav d-md-none employer-bottom-menu text-white">
            <a href="{{ route('employer.home') }}" class="nav-link text-center flex-fill {{ request()->is('employer/home') ? 'active' : '' }}">
{{--                <img src="{{ asset('/frontend/employer/images/employersHome/HomeDesk.png') }}" alt="">--}}
                <img src="{{ asset('/frontend/employer/images/home.png') }}" alt="">
                <span class="text-light-gray">{{ trans('home.home') }}</span>
            </a>

            <a href="{{ route('employer.dashboard', ['is_own' => 'true']) }}" class="nav-link text-center flex-fill {{ request()->is('employer/dashboard') ? 'active' : '' }}">
{{--                <img src="{{ asset('/backend/assets/images/dashboard.png') }}" alt="" style="height: 22px">--}}
                <img src="{{ asset('/frontend/employer/images/business.png') }}" alt="">
                <span class="text-light-gray">{{ trans('home.dashboard') }}</span>
            </a>

            <a href="{{ route('employer.my-jobs') }}" class="nav-link text-center flex-fill {{ request()->is('employer/my-jobs') ? 'active' : '' }}">
{{--                <img src="{{ asset('/frontend/employee/images/header images/mobileJobIcon.png') }}" style="height: 22px" alt="">--}}
                <img src="{{ asset('/frontend/employer/images/briefcase.png') }}" style="height: 22px" alt="">
                <span class="text-light-gray">{{ trans('employer.my_jobs') }}</span>
            </a>

            <a href="#" class="nav-link text-center flex-fill" id="openDrawer">
{{--                <img src="{{ asset('/frontend/employer/images/employersHome/Applicants.png') }}" alt="">--}}
                <img src="{{ asset('/frontend/menu.png') }}" alt="">
                <span class="text-light-gray">{{--{{ trans('employee.options') }}--}} Menu</span>
            </a>
        </nav>

        <form action="{{ route('logout') }}" method="post" id="employerLogoutForm">@csrf</form>
    </div>


</div>

@yield('modal')

@include('frontend.employer.includes.assets.js')
<script src="https://js.pusher.com/7.2.0/pusher.min.js"></script>
@include('frontend.zegocloud.incoming-call-popup')
@include('frontend.zegocloud.group-call-incoming-popup')




</body>

</html>
