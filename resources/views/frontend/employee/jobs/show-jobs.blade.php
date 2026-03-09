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
    <style>
        /* ================================================
           SHOW JOBS REDESIGN — Scoped with .sj- prefix (jobs)
           ================================================ */

        /* --- Filter Bar --- */
        .sj-filter-section {
            background: #fff;
            border-bottom: 1px solid #f0f1f3;
        }

        .sj-filter-bar {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            padding: 14px 0;
        }

        .sj-filter-label {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #141c25;
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
            margin-right: 4px;
        }

        .sj-filter-label svg {
            color: #667080;
        }

        .sj-filter-label div {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Filter pills override */
        .sj-filter-bar .custom-select {
            max-width: 140px !important;
            min-width: 100px !important;
        }

        .sj-filter-bar .select-box {
            padding: 7px 32px 7px 14px !important;
            border-radius: 10px !important;
            border: 1.5px solid #e4e5e9 !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #484f5b !important;
            background-color: #fafbfc;
            transition: all .2s ease;
        }

        .sj-filter-bar .select-box:hover {
            border-color: #d4d6db !important;
        }

        .sj-filter-bar .select-boxCustom {
            background-color: #FFFBEB !important;
            border-color: #FFCB11 !important;
            color: #141c25 !important;
        }

        .sj-filter-bar .dropdown-menu {
            border-radius: 12px !important;
            border: 1px solid #e8e9ec !important;
            box-shadow: 0 4px 20px rgba(20,28,37,.08) !important;
            padding: 10px !important;
            top: 42px !important;
            max-height: 260px !important;
            overflow-y: auto !important;
        }

        .sj-filter-bar .dropdown-menu::-webkit-scrollbar {
            width: 5px;
        }

        .sj-filter-bar .dropdown-menu::-webkit-scrollbar-track {
            background: transparent;
        }

        .sj-filter-bar .dropdown-menu::-webkit-scrollbar-thumb {
            background: #d4d6db;
            border-radius: 10px;
        }

        .sj-filter-bar .search-box {
            border-radius: 8px !important;
            padding: 7px 10px 7px 32px !important;
            font-size: 13px !important;
        }

        .sj-filter-bar .checkbox-item {
            padding: 4px 6px;
            border-radius: 6px;
            transition: background .15s ease;
        }

        .sj-filter-bar .checkbox-item:hover {
            background: #f8f9fb;
        }

        .sj-filter-bar .checkbox-item label {
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #484f5b !important;
            cursor: pointer;
        }

        .sj-filter-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
        }

        .sj-filter-search-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 16px;
            font-size: 13px;
            font-weight: 700;
            color: #141c25;
            background: #FFCB11;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .sj-filter-search-btn:hover {
            background: #f0be00;
        }

        .sj-filter-clear-btn {
            padding: 7px 14px;
            font-size: 13px;
            font-weight: 600;
            color: #667080;
            background: transparent;
            border: 1px solid #e4e5e9;
            border-radius: 10px;
            cursor: pointer;
            transition: all .15s ease;
        }

        .sj-filter-clear-btn:hover {
            background: #f8f9fb;
            border-color: #d4d6db;
        }

        /* --- Results Layout --- */
        .sj-results-section {
            background: #f6f7f9;
            min-height: calc(100vh - 160px);
            padding: 20px 0 40px;
        }

        .sj-results-layout {
            display: flex;
            gap: 20px;
            position: relative;
        }

        /* --- Left: Job List Column --- */
        .sj-job-list-col {
            width: 38%;
            flex-shrink: 0;
            background: #fff;
            border-radius: 16px;
            border: 1px solid #f0f1f3;
            box-shadow: 0 1px 3px rgba(20,28,37,.04), 0 6px 16px rgba(20,28,37,.03);
            overflow: hidden;
            max-height: calc(100vh - 200px);
            overflow-y: auto;
            position: relative;
        }

        .sj-job-list-col::-webkit-scrollbar {
            width: 5px;
        }

        .sj-job-list-col::-webkit-scrollbar-track {
            background: transparent;
        }

        .sj-job-list-col::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 10px;
        }

        .sj-results-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f0f1f3;
            position: sticky;
            top: 0;
            background: #fff;
            z-index: 5;
        }

        .sj-results-header h5 {
            font-size: 13px;
            font-weight: 500;
            color: #8c919d;
            margin: 0;
        }

        .sj-results-header strong {
            color: #141c25;
            font-weight: 700;
        }

        /* --- Job Card --- */
        .sj-job-card {
            padding: 16px 20px;
            border-bottom: 1px solid #f5f6f7;
            cursor: pointer;
            transition: all .18s ease;
            border-left: 3px solid transparent;
        }

        .sj-job-card:hover {
            background: #fafbfc;
        }

        .sj-job-card.sj-job-active {
            background: #FFFDF5;
            border-left-color: #FFCB11;
        }

        .sj-job-card-inner {
            display: flex;
            gap: 14px;
        }

        .sj-job-logo {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            background: #f3f4f6;
            border: 1px solid #eee;
        }

        .sj-job-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sj-job-info {
            flex: 1;
            min-width: 0;
        }

        .sj-job-title-text {
            font-size: 15px;
            font-weight: 650;
            color: #141c25;
            margin: 0 0 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sj-job-company {
            font-size: 13px;
            color: #667080;
            margin: 0 0 8px;
        }

        .sj-job-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 6px;
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

        .sj-job-location {
            font-size: 12px;
            color: #8c919d;
            margin: 0;
        }

        .sj-job-mobile-info {
            display: none;
            font-size: 12px;
            color: #8c919d;
            margin: 4px 0 0;
        }

        /* --- Right: Detail Panel --- */
        .sj-detail-panel {
            flex: 1;
            background: #fff;
            border-radius: 16px;
            border: 1px solid #f0f1f3;
            box-shadow: 0 1px 3px rgba(20,28,37,.04), 0 6px 16px rgba(20,28,37,.03);
            padding: 28px 32px;
        }

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

        /* Detail meta grid */
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

        /* Detail sections */
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

        /* --- Empty State --- */
        .sj-empty-jobs {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            text-align: center;
        }

        .sj-empty-jobs img {
            max-height: 180px;
            margin-bottom: 16px;
            opacity: .7;
        }

        .sj-empty-jobs p {
            font-size: 16px;
            font-weight: 600;
            color: #dc2626;
        }

        .sj-detail-empty {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 400px;
        }

        /* --- Loading --- */
        .sj-loading-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255,255,255,.9);
            padding: 20px;
            text-align: center;
            z-index: 10;
            pointer-events: none;
        }

        .sj-spinner {
            width: 24px;
            height: 24px;
            border: 3px solid #e8e9ec;
            border-top-color: #FFCB11;
            border-radius: 50%;
            animation: sjSpin .7s linear infinite;
            margin: 0 auto;
        }

        @keyframes sjSpin {
            to { transform: rotate(360deg); }
        }

        /* --- Easy Apply Modal --- */
        .sj-easyapply-modal {
            border-radius: 16px !important;
            padding: 28px !important;
            max-width: 400px;
            box-shadow: 0 12px 48px rgba(20,28,37,.15) !important;
        }

        .sj-easyapply-header {
            border-bottom: none !important;
            padding: 0 !important;
            flex-direction: column;
            align-items: center;
        }

        .sj-easyapply-images {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: 16px;
        }

        .sj-easyapply-images .user-image,
        .sj-easyapply-images .company-image {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }

        .sj-easyapply-images .company-image {
            margin-left: -18px;
        }

        .sj-easyapply-images .arrow-icon {
            width: 28px;
            height: 28px;
            background: #FFCB11;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            z-index: 4;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            border: 2px solid #fff;
        }

        .sj-easyapply-modal h2 {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #141c25 !important;
        }

        .sj-share-btn {
            background: #FFCB11 !important;
            color: #141c25 !important;
            border: none !important;
            border-radius: 12px !important;
            font-weight: 700 !important;
            font-size: 15px !important;
            padding: 12px !important;
        }

        .sj-share-btn:hover {
            background: #f0be00 !important;
            color: #141c25 !important;
        }

        .sj-cancel-btn {
            border-radius: 12px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            border: 1.5px solid #e4e5e9 !important;
            color: #667080 !important;
            background: transparent !important;
        }

        .sj-cancel-btn:hover {
            background: #f8f9fb !important;
            color: #484f5b !important;
        }

        /* --- Notification Toast --- */
        .notification {
            border-radius: 12px !important;
            background: #141c25 !important;
            padding: 12px 20px !important;
            box-shadow: 0 8px 24px rgba(20,28,37,.2) !important;
        }

        /* --- Mobile Modal --- */
        .sj-mobile-modal-content {
            border-radius: 16px;
            border: none;
            overflow: hidden;
        }

        /* ================================================
           RESPONSIVE
           ================================================ */

        @media (max-width: 992px) {
            .sj-job-list-col {
                width: 42%;
            }
        }

        @media (max-width: 768px) {
            .sj-results-layout {
                flex-direction: column;
            }

            .sj-job-list-col {
                width: 100%;
                max-height: none;
                border-radius: 12px;
            }

            #jobDetailsWithData,
            #jobDetailsWithoutData {
                display: none !important;
            }

            .sj-job-mobile-info {
                display: block;
            }

            .sj-filter-bar {
                overflow-x: visible;
                flex-wrap: wrap;
                padding: 14px 12px;
            }

            .sj-filter-actions {
                width: 100%;
                margin-left: 0;
            }

            .sj-filter-search-btn {
                flex: 1;
            }

            .sj-filter-clear-btn {
                flex: 1;
            }

            .sj-job-card {
                padding: 14px 16px;
            }

            .sj-job-logo {
                width: 42px;
                height: 42px;
            }

            .sj-job-title-text {
                font-size: 14px;
            }

            .sj-detail-meta-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }

        @media (max-width: 480px) {
            .sj-filter-bar .custom-select {
                max-width: none !important;
                flex: 1;
                min-width: calc(50% - 10px) !important;
            }

            .sj-filter-label {
                width: 100%;
            }
        }
        .force-hide {
            display: none !important;
        }
    </style>
@endpush

@push('script')
    @include('common-resource-files.selectize')
    <script>
        // Job card click -> load details
        $(document).on('click', '.job-card-ajax', function () {
            var jobId = $(this).attr('data-job-id');
            sendAjaxRequest('get-job-details/'+jobId+'?render=1', 'GET').then(function (response) {
                console.log(response);
                if (window.innerWidth > 768) {
                    const jobDetailsDiv = document.querySelector('.sj-detail-panel');
                    if (jobDetailsDiv) {
                        jobDetailsDiv.style.display = 'block';
                        jobDetailsDiv.innerHTML = response;
                    }
                } else {
                    const jobDetailsDiv = document.querySelector('#jobDeatilsForMobile');
                    jobDetailsDiv.style.display = 'block';
                    jobDetailsDiv.innerHTML = response;
                    $('#jobDeatilsForModal').modal('show');
                }
            });
        })

        // Save job
        $(document).on('click', '.save-btn', function () {
            var jobId = $(this).attr('data-job-id');
            var isSaved = $(this).attr('is-saved');
            if (isSaved == 'yes') {
                toastr.info('{{ trans('common.saved') }}');
                return;
            }
            var thisElement = $(this);
            sendAjaxRequest('employee/save-job/'+jobId, 'GET').then(function (response) {
                if (response.status == 'success') {
                    $(this).attr('disabled', true);
                    thisElement.addClass('force-hide');
                    $('#saveBtnImg'+jobId).attr('src', "{{ asset('/frontend/bookmark-circle.png') }}");
                    $('#saveBtnTxt'+jobId).text('{{ trans('common.saved') }}');
                    toastr.success(response.msg);
                } else if (response.status == 'error') {
                    toastr.error(response.msg);
                }
            })
        })

        // Easy apply modal
        $(document).on('click', '.show-apply-model', function () {
            event.preventDefault();
            var applyModal = $('#easyApplyModal');
            var jobId = $(this).attr('data-job-id');
            var companyLogo = $(this).attr('data-job-company-logo');
            var applyFormUrl = base_url+'employee/apply-job/'+jobId;
            $('.company-image').attr('src', companyLogo);
            $('#applyShareForm').attr('action', applyFormUrl);
            applyModal.css({ display: "flex" });
        })
    </script>

    <!-- Clear all -->
    <script>
        const clearBtn = document.getElementById('clearAllBtn');
        if (clearBtn) clearBtn.addEventListener('click', function () {
            window.location.href = "{{ route('employee.show-jobs') }}";
        });

        function resetAllDropdowns() {
            document.querySelectorAll('.custom-select').forEach(dropdownEl => {
                dropdownEl.querySelectorAll('.locationCheckbox').forEach(cb => (cb.checked = false));
                dropdownEl.querySelectorAll('input[type="hidden"][data-filter-value]').forEach(inp => inp.remove());
                const input = dropdownEl.querySelector('.locationSearch');
                const placeholderText = dropdownEl.dataset.placeholder || 'Select...';
                if (input) {
                    input.value = '';
                    input.placeholder = placeholderText;
                    input.classList.remove('select-boxCustom');
                }
                const panel = dropdownEl.querySelector('.locationDropdown');
                if (panel) panel.style.display = 'none';
            });
            window.JOB_FILTERS = {};
            document.dispatchEvent(new CustomEvent('filters:change', { detail: {} }));
        }
    </script>

    <!-- Infinite scroll -->
    <script>
        let currentPage = 1;
        let isLoading = false;
        let hasMorePages = {{ $jobTasks->hasMorePages() ? 'true' : 'false' }};
        let jobCounter = {{ count($jobTasks) }};
        let observer;

        $(document).ready(function() {
            initInfiniteScroll();
        });

        function initInfiniteScroll() {
            const sentinel = $('<div id="scroll-sentinel" style="height: 1px;"></div>');
            $('#job-list-container').append(sentinel);

            const options = {
                root: document.querySelector('#job-options-container'),
                rootMargin: '100px',
                threshold: 0
            };

            observer = new IntersectionObserver(handleIntersection, options);
            observer.observe(document.getElementById('scroll-sentinel'));
        }

        function handleIntersection(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting && !isLoading && hasMorePages) {
                    loadMoreJobs();
                }
            });
        }

        function loadMoreJobs() {
            isLoading = true;
            $('#loading-indicator').show();

            const urlParams = new URLSearchParams(window.location.search);
            const params = { page: currentPage + 1 };

            if (urlParams.has('search_text')) {
                params.search_text = urlParams.get('search_text');
            }
            if (urlParams.has('filters')) {
                params.filters = urlParams.get('filters');
            }

            $.ajax({
                url: '{{ route("employee.show-jobs") }}',
                type: 'GET',
                data: params,
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function(response) {
                    if (response.html) {
                        $('#scroll-sentinel').before(response.html);
                        currentPage = response.next_page;
                        hasMorePages = response.has_more;
                        jobCounter += $(response.html).filter('.sj-job-card').length;
                        $('#job-count').text(jobCounter);
                        bindJobCardEvents();
                        if (!hasMorePages) {
                            observer.disconnect();
                            $('#scroll-sentinel').remove();
                        }
                    }
                    $('#loading-indicator').hide();
                    isLoading = false;
                },
                error: function(xhr, status, error) {
                    console.error('Error loading more jobs:', error);
                    $('#loading-indicator').hide();
                    isLoading = false;
                }
            });
        }

        function bindJobCardEvents() {
            $('.job-card-ajax').off('click').on('click', function() {
                var jobId = $(this).attr('data-job-id');
                sendAjaxRequest('get-job-details/'+jobId+'?render=1', 'GET').then(function (response) {
                    console.log(response);
                    if (window.innerWidth > 768) {
                        const jobDetailsDiv = document.querySelector('.sj-detail-panel');
                        if (jobDetailsDiv) {
                            jobDetailsDiv.style.display = 'block';
                            jobDetailsDiv.innerHTML = response;
                        }
                    } else {
                        const jobDetailsDiv = document.querySelector('#jobDeatilsForMobile');
                        jobDetailsDiv.style.display = 'block';
                        jobDetailsDiv.innerHTML = response;
                        $('#jobDeatilsForModal').modal('show');
                    }
                });
            });
        }

        function setLetSideActiveJob(jobId) {
            document.querySelectorAll('.sj-job-card').forEach(card => card.classList.remove('sj-job-active'));
            const activeCard = document.getElementById('job-' + jobId);
            if (activeCard) activeCard.classList.add('sj-job-active');
        }
    </script>
@endpush
