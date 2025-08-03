<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Your Name or Company Name">
    <link rel="icon" href="images/fav.png" type="image/x-icon">
    <title>Grapho</title>
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






<!-- Hero Section (Main Content) -->
<section class="my-5 py-5 border-bottom">
    <div class="container">
        <!-- Mobile Illustration (Shown only on mobile) -->
        <div class="d-lg-none text-center mb-4">
            <img src="{{ asset('/') }}frontend/home-landing/images/5.png" alt="Mobile Illustration" class="img-fluid">
        </div>
        <h1 class="d-none d-lg-block text-center">Your work people are here</h1>

        <div class="row justify-content-center align-items-center">
            <!-- Left Illustration (Hidden on mobile) -->
            <div class="col-lg-4 d-none d-lg-block">
                <img src="{{ asset('/') }}frontend/home-landing/images/2.png" alt="Illustration Left" class="img-fluid">
            </div>

            <!-- Main Content Container -->
            <div class="col-12 col-lg-4 text-center">
                <!-- Header -->
                <div class="mb-4">
                    <h1 class="d-lg-none">Your work people are here</h1>
                    <p>By continuing, you agree to our <a href="" class="text-dark">Terms of Use and Privacy Policy.</a></p>
                </div>

                <!-- Login Buttons -->
                <div class="d-flex flex-column mb-4">
                    <button class="btn btn-outline-dark mb-2" type="button" data-bs-toggle="modal" data-bs-target="#googleUserTypeSelect">
                        <img src="{{ asset('/') }}frontend/home-landing/images/gooleIcon.png" alt="Google Icon" style="width: 30px;"> Continue with Google
                    </button>
{{--                    <button class="btn btn-outline-dark mb-2">--}}
{{--                        <img src="{{ asset('/') }}frontend/home-landing/images/appleIcon.png" alt="Apple Icon" style="width: 30px;"> Continue with Apple--}}
{{--                    </button>--}}

                    <!-- Divider with "or" -->
                    <div class="d-flex align-items-center my-3">
                        <hr class="flex-grow-1">
                        <span class="px-2 text-muted">or</span>
                        <hr class="flex-grow-1">
                    </div>

                    <!-- Email Input Label + Field -->
                    <div class="mb-3 text-start">
{{--                        <label for="email" class="form-label fw-semibold">Enter email</label>--}}
{{--                        <input type="email" id="email" class="form-control rounded-3" placeholder="" required>--}}
                    </div>


                    <a href="{{ route('auth.select-auth-method') }}" class="btn btn-outline-dark mb-2">Continue with Email</a>
                </div>
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
    <h2 class="fw-semibold mb-2">Get ahead with Glassdoor</h2>
    <p class="text-muted mb-4">We're serving up trusted insights and anonymous conversation, so you'll have the goods you need to succeed.</p>

    <div class="row justify-content-center g-4">
        <div class="col-6 col-md-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle border d-flex justify-content-center align-items-center" style="width: 72px; height: 72px;">
                    <img src="{{ asset('/') }}frontend/home-landing/images/jobcummunity.png" alt="Community" style="width: 40px;">
                </div>
                <span class="mt-2">Join your work community</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle border d-flex justify-content-center align-items-center" style="width: 72px; height: 72px;">
                    <img src="{{ asset('/') }}frontend/home-landing/images/jobsearch.png" alt="Search Jobs" style="width: 40px;">
                </div>
                <span class="mt-2">Find and apply to jobs</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle border d-flex justify-content-center align-items-center" style="width: 72px; height: 72px;">
                    <img src="{{ asset('/') }}frontend/home-landing/images/searchcompany.png" alt="Company Reviews" style="width: 40px;">
                </div>
                <span class="mt-2">Search company reviews</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle border d-flex justify-content-center align-items-center" style="width: 72px; height: 72px;">
                    <img src="{{ asset('/') }}frontend/home-landing/images/salary.png" alt="Salaries" style="width: 40px;">
                </div>
                <span class="mt-2">Compare salaries</span>
            </div>
        </div>
    </div>
</section>


<!-- Start Your Search Section -->
<section class="text-center py-5 bg-light">
    <div class="container">
        <h3>Start your search</h3>
        <p>Need some inspiration? See what millions of people are looking for on Glassdoor today.</p>
        <input type="text" class="form-control mx-auto" placeholder="Search for jobs, companies, or salaries" style="max-width: 600px;">
    </div>
</section>

<!-- Footer Section -->
<footer class="pt-5 pb-3 bg-white">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-2 mb-3">
                <a href="{{ route('/') }}" class="d-inline-block mb-3"><img src="{{ asset('/') }}frontend/home-landing/images/Compnay logo.png" alt=""></a>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-decoration-none text-dark">About / Press</a></li>
                    <li><a href="#" class="text-decoration-none text-dark">Awards</a></li>
                    <li><a href="#" class="text-decoration-none text-dark">Blog</a></li>
                    <li><a href="#" class="text-decoration-none text-dark">Research</a></li>
                    <li><a href="#" class="text-decoration-none text-dark">Contact Us</a></li>
                    <li><a href="#" class="text-decoration-none text-dark">Guides</a></li>
                </ul>
            </div>
            <div class="col-md-2 mb-3">
                <h6 class="fw-semibold">Employers</h6>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-decoration-none text-dark">Get a Free Employer Account</a></li>
                    <li><a href="#" class="text-decoration-none text-dark">Employer Center</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-3">
                <h6 class="fw-semibold">Information</h6>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-decoration-none text-dark">Help</a></li>
                    <li><a href="#" class="text-decoration-none text-dark">Guidelines</a></li>
                    <li><a href="#" class="text-decoration-none text-dark">Terms of Use</a></li>
                    <li><a href="#" class="text-decoration-none text-dark">Privacy & Ad Choices</a></li>
                    <li><a href="#" class="text-decoration-none text-dark">Do Not Sell Or Share</a></li>
                    <li><a href="#" class="text-decoration-none text-dark">My Information</a></li>
                    <li><a href="#" class="text-decoration-none text-dark">Cookie Consent Tool</a></li>
                    <li><a href="#" class="text-decoration-none text-dark">Security</a></li>
                </ul>
            </div>
            <div class="col-md-2 mb-3">
                <h6 class="fw-semibold">Work With Us</h6>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-decoration-none text-dark">Advertisers</a></li>
                    <li><a href="#" class="text-decoration-none text-dark">Careers</a></li>
                </ul>
            </div>

            <div class="col-md-3 mb-3 d-flex flex-column align-items-start justify-content-between">
                <div class="mb-2">
                    <span class="small">Download the App</span>
                    <div class="d-inline-flex gap-2 ms-2">
                        <a href="#" aria-label="Download on Android">
                            <img src="{{ asset('/') }}frontend/home-landing/images/android.png" alt="Android" style="width: 30px;">
                        </a>
                        <a href="#" aria-label="Download on iOS">
                            <img src="{{ asset('/') }}frontend/home-landing/images/appleIcon.png" alt="Apple" style="width: 30px;">
                        </a>
                    </div>
                </div>
                <div class="d-flex gap-3 mb-2">
                    <a href="#" aria-label="Glassdoor Community" class="btn btn-outline-secondary btn-sm rounded-circle p-2">
                        <img src="{{ asset('/') }}frontend/home-landing/images/quote.png" alt="Quote Icon" style="width: 30px;">
                    </a>
                    <a href="#" aria-label="Facebook" class="btn btn-outline-secondary btn-sm rounded-circle p-2">
                        <img src="{{ asset('/') }}frontend/home-landing/images/facebook.png" alt="Facebook" style="width: 30px;">
                    </a>
                    <a href="#" aria-label="X" class="btn btn-outline-secondary btn-sm rounded-circle p-2">
                        <img src="{{ asset('/') }}frontend/home-landing/images/x.png" alt="X" style="width: 30px;">
                    </a>
                    <a href="#" aria-label="YouTube" class="btn btn-outline-secondary btn-sm rounded-circle p-2">
                        <img src="{{ asset('/') }}frontend/home-landing/images/youtube.png" alt="YouTube" style="width: 30px;">
                    </a>
                    <a href="#" aria-label="Instagram" class="btn btn-outline-secondary btn-sm rounded-circle p-2">
                        <img src="{{ asset('/') }}frontend/home-landing/images/instagram.png" alt="Instagram" style="width: 30px;">
                    </a>
                    <a href="#" aria-label="TikTok" class="btn btn-outline-secondary btn-sm rounded-circle p-2">
                        <img src="{{ asset('/') }}frontend/home-landing/images/tiktok.png" alt="TikTok" style="width: 30px;">
                    </a>
                </div>

                <select class="form-select form-select-sm w-auto" aria-label="Select country">
                    <option selected>United States</option>
                    <option value="1">Canada</option>
                    <option value="2">United Kingdom</option>
                    <option value="3">Australia</option>
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
</body>
</html>
