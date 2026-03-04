<div class="sj-detail-company-row">
    <a href="{{ route('view-company-profile', ['employerCompany' => $singleJobTask->employer_company_id, 'view' => 'employee']) }}" class="sj-detail-logo-link">
        <img src="{{ isset($singleJobTask?->employerCompany?->logo) ? asset($singleJobTask?->employerCompany?->logo) : asset('/frontend/employee/images/contentImages/jobCardLogo.png') }}" alt="{{ $singleJobTask?->employerCompany?->name ?? 'job-0' }}" class="sj-detail-logo" />
    </a>
    <div class="sj-detail-company-info">
        <h3 class="sj-detail-company-name"><a href="{{ route('view-company-profile', ['employerCompany' => $singleJobTask->employer_company_id, 'view' => 'employee']) }}">{{ $singleJobTask?->employerCompany?->name ?? 'company name' }}</a></h3>
        <p class="sj-detail-company-addr">{{ $singleJobTask?->employerCompany?->address ?? 'company address' }}</p>
    </div>
</div>

<h2 class="sj-detail-job-title">{{ $singleJobTask->job_title }}</h2>

<div class="sj-detail-tags">
    <span class="sj-tag">{{ $singleJobTask?->jobType?->name ?? 'job type' }}</span>
    <span class="sj-tag">{{ $singleJobTask?->jobLocationType?->name ?? 'job location' }}</span>
</div>

@if(auth()->user()->user_type == 'employee' && $showApplyButton)
    <div class="sj-detail-actions">
        @if(!$isApplied)
            <form action="" method="post" class="apply-form">
                @csrf
                <button type="submit" class="sj-apply-btn show-apply-model" data-job-id="{{ $singleJobTask->id }}" data-job-company-logo="{{ asset($singleJobTask?->employerCompany?->logo) ?? '' }}">
{{--                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>--}}
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
                <img id="saveBtnImg{{ $singleJobTask->id }}" src="{{ asset('/frontend/employee/images/bookmark-white.png') }}" alt="Save" class="save-icon" style="width:16px;height:16px;filter:brightness(0);">
                <span id="saveBtnTxt{{ $singleJobTask->id }}">{{ trans('common.save') }}</span>
            </button>
        @endif
    </div>
@endif

<div class="sj-detail-meta-grid">
    <div class="sj-meta-item">
        <span class="sj-meta-label">Required Experience</span>
        <span class="sj-meta-value" id="reviewExperience">{{ $singleJobTask->required_experience ?? 0 }} Years</span>
    </div>
    <div class="sj-meta-item">
        <span class="sj-meta-label">Application Deadline</span>
        <span class="sj-meta-value" id="reviewDeadline">{{ \Illuminate\Support\Carbon::parse($singleJobTask->deadline)->format('d-M-Y') }}</span>
    </div>
    <div class="sj-meta-item">
        <span class="sj-meta-label">Salary</span>
        <span class="sj-meta-value" id="reviewSalary">BDT {{ $singleJobTask->salary_amount.' / '. $singleJobTask->job_pref_salary_payment_type }}</span>
    </div>
</div>

<div class="sj-detail-section">
    <h5 class="sj-detail-heading about-company-name">{{ trans('employer.about') }} {{ $singleJobTask?->employerCompany?->name ?? 'company Name' }}</h5>
    <p class="sj-detail-text">{!! $singleJobTask?->employerCompany?->company_overview ?? 'company overview' !!}</p>
</div>

@if(isset($singleJobTask->description))
    <div class="sj-detail-section">
        <h5 class="sj-detail-heading">{{ trans('employer.job_requirements') }}</h5>
        <div class="sj-detail-text job-requirements">
            {!! $singleJobTask->description ?? 'job description here' !!}
        </div>
    </div>
@endif

<div class="sj-detail-section">
    <h6 class="sj-detail-subheading">Field Of Study Preference</h6>
    <ul class="sj-detail-list" id="printFieldOfStudy">
        @foreach($singleJobTask->employerPrefferableFieldOfStudyNames as $fieldOfStudy)
            <li>{{ $fieldOfStudy->field_name }}</li>
        @endforeach
    </ul>
</div>

<div class="sj-detail-section">
    <h6 class="sj-detail-subheading">University Preference</h6>
    <ul class="sj-detail-list" id="printUniversity">
        @foreach($singleJobTask->employerPrefferableUniversityNames as $versityName)
            <li>{{ $versityName->name }}</li>
        @endforeach
    </ul>
</div>

<div class="sj-detail-section">
    <h5 class="sj-detail-heading">{{ trans('employer.gender_preference') }}</h5>
    <p class="sj-detail-text">{{ $singleJobTask->gender ?? '' }}</p>
</div>

@if($singleJobTask->jobRequiredskills->count() > 0)
    <div class="sj-detail-section">
        <h5 class="sj-detail-heading">Skills</h5>
        <div class="sj-skills-wrap">
            @foreach($singleJobTask->jobRequiredskills as $skill)
                <span class="sj-skill-pill">{{ $skill->skill_name }}</span>
            @endforeach
        </div>
    </div>
@endif
