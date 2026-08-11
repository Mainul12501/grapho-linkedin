@extends('frontend.employer.master')

@section('title', 'Employee Suggestions')

@section('body')
    <main class="dashboardContent p-3 p-md-4">
        <div class="container-fluid">
            <div class="row">
                <section class="col-xl-11 mx-auto">

                    <!-- Page Header -->
                    <div class="sg-header">
                        <div class="sg-header-left">
                            <h1 class="sg-title">Employee Suggestions</h1>
                            <p class="sg-subtitle">Discover top talent that matches your hiring needs</p>
                        </div>
                        <div class="sg-header-right">
                            <span class="sg-badge">
                                <i class="fa-solid fa-users"></i>
                                {{ $employees->total() }} candidates
                            </span>
                        </div>
                    </div>

                    <!-- Employee Cards Grid -->
                    <div class="row g-3">
                        @foreach($employees as $employee)
                            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                <a href="{{ route('employee-profile', $employee->id) }}" class="sg-card-link">
                                    <article class="talent-card sg-card">
                                        <div class="sg-card-top">
                                            <div class="sg-avatar-wrap">
                                                <img src="{{ asset($employee->profile_image ?? '/frontend/user-vector-img.jpg') }}"
                                                     alt="{{ $employee->name ?? 'Employee' }}"
                                                     class="sg-avatar talent-img" />
                                                <span class="sg-avatar-badge"><i class="fa-solid fa-briefcase"></i></span>
                                            </div>
                                            <div class="sg-info talent-details">
                                                <h6 class="sg-name">{{ $employee->name ?? trans('common.employee_name') }}</h6>
                                                <p class="sg-role">{{ $employee->profile_title ?? trans('employee.profile_title') }}</p>
                                                <span class="sg-location">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                    {!! str()->words($employee->address, 6) ?? trans('common.user_address') !!}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="sg-card-bottom talent-meta">
                                            <span class="sg-pill">
                                                <i class="fa-solid fa-clock"></i>
                                                {{ $employee?->employeeWorkExperiences[0]?->duration ?? 0 }}+ {{ trans('common.yrs') }}
                                            </span>
                                            <span class="sg-pill">
                                                <i class="fa-solid fa-graduation-cap"></i>
                                                {{ $employee?->employeeEducations[$employee->employeeEducations()->count() - 1]?->cgpa ?? 0.0 }} {{ trans('common.cgpa') }}
                                            </span>
                                        </div>
                                    </article>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="sg-pagination">
                        {{ $employees->links() }}
                    </div>

                </section>
            </div>
        </div>
    </main>

    <!-- Job Details Modal (preserved) -->
    <div class="modal" tabindex="-1" id="viewJobModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewJobModalTitle">{{ trans('common.view_job_post') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewJobModalBody">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .modal .job-type { margin-bottom: 10px; }

        /* =============================================
           Suggested Employees — Consistent with eh- system
           ============================================= */

        /* --- Header --- */
        .sg-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .sg-title {
            font-size: 24px;
            font-weight: 700;
            color: #0F172A;
            margin: 0;
            line-height: 1.2;
        }

        .sg-subtitle {
            font-size: 13px;
            color: #64748B;
            margin: 4px 0 0;
        }

        .sg-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #141C25;
            color: #FFCB11;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
        }

        .sg-badge i {
            font-size: 12px;
            color: #FFCB11;
        }

        /* --- Card --- */
        .sg-card-link {
            text-decoration: none !important;
            display: block;
            height: 100%;
        }

        .sg-card {
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 18px 14px;
            text-align: center;
            transition: transform .2s, box-shadow .2s, border-color .2s;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0;
        }

        .sg-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(15,23,42,.08);
            border-color: #FFCB11;
        }

        /* Card Top */
        .sg-card-top {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            width: 100%;
        }

        /* Avatar */
        .sg-avatar-wrap {
            position: relative;
            margin-bottom: 10px;
        }

        .sg-avatar {
            width: 64px !important;
            height: 64px !important;
            border-radius: 50% !important;
            object-fit: cover;
            border: 2.5px solid #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }

        .sg-avatar-badge {
            position: absolute;
            bottom: -2px;
            right: -4px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #FFCB11;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            color: #141C25;
            border: 2px solid #fff;
        }

        /* Info */
        .sg-info {
            width: 100%;
            min-width: 0;
        }

        .sg-name {
            font-size: 14px;
            font-weight: 700;
            color: #0F172A;
            margin: 0 0 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sg-role {
            font-size: 12px;
            color: #64748B;
            margin: 0 0 6px;
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 32px;
        }

        .sg-location {
            font-size: 11px;
            color: #94A3B8;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .sg-location i {
            font-size: 10px;
            color: #FFCB11;
        }

        /* Card Bottom — Stats */
        .sg-card-bottom {
            display: flex;
            gap: 6px;
            margin-top: 12px;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
        }

        .sg-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #F1F5F9 !important;
            border-radius: 20px !important;
            padding: 4px 10px !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            color: #475569 !important;
        }

        .sg-pill i {
            font-size: 10px;
            color: #94A3B8;
        }

        /* --- Pagination --- */
        .sg-pagination {
            padding: 24px 0 10px;
            display: flex;
            justify-content: center;
        }

        .sg-pagination .pagination {
            gap: 4px;
        }

        .sg-pagination .page-link {
            border-radius: 8px;
            border: 1px solid #E2E8F0;
            color: #0F172A;
            font-weight: 500;
            font-size: 14px;
            padding: 7px 13px;
            transition: all .2s;
        }

        .sg-pagination .page-link:hover {
            background: #FFCB11;
            border-color: #FFCB11;
            color: #141C25;
        }

        .sg-pagination .page-item.active .page-link {
            background: #141C25;
            border-color: #141C25;
            color: #FFCB11;
        }

        .sg-pagination .page-item.disabled .page-link {
            background: #F8FAFC;
            color: #CBD5E1;
            border-color: #E2E8F0;
        }

        /* =============================================
           Responsive
           ============================================= */

        @media (max-width: 991px) {
            .sg-title {
                font-size: 20px;
            }
        }

        @media (max-width: 767px) {
            .sg-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
                margin-bottom: 16px;
            }

            .sg-title {
                font-size: 18px;
            }

            .sg-badge {
                padding: 6px 12px;
                font-size: 12px;
            }

            .sg-card {
                padding: 14px 10px;
                border-radius: 12px;
            }

            .sg-avatar {
                width: 52px !important;
                height: 52px !important;
            }

            .sg-avatar-badge {
                width: 18px;
                height: 18px;
                font-size: 8px;
            }

            .sg-name {
                font-size: 13px;
            }

            .sg-role {
                font-size: 11px;
                min-height: 28px;
            }

            .sg-pill {
                padding: 3px 7px !important;
                font-size: 10px !important;
            }
        }

        @media (max-width: 575px) {
            .sg-card {
                padding: 12px 8px;
            }

            .sg-avatar {
                width: 44px !important;
                height: 44px !important;
            }

            .sg-name {
                font-size: 12px;
            }

            .sg-role {
                font-size: 10.5px;
                -webkit-line-clamp: 1;
                min-height: 14px;
                margin-bottom: 4px;
            }

            .sg-location {
                font-size: 10px;
            }

            .sg-card-bottom {
                margin-top: 8px;
            }

            .sg-pill {
                padding: 2px 6px !important;
                font-size: 9.5px !important;
                gap: 3px !important;
            }

            .sg-pill i {
                font-size: 8px;
            }
        }

        @media (max-width: 380px) {
            .col-6 {
                width: 50%;
            }
        }

        /* Job card responsive (preserved from original) */
        @media screen and (max-width: 529px) {
            .job-card {
                display: flex;
                flex-wrap: wrap;
                gap: 1rem;
                position: relative;
                padding-top: 2.5rem;
                justify-content: flex-start;
                align-items: flex-start;
            }
            .job-details { flex: 1 1 100%; min-width: 0; }
            .job-info { flex: 1 1 100%; min-width: 200px; }
            .job-actions { position: absolute; top: 37px; right: 1rem; margin-left: 0; }
        }

        @media screen and (max-width: 472px) {
            .job-card {
                flex-direction: column;
                position: relative;
                padding-top: 2.5rem;
                justify-content: flex-start;
                align-items: flex-start;
            }
            .job-actions { position: absolute; top: 37px; right: 1rem; }
        }
    </style>
@endpush

@push('script')
    <script>
        equalizeHeights('talent-card');
    </script>
    <script>
        function showJobDetails(jobId, jobTitle = 'View Job Title') {
            sendAjaxRequest('get-job-details/'+jobId+'?render=1&show_apply=0', 'GET').then(function (response) {
                $('#viewJobModalTitle').empty().append(jobTitle);
                $('#viewJobModalBody').empty().append(response);
                $('#viewJobModal').modal('show');
            })
        }
    </script>
@endpush
