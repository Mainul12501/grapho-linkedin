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
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&display=swap" rel="stylesheet">


    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS (Login Style) -->
    <link rel="stylesheet" href="{{ asset('/') }}frontend/auth/loginStyle.css">
    <style>
        @media only screen and (max-width: 576px) {
            .signupCard {
                max-height: 550px;
                overflow-y: scroll;
            }
        }
    </style>
</head>

<body class="bodyAuthentication">

<!-- Card Container -->
<div class="card shadow signupCard">
    <a href="{{ route('/') }}" class="mx-auto"><img  src="{{ asset(isset($siteSetting->site_icon) ? $siteSetting->site_icon : '/frontend/employee/images/authentication images/Compnay logo.png') }}" alt="site-logo" style="width: 115px; max-height: 50px; margin-bottom: 15px;" class="signupLogo "></a>
    <h4>{{ trans('auth.sign_up_today') }}</h4>
    <p>{{ trans('auth.hiring_or_looking_opportunities') }}</p>

    <div class="userCard">
        <span class="">{{ trans('auth.sign_up_as') }}</span>
        <div>
            <a href="{{ route('auth.user-registration-page', ['user' => 'Employer']) }}" class="userSelectOption mb-3 mt-3">
                <div class="row d-flex align-items-center w-100">
                    <div class="col-2  iconWrapper">
                        <img src="{{ asset('/') }}frontend/employee/images/authentication images/employeeIcon.png" alt="" class="userSelectOptionIcon">
                    </div>
                    <div class="col-9">
                        <h5>{{ trans('auth.employer') }}</h5>
                        <p>{{ trans('auth.looking_to_scale_team') }}</p>
                    </div>
                    <div class="col-1">
                        <img src="{{ asset('/') }}frontend/employee/images/authentication images/arrow-right 1.png" alt="" class="arrowIcon">
                    </div>
                </div>
            </a>

            <a href="{{ route('auth.user-registration-page', ['user' => 'Employee']) }}" class="userSelectOption">
                <div class="row d-flex align-items-center w-100">
                    <div class="col-2  iconWrapper">
                        <img src="{{ asset('/') }}frontend/employee/images/authentication images/jobSeekerIcon.png" alt="" class="userSelectOptionIcon">
                    </div>
                    <div class="col-9">
                        <h5>{{ trans('auth.job_seeker') }}</h5>
                        <p>{{ trans('auth.looking_for_job_opportunities') }}</p>
                    </div>
                    <div class="col-1">
                        <img src="{{ asset('/') }}frontend/employee/images/authentication images/arrow-right 1.png" alt="" class="arrowIcon">
                    </div>
                </div>
            </a>
        </div>
        <div class="mt-4">
            <span class="">{{ trans('auth.already_have_account') }} <a href="{{ route('auth.set-login-role') }}" class="fw-bold text-dark text-decoration-none">{{ trans('auth.log_in') }}</a></span>
        </div>

    </div>

</div>

<!-- Bootstrap 5 JS and Popper.js (Bootstrap 5 no longer needs jQuery) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
{!! $siteSetting->meta_footer ?? '' !!}
</body>

</html>
