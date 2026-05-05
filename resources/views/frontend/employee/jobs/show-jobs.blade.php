@extends('frontend.employee.master')

@section('title', 'Show Jobs')

@section('body')

    @php
        function getSelectedFilters($filterKey) {
            $filters = request('filters', []);
            if (!isset($filters[$filterKey])) {
                return [];
            }
            $value = $filters[$filterKey];
            if (is_string($value)) {
                $decoded = json_decode($value, true);
                return is_array($decoded) ? $decoded : [];
            }
            return is_array($value) ? $value : [];
        }
    @endphp

    <!-- ========== FILTER BAR ========== -->
    <section class="sj-filter-section">
        <div class="container">
            <form id="jobFilters" class="customWrapper sj-filter-bar" method="GET" action="" data-autosubmit="true">

                <!-- Filter Icon Label -->
                <div class="fielterIcon sj-filter-label">
                    <div>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                        <span>{{ trans('common.filters') }}</span>
                    </div>
                </div>

                <!-- Filter #1: Date posted -->
                <div class="custom-select" data-filter-key="date_posted" data-placeholder="{{ trans('common.most_recent') }}">
                    <input type="text" class="form-control select-box locationSearch" placeholder="{{ trans('common.search') }}" readonly />
                    <div class="dropdown-menu locationDropdown">
                        <input type="text" class="form-control search-box searchBar" placeholder="{{ trans('common.search') }}" />
                        <div class="checkbox-item">
                            <input type="checkbox" class="locationCheckbox" id="date24h" value="7" {{ in_array("7", getSelectedFilters('date_posted')) ? 'checked' : '' }} />
                            <label for="date24h">{{ trans('common.most_recent') }}</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" class="locationCheckbox" id="date15d" value="15" {{ in_array("15", getSelectedFilters('date_posted')) ? 'checked' : '' }} />
                            <label for="date15d">{{ trans('common.last_15_days') }}</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" class="locationCheckbox" id="date30d" value="30" {{ in_array("30", getSelectedFilters('date_posted')) ? 'checked' : '' }} />
                            <label for="date30d">{{ trans('common.last_30_days') }}</label>
                        </div>
                    </div>
                    <input type="hidden" class="filter-payload" name="filters[date_posted]" value="[]">
                </div>

                <!-- Filter #2: Job type -->
                <div class="custom-select" data-filter-key="company_type" data-placeholder="{{ trans('common.job_type') }}">
                    <input type="text" class="form-control select-box locationSearch" placeholder="{{ trans('common.search') }}" readonly />
                    <div class="dropdown-menu locationDropdown">
                        <input type="text" class="form-control search-box searchBar" placeholder="{{ trans('common.search') }}" />
                        @foreach($JobTypes as $JobType)
                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" id="ctype-{{ $JobType->slug }}" value="{{ $JobType->slug }}" {{ in_array($JobType->slug, getSelectedFilters('job_type')) ? 'checked' : '' }} />
                                <label for="ctype-{{ $JobType->slug }}">{{ $JobType->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" class="filter-payload" name="filters[job_type]" value="[]">
                </div>

                <!-- Filter #3: Location -->
                <div class="custom-select" data-filter-key="location" data-placeholder="{{ trans('common.location') }}">
                    <input type="text" class="form-control select-box locationSearch" placeholder="{{ trans('common.search') }}" readonly />
                    <div class="dropdown-menu locationDropdown">
                        <input type="text" class="form-control search-box searchBar" placeholder="{{ trans('common.search') }}" />
                        @foreach(['Bagerhat','Bandarban','Barguna','Barisal','Bhola','Bogura','Brahmanbaria','Chandpur','Chapainawabganj','Chattogram','Chuadanga','Coxs Bazar','Cumilla','Dhaka','Dinajpur','Faridpur','Feni','Gaibandha','Gazipur','Gopalganj','Habiganj','Jamalpur','Jashore','Jhalokati','Jhenaidah','Joypurhat','Khagrachari','Khulna','Kishoreganj','Kurigram','Kushtia','Lakshmipur','Lalmonirhat','Madaripur','Magura','Manikganj','Meherpur','Moulvibazar','Munshiganj','Mymensingh','Naogaon','Narail','Narayanganj','Narsingdi','Natore','Netrokona','Nilphamari','Noakhali','Pabna','Panchagarh','Patuakhali','Pirojpur','Rajbari','Rajshahi','Rangamati','Rangpur','Satkhira','Shariatpur','Sherpur','Sirajganj','Sunamganj','Sylhet','Tangail','Thakurgaon'] as $district)
                            <div class="checkbox-item">
                                <input type="checkbox" value="{{ $district }}" {{ in_array($district, getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-{{ Str::slug($district) }}" />
                                <label for="loc-{{ Str::slug($district) }}">{{ $district == 'Coxs Bazar' ? "Cox's Bazar" : $district }}</label>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" class="filter-payload" name="filters[district]" value="[]">
                </div>

                <!-- Filter #4: Industry -->
                <div class="custom-select" data-filter-key="industry" data-placeholder="{{ trans('common.industry') }}">
                    <input type="text" class="form-control select-box locationSearch" placeholder="{{ trans('common.search') }}" readonly />
                    <div class="dropdown-menu locationDropdown">
                        <input type="text" class="form-control search-box searchBar" placeholder="{{ trans('common.search') }}" />
                        @foreach($industries as $industry)
                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" id="ind-{{ $industry->slug }}" {{ in_array($industry->slug, getSelectedFilters('industry')) ? 'checked' : '' }} value="{{ $industry->slug }}" />
                                <label for="ind-{{ $industry->slug }}">{{ $industry->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" class="filter-payload" name="filters[industry]" value="[]">
                </div>

                <!-- Filter #5: Job Nature / Workplace type -->
                <div class="custom-select" data-filter-key="salary" data-placeholder="{{ trans('common.job_nature') }}">
                    <input type="text" class="form-control select-box locationSearch" placeholder="{{ trans('common.search') }}" readonly />
                    <div class="dropdown-menu locationDropdown">
                        <input type="text" class="form-control search-box searchBar" placeholder="{{ trans('common.search') }}" />
                        @foreach($jobLocationTypes as $jobLocationType)
                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" {{ in_array($jobLocationType->slug, getSelectedFilters('job_location_type')) ? 'checked' : '' }} id="jlt-{{ $jobLocationType->slug }}" value="{{ $jobLocationType->slug }}" />
                                <label for="jlt-{{ $jobLocationType->slug }}">{{ $jobLocationType->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" class="filter-payload" name="filters[job_location_type]" value="[]">
                </div>

                <!-- Action Buttons -->
                <div class="sj-filter-actions">
                    <button type="submit" class="sj-filter-search-btn" id="saveBtn">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        {{ trans('common.search') }}
                    </button>
                    <button type="button" class="sj-filter-clear-btn" id="clearAllBtn">{{ trans('common.clear_all') }}</button>
                </div>

            </form>
        </div>
    </section>

    <!-- ========== RESULTS: Job list + Details panel ========== -->
    <section class="sj-results-section">
        <div class="container">
            <div class="sj-results-layout">

                <!-- LEFT: Job cards list -->
                <div class="sj-job-list-col" id="job-options-container">
                    <div class="sj-results-header">
                        <h5>{{ trans('common.showing_results') }}: <strong id="job-count">{{ count($jobTasks) ?? 0 }}</strong> results. Please click job to view it's details.</h5>
                    </div>

                    <div id="job-list-container">
                        @forelse($jobTasks as $key => $jobTask)
                            <div class="sj-job-card job-card-ajax {{ $singleJobTask->id == $jobTask->id ? 'sj-job-active' : '' }}"
                                 onclick="setLetSideActiveJob('{{ $jobTask->id }}')"
                                 data-job-id="{{ $jobTask->id }}"
                                 id="job-{{ $jobTask->id }}">
                                <div class="sj-job-card-inner">
                                    <div class="sj-job-logo">
                                        <img src="{{ isset($jobTask?->employerCompany?->logo) ? asset($jobTask?->employerCompany?->logo) : asset('/frontend/employee/images/contentImages/jobCardLogo.png') }}" alt="{{ $jobTask->job_title }}" />
                                    </div>
                                    <div class="sj-job-info">
                                        <h5 class="sj-job-title-text">{{ $jobTask->job_title ?? trans('common.job_title') }}</h5>
                                        <p class="sj-job-company">{{ $jobTask?->employerCompany?->name ?? trans('common.company_name') }}</p>
                                        <div class="sj-job-tags">
                                            <span class="sj-tag">{{ $jobTask?->jobType?->name ?? trans('common.full_time') }}</span>
                                            <span class="sj-tag">{{ $jobTask?->jobLocationType?->name ?? trans('common.on_site') }}</span>
                                        </div>
                                        <p class="sj-job-location">{{ $jobTask?->employerCompany?->address ?? trans('common.company_address') }}</p>
                                        <p class="sj-job-mobile-info">{{ $jobTask->required_experience ?? 0 }} years experience</p>
                                        <p class="sj-job-mobile-info">Salary: {{ $jobTask->salary_amount ?? 0 }}/{{ $jobTask->job_pref_salary_payment_type ?? 'month' }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="sj-empty-jobs">
                                <img src="{{ asset('/frontend/think.svg') }}" alt="No jobs" />
                                <p>{{ trans('common.sorry_no_job_found') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Loading indicator -->
                <div id="loading-indicator" class="sj-loading-overlay" style="display: none;">
                    <div class="sj-spinner"></div>
                </div>

                <!-- RIGHT: Details panel -->
                @if($foundData)
                    <div class="job-details sj-detail-panel" id="jobDetailsWithData">
                        <div class="sj-detail-company-row">
                            <a href="{{ route('view-company-profile', ['employerCompany' => $singleJobTask->employer_company_id, 'view' => 'employee']) }}" class="sj-detail-logo-link">
                                <img src="{{ isset($singleJobTask?->employerCompany?->logo) ? asset($singleJobTask?->employerCompany?->logo) : asset('/frontend/employee/images/contentImages/jobCardLogo.png') }}" alt="{{ $singleJobTask?->employerCompany?->name ?? 'job-0' }}" class="sj-detail-logo" />
                            </a>
                            <div class="sj-detail-company-info">
                                <h3 class="sj-detail-company-name">
                                    <a href="{{ route('view-company-profile', ['employerCompany' => $singleJobTask->employer_company_id, 'view' => 'employee']) }}">{{ $singleJobTask?->employerCompany?->name ?? trans('common.company_name') }}</a>
                                </h3>
                                <p class="sj-detail-company-addr">{{ $singleJobTask?->employerCompany?->address ?? trans('common.company_address') }}</p>
                            </div>
                        </div>

                        <h2 class="sj-detail-job-title">{{ $singleJobTask->job_title }}</h2>

                        <div class="sj-detail-tags">
                            <span class="sj-tag">{{ $singleJobTask?->jobType?->name ?? trans('common.job_type') }}</span>
                            <span class="sj-tag">{{ $singleJobTask?->jobLocationType?->name ?? trans('common.job_location') }}</span>
                        </div>

                        <div class="sj-detail-actions">
                            @if(!$isApplied)
                                <form action="" method="post" class="apply-form">
                                    @csrf
                                    <button type="submit" class="sj-apply-btn show-apply-model" data-job-id="{{ $singleJobTask->id }}" data-job-company-logo="{{ asset($singleJobTask?->employerCompany?->logo) ?? '' }}">
{{--                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>--}}
                                        {{ trans('employee.easy_apply') }}
                                    </button>
                                </form>
                            @else
                                <button type="button" class="sj-applied-btn" disabled>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    {{ trans('employee.applied') }}
                                </button>
                            @endif
                            @if(!$isSaved && !$isApplied)
                                <button type="button" is-saved="no" class="sj-save-btn save-btn" style="    background-color: rgb(13, 110, 253) !important; color: white !important;" data-job-id="{{ $singleJobTask->id }}">
                                    <img id="saveBtnImg{{ $singleJobTask->id }}" src="{{ asset('/frontend/employee/images/bookmark-white.png') }}" alt="Save" class="save-icon" style="width:16px;height:16px;">
                                    <span id="saveBtnTxt{{ $singleJobTask->id }}">{{ trans('common.save') }}</span>
                                </button>
                            @endif
                        </div>

                        <div class="sj-detail-section">
                            <h5 class="sj-detail-heading">{{ trans('employer.about') }} {{ $singleJobTask?->employerCompany?->name ?? trans('common.company_name') }}</h5>
                            <p class="sj-detail-text">{{ $singleJobTask?->employerCompany?->company_overview ?? trans('employer.company_overview') }}</p>
                        </div>

                        <div class="sj-detail-section">
                            <h5 class="sj-detail-heading">{{ trans('employer.job_requirements') }}</h5>
                            <div class="sj-detail-text job-requirements">
                                {!! $singleJobTask->description ?? trans('employer.job_description_key_responsibilities') !!}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="job-details sj-detail-panel sj-detail-empty" id="jobDetailsWithoutData">
                        <div class="sj-empty-jobs">
                            <img src="{{ asset('/frontend/think.svg') }}" alt="No jobs" />
                            <p>{{ trans('common.sorry_no_job_found') }}</p>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        <!-- Easy Apply Modal -->
        <div class="easy-apply-modal" id="easyApplyModal">
            <div class="modal-content sj-easyapply-modal">
                <div class="modal-header sj-easyapply-header">
                    <div class="images-container sj-easyapply-images">
                        <img src="{{ asset(auth()->user()->profile_image ?? '/frontend/user-vector-img.jpg') }}" alt="Your Profile" class="user-image" />
                        <div class="arrow-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#141c25" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </div>
                        <img src="" alt="Company Logo" class="company-image" />
                    </div>
                    <h2>{{ trans('common.share_your_profile') }}</h2>
                </div>
                <p class="modal-description">{{ trans('common.to_apply_share_profile') }}</p>
                <div class="modal-buttons sj-easyapply-buttons">
                    <form action="" method="post" id="applyShareForm">
                        @csrf
                        <button class="share-profile-btn sj-share-btn w-100 mb-2" type="submit">{{ trans('common.share_my_profile') }}</button>
                    </form>
                    <button class="cancel-btn sj-cancel-btn w-100" style="    background-color: rgb(13, 110, 253) !important; color: white !important;" onclick="closeEasyApplyModal()">{{ trans('common.cancel') }}</button>
                </div>
            </div>
        </div>

        <!-- Apply Success Toast -->
        <div class="notification" id="notification">
            <div class="notification-content">
                <span class="checkmark">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </span>
                {{ trans('employee.you_applied_for_job') }}
                <span id="appliedJobTitle">Senior Officer, Corporate Banking</span>
                <span class="close-btn" onclick="closeNotification()" style="cursor:pointer;margin-left:10px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </span>
            </div>
        </div>
    </section>

    <!-- Mobile Job Details Modal -->
    <div class="modal fade" id="jobDeatilsForModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content sj-mobile-modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="job-details" id="jobDeatilsForMobile" style="display:block;width:100%;box-shadow:none;border:none;padding:0;">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('frontend/page-custom-codes/employee/show-jobs/style.css') }}">

@endpush

@push('script')
    @include('common-resource-files.selectize')
    <script>
        var hasMorePages = {{ $jobTasks->hasMorePages() ? 'true' : 'false' }};
        var jobCounter = {{ count($jobTasks) }};
    </script>
    <script src="{{ asset('frontend/page-custom-codes/employee/show-jobs/script.js') }}"></script>

@endpush
