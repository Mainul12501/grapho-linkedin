@foreach($myApplications as $myApplication)
    <div class="ma-app-card" style="animation-delay: {{ $loop->index * 0.035 }}s">
        <!-- Desktop Row -->
        <div class="ma-row-desktop">
            <div class="ma-col-company">
                <a href="{{ route('view-company-profile', ['employerCompany' => $myApplication?->jobTask?->employerCompany?->id ?? 3]) }}" class="ma-company-link">
                    <img src="{{ asset(isset($myApplication?->jobTask?->employerCompany?->logo) ? $myApplication?->jobTask?->employerCompany?->logo : '/frontend/company-vector.jpg') }}" alt="{{ $myApplication?->jobTask?->employerCompany?->name ?? 'Company' }}" class="ma-company-logo" />
                    <span class="ma-company-name">{{ $myApplication?->jobTask?->employerCompany?->name ?? 'Company Name' }}</span>
                </a>
            </div>
            <div class="ma-col-position">
                <span class="ma-position-title">{{ $myApplication?->jobTask?->job_title ?? 'Job Title' }}</span>
            </div>
            <div class="ma-col-date">
                <span>{{ \Illuminate\Support\Carbon::parse($myApplication?->jobTask?->created_at)->format('d M, Y') ?? '24-09-2024' }}</span>
            </div>
            <div class="ma-col-status">
                <span class="ma-status-badge ma-status-{{ $myApplication?->status ?? 'pending' }}">
                    @if($myApplication?->status == 'approved')
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ trans('employee.approved') }}
                    @elseif($myApplication?->status == 'pending')
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        {{ trans('employee.pending') }}
                    @elseif($myApplication?->status == 'shortlisted')
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        {{ trans('employee.shortlisted') }}
                    @elseif($myApplication?->status == 'rejected')
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        {{ trans('employee.rejected') }}
                    @endif
                </span>
            </div>
            <div class="ma-col-action">
                <a href="{{ route('employee.show-jobs', ['job_task' => $myApplication?->jobTask?->id]) }}" class="ma-view-btn view-job" data-job-id="{{ $myApplication->job_task_id }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    View
                </a>
            </div>
        </div>

        <!-- Mobile Card -->
        <div class="ma-row-mobile">
            <div class="ma-mobile-top">
                <a href="{{ route('view-company-profile', ['employerCompany' => $myApplication?->jobTask?->employerCompany?->id ?? 3]) }}" class="ma-mobile-company-link">
                    <img src="{{ asset(isset($myApplication?->jobTask?->employerCompany?->logo) ? $myApplication?->jobTask?->employerCompany?->logo : '/frontend/company-vector.jpg') }}" alt="" class="ma-company-logo" />
                    <div class="ma-mobile-info">
                        <span class="ma-position-title">{{ $myApplication?->jobTask?->job_title ?? 'Job Title' }}</span>
                        <span class="ma-company-name">{{ $myApplication?->jobTask?->employerCompany?->name ?? 'Company Name' }}</span>
                    </div>
                </a>
                <span class="ma-status-badge ma-status-{{ $myApplication?->status ?? 'pending' }}">
                    @if($myApplication?->status == 'approved') {{ trans('employee.approved') }}
                    @elseif($myApplication?->status == 'pending') {{ trans('employee.pending') }}
                    @elseif($myApplication?->status == 'shortlisted') {{ trans('employee.shortlisted') }}
                    @elseif($myApplication?->status == 'rejected') {{ trans('employee.rejected') }}
                    @endif
                </span>
            </div>
            <div class="ma-mobile-bottom">
                <span class="ma-mobile-date">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ \Illuminate\Support\Carbon::parse($myApplication?->jobTask?->created_at)->format('d M, Y') }}
                </span>
                <a href="{{ route('employee.show-jobs', ['job_task' => $myApplication?->jobTask?->id]) }}" class="ma-view-btn view-job" data-job-id="{{ $myApplication->job_task_id }}">
                    View Details
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
        </div>
    </div>
@endforeach
