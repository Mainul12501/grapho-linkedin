<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Your Name" />
    <title>{{ isset($siteSetting) ? $siteSetting->site_title : 'Grapho' }} - @yield('title')</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ isset($siteSetting) ? $siteSetting->site_title : asset('/frontend/employee/images/Logo icon.png') }}" type="image/x-icon" />
    <!-- Google Font: Geist -->
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;700&display=swap" rel="stylesheet" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/') }}frontend/employee/headerStyle.css" />
    <link rel="stylesheet" href="{{ asset('/') }}frontend/employee/mainstyle.css" />
    @yield('style')
    @stack('style')
</head>

<body>
<!-- Header -->
@include('frontend.employee.includes.header')

<!-- Main Content -->
@yield('body')

<!-- Mobile Bottom Navigation -->
{{--<div class="bottom-nav d-md-none d-flex justify-content-around py-4">--}}
{{--    <div class="text-center mobileHome active">--}}
{{--        <a href="home.html"><img src="{{ asset('/') }}frontend/employee/images/header images/mobileHomeIcon.png" alt="" /> <br />--}}
{{--            Home</a>--}}
{{--    </div>--}}

{{--    <div class="text-center mobileJobs">--}}
{{--        <a href="jobs.html"><img src="{{ asset('/') }}frontend/employee/images/header images/mobileJobIcon.png" alt="" /> <br />--}}
{{--            Jobs</a>--}}
{{--    </div>--}}
{{--    <div class="text-center mobileInbox">--}}
{{--        <a href=""><img src="{{ asset('/') }}frontend/employee/images/header images/MobileMessageIcon.png" alt="" />--}}
{{--            <br />--}}
{{--            Inbox</a>--}}
{{--    </div>--}}
{{--    <div class="text-center mobileProfile">--}}
{{--        <a href=""><img src="{{ asset('/') }}frontend/employee/images/header images/mobileProfielIcon.png" alt="" />--}}
{{--            <br />--}}
{{--            Profile</a>--}}
{{--    </div>--}}
{{--</div>--}}

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script>
    {{--var base_url = "{{ url('/') }}"+'/';--}}
    var base_url = "{{ url('/') }}"+'/frontend/employee/';
</script>
<script src="{{ asset('/') }}frontend/employee/script.js"></script>

@yield('script')
@stack('script')
</body>

</html>
