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
    <link rel="stylesheet" href="{{ asset('frontend/page-custom-codes/employee/saved-jobs/style.css') }}" />
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('frontend/page-custom-codes/employee/saved-jobs/script.js') }}"></script>
@endpush
