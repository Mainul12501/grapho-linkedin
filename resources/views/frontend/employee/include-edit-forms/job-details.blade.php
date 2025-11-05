<div class="company-info mb-2 d-flex">
    <a href="{{ route('view-company-profile', $singleJobTask->employer_company_id) }}" style="cursor: pointer">
        <img style="height: 40px; margin-right: 10px;" src="{{ isset($singleJobTask?->employerCompany?->logo) ? asset($singleJobTask?->employerCompany?->logo) : asset('/frontend/employee/images/contentImages/jobCardLogo.png') }}" alt="{{ $singleJobTask?->employerCompany?->name ?? 'job-0' }}" class="company-logo">
    </a>
    <div class="company-details d-flex pt-2" style="padding-top: 14px;">
        <h3 class="p-t-5"><a href="{{ route('view-company-profile', $singleJobTask->employer_company_id) }}" class="nav-link text-muted">{{ $singleJobTask?->employerCompany?->name ?? 'company name' }}</a></h3>
        <span class="mx-1 p-t-5">,</span>
        <p class="p-t-5">{{ $singleJobTask?->employerCompany?->address ?? 'company address' }}</p>
    </div>
</div>
<h4 class="job-title mb-2 f-s-19">{{ $singleJobTask->job_title }}</h4>
<div class="job-type"><span class="badge">{{ $singleJobTask?->jobType?->name ?? 'job type' }}</span> <span class="badge">{{ $singleJobTask?->jobLocationType?->name ?? 'job location' }}</span> </div>
@if(auth()->user()->user_type == 'employee' && $showApplyButton)
    <div class="d-flex gap-2 mt-1 mb-2">
        @if(!$isApplied)
            <form action="" method="post" class="apply-form">
                @csrf
                <div class="">
                    <button style="padding: 8px 20px;" type="submit" class="apply-btn show-apply-model"  data-job-id="{{ $singleJobTask->id }}" data-job-company-logo="{{ asset($singleJobTask?->employerCompany?->logo) ?? '' }}">{{ trans('employee.easy_apply') }}</button>

                </div>
            </form>
            {{--                        <a href="javascript:void(0)" onclick="document.getElementById('applyJob{{ $singleJobTask->id }}').submit()" class="apply-btn" style="text-decoration: none;">Easy Apply</a>--}}
        @else
            <form action="" method="post" class="apply-form">
                <div class="">
                    <button style="padding: 8px 20px;" type="submit" class="apply-btn " disabled >{{ trans('employee.applied') }}</button>

                </div>
            </form>
        @endif
        @if(!$isSaved)
            <button style="padding: 6px 20px;" is-saved="no" class="save-btn" data-job-id="{{ $singleJobTask->id }}"><img id="saveBtnImg{{ $singleJobTask->id }}" src="{{ asset('/') }}frontend/employee/images/contentImages/saveIcon.png" alt="Save Icon" class="save-icon"> <span id="saveBtnTxt{{ $singleJobTask->id }}">{{ trans('common.save') }}</span></button>
        @else
            <button style="padding: 6px 20px;" is-saved="yes" class="save-btn" data-job-id="{{ $singleJobTask->id }}"><img id="saveBtnImg{{ $singleJobTask->id }}" src="{{ asset('/frontend/bookmark-circle.png') }}" style="height: 20px; width: 20px" alt="Save Icon" class=""> <span id="saveBtnTxt{{ $singleJobTask->id }}">{{ trans('common.saved') }}</span></button>
        @endif
    </div>
@endif



<h5 style="" class="fw-bold about-company-name">{{ trans('employer.about') }} {{ $singleJobTask?->employerCompany?->name ?? 'company Name' }}</h5>
<p class="text-muted">{{ $singleJobTask?->employerCompany?->company_overview ?? 'company overview' }}</p>
<h5 class="fw-bold">{{ trans('employer.job_requirements') }}</h5>
<div class="job-requirements ms-0 text-muted" style="color: gray;">
    {!! $singleJobTask->description ?? 'job description here' !!}
</div>
