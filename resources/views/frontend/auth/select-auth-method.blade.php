<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Your Name">
    <title>Like Wise BD</title>
    {!! $siteSetting->meta_header ?? '' !!}
    <!-- Favicon -->
    <link rel="icon" href="images/Logo icon.png" type="image/x-icon">

    <!-- Google Font: Geist -->
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS (Login Style) -->
    <link rel="stylesheet" href="{{ asset('/') }}frontend/auth/loginStyle.css">

    <!-- Geist Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <style>
        p span {
            font-family: "Mulish", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
        }
        h1 h2 h3 h4 h5 h6 {
            font-family: "Mulish", sans-serif;
            font-optical-sizing: auto;
            font-weight: 600;
            font-style: normal;
        }
        @media only screen and (max-width: 600px) {
            .loginCard {
                overflow-y: scroll;
            }
        }
        @media only screen and (max-width: 768px) {
            .loginCard p {
                font-weight: 400!important;
                font-size: 18px!important;
            }
            #hir {font-size: 13px!important;}
        }
    </style>
</head>

<body class="bodyAuthentication">

<!-- Card Container -->
<div class="card loginCard">
    <!-- Company Logo -->
    <img src="{{ asset(isset($siteSetting->site_icon) ? $siteSetting->site_icon : '/frontend/employee/images/authentication images/Compnay logo.png') }}" alt="Company Logo" style="height: 41px; width: 166px">

    <!-- Call to Action -->
{{--    <p>{{ trans('auth.hiring_or_looking_opportunities') }}</p>--}}
    <p id="hir">Hiring or looking for opportunities?</p>

    <!-- Buttons for Log In and Create Account -->
    <a href="{{ route('auth.set-login-role') }}"><button class="btn login" style="border-radius: 15px;">{{ trans('auth.log_in') }}</button></a>
    <a href="{{ route('auth.set-registration-role') }}"><button class="btn createAccount" style="border-radius: 15px;">{{ trans('auth.create_account') }}</button></a>
</div>

<!-- Bootstrap 5 JS and Popper.js (Bootstrap 5 no longer needs jQuery) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
{!! $siteSetting->meta_footer ?? '' !!}
<script src="https://js.pusher.com/7.2.0/pusher.min.js"></script>
@include('frontend.zegocloud.incoming-call-popup')
</body>

</html>
