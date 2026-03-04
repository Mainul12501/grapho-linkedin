@extends('frontend.employee.master')

@section('title', 'My Profile Viewers')

@section('body')

    <!-- Mobile Back Header -->
    <section class="bg-white forSmall smallTop pv-mobile-back">
        <a href="{{ route('employee.my-profile') }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#141c25" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            {{ trans('employee.profiler_viewers') }}
        </a>
    </section>

    <!-- Main Content -->
    <div class="container container-main mt-md-5 mt-2">
        <!-- Left Side Menu -->
        @include('frontend.employee.jobs.left-menu')

        <!-- Right Content -->
        <section class="w-100 profileOptionRight pv-content">

            <!-- Page Header -->
            <div class="pv-page-header forLarge">
                <div class="pv-header-text">
                    <h1>{{ trans('employee.profiler_viewers') }}</h1>
                    <p>People who viewed your profile recently</p>
                </div>
                <div class="pv-header-count">
                    <span class="pv-count-number">{{ count($myProfileViewers) ?? 0 }}</span>
                    <span class="pv-count-label">Viewers</span>
                </div>
            </div>

            <!-- Mobile Subheader -->
            <div class="forSmall pv-mobile-subheader">
                <p>You have {{ count($myProfileViewers) ?? 0 }} profile {{ Str::plural('viewer', count($myProfileViewers)) }}</p>
            </div>

            <!-- Viewers List -->
            <div class="pv-list-wrap">
                <div class="pv-list" id="viewer-container">
                    @if(count($myProfileViewers) > 0)
                        @include('frontend.employee.base-functionalities.partials.profile-viewer-items', ['profileViewerIds' => $myProfileViewers])
                    @else
                        <div class="pv-empty-state">
                            <div class="pv-empty-icon">
                                <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#cfd2d9" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </div>
                            <h3>No profile views yet</h3>
                            <p>When employers view your profile, they'll appear here</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Infinite Scroll Loader -->
            <div id="loader" class="pv-loader" style="display:none;">
                <div class="pv-spinner"></div>
                <span>Loading more...</span>
            </div>

        </section>
    </div>

@endsection

@push('style')
    <style>
        /* ================================================
           PROFILE VIEWERS REDESIGN — Scoped with .pv- prefix
           ================================================ */

        .pv-mobile-back a {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            color: #141c25;
            padding: 16px 20px;
        }

        /* --- Sidebar Navigation (shared with saved-jobs) --- */
        .sj-sidebar {
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            border: 1px solid #f0f1f3;
            box-shadow: 0 1px 3px rgba(20,28,37,.04), 0 6px 16px rgba(20,28,37,.03);
            padding: 8px !important;
        }

        .sj-nav-link {
            border-radius: 10px !important;
            padding: 14px 16px !important;
            margin-bottom: 2px;
            transition: all .2s ease !important;
            text-decoration: none !important;
            border-bottom: none !important;
        }

        .sj-nav-link:hover {
            background: #f8f9fa !important;
        }

        .sj-nav-link .d-flex {
            gap: 14px;
        }

        .sj-nav-icon {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            border-radius: 10px;
            color: #667080;
            flex-shrink: 0;
            margin-right: 0 !important;
            transition: all .2s ease;
        }

        .sj-nav-link:hover .sj-nav-icon {
            background: #FFF8E1;
            color: #d4a017;
        }

        .sj-nav-link .text {
            font-weight: 500 !important;
            font-size: 15px !important;
            color: #484f5b !important;
        }

        .sj-nav-active {
            background: #FFFBEB !important;
            border-left: none !important;
        }

        .sj-nav-active .sj-nav-icon {
            background: #FFCB11 !important;
            color: #141c25 !important;
        }

        .sj-nav-active .text {
            font-weight: 700 !important;
            color: #141c25 !important;
        }

        /* --- Page Header --- */
        .pv-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f1f3;
        }

        .pv-header-text h1 {
            font-size: 26px;
            font-weight: 800;
            color: #141c25;
            margin: 0 0 4px;
            letter-spacing: -0.3px;
        }

        .pv-header-text p {
            font-size: 14px;
            color: #7c8391;
            margin: 0;
        }

        .pv-header-count {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #FFFBEB;
            border: 1px solid #FFECB3;
            border-radius: 14px;
            padding: 14px 22px;
            min-width: 80px;
        }

        .pv-count-number {
            font-size: 28px;
            font-weight: 800;
            color: #141c25;
            line-height: 1;
        }

        .pv-count-label {
            font-size: 12px;
            font-weight: 600;
            color: #9a8234;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }

        /* --- Mobile Subheader --- */
        .pv-mobile-subheader {
            padding: 0 4px;
            margin-bottom: 12px;
        }

        .pv-mobile-subheader p {
            font-size: 13px;
            color: #7c8391;
            margin: 0;
        }

        /* --- Viewers List --- */
        .pv-list-wrap {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #f0f1f3;
            box-shadow: 0 1px 3px rgba(20,28,37,.04), 0 6px 16px rgba(20,28,37,.03);
            overflow: hidden;
        }

        @keyframes pvFadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .pv-viewer-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            border-bottom: 1px solid #f5f6f7;
            transition: background .18s ease;
            animation: pvFadeUp .4s ease both;
        }

        .pv-viewer-card:last-child {
            border-bottom: none;
        }

        .pv-viewer-card:hover {
            background: #fafbfc;
        }

        .pv-viewer-link {
            display: flex;
            align-items: center;
            gap: 16px;
            text-decoration: none;
            flex: 1;
            min-width: 0;
        }

        .pv-viewer-avatar {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            overflow: hidden;
            flex-shrink: 0;
            background: #f3f4f6;
            border: 1px solid #eee;
        }

        .pv-viewer-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .pv-viewer-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 0;
        }

        .pv-viewer-name {
            font-size: 15px;
            font-weight: 650;
            color: #141c25;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pv-viewer-time {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            color: #8c919d;
        }

        .pv-viewer-action {
            flex-shrink: 0;
            margin-left: 12px;
        }

        .pv-visit-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            color: #484f5b;
            background: #f3f4f6;
            text-decoration: none;
            transition: all .2s ease;
            border: 1px solid transparent;
        }

        .pv-visit-btn:hover {
            background: #FFFBEB;
            color: #141c25;
            border-color: #FFECB3;
        }

        /* --- Empty State --- */
        .pv-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 72px 24px;
            text-align: center;
        }

        .pv-empty-icon {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            background: #f8f9fb;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .pv-empty-state h3 {
            font-size: 18px;
            font-weight: 700;
            color: #141c25;
            margin: 0 0 6px;
        }

        .pv-empty-state p {
            font-size: 14px;
            color: #8c919d;
            margin: 0;
        }

        /* --- Loader --- */
        .pv-loader {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 24px;
            color: #8c919d;
            font-size: 14px;
        }

        .pv-spinner {
            width: 20px;
            height: 20px;
            border: 2.5px solid #e8e9ec;
            border-top-color: #FFCB11;
            border-radius: 50%;
            animation: pvSpin .7s linear infinite;
        }

        @keyframes pvSpin {
            to { transform: rotate(360deg); }
        }

        /* ================================================
           RESPONSIVE
           ================================================ */

        @media (max-width: 768px) {
            .pv-page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .pv-list-wrap {
                border-radius: 12px;
                border: none;
                box-shadow: 0 1px 4px rgba(20,28,37,.06);
            }

            .pv-viewer-card {
                padding: 14px 16px;
            }

            .pv-viewer-avatar {
                width: 44px;
                height: 44px;
                border-radius: 10px;
            }

            .pv-viewer-link {
                gap: 12px;
            }

            .pv-viewer-name {
                font-size: 14px;
            }

            .pv-viewer-time {
                font-size: 12px;
            }

            .pv-visit-btn span {
                display: none;
            }

            .pv-visit-btn {
                padding: 8px 10px;
                border-radius: 8px;
            }

            .pv-empty-state {
                padding: 48px 20px;
            }
        }

        @media (max-width: 480px) {
            .pv-viewer-card {
                padding: 12px 14px;
            }

            .pv-viewer-avatar {
                width: 40px;
                height: 40px;
            }
        }
    </style>
@endpush

@push('script')
    <script>
        let page = 1;
        let loading = false;

        $(window).on('scroll', function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 150) {

                if (loading) return;
                loading = true;
                page++;

                $('#loader').show();

                $.get('?page=' + page, function (data) {
                    if (data.trim() === '') {
                        $('#loader').hide();
                        return;
                    }

                    $('#viewer-container').append(data);
                    loading = false;
                    $('#loader').hide();
                });
            }
        });
    </script>
@endpush
