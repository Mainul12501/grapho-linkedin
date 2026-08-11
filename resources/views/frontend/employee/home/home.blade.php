@extends('frontend.employee.master')

@section('title', 'Employee Home')

@section('body')
    <div class="eh-home">
        {{-- ====== SIDEBAR ====== --}}
        <aside class="eh-sidebar">
            <div class="eh-profile-card">
                <div class="eh-avatar-wrap">
                    <img src="{{ asset(auth()->user()->profile_image ?? '/frontend/user-vector-img.jpg') }}"
                         alt="Profile" class="eh-avatar" />
                    <span class="eh-status-dot {{ auth()->user()->is_open_for_hire == 1 ? 'eh-status-dot--online' : 'eh-status-dot--offline' }}"></span>
                </div>
                <h2 class="eh-name">{{ auth()->user()->name ?? trans('common.user') }}</h2>
                <span class="eh-status-badge {{ auth()->user()->is_open_for_hire == 1 ? 'eh-status-badge--open' : 'eh-status-badge--offline' }}">
                    <i class="fas fa-circle"></i>
                    {{ auth()->user()->is_open_for_hire == 1 ? trans('employee.open_to_work') : trans('employee.offline') }}
                </span>
                <p class="eh-bio">{{ auth()->user()->profile_title ?? trans('common.user_bio') }}</p>
                <p class="eh-location">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ auth()->user()->address ?? trans('common.user_address') }}
                </p>
            </div>

            <div class="eh-stats">
                <a href="{{ route('employee.my-saved-jobs') }}" class="eh-stat-card">
                    <span class="eh-stat-icon eh-stat-icon--bookmark"><i class="fas fa-bookmark"></i></span>
                    <span class="eh-stat-value" id="savedJobsNumber">{{ $totalSavedJobs }}</span>
                    <span class="eh-stat-label">{{ trans('employee.my_saved_jobs') }}</span>
                </a>
                <a href="{{ route('employee.my-applications') }}" class="eh-stat-card">
                    <span class="eh-stat-icon eh-stat-icon--check"><i class="fas fa-check-circle"></i></span>
                    <span class="eh-stat-value">{{ $totalAppliedApplications }}</span>
                    <span class="eh-stat-label">{{ trans('employee.my_applications') }}</span>
                </a>
                <a href="{{ route('employee.my-profile-viewers') }}" class="eh-stat-card">
                    <span class="eh-stat-icon eh-stat-icon--eye"><i class="fas fa-eye"></i></span>
                    <span class="eh-stat-value">{{ $totalViewedEmployers }}</span>
                    <span class="eh-stat-label">{{ trans('employee.profiler_viewers') }}</span>
                </a>
            </div>
        </aside>

        {{-- ====== JOB FEED ====== --}}
        <section class="eh-feed mx-md-auto">

            {{-- Top Job Picks --}}
            @if(count($topJobsForEmployee) > 0)
                <div class="eh-section">
                    <div class="eh-section-header">
                        <h2 class="eh-section-title">{{ trans('employee.top_job_picks_for_you') }}, {{ auth()->user()->name ?? trans('common.user_name') }}!</h2>
                        <p class="eh-section-subtitle">{{ trans('employee.based_on_profile_preferences') }}</p>
                    </div>

                    @foreach($topJobsForEmployee as $topJobForEmployee)
                        <article class="eh-job-card">
                            <div class="eh-job-logo">
                                <a href="{{ route('view-company-profile', ['employerCompany' => $topJobForEmployee->employer_company_id, 'view' => 'employee']) }}">
                                    <img src="{{ asset($topJobForEmployee?->employerCompany?->logo ?? '/frontend/company-vector.jpg') }}"
                                         alt="{{ $topJobForEmployee?->employerCompany?->name ?? 'Company' }}" />
                                </a>
                            </div>
                            <div class="eh-job-body">
                                <div class="eh-job-header-row">
                                    <div class="eh-job-logo--mobile">
                                        <a href="{{ route('view-company-profile', ['employerCompany' => $topJobForEmployee->employer_company_id, 'view' => 'employee']) }}">
                                            <img src="{{ asset($topJobForEmployee?->employerCompany?->logo ?? '/frontend/company-vector.jpg') }}"
                                                 alt="{{ $topJobForEmployee?->employerCompany?->name ?? 'Company' }}" />
                                        </a>
                                    </div>
                                    <div>
                                        <h3 class="eh-job-title">
                                            {{ $topJobForEmployee->job_title ?? trans('common.job_title') }}
                                            <span class="eh-view-link" onclick="showJobDetails({{ $topJobForEmployee->id }}, `{{ $topJobForEmployee->job_title }}`)">{{ trans('common.view') }}</span>
                                        </h3>
                                        <p class="eh-job-company">
                                            <a href="{{ route('view-company-profile', ['employerCompany' => $topJobForEmployee->employer_company_id, 'view' => 'employee']) }}">{{ $topJobForEmployee?->employerCompany?->name ?? trans('common.company_name') }}</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="eh-tags">
                                    <span class="eh-tag">{{ $topJobForEmployee?->jobType?->name ?? trans('common.full_time') }}</span>
                                    <span class="eh-tag">{{ $topJobForEmployee?->jobLocationType?->name ?? trans('common.on_site') }}</span>
                                </div>
                                <div class="eh-job-meta">
                                    <span><i class="fas fa-map-marker-alt"></i> {!! $topJobForEmployee->employerCompany?->address ?? trans('common.company_address') !!}</span>
                                    <span><i class="fas fa-briefcase"></i> {{ $topJobForEmployee->required_experience ?? 0 }} {{ trans('employee.years_of_experience') }}</span>
                                    <span><i class="fas fa-money-bill-wave"></i> {{ trans('employee.salary') }}: Tk. {{ $topJobForEmployee->salary_amount ?? 0 }}/{{ $topJobForEmployee->job_pref_salary_payment_type }}</span>
                                </div>
                                @if(!\App\Helpers\ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
                                    <div class="eh-job-actions">
                                        @if(!$topJobForEmployee['isApplied'])
                                            <form action="{{ route('employee.apply-job', $topJobForEmployee->id) }}" method="post" style="display:inline">
                                                @csrf
                                                <button type="submit" class="eh-btn-apply show-apply-model"
                                                        data-job-id="{{ $topJobForEmployee->id }}"
                                                        data-job-company-logo="{{ asset($topJobForEmployee?->employerCompany?->logo) ?? '' }}">
                                                    {{ trans('employee.easy_apply') }}
                                                </button>
                                            </form>
                                        @else
                                            <button class="eh-btn-apply eh-btn-applied" disabled
                                                    data-job-id="{{ $topJobForEmployee->id }}"
                                                    data-job-company-logo="{{ asset($topJobForEmployee?->employerCompany?->logo) ?? '' }}">
                                                <i class="fas fa-check"></i> {{ trans('employee.applied') }}
                                            </button>
                                        @endif

                                        @if(!auth()->user()?->employeeSavedJobs->contains($topJobForEmployee->id))
                                            <button class="eh-btn-save save-btn" is-saved="no" data-job-id="{{ $topJobForEmployee->id }}">
                                                <img id="saveBtnImg{{ $topJobForEmployee->id }}" src="{{ asset('frontend/employee/images/bookmark-white.png') }}" alt="Save" class="save-icon">
                                                <span id="saveBtnTxt{{ $topJobForEmployee->id }}">{{ trans('common.save') }}</span>
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach

                    <div class="eh-see-all">
                        <a href="{{ route('employee.show-jobs') }}">{{ trans('employee.show_all') }} <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            @endif

            {{-- More Jobs --}}
            <div class="eh-section">
                <div class="eh-section-header">
                    <h2 class="eh-section-title">{{ trans('employee.more_jobs') }}</h2>
                </div>

                @foreach($moreJobsForEmployee as $topJobForEmployee)
                    <article class="eh-job-card">
                        <div class="eh-job-logo">
                            <a href="{{ route('view-company-profile', ['employerCompany' => $topJobForEmployee->employer_company_id, 'view' => 'employee']) }}">
                                <img src="{{ asset($topJobForEmployee?->employerCompany?->logo ?? '/frontend/company-vector.jpg') }}"
                                     alt="{{ $topJobForEmployee?->employerCompany?->name ?? 'Company' }}" />
                            </a>
                        </div>
                        <div class="eh-job-body">
                            <div class="eh-job-header-row">
                                <div class="eh-job-logo--mobile">
                                    <a href="{{ route('view-company-profile', ['employerCompany' => $topJobForEmployee->employer_company_id, 'view' => 'employee']) }}">
                                        <img src="{{ asset($topJobForEmployee?->employerCompany?->logo ?? '/frontend/company-vector.jpg') }}"
                                             alt="{{ $topJobForEmployee?->employerCompany?->name ?? 'Company' }}" />
                                    </a>
                                </div>
                                <div>
                                    <h3 class="eh-job-title">
                                        {{ $topJobForEmployee->job_title ?? trans('common.job_title') }}
                                        <span class="eh-view-link" onclick="showJobDetails({{ $topJobForEmployee->id }}, `{{ $topJobForEmployee->job_title }}`)">{{ trans('common.view') }}</span>
                                    </h3>
                                    <p class="eh-job-company">
                                        <a href="{{ route('view-company-profile', ['employerCompany' => $topJobForEmployee->employer_company_id, 'view' => 'employee']) }}">{{ $topJobForEmployee?->employerCompany?->name ?? trans('common.company_name') }}</a>
                                    </p>
                                </div>
                            </div>
                            <div class="eh-tags">
                                <span class="eh-tag">{{ $topJobForEmployee?->jobType?->name ?? trans('common.full_time') }}</span>
                                <span class="eh-tag">{{ $topJobForEmployee?->jobLocationType?->name ?? trans('common.on_site') }}</span>
                            </div>
                            <div class="eh-job-meta">
                                <span><i class="fas fa-map-marker-alt"></i> {!! $topJobForEmployee->employerCompany?->address ?? trans('common.company_address') !!}</span>
                                <span><i class="fas fa-briefcase"></i> {{ $topJobForEmployee->required_experience ?? 0 }} {{ trans('employee.years_of_experience') }}</span>
                                <span><i class="fas fa-money-bill-wave"></i> {{ trans('employee.salary') }}: Tk. {{ $topJobForEmployee->salary_amount ?? 0 }}/{{ $topJobForEmployee->job_pref_salary_payment_type }}</span>
                            </div>
                            @if(!\App\Helpers\ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
                                <div class="eh-job-actions">
                                    @if(!$topJobForEmployee['isApplied'])
                                        <form action="{{ route('employee.apply-job', $topJobForEmployee->id) }}" method="post" style="display:inline">
                                            @csrf
                                            <button type="submit" class="eh-btn-apply show-apply-model"
                                                    data-job-id="{{ $topJobForEmployee->id }}"
                                                    data-job-company-logo="{{ asset($topJobForEmployee?->employerCompany?->logo) ?? '' }}">
                                                {{ trans('employee.easy_apply') }}
                                            </button>
                                        </form>
                                    @endif

                                    @if(!auth()->user()?->employeeSavedJobs->contains($topJobForEmployee->id))
                                        <button class="eh-btn-save save-btn" is-saved="no" data-job-id="{{ $topJobForEmployee->id }}">
                                            <img id="saveBtnImg{{ $topJobForEmployee->id }}" src="{{ asset('/frontend/employee/images/bookmark-white.png') }}" alt="Save" class="save-icon">
                                            <span id="saveBtnTxt{{ $topJobForEmployee->id }}">{{ trans('common.save') }}</span>
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </article>
                @endforeach

                <div class="eh-see-all">
                    <a href="{{ route('employee.show-jobs') }}">{{ trans('employee.show_all') }} <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

        </section>
    </div>

    {{-- Easy Apply Modal --}}
    <div class="easy-apply-modal eh-apply-modal" id="easyApplyModal">
        <div class="modal-content">
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
                <button class="cancel-btn w-100" onclick="closeEasyApplyModal()">{{ trans('common.cancel') }}</button>
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
    <link rel="stylesheet" href="{{ asset('frontend/employee/eh-home.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/page-custom-codes/employee/home/style.css') }}">
@endpush

@push('script')
    <script src="{{ asset('frontend/page-custom-codes/employee/home/script.js') }}"></script>
@endpush
