<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Your Name">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $siteSetting->site_title ?? '' }}</title>
    {!! $siteSetting->meta_header ?? '' !!}

    <!-- Favicon -->
{{--    <link rel="icon" href="http://127.0.0.1:8000/frontend/employee/images/Logo icon.png" type="image/x-icon">--}}
    <link rel="icon" href="{{ asset($siteSetting->favicon ?? '') }}" type="image/x-icon">

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

    <a href="{{ route('/') }}" class="signupArrow text-decoration-none mb-4">
{{--        <img src="{{ asset(isset($siteSetting->logo) ? $siteSetting->logo : '/frontend/likewise.png') }}" alt="site logo" class="w-25" style="width: 115px; height: 28px">--}}
        <img src="{{ asset('/frontend/likewise.png') }}" alt="site logo" class="w-25" style="width: 115px; height: 28px">
    </a>

    <h1>{{ trans('auth.recover_your_account') }}</h1>
    <p>{{ trans('auth.welcome_back_enter_email_mobile') }}</p>


    <div class="p-2 email-div">
{{--        <a href="" class="signupBtn mb-3 d-none email-btn" >--}}
{{--            <img src="https://static.vecteezy.com/system/resources/thumbnails/002/205/854/small_2x/email-icon-free-vector.jpg" alt="recover with email" style="height: 25px" class="me-2">--}}
{{--            <span>Recover With Email</span>--}}
{{--        </a>--}}

        <a href="javascript:void(0)" class="signupBtn mobileBtn">
            <img src="{{ asset('/') }}frontend/employee/images/authentication images/smartphone 1.png" alt="recover with mobile" class="me-2">
            <span>{{ trans('auth.recover_with_mobile_number') }}</span>
        </a>

{{--        <div class="signUpOr text-center pt-2">--}}
{{--            <span>OR</span>--}}
{{--        </div>--}}

        <form action="" method="post" id="emailForm" class="mt-4">
            @csrf
            <input type="hidden" name="recover_method" value="email">
            <div id="signInWithEmail" class="mt-3">
                <label for="signUpMail">{{ trans('auth.email_address') }}</label>
                <div>
                    <input type="text" name="email" id="signUpMail" placeholder="{{ trans('auth.type_here') }}" class="w-100">
                </div>
                <a href=""> <button type="button" id="recoverWithEmailSubmitBtn">{{ trans('auth.send_otp') }}</button></a>
            </div>
        </form>

    </div>

    <div class="p-2 mobile-div d-none">
        <a href="javascript:void(0)" class="signupArrow text-decoration-none mb-4">
            <img src="{{ asset('/') }}frontend/employee/images/authentication images/leftArrow.png" alt="" class="me-2">
            <span>{{ trans('auth.recover_with_mobile') }}</span>
        </a>

        <form action="{{ route('auth.send-forgot-password-otp') }}" method="post" id="mobileNumberForm">
            @csrf
            <input type="hidden" name="recover_method" value="mobile">
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

                    <button type="button" id="continueBtn">{{ trans('auth.send_otp') }}</button>
                </div>
            </div>



        </form>

    </div>

    <div class="p-2 otp-div d-none">
        <form action="" id="checkOtpForm">
            <div class="afterContinuex ">
                <div class="loginbyMobile text-center mb-4 mt-3">
                    <img src="{{ asset('/') }}frontend/employee/images/authentication images/loginwithmobile.png" alt="">
                    <h3>{{ trans('auth.enter_verification_code') }}</h3>
                    <p class="mb-0">{{ trans('auth.otp_has_been_sent') }} <span id="otpMobile">+8801653523779</span></p>
                    {{--                    <a href="" class="">{{ trans('auth.change_number') }}</a>--}}
                </div>

                <div class="otp-container">
                    {{--                    <input type="text" class="otp-input" maxlength="1" />--}}
                    {{--                    <input type="text" class="otp-input" maxlength="1" />--}}
                    {{--                    <input type="text" class="otp-input" maxlength="1" />--}}
                    {{--                    <input type="text" class="otp-input" maxlength="1" />--}}
                    <input type="text" name="user_otp" value="0000" class="form-control">
                </div>

                <div class="p-2">
                    <button type="submit">{{ trans('auth.recover') }}</button>
                </div>
            </div>
        </form>
    </div>

    <div class="p-2 new-pass-div d-none">
        <form action="" method="post" id="newPassForm">
            @csrf
            <div class="afterContinuex ">
                <div class="loginbyMobile text-center mb-4 mt-3">
                    <img src="{{ asset('/') }}frontend/employee/images/authentication images/loginwithmobile.png" alt="">
                    <h3>{{ trans('auth.set_your_new_password') }}</h3>
                    {{--                    <a href="" class="">{{ trans('auth.change_number') }}</a>--}}
                </div>

                <div class="otp-containerx">
                    <input type="hidden" name="recover_value" value="" id="passRecoverValue">
                    <input type="hidden" name="recover_method" value="" id="passRecoverMethod">
                    <div>
                        <label for="newPass">{{ trans('auth.new_password') }}</label>
                        <input type="text" name="new_password" id="newPass" value="" class="form-control px-2 py-3">
                    </div>
                    <div>
                        <label for="newPass" class="mt-2">{{ trans('auth.confirm_password') }}</label>
                        <input type="text" name="confirm_password" id="newPass" value="" class="form-control px-2 py-3">
                    </div>

                </div>

                <div class="p-2">
                    <button type="submit">{{ trans('auth.update_password') }}</button>
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
    var recover_method = 'mobile';
    var recover_value = '';
    $(document).on('click', '.mobileBtn', function () {
        $('.email-div').addClass('d-none');
        $('.mobile-div').removeClass('d-none');
    })
    $(document).on('click', '.signupArrow', function () {
        $('.email-div').removeClass('d-none');
        $('.mobile-div').addClass('d-none');
        recover_method = 'mobile';
    })

    $(document).on('click', '#continueBtn', function () {
        var mobile = $('#phoneInput').val();
        $('#otpMobile').text(mobile);
        $('.signupArrow').addClass('signupArrowx').removeClass('signupArrow');
        $.ajax({
            url: "{{ route('auth.send-forgot-password-otp') }}",
            method: "POST",
            data: {mobile: mobile, recover_method: 'mobile'},
            success: function (data) {
                if (data.status == 'success') {
                    recover_method = 'mobile';
                    recover_value = $('input[name="mobile"]').val();
                    toastr.success(data.msg);
                    // $('#otpMobile').text(recover_value);
                    $('.otp-div').removeClass('d-none');
                    $('.mobile-div').addClass('d-none');
                    {{--setTimeout(function () {--}}
                    {{--    window.location.href = "{{ route('auth.verify-forgot-password-otp') }}?email=" + data.email + "&recover_method=email";--}}
                    {{--}, 2000);--}}
                } else {
                    toastr.error(data.error);
                }
            }
        })
    })
    {{--$(document).on('click', 'signupArrowx', function () {--}}
    {{--    $('.signupArrowx').addClass('signupArrow').removeClass('signupArrowx');--}}
    {{--    $('.afterContinue').addClass('d-none');--}}
    {{--    $('.beforeContinue').css('display', 'block');--}}
    {{--})--}}

    $(document).on('click', '#recoverWithEmailSubmitBtn', function () {
        event.preventDefault();
        sendAjaxRequest('auth/send-forgot-password-otp', 'POST', $('#emailForm').serialize(), '#recoverWithEmailSubmitBtn')
            .then(function (data) {

                if (data.status == 'success') {
                    recover_method = 'email';
                    recover_value = $('input[name="email"]').val();
                    toastr.success(data.msg);
                    $('#otpMobile').text(recover_value);
                    $('.otp-div').removeClass('d-none');
                    $('.email-div').addClass('d-none');
                    {{--setTimeout(function () {--}}
                    {{--    window.location.href = "{{ route('auth.verify-forgot-password-otp') }}?email=" + data.email + "&recover_method=email";--}}
                    {{--}, 2000);--}}
                } else {
                    toastr.error(data.error);
                }
            })
            .catch(function (error) {
                console.error('Error:', error);
            });
    })
    $(document).on('submit', '#checkOtpForm', function (event) {
        event.preventDefault();
        // var mobile = $('#phoneInput').val();
        var user_otp = $('input[name="user_otp"]').val();
        // var recover_method = $('input[name="recover_method"]').val();
        sendAjaxRequest('auth/verify-forgot-password-otp', 'POST', {
            recover_value: recover_value,
            user_otp: user_otp,
            recover_method: recover_method
        }, '#checkOtpForm button[type="submit"]')
            .then(function (data) {
                if (data.status == 'success') {
                    toastr.success(data.msg);
                    $('.new-pass-div').removeClass('d-none');
                    $('.otp-div').addClass('d-none');
                } else {
                    toastr.error(data.error);
                }
            })
            .catch(function (error) {
                console.error('Error:', error);
            });
    })
    $(document).on('submit', '#newPassForm', function (event) {
        event.preventDefault();
        // var mobile = $('#phoneInput').val();
        // var user_otp = $('input[name="user_otp"]').val();
        // var recover_method = $('input[name="recover_method"]').val();
        sendAjaxRequest('auth/reset-password', 'POST', {
            recover_value: recover_value,
            recover_method: recover_method,
            new_password: $('input[name="new_password"]').val(),
            confirm_password: $('input[name="confirm_password"]').val(),
        }, '#newPassForm button[type="submit"]')
            .then(function (data) {
                if (data.status == 'success') {
                    toastr.success(data.msg);
                    setTimeout(function () {
                        window.location.href = "{{ route('auth.set-login-role') }}";
                    }, 1000);
                } else {
                    toastr.error(data.error);
                }
            })
            .catch(function (error) {
                console.error('Error:', error);
            });
    })
</script>
<script>
    var base_url = "{!! url('/') !!}/";

    let response;
    let btnText = '';

    function sendAjaxRequest(url, method, data = {}, eventTriggerBtn = null) {
        return $.ajax({ // Return the Promise from $.ajax
            url: base_url + url,
            method: method,
            data: data,
            beforeSend: function () {
                // You can show a loader here if needed
                btnText = $(eventTriggerBtn).text();
                $(eventTriggerBtn).attr('disabled', true).text('Please wait...');
            },
            complete: function () {
                // Hide the loader here if needed
                $(eventTriggerBtn).attr('disabled', false).text(btnText);
            },
        })
            .done(function (data) { // .done() for success
                // console.log('print from dno');
                // No need to assign to 'response' here, it's passed to .then()
            })
            .fail(function (error) { // .fail() for error
                toastr.error(error);
                // The error will also be propagated to the .catch() when called
            });
    }

</script>
{!! $siteSetting->meta_footer ?? '' !!}
<script src="https://js.pusher.com/7.2.0/pusher.min.js"></script>
@include('frontend.zegocloud.incoming-call-popup')
</body>

</html>
