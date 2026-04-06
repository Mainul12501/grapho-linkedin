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
    <style>
        /* Job details styles (loaded via AJAX from job-details.blade.php) */
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
        }
    </style>
@endpush

@push('script')
    <script>
        $(document).on('click', '.save-btn', function () {
            var jobId = $(this).attr('data-job-id');
            var isSaved = $(this).attr('is-saved');
            var thisBtn = $(this);
            if (isSaved == 'yes')
            {
                toastr.info('You have already saved this job.');
                return;
            }
            var thisElement = $(this);
            sendAjaxRequest('employee/save-job/'+jobId, 'GET').then(function (response) {
                if (response.status == 'success')
                {
                    $(this).attr('disabled', true);
                    thisElement.addClass('force-hide');
                    sendAjaxRequest('employee/get-total-saved-jobs', 'GET').then(function (res) {
                        $('#savedJobsNumber').text(res);
                    })
                    $('#saveBtnImg'+jobId).attr('src', "{{ asset('/frontend/bookmark-circle.png') }}");
                    $('#saveBtnTxt'+jobId).text("{{ trans('common.saved') }}");
                    thisBtn.removeClass('bg-primary text-white').addClass('bg-gray-300 bg-light text-dark');
                    toastr.success(response.msg);
                    thisElement.closest('.eh-job-card').hide();
                }
                else if (response.status == 'error')
                {
                    toastr.error(response.msg);
                }
            })
        })

        $(document).on('click', '.save-btnx', function () {
            var jobId = $(this).attr('data-job-id');
            var thisObject = $(this);
            sendAjaxRequest('employee/save-job/'+jobId, 'GET').then(function (response) {
                if (response.status == 'success')
                {
                    thisObject.attr('src', "{{ asset('/frontend/bookmark-circle.png') }}");
                    sendAjaxRequest('employee/get-total-saved-jobs', 'GET').then(function (res) {
                        $('#savedJobsNumber').text(res);
                    })
                    toastr.success(response.msg);
                }
                else if (response.status == 'error')
                {
                    toastr.error(response.msg);
                }
            })
        })
    </script>
    <script>
        $(document).on('click', '.show-apply-model', function (){
            event.preventDefault();
           var applyModal = $('#easyApplyModal');
            var jobId = $(this).attr('data-job-id');
            var companyLogo = $(this).attr('data-job-company-logo');
            var applyFormUrl = base_url+'employee/apply-job/'+jobId;
            $('.company-image').attr('src', companyLogo);
            $('#applyShareForm').attr('action', applyFormUrl);
            applyModal.css({
                display: "flex"
            });
        })
        function showJobDetails(jobId, jobTitle = 'View Job Title') {
            sendAjaxRequest('get-job-details/'+jobId+'?render=1&show_apply=0', 'GET').then(function (response) {
                $('#viewJobModalTitle').empty().append(jobTitle);
                $('#viewJobModalBody').empty().append(response);
                $('#viewJobModal').modal('show');
            })
        }
    </script>
@endpush
