@extends('frontend.employer.master')

@section('title', 'Employer Home')

@section('body')
    <main class="ed-dashboard">
        <div class="ed-container">
            {{-- ===== Page Header ===== --}}
            <header class="ed-page-header">
                <div class="ed-header-left">
                    <h1 class="ed-page-title">Activities</h1>
                    <p class="ed-page-subtitle">Your jobs, posts &amp; company updates</p>
                </div>
                <div class="ed-header-actions">
                    <a href="{{ route('employer.my-jobs', ['show_modal' => 'create']) }}" class="ed-btn ed-btn-primary post-job-hide-mobile">
                        <i class="fa-solid fa-plus"></i>
                        <span>Post a Job</span>
                    </a>
                    <a href="{{ route('employer.posts.create') }}" class="ed-btn ed-btn-outline">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Create Post</span>
                    </a>
                </div>
            </header>

            <div class="ed-layout">
                {{-- ===== Left Sidebar: Quick Actions ===== --}}
                <aside class="ed-sidebar">
                    <div class="ed-sidebar-sticky">
                        {{-- Post a Job CTA --}}
                        <div class="ed-cta-card ed-cta-hire">
                            <div class="ed-cta-icon-wrap">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                            <h3 class="ed-cta-title">Find Your Next Hire</h3>
                            <p class="ed-cta-desc">Post a job and reach thousands of qualified candidates</p>
                            <a href="{{ route('employer.my-jobs', ['show_modal' => 'create']) }}" class="ed-btn ed-btn-dark ed-btn-block">
                                <i class="fa-solid fa-plus"></i> Post a Job
                            </a>
                        </div>

                        {{-- Head Hunt CTA --}}
                        <div class="ed-cta-card ed-cta-hunt">
                            <div class="ed-cta-icon-wrap ed-cta-icon-hunt">
                                <i class="fa-solid fa-magnifying-glass-chart"></i>
                            </div>
                            <h3 class="ed-cta-title">Head Hunt Talent</h3>
                            <p class="ed-cta-desc">Search, filter, and discover the best employees for your company</p>
                            <a href="{{ route('employer.head-hunt') }}" class="ed-btn ed-btn-outline-dark ed-btn-block">
                                <i class="fa-solid fa-crosshairs"></i> Browse Talent
                            </a>
                        </div>

                        {{-- Quick Stats --}}
                        <div class="ed-quick-links">
                            <a href="{{ route('employer.my-jobs') }}" class="ed-quick-link">
                                <i class="fa-solid fa-list-check"></i>
                                <span>My Jobs</span>
                                <i class="fa-solid fa-chevron-right ed-ql-arrow"></i>
                            </a>
                            <a href="{{ route('employer.my-job-wise-applicants') }}" class="ed-quick-link">
                                <i class="fa-solid fa-user-check"></i>
                                <span>Applicants</span>
                                <i class="fa-solid fa-chevron-right ed-ql-arrow"></i>
                            </a>
                            <a href="{{ route('employer.company-profile') }}" class="ed-quick-link">
                                <i class="fa-solid fa-building"></i>
                                <span>Company Profile</span>
                                <i class="fa-solid fa-chevron-right ed-ql-arrow"></i>
                            </a>
                        </div>
                    </div>
                </aside>

                {{-- ===== Main Content: Activity Feed ===== --}}
                <section class="ed-main">
                    <div class="ed-feed" id="item-container">
                        @include('frontend.employer.home.activity-content')

                        <div id="loader" class="ed-loader" style="display:none;">
                            <div class="ed-spinner"></div>
                            <span>Loading more...</span>
                        </div>

                        <div id="no-more-data" class="ed-end-msg" style="display:none;">
                            <i class="fa-solid fa-check-circle"></i>
                            <span>You're all caught up</span>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

    {{-- ===== View Job Modal ===== --}}
    <div class="modal fade" tabindex="-1" id="viewJobModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content ed-modal-content">
                <div class="modal-header ed-modal-header">
                    <h5 class="modal-title ed-modal-title" id="viewJobModalTitle">{{ trans('common.view_job_post') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ed-modal-body" id="viewJobModalBody">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer ed-modal-footer">
                    <button type="button" class="ed-btn ed-btn-outline" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== View Post Modal ===== --}}
    <div class="modal fade" id="viewPostModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content ed-modal-content">
                <div class="modal-header ed-modal-header">
                    <h5 class="modal-title ed-modal-title" id="viewPostModalTitle">View Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ed-modal-body" id="viewPostModalBody">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer ed-modal-footer">
                    <button type="button" class="ed-btn ed-btn-outline" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        /* =================================================
           EMPLOYER DASHBOARD — REFINED UTILITARIAN AESTHETIC
           Tone: Clean, dense, purposeful. No fluff.
           Font: Geist (already loaded globally)
           Palette: Slate-900 base, Amber-400 accent, cool grays
           ================================================= */

        /* ---------- Page Shell ---------- */
        .ed-dashboard {
            padding: 20px 24px 60px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .ed-container {
            width: 100%;
        }

        /* ---------- Page Header ---------- */
        .ed-page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 2px solid #F1F5F9;
        }

        .ed-page-title {
            font-size: 26px;
            font-weight: 800;
            color: #0F172A;
            margin: 0;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .ed-page-subtitle {
            font-size: 13px;
            color: #64748B;
            margin: 4px 0 0;
            font-weight: 500;
        }

        .ed-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
        }

        /* ---------- Buttons ---------- */
        .ed-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: all .2s ease;
            border: 1.5px solid transparent;
            font-family: 'Geist', sans-serif;
            white-space: nowrap;
            line-height: 1;
        }

        .ed-btn i {
            font-size: 12px;
        }

        .ed-btn-primary {
            background: #FFCB11;
            color: #141C25;
            border-color: #FFCB11;
        }

        .ed-btn-primary:hover {
            background: #F5C000;
            border-color: #E5B000;
            color: #141C25;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255,203,17,.25);
        }

        .ed-btn-outline {
            background: #fff;
            color: #334155;
            border-color: #CBD5E1;
        }

        .ed-btn-outline:hover {
            border-color: #94A3B8;
            background: #F8FAFC;
            color: #0F172A;
        }

        .ed-btn-dark {
            background: #141C25;
            color: #fff;
            border-color: #141C25;
        }

        .ed-btn-dark:hover {
            background: #1E293B;
            border-color: #1E293B;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15,23,42,.2);
        }

        .ed-btn-outline-dark {
            background: transparent;
            color: #141C25;
            border-color: #334155;
        }

        .ed-btn-outline-dark:hover {
            background: #141C25;
            color: #fff;
            border-color: #141C25;
        }

        .ed-btn-block {
            width: 100%;
            justify-content: center;
        }

        /* ---------- Two-column Layout ---------- */
        .ed-layout {
            display: flex;
            gap: 28px;
            align-items: flex-start;
        }

        .ed-sidebar {
            width: 280px;
            flex-shrink: 0;
        }

        .ed-sidebar-sticky {
            position: sticky;
            top: 80px;
        }

        .ed-main {
            flex: 1;
            min-width: 0;
        }

        /* ---------- CTA Cards ---------- */
        .ed-cta-card {
            border-radius: 16px;
            padding: 22px;
            margin-bottom: 16px;
            transition: transform .2s, box-shadow .2s;
        }

        .ed-cta-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(15,23,42,.08);
        }

        .ed-cta-hire {
            background: linear-gradient(145deg, #FFCB11 0%, #FFD84D 100%);
            border: 1px solid rgba(0,0,0,.05);
        }

        .ed-cta-hunt {
            background: #fff;
            border: 1.5px solid #E2E8F0;
        }

        .ed-cta-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 14px;
            background: rgba(255,255,255,.85);
            color: #141C25;
            box-shadow: 0 2px 6px rgba(0,0,0,.06);
        }

        .ed-cta-icon-hunt {
            background: #F1F5F9;
            color: #334155;
        }

        .ed-cta-title {
            font-size: 16px;
            font-weight: 800;
            color: #0F172A;
            margin: 0 0 6px;
            letter-spacing: -0.3px;
        }

        .ed-cta-desc {
            font-size: 12.5px;
            color: #475569;
            line-height: 1.5;
            margin: 0 0 16px;
        }

        .ed-cta-hire .ed-cta-desc {
            color: #44403C;
        }

        /* ---------- Quick Links ---------- */
        .ed-quick-links {
            background: #fff;
            border: 1.5px solid #E2E8F0;
            border-radius: 14px;
            overflow: hidden;
        }

        .ed-quick-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            text-decoration: none;
            color: #334155;
            font-size: 13.5px;
            font-weight: 600;
            transition: all .15s;
            border-bottom: 1px solid #F1F5F9;
        }

        .ed-quick-link:last-child {
            border-bottom: none;
        }

        .ed-quick-link:hover {
            background: #F8FAFC;
            color: #0F172A;
        }

        .ed-quick-link i:first-child {
            width: 20px;
            text-align: center;
            font-size: 14px;
            color: #64748B;
        }

        .ed-quick-link:hover i:first-child {
            color: #FFCB11;
        }

        .ed-quick-link span {
            flex: 1;
            font-size: 13.5px;
        }

        .ed-ql-arrow {
            font-size: 10px !important;
            color: #CBD5E1 !important;
            transition: transform .2s;
        }

        .ed-quick-link:hover .ed-ql-arrow {
            transform: translateX(3px);
            color: #94A3B8 !important;
        }

        /* =================================
           ACTIVITY FEED ITEMS
           ================================= */

        /* --- Job Card --- */
        .ed-job-card {
            background: #fff;
            border: 1.5px solid #E2E8F0;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 14px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: border-color .2s, box-shadow .2s;
            position: relative;
        }

        .ed-job-card:hover {
            border-color: #CBD5E1;
            box-shadow: 0 4px 16px rgba(15,23,42,.05);
        }

        .ed-job-type-bar {
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            border-radius: 14px 0 0 14px;
            background: #FFCB11;
        }

        .ed-job-icon-wrap {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #FEF9E7;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #B8860B;
            font-size: 16px;
        }

        .ed-job-body {
            flex: 1;
            min-width: 0;
        }

        .ed-job-title {
            font-size: 15px;
            font-weight: 700;
            color: #0F172A;
            margin: 0 0 8px;
            cursor: pointer;
            transition: color .15s;
            line-height: 1.3;
        }

        .ed-job-title:hover {
            color: #B8860B;
        }

        .ed-job-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 10px;
        }

        .ed-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 600;
            background: #F1F5F9;
            color: #475569;
        }

        .ed-job-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .ed-job-meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: #64748B;
            font-weight: 500;
        }

        .ed-job-meta-item i {
            font-size: 12px;
            color: #94A3B8;
        }

        .ed-job-meta-item a {
            color: #141C25;
            text-decoration: underline;
            text-underline-offset: 2px;
            font-weight: 700;
        }

        .ed-job-meta-item a:hover {
            color: #FFCB11;
        }

        .ed-job-actions {
            flex-shrink: 0;
            align-self: flex-start;
        }

        .ed-dots-btn {
            background: none;
            border: 1.5px solid #E2E8F0;
            border-radius: 8px;
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #64748B;
            font-size: 14px;
            transition: all .15s;
        }

        .ed-dots-btn:hover {
            border-color: #CBD5E1;
            background: #F8FAFC;
            color: #0F172A;
        }

        /* --- Post Card --- */
        .ed-post-card {
            background: #fff;
            border: 1.5px solid #E2E8F0;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 14px;
            transition: border-color .2s, box-shadow .2s;
        }

        .ed-post-card:hover {
            border-color: #CBD5E1;
            box-shadow: 0 4px 16px rgba(15,23,42,.05);
        }

        .ed-post-inner {
            display: flex;
        }

        .ed-post-thumb {
            width: 220px;
            min-height: 180px;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
            background: #F1F5F9;
        }

        .ed-post-thumb-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .3s;
        }

        .ed-post-card:hover .ed-post-thumb-img {
            transform: scale(1.03);
        }

        /* Image grid for multiple images */
        .ed-post-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            width: 100%;
            height: 100%;
            gap: 2px;
        }

        .ed-post-grid a {
            overflow: hidden;
            position: relative;
            display: block;
        }

        .ed-post-grid img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .ed-post-grid .ed-more-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15,23,42,.65);
            color: #fff;
            font-size: 22px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(1px);
        }

        .ed-post-content {
            flex: 1;
            min-width: 0;
            padding: 18px 20px;
            display: flex;
            flex-direction: column;
        }

        .ed-post-top-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 10px;
        }

        .ed-post-label {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6366F1;
            background: #EEF2FF;
            padding: 3px 8px;
            border-radius: 5px;
        }

        .ed-post-title {
            font-size: 15px;
            font-weight: 700;
            color: #0F172A;
            margin: 0 0 8px;
            line-height: 1.4;
            cursor: pointer;
            transition: color .15s;
        }

        .ed-post-title:hover {
            color: #B8860B;
        }

        .ed-post-title a {
            color: inherit;
            text-decoration: none;
        }

        .ed-post-excerpt {
            font-size: 13px;
            color: #64748B;
            line-height: 1.65;
            margin: 0;
            flex: 1;
        }

        .ed-post-excerpt a {
            color: #FFCB11;
            font-weight: 700;
            text-decoration: none;
        }

        .ed-post-excerpt a:hover {
            color: #D4A500;
        }

        /* --- Empty State --- */
        .ed-empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #94A3B8;
        }

        .ed-empty-icon {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.4;
        }

        .ed-empty-text {
            font-size: 18px;
            font-weight: 700;
            color: #64748B;
            margin: 0 0 6px;
        }

        .ed-empty-sub {
            font-size: 13px;
            color: #94A3B8;
            margin: 0;
        }

        /* --- Loader & End --- */
        .ed-loader {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 24px;
            color: #94A3B8;
            font-size: 13px;
            font-weight: 600;
        }

        .ed-spinner {
            width: 22px;
            height: 22px;
            border: 3px solid #E2E8F0;
            border-top-color: #FFCB11;
            border-radius: 50%;
            animation: ed-spin .7s linear infinite;
        }

        @keyframes ed-spin {
            to { transform: rotate(360deg); }
        }

        .ed-end-msg {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 20px;
            color: #94A3B8;
            font-size: 13px;
            font-weight: 600;
        }

        .ed-end-msg i {
            color: #22C55E;
            font-size: 16px;
        }

        /* --- Modal --- */
        .ed-modal-content {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(15,23,42,.15);
        }

        .ed-modal-header {
            border-bottom: 1px solid #F1F5F9;
            padding: 18px 24px;
        }

        .ed-modal-title {
            font-size: 16px;
            font-weight: 700;
            color: #0F172A;
        }

        .ed-modal-body {
            padding: 24px;
        }

        .ed-modal-footer {
            border-top: 1px solid #F1F5F9;
            padding: 14px 24px;
        }

        .modal .job-type {
            margin-bottom: 10px;
        }

        .ed-modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        /* --- Job Detail Content (inside modal) --- */
        .sj-detail-company-row {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
        }
        .sj-detail-logo {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid #eee;
        }
        .sj-detail-logo-link { flex-shrink: 0; }
        .sj-detail-company-info { min-width: 0; }
        .sj-detail-company-name {
            font-size: 15px;
            font-weight: 650;
            color: #484f5b;
            margin: 0;
        }
        .sj-detail-company-name a { color: inherit; text-decoration: none; }
        .sj-detail-company-name a:hover { color: #141c25; }
        .sj-detail-company-addr {
            font-size: 13px;
            color: #8c919d;
            margin: 2px 0 0;
        }
        .sj-detail-job-title {
            font-size: 24px;
            font-weight: 800;
            color: #141c25;
            margin: 0 0 10px;
            letter-spacing: -0.3px;
            line-height: 1.25;
        }
        .sj-tag {
            display: inline-block;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 600;
            color: #556070;
            background: #f0f1f4;
            border-radius: 6px;
        }
        .sj-detail-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 16px;
        }
        .sj-detail-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f1f3;
        }
        .sj-apply-btn {
            display: inline-flex !important;
            align-items: center;
            gap: 7px;
            padding: 10px 24px !important;
            font-size: 14px !important;
            font-weight: 700;
            color: #141c25 !important;
            background: #FFCB11 !important;
            border: none !important;
            border-radius: 12px !important;
            cursor: pointer;
            transition: all .2s ease;
            width: auto !important;
            margin: 0 !important;
        }
        .sj-apply-btn:hover {
            background: #f0be00 !important;
            box-shadow: 0 4px 14px rgba(255,203,17,.3);
            color: #141c25 !important;
        }
        .sj-applied-btn {
            display: inline-flex !important;
            align-items: center;
            gap: 7px;
            padding: 10px 24px !important;
            font-size: 14px !important;
            font-weight: 600;
            color: #22c55e !important;
            background: #F0FDF4 !important;
            border: 1px solid #BBF7D0 !important;
            border-radius: 12px !important;
            cursor: default;
            width: auto !important;
            margin: 0 !important;
        }
        .sj-save-btn {
            display: inline-flex !important;
            align-items: center;
            gap: 6px;
            padding: 10px 20px !important;
            font-size: 14px !important;
            font-weight: 600;
            color: #484f5b !important;
            background: #f3f4f6 !important;
            border: 1px solid #e4e5e9 !important;
            border-radius: 12px !important;
            cursor: pointer;
            transition: all .2s ease;
            width: auto !important;
            margin: 0 !important;
        }
        .sj-save-btn:hover {
            background: #e8e9ec !important;
            color: #484f5b !important;
        }
        .sj-detail-meta-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
            padding: 16px;
            background: #f8f9fb;
            border-radius: 12px;
        }
        .sj-meta-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .sj-meta-label {
            font-size: 12px;
            font-weight: 600;
            color: #8c919d;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .sj-meta-value {
            font-size: 14px;
            font-weight: 700;
            color: #141c25;
        }
        .sj-detail-section { margin-bottom: 20px; }
        .sj-detail-heading {
            font-size: 16px;
            font-weight: 700;
            color: #141c25;
            margin: 0 0 8px;
        }
        .sj-detail-subheading {
            font-size: 14px;
            font-weight: 650;
            color: #141c25;
            margin: 0 0 8px;
        }
        .sj-detail-text {
            font-size: 14px;
            color: #556070;
            line-height: 1.7;
        }
        .sj-detail-text p { color: #556070; }
        .sj-detail-list { padding-left: 20px; margin: 0; }
        .sj-detail-list li {
            font-size: 14px;
            color: #556070;
            margin-bottom: 4px;
        }
        .sj-skills-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .sj-skill-pill {
            padding: 5px 14px;
            font-size: 12px;
            font-weight: 600;
            color: #484f5b;
            background: #f0f1f4;
            border-radius: 20px;
        }
        @media (max-width: 768px) {
            .sj-detail-meta-grid { grid-template-columns: 1fr; }
            .sj-detail-job-title { font-size: 20px; }
        }

        /* =================================
           RESPONSIVE
           ================================= */

        /* Tablet: sidebar on top, stacked */
        @media (max-width: 991px) {
            .ed-layout {
                flex-direction: column;
            }

            .ed-sidebar {
                width: 100%;
                order: 1;
            }

            .ed-main {
                order: 2;
                width: 100%;
            }

            .ed-sidebar-sticky {
                position: static;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 14px;
            }

            .ed-cta-card {
                margin-bottom: 0;
            }

            .ed-quick-links {
                grid-column: 1 / -1;
                display: flex;
            }

            .ed-quick-link {
                flex: 1;
                justify-content: center;
                border-bottom: none;
                border-right: 1px solid #F1F5F9;
                text-align: center;
                padding: 12px 10px;
            }

            .ed-quick-link:last-child {
                border-right: none;
            }

            .ed-ql-arrow {
                display: none;
            }

            .ed-quick-link i:first-child {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .ed-dashboard {
                padding: 14px 12px 80px;
            }

            .ed-page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 14px;
                padding-bottom: 16px;
                margin-bottom: 20px;
            }

            .ed-header-actions {
                width: 100%;
            }

            .ed-header-actions .ed-btn {
                flex: 1;
                justify-content: center;
            }

            .ed-page-title {
                font-size: 22px;
            }

            /* Post card stack vertically */
            .ed-post-inner {
                flex-direction: column;
            }

            .ed-post-thumb {
                width: 100%;
                min-height: 160px;
                max-height: 200px;
            }

            .ed-post-content {
                padding: 14px 16px;
            }

            /* Job card adjustments */
            .ed-job-card {
                padding: 16px;
            }

            .ed-job-meta {
                gap: 10px;
            }

            .ed-sidebar-sticky {
                grid-template-columns: 1fr 1fr;
            }

            .ed-quick-links {
                grid-column: 1 / -1;
                flex-direction: column;
            }

            .ed-quick-link {
                justify-content: flex-start;
                border-right: none;
                border-bottom: 1px solid #F1F5F9;
            }

            .ed-quick-link:last-child {
                border-bottom: none;
            }

            .ed-quick-link i:first-child {
                display: inline;
            }

            .ed-ql-arrow {
                display: inline;
            }
        }

        @media (max-width: 576px) {
            .ed-job-card {
                flex-wrap: wrap;
                padding: 14px;
            }

            .ed-job-icon-wrap {
                display: none;
            }

            .ed-job-title {
                font-size: 14px;
            }

            .ed-job-meta {
                flex-direction: column;
                gap: 6px;
            }

            .ed-job-actions {
                position: absolute;
                top: 14px;
                right: 14px;
            }

            .ed-post-title {
                font-size: 14px;
            }

            .ed-header-actions {
                flex-direction: column;
            }

            .ed-cta-card {
                padding: 18px;
            }

            .ed-cta-title {
                font-size: 15px;
            }
        }

        /* ---- Post image zoom styles (carried from old) ---- */
        .post-image-wrapper {
            height: 100%;
            overflow: hidden;
        }

        .single-post-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(2, 1fr);
            width: 100%;
            height: 100%;
            gap: 2px;
        }

        .grid-image-wrapper {
            width: 100%;
            height: 100%;
            overflow: hidden;
            position: relative;
            cursor: pointer;
        }

        .image-grid img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .more-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15,23,42,.6);
            color: #fff;
            font-size: 22px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        @media screen and (max-width: 768px){
            .post-job-hide-mobile {display: none!important;}
            .def-img-on-mob {padding: 0px!important; height: 160px!important;}
        }
    </style>
@endpush

@push('script')
    <link rel="stylesheet" href="{{ asset('frontend/zoom-plugin/mbox.css') }}">
    <script src="{{ asset('frontend/zoom-plugin/mbox.min.js') }}"></script>

    <script>
        function showJobDetails(jobId, jobTitle = 'View Job Title') {
            sendAjaxRequest('get-job-details/'+jobId+'?render=1&show_apply=0', 'GET').then(function (response) {
                $('#viewJobModalTitle').empty().append(jobTitle);
                $('#viewJobModalBody').empty().append(response);
                $('#viewJobModal').modal('show');
            })
        }
        function showPostDetails(postId, postTitle = 'View Post Title') {
            sendAjaxRequest('employee-view-post/'+postId+'?render=1', 'GET').then(function (response) {
                $('#viewPostModalTitle').empty().append(postTitle);
                $('#viewPostModalBody').empty().append(response);
                $('.zoom-img').mBox();
                $('#viewPostModal').modal('show');
            })
        }

        $(document).on('click', '.ed-post-click', function(e) {
            e.preventDefault();
            var postId = $(this).data('post-id');
            var postTitle = $(this).data('post-title') || 'View Post';
            showPostDetails(postId, postTitle);
        });
    </script>

    <script>
        let page = 1;
        let loading = false;
        let lastPage = {{ $paginatedData->lastPage() }};

        function loadMoreData() {
            if (loading || page >= lastPage) return;

            loading = true;
            page++;
            $("#loader").show();

            $.ajax({
                url: "?page=" + page,
                type: "GET",
                success: function(res) {
                    if ($.trim(res) === "") {
                        $("#no-more-data").show();
                        return;
                    }

                    $("#item-container").append(res);
                },
                complete: function() {
                    loading = false;
                    $("#loader").hide();
                }
            });
        }

        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() + 200 >= $(document).height()) {
                loadMoreData();
            }
        });
    </script>
@endpush
