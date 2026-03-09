@extends('frontend.employee.master')

@section('title', 'My Saved Jobs')

@section('body')

    <!-- Mobile Back Header -->
    <section class="bg-white forSmall smallTop sj-mobile-back">
        <a href="{{ route('employee.my-profile') }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#141c25" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            {{ trans('employee.jobs_saved') }}
        </a>
    </section>

    <!-- Main Content -->
    <div class="container container-main mt-md-5 mt-2">
        <!-- Left Side Menu -->
        @include('frontend.employee.jobs.left-menu')

        <!-- Right Content -->
        <section class="w-100 profileOptionRight sj-content">

            <!-- Page Header -->
            <div class="sj-page-header forLarge">
                <div class="sj-header-text">
                    <h1>{{ trans('employee.jobs_saved') }}</h1>
{{--                    <p>{{ trans('employee.you_have_applied_to_jobs', ['count' => count($savedJobs) ?? 0]) }}</p>--}}
                </div>
                <div class="sj-header-count">
                    <span class="sj-count-number">{{ count($savedJobs) ?? 0 }}</span>
                    <span class="sj-count-label">Saved</span>
                </div>
            </div>

            <!-- Mobile subheader -->
            <div class="forSmall sj-mobile-subheader">
{{--                <p>{{ trans('employee.you_have_applied_to_jobs', ['count' => count($savedJobs) ?? 0]) }}</p>--}}
            </div>

            <!-- Job Cards -->
            <div class="sj-jobs-list">
                @forelse($savedJobs as $key => $savedJob)
                    <div class="sj-job-card" style="animation-delay: {{ $key * 0.04 }}s">
                        <!-- Card Top Row -->
                        <div class="sj-card-main">
                            <div class="sj-company-logo">
                                <img src="{{ asset(isset($savedJob?->employerCompany?->logo) ? $savedJob?->employerCompany?->logo : '/frontend/company-vector.jpg') }}" alt="Company Logo" />
                            </div>
                            <div class="sj-card-body">
                                <div class="sj-card-top">
                                    <div class="sj-card-info">
                                        <h3 class="sj-job-title">
                                            <a href="{{ route('employee.show-jobs', ['job_task' => $savedJob->id]) }}">{{ $savedJob->job_title ?? trans('common.job_title') }}</a>
                                        </h3>
                                        <p class="sj-company-name">{{ $savedJob->employerCompany?->name ?? trans('common.company_name') }}</p>
                                    </div>
                                    <button class="sj-remove-btn closeIcon" data-job-id="{{ $savedJob->id }}" title="Remove saved job">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    </button>
                                </div>

                                <!-- Tags -->
                                <div class="sj-tags">
                                    @if($savedJob?->jobType?->name)
                                        <span class="sj-tag">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                            {{ $savedJob->jobType->name }}
                                        </span>
                                    @endif
                                    @if($savedJob?->jobLocationType?->name)
                                        <span class="sj-tag">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                            {{ $savedJob->jobLocationType->name }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Details -->
                                <div class="sj-details">
                                    @if($savedJob?->employerCompany?->address)
                                        <div class="sj-detail-item">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                            <span>{{ $savedJob->employerCompany->address }}</span>
                                        </div>
                                    @endif
                                    <div class="sj-detail-item">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span>{{ $savedJob->required_experience ?? 0 }}+ {{ trans('employee.years_of_experience') }}</span>
                                    </div>
                                    <div class="sj-detail-item sj-salary">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                        @if(isset($savedJob->salary_range_start))
                                            <span>{{ trans('employee.salary') }}: Tk. {{ $savedJob->salary_range_start }} - {{ $savedJob->salary_range_end }}</span>
                                        @else
                                            <span>{{ trans('employee.salary') }}: {{ $savedJob->job_pref_salary_payment_type }} Tk. {{ $savedJob->salary_amount }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="sj-actions">
                                    @if(!\App\Helpers\ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
                                        @if(!$savedJob['isApplied']['isApplied'])
                                            <form action="{{ route('employee.apply-job', $savedJob->id) }}" method="post" class="sj-apply-form">
                                                @csrf
                                                <button type="submit" class="sj-apply-btn show-apply-model" data-job-id="{{ $savedJob->id }}" data-job-company-logo="{{ asset($savedJob?->employerCompany?->logo) ?? '' }}">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                                                    {{ trans('employee.easy_apply') }}
                                                </button>
                                            </form>
                                        @else
                                            <span class="sj-applied-badge">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                                Applied
                                            </span>
                                        @endif
                                    @endif
                                    <a href="{{--{{ route('employee.show-jobs', ['job_task' => $savedJob->id]) }}--}}" onclick="event.preventDefault(); showJobDetails({{ $savedJob->id }}, `{{ $savedJob->job_title }}`)" class="sj-view-btn">
                                        View Details
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="sj-empty-state">
                        <div class="sj-empty-icon">
                            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#cfd2d9" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                        </div>
                        <h3>No saved jobs yet</h3>
                        <p>{{ trans('employee.havent_applied_any_job') }}</p>
                        <a href="{{ route('employee.show-jobs') }}" class="sj-browse-btn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            Browse Jobs
                        </a>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    <!-- Easy Apply Modal -->
    <div class="easy-apply-modal" id="easyApplyModal">
        <div class="modal-content sj-apply-modal-content">
            <div class="modal-header">
                <div>
                    <div class="images-container">
                        <img src="{{ asset(auth()->user()->profile_image ?? '/frontend/user-vector-img.jpg') }}" alt="Your Profile" class="user-image" />
                        <div class="arrow-icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                        <img src="" alt="Company Logo" class="company-image" />
                    </div>
                </div>
                <h2>{{ trans('common.share_your_profile') }}</h2>
            </div>
            <p class="modal-description">{{ trans('common.to_apply_share_profile') }}</p>
            <div class="modal-buttons">
                <form action="" method="post" id="applyShareForm">
                    @csrf
                    <button class="share-profile-btn w-100 mb-2" type="submit">{{ trans('common.share_my_profile') }}</button>
                </form>
                <button class="cancel-btn w-100" style="background-color: #0d6efd !important; color: white !important;" onclick="closeEasyApplyModal()">{{ trans('common.cancel') }}</button>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    <div class="modal fade" id="closeConfirmModal" tabindex="-1" aria-labelledby="closeConfirmLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title" id="closeConfirmLabel">{{ trans('common.are_you_sure') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Do you really want to close this job suggestion?
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('common.no') }}</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ trans('common.yes') }}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- View Job Modal --}}
    <div class="modal eh-view-modal" tabindex="-1" id="viewJobModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewJobModalTitle">View Job</h5>
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
        /* ================================================
           SAVED JOBS REDESIGN — Scoped with .sj- prefix
           ================================================ */

        .sj-mobile-back a {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            color: #141c25;
            padding: 16px 20px;
        }

        /* --- Sidebar Navigation --- */
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
        .sj-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            /*margin-bottom: 24px;*/
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f1f3;
        }

        .sj-page-header h1 {
            font-weight: 700;
            font-size: 26px;
            color: #141c25;
            letter-spacing: -0.5px;
            margin: 0 0 4px;
        }

        .sj-page-header p,
        .sj-mobile-subheader p {
            font-size: 14px;
            color: #667080;
            margin: 0;
        }

        .sj-mobile-subheader {
            padding: 0 4px 12px;
        }

        .sj-header-count {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #FFFBEB;
            border: 1.5px solid #FFCB11;
            border-radius: 14px;
            padding: 12px 20px;
            min-width: 72px;
        }

        .sj-count-number {
            font-weight: 800;
            font-size: 24px;
            color: #141c25;
            line-height: 1;
            letter-spacing: -1px;
        }

        .sj-count-label {
            font-size: 11px;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }

        /* --- Job Cards --- */
        .sj-jobs-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .sj-job-card {
            background: #fff;
            border: 1px solid #f0f1f3;
            border-radius: 14px;
            padding: 22px 24px;
            transition: all .25s ease;
            animation: sjFadeUp .4s ease both;
        }

        .sj-job-card:hover {
            border-color: #e5e7eb;
            box-shadow: 0 4px 16px rgba(20,28,37,.06);
        }

        @keyframes sjFadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .sj-card-main {
            display: flex;
            gap: 18px;
        }

        .sj-company-logo {
            flex-shrink: 0;
        }

        .sj-company-logo img {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            object-fit: cover;
            border: 1px solid #f0f1f3;
        }

        .sj-card-body {
            flex: 1;
            min-width: 0;
        }

        .sj-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }

        .sj-card-info {
            min-width: 0;
        }

        .sj-job-title {
            font-weight: 600;
            font-size: 17px;
            margin: 0 0 3px;
            line-height: 1.35;
        }

        .sj-job-title a {
            color: #141c25;
            text-decoration: none;
            transition: color .15s ease;
        }

        .sj-job-title a:hover {
            color: #d4a017;
        }

        .sj-company-name {
            font-size: 14px;
            color: #667080;
            margin: 0;
        }

        /* Remove Button */
        .sj-remove-btn {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: none;
            border: 1.5px solid #f0f1f3;
            border-radius: 10px;
            color: #9ca3af;
            cursor: pointer;
            transition: all .2s ease;
        }

        .sj-remove-btn:hover {
            background: #fef2f2;
            border-color: #fecaca;
            color: #ef4444;
        }

        /* Tags */
        .sj-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
        }

        .sj-tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            background: #f3f4f6;
            border-radius: 100px;
            font-size: 12.5px;
            font-weight: 500;
            color: #484f5b;
        }

        .sj-tag svg {
            color: #9ca3af;
        }

        /* Details */
        .sj-details {
            display: flex;
            flex-wrap: wrap;
            gap: 6px 20px;
            margin-top: 12px;
        }

        .sj-detail-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #667080;
        }

        .sj-detail-item svg {
            color: #9ca3af;
            flex-shrink: 0;
        }

        .sj-salary {
            font-weight: 600;
            color: #141c25;
        }

        /* Actions */
        .sj-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1px solid #f7f8f9;
        }

        .sj-apply-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 20px;
            background: #FFCB11;
            color: #141c25;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .sj-apply-btn:hover {
            background: #e6b70f;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255,203,17,.3);
        }

        .sj-applied-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 8px 16px;
            background: #ecfdf5;
            color: #059669;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            border: 1px solid #a7f3d0;
        }

        .sj-view-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 9px 16px;
            background: transparent;
            color: #484f5b;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-weight: 500;
            font-size: 13px;
            cursor: pointer;
            transition: all .2s ease;
            text-decoration: none;
        }

        .sj-view-btn:hover {
            border-color: #141c25;
            color: #141c25;
            background: #f9fafb;
        }

        /* --- Empty State --- */
        .sj-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 64px 24px;
            text-align: center;
            background: #fff;
            border: 1px solid #f0f1f3;
            border-radius: 14px;
        }

        .sj-empty-icon {
            width: 88px;
            height: 88px;
            background: #f9fafb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .sj-empty-state h3 {
            font-weight: 700;
            font-size: 18px;
            color: #141c25;
            margin: 0 0 6px;
        }

        .sj-empty-state p {
            font-size: 14px;
            color: #9ca3af;
            margin: 0 0 24px;
        }

        .sj-browse-btn {
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

        .sj-browse-btn:hover {
            background: #2d3748;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(20,28,37,.2);
        }

        /* --- Easy Apply Modal --- */
        .sj-apply-modal-content {
            border-radius: 20px !important;
            padding: 32px !important;
            max-width: 380px !important;
        }

        .images-container {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: 1.5rem;
            height: 100px;
        }

        .user-image {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            background-color: white;
            position: relative;
            z-index: 3;
            box-shadow: 0 2px 12px rgba(0,0,0,.08);
        }

        .company-image {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid white;
            background-color: white;
            position: relative;
            z-index: 1;
            margin-left: -25px;
            box-shadow: 0 2px 12px rgba(0,0,0,.08);
        }

        .arrow-icon {
            background-color: #FFCB11;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #000;
            position: absolute;
            z-index: 4;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            border: 2.5px solid white;
        }

        .easy-apply-modal .modal-description {
            text-align: center;
            color: #667080;
            margin-bottom: 1.5rem;
            font-size: 14px;
            line-height: 1.6;
        }

        .share-profile-btn {
            background: #FFCB11 !important;
            border: none;
            color: #141c25 !important;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.2s;
        }

        .share-profile-btn:hover {
            background: #e6b70f !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255,203,17,.3);
        }

        .easy-apply-modal .cancel-btn {
            background: transparent !important;
            border: 1.5px solid #e5e7eb !important;
            color: #484f5b !important;
            padding: 11px;
            border-radius: 12px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s;
        }

        .easy-apply-modal .cancel-btn:hover {
            border-color: #141c25 !important;
            color: #141c25 !important;
            background: #f9fafb !important;
        }

        .easy-apply-modal .modal-buttons button:hover {
            color: inherit;
        }

        /* SweetAlert theme */
        .swal2-confirm { background-color: #FFCB11 !important; color: #141c25 !important; border-radius: 10px !important; }
        .swal2-cancel { background-color: #f3f4f6 !important; color: #484f5b !important; border-radius: 10px !important; }

        .modal .job-type { margin-bottom: 10px; }

        /* --- View Job Modal --- */
        .eh-view-modal .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        }
        .eh-view-modal .modal-header {
            border-bottom: 1px solid #E5E7EB;
            padding: 18px 24px;
        }
        .eh-view-modal .modal-title {
            font-weight: 700;
            font-size: 18px;
            color: #111827;
        }
        .eh-view-modal .modal-body {
            padding: 24px;
            max-height: 70vh;
            overflow-y: auto;
        }
        .eh-view-modal .modal-footer {
            border-top: 1px solid #E5E7EB;
            padding: 14px 24px;
        }
        .eh-view-modal .modal-footer .btn-secondary {
            border-radius: 8px;
            font-weight: 600;
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

        /* --- Responsive --- */
        @media (max-width: 768px) {
            .sj-sidebar {
                display: none;
            }

            .sj-content {
                padding: 0 !important;
            }

            .sj-page-header {
                padding: 0 16px 16px;
            }

            .sj-jobs-list {
                gap: 8px;
                padding: 0 4px;
            }

            .sj-job-card {
                padding: 16px;
                border-radius: 12px;
            }

            .sj-card-main {
                gap: 12px;
            }

            .sj-company-logo img {
                width: 44px;
                height: 44px;
                border-radius: 12px;
            }

            .sj-job-title {
                font-size: 15px;
            }

            .sj-details {
                gap: 4px 14px;
            }

            .sj-actions {
                flex-wrap: wrap;
                gap: 8px;
            }

            .sj-apply-btn,
            .sj-view-btn {
                font-size: 13px;
                padding: 8px 16px;
            }

            .sj-header-count {
                padding: 10px 16px;
                min-width: 60px;
            }

            .sj-count-number {
                font-size: 20px;
            }

            .sj-empty-state {
                padding: 48px 20px;
                border-radius: 12px;
                margin: 0 4px;
            }
        }

        @media (max-width: 380px) {
            .sj-card-main {
                flex-direction: column;
            }

            .sj-company-logo {
                display: flex;
            }

            .sj-company-logo img {
                width: 48px;
                height: 48px;
            }

            .sj-actions {
                flex-direction: column;
            }

            .sj-apply-btn,
            .sj-view-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Delete saved job with SweetAlert
        $(document).on('click', '.closeIcon', function () {
            var jobId = $(this).attr('data-job-id');
            Swal.fire({
                title: "{{ trans('common.are_you_sure') }}",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "{{ trans('common.yes') }}, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    sendAjaxRequest('employee/delete-saved-job/'+jobId, 'GET').then(function (response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success",
                                showCancelButton: false,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Success!"
                            }).then((res) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                            });
                        }
                    })
                }
            });
        })
    </script>

    <script>
        // Easy Apply Modal trigger
        $(document).on('click', '.show-apply-model', function () {
            event.preventDefault();
            var applyModal = $('#easyApplyModal');
            var jobId = $(this).attr('data-job-id');
            var companyLogo = $(this).attr('data-job-company-logo');
            var applyFormUrl = base_url + 'employee/apply-job/' + jobId;
            $('.company-image').attr('src', companyLogo);
            $('#applyShareForm').attr('action', applyFormUrl);
            applyModal.css({
                display: "flex"
            });
        })

        // show job details on modal
        function showJobDetails(jobId, jobTitle = 'View Job Title') {
            sendAjaxRequest('get-job-details/'+jobId+'?render=1&show_apply=0', 'GET').then(function (response) {
                $('#viewJobModalTitle').empty().append(jobTitle);
                $('#viewJobModalBody').empty().append(response);
                $('#viewJobModal').modal('show');
            })
        }
    </script>
@endpush
