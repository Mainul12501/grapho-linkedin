<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Your Name">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Grapho</title>

    <!-- Favicon -->
    <link rel="icon" href="images/Logo icon.png" type="image/x-icon">

    <!-- Google Font: Geist -->
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&display=swap" rel="stylesheet">


    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS (Login Style) -->
    <link rel="stylesheet" href="{{ asset('/') }}frontend/auth/loginStyle.css" />
</head>

<body class="bodyAuthentication">

<!-- Card Container -->
<div class="card shadow signUpCard loginMain">

    <a href="{{ route('/') }}" class="signupArrow text-decoration-none mb-4">
        <img src="{{ asset('/') }}frontend/employee/images/authentication images/Compnay logo.png" alt="" class="w-25">
    </a>

    <h1>Log in to your account</h1>
    <p>Welcome back! Please enter your details</p>


    <div class="p-2 email-div">
        <a href="{{ route('auth.socialite.redirect', ['provider' => 'google', 'user' => 'Employee']) }}" class="signupBtn mb-3">
            <img src="{{ asset('/') }}frontend/employee/images/authentication images/googleIcon.png" alt="" class="me-2">
            <span>Log in with Google</span>
        </a>

        <a href="javascript:void(0)" class="signupBtn mobileBtn">
            <img src="{{ asset('/') }}frontend/employee/images/authentication images/smartphone 1.png" alt="" class="me-2">
            <span>Use mobile number</span>
        </a>

        <div class="signUpOr text-center pt-2">
            <span>OR</span>
        </div>

        <form action="{{ route('auth.custom-login') }}" method="post">
            @csrf
            <input type="hidden" name="login_method" value="email">
            <div id="signInWithEmail">
                <label for="signUpMail">Email address</label>
                <div>
                    <input type="text" name="email" id="signUpMail" placeholder="Type here" class="w-100">
                </div>

                <label for="supPassword">Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="supPassword" placeholder="Type here" class="w-100">
{{--                    <span class="toggle-icon"><img src="{{ asset('/') }}frontend/employee/images/authentication images/eye.png" alt=""></span> <!-- 👁 (eye icon as Unicode for now) -->--}}
                </div>


                <div class="signupCheckbox d-flex align-items-center mb-3">
                    <div class="row w-100">
                        <div class="col-6 d-flex align-items-center">
                            <input type="checkbox" name="remember_me" class="me-2">
                            <span>Remember me</span>
                        </div>
{{--                        <div class="col-6 d-flex align-items-center justify-content-end ">--}}
{{--                            <a href="" class="text-decoration-none"><span>Remember me</span></a>--}}
{{--                        </div>--}}
                    </div>
                </div>

                <a href=""> <button type="submit">Sign In</button></a>
            </div>
        </form>
    </div>

    <div class="p-2 mobile-div d-none">
        <a href="javascript:void(0)" class="signupArrow text-decoration-none mb-4">
            <img src="{{ asset('/') }}frontend/employee/images/authentication images/leftArrow.png" alt="" class="me-2">
            <span>Log in with mobile number</span>
        </a>

        <form action="{{ route('auth.custom-login') }}" method="post">
            @csrf
            <input type="hidden" name="login_method" value="mobile">
            <div class="beforeContinue">
                <div class="loginbyMobile text-center mb-4 mt-3">
                    <img src="{{ asset('/') }}frontend/employee/images/authentication images/loginwithmobile.png" alt="">
                    <h3>Enter you mobile number</h3>
                    <p>We will send you a verification code in this number.</p>
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

                    <button type="button" id="continueBtn">Continue</button>
                </div>
            </div>


            <div class="afterContinue">
                <div class="loginbyMobile text-center mb-4 mt-3">
                    <img src="{{ asset('/') }}frontend/employee/images/authentication images/loginwithmobile.png" alt="">
                    <h3>Enter verification code</h3>
                    <p class="mb-0">OTP has been sent to <span id="otpMobile">+8801653523779</span></p>
                    <a href="" class="">Change number</a>
                </div>

                <div class="otp-container">
{{--                    <input type="text" class="otp-input" maxlength="1" />--}}
{{--                    <input type="text" class="otp-input" maxlength="1" />--}}
{{--                    <input type="text" class="otp-input" maxlength="1" />--}}
{{--                    <input type="text" class="otp-input" maxlength="1" />--}}
                    <input type="text" name="user_otp" value="0000" class="form-control">
                </div>

                <div class="p-2">
                    <button type="submit">Log in</button>
                </div>
            </div>
        </form>
    </div>

    <div class="mt-4">
        <span class="">Don't have an account? <a href="login.html" class="fw-bold text-dark text-decoration-none">Sign Up</a></span>
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
        $('.signupArrow').addClass('signupArrowx').removeClass('signupArrow');
        $.ajax({
            url: "{{ route('send-otp') }}",
            method: "POST",
            data: {mobile: mobile},
            success: function (response) {
                toastr.success(response.msg);
                console.log(response.otp);
            }
        })
    })
    $(document).on('click', 'signupArrowx', function () {
        $('.signupArrowx').addClass('signupArrow').removeClass('signupArrowx');
        $('.afterContinue').addClass('d-none');
        $('.beforeContinue').css('display', 'block');
    })
</script>
</body>

</html>
