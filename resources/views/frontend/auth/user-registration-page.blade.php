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

    <!-- Toastr Css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS (Login Style) -->
    <link rel="stylesheet" href="{{ asset('/') }}frontend/auth/loginStyle.css">
    <style>
        .input-text-box {
            border: 1.5px solid #DADADA;
            padding: 16px;
            border-radius: 16px;
            /* margin-bottom: 15px; */
            color: #141C25;
            font-weight: 400;
            font-size: 16px;
            line-height: 160%;
        }
        .signUpCard, .signupCard {
            max-height: 600px!important;
            overflow-y: scroll;
            height: auto!important;
        }
        .signUpMail {
            border: 1.5px solid #DADADA;
            padding: 16px;
            border-radius: 16px;
            margin-bottom: 15px;
            color: #141C25;
            font-weight: 400;
            font-size: 16px;
            line-height: 160%;
            letter-spacing: -1%;
        }
        .otp-send-btn {
            cursor: pointer;
            border: 1.5px solid #DADADA;
            padding: 16px;
            border-radius: 0px 16px 16px 0px;
            margin-bottom: 15px;
            color: #141C25;
            font-weight: 400;
            font-size: 16px;
            line-height: 160%;
            letter-spacing: -1%;
        }
    </style>
</head>

<body class="bodyAuthentication">

<!-- Card Container -->
<div class="card shadow signUpCard">

    <a href="{{ route('auth.set-registration-role') }}" class="signupArrow text-decoration-none mb-4">
        <img src="{{ asset('/') }}frontend/employee/images/authentication images/leftArrow.png" alt="" class="me-2">
        <span>{{ trans('auth.sign_up_as') }} {{ $userType ?? 'employer' }}</span>
    </a>

    <div class="p-2">
        <a href="{{ route('auth.socialite.redirect', ['provider' => 'google', 'user' => $userType]) }}" class="signupBtn mb-3 hide-during-form">
            <img src="{{ asset('/') }}frontend/employee/images/authentication images/googleIcon.png" alt="google icon" class="me-2">
            <span>{{ trans('auth.sign_up_with_google') }}</span>
        </a>

        <a href="javascript:void(0)" class="signupBtn hide-during-form" id="signUpWithMobileBtn">
            <img src="{{ asset('/') }}frontend/employee/images/authentication images/smartphone 1.png" alt="phone" class="me-2">
            <span>{{ trans('auth.use_mobile_number') }}</span>
        </a>

        <div class="signUpOr text-center pt-2 hide-during-form">
            <span>{{ trans('auth.or') }}</span>
        </div>

        <form action="{{ route('auth.custom-registration') }}" method="post">
            @csrf
            <input type="hidden" name="user_type" id="userType" value="{{ $userType ?? 'Employee' }}">
            <input type="hidden" name="reg_method" value="email" id="reg_method">
{{--            @if ($errors->any())--}}
{{--                <ul class="text-danger">--}}
{{--                    @foreach ($errors->all() as $error)--}}
{{--                        <li>{{ $error }}</li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            @endif--}}
            <div id="signUpEmailDiv1">
                <label for="signUpMail">{{ trans('auth.email_address') }}</label>
                <div class="input-group">
                    <input type="text" id="signUpMail" placeholder="{{ trans('auth.type_here') }}" class=" signUpMail form-control" style="border-radius: 16px 0px 0px 16px">
                    <span class="input-group-text signUpMail" id="sendOtpForEmailBtn" style="cursor: pointer; border-radius: 0px 16px 16px 0px">{{ trans('auth.send_otp') }}</span>
                    <span class="text-danger" id="signUpMailError"></span>
                </div>

                <div id="emailOtpDiv" class="d-none">
                    <label for="signUpOtp">{{ trans('auth.otp') }}</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control py-3 signUpMail" name="otp" placeholder="{{ trans('auth.otp') }}" id="emailOtp">
                        <span class="input-group-text signUpMail" id="checkEmailOtpBtn" style="cursor: pointer">{{ trans('auth.verify') }}</span>
                    </div>
                </div>

                <a href="javascript:void(0)"><button type="button" id="emailContinueBtn" class="d-none">{{ trans('auth.continue') }}</button></a>
            </div>
            <div id="signUpMobileDiv1" class="d-none">
                <label for="signUpMail">{{ trans('auth.phone_number') }}</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control py-3 signUpMail" name="phone" placeholder="{{ trans('auth.phone_number') }}" id="phoneNumber">
                    <span class="input-group-text otp-send-btn" id="sendOtpBtn" style="cursor: pointer">{{ trans('auth.send_otp') }}</span>
                </div>
                <div id="otpDiv" class="d-none">
                    <label for="signUpOtp">{{ trans('auth.otp') }}</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control py-3 signUpMail" name="otp" placeholder="{{ trans('auth.otp') }}" id="otp">
                        <span class="input-group-text otp-send-btn" id="checkOtpBtn" style="cursor: pointer">{{ trans('auth.verify') }}</span>
                    </div>
                </div>
                <div id="phoneContinueBtnDiv" class="d-none">
                    <a href="javascript:void(0)"><button type="button" id="phoneContinueBtn">{{ trans('auth.continue') }}</button></a>
                </div>
            </div>
            <div id="signUpEmailDiv2" class="d-none"  style="overflow-y: scroll; max-height: 400px">
                <div class="p-2">

                    <label for="signUpMail">{{ trans('auth.email_address') }}</label>
                    <div class="">
                        <input type="email" id="signUpMail" name="email" value="" class="printSignUpMail w-100">

                    </div>

{{--                    @if(isset($_GET['user']) && $_GET['user'] == 'Employer')--}}
{{--                        <label for="fullname">{{ isset($_GET['user']) && $_GET['user'] == 'Employer' ? 'Company Name' : 'User name' }}</label>--}}
{{--                        <div>--}}
{{--                            <input type="text" id="fullname" name="name" placeholder="Type here" class="w-100">--}}
{{--                            @error('name') <span class="text-danger">{{ $errors->first('name') }}</span> @enderror--}}
{{--                        </div>--}}
{{--                    @endif--}}


                    <label for="phoneInput">{{ trans('auth.phone_number') }}</label>
                    <div class="phone-wrapper" style="margin-bottom: 0px!important;">
{{--                        <div class="country-select">--}}
{{--                            <img id="flagIcon" src="https://flagcdn.com/w40/bd.png" alt="Flag">--}}
{{--                            <select id="countryCode" style="border: none; outline: none; font-weight: 500;" >--}}
{{--                                <option value="+880" data-flag="bd">+880</option>--}}
{{--                                <option value="+91" data-flag="in">+91</option>--}}
{{--                                <option value="+1" data-flag="us">+1</option>--}}
{{--                                <option value="+44" data-flag="gb">+44</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <input type="tel" id="phoneInput" placeholder="{{ trans('auth.type_here') }}" class="phone-input" name="mobile">
                        @error('mobile') <span class="text-danger">{{ $errors->first('mobile') }}</span> @enderror
                    </div>

                    @if($userType == 'Employer')
{{--                        <label for="organizationName">Industry</label>--}}
{{--                        <div>--}}
{{--                            <select name="industry_id" class=" form-control select2" id="" data-placeholder="Select Industry">--}}
{{--                                <option selected disabled >Hi</option>--}}
{{--                                @foreach($industries as $industry)--}}
{{--                                    <option value="{{ $industry->id }}">{{ $industry->name ?? 'Industry Name' }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @error('industry_id') <span class="text-danger">{{ $errors->first('industry_id') }}</span> @enderror--}}
{{--                        </div>--}}
{{--                        <label for="organizationName" class="mt-3">Organization Category</label>--}}
{{--                        <div>--}}
{{--                            <select name="employer_company_category_id" class=" form-control select2" id="" data-placeholder="Select Company Category">--}}
{{--                                <option selected disabled >Hi</option>--}}
{{--                                @foreach($companyCategories as $companyCategory)--}}
{{--                                    <option value="{{ $companyCategory->id }}">{{ $companyCategory->category_name ?? 'Company Category Name' }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @error('employer_company_category_id') <span class="text-danger">{{ $errors->first('employer_company_category_id') }}</span> @enderror--}}
{{--                        </div>--}}
                        <label for="organizationName" class="mt-3">{{ trans('auth.organization_name') }}</label>
                        <div>
                            <input type="text" name="organization_name" id="organizationName" placeholder="{{ trans('auth.type_here') }}" class="w-100" style="margin-bottom: 0px!important;" />
                            @error('organization_name') <span class="text-danger">{{ $errors->first('organization_name') }}</span> @enderror
                        </div>
                    @endif
                    @if(isset($_GET['user']) && $_GET['user'] == 'Employer')
                        <div class="">
                            <label for="binNumber" class="mt-3">{{ trans('auth.bin_number') }}</label>
                            <div>
                                <input type="text" name="bin_number" id="binNumber" placeholder="{{ trans('auth.bin_number') }}" class="w-100 form-control input-text-box">
                                @error('bin_number') <span class="text-danger">{{ $errors->first('bin_number') }}</span> @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tradeLicenseNumber" class="mt-3">{{ trans('auth.trade_license_number') }}</label>
                            <div>
                                <input type="text" name="trade_license_number" id="tradeLicenseNumber" placeholder="{{ trans('auth.trade_license_number') }}" class="w-100 form-control input-text-box">
                                @error('trade_license_number') <span class="text-danger">{{ $errors->first('trade_license_number') }}</span> @enderror
                            </div>
                        </div>
                    @endif

{{--                    @if(isset($_GET['user']) && $_GET['user'] != 'Employer')--}}
{{--                        <label for="organizationName">Gender</label>--}}
{{--                        <div>--}}
{{--                            <select name="gender" class="w-100 form-control select2" id="" data-placeholder="Select Industry">--}}
{{--                                --}}{{--                                <option selected disabled >Hi</option>--}}
{{--                                <option value="male">Male</option>--}}
{{--                                <option value="female">Female</option>--}}
{{--                                <option value="other">Other</option>--}}
{{--                            </select>--}}
{{--                            @error('industry_id') <span class="text-danger">{{ $errors->first('industry_id') }}</span> @enderror--}}
{{--                        </div>--}}
{{--                    @endif--}}


                    <label for="supPassword">{{ trans('auth.password') }}</label>
                    <div class="input-wrapper">
                        <input type="password" id="supPassword" name="password" placeholder="{{ trans('auth.type_here') }}" class="w-100">
                        <span class="toggle-icon">
                            <img id="show" class="" src="{{ asset('/') }}frontend/employee/images/authentication images/eye.png" alt="">
                            <span id="hide" class="d-none">👁</span>
                        </span> <!-- 👁 (eye icon as Unicode for now) -->
                    </div>


{{--                    <div class="signupCheckbox d-flex align-items-center mb-3">--}}
{{--                        <input type="checkbox" class="me-2">--}}
{{--                        <span>I agree to <a href="">Terms & Conditions</a></span>--}}
{{--                    </div>--}}


                    <button type="submit" class="mt-2">{{ trans('auth.create_account') }}</button>
                </div>
            </div>
        </form>
    </div>

    <div class="mt-4">
        <span class="">{{ trans('auth.already_have_account') }} <a href="{{ route('auth.set-login-role') }}" class="fw-bold text-dark text-decoration-none">{{ trans('auth.log_in') }}</a></span>
    </div>






</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Bootstrap 5 JS and Popper.js (Bootstrap 5 no longer needs jQuery) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{!! Toastr::message() !!}

<script src="{{ asset('/') }}frontend/employee/script.js"></script>
<!-- select2 js -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
    .select2-container{width: 100%!important;}
</style>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: "100%",
            dropdownParent: $('.signUpCard') // Ensure the dropdown is within the card
            // theme: "bootstrap-5",
        });
    });
</script>


<script>
    $(document).on('click', '#emailContinueBtn', function () {
        var signUpMail = $('.signUpMail').val();
        if (signUpMail == '')
        {
            $('#signUpMailError').text('Please input Email before processing.');
            return false;
        }
        $('.printSignUpMail').val(signUpMail);
        $('#signUpEmailDiv1').addClass('d-none');
        $('.hide-during-form').addClass('d-none');
        $('#signUpEmailDiv2').removeClass('d-none');
    })
    // $(document).on('click', '#signUpWithMobileBtn', function () {
    //     $('#signUpEmailDiv1').addClass('d-none');
    //     $('#signUpEmailDiv2').removeClass('d-none');
    // })
    var serverOtp = 0;
    $(document).on('click', '#sendOtpBtn', function () {
        $.ajax({
            url: '{{ route('send-otp') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                mobile: $('#phoneNumber').val()
            },
            success: function (response) {
                if (response.status == 'success')
                {
                    serverOtp = response.otp;
                    $('#otpDiv').removeClass('d-none');
                    toastr.success(response.msg);
                } else {
                    toastr.error(response.msg);
                }
            },
            error: function (xhr) {
                toastr.error('An error occurred while sending the OTP.');
            }
        })
    })
    $(document).on('click', '#sendOtpForEmailBtn', function () {
        $.ajax({
            url: '{{ route('send-otp') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                email: $('#signUpMail').val(),
            },
            success: function (response) {
                if (response.status == 'success')
                {
                    // serverOtp = response.otp;
                    toastr.success(response.msg);
                    $('#emailOtpDiv').removeClass('d-none');
                } else {
                    toastr.error(response.msg);
                }
            },
            error: function (xhr) {
                toastr.error('An error occurred while sending the OTP.');
            }
        })
    })
    $(document).on('click', '#checkOtpBtn', function () {
        var enteredOtp = $('#otp').val();
        $.ajax({
            url: '{{ route('verify-otp') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                mobile: $('#phoneNumber').val(),
                user_otp: enteredOtp,
            },
            success: function (response) {
                if (response.status == 'success')
                {
                    // serverOtp = response.otp;
                    toastr.success(response.msg);
                    $('#phoneContinueBtnDiv').removeClass('d-none');
                } else {
                    toastr.error(response.msg);
                }
            },
            error: function (xhr) {
                toastr.error('An error occurred while sending the OTP.');
            }
        })
    });
    $(document).on('click', '#checkEmailOtpBtn', function () {
        var enteredOtp = $('#emailOtp').val();
        $.ajax({
            url: '{{ route('verify-otp') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                email: $('#signUpMail').val(),
                user_otp: enteredOtp,
            },
            success: function (response) {
                if (response.status == 'success')
                {
                    // serverOtp = response.otp;
                    toastr.success(response.msg);
                    $('#emailContinueBtn').removeClass('d-none');
                } else {
                    toastr.error(response.msg);
                }
            },
            error: function (xhr) {
                toastr.error('An error occurred while sending the OTP.');
            }
        })
    });
    $(document).on('click', '#signUpWithMobileBtn', function () {
        $('#signUpEmailDiv1').addClass('d-none');
        $('.hide-during-form').addClass('d-none');
        $('#signUpMobileDiv1').removeClass('d-none');
        $('#reg_method').val('mobile');
    })

    $(document).on('click', '#phoneContinueBtn', function () {
        var signUpMobile = $('#phoneNumber').val();
        if (signUpMobile == '') {
            $('#signUpMailError').text('Please input Phone Number before processing.');
            return false;
        }
        $('#phoneInput').val(signUpMobile);
        $('#signUpMobileDiv1').addClass('d-none');
        $('.hide-during-form').addClass('d-none');
        $('#signUpEmailDiv2').removeClass('d-none');
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
<style>
    .select2-container {
        width: 100% !important;
    }
</style>
</body>

</html>
