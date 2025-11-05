<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Your Name">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Like Wise BD</title>
    {!! $siteSetting->meta_header ?? '' !!}

    <!-- Favicon -->
{{--    <link rel="icon" href="http://127.0.0.1:8000/frontend/employee/images/Logo icon.png" type="image/x-icon">--}}
    <link rel="icon" href="{{ asset($siteSetting->favicon) }}" type="image/x-icon">

    <!-- Google Font: Geist -->
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&display=swap" rel="stylesheet">


    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS (Login Style) -->
    <link rel="stylesheet" href="{{ asset('/') }}frontend/auth/loginStyle.css" />

    <!-- Geist Font -->
{{--    <link rel="preconnect" href="https://fonts.googleapis.com">--}}
{{--    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>--}}
{{--    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">--}}
    <style>
        p span {
            font-family: "Geist", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
        }
        h1 h2 h3 h4 h5 h6 {
            font-family: "Geist", sans-serif;
            font-optical-sizing: auto;
            font-weight: 600;
            font-style: normal;
        }

    </style>
</head>

<body class="bodyAuthentication">

<!-- Card Container -->
<div class="card shadow signUpCard loginMain">

{{--    <a href="{{ route('/') }}" class="signupArrow text-decoration-none mb-4">--}}
{{--        <img src="{{ asset(isset($siteSetting->logo) ? $siteSetting->logo : '/frontend/employee/images/authentication images/Compnay logo.png') }}" alt="site logo" class="w-25" style="width: 115px; height: 28px">--}}
{{--    </a>--}}


    <h1>{{ trans('auth.login_to_your_account') }}</h1>
    <p>{{ trans('auth.welcome_back') }}</p>


    <div class="p-2 email-div">
        <a href="{{ route('auth.socialite.redirect', ['provider' => 'google', 'user' => 'Employee']) }}" class="signupBtn mb-3">
            <img src="{{ asset('/') }}frontend/employee/images/authentication images/googleIcon.png" alt="" class="me-2">
            <span>{{ trans('auth.log_in_with_google') }}</span>
        </a>

        <a href="javascript:void(0)" class="signupBtn mobileBtn">
            <img src="{{ asset('/') }}frontend/employee/images/authentication images/smartphone 1.png" alt="" class="me-2">
            <span>{{ trans('auth.use_mobile_number') }}</span>
        </a>

        <div class="signUpOr text-center pt-2">
            <span>{{ trans('auth.or') }}</span>
        </div>

        <form action="{{ route('auth.custom-login') }}" method="post">
            @csrf
            <input type="hidden" name="login_method" value="email">
            <div id="signInWithEmail">
                <label for="signUpMail">{{ trans('auth.email_address') }}</label>
                <div>
                    <input type="text" name="email" id="signUpMail" placeholder="{{ trans('auth.type_here') }}" class="w-100">
                </div>

                <label for="supPassword">{{ trans('auth.password') }}</label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="supPassword" placeholder="{{ trans('auth.type_here') }}" class="w-100">
                    <span class="toggle-icon">
                        <img id="show" class="" src="{{ asset('/') }}frontend/employee/images/authentication images/eye.png" alt="">
                        <span id="hide" class="d-none">👁</span>
                    </span> <!-- 👁 (eye icon as Unicode for now) -->
                </div>


                <div class="signupCheckbox d-flex align-items-center mb-3">
                    <div class="row w-100">
                        <div class="col-6 d-flex align-items-center">
                            <input type="checkbox" name="remember_me" class="me-2">
                            <span>{{ trans('auth.remember_me') }}</span>
                        </div>
                        <div class="col-6 d-flex align-items-center justify-content-end ">
                            <a href="{{ route('auth.forgot-password-page') }}" class="text-decoration-none"><span>{{ trans('auth.forgot_password') }}</span></a>
                        </div>
                    </div>
                </div>

                <a href=""> <button type="submit">{{ trans('auth.sign_in') }}</button></a>
            </div>
        </form>
    </div>

    <div class="p-2 mobile-div d-none">
        <a href="javascript:void(0)" class="signupArrow text-decoration-none mb-4">
            <img src="{{ asset('/') }}frontend/employee/images/authentication images/leftArrow.png" alt="" class="me-2">
            <span>{{ trans('auth.log_in_with_mobile_number') }}</span>
        </a>

        <form action="{{ route('auth.custom-login') }}" method="post">
            @csrf
            <input type="hidden" name="login_method" value="mobile">
            <div class="beforeContinue">
                <div class="loginbyMobile text-center mb-4 mt-3">
                    <img src="{{ asset('/') }}frontend/employee/images/authentication images/loginwithmobile.png" alt="">
                    <h3>{{ trans('auth.enter_your_mobile_number') }}</h3>
                    <p>{{ trans('auth.we_will_send_verification_code') }}</p>
                </div>

                <div class="p-2">
                    <div class="phone-wrapper">
                        {{--                    <div class="country-select">--}}
                        {{--                        <img id="flagIcon" src="https://flagcdn.com/w40/bd.png" alt="Flag">--}}
                        {{--                        <select id="countryCode" style="border: none; outline: none; font-weight: 500;">--}}
                        {{--                            <option value="+880" data-flag="bd">+880</option>--}}
                        {{--                            <option value="+91" data-flag="in">+91</option>--}}
                        {{--                            <option value="+1" data-flag="us">+1</option>--}}
                        {{--                            <option value="+44" data-flag="gb">+44</option>--}}
                        {{--                        </select>--}}
                        {{--                    </div>--}}
                        <input type="tel" id="phoneInput" name="mobile" value="" class="phone-input">
                    </div>

                    <button type="button" id="continueBtn">{{ trans('auth.continue') }}</button>
                </div>
            </div>


            <div class="afterContinue">
                <div class="loginbyMobile text-center mb-4 mt-3">
                    <img src="{{ asset('/') }}frontend/employee/images/authentication images/loginwithmobile.png" alt="">
                    <h3>{{ trans('auth.enter_verification_code') }}</h3>
                    <p class="mb-0">{{ trans('auth.otp_has_been_sent') }} <span id="otpMobile">+8801653523779</span></p>
                    <a href="" class="" id="changeNumber">{{ trans('auth.change_number') }}</a>
                </div>

                <div class="otp-container">
{{--                    <input type="text" class="otp-input" maxlength="1" />--}}
{{--                    <input type="text" class="otp-input" maxlength="1" />--}}
{{--                    <input type="text" class="otp-input" maxlength="1" />--}}
{{--                    <input type="text" class="otp-input" maxlength="1" />--}}
                    <input type="text" name="user_otp" value="0000" class="form-control">
                </div>

                <div class="p-2">
                    <button type="submit">{{ trans('index.login') }}</button>
                </div>
            </div>
        </form>
    </div>

    <div class="mt-4">
        <span class="">{{ trans('auth.dont_have_account') }} <a href="{{ route('auth.set-registration-role') }}" class="fw-bold text-dark text-decoration-none">{{ trans('auth.sign_up') }}</a></span>
    </div>






</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Bootstrap 5 JS and Popper.js (Bootstrap 5 no longer needs jQuery) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<!-- Toastr Css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ asset('/') }}frontend/employee/script.js"></script>
{!! Toastr::message() !!}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click', '.mobileBtn', function () {
        $('.email-div').addClass('d-none');
        $('.mobile-div').removeClass('d-none');
    })
    $(document).on('click', '.signupArrow', function () {
        $('.email-div').removeClass('d-none');
        $('.mobile-div').addClass('d-none');
    })
    $(document).on('click', '#continueBtn', function () {
        var mobile = $('#phoneInput').val();
        $('#otpMobile').text(mobile);
        // $('.signupArrow').addClass('signupArrowx').removeClass('signupArrow');
        $.ajax({
            url: "{{ route('send-otp') }}",
            method: "POST",
            data: {mobile: mobile, req_from: 'login'},
            success: function (response) {
                if (response.status === 'error') {
                    toastr.error(response.msg);
                    return;
                }
                $('.signupArrow').addClass('signupArrowx').removeClass('signupArrow');
                toastr.success(response.msg);

                // ---- [BACKEND] Build payload here (no UI change) ----
                // const payload = createSendOtpPayload();
                $('.beforeContinue').css('display', 'none');
                $('.afterContinue').css('display', 'block');
            }
        })
    })
    $(document).on('click', 'signupArrowx', function () {
        $('.signupArrowx').addClass('signupArrow').removeClass('signupArrowx');
        $('.afterContinue').addClass('d-none');
        $('.beforeContinue').css('display', 'block');
    })
    $(document).on('click', '#changeNumber', function () {
        event.preventDefault();
        $('.signupArrowx').addClass('signupArrow').removeClass('signupArrowx');
        $('.email-div').addClass('d-none');
        // $('.afterContinue').addClass('d-none');
        $('.afterContinue').css('display', 'none');
        $('.beforeContinue').css('display', 'block');
    })
    $(document).on('click', '#show', function () {
        event.preventDefault();
        $('#supPassword').attr('type', 'text');
        $('#hide').removeClass('d-none');
        $('#show').addClass('d-none');
    })
    $(document).on('click', '#hide', function () {
        event.preventDefault();
        $('#supPassword').attr('type', 'password');
        $('#hide').addClass('d-none');
        $('#show').removeClass('d-none');
    })
</script>
{!! $siteSetting->meta_footer ?? '' !!}
</body>

</html>
