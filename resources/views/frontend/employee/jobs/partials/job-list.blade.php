@foreach($jobTasks as $key => $jobTask)
    <div class="job-card job-card-ajax border-bottom {{ isset($singleJobTask) && $singleJobTask->id == $jobTask->id ? 'active' : '' }}"
         onclick="setLetSideActiveJob({{ $key }})"
         data-job-id="{{ $jobTask->id }}"
         id="job-{{ $jobTask->id }}">
        <div class="row">
            <div class="col-2">
                <img style="cursor: pointer"
                     src="{{ isset($jobTask?->employerCompany?->logo) ? asset($jobTask?->employerCompany?->logo) : asset('/frontend/employee/images/contentImages/jobCardLogo.png') }}"
                     alt="{{ $jobTask->job_title }}"
                     class="img-fluid" />
            </div>
            <div class="col-10">
                <h5 class="mb-0">{{ $jobTask->job_title ?? trans('common.job_title') }}</h5>
                <p class="text-muted">
                    {{ $jobTask?->employerCompany?->name ?? trans('common.company_name') }}
                </p>
                <div class="job-type d-flex text-muted">
                    <span class="badge" style="background-color: #EDEFF2">{{ $jobTask?->jobType?->name ?? trans('common.full_time') }}</span>
                    <span class="badge" style="background-color: #EDEFF2">{{ $jobTask?->jobLocationType?->name ?? trans('common.on_site') }}</span>
                </div>
                <p class="job-location mt-2 mb-0 text-muted">{{ $jobTask?->employerCompany?->address ?? trans('common.company_address') }}</p>
                <p class="job-location mt-2 show-only-mobile mb-0 text-muted">{{ $jobTask->required_experience ?? 0 }} years experience</p>
                <p class="job-location mt-2 show-only-mobile mb-0 text-muted">Salary: {{ $jobTask->salary_amount ?? 0 }}/{{ $jobTask->job_pref_salary_payment_type ?? 'month' }}</p>
            </div>
        </div>
    </div>
@endforeach
