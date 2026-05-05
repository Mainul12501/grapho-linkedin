@extends('frontend.employee.master')

@section('title', 'My Profile')

@section('body')

    <!-- Main Content -->
    <div class="container container-main mt-3 profileMain">
        <aside class="left-panel p-3">
            <div class="card mp-card">
                <div class="card-body profile">
                    <!-- Profile Image -->
                    <div class="mp-avatar-wrap" data-bs-toggle="modal" data-bs-target="#changeProfileImageModal" title="Change profile image">
                        <img src="{{ asset(auth()->user()->profile_image ?? '/frontend/user-vector-img.jpg') }}" alt="Profile" class="mp-avatar" />
                        <span class="mp-avatar-edit">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </span>
                    </div>

                    <!-- Name -->
                    <h5 class="mp-name">{{ auth()->user()->name ?? trans('common.user_name') }}</h5>

                    <!-- Status Badge -->
                    <div class="d-flex justify-content-center justify-content-md-start">
                        <div class="dropdown d-flex align-items-center">
                            <span class="mp-status-badge d-flex align-items-center">
                                <span class="mp-status-dot {{ auth()->user()->is_open_for_hire == 1 ? 'mp-status-active' : 'mp-status-offline' }}"></span>
                                <span id="selectedRole">{{ auth()->user()->is_open_for_hire == 1 ? trans('employee.open_to_work') : trans('employee.offline') }}</span>
                            </span>
                            <button class="mp-dropdown-trigger" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                            </button>
                            <ul class="dropdown-menu mp-dropdown">
                                <li><a class="dropdown-item change-job-active-status" href="javascript:void(0)" data-value="1" data-msg="{{ trans('employee.open_to_work') }}">{{ trans('employee.open_to_work') }}</a></li>
                                <li><a class="dropdown-item change-job-active-status" href="javascript:void(0)" data-value="0" data-msg="{{ trans('employee.offline') }}">{{ trans('employee.offline') }}</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Profile Title -->
                    <p class="mp-bio" data-bs-toggle="modal" data-bs-target="#editBioModal">
                        {{ auth()->user()->profile_title ?? 'user profile title here.' }}
                    </p>

                    <!-- Mobile: View Profile Details -->
                    <div class="viewoProfileforSmallDevice mp-mobile-view-link">
                        <a href="" id="showMobileProfileEditBox">{{ trans('employee.view_profile_details') }}</a>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </div>

                    <!-- Edit Profile Section -->
                    <div class="profileEdit mp-edit-section">
                        <!-- Edit Bio -->
                        <div class="mp-edit-link bio-edit-icon" data-bs-toggle="modal" data-bs-target="#editBioModal">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            <span class="editBio">{{ trans('employee.edit_bio') }}</span>
                        </div>

                        <div class="mp-divider"></div>

                        <!-- Contact Info -->
                        <div class="mp-contact-list">
                            <div class="mp-contact-item profileIngo location">
                                <div class="mp-contact-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                </div>
                                <div class="mp-contact-text">
                                    <span class="mp-contact-label">{{ trans('common.address') }}</span>
                                    <span class="mp-contact-value">{{ auth()->user()->address ?? trans('common.user_address') }}</span>
                                </div>
                            </div>

                            <div class="mp-contact-item profileIngo email">
                                <div class="mp-contact-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                </div>
                                <div class="mp-contact-text">
                                    <span class="mp-contact-label">{{ trans('common.email') }}</span>
                                    <span class="mp-contact-value"><a href="mailto:{{ auth()->user()->email }}">{{ auth()->user()->email ?? 'user email' }}</a></span>
                                </div>
                            </div>

                            <div class="mp-contact-item profileIngo phone">
                                <div class="mp-contact-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                </div>
                                <div class="mp-contact-text">
                                    <span class="mp-contact-label">{{ trans('common.phone') }}</span>
                                    <span class="mp-contact-value">{{ auth()->user()->mobile ?? '01500000000' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Contact -->
                        <div class="mp-edit-link bio-edit-icon" data-bs-toggle="modal" data-bs-target="#editContactModal">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            <span class="editBio">{{ trans('employee.edit_contact_info') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Right Scrollable Content -->
        <section class="w-100">

            <!-- Stats Dashboard -->
            <div class="mp-stats-row">
                <div class="mp-stat-card mp-stat-saved">
                    <div class="mp-stat-icon-wrap">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <div class="mp-stat-content">
                        <span class="mp-stat-number">{{ $totalSavedJobs ?? 0 }}</span>
                        <span class="mp-stat-label">{{ trans('employee.jobs_saved') }}</span>
                    </div>
                    <span class="mp-stat-title">{{ trans('employee.my_saved_jobs') }}</span>
                </div>

                <div class="mp-stat-card mp-stat-apps">
                    <div class="mp-stat-icon-wrap">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    </div>
                    <div class="mp-stat-content">
                        <span class="mp-stat-number">{{ auth()->user()->employeeAppliedJobs()->count() ?? 0 }}</span>
                        <span class="mp-stat-label">{{ trans('employee.applications') }}</span>
                    </div>
                    <span class="mp-stat-title">{{ trans('employee.my_applications') }}</span>
                </div>

                <div class="mp-stat-card mp-stat-viewers">
                    <div class="mp-stat-icon-wrap">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </div>
                    <div class="mp-stat-content">
                        <span class="mp-stat-number">{{ auth()->user()->viewEmployeeIds()->count() ?? 0 }}</span>
                        <span class="mp-stat-label">{{ trans('employee.viewers') }}</span>
                    </div>
                    <span class="mp-stat-title">{{ trans('employee.my_profile_viewers') }}</span>
                </div>
            </div>

            <!-- Mobile User Options -->
            <div class="right-panel w-100 userOptionforMobile mp-mobile-options">
                <div class="userOptionforMobileWraperMain">
                    <a href="{{ route('employee.my-saved-jobs') }}" class="userOptionforMobileOptions mp-mobile-opt-link">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="left-side">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#484f5b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                                <span>Saved jobs</span>
                            </div>
                            <div class="right-side">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#667080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('employee.my-applications') }}" class="userOptionforMobileOptions mp-mobile-opt-link">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="left-side">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#484f5b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                <span>My applications</span>
                            </div>
                            <div class="right-side">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#667080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('employee.my-profile-viewers') }}" class="userOptionforMobileOptions mp-mobile-opt-link">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="left-side">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#484f5b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <span>Profile viewers</span>
                            </div>
                            <div class="right-side">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#667080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('employee.my-subscriptions') }}" class="userOptionforMobileOptions mp-mobile-opt-link">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="left-side">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#484f5b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                                <span>{{ trans('employee.subscription') }}</span>
                            </div>
                            <div class="right-side">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#667080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('employee.settings') }}" class="userOptionforMobileOptions mp-mobile-opt-link">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="left-side">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#484f5b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                                <span>{{ trans('employee.settings') }}</span>
                            </div>
                            <div class="right-side">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#667080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Work Experience -->
            <div class="mp-section">
                <div class="mp-section-header">
                    <div class="mp-section-title-group">
                        <div class="mp-section-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        </div>
                        <h3>{{ trans('employee.work_experiences') }}</h3>
                    </div>
                    <button class="mp-add-btn" data-bs-toggle="modal" data-bs-target="#addWorkExperienceModal">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        <span>{{ trans('common.add') }}</span>
                    </button>
                </div>

                @forelse($workExperiences as $workExperience)
                    <div class="mp-entry">
                        <div class="mp-entry-logo">
                            <img src="{{ isset($workExperience->company_logo) ? asset($workExperience->company_logo) : asset('/frontend/company-vector.jpg') }}" alt="Company Logo" />
                        </div>
                        <div class="mp-entry-body">
                            <div class="mp-entry-header">
                                <div>
                                    <h4 class="mp-entry-title">{{ $workExperience->title ?? 'Executive Officer, Sales' }}</h4>
                                    <p class="mp-entry-subtitle">
                                        {{ $workExperience->company_name ?? trans('common.company_name') }}
                                        @if($workExperience->job_type)
                                            <span class="mp-entry-tag">
                                                {{ $workExperience->job_type == 'part_time' ? "Part Time" : '' }}
                                                {{ $workExperience->job_type == 'full_time' ? trans('common.full_time') : '' }}
                                                {{ $workExperience->job_type == 'contractual' ? "Contractual" : '' }}
                                            </span>
                                        @endif
                                    </p>
                                    <p class="mp-entry-meta">
                                        {{ \Illuminate\Support\Carbon::parse($workExperience->start_date)->format('M Y') }} - {{ $workExperience->is_working_currently == 1 ? 'Present' : \Illuminate\Support\Carbon::parse($workExperience->end_date)->format('M Y') }}
                                        <span class="mp-meta-sep"></span>
                                        <span>{{ differTime($workExperience->start_date, $workExperience->is_working_currently == 1 ? now() : $workExperience->end_date ) }}</span>
                                    </p>
                                    @if($workExperience->office_address)
                                        <p class="mp-entry-location">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                            {{ $workExperience->office_address }}
                                        </p>
                                    @endif
                                    @if($workExperience->job_responsibilities)
                                        <div class="mp-entry-summary">
                                            <span class="mp-summary-label">Job Summary:</span>
                                            <div class="mp-summary-text">{!! str()->words($workExperience->job_responsibilities, 30, ' ......') !!}</div>
                                        </div>
                                    @endif
                                </div>
                                <div class="mp-entry-actions">
                                    <div class="dropdown">
                                        <button class="mp-menu-btn" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end mp-dropdown">
                                            <li><a class="dropdown-item edit-work-experience f-s-15" data-work-experience-id="{{ $workExperience->id }}" href="javascript:void(0)">{{ trans('common.edit') }}</a></li>
                                            <li>
                                                <form action="{{ route('employee.employee-work-experiences.destroy', $workExperience->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item data-delete-form f-s-15 text-danger" type="submit">{{ trans('common.delete') }}</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="mp-empty-state">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cfd2d9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        <p>No work experience added yet</p>
                    </div>
                @endforelse
            </div>

            <!-- Education -->
            <div class="mp-section">
                <div class="mp-section-header">
                    <div class="mp-section-title-group">
                        <div class="mp-section-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 10 3 12 0v-5"/></svg>
                        </div>
                        <h3>{{ trans('employee.education') }}</h3>
                    </div>
                    <button class="mp-add-btn" data-bs-toggle="modal" data-bs-target="#addEducationModal">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        <span>{{ trans('common.add') }}</span>
                    </button>
                </div>

                @forelse($employeeEducations as $employeeEducation)
                    <div class="mp-entry">
                        <div class="mp-entry-logo">
                            <img src="{{ asset('/') }}frontend/company-vector.jpg" alt="Institution Logo" />
                        </div>
                        <div class="mp-entry-body">
                            <div class="mp-entry-header">
                                <div>
                                    <h4 class="mp-entry-title">{{ $employeeEducation?->institute_name ?? 'Institute Name' }}</h4>
                                    <p class="mp-entry-subtitle">
                                        {{ $employeeEducation?->educationDegreeName?->degree_name ?? 'BBA' }} - {{ $employeeEducation?->field_of_study ?? 'Field Of Study' }}
                                        <span class="mp-entry-tag">{{ trans('common.cgpa') }} {{ $employeeEducation->cgpa ?? 0.00 }}</span>
                                    </p>
                                    <p class="mp-entry-meta">
                                        Passing Year: {{ $employeeEducation->passing_year ?? '1990' }}
                                    </p>
                                </div>
                                <div class="mp-entry-actions">
                                    <div class="dropdown">
                                        <button class="mp-menu-btn" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end mp-dropdown">
                                            <li><a class="dropdown-item edit-education f-s-15" data-education-id="{{ $employeeEducation->id }}" href="javascript:void(0)">{{ trans('common.edit') }}</a></li>
                                            <li>
                                                <form action="{{ route('employee.employee-educations.destroy', $employeeEducation->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item data-delete-form f-s-15 text-danger" type="submit">{{ trans('common.delete') }}</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="mp-empty-state">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cfd2d9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 10 3 12 0v-5"/></svg>
                        <p>{{ trans('employee.no_education_info_enlisted') }}</p>
                    </div>
                @endforelse
            </div>

            <!-- Documents -->
            <div class="mp-section">
                <div class="mp-section-header">
                    <div class="mp-section-title-group">
                        <div class="mp-section-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                        </div>
                        <h3>{{ trans('employee.documents') }}</h3>
                    </div>
                    <button class="mp-add-btn" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        <span>{{ trans('common.add') }}</span>
                    </button>
                </div>

                @forelse($employeeDocuments as $employeeDocument)
                    <div class="mp-entry mp-doc-entry">
                        <div class="mp-doc-preview">
                            <a href="{{ file_exists($employeeDocument->file) ? asset($employeeDocument->file) : '' }}" download="">
                                @if( explode('/', $employeeDocument->file_type)[0] == 'image' )
                                    <img src="{{ isset($employeeDocument->file) ? asset($employeeDocument->file) : asset('frontend/photo.png') }}" alt="Document" />
                                @elseif( explode('/', $employeeDocument->file_type)[1] == 'pdf' )
                                    <div class="mp-doc-icon mp-doc-pdf">
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                                        <span>PDF</span>
                                    </div>
                                @elseif( explode('/', $employeeDocument->file_type)[1] == 'vnd.openxmlformats-officedocument.wordprocessingml.document' )
                                    <div class="mp-doc-icon mp-doc-word">
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                        <span>DOC</span>
                                    </div>
                                @else
                                    <div class="mp-doc-icon">
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                                        <span>FILE</span>
                                    </div>
                                @endif
                            </a>
                        </div>
                        <div class="mp-entry-body">
                            <div class="mp-entry-header">
                                <div>
                                    <h4 class="mp-entry-title">{{ $employeeDocument->title }}</h4>
                                    <p class="mp-entry-meta">
                                        {{ explode('/', $employeeDocument->file_type)[0] }}
                                        <span class="mp-meta-sep"></span>
                                        <span>{{ $employeeDocument->file_size ?? 0 }} KB</span>
                                    </p>
                                </div>
                                <div class="mp-entry-actions">
                                    <div class="dropdown">
                                        <button class="mp-menu-btn" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end mp-dropdown">
                                            <li><a class="dropdown-item edit-document f-s-15" data-document-id="{{ $employeeDocument->id }}" href="javascript:void(0)">{{ trans('common.edit') }}</a></li>
                                            <li>
                                                <form action="{{ route('employee.employee-documents.destroy', $employeeDocument->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item data-delete-form f-s-15 text-danger" type="submit">{{ trans('common.delete') }}</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="mp-empty-state">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cfd2d9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                        <p>{{ trans('employee.no_documents_available') }}</p>
                    </div>
                @endforelse
            </div>

        </section>
    </div>

@endsection

@section('modal')

    <!-- Modal for Change Profile Image -->
    <div class="modal fade" id="changeProfileImageModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-1 " data-bs-dismiss="modal" />
                        {{ trans('employee.profile_image') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <form action="{{ route('employee.update-profile', auth()->id()) }}" method="post" enctype="multipart/form-data" id="profileImageForm">
                    @csrf
                    <div class="modal-body">
                        <div class="drag-drop-area" id="piDragDropArea" style="padding: 10px 40px">
                            <input type="file" class="file-input-hidden" id="piFileInput" name="profile_image" accept="image/*">
                            <div class="upload-content" id="piUploadContent">
                                <div class="upload-icon">📁</div>
                                <h5>{{ trans('employee.drag_drop_image') }}</h5>
                                <p class="text-muted">{{ trans('employee.or_click_to_browse') }}</p>
                                <small class="text-muted">{{ trans('employee.supports_jpg_png_gif') }}</small>
                            </div>
                        </div>
                        <div class="preview-container" id="piPreviewContainer" style="display: none;">
                            <img id="piImagePreview" style="max-width: 100%;">
                        </div>
                        <div class="crop-controls mt-3" id="piCropControls" style="display: none;">
                            <div class="d-flex gap-2 justify-content-center">
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="piResetCrop">🔄 {{ trans('employee.reset') }}</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="piRotateLeft">↺ {{ trans('employee.rotate_left') }}</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="piRotateRight">↻ {{ trans('employee.rotate_right') }}</button>
                                <button type="button" class="btn btn-success btn-sm" id="piCropImage">✂️ {{ trans('employee.crop_image') }}</button>
                            </div>
                        </div>
                        <div class="text-center mt-3" id="piFinalPreviewContainer" style="display: none;">
                            <h6>Cropped Image:</h6>
                            <img id="piFinalPreview" class="final-preview" alt="Cropped preview">
                            <div class="mt-2">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="piChangeImage">{{ trans('employee.change_image') }}</button>
                            </div>
                        </div>
                        <input type="hidden" id="piCroppedImageData" name="cropped_image_data">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('common.save_changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Edit Contact -->
    <div class="modal fade" id="editContactModal">
        <div class="modal-dialog custom-modal1 modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editContactModalLabel">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-1" />
                        {{ trans('employee.edit_contact_information') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <form action="{{ route('employee.update-profile', auth()->id()) }}" method="post" enctype="multipart/form-data" id="employeeUpdateProfile">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">{{ trans('common.name') }}</label>
                            <input type="text" name="name" class="form-control" id="nameInput" value="{!! auth()->user()->name ?? '' !!}" placeholder="{{ trans('auth.type_here') }}" />
                        </div>
                        <div class="mb-3">
                            <label for="emailInput" class="form-label">{{ trans('common.email') }}</label>
                            <input type="email" name="email" class="form-control" id="emailInput" value="{!! auth()->user()->email ?? '' !!}" placeholder="{{ trans('auth.type_here') }}" />
                        </div>
                        <div class="mb-3">
                            <label for="phoneInput" class="form-label">{{ trans('common.phone') }}</label>
                            <input type="tel" class="form-control" id="phoneInput" value="{!! auth()->user()->mobile ?? '' !!}" name="mobile" placeholder="{{ trans('auth.type_here') }}" />
                        </div>
                        <div class="mb-3">
                            <label for="phoneInput" class="form-label">{{ trans('employee.gender') }}</label>
                            <select name="gender" class=" select2" id="">
                                <option value="male" {{ auth()->user()->gender == 'male' ? 'selected' : '' }}>{{ trans('employee.male') }}</option>
                                <option value="female" {{ auth()->user()->gender == 'female' ? 'selected' : '' }}>{{ trans('employee.female') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="locationInput" class="form-label">{{ trans('common.address') }}</label>
                            <textarea name="address" class="form-control" id="locationInput" cols="30" rows="5">{!! auth()->user()->address ?? '' !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="divisions" class="form-label">{{ trans('employee.division') }}</label>
                            <select name="division" id="divisions" onchange="divisionsList()" class="form-control w-100" data-placeholder="Select Division">
                                <option value="Barishal" {{ auth()->user()->division == 'Barishal' ? 'selected' : '' }}>Barishal</option>
                                <option value="Chattogram" {{ auth()->user()->division == 'Chattogram' ? 'selected' : '' }}>Chattogram</option>
                                <option value="Dhaka" {{ auth()->user()->division == 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                                <option value="Khulna" {{ auth()->user()->division == 'Khulna' ? 'selected' : '' }}>Khulna</option>
                                <option value="Mymensingh" {{ auth()->user()->division == 'Mymensingh' ? 'selected' : '' }}>Mymensingh</option>
                                <option value="Rajshahi" {{ auth()->user()->division == 'Rajshahi' ? 'selected' : '' }}>Rajshahi</option>
                                <option value="Rangpur" {{ auth()->user()->division == 'Rangpur' ? 'selected' : '' }}>Rangpur</option>
                                <option value="Sylhet" {{ auth()->user()->division == 'Sylhet' ? 'selected' : '' }}>Sylhet</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="distr" class="form-label">{{ trans('employee.district') }}</label>
                            <select name="district" id="distr" onchange="thanaList()" class="form-control w-100" data-placeholder="Select District">
                                <option value="">{{ auth()->user()->district ?? '' }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="polic_sta" class="form-label">{{ trans('employee.post_office') }}</label>
                            <select name="post_office" id="polic_sta" class="form-control w-100" data-placeholder="Select District">
                                <option value="">{{ auth()->user()->post_office ?? '' }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="polic_sta" class="form-label">{{ trans('employee.post_code') }}</label>
                            <input type="text" name="postal_code" value="{{ auth()->user()->postal_code ?? '' }}" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="phoneInput" class="form-label">{{ trans('common.website') }}</label>
                            <input type="text" class="form-control" id="phoneInput" name="website" value="{!! auth()->user()->website ?? '' !!}" placeholder="{{ trans('auth.type_here') }}" />
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('common.save_changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Add Work Experience -->
    <div class="modal fade" id="addWorkExperienceModal" tabindex="-1" aria-labelledby="addWorkExperienceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWorkExperienceModalLabel">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-1" />{{ trans('employee.add_work_experience') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <form action="{{ route('employee.employee-work-experiences.store') }}" method="post" enctype="multipart/form-data" id="createEmployeeWorkExperienceForm">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-4">
                            <label for="jobTitleInput" class="form-label">{{ trans('employee.position') }}</label>
                            <input type="text" class="form-control" required name="title" id="jobTitleInput" placeholder="{{ trans('auth.type_here') }}" />
                        </div>
                        <div class="mb-4">
                            <label for="jobTypeInput" class="form-label">{{ trans('common.job_type') }}</label>
                            <select class="form-control" id="jobTypeInput" name="job_type">
                                <option value="">Select</option>
                                <option value="full_time">Full-time</option>
                                <option value="part_time">Part-time</option>
                                <option value="contractual">Contractual</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="companyInput" class="form-label">{{ trans('employee.company_organization') }}</label>
                            <input type="text" class="form-control" required list="companyDatalist" name="company_name" id="companyInput" placeholder="{{ trans('auth.type_here') }}" />
                        </div>
                        <div class="mb-4">
                            <div class="d-flex">
                                <span style="width: 100%; margin-right: 5px;">
                                    <label for="startDateInput" class="form-label">{{ trans('employee.from') }}</label>
                                    <input type="date" name="start_date" class="form-control m-1" />
                                </span>
                                <span style="width: 100%; margin-left: 5px;">
                                    <label for="startDateInput" class="form-label">{{ trans('employee.to') }}</label>
                                    <input type="date" name="end_date" class="form-control m-1" />
                                </span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="currentJobCheck" name="is_working_currently" />
                                <label class="form-check-label" for="currentJobCheck">{{ trans('employee.i_currently_work_here') }}</label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="locationInput" class="form-label">{{ trans('common.location') }}</label>
                            <input type="text" class="form-control" name="office_address" id="locationInput" placeholder="{{ trans('auth.type_here') }}" />
                        </div>
                        <div class="mb-4">
                            <label for="workSummaryInput" class="form-label">{{ trans('employee.responsibilities') }}</label>
                            <textarea class="form-control summernote" name="job_responsibilities" id="workSummaryInput" rows="4" placeholder="{{ trans('auth.type_here') }}"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('employee.add_experience') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Edit Work Experience -->
    <div class="modal fade" id="editWorkExperienceModal" tabindex="-1" aria-labelledby="addWorkExperienceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWorkExperienceModalLabel">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-1" />{{ trans('employee.update_work_experience') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <div id="workExperienceEditForm"></div>
            </div>
        </div>
    </div>

    <!-- Modal for Add Education -->
    <div class="modal fade" id="addEducationModal" tabindex="-1" aria-labelledby="addEducationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEducationModalLabel">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-1" />
                        {{ trans('employee.add_education') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <form action="{{ route('employee.employee-educations.store') }}" method="post" enctype="multipart/form-data" id="addEducationForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-4">
                            <label for="degreeInput" class="form-label">{{ trans('employee.program_name') }}</label>
                            <select name="education_degree_name_id" class="form-control " required id="">
                                @foreach($educationDegreeNames as $educationDegreeName)
                                    <option value="{{ $educationDegreeName->id }}" has-institute-name="{{ $educationDegreeName->need_institute_field }}">{{ $educationDegreeName->degree_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="universityDiv">
                            <div class="mb-4">
                                <label for="universityInput" class="form-label">{{ trans('employee.name_of_institution') }}</label>
                                <input type="text" required class="form-control" name="institute_name" id="universityInput" placeholder="{{ trans('auth.type_here') }}" />
                            </div>
                            <div class="mb-4">
                                <label for="fieldOfStudyInput" class="form-label">{{ trans('employee.background_field_of_study') }}</label>
                                <input required type="text" class="form-control" name="field_of_study" id="fieldOfStudyInput" placeholder="{{ trans('auth.type_here') }}" />
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="passingYear" class="form-label">{{ trans('employee.passing_year') }}</label>
                            <input type="number" min="1940" max="{{ date('Y') }}" required class="form-control" name="passing_year" id="passingYear" placeholder="{{ trans('auth.type_here') }}" />
                        </div>
                        <div class="mb-4">
                            <label for="cgpaInput" class="form-label">{{ trans('employee.cgpa') }}</label>
                            <input type="text" required name="cgpa" class="form-control" id="cgpaInput" placeholder="{{ trans('auth.type_here') }}" />
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('employee.add_education') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <datalist id="companyDatalist">
        @foreach($companyList as $company)
            <option value="{{ $company->name }}"></option>
        @endforeach
    </datalist>

    <!-- Modal for Edit Education -->
    <div class="modal fade" id="editEducationModal" tabindex="-1" aria-labelledby="addEducationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEducationModalLabel">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-1" />
                        {{ trans('employee.edit_education') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <div id="educationEditForm"></div>
            </div>
        </div>
    </div>

    <!-- Modal for Add Document -->
    <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDocumentModalLabel">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-1" />
                        {{ trans('employee.add_document') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <form action="{{ route('employee.employee-documents.store') }}" id="createEmployeeDocuments" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="documentFileTitleInput" class="form-label">{{ trans('employee.document_title') }}</label>
                            <div class="d-flex align-items-center">
                                <select name="title" required class=" select2" id="" style="width: 100%;">
                                    <option value="CV">CV</option>
                                    <option value="NID">NID</option>
                                    <option value="Certificate">Certificate</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="documentFileInput" class="form-label">{{ trans('employee.document_file') }}</label>
                            <div class="d-flex align-items-center">
                                <input type="file" required name="file" class="form-control" id="documentFileInput" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('employee.upload_document') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Edit Document -->
    <div class="modal fade" id="editDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDocumentModalLabel">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-1" />
                        {{ trans('employee.edit_document') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <div id="documentEditForm"></div>
            </div>
        </div>
    </div>

    <!-- Edit Bio Modal -->
    <div class="modal fade" id="editBioModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBioModalLabel">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-2" />
                        {{ trans('employee.edit_bio') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <form action="{{ route('employee.update-profile', auth()->id()) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bioTextarea" class="form-label">{{ trans('employee.your_bio') }}</label>
                            <textarea class="form-control" id="bioTextarea" name="profile_title" rows="5" placeholder="{{ trans('auth.type_here') }}">{{ auth()->user()->profile_title ?? 'Mobile App Developer, Flutter Developer Instructor & Mentor' }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('employee.save_bio') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('frontend/page-custom-codes/employee/my-profile/style.css') }}" />
@endpush

@push('script')

    @include('common-resource-files.summernote')
    @include('common-resource-files.selectize')

    <script src="{{ asset('/frontend/employee/division-Districts-post-station/javascript.js') }}"></script>


    <!-- CropperJS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    <script src="{{ asset('frontend/page-custom-codes/employee/my-profile/script.js') }}"></script>
@endpush
