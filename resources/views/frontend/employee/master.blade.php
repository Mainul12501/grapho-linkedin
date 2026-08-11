<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Your Name" />
    {!! $siteSetting->meta_header ?? '' !!}
    <title>{{ isset($siteSetting) ? $siteSetting->site_title : 'LikewiseBd' }} - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" href="{{ isset($siteSetting) ? $siteSetting->site_icon : asset('/frontend/employee/images/Logo icon.png') }}" type="image/x-icon" />
    <!-- Google Font: Geist -->
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;700&display=swap" rel="stylesheet" />
    <!-- Bootstrap 5 CSS -->
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="{{ asset('/') }}common-assets/css/bootstrap-5.3.6.min.css" />
    <!-- Toastr Css -->
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />--}}
    <link rel="stylesheet" href="{{ asset('/') }}common-assets/css/toastr-2.1.3.min.css" />
    <!-- Sweet Alert -->
{{--    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet" />--}}
{{--    <link rel="stylesheet" href="{{ asset('/') }}common-assets/css/sweetalert2-11.7.3.min.css" />--}}

    <!-- css class helper -->
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Mainul12501/css-common-helper-classes/helper.min.css" />--}}
    <link rel="stylesheet" href="{{ asset('/') }}common-assets/css/helper.min.css" />


    <link rel="stylesheet" href="{{ asset('/') }}frontend/employee/headerStyle.css" />
    <link rel="stylesheet" href="{{ asset('/') }}frontend/employee/mainstyle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{--    font--}}
    <link rel="stylesheet" href="{{ asset('frontend/page-custom-codes/employee/master/style.css') }}">

    @yield('style')
    @stack('style')
</head>

<body>
<!-- Header -->
@include('frontend.employee.includes.header')

<!-- Main Content -->
@yield('body')

{{--employee drawer mobile menu--}}
<div class="employee-mobile-drawer">
    <!-- Drawer Overlay -->
    <div class="drawer-overlay" id="drawerOverlay"></div>

    <!-- Side Drawer -->
    <div class="side-drawer" id="sideDrawer" >
        <div class="drawer-header" style="">
            <h5 class="drawer-title">
                <i class="fa-solid fa-bars"></i>
                Menu
            </h5>
            <button class="drawer-close" id="closeDrawer">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="drawer-menu">
            <div class="drawer-section-title">Quick Actions</div>

            <a href="{{ route('employee.my-notifications') }}" class="drawer-item">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
            </a>

            <a href="{{ url('/chat') }}" class="drawer-item">
                <i class="fas fa-comments"></i>
                <span>Chat</span>
            </a>

            <div class="drawer-divider"></div>

            <div class="drawer-section-title">My Activity</div>

            <a href="{{ route('employee.my-profile-viewers') }}" class="drawer-item">
                <i class="fas fa-eye"></i>
                <span>Profile Viewers</span>
            </a>

            <a href="{{ route('employee.my-applications') }}" class="drawer-item">
                <i class="fas fa-file-alt"></i>
                <span>My Applications</span>
            </a>

            <a href="{{ route('employee.my-saved-jobs') }}" class="drawer-item">
                <i class="fas fa-bookmark"></i>
                <span>Saved Jobs</span>
            </a>

            <div class="drawer-divider"></div>

            <div class="drawer-section-title">Account</div>

            <a href="{{ route('employee.settings') }}" class="drawer-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
            @if(isset($siteSetting) && $siteSetting->subscription_system_status ==1)
                <a href="{{ route('employee.my-subscriptions') }}" class="drawer-item">
                    <i class="fas fa-crown"></i>
                    <span>Subscription</span>
                </a>
            @endif

            <div class="drawer-divider"></div>

            <a href="#" class="drawer-item logout" onclick="event.preventDefault(); document.getElementById('employeeMobileMenuLogout').submit()">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <div class="d-md-none mobile-bottom-menu">
        <a href="{{ route('employee.home') }}" class="mb-nav-item {{ request()->is('employee/home') ? 'mb-nav-active' : '' }}">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <span>Home</span>
        </a>
        <a href="{{ route('employee.show-jobs') }}" class="mb-nav-item {{ request()->is('employee/show-jobs') ? 'mb-nav-active' : '' }}">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            <span>Jobs</span>
        </a>
        <a href="{{ route('employee.my-profile') }}" class="mb-nav-item {{ request()->is('employee/my-profile') ? 'mb-nav-active' : '' }}">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span>Profile</span>
        </a>
        <a href="#" id="openDrawer" class="mb-nav-item">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            <span>Menu</span>
        </a>
    </div>

    <form action="{{ route('logout') }}" method="post" id="employeeMobileMenuLogout">
        @csrf
    </form>
</div>

@yield('modal')

<!-- Jquery CDN -->
{{--<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>--}}
<script src="{{ asset('/') }}common-assets/js/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS -->
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>--}}
<script src="{{ asset('/') }}common-assets/js/bootstrap.bundle-5.3.6.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

{{--include zigo-cloud popup blade--}}
<script src="https://js.pusher.com/7.2.0/pusher.min.js"></script>
@include('frontend.zegocloud.incoming-call-popup')
@include('frontend.zegocloud.group-call-incoming-popup')

<script src="{{ asset('/frontend/employee/script.js') }}"></script>
<script>
    var base_url = "{{ url('/') }}"+'/frontend/employee/';
</script>
<!-- Toastr JS -->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
<script src="{{ asset('/') }}common-assets/js/toastr-2.1.3.min.js"></script>

{{--    sweet alert js--}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{--    delete popup with sweet alert--}}

{!! Toastr::message() !!}
{!! $siteSetting->meta_footer ?? '' !!}
<script>
    var base_url = "{!! url('/') !!}/";

    let response;
    var commonSaved = "{{ trans('common.saved') }}";
</script>


<script src="{{ asset('frontend/page-custom-codes/employee/master/script.js') }}"></script>
@yield('script')
@stack('script')
</body>

</html>
