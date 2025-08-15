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
            <li class="nav-item"><a class="nav-link custom-hover" href="#">Jobs</a></li>
            <li class="nav-item"><a class="nav-link custom-hover" href="#">Companies</a></li>
            <li class="nav-item"><a class="nav-link custom-hover" href="#">Salaries</a></li>
            <li class="nav-item"><a class="nav-link custom-hover" href="#">For Employers</a></li>
        </ul>

        <!-- Notification Icon & Sign In in offcanvas -->
        <div class="d-flex align-items-center gap-3 mb-3">
            @if(auth()->check())
                <a href="#" onclick="event.preventDefault(); document.getElementsByClassName('logoutForm')[0].submit()" class="btn btn-dark d-flex align-items-center gap-2 px-3 py-2 rounded-3">
{{--                    <img src="{{ asset('/') }}frontend/home-landing/images/signin.png" alt="Login" width="20px">--}}
                    <span>Logout</span>
                </a>
                <form action="{{ route('logout') }}" method="post" class="logoutForm">
                    @csrf
                </form>
            @else
                <a href="{{ route('auth.select-auth-method') }}" class="btn btn-dark d-flex align-items-center gap-2 px-3 py-2 rounded-3">
                    <img src="{{ asset('/') }}frontend/home-landing/images/signin.png" alt="Login" width="20px">
                    <span>Sign In</span>
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
            <button class="btn btn-link p-0">
                <img src="{{ asset('/') }}frontend/home-landing/images/notificationbell.png" alt="Notifications" width="30px">
            </button>
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
            <button class="btn btn-link p-0">
                <img src="{{ asset('/') }}frontend/home-landing/images/notificationbell.png" alt="Notifications" width="30px">
            </button>
            @if(auth()->check())
                <a href="#" onclick="event.preventDefault(); document.getElementsByClassName('logoutForm')[0].submit()" class="btn btn-dark d-flex align-items-center gap-2 px-3 py-2 rounded-3">
                    {{--                    <img src="{{ asset('/') }}frontend/home-landing/images/signin.png" alt="Login" width="20px">--}}
                    <span>Logout</span>
                </a>
                <form action="{{ route('logout') }}" method="post" class="logoutForm">
                    @csrf
                </form>
            @else
                <a href="{{ route('auth.select-auth-method') }}" class="btn btn-dark d-flex align-items-center gap-2 px-3 py-2 rounded-3">
                    <img src="{{ asset('/') }}frontend/home-landing/images/signin.png" alt="Login" width="20px">
                    <span>Sign In</span>
                </a>
            @endif
        </div>
    </div>
</nav>


{{--page content section--}}
<section class="mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <h2>{{ $page->title ?? 'Page Title Here' }}</h2>
            </div>
            <div class="col-md-12 mt-3">
                <p style="text-align: justify">{!! $page->content ?? 'Page content here' !!}</p>
            </div>
        </div>
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
                <p class="" style="text-align: justify">Grapho is job hub.. More content here..</p>
            </div>
            <div class="col-md-2 mb-3">
                <h6 class="fw-semibold">Employers</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ url('auth/user-registration-page?user=Employer') }}" class="text-decoration-none text-dark">Get a Free Employer Account</a></li>
                    <li><a href="{{ url('auth/user-registration-page?user=Employer') }}" class="text-decoration-none text-dark">Employer Center</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-3">
                <h6 class="fw-semibold">Pages</h6>
                <ul class="list-unstyled small">
                    @foreach($commonPages as $commonPage)
                        <li><a href="#" class="text-decoration-none text-dark">{{ $commonPage->title ?? 'page name' }}</a></li>
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
                <h6 class="fw-semibold">Work With Us</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ url('auth/user-registration-page?user=Employer') }}" class="text-decoration-none text-dark">Advertisers</a></li>
                    <li><a href="{{ url('auth/user-registration-page?user=Employee') }}" class="text-decoration-none text-dark">Careers</a></li>
                </ul>
            </div>

            <div class="col-md-3 mb-3 d-flex flex-column align-items-start justify-content-between">
                <div class="mb-2">
                    <span class="small">Download the App</span>
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

                <select class="form-select form-select-sm w-auto" aria-label="Select country">
                    <option value="en">English</option>
                    <option value="bn">Bangla</option>
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
            Copyright &copy; 2008-2025. Grapho LLC.
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
                        <a href="{{ route('/') }}"><img src="{{ asset('frontend/employee/images/authentication images/Compnay logo.png') }}" alt="" class="signupLogo w-25"></a>


                        <div class="userCard">
                            <div>
                                <a href="{{ route('auth.socialite.redirect', ['provider' => 'google', 'user' => 'Employer']) }}" class="userSelectOption mb-3">
                                    <div class="row d-flex align-items-center w-100">
                                        <div class="col-2  iconWrapper">
                                            <img src="{{ asset('frontend/employee/images/authentication images/employeeIcon.png') }}" alt="" class="userSelectOptionIcon">
                                        </div>
                                        <div class="col-9">
                                            <h5>Employer</h5>
                                            <p>Looking to scale your team.</p>
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
                                            <h5>Job-seeker</h5>
                                            <p>Looking for job opportunities.</p>
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
</body>
</html>
