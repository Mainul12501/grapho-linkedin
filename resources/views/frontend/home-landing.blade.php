<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Like Wise BD">
    <meta name="title" content="Like Wise BD">
    <link rel="icon" href="images/fav.png" type="image/x-icon">
    {!! $siteSetting->meta_header ?? '' !!}
    <title>{!! $siteSetting->meta_title ?? 'Like Wise BD' !!}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Helper CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}common-assets/css/helper.min.css" />
    <link rel="stylesheet" href="{{ asset('/') }}frontend/auth/loginStyle.css">
    <link rel="stylesheet" href="{{ asset('/') }}frontend/home-landing/style.css">
    <link rel="stylesheet" href="{{ asset('/') }}common-assets/css/toastr-2.1.3.min.css" />

    <!-- Geist Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <style>
        @media only screen and (max-width: 600px) {
            .signupCard {
                width: 100% !important;
            }
            .userSelectOption {
                padding: 10px !important;
            }
            .userSelectOptionIcon {
                width: 30px !important;
            }

        }
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
    </style>
</head>

<body>

<!-- Offcanvas Navbar for Mobile -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="{{ asset('/') }}frontend/home-landing/images/Compnay logo.png" alt="" class="img-fluid"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column justify-content-between">
        <ul class="navbar-nav mb-3">
{{--            <li class="nav-item"><a class="nav-link custom-hover" href="#">Community</a></li>--}}
{{--            <li class="nav-item"><a class="nav-link custom-hover" href="#">Jobs</a></li>--}}
            <li class="nav-item"><a class="nav-link custom-hover" href="{{ route('auth.set-login-role') }}">{{ trans('home.companies') }}</a></li>
{{--            <li class="nav-item"><a class="nav-link custom-hover" href="#">Salaries</a></li>--}}
            <li class="nav-item"><a class="nav-link custom-hover" href="{{ route('auth.set-login-role') }}">{{ trans('home.for_employers') }}</a></li>
        </ul>

        <!-- Notification Icon & Sign In in offcanvas -->
        <div class="d-flex align-items-center gap-3 mb-3">
            @if(auth()->check())
                <a href="{{ auth()->user()->user_type == 'employee' ? route('employee.home') : (auth()->user()->user_type == 'employer' ? route('employer.home') : route('dashboard')) }}" class="btn btn-primary d-flex align-items-center gap-2 px-3 py-2 rounded-3">
{{--                    <img src="{{ asset('/') }}frontend/home-landing/images/signin.png" alt="Login" width="20px">--}}
                    <span>{{ trans('home.dashboard') }}</span>
                </a>
                <a href="#" onclick="event.preventDefault(); document.getElementsByClassName('logoutForm')[0].submit()" class="btn btn-dark d-flex align-items-center gap-2 px-3 py-2 rounded-3">
{{--                    <img src="{{ asset('/') }}frontend/home-landing/images/signin.png" alt="Login" width="20px">--}}
                    <span>{{ trans('home.logout') }}</span>
                </a>
                <form action="{{ route('logout') }}" method="post" class="logoutForm">
                    @csrf
                </form>
            @else
                <a href="{{ route('auth.select-auth-method') }}" class="btn btn-dark d-flex align-items-center gap-2 px-3 py-2 rounded-3">
                    <img src="{{ asset('/') }}frontend/home-landing/images/signin.png" alt="Login" width="20px">
                    <span>{{ trans('auth.sign_in') }}</span>
                </a>
            @endif

        </div>

        <!-- Bottom Image in offcanvas -->
        <div class="text-center">
            <img src="{{ asset('/') }}frontend/home-landing/images/4.png" alt="Decorative" class="img-fluid">
        </div>
    </div>
</div>

<!-- Navbar for Larger Screens -->
<nav class="navbar navbar-expand-lg bg-white fixed-top shadow-sm py-2">
    <div class="container d-flex justify-content-between align-items-center">

        <!-- Brand / Logo -->
        <a class="navbar-brand" href="{{ route('/') }}">
            <img src="{{ asset('/') }}frontend/home-landing/images/Compnay logo.png" alt="">
        </a>

        <!-- Mobile notification bell and hamburger grouped -->
        <div class="d-flex align-items-center gap-2 d-lg-none">
            <!-- Notification Bell -->
{{--            <button class="btn btn-link p-0">--}}
{{--                <img src="{{ asset('/') }}frontend/home-landing/images/notificationbell.png" alt="Notifications" width="30px">--}}
{{--            </button>--}}
            <!-- Hamburger -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <!-- Main Links -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
{{--            <ul class="navbar-nav gap-3">--}}
{{--                <li class="nav-item"><a class="nav-link custom-hover fw-semibold" href="#">Community</a></li>--}}
{{--                <li class="nav-item"><a class="nav-link custom-hover fw-semibold" href="#">Jobs</a></li>--}}
{{--                <li class="nav-item"><a class="nav-link custom-hover fw-semibold" href="#">Companies</a></li>--}}
{{--                <li class="nav-item"><a class="nav-link custom-hover fw-semibold" href="#">Salaries</a></li>--}}
{{--                <li class="nav-item"><a class="nav-link custom-hover fw-semibold" href="#">For Employers</a></li>--}}
{{--            </ul>--}}
        </div>

        <!-- Notification Icon & Sign In (hidden on mobile) -->
        <div class="d-flex align-items-center gap-3 d-none d-lg-flex">
{{--            <button class="btn btn-link p-0">--}}
{{--                <img src="{{ asset('/') }}frontend/home-landing/images/notificationbell.png" alt="Notifications" width="30px">--}}
{{--            </button>--}}
            @if(auth()->check())
                <a href="{{ auth()->user()->user_type == 'employee' ? route('employee.home') : (auth()->user()->user_type == 'employer' ? route('employer.home') : route('dashboard')) }}" class="btn btn-primary d-flex align-items-center gap-2 px-3 py-2 rounded-3">
                    {{--                    <img src="{{ asset('/') }}frontend/home-landing/images/signin.png" alt="Login" width="20px">--}}
                    <span>{{ trans('home.dashboard') }}</span>
                </a>
                <a href="#" onclick="event.preventDefault(); document.getElementsByClassName('logoutForm')[0].submit()" class="btn btn-dark d-flex align-items-center gap-2 px-3 py-2 rounded-3">
                    {{--                    <img src="{{ asset('/') }}frontend/home-landing/images/signin.png" alt="Login" width="20px">--}}
                    <span>{{ trans('home.logout') }}</span>
                </a>
                <form action="{{ route('logout') }}" method="post" class="logoutForm">
                    @csrf
                </form>
            @else
                <a href="{{ route('auth.select-auth-method') }}" class="btn btn-dark d-flex align-items-center gap-2 px-3 py-2 rounded-3">
                    <img src="{{ asset('/') }}frontend/home-landing/images/signin.png" alt="Login" width="20px">
                    <span>{{ trans('auth.sign_in') }}</span>
                </a>
            @endif
        </div>
    </div>
</nav>






<!-- Hero Section (Main Content) -->
<section class="my-5 py-5 border-bottom" style="background-color: #FFCB11">
    <div class="container">
        <!-- Mobile Illustration (Shown only on mobile) -->
        <div class="d-lg-none text-center mb-4">
            <img src="{{ asset('/') }}frontend/home-landing/images/5.png" alt="Mobile Illustration" class="img-fluid">
        </div>
        <h1 class="d-none d-lg-block text-center">{{ trans('home.your_work_people_are_here') }}</h1>

        <div class="row justify-content-center align-items-center">
            <!-- Left Illustration (Hidden on mobile) -->
            <div class="col-lg-4 d-none d-lg-block">
                <img src="{{ asset('/') }}frontend/home-landing/images/2.png" alt="Illustration Left" class="img-fluid">
            </div>

            <!-- Main Content Container -->
            <div class="col-12 col-lg-4 text-center">
                <!-- Header -->
                <div class="mb-4">
                    <h1 class="d-lg-none">{{ trans('home.your_work_people_are_here') }}</h1>
                    <p>{{ trans('home.by_continuing_agree_terms') }}</p>
                </div>

                <!-- Login Buttons -->
                @if(auth()->check())
                    <div class="d-flex flex-column mb-4">

                        <a href="{{ auth()->user()->user_type == 'employee' ? route('employee.home') : (auth()->user()->user_type == 'employer' ? route('employer.home') : route('dashboard')) }}" class="btn btn-outline-dark mb-2">{{ trans('home.visit_dashboard') }}</a>
                    </div>
                @else
                    <div class="d-flex flex-column mb-4">
                        <button class="btn btn-outline-dark mb-2" type="button" data-bs-toggle="modal" data-bs-target="#googleUserTypeSelect">
                            <img src="{{ asset('/') }}frontend/home-landing/images/gooleIcon.png" alt="Google Icon" style="width: 30px;"> {{ trans('home.continue_with_google') }}
                        </button>
                        {{--                    <button class="btn btn-outline-dark mb-2">--}}
                        {{--                        <img src="{{ asset('/') }}frontend/home-landing/images/appleIcon.png" alt="Apple Icon" style="width: 30px;"> Continue with Apple--}}
                        {{--                    </button>--}}

                        <!-- Divider with "or" -->
                        <div class="d-flex align-items-center my-3">
                            <hr class="flex-grow-1">
                            <span class="px-2 text-muted">{{ trans('home.or') }}</span>
                            <hr class="flex-grow-1">
                        </div>

                        <!-- Email Input Label + Field -->
                        <div class="mb-3 text-start">
                            {{--                        <label for="email" class="form-label fw-semibold">Enter email</label>--}}
                            {{--                        <input type="email" id="email" class="form-control rounded-3" placeholder="" required>--}}
                        </div>


                        <a href="{{ route('auth.select-auth-method') }}" class="btn btn-outline-dark mb-2">{{ trans('home.continue_with_email') }}</a>
                    </div>
                @endif


            </div>

            <!-- Right Illustration (Hidden on mobile) -->
            <div class="col-lg-4 d-none d-lg-block">
                <img src="{{ asset('/') }}frontend/home-landing/images/3.png" alt="Illustration Right" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Get Ahead with Glassdoor Section -->
<section class="container text-center py-5">
    <h2 class="fw-semibold mb-2">{{ trans('home.get_ahead_with_likewisebd') }}</h2>
    <p class="text-muted mb-4">{{ trans('home.serving_trusted_insights') }}</p>

    <div class="row justify-content-center g-4">
        <div class="col-6 col-md-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle border d-flex justify-content-center align-items-center" style="width: 72px; height: 72px;">
                    <img src="{{ asset('/') }}frontend/home-landing/images/jobcummunity.png" alt="Community" style="width: 40px;">
                </div>
                <span class="mt-2">{{ trans('home.join_work_community') }}</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle border d-flex justify-content-center align-items-center" style="width: 72px; height: 72px;">
                    <img src="{{ asset('/') }}frontend/home-landing/images/jobsearch.png" alt="Search Jobs" style="width: 40px;">
                </div>
                <span class="mt-2">{{ trans('home.find_and_apply_to_jobs') }}</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle border d-flex justify-content-center align-items-center" style="width: 72px; height: 72px;">
                    <img src="{{ asset('/') }}frontend/home-landing/images/searchcompany.png" alt="Company Reviews" style="width: 40px;">
                </div>
                <span class="mt-2">{{ trans('home.search_company_reviews') }}</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle border d-flex justify-content-center align-items-center" style="width: 72px; height: 72px;">
                    <img src="{{ asset('/') }}frontend/home-landing/images/salary.png" alt="Salaries" style="width: 40px;">
                </div>
                <span class="mt-2">{{ trans('home.compare_salaries') }}</span>
            </div>
        </div>
    </div>
</section>


<!-- Start Your Search Section -->
<section class="text-center py-5 bg-light">
    <div class="container">
        <h3>{{ trans('home.start_your_search') }}</h3>
        <p>{{ trans('home.need_inspiration') }}</p>
        <input type="text" class="form-control mx-auto" placeholder="{{ trans('home.search_for_jobs_companies_salaries') }}" style="max-width: 600px;">
    </div>
</section>

<!-- Footer Section -->
<footer class="pt-5 pb-3 bg-white">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-2 mb-3">
                <a href="{{ route('/') }}" class="d-inline-block mb-3"><img src="{{ asset('/') }}frontend/home-landing/images/Compnay logo.png" alt=""></a>
{{--                <ul class="list-unstyled small">--}}
{{--                    <li><a href="#" class="text-decoration-none text-dark">About / Press</a></li>--}}
{{--                    <li><a href="#" class="text-decoration-none text-dark">Awards</a></li>--}}
{{--                    <li><a href="#" class="text-decoration-none text-dark">Blog</a></li>--}}
{{--                    <li><a href="#" class="text-decoration-none text-dark">Research</a></li>--}}
{{--                    <li><a href="#" class="text-decoration-none text-dark">Contact Us</a></li>--}}
{{--                    <li><a href="#" class="text-decoration-none text-dark">Guides</a></li>--}}
{{--                </ul>--}}
                <p class="" style="text-align: justify">{{ trans('home.grapho_description') }}</p>
            </div>
            <div class="col-md-2 mb-3">
                <h6 class="fw-semibold">{{ trans('home.employers') }}</h6>
                <ul class="list-unstyled small">
                    @if(!auth()->check())
                        <li><a href="{{ url('auth/user-registration-page?user=Employer') }}" class="text-decoration-none text-dark">{{ trans('home.get_free_employer_account') }}</a></li>
                        <li><a href="{{ url('auth/user-registration-page?user=Employer') }}" class="text-decoration-none text-dark">{{ trans('home.employer_center') }}</a></li>
                    @elseif(auth()->user()->user_type == 'employer')
                        <li><a href="{{ route('employer.dashboard') }}" class="text-decoration-none text-dark">{{ trans('home.dashboard') }}</a></li>
                        <li><a href="{{ route('employer.my-jobs') }}" class="text-decoration-none text-dark">{{ trans('home.jobs') }}</a></li>
                    @else
                        <li><a href="{{ url('/') }}" class="text-decoration-none text-dark">{{ trans('home.home') }}</a></li>
                    @endif
                </ul>
            </div>
            <div class="col-md-3 mb-3">
                <h6 class="fw-semibold">{{ trans('home.pages') }}</h6>
                <ul class="list-unstyled small">
                    @foreach($commonPages as $commonPage)
                        <li><a href="{{ route('show-common-page', ['slug' => $commonPage->slug]) }}" class="text-decoration-none text-dark">{{ $commonPage->title ?? 'page name' }}</a></li>
                    @endforeach
{{--                    <li><a href="#" class="text-decoration-none text-dark">Guidelines</a></li>--}}
{{--                    <li><a href="#" class="text-decoration-none text-dark">Terms of Use</a></li>--}}
{{--                    <li><a href="#" class="text-decoration-none text-dark">Privacy & Ad Choices</a></li>--}}
{{--                    <li><a href="#" class="text-decoration-none text-dark">Do Not Sell Or Share</a></li>--}}
{{--                    <li><a href="#" class="text-decoration-none text-dark">My Information</a></li>--}}
{{--                    <li><a href="#" class="text-decoration-none text-dark">Cookie Consent Tool</a></li>--}}
{{--                    <li><a href="#" class="text-decoration-none text-dark">Security</a></li>--}}
                </ul>
            </div>
            <div class="col-md-2 mb-3">
                <h6 class="fw-semibold">{{ trans('home.work_with_us') }}</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ url('auth/user-registration-page?user=Employer') }}" class="text-decoration-none text-dark">{{ trans('home.advertisers') }}</a></li>
                    <li><a href="{{ url('auth/user-registration-page?user=Employee') }}" class="text-decoration-none text-dark">{{ trans('home.careers') }}</a></li>
                </ul>
            </div>

            <div class="col-md-3 mb-3 d-flex flex-column align-items-start justify-content-between">
                <div class="mb-2">
                    <span class="small">{{ trans('home.download_the_app') }}</span>
                    <div class="d-inline-flex gap-2 ms-2">
                        <a href="{{ isset($siteSetting) ? $siteSetting->apk_link : 'javascript:void(0)' }}" aria-label="Download on Android">
                            <img src="{{ asset('/') }}frontend/home-landing/images/android.png" alt="Android" style="width: 30px;">
                        </a>
                        <a href="{{ isset($siteSetting) ? $siteSetting->ios_link : 'javascript:void(0)' }}" aria-label="Download on iOS">
                            <img src="{{ asset('/') }}frontend/home-landing/images/appleIcon.png" alt="Apple" style="width: 30px;">
                        </a>
                    </div>
                </div>
                <div class="d-flex gap-3 mb-2">
{{--                    <a href="{{ isset($siteSetting) ? $siteSetting->fb : 'javascript:void(0)' }}" aria-label="Glassdoor Community" class="btn btn-outline-secondary btn-sm rounded-circle p-2">--}}
{{--                        <img src="{{ asset('/') }}frontend/home-landing/images/quote.png" alt="Quote Icon" style="width: 30px;">--}}
{{--                    </a>--}}
                    <a href="{{ isset($siteSetting) ? $siteSetting->fb : 'javascript:void(0)' }}" aria-label="Facebook" class="btn btn-outline-secondary btn-sm rounded-circle p-2">
                        <img src="{{ asset('/') }}frontend/home-landing/images/facebook.png" alt="Facebook" style="width: 30px;">
                    </a>
                    <a href="{{ isset($siteSetting) ? $siteSetting->x_link : 'javascript:void(0)' }}" aria-label="X" class="btn btn-outline-secondary btn-sm rounded-circle p-2">
                        <img src="{{ asset('/') }}frontend/home-landing/images/x.png" alt="X" style="width: 30px;">
                    </a>
                    <a href="{{ isset($siteSetting) ? $siteSetting->youtube : 'javascript:void(0)' }}" aria-label="YouTube" class="btn btn-outline-secondary btn-sm rounded-circle p-2">
                        <img src="{{ asset('/') }}frontend/home-landing/images/youtube.png" alt="YouTube" style="width: 30px;">
                    </a>
                    <a href="{{ isset($siteSetting) ? $siteSetting->insta : 'javascript:void(0)' }}" aria-label="Instagram" class="btn btn-outline-secondary btn-sm rounded-circle p-2">
                        <img src="{{ asset('/') }}frontend/home-landing/images/instagram.png" alt="Instagram" style="width: 30px;">
                    </a>
                    <a href="{{ isset($siteSetting) ? $siteSetting->tiktalk : 'javascript:void(0)' }}" aria-label="TikTok" class="btn btn-outline-secondary btn-sm rounded-circle p-2">
                        <img src="{{ asset('/') }}frontend/home-landing/images/tiktok.png" alt="TikTok" style="width: 30px;">
                    </a>
                </div>

                <select class="form-select form-select-sm w-auto" aria-label="Select country" id="changeLocalLangOption">
                    <option value="en" {{ session('locale') == 'en' ? 'selected' : '' }} data-url="{{ route('change-local-language', ['local' => 'English']) }}">{{ trans('home.english') }}</option>
                    <option value="bn" {{ session('locale') == 'bn' ? 'selected' : '' }} data-url="{{ route('change-local-language', ['local' => 'Bangla']) }}">{{ trans('home.bangla') }}</option>
                </select>
            </div>
        </div>

        <hr>

{{--        <div class="text-center small text-muted">--}}
{{--            Browse by:--}}
{{--            <a href="#" class="text-decoration-none">Companies</a>,--}}
{{--            <a href="#" class="text-decoration-none">Jobs</a>,--}}
{{--            <a href="#" class="text-decoration-none">Locations</a>,--}}
{{--            <a href="#" class="text-decoration-none">Communities</a>,--}}
{{--            <a href="#" class="text-decoration-none">Recent Posts</a>--}}
{{--        </div>--}}

        <div class="text-center mt-2 small text-muted">
            {{ trans('home.copyright_text') }}
        </div>
    </div>
</footer>


<!-- Modal -->
<div class="modal fade " id="googleUserTypeSelect">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body ">
                <div class="">
                    <div class="card shadow signupCard">
                        <div class="card-header bg-transparent position-relative">
                            <a href="{{ route('/') }}"><img src="{{ asset('frontend/employee/images/authentication images/Compnay logo.png') }}" alt="" class="signupLogo w-25"></a>
                            <button type="button" class="btn position-absolute btn-close" style="right: 5px" data-bs-dismiss="modal"></button>
                        </div>


                        <div class="userCard">
                            <div>
                                <a href="{{ route('auth.socialite.redirect', ['provider' => 'google', 'user' => 'Employer']) }}" class="userSelectOption mb-3">
                                    <div class="row d-flex align-items-center w-100">
                                        <div class="col-2  iconWrapper">
                                            <img src="{{ asset('frontend/employee/images/authentication images/employeeIcon.png') }}" alt="" class="userSelectOptionIcon">
                                        </div>
                                        <div class="col-9">
                                            <h5>{{ trans('home.employer_text') }}</h5>
                                            <p>{{ trans('home.employer_desc') }}</p>
                                        </div>
                                        <div class="col-1">
                                            <img src="{{ asset('frontend/employee/images/authentication images/arrow-right 1.png') }}" alt="" class="arrowIcon">
                                        </div>
                                    </div>
                                </a>

                                <a href="{{ route('auth.socialite.redirect', ['provider' => 'google', 'user' => 'Employee']) }}" class="userSelectOption">
                                    <div class="row d-flex align-items-center w-100">
                                        <div class="col-2  iconWrapper">
                                            <img src="{{ asset('frontend/employee/images/authentication images/jobSeekerIcon.png') }}" alt="" class="userSelectOptionIcon">
                                        </div>
                                        <div class="col-9">
                                            <h5>{{ trans('home.job_seeker') }}</h5>
                                            <p>{{ trans('home.job_seeker_desc') }}</p>
                                        </div>
                                        <div class="col-1">
                                            <img src="{{ asset('frontend/employee/images/authentication images/arrow-right 1.png') }}" alt="" class="arrowIcon">
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- Bootstrap JS and Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('/') }}common-assets/js/toastr-2.1.3.min.js"></script>
{!! Toastr::message() !!}
<script>
    @if($errors->any())
    @foreach($errors->all() as $error)
    toastr.error('{{ $error }}', 'Error', {
        closeButton: true,
        progressBar: true,
    });
    @endforeach
    @endif
    @if(session()->has('error'))
        toastr.error("{{ session('error') }}");
    @endif
    toastr.error('fuck');
</script>
</body>
</html>
