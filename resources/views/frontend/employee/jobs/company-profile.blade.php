@extends('frontend.employee.master')

@section('title', $employerCompany->name ?? 'Company Profile')

@section('body')
    <main class="cp-main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-11 mx-auto">

                    <!-- Back Button -->
                    <div class="cp-back-row">
                        <a href="{{ url()->previous() }}" class="cp-back-btn">
                            <i class="fa-solid fa-arrow-left"></i>
                            <span>Back</span>
                        </a>
                    </div>

                    <!-- Company Header Card -->
                    <div class="cp-header-card">
                        <div class="cp-cover">
                            <div class="cp-cover-overlay"></div>
                        </div>
                        <div class="cp-header-body">
                            <div class="cp-logo-wrap">
                                <img src="{{ asset($employerCompany->logo ?? '/frontend/company-vector.jpg') }}"
                                     alt="{{ $employerCompany->name ?? 'Company' }}"
                                     class="cp-logo" />
                            </div>
                            <div class="cp-header-info">
                                <h1 class="cp-company-name">{{ $employerCompany->name ?? 'Company Name' }}</h1>
                                @if($employerCompany?->industry?->name)
                                    <span class="cp-industry">
                                        <i class="fa-solid fa-building"></i>
                                        {{ $employerCompany->industry->name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 g-lg-4">

                        <!-- Left Sidebar: Company Info -->
                        <div class="col-lg-4 col-md-5">

                            <!-- Contact Card -->
                            <div class="cp-card cp-contact-card">
                                <h6 class="cp-card-title">Contact Information</h6>

                                @if($employerCompany->address)
                                    <div class="cp-contact-item">
                                        <div class="cp-contact-icon">
                                            <i class="fa-solid fa-location-dot"></i>
                                        </div>
                                        <div class="cp-contact-body">
                                            <span class="cp-contact-label">Location</span>
                                            <span class="cp-contact-value">{{ $employerCompany->address }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if($employerCompany->email)
                                    <div class="cp-contact-item">
                                        <div class="cp-contact-icon">
                                            <i class="fa-solid fa-envelope"></i>
                                        </div>
                                        <div class="cp-contact-body">
                                            <span class="cp-contact-label">Email</span>
                                            <a href="mailto:{{ $employerCompany->email }}" class="cp-contact-value cp-contact-link">{{ $employerCompany->email }}</a>
                                        </div>
                                    </div>
                                @endif

                                @if($employerCompany->phone)
                                    <div class="cp-contact-item">
                                        <div class="cp-contact-icon">
                                            <i class="fa-solid fa-phone"></i>
                                        </div>
                                        <div class="cp-contact-body">
                                            <span class="cp-contact-label">Phone</span>
                                            <span class="cp-contact-value">{{ $employerCompany->phone }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if($employerCompany->website)
                                    <div class="cp-contact-item">
                                        <div class="cp-contact-icon">
                                            <i class="fa-solid fa-globe"></i>
                                        </div>
                                        <div class="cp-contact-body">
                                            <span class="cp-contact-label">Website</span>
                                            <a href="{{ $employerCompany->website }}" target="_blank" class="cp-contact-value cp-contact-link">{{ $employerCompany->website }}</a>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Quick Stats -->
                            <div class="cp-card cp-stats-card">
                                <div class="cp-stat-row">
                                    <div class="cp-stat">
                                        <div class="cp-stat-icon"><i class="fa-solid fa-users"></i></div>
                                        <div>
                                            <span class="cp-stat-value">{{ $employerCompany->total_employees ?? '—' }}</span>
                                            <span class="cp-stat-label">{{ trans('employer.total_employees') }}</span>
                                        </div>
                                    </div>
                                    <div class="cp-stat">
                                        <div class="cp-stat-icon"><i class="fa-solid fa-calendar"></i></div>
                                        <div>
                                            <span class="cp-stat-value">{{ $employerCompany->founded_on ?? '—' }}</span>
                                            <span class="cp-stat-label">{{ trans('employer.founded_on') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Content -->
                        <div class="col-lg-8 col-md-7">

                            <!-- About Section -->
                            @if($employerCompany->company_overview)
                                <div class="cp-card cp-about-card">
                                    <h6 class="cp-card-title">{{ trans('employer.company_overview') }}</h6>
                                    <div class="cp-about-text">
                                        <div id="short-overview">
                                            {!! str()->words($employerCompany->company_overview, 80, '<span id="show-full-btn" class="cp-view-toggle">... View all</span>') !!}
                                        </div>
                                        <div id="long-overview" style="display: none;">
                                            {!! $employerCompany->company_overview !!}
                                            <span id="show-less-btn" class="cp-view-toggle">View less</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Activities Section -->
                            <div class="cp-section-header">
                                <h5 class="cp-section-title">
                                    <i class="fa-solid fa-chart-line"></i>
                                    Activities
                                </h5>
                            </div>

                            <div id="item-container">
                                @if(isset($paginatedData))
                                    @include('frontend.employer.home.activity-content')
                                @endif

                                <div id="loader" class="cp-loader" style="display:none;">
                                    <div class="cp-spinner"></div>
                                    <span>Loading more...</span>
                                </div>
                                <div id="no-more-data" class="cp-no-more" style="display:none;">
                                    No more results
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('modal')
    <!-- View Job Modal -->
    <div class="modal fade" id="viewJobModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content cp-modal">
                <div class="modal-header cp-modal-header">
                    <h5 class="modal-title cp-modal-title" id="viewJobModalTitle">{{ trans('common.view_job_post') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body cp-modal-body" id="viewJobModalBody">
                    <p>Loading...</p>
                </div>
                <div class="modal-footer cp-modal-footer">
                    <button type="button" class="btn cp-btn-close" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Post Modal -->
    <div class="modal fade" id="viewPostModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content cp-modal">
                <div class="modal-header cp-modal-header">
                    <h5 class="modal-title cp-modal-title" id="viewPostModalTitle">View Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body cp-modal-body" id="viewPostModalBody">
                    <p>Loading...</p>
                </div>
                <div class="modal-footer cp-modal-footer">
                    <button type="button" class="btn cp-btn-close" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('/frontend/employer/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/zoom-plugin/mbox.css') }}">
    <style>
        /* =============================================
           Company Profile — cp- design system
           ============================================= */

        .cp-main {
            padding: 16px 0 40px;
            min-height: 100vh;
            background: #F8FAFC;
        }

        /* --- Back Button --- */
        .cp-back-row { margin-bottom: 16px; }

        .cp-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #0F172A;
            text-decoration: none;
            transition: all .2s;
            font-family: 'Geist', sans-serif;
        }
        .cp-back-btn:hover { background: #141C25; border-color: #141C25; color: #fff!important; }
        .cp-back-btn:hover i, .cp-back-btn:hover span { color: white!important; }
        .cp-back-btn i { font-size: 12px; }


        /* --- Header Card --- */
        .cp-header-card {
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .cp-cover {
            height: 120px;
            /*background: linear-gradient(135deg, #141C25 0%, #1e293b 50%, #0f172a 100%);*/
            background: #FFCB11;
            position: relative;
        }

        .cp-cover-overlay {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 50%, rgba(255,203,17,.12) 0%, transparent 50%),
                radial-gradient(circle at 80% 30%, rgba(255,203,17,.08) 0%, transparent 40%);
        }

        .cp-header-body {
            padding: 0 24px 20px;
            display: flex;
            align-items: flex-end;
            gap: 18px;
            margin-top: -36px;
            position: relative;
            z-index: 1;
        }

        .cp-logo-wrap {
            flex-shrink: 0;
        }

        .cp-logo {
            width: 72px;
            height: 72px;
            border-radius: 14px;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,.1);
            background: #fff;
        }

        .cp-header-info {
            padding-bottom: 2px;
            min-width: 0;
        }

        .cp-company-name {
            font-size: 22px;
            font-weight: 700;
            color: #0F172A;
            margin: 0 0 4px;
            line-height: 1.3;
        }

        .cp-industry {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #64748B;
            font-weight: 500;
        }
        .cp-industry i { font-size: 11px; color: #94A3B8; }


        /* --- Generic Card --- */
        .cp-card {
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 16px;
        }

        .cp-card-title {
            font-size: 14px;
            font-weight: 700;
            color: #0F172A;
            margin: 0 0 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #F1F5F9;
        }


        /* --- Contact Card --- */
        .cp-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #F8FAFC;
        }
        .cp-contact-item:last-child { border-bottom: none; padding-bottom: 0; }
        .cp-contact-item:first-of-type { padding-top: 0; }

        .cp-contact-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: #64748B;
            flex-shrink: 0;
        }

        .cp-contact-body {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .cp-contact-label {
            font-size: 11px;
            font-weight: 600;
            color: #94A3B8;
            text-transform: uppercase;
            letter-spacing: .4px;
            margin-bottom: 2px;
        }

        .cp-contact-value {
            font-size: 13px;
            color: #0F172A;
            font-weight: 500;
            word-break: break-word;
        }

        .cp-contact-link {
            color: #141C25;
            text-decoration: none;
            transition: color .15s;
        }
        .cp-contact-link:hover { color: #FFCB11; }


        /* --- Stats Card --- */
        .cp-stats-card { padding: 16px 20px; }

        .cp-stat-row {
            display: flex;
            gap: 16px;
        }

        .cp-stat {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            background: #F8FAFC;
            border-radius: 10px;
            border: 1px solid #F1F5F9;
        }

        .cp-stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            /*background: #141C25;*/
            background: #FFCB11;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            /*color: #FFCB11;*/
            flex-shrink: 0;
        }

        .cp-stat-value {
            display: block;
            font-size: 15px;
            font-weight: 700;
            color: #0F172A;
            line-height: 1.2;
        }

        .cp-stat-label {
            display: block;
            font-size: 11px;
            color: #94A3B8;
            font-weight: 500;
        }


        /* --- About Card --- */
        .cp-about-card { margin-bottom: 20px; }

        .cp-about-text {
            font-size: 14px;
            color: #475569;
            line-height: 1.7;
            word-break: break-word;
        }
        .cp-about-text p { margin-bottom: 10px; color: #475569; }
        .cp-about-text p:last-child { margin-bottom: 0; }

        .cp-view-toggle {
            color: #FFCB11;
            font-weight: 700;
            cursor: pointer;
            transition: color .15s;
            font-size: 13px;
        }
        .cp-view-toggle:hover { color: #D4A500; }


        /* --- Section Header --- */
        .cp-section-header {
            margin-bottom: 16px;
        }

        .cp-section-title {
            font-size: 16px;
            font-weight: 700;
            color: #0F172A;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .cp-section-title i { font-size: 14px; color: #FFCB11; }


        /* --- Loader & No More --- */
        .cp-loader {
            text-align: center;
            padding: 24px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 13px;
            color: #94A3B8;
        }

        .cp-spinner {
            width: 20px;
            height: 20px;
            border: 2.5px solid #E2E8F0;
            border-top-color: #FFCB11;
            border-radius: 50%;
            animation: cp-spin .7s linear infinite;
        }

        @keyframes cp-spin {
            to { transform: rotate(360deg); }
        }

        .cp-no-more {
            text-align: center;
            padding: 20px 0;
            font-size: 13px;
            color: #CBD5E1;
        }


        /* --- Modal Styles --- */
        .cp-modal { border: none; border-radius: 16px; overflow: hidden; }
        .cp-modal-header { border-bottom: 1px solid #F1F5F9; padding: 18px 24px; }
        .cp-modal-title { font-size: 16px; font-weight: 700; color: #0F172A; }
        .cp-modal-body { padding: 24px; max-height: 70vh; overflow-y: auto; }
        .cp-modal-footer { border-top: 1px solid #F1F5F9; padding: 14px 24px; }

        .cp-btn-close {
            background: #F1F5F9;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            transition: all .2s;
            font-family: 'Geist', sans-serif;
        }
        .cp-btn-close:hover { background: #E2E8F0; color: #0F172A; }


        /* =============================================
           Responsive
           ============================================= */

        @media (max-width: 991px) {
            .cp-company-name { font-size: 20px; }
            .cp-cover { height: 100px; }
        }

        @media (max-width: 767px) {
            .cp-main { padding: 12px 0 30px; }

            .cp-header-card { margin-bottom: 16px; }
            .cp-cover { height: 80px; }
            .cp-header-body {
                padding: 0 16px 16px;
                margin-top: -28px;
                gap: 12px;
            }
            .cp-logo {
                width: 58px;
                height: 58px;
                border-radius: 12px;
            }
            .cp-company-name { font-size: 18px; }
            .cp-industry { font-size: 12px; }

            .cp-card { padding: 16px; border-radius: 12px; }
            .cp-card-title { font-size: 13px; margin-bottom: 12px; padding-bottom: 10px; }

            .cp-contact-icon { width: 30px; height: 30px; font-size: 12px; }
            .cp-contact-item { gap: 10px; padding: 8px 0; }

            .cp-stat-row { gap: 10px; }
            .cp-stat { padding: 8px 10px; gap: 8px; }
            .cp-stat-icon { width: 32px; height: 32px; font-size: 12px; }
            .cp-stat-value { font-size: 14px; }

            .cp-section-title { font-size: 15px; }

            .cp-back-btn { padding: 6px 12px; font-size: 12px; }

            .cp-modal-header { padding: 14px 18px; }
            .cp-modal-body { padding: 18px; }
            .cp-modal-footer { padding: 12px 18px; }
        }

        @media (max-width: 575px) {
            .cp-header-body {
                flex-direction: column;
                align-items: flex-start;
                padding: 0 14px 14px;
                margin-top: -24px;
                gap: 8px;
            }
            .cp-logo {
                width: 52px;
                height: 52px;
                border-radius: 10px;
            }
            .cp-company-name { font-size: 17px; }

            .cp-stat-row { flex-direction: column; gap: 8px; }

            .cp-about-text { font-size: 13px; }
        }
    </style>
@endpush

@push('script')
    <script src="{{ asset('frontend/zoom-plugin/mbox.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.zoom-img').mBox();
        });
    </script>

    {{-- Show/Hide overview --}}
    <script>
        $(document).on('click', '#show-full-btn', function () {
            $('#short-overview').css('display', 'none');
            $('#long-overview').css('display', 'block');
        });
        $(document).on('click', '#show-less-btn', function () {
            $('#short-overview').css('display', 'block');
            $('#long-overview').css('display', 'none');
        });
    </script>

    {{-- Job & Post detail modals --}}
    <script>
        function showJobDetails(jobId, jobTitle) {
            jobTitle = jobTitle || 'View Job Title';
            sendAjaxRequest('get-job-details/'+jobId+'?render=1&show_apply=1', 'GET').then(function (response) {
                $('#viewJobModalTitle').empty().append(jobTitle);
                $('#viewJobModalBody').empty().append(response);
                $('#viewJobModal').modal('show');
            });
        }

        function showPostDetails(postId, postTitle) {
            postTitle = postTitle || 'View Post';
            sendAjaxRequest('employee-view-post/'+postId+'?render=1', 'GET').then(function (response) {
                $('#viewPostModalTitle').empty().append(postTitle);
                $('#viewPostModalBody').empty().append(response);
                $('.zoom-img').mBox();
                $('#viewPostModal').modal('show');
            });
        }

        // Post click handler (for .ed-post-click links in activity-content partial)
        $(document).on('click', '.ed-post-click', function(e) {
            e.preventDefault();
            var postId = $(this).data('post-id');
            var postTitle = $(this).data('post-title') || 'View Post';
            showPostDetails(postId, postTitle);
        });
    </script>

    {{-- Infinite scroll pagination --}}
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
                url: "?page=" + page + "&view=employer&employer_id={{ $companyDetails->id }}",
                type: "GET",
                success: function(res) {
                    if (res.empty) {
                        if (!$(".no-activity").length) {
                            $("#item-container").append(res.html);
                        }
                        $("#no-more-data").show();
                        page = lastPage;
                        return;
                    }
                    $("#item-container").append(res.html);
                    // Re-initialize zoom plugin for new images
                    $('.zoom-img').mBox();
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
