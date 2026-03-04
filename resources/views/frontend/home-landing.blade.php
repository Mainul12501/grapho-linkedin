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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <style>
        :root {
            --primary: #FFCB11;
            --primary-dark: #e5b500;
            --primary-light: #FFF3BF;
            --primary-50: #FFFBEB;
            --dark: #111827;
            --dark-700: #374151;
            --dark-500: #6B7280;
            --dark-400: #9CA3AF;
            --dark-300: #D1D5DB;
            --dark-200: #E5E7EB;
            --dark-100: #F3F4F6;
            --dark-50: #F9FAFB;
            --white: #FFFFFF;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
            --radius: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark-700);
            background: var(--white);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 { color: var(--dark); font-weight: 700; }

        /* ── Navbar ── */
        .lw-navbar {
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--dark-200);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            padding: 0;
            transition: box-shadow 0.3s;
        }
        .lw-navbar.scrolled { box-shadow: var(--shadow-md); }
        .lw-navbar .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
        }
        .lw-navbar .nav-logo img { height: 32px; }
        .lw-navbar .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .lw-navbar .nav-links a {
            text-decoration: none;
            color: var(--dark-500);
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.2s;
        }
        .lw-navbar .nav-links a:hover { color: var(--dark); }
        .lw-navbar .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
        }

        /* ── Buttons ── */
        .btn-primary-custom {
            background: var(--primary);
            color: var(--dark);
            border: none;
            padding: 10px 24px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary-custom:hover {
            background: var(--primary-dark);
            color: var(--dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }
        .btn-outline-custom {
            background: transparent;
            color: var(--dark);
            border: 1.5px solid var(--dark-300);
            padding: 10px 24px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-outline-custom:hover {
            border-color: var(--dark);
            color: var(--dark);
            background: var(--dark-50);
        }
        .btn-dark-custom {
            background: var(--dark);
            color: var(--white);
            border: none;
            padding: 10px 24px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-dark-custom:hover {
            background: #1F2937;
            color: var(--white);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }
        .btn-white-custom {
            background: var(--white);
            color: var(--dark);
            border: none;
            padding: 12px 28px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-white-custom:hover {
            background: var(--dark-50);
            color: var(--dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* ── Hero Section ── */
        .hero-section {
            padding: 140px 0 80px;
            background: linear-gradient(135deg, var(--primary-50) 0%, var(--white) 40%, #f0f7ff 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,203,17,0.15), transparent 70%);
            top: -200px;
            right: -100px;
            pointer-events: none;
        }
        .hero-section::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59,130,246,0.08), transparent 70%);
            bottom: -100px;
            left: -100px;
            pointer-events: none;
        }
        .hero-content { position: relative; z-index: 2; }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary-light);
            color: var(--dark);
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 24px;
        }
        .hero-title {
            font-size: clamp(2.2rem, 5vw, 3.5rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
            letter-spacing: -0.02em;
        }
        .hero-title .highlight {
            background: linear-gradient(135deg, var(--primary), #FFB800);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-subtitle {
            font-size: 1.15rem;
            color: var(--dark-500);
            max-width: 540px;
            line-height: 1.7;
            margin-bottom: 32px;
        }
        .hero-actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }
        .hero-image-wrapper {
            position: relative;
            z-index: 2;
        }
        .hero-image-main {
            width: 100%;
            max-width: 520px;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-xl);
            object-fit: cover;
        }
        .hero-float-card {
            position: absolute;
            background: var(--white);
            border-radius: var(--radius);
            padding: 16px 20px;
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: float 3s ease-in-out infinite;
        }
        .hero-float-card.card-1 {
            bottom: 20px;
            left: -20px;
        }
        .hero-float-card.card-2 {
            top: 40px;
            right: -10px;
            animation-delay: 1.5s;
        }
        .hero-float-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .hero-float-icon.yellow { background: var(--primary-light); }
        .hero-float-icon.blue { background: #DBEAFE; }
        .hero-float-icon.green { background: #D1FAE5; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* ── Search Bar ── */
        .search-bar-section {
            margin-top: -40px;
            position: relative;
            z-index: 10;
            padding: 0 16px;
        }
        .search-bar {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            padding: 8px;
            display: flex;
            align-items: center;
            max-width: 820px;
            margin: 0 auto;
            border: 1px solid var(--dark-200);
        }
        .search-bar .search-input-group {
            display: flex;
            align-items: center;
            flex: 1;
            gap: 4px;
            padding: 4px 12px;
        }
        .search-bar .search-input-group + .search-input-group {
            border-left: 1px solid var(--dark-200);
        }
        .search-bar input {
            border: none;
            outline: none;
            font-size: 0.95rem;
            color: var(--dark);
            background: transparent;
            width: 100%;
            padding: 8px 4px;
        }
        .search-bar input::placeholder { color: var(--dark-400); }
        .search-bar .search-btn {
            background: var(--primary);
            border: none;
            border-radius: 12px;
            padding: 12px 28px;
            font-weight: 600;
            color: var(--dark);
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
            font-size: 0.95rem;
        }
        .search-bar .search-btn:hover {
            background: var(--primary-dark);
            box-shadow: var(--shadow-md);
        }

        /* ── Trusted Companies ── */
        .trusted-section {
            padding: 60px 0 40px;
            text-align: center;
        }
        .trusted-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 600;
            color: var(--dark-400);
            margin-bottom: 28px;
        }
        .trusted-logos {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
            opacity: 0.5;
        }
        .trusted-logos img {
            height: 28px;
            filter: grayscale(100%);
            transition: all 0.3s;
        }
        .trusted-logos img:hover {
            filter: grayscale(0%);
            opacity: 1;
        }

        /* ── Features Section ── */
        .features-section {
            padding: 80px 0;
            background: var(--dark-50);
        }
        .section-kicker {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 12px;
        }
        .section-title {
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            font-weight: 800;
            margin-bottom: 12px;
            letter-spacing: -0.01em;
        }
        .section-desc {
            font-size: 1.05rem;
            color: var(--dark-500);
            max-width: 600px;
            line-height: 1.7;
        }
        .feature-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 32px 28px;
            height: 100%;
            border: 1px solid var(--dark-200);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary);
            transform: scaleX(0);
            transition: transform 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }
        .feature-card:hover::before { transform: scaleX(1); }
        .feature-icon-box {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .feature-icon-box.yellow { background: var(--primary-light); }
        .feature-icon-box.blue { background: #DBEAFE; }
        .feature-icon-box.green { background: #D1FAE5; }
        .feature-icon-box.purple { background: #EDE9FE; }
        .feature-card h5 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .feature-card p {
            color: var(--dark-500);
            font-size: 0.93rem;
            line-height: 1.6;
            margin: 0;
        }

        /* ── How It Works ── */
        .steps-section { padding: 80px 0; }
        .step-card {
            text-align: center;
            padding: 32px 24px;
            position: relative;
        }
        .step-number {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--primary);
            color: var(--dark);
            font-weight: 800;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 4px 14px rgba(255,203,17,0.4);
        }
        .step-card h5 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .step-card p {
            color: var(--dark-500);
            font-size: 0.93rem;
            line-height: 1.6;
            margin: 0;
        }
        .step-connector {
            position: absolute;
            top: 55px;
            right: -30px;
            width: 60px;
            height: 2px;
            background: repeating-linear-gradient(90deg, var(--dark-300), var(--dark-300) 6px, transparent 6px, transparent 12px);
        }

        /* ── CTA Section ── */
        .cta-section {
            padding: 80px 0;
            background: var(--dark-50);
        }
        .cta-card {
            background: linear-gradient(135deg, var(--dark) 0%, #1F2937 100%);
            border-radius: var(--radius-xl);
            padding: 64px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .cta-card::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,203,17,0.2), transparent 70%);
            top: -100px;
            right: -50px;
        }
        .cta-card::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,203,17,0.1), transparent 70%);
            bottom: -80px;
            left: -30px;
        }
        .cta-card h2 {
            color: var(--white);
            font-size: clamp(1.6rem, 3vw, 2.2rem);
            margin-bottom: 16px;
            position: relative;
            z-index: 2;
        }
        .cta-card p {
            color: var(--dark-400);
            font-size: 1.05rem;
            max-width: 540px;
            margin: 0 auto 32px;
            line-height: 1.7;
            position: relative;
            z-index: 2;
        }
        .cta-actions {
            display: flex;
            gap: 14px;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
            z-index: 2;
        }

        /* ── Footer ── */
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

        /* ── Mobile Off-canvas ── */
        .mobile-menu-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1100;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }
        .mobile-menu-overlay.active { opacity: 1; visibility: visible; }
        .mobile-menu {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: 300px;
            max-width: 85vw;
            background: var(--white);
            z-index: 1200;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        .mobile-menu.active { transform: translateX(0); }
        .mobile-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--dark-200);
        }
        .mobile-menu-header img { height: 30px; }
        .mobile-menu-close {
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: var(--dark-500);
        }
        .mobile-menu-body { padding: 20px; flex: 1; }
        .mobile-menu-body .mobile-nav-link {
            display: block;
            padding: 12px 0;
            color: var(--dark-700);
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            border-bottom: 1px solid var(--dark-100);
        }
        .mobile-menu-body .mobile-nav-link:hover { color: var(--primary-dark); }
        .mobile-menu-footer {
            padding: 20px;
            border-top: 1px solid var(--dark-200);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* ── Responsive ── */
        @media (max-width: 991px) {
            .nav-links, .nav-actions { display: none !important; }
            .hamburger-btn { display: block; }
            .hero-section { padding: 120px 0 100px; }
            .hero-image-wrapper { margin-top: 40px; text-align: center; }
            .hero-image-main { max-width: 100%; }
            .hero-float-card.card-1 { left: 10px; bottom: 10px; }
            .hero-float-card.card-2 { right: 10px; top: 20px; }
            .step-connector { display: none; }
            .cta-card { padding: 40px 24px; }
        }
        @media (max-width: 575px) {
            .search-bar {
                flex-direction: column;
                padding: 12px;
                gap: 8px;
            }
            .search-bar .search-input-group + .search-input-group {
                border-left: none;
                border-top: 1px solid var(--dark-200);
                padding-top: 8px;
            }
            .search-bar .search-btn { width: 100%; text-align: center; justify-content: center; }
            .hero-float-card { display: none; }
            .hero-title { font-size: 2rem; }
            .trusted-logos { gap: 24px; }
            .trusted-logos img { height: 22px; }
            .footer-bottom { flex-direction: column; text-align: center; }
        }

        /* ── Signup modal styles ── */
        .signupCard { border-radius: var(--radius-lg); overflow: hidden; }
        .userCard { padding: 20px; }
        .userSelectOption {
            display: block;
            text-decoration: none;
            color: var(--dark);
            padding: 16px;
            border: 1px solid var(--dark-200);
            border-radius: var(--radius);
            transition: all 0.2s;
        }
        .userSelectOption:hover {
            border-color: var(--primary);
            background: var(--primary-50);
            color: var(--dark);
        }
        .userSelectOption h5 { font-size: 1rem; margin-bottom: 4px; }
        .userSelectOption p { font-size: 0.85rem; color: var(--dark-500); margin: 0; }
        .userSelectOptionIcon { width: 40px; }
        .arrowIcon { width: 16px; opacity: 0.5; }

        @media only screen and (max-width: 600px) {
            .signupCard { width: 100% !important; }
            .userSelectOption { padding: 10px !important; }
            .userSelectOptionIcon { width: 30px !important; }
        }
    </style>
</head>

<body>

<!-- ═══════════════ NAVBAR ═══════════════ -->
<nav class="lw-navbar" id="mainNav">
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
                    <a href="{{ url('auth/user-registration-page?user=Employee') }}" class="btn-primary-custom">{{ trans('home.get_started_free') }}</a>
                @endif
            </div>

            <button class="hamburger-btn" onclick="toggleMobileMenu()" aria-label="Menu">
                <i data-lucide="menu" style="width:24px;height:24px;color:var(--dark)"></i>
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
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <div class="hero-badge">
                    <i data-lucide="sparkles" style="width:16px;height:16px;color:var(--primary-dark)"></i>
                    {{ trans('home.hero_title') }}
                </div>
                <h1 class="hero-title">

                    {{ trans('home.where_doors_knock_you') }}
                </h1>
                <p class="hero-subtitle">{{ trans('home.hero_subtitle') }}</p>

                <div class="hero-actions">
                    @if(auth()->check())
                        <a href="{{ auth()->user()->user_type == 'employee' ? route('employee.home') : (auth()->user()->user_type == 'employer' ? route('employer.home') : route('dashboard')) }}" class="btn-primary-custom">
                            {{ trans('home.visit_dashboard') }}
                            <i data-lucide="arrow-right" style="width:18px;height:18px"></i>
                        </a>
                    @else
                        <a href="{{ route('auth.socialite.redirect', ['provider' => 'google', 'user' => 'Employee', 'g_req_from' => 'home']) }}" class="btn-primary-custom">
                            <img src="{{ asset('/') }}frontend/home-landing/images/gooleIcon.png" alt="Google" style="width:20px;height:20px;">
                            Sign Up With Google
                        </a>
                        <a href="{{ route('auth.select-auth-method') }}" class="btn-outline-custom">
                            {{ trans('home.continue_with_email') }}
                            <i data-lucide="arrow-right" style="width:18px;height:18px"></i>
                        </a>
                    @endif
                </div>

                <p style="font-size:0.82rem;color:var(--dark-400)">{{ trans('home.by_continuing_agree_terms') }}</p>
            </div>

            <div class="col-lg-6">
                <div class="hero-image-wrapper">
                    <img src="{{ asset('/frontend/home-landing/images/left.jpeg') }}" alt="Find your dream job" class="hero-image-main">

                    <div class="hero-float-card card-1">
                        <div class="hero-float-icon green">
                            <i data-lucide="check-circle" style="width:22px;height:22px;color:#059669"></i>
                        </div>
                        <div>
                            <div style="font-weight:700;font-size:0.9rem;color:var(--dark)">{{ trans('home.verified_employers') }}</div>
                            <div style="font-size:0.78rem;color:var(--dark-500)">{{ trans('home.easy_requirements') }}</div>
                        </div>
                    </div>

                    <div class="hero-float-card card-2">
                        <div class="hero-float-icon yellow">
                            <i data-lucide="briefcase" style="width:22px;height:22px;color:var(--primary-dark)"></i>
                        </div>
                        <div>
                            <div style="font-weight:700;font-size:0.9rem;color:var(--dark)">{{ trans('home.smart_matching') }}</div>
                            <div style="font-size:0.78rem;color:var(--dark-500)">{{ trans('home.find_and_apply_to_jobs') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════ SEARCH BAR ═══════════════ -->
<div class="search-bar-section">
    <form class="search-bar" action="{{ route('auth.set-login-role') }}" method="GET">
        <div class="search-input-group">
            <i data-lucide="search" style="width:20px;height:20px;color:var(--dark-400);flex-shrink:0"></i>
            <input type="text" name="q" placeholder="{{ trans('home.search_placeholder') }}">
        </div>
        <div class="search-input-group">
            <i data-lucide="map-pin" style="width:20px;height:20px;color:var(--dark-400);flex-shrink:0"></i>
            <input type="text" name="location" placeholder="{{ trans('home.location_placeholder') }}">
        </div>
        <button type="submit" class="search-btn">{{ trans('home.find_jobs') }}</button>
    </form>
</div>


<!-- ═══════════════ TRUSTED BY ═══════════════ -->
<section class="trusted-section">
    <div class="container">
        <p class="trusted-label">{{ trans('home.trusted_by') }}</p>
        <div class="trusted-logos">
            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg" alt="Google">
            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg" alt="Amazon">
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" alt="Microsoft">
            <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" alt="Apple" style="height:32px">
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Netflix_2015_logo.svg" alt="Netflix">
        </div>
    </div>
</section>


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
            <div class="col-lg-2 col-md-6 col-6">
                <h6 class="footer-heading">{{ trans('home.work_with_us') }}</h6>
                <ul class="footer-links">
                    <li><a href="{{ url('auth/user-registration-page?user=Employer') }}">{{ trans('home.advertisers') }}</a></li>
                    <li><a href="{{ url('auth/user-registration-page?user=Employee') }}">{{ trans('home.careers') }}</a></li>
                </ul>
            </div>

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

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const nav = document.getElementById('mainNav');
        if (window.scrollY > 20) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    });

    // Mobile menu toggle
    function toggleMobileMenu() {
        document.getElementById('mobileMenu').classList.toggle('active');
        document.getElementById('mobileOverlay').classList.toggle('active');
        document.body.style.overflow = document.getElementById('mobileMenu').classList.contains('active') ? 'hidden' : '';
    }

    // Language switcher
    document.getElementById('changeLocalLangOption').addEventListener('change', function() {
        var selected = this.options[this.selectedIndex];
        var url = selected.getAttribute('data-url');
        if (url) window.location.href = url;
    });

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
