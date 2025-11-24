<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Your Name" />
    {!! $siteSetting->meta_header ?? '' !!}
    <title>{{ isset($siteSetting) ? $siteSetting->site_title : 'Grapho' }} - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" href="{{ isset($siteSetting) ? $siteSetting->site_title : asset('/frontend/employee/images/Logo icon.png') }}" type="image/x-icon" />
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
    <style>
        .employee-mobile-drawer h1,h2,h3,h4,h5,h6 {
            font-family: "Geist", sans-serif;
            font-optical-sizing: auto;
            font-weight: 600;
            font-size: 16px;
        }
        .employee-mobile-drawer p,span,label,span,button {
            font-family: "Geist", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-size: 13px;
        }
        @media screen and (max-width: 768px) {
            body {
                padding-bottom: 100px!important; /* same or slightly more than .bottom-nav height */
            }
        }



        /*employee mobile drawer codes*/
        /* Bottom Navigation */
        .employee-mobile-drawer .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #ffffff;
            box-shadow: 0 -3px 15px rgba(0,0,0,0.1);
            z-index: 1000;
            padding: 12px 0 8px;
            border-top: 1px solid #e9ecef;
        }

        .employee-mobile-drawer .bottom-nav > div {
            flex: 1;
            position: relative;
        }

        .employee-mobile-drawer .bottom-nav a {
            color: #6c757d;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .employee-mobile-drawer .bottom-nav img {
            width: 24px;
            height: 24px;
            object-fit: contain;
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .employee-mobile-drawer .bottom-nav .active a {
            color: #0d6efd;
            font-weight: 600;
        }

        .employee-mobile-drawer .bottom-nav .active img {
            opacity: 1;
            transform: scale(1.1);
        }

        .employee-mobile-drawer .bottom-nav .active::after {
            content: '';
            position: absolute;
            top: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 3px;
            background: #0d6efd;
            border-radius: 0 0 3px 3px;
        }

        .employee-mobile-drawer .bottom-nav a:hover {
            color: #0d6efd;
        }

        .employee-mobile-drawer .bottom-nav a:hover img {
            opacity: 1;
        }

        /* Hide default dropdown */
        .employee-mobile-drawer .dropdown-toggle::after {
            display: none;
        }

        .employee-mobile-drawer .bottom-nav .dropdown-menu {
            display: none !important;
        }

        /* Drawer Overlay */
        .employee-mobile-drawer .drawer-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.65);
            opacity: 0;
            visibility: hidden;
            transition: all 0.35s ease;
            z-index: 1040;
            backdrop-filter: blur(3px);
        }

        .employee-mobile-drawer .drawer-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Side Drawer */
        .employee-mobile-drawer .side-drawer {
            position: fixed;
            top: 0;
            right: -100%;
            width: 320px;
            max-width: 85vw;
            height: 100vh;
            background: #ffffff;
            box-shadow: -8px 0 30px rgba(0,0,0,0.25);
            transition: right 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1050;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .employee-mobile-drawer .side-drawer.show {
            right: 0;
        }

        /* Drawer Header */
        .employee-mobile-drawer .drawer-header {
            padding: 28px 24px;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .employee-mobile-drawer .drawer-title {
            color: #ffffff;
            font-size: 22px;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .employee-mobile-drawer .drawer-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: #ffffff;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 20px;
        }

        .employee-mobile-drawer .drawer-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        /* Drawer Menu */
        .employee-mobile-drawer .drawer-menu {
            padding: 16px 0;
            flex: 1;
        }

        .employee-mobile-drawer .drawer-section-title {
            padding: 16px 24px 8px;
            color: #6c757d;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .employee-mobile-drawer .drawer-item {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 16px 24px;
            color: #212529;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .employee-mobile-drawer .drawer-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: linear-gradient(90deg, rgba(13, 110, 253, 0.08) 0%, transparent 100%);
            transition: width 0.3s ease;
        }

        .employee-mobile-drawer .drawer-item:hover {
            background: #f8f9fa;
            border-left-color: #0d6efd;
            color: #0d6efd;
        }

        .employee-mobile-drawer .drawer-item:hover::before {
            width: 100%;
        }

        .employee-mobile-drawer .drawer-item i {
            width: 28px;
            font-size: 20px;
            text-align: center;
            color: #4e73df;
            transition: all 0.3s ease;
        }

        .employee-mobile-drawer .drawer-item:hover i {
            color: #0d6efd;
            transform: scale(1.15);
        }

        .employee-mobile-drawer .drawer-item span {
            font-size: 16px;
            font-weight: 500;
            flex: 1;
        }

        .employee-mobile-drawer .drawer-item .badge {
            background: #0d6efd;
            color: white;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 12px;
            font-weight: 600;
        }

        .employee-mobile-drawer .drawer-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #dee2e6 20%, #dee2e6 80%, transparent);
            margin: 12px 24px;
        }

        .employee-mobile-drawer .drawer-item.logout {
            color: #dc3545;
            margin-top: 8px;
        }

        .employee-mobile-drawer .drawer-item.logout i {
            color: #dc3545;
        }

        .employee-mobile-drawer .drawer-item.logout:hover {
            background: #fff5f5;
            border-left-color: #dc3545;
            color: #c82333;
        }

        .employee-mobile-drawer .drawer-item.logout:hover i {
            color: #c82333;
        }

        /* Animations */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .employee-mobile-drawer .side-drawer.show .drawer-item {
            animation: slideInRight 0.4s ease forwards;
            opacity: 0;
        }

        .employee-mobile-drawer .side-drawer.show .drawer-item:nth-child(1) { animation-delay: 0.05s; }
        .employee-mobile-drawer .side-drawer.show .drawer-item:nth-child(2) { animation-delay: 0.08s; }
        .employee-mobile-drawer .side-drawer.show .drawer-item:nth-child(3) { animation-delay: 0.11s; }
        .employee-mobile-drawer .side-drawer.show .drawer-item:nth-child(4) { animation-delay: 0.14s; }
        .employee-mobile-drawer .side-drawer.show .drawer-item:nth-child(5) { animation-delay: 0.17s; }
        .employee-mobile-drawer .side-drawer.show .drawer-item:nth-child(6) { animation-delay: 0.20s; }
        .employee-mobile-drawer .side-drawer.show .drawer-item:nth-child(7) { animation-delay: 0.23s; }
        .employee-mobile-drawer .side-drawer.show .drawer-item:nth-child(8) { animation-delay: 0.26s; }

        /* Scrollbar styling */
        .employee-mobile-drawer .side-drawer::-webkit-scrollbar {
            width: 6px;
        }

        .employee-mobile-drawer .side-drawer::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .employee-mobile-drawer .side-drawer::-webkit-scrollbar-thumb {
            background: #4e73df;
            border-radius: 3px;
        }

    </style>

    <style>
        .employee-mobile-drawer .bottom-nav a {
             gap: 0px;
        }

        .employee-mobile-drawer .bottom-nav .active::after {
            top: -8px!important;
        }
    </style>
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
    <div class="side-drawer" id="sideDrawer">
        <div class="drawer-header">
            <h5 class="drawer-title">
                <i class="fas fa-user-circle"></i>
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

            <div class="drawer-section-title">Account</div>

            <a href="{{ route('employee.settings') }}" class="drawer-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>

            <a href="{{ route('employee.my-subscriptions') }}" class="drawer-item">
                <i class="fas fa-crown"></i>
                <span>Subscription</span>
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

            <a href="#" class="drawer-item logout" onclick="event.preventDefault(); document.getElementById('employeeMobileMenuLogout').submit()">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <div class="bottom-nav d-md-none d-flex justify-content-around mobile-bottom-menu" style="max-height: 93px; background-color: #E5E7EB;">
        <div class="text-center mobileHome {{ request()->is('employee/home') ? 'active' : '' }}">
            <a href="{{ route('employee.home') }}">
{{--                <img src="{{ asset('/frontend/employee/images/header images/mobileHomeIcon.png') }}" alt="Home" />--}}
                <img src="{{ asset('/frontend/employee/fi_3405771.png') }}" alt="Home" />
                <span class="mt-1">Home</span>
            </a>
        </div>

        <div class="text-center mobileJobs {{ request()->is('employee/show-jobs') ? 'active' : '' }}">
            <a href="{{ route('employee.show-jobs') }}">
                <img src="{{ asset('/frontend/employee/images/header images/mobileJobIcon.png') }}" alt="Jobs" />
                <span class="mt-1">Jobs</span>
            </a>
        </div>

        <div class="text-center mobileProfile {{ request()->is('employee/my-profile') ? 'active' : '' }}">
            <a href="{{ route('employee.my-profile') }}">
                <img src="{{ asset('/frontend/employee/images/header images/mobileProfielIcon.png') }}" alt="Profile" />
                <span class="mt-1">Profile</span>
            </a>
        </div>

        <div class="text-center mobileInbox">
            <a href="#" id="openDrawer">
                <img src="{{ asset('/frontend/employee/images/header images/MobileMessageIcon.png') }}" alt="Options" />
                <span class="mt-1">Options</span>
            </a>
        </div>
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
<script>
    {{--var base_url = "{{ url('/') }}"+'/';--}}
    var base_url = "{{ url('/') }}"+'/frontend/employee/';
</script>
<script src="{{ asset('/frontend/employee/script.js') }}"></script>

<!-- Toastr JS -->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
<script src="{{ asset('/') }}common-assets/js/toastr-2.1.3.min.js"></script>
{{--    sweet alert js--}}
{{--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>--}}
{{--<script src="{{ asset('/') }}common-assets/js/sweetalert2@11-11.22.0.js"></script>--}}
<!-- Sweet Alert JS -->
{{--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>--}}

{{--    sweet alert js--}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{--    delete popup with sweet alert--}}
<script>
    $(document).on('click', '.data-delete-form', function () {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Swal.fire(
                //     'Deleted!',
                //     'Your file has been deleted.',
                //     'success'
                // )
                $(this).parent().submit();
            }

        })
    })
</script>
{!! Toastr::message() !!}
{!! $siteSetting->meta_footer ?? '' !!}
<script>
    var base_url = "{!! url('/') !!}/";

    let response;
    // async function callAjaxRequest(url, method, data = {})
    // {
    //     response = await callAjaxRequest(url, method, data);
    //
    //     return response;
    // }

    function sendAjaxRequest(url, method, data = {}) {
        return $.ajax({ // Return the Promise from $.ajax
            url: base_url + url,
            method: method,
            data: data
        })
            .done(function (data) { // .done() for success
                // console.log(data.job.employer_company);
                // console.log('print from dno');
                // No need to assign to 'response' here, it's passed to .then()
            })
            .fail(function (error) { // .fail() for error
                toastr.error(error);
                // The error will also be propagated to the .catch() when called
            });
    }
    // function sendAjaxRequest(url, method, data = {}) {
    //     var response;
    //     $.ajax({
    //         url: base_url+url,
    //         method: method,
    //         data: data,
    //         success: function (data) {
    //             // console.log(data);
    //             // console.log('console form master');
    //             response = data;
    //         },
    //         error: function (error) {
    //             toastr.error(error);
    //         }
    //     })
    //     return response;
    // }
</script>




{{--employee drawer mobile menu scripts--}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const openDrawerBtn = document.getElementById('openDrawer');
        const closeDrawerBtn = document.getElementById('closeDrawer');
        const drawer = document.getElementById('sideDrawer');
        const overlay = document.getElementById('drawerOverlay');

        // Open drawer
        if (openDrawerBtn) {
            openDrawerBtn.addEventListener('click', function(e) {
                e.preventDefault();
                drawer.classList.add('show');
                overlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            });
        }

        // Close drawer function
        function closeDrawer() {
            drawer.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Close button
        if (closeDrawerBtn) {
            closeDrawerBtn.addEventListener('click', closeDrawer);
        }

        // Overlay click
        if (overlay) {
            overlay.addEventListener('click', closeDrawer);
        }

        // Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && drawer.classList.contains('show')) {
                closeDrawer();
            }
        });
    });
</script>

@yield('script')
@stack('script')
</body>

</html>
