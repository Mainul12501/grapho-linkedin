<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Your Name">
    <title>Grapho</title>

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
</head>

<body class="bodyAuthentication">

<!-- Card Container -->
<div class="card shadow signUpCard">

    <a href="{{ route('auth.set-registration-role') }}" class="signupArrow text-decoration-none mb-4">
        <img src="{{ asset('/') }}frontend/employee/images/authentication images/leftArrow.png" alt="" class="me-2">
        <span>Sign up as {{ $userType ?? 'employer' }}</span>
    </a>

    <div class="p-2">
        <a href="{{ route('auth.socialite.redirect', ['provider' => 'google', 'user' => $userType]) }}" class="signupBtn mb-3">
            <img src="{{ asset('/') }}frontend/employee/images/authentication images/googleIcon.png" alt="" class="me-2">
            <span>Sign up with Google</span>
        </a>

{{--        <a href="javascript:void(0)" class="signupBtn" id="signUpWithMobileBtn">--}}
{{--            <img src="{{ asset('/') }}frontend/employee/images/authentication images/smartphone 1.png" alt="" class="me-2">--}}
{{--            <span>Use mobile number</span>--}}
{{--        </a>--}}

        <div class="signUpOr text-center pt-2">
            <span>OR</span>
        </div>

        <form action="{{ route('auth.custom-registration') }}" method="post">
            @csrf
            <input type="hidden" name="user_type" id="userType" value="{{ $userType ?? 'Employee' }}">
            <input type="hidden" name="reg_method" value="email">
            <div id="signUpEmailDiv1">
                <label for="signUpMail">Email address</label>
                <div>
                    <input type="text" id="signUpMail" placeholder="Type here" class="w-100 signUpMail form-control">
                    <span class="text-danger" id="signUpMailError"></span>
                </div>

                <a href="javascript:void(0)"><button type="button" id="emailContinueBtn">Continue</button></a>
            </div>
            <div id="signUpEmailDiv2" class="d-none">
                <div class="p-2">

                    <label for="signUpMail">Email address</label>
                    <div>
                        <input type="email" id="signUpMail" name="email" value="shetu@xyz.com" class="printSignUpMail w-100">
                    </div>

                    <label for="fullname">{{ isset($_GET['user']) && $_GET['user'] == 'Employer' ? 'Company Name' : 'Full name' }}</label>
                    <div>
                        <input type="text" id="fullname" name="name" placeholder="Type here" class="w-100">
                        @error('name') <span class="text-danger">{{ $errors->first('name') }}</span> @enderror
                    </div>


                    <label for="phoneInput">Phone number</label>
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
                        <input type="tel" id="phoneInput" placeholder="Type here" class="phone-input" name="mobile">
                        @error('mobile') <span class="text-danger">{{ $errors->first('mobile') }}</span> @enderror
                    </div>

                    @if($userType == 'Employer')
                        <label for="organizationName">Industry</label>
                        <div>
                            <select name="industry_id" class="w-100 form-control select2" id="" data-placeholder="Select Industry">
{{--                                <option selected disabled >Hi</option>--}}
                                @foreach($industries as $industry)
                                    <option value="{{ $industry->id }}">{{ $industry->name ?? 'Industry Name' }}</option>
                                @endforeach
                            </select>
                            @error('industry_id') <span class="text-danger">{{ $errors->first('industry_id') }}</span> @enderror
                        </div>
                        <label for="organizationName" class="mt-3">Organization Category</label>
                        <div>
                            <select name="employer_company_category_id" class="w-100 form-control select2" id="" data-placeholder="Select Company Category">
{{--                                <option selected disabled >Hi</option>--}}
                                @foreach($companyCategories as $companyCategory)
                                    <option value="{{ $companyCategory->id }}">{{ $companyCategory->category_name ?? 'Company Category Name' }}</option>
                                @endforeach
                            </select>
                            @error('employer_company_category_id') <span class="text-danger">{{ $errors->first('employer_company_category_id') }}</span> @enderror
                        </div>
                        <label for="organizationName" class="mt-3">Organization name</label>
                        <div>
                            <input type="text" name="organization_name" id="organizationName" placeholder="Type here" class="w-100" style="margin-bottom: 0px!important;" />
                            @error('organization_name') <span class="text-danger">{{ $errors->first('organization_name') }}</span> @enderror
                        </div>
                    @endif
                    @if(isset($_GET['user']) && $_GET['user'] == 'Employer')
                        <div class="">
                            <label for="binNumber" class="mt-3">Bin Number</label>
                            <div>
                                <input type="text" name="bin_number" id="binNumber" placeholder="Enter Bin Number" class="w-100 form-control">
                                @error('bin_number') <span class="text-danger">{{ $errors->first('bin_number') }}</span> @enderror
                            </div>
                        </div>
                        <div class="">
                            <label for="tradeLicenseNumber" class="mt-3">Trade License number</label>
                            <div>
                                <input type="text" name="trade_license_number" id="tradeLicenseNumber" placeholder="Enter Trade License number" class="w-100 form-control">
                                @error('trade_license_number') <span class="text-danger">{{ $errors->first('trade_license_number') }}</span> @enderror
                            </div>
                        </div>
                    @endif

                    @if(isset($_GET['user']) && $_GET['user'] != 'Employer')
                        <label for="organizationName">Gender</label>
                        <div>
                            <select name="gender" class="w-100 form-control select2" id="" data-placeholder="Select Industry">
                                {{--                                <option selected disabled >Hi</option>--}}
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                            @error('industry_id') <span class="text-danger">{{ $errors->first('industry_id') }}</span> @enderror
                        </div>
                    @endif


                    <label for="supPassword">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="supPassword" name="password" placeholder="Type here" class="w-100">
{{--                        <span class="toggle-icon"><img src="{{ asset('/') }}frontend/employee/images/authentication images/eye.png" alt=""></span> <!-- 👁 (eye icon as Unicode for now) -->--}}
                    </div>


{{--                    <div class="signupCheckbox d-flex align-items-center mb-3">--}}
{{--                        <input type="checkbox" class="me-2">--}}
{{--                        <span>I agree to <a href="">Terms & Conditions</a></span>--}}
{{--                    </div>--}}


                    <button type="submit" class="mt-2">Create account</button>
                </div>
            </div>
        </form>
    </div>

    <div class="mt-4">
        <span class="">Already have an account? <a href="login.html" class="fw-bold text-dark text-decoration-none">Log in</a></span>
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
        $('.select2').select2();
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
        $('#signUpEmailDiv2').removeClass('d-none');
    })
    $(document).on('click', '#signUpWithMobileBtn', function () {
        $('#signUpEmailDiv1').addClass('d-none');
        $('#signUpEmailDiv2').removeClass('d-none');
    })
</script>
</body>

</html>
