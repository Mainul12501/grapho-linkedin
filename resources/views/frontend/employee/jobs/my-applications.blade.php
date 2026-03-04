@extends('frontend.employee.master')

@section('title', 'My Applications')

@section('body')

    <!-- Mobile Back Header -->
    <section class="bg-white forSmall smallTop ma-mobile-back">
        <a href="{{ route('employee.my-profile') }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#141c25" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            {{ trans('employee.my_applications') }}
        </a>
    </section>

    <!-- Main Content -->
    <div class="container container-main mt-md-5 mt-2">
        <!-- Left Side Menu -->
        @include('frontend.employee.jobs.left-menu')

        <!-- Right Content -->
        <section class="w-100 profileOptionRight ma-content">

            <!-- Page Header -->
            <div class="ma-page-header forLarge">
                <div class="ma-header-text">
                    <h1>{{ trans('employee.my_applications') }}</h1>
{{--                    <p>{{ trans('employee.you_have_applied_to_jobs', ['count' => count($myApplications) ?? 0]) }}</p>--}}
                </div>
                <div class="ma-header-count">
                    <span class="ma-count-number">{{ count($myApplications) ?? 0 }}</span>
                    <span class="ma-count-label">Applied</span>
                </div>
            </div>

            <!-- Mobile Subheader -->
            <div class="forSmall ma-mobile-subheader">
                <p>{{ trans('employee.you_have_applied_to_jobs', ['count' => count($myApplications) ?? 0]) }}</p>
            </div>

            <!-- Applications Table -->
            <div class="ma-table-wrap">
                <!-- Desktop Table Header -->
                <div class="ma-table-header">
                    <span class="ma-th-company">{{ trans('employee.company') }}</span>
                    <span class="ma-th-position">{{ trans('employee.position') }}</span>
                    <span class="ma-th-date">{{ trans('employee.applied_on') }}</span>
                    <span class="ma-th-status">{{ trans('common.status') }}</span>
                    <span class="ma-th-action">{{ trans('common.action') }}</span>
                </div>

                <!-- Applications List -->
                <div class="ma-table-body" id="job-container">
                    @if(count($myApplications) > 0)
                        @include('frontend.employee.jobs.partials.my-applications-items')
                    @else
                        <div class="ma-empty-state">
                            <div class="ma-empty-icon">
                                <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#cfd2d9" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            </div>
                            <h3>No applications yet</h3>
                            <p>{{ trans('employee.havent_applied_any_job') }}</p>
                            <a href="{{ route('employee.show-jobs') }}" class="ma-browse-btn">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                Browse Jobs
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Infinite Scroll Loader -->
            <div id="loader" class="ma-loader" style="display:none;">
                <div class="ma-spinner"></div>
                <span>Loading more...</span>
            </div>

        </section>
    </div>

    <!-- Job Details Modal -->
    <div class="modal fade" id="jobModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content ma-modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="jobDetailsBody">
                    <p>Loading job details...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <style>
        /* ================================================
           MY APPLICATIONS REDESIGN — Scoped with .ma- prefix
           ================================================ */

        .ma-mobile-back a {
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
        .ma-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            /*margin-bottom: 24px;*/
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f1f3;
        }

        .ma-page-header h1 {
            font-weight: 700;
            font-size: 26px;
            color: #141c25;
            letter-spacing: -0.5px;
            margin: 0 0 4px;
        }

        .ma-page-header p,
        .ma-mobile-subheader p {
            font-size: 14px;
            color: #667080;
            margin: 0;
        }

        .ma-mobile-subheader {
            padding: 0 4px 12px;
        }

        .ma-header-count {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #eff6ff;
            border: 1.5px solid #93c5fd;
            border-radius: 14px;
            padding: 12px 20px;
            min-width: 72px;
        }

        .ma-count-number {
            font-weight: 800;
            font-size: 24px;
            color: #141c25;
            line-height: 1;
            letter-spacing: -1px;
        }

        .ma-count-label {
            font-size: 11px;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }

        /* --- Table Wrapper --- */
        .ma-table-wrap {
            background: #fff;
            border: 1px solid #f0f1f3;
            border-radius: 14px;
            overflow: hidden;
        }

        /* Desktop Table Header */
        .ma-table-header {
            display: grid;
            grid-template-columns: 2fr 2fr 1.3fr 1.2fr 0.8fr;
            padding: 14px 24px;
            background: #f9fafb;
            border-bottom: 1px solid #f0f1f3;
        }

        .ma-table-header span {
            font-weight: 600;
            font-size: 12px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* --- Application Cards --- */
        .ma-app-card {
            border-bottom: 1px solid #f7f8f9;
            animation: maFadeUp .4s ease both;
        }

        .ma-app-card:last-child {
            border-bottom: none;
        }

        .ma-app-card:hover {
            background: #fafbfc;
        }

        @keyframes maFadeUp {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Desktop Row */
        .ma-row-desktop {
            display: grid;
            grid-template-columns: 2fr 2fr 1.3fr 1.2fr 0.8fr;
            align-items: center;
            padding: 16px 24px;
            gap: 12px;
        }

        .ma-row-mobile {
            display: none;
        }

        /* Company Column */
        .ma-company-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: inherit;
            transition: color .15s ease;
        }

        .ma-company-link:hover {
            color: #d4a017;
        }

        .ma-company-logo {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid #f0f1f3;
            flex-shrink: 0;
        }

        .ma-company-name {
            font-weight: 500;
            font-size: 14px;
            color: #484f5b;
        }

        /* Position Column */
        .ma-position-title {
            font-weight: 600;
            font-size: 14px;
            color: #141c25;
        }

        /* Date Column */
        .ma-col-date {
            font-size: 13px;
            color: #667080;
        }

        /* Status Badges */
        .ma-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 14px;
            border-radius: 100px;
            font-weight: 600;
            font-size: 12px;
            white-space: nowrap;
        }

        .ma-status-approved {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        .ma-status-pending {
            background: #FFFBEB;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .ma-status-shortlisted {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #93c5fd;
        }

        .ma-status-rejected {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        /* View Button */
        .ma-view-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 14px;
            background: transparent;
            color: #484f5b;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-weight: 500;
            font-size: 13px;
            cursor: pointer;
            transition: all .2s ease;
            text-decoration: none;
            white-space: nowrap;
        }

        .ma-view-btn:hover {
            border-color: #141c25;
            color: #141c25;
            background: #f9fafb;
        }

        /* --- Empty State --- */
        .ma-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 64px 24px;
            text-align: center;
        }

        .ma-empty-icon {
            width: 88px;
            height: 88px;
            background: #f9fafb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .ma-empty-state h3 {
            font-weight: 700;
            font-size: 18px;
            color: #141c25;
            margin: 0 0 6px;
        }

        .ma-empty-state p {
            font-size: 14px;
            color: #9ca3af;
            margin: 0 0 24px;
        }

        .ma-browse-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 24px;
            background: #141c25;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all .2s ease;
        }

        .ma-browse-btn:hover {
            background: #2d3748;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(20,28,37,.2);
        }

        /* --- Loader --- */
        .ma-loader {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 24px;
            color: #9ca3af;
            font-size: 14px;
            font-weight: 500;
        }

        .ma-spinner {
            width: 20px;
            height: 20px;
            border: 2.5px solid #f0f1f3;
            border-top-color: #FFCB11;
            border-radius: 50%;
            animation: maSpin .6s linear infinite;
        }

        @keyframes maSpin {
            to { transform: rotate(360deg); }
        }

        /* --- Job Details (loaded via AJAX from job-details.blade.php) --- */
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

        .sj-detail-logo-link {
            flex-shrink: 0;
        }

        .sj-detail-company-info {
            min-width: 0;
        }

        .sj-detail-company-name {
            font-size: 15px;
            font-weight: 650;
            color: #484f5b;
            margin: 0;
        }

        .sj-detail-company-name a {
            color: inherit;
            text-decoration: none;
        }

        .sj-detail-company-name a:hover {
            color: #141c25;
        }

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

        .sj-detail-section {
            margin-bottom: 20px;
        }

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

        .sj-detail-text p {
            color: #556070;
        }

        .sj-detail-list {
            padding-left: 20px;
            margin: 0;
        }

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
            .sj-detail-meta-grid {
                grid-template-columns: 1fr;
            }
        }

        /* --- Modal --- */
        .ma-modal-content {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: 0 16px 48px rgba(20,28,37,.16) !important;
        }

        .ma-modal-content .modal-header {
            border-bottom: 1px solid #f0f1f3;
            padding: 18px 24px;
        }

        .ma-modal-content .modal-body {
            padding: 24px;
        }

        .ma-modal-content .modal-footer {
            border-top: 1px solid #f0f1f3;
            padding: 16px 24px;
        }

        .ma-modal-content .modal-footer .btn-secondary {
            border-radius: 10px;
            padding: 8px 20px;
            font-weight: 500;
            border-color: #e5e7eb;
        }

        /* --- Responsive --- */
        @media (max-width: 768px) {
            .ma-table-header {
                display: none;
            }

            .ma-row-desktop {
                display: none !important;
            }

            .ma-row-mobile {
                display: block;
                padding: 16px 18px;
            }

            .ma-mobile-top {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 10px;
                margin-bottom: 12px;
            }

            .ma-mobile-company-link {
                display: flex;
                align-items: center;
                gap: 12px;
                text-decoration: none;
                color: inherit;
                min-width: 0;
            }

            .ma-mobile-company-link .ma-company-logo {
                width: 44px;
                height: 44px;
                border-radius: 12px;
            }

            .ma-mobile-info {
                display: flex;
                flex-direction: column;
                min-width: 0;
            }

            .ma-mobile-info .ma-position-title {
                font-size: 15px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .ma-mobile-info .ma-company-name {
                font-size: 13px;
            }

            .ma-mobile-bottom {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding-top: 12px;
                border-top: 1px solid #f7f8f9;
            }

            .ma-mobile-date {
                display: flex;
                align-items: center;
                gap: 5px;
                font-size: 12px;
                color: #9ca3af;
            }

            .ma-mobile-date svg {
                color: #cfd2d9;
            }

            .ma-content {
                padding: 0 !important;
            }

            .ma-table-wrap {
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            .ma-app-card {
                border-bottom: 1px solid #f0f1f3;
            }

            .ma-empty-state {
                padding: 48px 20px;
            }

            .ma-view-btn {
                font-size: 12px;
                padding: 6px 12px;
            }

            .ma-status-badge {
                font-size: 11px;
                padding: 4px 10px;
            }
        }

        @media (min-width: 769px) and (max-width: 1100px) {
            .ma-row-desktop {
                grid-template-columns: 1.8fr 1.8fr 1.2fr 1fr 0.8fr;
            }

            .ma-table-header {
                grid-template-columns: 1.8fr 1.8fr 1.2fr 1fr 0.8fr;
            }
        }
    </style>
@endpush

@push('script')
    <script>
        // View Job in modal
        $(document).on('click', '.view-job', function () {
            event.preventDefault();
            var jobId = $(this).attr('data-job-id');
            $.ajax({
                url: "/get-job-details/" + jobId + "?render=1",
                method: "GET",
                success: function (response) {
                    console.log(response);
                    $('#jobDetailsBody').empty().append(response);
                    $('#jobModal').modal('show');
                }
            })
        })
    </script>

    <script>
        // Infinite scroll pagination
        let page = 1;
        let loading = false;

        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
                if (!loading) {
                    loading = true;
                    page++;

                    $('#loader').show();

                    $.get('?page=' + page, function (data) {
                        if (data.trim().length === 0) {
                            $('#loader').hide();
                            return;
                        }

                        $('#job-container').append(data);
                        loading = false;
                        $('#loader').hide();
                    });
                }
            }
        });
    </script>
@endpush
