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
    <link rel="stylesheet" href="{{ asset('/') }}common-assets/css/sweetalert2-11.7.3.min.css" />

    <!-- css class helper -->
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Mainul12501/css-common-helper-classes/helper.min.css" />--}}
    <link rel="stylesheet" href="{{ asset('/') }}common-assets/css/helper.min.css" />


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
<script src="{{ asset('/') }}frontend/employee/script.js"></script>

<!-- Toastr JS -->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
<script src="{{ asset('/') }}common-assets/js/toastr-2.1.3.min.js"></script>
{{--    sweet alert js--}}
{{--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>--}}
<script src="{{ asset('/') }}common-assets/js/sweetalert2@11-11.22.0.js"></script>
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

@yield('script')
@stack('script')
</body>

</html>
