<!DOCTYPE html>
<html lang="{{ session('locale', 'en') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Like Wise BD">
    <meta name="title" content="Like Wise BD">
    <link rel="icon" href="{{ asset($siteSetting->favicon) ?? '' }}" type="image/x-icon">
    {!! $siteSetting->meta_header ?? '' !!}
    <title>{!! $siteSetting->meta_title ?? 'Like Wise BD' !!}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/') }}common-assets/css/helper.min.css" />
    <link rel="stylesheet" href="{{ asset('/') }}frontend/auth/loginStyle.css">
    <link rel="stylesheet" href="{{ asset('/') }}common-assets/css/toastr-2.1.3.min.css" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;400;500;600;700;800;1,9..40,400;500&family=Playfair+Display:ital,wght@0,700;0,800;0,900;1,700;1,800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <link rel="stylesheet" href="{{ asset('frontend/page-custom-codes/home-landing/style.css') }}" />
</head>

<body>

<!-- ═══════════════ NAVBAR ═══════════════ -->
<nav class="lw-navbar " id="mainNav">
    <div class="container">
        <div class="navbar-inner">
            <a href="{{ route('/') }}" class="nav-logo">
                <img src="{{ asset('/frontend/likewise.png') }}" alt="LikewiseBD">
            </a>

            <ul class="nav-links">
                <li><a href="{{ route('auth.set-login-role') }}">{{ trans('home.jobs') }}</a></li>
                <li><a href="{{ route('auth.set-login-role') }}">{{ trans('home.companies') }}</a></li>
                <li><a href="{{ route('auth.set-login-role') }}">{{ trans('home.for_employers') }}</a></li>
            </ul>

            <div class="nav-actions">
                @if(auth()->check())
                    <a href="{{ auth()->user()->user_type == 'employee' ? route('employee.home') : (auth()->user()->user_type == 'employer' ? route('employer.home') : route('dashboard')) }}" class="btn-primary-custom">
                        {{ trans('home.dashboard') }}
                    </a>
                    <a href="#" onclick="event.preventDefault(); document.getElementsByClassName('logoutForm')[0].submit()" class="btn-outline-custom">
                        {{ trans('home.logout') }}
                    </a>
                    <form action="{{ route('logout') }}" method="post" class="logoutForm">@csrf</form>
                @else
                    <a href="{{ route('auth.select-auth-method') }}" class="btn-outline-custom">{{ trans('auth.sign_in') }}</a>
{{--                    <a href="{{ url('auth/user-registration-page?user=Employee') }}" class="btn-primary-custom">{{ trans('home.get_started_free') }}</a>--}}
                    <a href="{{ route('auth.set-registration-role') }}" class="btn-primary-custom">{{ trans('home.get_started_free') }}</a>
                @endif
            </div>

            <button class="hamburger-btn" onclick="toggleMobileMenu()" aria-label="Menu">
                <i data-lucide="menu" class="hamburger-icon" style="width:24px;height:24px;color:var(--white)"></i>
            </button>
        </div>
    </div>
</nav>

<!-- ═══════════════ MOBILE MENU ═══════════════ -->
<div class="mobile-menu-overlay" id="mobileOverlay" onclick="toggleMobileMenu()"></div>
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-menu-header">
        <img src="{{ asset('/frontend/likewise.png') }}" alt="LikewiseBD">
        <button class="mobile-menu-close" onclick="toggleMobileMenu()" aria-label="Close">
            <i data-lucide="x" style="width:24px;height:24px"></i>
        </button>
    </div>
    <div class="mobile-menu-body">
        <a href="{{ route('auth.set-login-role') }}" class="mobile-nav-link">{{ trans('home.jobs') }}</a>
        <a href="{{ route('auth.set-login-role') }}" class="mobile-nav-link">{{ trans('home.companies') }}</a>
        <a href="{{ route('auth.set-login-role') }}" class="mobile-nav-link">{{ trans('home.for_employers') }}</a>
    </div>
    <div class="mobile-menu-footer">
        @if(auth()->check())
            <a href="{{ auth()->user()->user_type == 'employee' ? route('employee.home') : (auth()->user()->user_type == 'employer' ? route('employer.home') : route('dashboard')) }}" class="btn-primary-custom" style="justify-content:center">
                {{ trans('home.dashboard') }}
            </a>
            <a href="#" onclick="event.preventDefault(); document.getElementsByClassName('logoutForm')[0].submit()" class="btn-outline-custom" style="justify-content:center">
                {{ trans('home.logout') }}
            </a>
        @else
            <a href="{{ route('auth.select-auth-method') }}" class="btn-dark-custom" style="justify-content:center">{{ trans('auth.sign_in') }}</a>
            <a href="{{ url('auth/user-registration-page?user=Employee') }}" class="btn-primary-custom" style="justify-content:center">{{ trans('home.get_started_free') }}</a>
        @endif
    </div>
</div>


<!-- ═══════════════ HERO SECTION ═══════════════ -->
<section class="hero-section">
    <!-- Background Image -->
    <div class="hero-bg">
        <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=1920&q=80&fit=crop" alt="Professional team collaborating">
    </div>

    <!-- Content Overlay -->
    <div class="hero-content">
        <div class="hero-badge">
            <i data-lucide="sparkles" style="width:14px;height:14px;color:var(--primary)"></i>
            {{ trans('home.hero_title') }}
        </div>

        <h1 class="hero-title">
            {{ trans('home.where_doors_knock_you') }}
        </h1>

        <p class="hero-subtitle">{{ trans('home.hero_subtitle') }}</p>

        <div class="hero-actions">
            @if(auth()->check())
                <a href="{{ auth()->user()->user_type == 'employee' ? route('employee.home') : (auth()->user()->user_type == 'employer' ? route('employer.home') : route('dashboard')) }}" class="hero-btn-primary">
                    {{ trans('home.visit_dashboard') }}
                    <i data-lucide="arrow-right" style="width:18px;height:18px"></i>
                </a>
            @else
                <a href="{{ route('auth.socialite.redirect', ['provider' => 'google', 'user' => 'Employee', 'g_req_from' => 'home']) }}" class="hero-btn-primary">
                    <img src="{{ asset('/') }}frontend/home-landing/images/gooleIcon.png" alt="Google" style="width:20px;height:20px;">
                    Sign Up With Google
                </a>
                <a href="{{ route('auth.select-auth-method') }}" class="hero-btn-secondary">
                    {{ trans('home.continue_with_email') }}
                    <i data-lucide="arrow-right" style="width:18px;height:18px"></i>
                </a>
            @endif
        </div>

        <p class="hero-terms-text">{{ trans('home.by_continuing_agree_terms') }}</p>

        <div class="hero-stats">
            <div class="hero-stat-pill">
                <div class="hero-stat-icon">
                    <i data-lucide="briefcase" style="width:16px;height:16px;color:var(--primary)"></i>
                </div>
                <div>
                    <div class="hero-stat-number">10K+</div>
                    <div class="hero-stat-label">Active Jobs</div>
                </div>
            </div>
            <div class="hero-stat-pill">
                <div class="hero-stat-icon">
                    <i data-lucide="building-2" style="width:16px;height:16px;color:var(--primary)"></i>
                </div>
                <div>
                    <div class="hero-stat-number">500+</div>
                    <div class="hero-stat-label">Companies</div>
                </div>
            </div>
            <div class="hero-stat-pill">
                <div class="hero-stat-icon">
                    <i data-lucide="users" style="width:16px;height:16px;color:var(--primary)"></i>
                </div>
                <div>
                    <div class="hero-stat-number">50K+</div>
                    <div class="hero-stat-label">Job Seekers</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="hero-scroll-hint">
        <span>Scroll</span>
        <div class="scroll-line"></div>
    </div>
</section>




<!-- ═══════════════ TRUSTED BY ═══════════════ -->
{{--<section class="trusted-section">--}}
{{--    <div class="container">--}}
{{--        <p class="trusted-label">{{ trans('home.trusted_by') }}</p>--}}
{{--        <div class="trusted-logos">--}}
{{--            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg" alt="Google">--}}
{{--            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg" alt="Amazon">--}}
{{--            <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" alt="Microsoft">--}}
{{--            <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" alt="Apple" style="height:32px">--}}
{{--            <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Netflix_2015_logo.svg" alt="Netflix">--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}


<!-- ═══════════════ FEATURES ═══════════════ -->
<section class="features-section">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-kicker">{{ trans('home.why_choose_us') }}</p>
            <h2 class="section-title">{{ trans('home.get_ahead_with_likewisebd') }}</h2>
            <p class="section-desc mx-auto">{{ trans('home.why_choose_desc') }}</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon-box yellow">
                        <i data-lucide="target" style="width:24px;height:24px;color:var(--primary-dark)"></i>
                    </div>
                    <h5>{{ trans('home.smart_matching') }}</h5>
                    <p>{{ trans('home.smart_matching_desc') }}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon-box green">
                        <i data-lucide="shield-check" style="width:24px;height:24px;color:#059669"></i>
                    </div>
                    <h5>{{ trans('home.verified_employers') }}</h5>
                    <p>{{ trans('home.verified_employers_desc') }}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon-box blue">
                        <i data-lucide="bell-ring" style="width:24px;height:24px;color:#2563EB"></i>
                    </div>
                    <h5>{{ trans('home.instant_alerts') }}</h5>
                    <p>{{ trans('home.instant_alerts_desc') }}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon-box purple">
                        <i data-lucide="book-open" style="width:24px;height:24px;color:#7C3AED"></i>
                    </div>
                    <h5>{{ trans('home.career_resources') }}</h5>
                    <p>{{ trans('home.career_resources_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════ HOW IT WORKS ═══════════════ -->
<section class="steps-section">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-kicker">{{ trans('home.how_it_works') }}</p>
            <h2 class="section-title">{{ trans('home.how_it_works_desc') }}</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h5>{{ trans('home.step1_title') }}</h5>
                    <p>{{ trans('home.step1_desc') }}</p>
                    <span class="step-connector d-none d-lg-block"></span>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h5>{{ trans('home.step2_title') }}</h5>
                    <p>{{ trans('home.step2_desc') }}</p>
                    <span class="step-connector d-none d-lg-block"></span>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h5>{{ trans('home.step3_title') }}</h5>
                    <p>{{ trans('home.step3_desc') }}</p>
                    <span class="step-connector d-none d-lg-block"></span>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="step-card">
                    <div class="step-number">4</div>
                    <h5>{{ trans('home.step4_title') }}</h5>
                    <p>{{ trans('home.step4_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════ CTA SECTION ═══════════════ -->
<section class="cta-section">
    <div class="container">
        <div class="cta-card">
            <h2>{{ trans('home.ready_to_start') }}</h2>
            <p>{{ trans('home.ready_to_start_desc') }}</p>
            <div class="cta-actions">
                @if(auth()->check())
                    <a href="{{ auth()->user()->user_type == 'employee' ? route('employee.home') : (auth()->user()->user_type == 'employer' ? route('employer.home') : route('dashboard')) }}" class="btn-primary-custom" style="padding:14px 32px;font-size:1rem">
                        {{ trans('home.visit_dashboard') }}
                        <i data-lucide="arrow-right" style="width:18px;height:18px"></i>
                    </a>
                @else
                    <a href="{{ url('auth/user-registration-page?user=Employee') }}" class="btn-primary-custom" style="padding:14px 32px;font-size:1rem">
                        {{ trans('home.get_started_free') }}
                        <i data-lucide="arrow-right" style="width:18px;height:18px"></i>
                    </a>
                    <a href="{{ url('auth/user-registration-page?user=Employer') }}" class="btn-white-custom" style="padding:14px 32px;font-size:1rem">
                        {{ trans('home.hire_talent') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════ FOOTER ═══════════════ -->
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
            <div class="col-lg-2 col-md-6 col-6">
                <h6 class="footer-heading">{{ trans('home.pages') }}</h6>
                <ul class="footer-links">
                    @foreach($commonPages as $commonPage)
                        <li><a href="{{ route('show-common-page', ['slug' => $commonPage->slug]) }}">{{ $commonPage->title ?? 'page name' }}</a></li>
                    @endforeach
                </ul>
            </div>

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


<!-- ═══════════════ GOOGLE USER TYPE MODAL ═══════════════ -->
<div class="modal fade" id="googleUserTypeSelect">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body">
                <div class="card shadow signupCard">
                    <div class="card-header bg-transparent position-relative" style="border-bottom:1px solid var(--dark-200)">
                        <a href="{{ route('/') }}"><img src="{{ asset('frontend/likewise.png') }}" alt="" class="signupLogo w-25"></a>
                        <button type="button" class="btn position-absolute btn-close" style="right:10px;top:50%;transform:translateY(-50%)" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="userCard">
                        <a href="{{ route('auth.socialite.create-user', ['provider' => 'google', 'user_type' => 'Employer']) }}" class="userSelectOption mb-3">
                            <div class="row d-flex align-items-center w-100">
                                <div class="col-2">
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
                        <a href="{{ route('auth.socialite.create-user', ['provider' => 'google', 'user_type' => 'Employee']) }}" class="userSelectOption">
                            <div class="row d-flex align-items-center w-100">
                                <div class="col-2">
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


<!-- ═══════════════ SCRIPTS ═══════════════ -->
<script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('/') }}common-assets/js/toastr-2.1.3.min.js"></script>
{!! Toastr::message() !!}
<script src="https://js.pusher.com/7.2.0/pusher.min.js"></script>
@include('frontend.zegocloud.incoming-call-popup')
<script src="{{ asset('frontend/page-custom-codes/home-landing/script.js') }}"></script>
<script>


    // Error toasts
    @if($errors->any())
        @foreach($errors->all() as $error)
            toastr.error('{{ $error }}', 'Error', { closeButton: true, progressBar: true });
        @endforeach
    @endif
    @if(session()->has('error'))
        toastr.error("{{ session('error') }}");
    @endif

    // Google redirect modal
    @if(request('has_redirect'))
    var modal = new bootstrap.Modal(document.getElementById('googleUserTypeSelect'));
    modal.show();
    @endif
</script>
</body>
</html>
