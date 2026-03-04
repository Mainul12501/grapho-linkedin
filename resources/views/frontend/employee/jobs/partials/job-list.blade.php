@foreach($jobTasks as $key => $jobTask)
    <div class="sj-job-card job-card-ajax {{ isset($singleJobTask) && $singleJobTask->id == $jobTask->id ? 'sj-job-active' : '' }}"
         onclick="setLetSideActiveJob('{{ $jobTask->id }}')"
         data-job-id="{{ $jobTask->id }}"
         id="job-{{ $jobTask->id }}">
        <div class="sj-job-card-inner">
            <div class="sj-job-logo">
                <img src="{{ isset($jobTask?->employerCompany?->logo) ? asset($jobTask?->employerCompany?->logo) : asset('/frontend/employee/images/contentImages/jobCardLogo.png') }}"
                     alt="{{ $jobTask->job_title }}" />
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
@endforeach
