<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Your Name or Company Name">
    <link rel="icon" href="images/fav.png" type="image/x-icon">
    {!! $siteSetting->meta_header ?? '' !!}
    <title>{!! $siteSetting->meta_title ?? 'Like Wise BD' !!}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Helper CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}common-assets/css/helper.min.css" />
    <link rel="stylesheet" href="{{ asset('/') }}frontend/auth/loginStyle.css">
    <link rel="stylesheet" href="{{ asset('/') }}frontend/home-landing/style.css">
    <style>
        :root {
            --primary: #FFCB11;
            --primary-dark: #e5b500;
            --dark: #111827;
            --dark-700: #374151;
            --dark-500: #6B7280;
            --dark-400: #9CA3AF;
            --dark-300: #D1D5DB;
            --dark-200: #E5E7EB;
            --dark-100: #F3F4F6;
            --white: #FFFFFF;
        }
        .lw-footer {
            background: var(--dark);
            color: var(--dark-400);
            padding: 64px 0 0;
        }
        .footer-logo img { height: 32px; margin-bottom: 16px; }
        .footer-desc {
            color: var(--dark-400);
            font-size: 0.9rem;
            line-height: 1.7;
            max-width: 300px;
            margin-bottom: 20px;
        }
        .footer-heading {
            color: var(--white);
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 20px;
        }
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a {
            color: var(--dark-400);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }
        .footer-links a:hover { color: var(--primary); }
        .footer-social {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
        }
        .footer-social a {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .footer-social a:hover {
            background: var(--primary);
        }
        .footer-social a img {
            width: 18px;
            height: 18px;
            filter: brightness(0) invert(1);
        }
        .footer-social a:hover img {
            filter: brightness(0);
        }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding: 24px 0;
            margin-top: 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }
        .footer-bottom p {
            margin: 0;
            font-size: 0.85rem;
            color: var(--dark-500);
        }
        .lang-select {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            color: var(--dark-400);
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 0.85rem;
            cursor: pointer;
        }
        .lang-select option { background: var(--dark); color: var(--white); }
    </style>
</head>

<body>

<!-- Offcanvas Navbar for Mobile -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
    <div class="offcanvas-header">
{{--        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="{{ asset(isset($siteSetting) ? $siteSetting->logo : 'frontend/likewise.png') }}" alt="" class="img-fluid"></h5>--}}
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img style="max-height: 40px;" src="{{ asset('frontend/likewise.png') }}" alt="" class="img-fluid"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column justify-content-between">
        <ul class="navbar-nav mb-3">
{{--            <li class="nav-item"><a class="nav-link custom-hover" href="#">Community</a></li>--}}
{{--            <li class="nav-item"><a class="nav-link custom-hover" href="#">{{ trans('home.jobs') }}</a></li>--}}
            <li class="nav-item"><a class="nav-link custom-hover" href="{{ route('auth.set-login-role') }}">{{ trans('home.companies') }}</a></li>
{{--            <li class="nav-item"><a class="nav-link custom-hover" href="#">{{ trans('home.salaries') }}</a></li>--}}
            <li class="nav-item"><a class="nav-link custom-hover" href="{{ route('auth.set-login-role') }}">{{ trans('home.for_employers') }}</a></li>
        </ul>

        <!-- Notification Icon & Sign In in offcanvas -->
        <div class="d-flex align-items-center gap-3 mb-3">
            @if(auth()->check())
                <a href="#" onclick="event.preventDefault(); document.getElementsByClassName('logoutForm')[0].submit()" class="btn btn-dark d-flex align-items-center gap-2 px-3 py-2 rounded-3">
{{--                    <img src="{{ asset('/') }}frontend/home-landing/images/signin.png" alt="Login" width="20px">--}}
                    <span>{{ trans('auth.logout') }}</span>
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
            <img src="{{ asset('frontend/likewise.png') }}" style="max-height: 30px" alt="">
        </a>

        <!-- Mobile notification bell and hamburger grouped -->
        <div class="d-flex align-items-center gap-2 d-lg-none">
            <!-- Notification Bell -->
{{--            <a href="#" class="btn btn-link p-0">--}}
{{--                <img src="{{ asset('/') }}frontend/home-landing/images/notificationbell.png" alt="Notifications" width="30px">--}}
{{--            </a>--}}
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
{{--                <li class="nav-item"><a class="nav-link custom-hover fw-semibold" href="{{ route('auth.set-login-role') }}">Companies</a></li>--}}
{{--                <li class="nav-item"><a class="nav-link custom-hover fw-semibold" href="#">Salaries</a></li>--}}
{{--                <li class="nav-item"><a class="nav-link custom-hover fw-semibold" href="{{ route('auth.set-login-role') }}">For Employers</a></li>--}}
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
                    <span>{{ trans('auth.logout') }}</span>
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


{{--page content section--}}
<section class="mt-3 py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <h2 class="text-center" style="margin-top: 100px;">Delete Your Account !!</h2>
            </div>
            <div class="col-md-12 mt-3">
                <p style="text-align: justify">Users can request deletion of their LikeWise account and associated personal data by contacting us at: support@likewisebd.com
                    Please include your registered email address or phone number.</p>
            </div>
        </div>
    </div>
</section>

<!-- Footer Section -->
<footer class="lw-footer">
    <div class="container">
        <div class="row g-4">
            <!-- Brand Column -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-logo">
                    <img src="{{ asset('/frontend/likewise.png') }}" alt="LikewiseBD" style="filter:brightness(0) invert(1)">
                </div>
                <p class="footer-desc">{{ trans('home.about_platform') }}</p>
                <div class="footer-social">
                    <a href="{{ isset($siteSetting) ? $siteSetting->fb : 'javascript:void(0)' }}" aria-label="Facebook">
                        <img src="{{ asset('/') }}frontend/home-landing/images/facebook.png" alt="Facebook">
                    </a>
                    <a href="{{ isset($siteSetting) ? $siteSetting->x_link : 'javascript:void(0)' }}" aria-label="X">
                        <img src="{{ asset('/') }}frontend/home-landing/images/x.png" alt="X">
                    </a>
                    <a href="{{ isset($siteSetting) ? $siteSetting->youtube : 'javascript:void(0)' }}" aria-label="YouTube">
                        <img src="{{ asset('/') }}frontend/home-landing/images/youtube.png" alt="YouTube">
                    </a>
                    <a href="{{ isset($siteSetting) ? $siteSetting->insta : 'javascript:void(0)' }}" aria-label="Instagram">
                        <img src="{{ asset('/') }}frontend/home-landing/images/instagram.png" alt="Instagram">
                    </a>
                    <a href="{{ isset($siteSetting) ? $siteSetting->tiktalk : 'javascript:void(0)' }}" aria-label="TikTok">
                        <img src="{{ asset('/') }}frontend/home-landing/images/tiktok.png" alt="TikTok">
                    </a>
                </div>
            </div>

            <!-- Employers -->
            <div class="col-lg-2 col-md-6 col-6">
                <h6 class="footer-heading">{{ trans('home.employers') }}</h6>
                <ul class="footer-links">
                    @if(!auth()->check())
                        <li><a href="{{ url('auth/user-registration-page?user=Employer') }}">{{ trans('home.get_free_employer_account') }}</a></li>
                        <li><a href="{{ url('auth/user-registration-page?user=Employer') }}">{{ trans('home.employer_center') }}</a></li>
                    @elseif(auth()->user()->user_type == 'employer')
                        <li><a href="{{ route('employer.dashboard', ['is_own' => 'true']) }}">{{ trans('home.dashboard') }}</a></li>
                        <li><a href="{{ route('employer.my-jobs') }}">{{ trans('home.jobs') }}</a></li>
                    @else
                        <li><a href="{{ url('/') }}">{{ trans('home.home') }}</a></li>
                    @endif
                </ul>
            </div>

            <!-- Pages -->
{{--            <div class="col-lg-2 col-md-6 col-6">--}}
{{--                <h6 class="footer-heading">{{ trans('home.pages') }}</h6>--}}
{{--                <ul class="footer-links">--}}
{{--                    @foreach($commonPages as $commonPage)--}}
{{--                        <li><a href="{{ route('show-common-page', ['slug' => $commonPage->slug]) }}">{{ $commonPage->title ?? 'page name' }}</a></li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}

            <!-- Work With Us -->
{{--            <div class="col-lg-2 col-md-6 col-6">--}}
{{--                <h6 class="footer-heading">{{ trans('home.work_with_us') }}</h6>--}}
{{--                <ul class="footer-links">--}}
{{--                    <li><a href="{{ url('auth/user-registration-page?user=Employer') }}">{{ trans('home.advertisers') }}</a></li>--}}
{{--                    <li><a href="{{ url('auth/user-registration-page?user=Employee') }}">{{ trans('home.careers') }}</a></li>--}}
{{--                </ul>--}}
{{--            </div>--}}

            <!-- Download & Connect -->
            <div class="col-lg-2 col-md-6 col-6">
                <h6 class="footer-heading">{{ trans('home.download_the_app') }}</h6>
                <div class="d-flex gap-3 mb-4">
                    <a href="{{ isset($siteSetting) ? $siteSetting->apk_link : 'javascript:void(0)' }}" aria-label="Android">
                        <img src="{{ asset('/') }}frontend/home-landing/images/android.png" alt="Android" style="width:32px;filter:brightness(0) invert(1);opacity:0.7">
                    </a>
                    <a href="{{ isset($siteSetting) ? $siteSetting->ios_link : 'javascript:void(0)' }}" aria-label="iOS">
                        <img src="{{ asset('/') }}frontend/home-landing/images/appleIcon.png" alt="Apple" style="width:32px;filter:brightness(0) invert(1);opacity:0.7">
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>{{ trans('home.copyright_text') }}</p>
            <select class="lang-select" aria-label="Select language" id="changeLocalLangOption">
                <option value="en" {{ session('locale') == 'en' ? 'selected' : '' }} data-url="{{ route('change-local-language', ['local' => 'English']) }}">{{ trans('home.english') }}</option>
                <option value="bn" {{ session('locale') == 'bn' ? 'selected' : '' }} data-url="{{ route('change-local-language', ['local' => 'Bangla']) }}">{{ trans('home.bangla') }}</option>
            </select>
        </div>
    </div>
</footer>


<!-- Modal -->
<div class="modal fade " id="googleUserTypeSelect">
    <div class="modal-dialog">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body ">
                <div class="">
                    <div class="card shadow signupCard">
                        <a href="{{ route('/') }}"><img src="{{ asset('frontend/likewise.png') }}" alt="" class="signupLogo w-25"></a>


                        <div class="userCard">
                            <div>
                                <a href="{{ route('auth.socialite.redirect', ['provider' => 'google', 'user' => 'Employer']) }}" class="userSelectOption mb-3">
                                    <div class="row d-flex align-items-center w-100">
                                        <div class="col-2  iconWrapper">
                                            <img src="{{ asset('frontend/employee/images/authentication images/employeeIcon.png') }}" alt="" class="userSelectOptionIcon">
                                        </div>
                                        <div class="col-9">
                                            <h5>{{ trans('auth.employer') }}</h5>
                                            <p>{{ trans('auth.employer_description') }}</p>
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
                                            <h5>{{ trans('auth.job_seeker') }}</h5>
                                            <p>{{ trans('auth.job_seeker_description') }}</p>
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
{!! $siteSetting->meta_footer ?? '' !!}
<script src="https://js.pusher.com/7.2.0/pusher.min.js"></script>
@include('frontend.zegocloud.incoming-call-popup')
</body>
</html>
