@extends('frontend.employer.master')

@section('title', 'Employer Home')

@section('body')
    <main class="eh-feed">
        {{-- ===== TOP BAR: Greeting + Search ===== --}}
        <div class="eh-topbar-row">
            <div>
                <h1 class="eh-greeting">{{ trans('employer.home') }}</h1>
                <p class="eh-greeting-sub">Discover talent and stay connected</p>
            </div>
            <form action="" method="get" class="eh-search-form">
                <div class="eh-search-wrap">
                    <i class="fa-solid fa-magnifying-glass eh-search-icon"></i>
                    <input type="text" name="search_text" class="eh-search-input" placeholder="{{ trans('employer.search_company') }}" value="{{ request('search_text') }}">
                    <button type="submit" class="eh-search-btn">{{ trans('common.search') }}</button>
                </div>
            </form>
        </div>

        <div class="eh-layout">
            {{-- ===== MAIN COLUMN ===== --}}
            <div class="eh-main" id="appendContentHere">

                {{-- Create Post CTA --}}
                @if(!\App\Helpers\ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
                    <div class="eh-create-post-card">
                        <div class="eh-create-post-inner">
                            <div class="eh-create-post-icon">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </div>
                            <div class="eh-create-post-text">
                                <span class="eh-create-post-label">{{ trans('employer.have_something_new_on_mind') }}</span>
                                <span class="eh-create-post-hint">Share updates, news or articles</span>
                            </div>
                            <a href="{{ route('employer.posts.create') }}" class="eh-create-post-btn">
                                <i class="fa-solid fa-plus"></i> {{ trans('employer.post') }}
                            </a>
                        </div>
                    </div>
                @endif

                {{-- ===== Suggested Profiles Carousel ===== --}}
                @if(count($employees) > 0)
                <div class="eh-section-card">
                    <div class="eh-section-header">
                        <h2 class="eh-section-title">
                            <i class="fa-solid fa-user-group eh-section-icon"></i>
                            Suggested Profiles
                        </h2>
                        <a href="{{ route('employer.employee-suggestions') }}" class="eh-view-all-link">
                            View All <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="employee-suggestions">
                        <div class="owl-carousel owl-theme">
                            @foreach($employees as $employee)
                                <div class="item pb-2">
                                    <a href="{{ route('employee-profile', $employee->id) }}" class="eh-talent-link">
                                        <article class="eh-talent-card">
                                            <div class="eh-talent-avatar-wrap">
                                                <img src="{{ asset($employee->profile_image ?? '/frontend/user-vector-img.jpg') }}"
                                                     alt="{{ $employee->name }}" class="eh-talent-avatar" />
                                                <span class="eh-talent-badge"><i class="fa-solid fa-briefcase"></i></span>
                                            </div>
                                            <div class="eh-talent-info">
                                                <h6 class="eh-talent-name">{{ $employee->name ?? trans('common.employee_name') }}</h6>
                                                <p class="eh-talent-title">{{ $employee->profile_title ?? trans('employee.profile_title') }}</p>
                                                <span class="eh-talent-location">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                    {!! str()->words($employee->address, 6) ?? trans('common.user_address') !!}
                                                </span>
                                            </div>
                                            <div class="eh-talent-stats">
                                                <span class="eh-stat-pill">
                                                    <i class="fa-solid fa-clock"></i>
                                                    {{ $employee?->employeeWorkExperiences[0]?->duration ?? 0 }}+ {{ trans('common.yrs') }}
                                                </span>
                                                <span class="eh-stat-pill">
                                                    <i class="fa-solid fa-graduation-cap"></i>
                                                    {{ $employee?->employeeEducations[$employee->employeeEducations()->count() - 1]?->cgpa ?? 0.0 }} {{ trans('common.cgpa') }}
                                                </span>
                                            </div>
                                        </article>
                                    </a>
                                </div>
                            @endforeach
                            <div class="item" id="viewMore">
                                <a href="{{ route('employer.employee-suggestions') }}" class="eh-talent-link">
                                    <article class="eh-talent-card eh-view-more-card">
                                        <div class="eh-view-more-icon">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </div>
                                        <h6 class="eh-view-more-title">View more profiles</h6>
                                        <p class="eh-view-more-sub">Discover more talent on LikewiseBD</p>
                                    </article>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Posts are appended here via AJAX --}}
            </div>

            {{-- ===== SIDEBAR: Advertisements ===== --}}
            @if(count($advertisements) > 0)
                <aside class="eh-sidebar" id="advertisementContainer">
                    <div class="eh-sidebar-sticky">
                        <div class="eh-ad-header">
                            <span class="eh-ad-label"><i class="fa-solid fa-bullhorn"></i> Sponsored</span>
                        </div>
                        @foreach($advertisements as $advertisement)
                            <div class="eh-ad-card">
                                <a href="{{ url('/'.$advertisement->redirect_url) }}" target="_blank" rel="noopener">
                                    <img src="{{ asset($advertisement->banner) }}" alt="{{ $advertisement->title ?? 'Ad' }}" class="eh-ad-img" />
                                </a>
                            </div>
                        @endforeach
                    </div>
                </aside>
            @endif
        </div>
    </main>
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* =============================================
           EMPLOYER HOME — REDESIGNED STYLES
           ============================================= */

        .eh-feed {
            padding: 20px 24px 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ---------- Top Bar ---------- */
        .eh-topbar-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .eh-greeting {
            font-size: 24px;
            font-weight: 700;
            color: #0F172A;
            margin: 0;
            line-height: 1.2;
        }

        .eh-greeting-sub {
            font-size: 13px;
            color: #64748B;
            margin: 4px 0 0;
        }

        /* ---------- Search ---------- */
        .eh-search-form {
            flex-shrink: 0;
        }

        .eh-search-wrap {
            display: flex;
            align-items: center;
            background: #fff;
            border: 1.5px solid #E2E8F0;
            border-radius: 12px;
            padding: 4px 4px 4px 14px;
            transition: border-color .2s, box-shadow .2s;
            max-width: 420px;
        }

        .eh-search-wrap:focus-within {
            border-color: #FFCB11;
            box-shadow: 0 0 0 3px rgba(255,203,17,.15);
        }

        .eh-search-icon {
            color: #94A3B8;
            font-size: 14px;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .eh-search-input {
            border: none;
            outline: none;
            background: transparent;
            font-size: 14px;
            color: #0F172A;
            flex: 1;
            min-width: 0;
            padding: 8px 0;
            font-family: 'Geist', sans-serif;
        }

        .eh-search-input::placeholder {
            color: #94A3B8;
        }

        .eh-search-btn {
            background: #141C25;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
            white-space: nowrap;
            font-family: 'Geist', sans-serif;
        }

        .eh-search-btn:hover {
            background: #1E293B;
        }

        /* ---------- Layout: Main + Sidebar ---------- */
        .eh-layout {
            display: flex;
            gap: 24px;
            align-items: flex-start;
        }

        .eh-main {
            flex: 1;
            min-width: 0;
        }

        .eh-sidebar {
            width: 300px;
            flex-shrink: 0;
        }

        .eh-sidebar-sticky {
            position: sticky;
            top: 80px;
        }

        /* ---------- Create Post Card ---------- */
        .eh-create-post-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #E2E8F0;
            padding: 16px 20px;
            margin-bottom: 20px;
            transition: box-shadow .2s;
        }

        .eh-create-post-card:hover {
            box-shadow: 0 4px 16px rgba(15,23,42,.06);
        }

        .eh-create-post-inner {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .eh-create-post-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #FFF7D6 0%, #FFF0B3 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #B8860B;
            flex-shrink: 0;
        }

        .eh-create-post-text {
            flex: 1;
            min-width: 0;
        }

        .eh-create-post-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #0F172A;
            line-height: 1.3;
        }

        .eh-create-post-hint {
            display: block;
            font-size: 12px;
            color: #94A3B8;
            margin-top: 2px;
        }

        .eh-create-post-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #FFCB11;
            color: #141C25;
            border: none;
            border-radius: 10px;
            padding: 9px 18px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            transition: background .2s, transform .15s;
        }

        .eh-create-post-btn:hover {
            background: #F5C000;
            transform: translateY(-1px);
            color: #141C25;
        }

        /* ---------- Section Card (Suggested Profiles wrapper) ---------- */
        .eh-section-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #E2E8F0;
            padding: 20px;
            margin-bottom: 20px;
        }

        .eh-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .eh-section-title {
            font-size: 16px;
            font-weight: 700;
            color: #0F172A;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .eh-section-icon {
            color: #FFCB11;
            font-size: 16px;
        }

        .eh-view-all-link {
            font-size: 13px;
            font-weight: 600;
            color: #141C25;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: color .2s;
        }

        .eh-view-all-link:hover {
            color: #FFCB11;
        }

        .eh-view-all-link i {
            font-size: 11px;
            transition: transform .2s;
        }

        .eh-view-all-link:hover i {
            transform: translateX(3px);
        }

        /* ---------- Talent Cards ---------- */
        .eh-talent-link {
            text-decoration: none !important;
            display: block;
            height: 100%;
        }

        .eh-talent-card {
            background: #FAFBFC;
            border: 1px solid #F1F5F9;
            border-radius: 14px;
            padding: 18px 14px;
            text-align: center;
            transition: transform .2s, box-shadow .2s, border-color .2s;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .eh-talent-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(15,23,42,.08);
            border-color: #FFCB11;
        }

        .eh-talent-avatar-wrap {
            position: relative;
            margin-bottom: 10px;
        }

        .eh-talent-avatar {
            width: 56px !important;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            border: 2.5px solid #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }

        .eh-talent-badge {
            position: absolute;
            bottom: -2px;
            right: -4px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #FFCB11;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            color: #141C25;
            border: 2px solid #fff;
        }

        .eh-talent-info {
            flex: 1;
            min-width: 0;
            width: 100%;
        }

        .eh-talent-name {
            font-size: 14px;
            font-weight: 700;
            color: #0F172A;
            margin: 0 0 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .eh-talent-title {
            font-size: 12px;
            color: #64748B;
            margin: 0 0 6px;
            line-height: 1.3;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .eh-talent-location {
            font-size: 11px;
            color: #94A3B8;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .eh-talent-location i {
            font-size: 10px;
            color: #FFCB11;
        }

        .eh-talent-stats {
            display: flex;
            gap: 6px;
            margin-top: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .eh-stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #F1F5F9;
            border-radius: 20px;
            padding: 4px 9px;
            font-size: 11px;
            font-weight: 600;
            color: #475569;
        }

        .eh-stat-pill i {
            font-size: 10px;
            color: #94A3B8;
        }

        /* View more card */
        .eh-view-more-card {
            justify-content: center;
            background: linear-gradient(135deg, #F8FAFC 0%, #EEF2FF 100%);
            border: 1px dashed #CBD5E1;
            min-height: 200px;
        }

        .eh-view-more-card:hover {
            border-style: solid;
            border-color: #FFCB11;
            background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
        }

        .eh-view-more-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #141C25;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #FFCB11;
            margin-bottom: 10px;
        }

        .eh-view-more-title {
            font-size: 14px;
            font-weight: 700;
            color: #0F172A;
            margin: 0 0 4px;
        }

        .eh-view-more-sub {
            font-size: 12px;
            color: #64748B;
            margin: 0;
        }

        /* ---------- Owl Carousel Overrides ---------- */
        .employee-suggestions .owl-carousel,
        .employee-suggestions .owl-stage-outer {
            width: 100%;
            overflow: hidden;
        }

        .employee-suggestions .owl-stage {
            display: flex;
        }

        .employee-suggestions .owl-nav {
            display: flex;
            justify-content: space-between;
            position: absolute;
            top: 38%;
            width: calc(100% + 24px);
            left: -12px;
            pointer-events: none;
        }

        .employee-suggestions .owl-nav button {
            pointer-events: all;
            background: #fff !important;
            border: 1.5px solid #E2E8F0 !important;
            width: 32px;
            height: 32px;
            border-radius: 50% !important;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            transition: all .2s;
            font-size: 14px;
            color: #334155;
        }

        .employee-suggestions .owl-nav button:hover {
            background: #FFCB11 !important;
            border-color: #FFCB11 !important;
            color: #141C25;
        }

        .employee-suggestions .owl-nav button span {
            line-height: 1;
            margin-top: -2px;
        }

        .owl-prev-btn, .owl-next-btn {
            font-size: 16px;
            line-height: 1;
        }

        /* ---------- Advertisement Sidebar ---------- */
        .eh-ad-header {
            margin-bottom: 12px;
        }

        .eh-ad-label {
            font-size: 12px;
            font-weight: 600;
            color: #94A3B8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .eh-ad-label i {
            font-size: 11px;
        }

        .eh-ad-card {
            margin-bottom: 14px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #E2E8F0;
            transition: transform .2s, box-shadow .2s;
        }

        .eh-ad-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(15,23,42,.08);
        }

        .eh-ad-img {
            width: 100%;
            max-height: 260px;
            object-fit: cover;
            display: block;
        }

        /* ===== Post Cards (from home-append) ===== */
        .eh-post-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #E2E8F0;
            padding: 20px;
            margin-bottom: 16px;
            transition: box-shadow .2s;
        }

        .eh-post-card:hover {
            box-shadow: 0 4px 20px rgba(15,23,42,.06);
        }

        .eh-post-header {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .eh-post-company-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            flex: 1;
            min-width: 0;
        }

        .eh-post-company-logo {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid #F1F5F9;
            flex-shrink: 0;
        }

        .eh-post-company-info {
            min-width: 0;
        }

        .eh-post-company-name {
            font-size: 14px;
            font-weight: 700;
            color: #0F172A;
            margin: 0;
            line-height: 1.3;
        }

        .eh-post-time {
            font-size: 12px;
            color: #94A3B8;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .eh-post-time i {
            font-size: 10px;
        }

        .eh-follow-btn {
            flex-shrink: 0;
            border: 1.5px solid #FFCB11;
            background: #FFFBEB;
            color: #92400E;
            border-radius: 8px;
            padding: 6px 16px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            white-space: nowrap;
            font-family: 'Geist', sans-serif;
        }

        .eh-follow-btn:hover {
            background: #FFCB11;
            color: #141C25;
        }

        /* Post Body */
        .eh-post-body {
            margin-top: 16px;
        }

        .eh-post-title-text {
            font-size: 17px;
            font-weight: 700;
            color: #0F172A;
            margin: 0 0 8px;
            line-height: 1.4;
        }

        .eh-post-title-text a {
            color: #0F172A;
            text-decoration: none;
            transition: color .2s;
        }

        .eh-post-title-text a:hover {
            color: #FFCB11;
        }

        .eh-post-desc {
            font-size: 14px;
            color: #475569;
            line-height: 1.7;
            margin: 0;
        }

        .eh-post-desc a {
            color: #141C25;
            font-weight: 600;
            text-decoration: none;
        }

        .eh-post-desc a:hover {
            color: #FFCB11;
        }

        /* Post Images */
        .eh-post-images {
            margin-top: 14px;
            display: grid;
            gap: 6px;
            border-radius: 12px;
            overflow: hidden;
        }

        .eh-post-images.eh-grid-1 {
            grid-template-columns: 1fr;
        }

        .eh-post-images.eh-grid-2 {
            grid-template-columns: 1fr 1fr;
        }

        .eh-post-images.eh-grid-3 {
            grid-template-columns: 1fr 1fr;
            grid-template-rows: auto auto;
        }

        .eh-post-images.eh-grid-3 .eh-post-img-wrap:first-child {
            grid-column: 1 / -1;
        }

        .eh-post-images.eh-grid-multi {
            grid-template-columns: 1fr 1fr;
        }

        .eh-post-img-wrap {
            overflow: hidden;
            position: relative;
        }

        .eh-post-img-wrap a {
            display: block;
        }

        .eh-post-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
            transition: transform .3s;
        }

        .eh-post-images.eh-grid-1 .eh-post-img {
            height: 360px;
        }

        .eh-post-img-wrap:hover .eh-post-img {
            transform: scale(1.02);
        }

        .eh-post-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid #F1F5F9;
        }

        .eh-post-timestamp {
            font-size: 12px;
            color: #94A3B8;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .eh-post-timestamp i {
            font-size: 11px;
        }

        /* ---------- Loading Skeleton ---------- */
        .eh-loading {
            text-align: center;
            padding: 20px;
            color: #94A3B8;
            font-size: 13px;
        }

        /* =============================================
           RESPONSIVE BREAKPOINTS
           ============================================= */

        @media (max-width: 991px) {
            .eh-sidebar {
                display: none;
            }

            .eh-feed {
                padding: 16px;
            }

            .employee-suggestions .owl-stage {
                display: flex !important;
                align-items: stretch;
            }

            .employee-suggestions .owl-item {
                display: flex;
                float: none !important;
            }

            .employee-suggestions .item {
                height: 100%;
                width: 100%;
            }

            .employee-suggestions .eh-talent-card {
                height: 100%;
                width: 100%;
            }
        }

        @media (min-width: 992px) {
            .employee-suggestions .owl-stage {
                display: block !important;
            }

            .employee-suggestions .owl-item {
                display: block;
            }

            .employee-suggestions .item,
            .employee-suggestions .eh-talent-card {
                height: auto;
            }
        }

        @media (max-width: 768px) {
            .eh-topbar-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .eh-search-form {
                width: 100%;
            }

            .eh-search-wrap {
                max-width: 100%;
            }

            .eh-greeting {
                font-size: 20px;
            }

            .eh-post-images.eh-grid-1 .eh-post-img {
                height: 240px;
            }

            .eh-post-img {
                height: 150px;
            }

            .eh-talent-stats {
                display: none;
            }

            .eh-feed {
                padding: 12px;
            }

            .eh-section-card {
                padding: 14px;
            }

            .eh-post-card {
                padding: 14px;
                border-radius: 12px;
            }

            .eh-create-post-card {
                padding: 12px 14px;
            }
        }

        @media (max-width: 576px) {
            .eh-create-post-inner {
                flex-wrap: wrap;
            }

            .eh-create-post-btn {
                width: 100%;
                justify-content: center;
                margin-top: 4px;
            }

            .eh-post-company-logo {
                width: 40px;
                height: 40px;
                border-radius: 8px;
            }

            .eh-post-company-name {
                font-size: 13px;
            }

            .eh-post-title-text {
                font-size: 15px;
            }

            .eh-follow-btn {
                padding: 5px 12px;
                font-size: 12px;
            }

            .eh-talent-avatar {
                width: 44px !important;
                height: 44px;
            }

            .eh-talent-name {
                font-size: 13px;
            }

            .eh-section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }

        @media (max-width: 400px) {
            .eh-post-header {
                flex-wrap: wrap;
            }

            .eh-follow-btn {
                padding: 4px 10px;
                font-size: 11px;
            }
        }

        /* Keep sidebar stable */
        .employeHome .sidebar { flex: 0 0 250px; min-width: 250px; }
        .employeHome .mainContent { min-width: 0; overflow: hidden; }
    </style>
@endpush

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            responsiveClass:true,
            nav: true,
            dots: false,
            navText: [
                '<span class="owl-prev-btn">&#10094;</span>',
                '<span class="owl-next-btn">&#10095;</span>'
            ],
            responsive:{
                0:{
                    items:2,
                    nav:true
                },
                600:{
                    items:3,
                    nav:false
                },
                1000:{
                    items:3,
                    nav:true,
                    loop:false
                }
            }
        })
    </script>
    <script>
        var startNumber = 0;
        var endNumber = 10;
        $(document).ready(function () {
            sendAjaxRequest(`employer/home?start_number=${startNumber}`, 'GET').then(function (response) {
                $('#appendContentHere').append(response);
                startNumber += 1;
            })
        });

        let loading = false;
        $(window).on('scroll', function () {
            if (!loading && $(window).scrollTop() + $(window).height() >= $(document).height() - 10) {
                loading = true;
                sendAjaxRequest(`employer/home?start_number=${startNumber}`, 'GET').then(function (response) {
                    $('#appendContentHere').append(response);
                    startNumber += 10;
                    loading = false;
                })
            }
        });
    </script>

    <script>
        $(document).on('click', '.follow-btn', function () {
            let companyEmployerId = $(this).attr('data-employer-id');
            let companyEmployerName = $(this).attr('data-employer-company-name');
            let postId = $(this).attr('data-post-id');
            let followHistoryStatus = $(this).attr('data-follow-history-status');
            sendAjaxRequest(`employer/set-follow-history?employer_id=${companyEmployerId}&status=${ followHistoryStatus == 1 ? 'false' : 'true' }`, 'GET').then(function (response) {
                if (response.status == 'success' )
                {
                    if (response.follow_status == 1)
                    {
                        toastr.success(`You followed ${companyEmployerName} successfully.`);
                        $('#followBtn'+postId).text("{{ trans('employer.unfollow') }}").attr('data-follow-history-status', 1);

                    } else if (response.follow_status == 0)
                    {
                        toastr.warning(`You Unfollowed ${companyEmployerName} successfully.`);
                        $('#followBtn'+postId).text("{{ trans('employer.follow') }}").attr('data-follow-history-status', 0);
                    }
                } else {
                    alert('Please try again.')
                }
            })
        })
    </script>
@endpush
