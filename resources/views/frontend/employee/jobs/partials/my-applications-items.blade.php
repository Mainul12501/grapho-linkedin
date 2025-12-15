{{--@forelse($myApplications as $myApplication)--}}
{{--    <div class="appliedJobs-row">--}}
{{--        <div class="position">--}}
{{--            {{ $myApplication?->jobTask?->employerCompany?->name ?? 'Company Name' }}--}}
{{--        </div>--}}

{{--        <div class="company">--}}
{{--            <img src="{{ asset($myApplication?->jobTask?->employerCompany?->logo ?? '/frontend/company-vector.jpg') }}"--}}
{{--                 height="28">--}}
{{--            <span>{{ $myApplication?->jobTask?->job_title ?? 'Job Title' }}</span>--}}
{{--        </div>--}}

{{--        <div class="date">--}}
{{--            {{ optional($myApplication?->jobTask?->created_at)->format('d-m-Y') }}--}}
{{--        </div>--}}

{{--        <div class="status {{ $myApplication->status }}">--}}
{{--            {{ ucfirst($myApplication->status) }}--}}
{{--        </div>--}}

{{--        <div class="action">--}}
{{--            <a href="{{ route('employee.show-jobs', $myApplication->jobTask?->id) }}">--}}
{{--                {{ trans('common.view_job_post') }}--}}
{{--            </a>--}}
{{--            <div class="action-menu-trigger" onclick="toggleActionMenu(this)">⋮</div>--}}
{{--            <div class="action-dropdown">--}}
{{--                <div>{{ trans('common.message') }}</div>--}}
{{--                <div><a href="{{ route('employee.show-jobs', ['job_task' => $myApplication?->jobTask?->id ]) }}" class="nav-link view-job" data-job-id="{{ $myApplication->job_task_id }}">{{ trans('common.view_job_post') }}</a></div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@empty--}}
{{--    <p class="text-center">{{ trans('employee.havent_applied_any_job') }}</p>--}}
{{--    <div class="appliedJobs-row">--}}
{{--        <p class="f-s-20 text-center mx-auto">{{ trans('employee.havent_applied_any_job') }}</p>--}}
{{--    </div>--}}
{{--    <style>--}}
{{--        .appliedJobs .appliedJobs-row {display: block}--}}
{{--    </style>--}}
{{--@endforelse--}}


@foreach($myApplications as $myApplication)
    <div class="appliedJobs-row">
        <div class="position">{{ $myApplication?->jobTask?->employerCompany?->name ?? 'Company Name' }}</div>
        <div class="company">
            <a href="{{ route('view-company-profile', ['employerCompany' => $myApplication?->jobTask?->employerCompany?->id ?? 3]) }}" style="text-decoration: none">
                <img src="{{ asset(isset($myApplication?->jobTask?->employerCompany?->logo) ? $myApplication?->jobTask?->employerCompany?->logo :'/frontend/company-vector.jpg') }}" alt="{{ $myApplication?->jobTask?->employerCompany?->name ?? 'company Name' }}"  height="28" />
                <span>{{ $myApplication?->jobTask?->job_title ?? 'Job Title' }}</span>
                <span>{{ $myApplication?->jobTask?->employerCompany?->name ?? 'Company Name' }}</span>
            </a>
        </div>
        <div class="date">{{ \Illuminate\Support\Carbon::parse($myApplication?->jobTask?->created_at)->format('d-m-Y') ?? '24-09-2024' }}</div>
        <div class="status @if($myApplication?->status == 'approved') accepted @endif @if($myApplication?->status == 'pending') pending @endif @if($myApplication?->status == 'shortlisted') bg-primary text-white @endif @if($myApplication?->status == 'rejected') bg-danger @endif ">@if($myApplication?->status == 'approved') {{ trans('employee.approved') }} @endif @if($myApplication?->status == 'pending') {{ trans('employee.pending') }} @endif @if($myApplication?->status == 'shortlisted') {{ trans('employee.shortlisted') }} @endif @if($myApplication?->status == 'rejected') {{ trans('employee.rejected') }} @endif</div>
        <div class="action">
            <div class="action-menu-trigger" onclick="toggleActionMenu(this)">⋮</div>
            <div class="action-dropdown">
                <div>{{ trans('common.message') }}</div>
                <div><a href="{{ route('employee.show-jobs', ['job_task' => $myApplication?->jobTask?->id ]) }}" class="nav-link view-job" data-job-id="{{ $myApplication->job_task_id }}">{{ trans('common.view_job_post') }}</a></div>
            </div>
        </div>
    </div>
@endforeach
