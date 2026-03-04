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
    <style>
        /* ================================================
           MY PROFILE REDESIGN — Scoped with .mp- prefix
           ================================================ */

        /* --- Profile Card --- */
        .mp-card {
            border: none !important;
            border-radius: 16px !important;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(20,28,37,.06), 0 8px 24px rgba(20,28,37,.04);
        }

        .mp-card .card-body.profile {
            padding: 28px 24px !important;
        }

        /* Avatar */
        .mp-avatar-wrap {
            position: relative;
            display: inline-block;
            cursor: pointer;
            margin-bottom: 14px;
        }

        .mp-avatar {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 2px 12px rgba(20,28,37,.12);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .mp-avatar-wrap:hover .mp-avatar {
            transform: scale(1.04);
            box-shadow: 0 4px 20px rgba(20,28,37,.18);
        }

        .mp-avatar-edit {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 30px;
            height: 30px;
            background: #141c25;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2.5px solid #fff;
            transition: background .2s ease;
        }

        .mp-avatar-wrap:hover .mp-avatar-edit {
            background: #FFCB11;
        }

        .mp-avatar-wrap:hover .mp-avatar-edit svg {
            stroke: #141c25;
        }

        /* Name */
        .mp-name {
            font-weight: 700 !important;
            font-size: 22px !important;
            color: #141c25 !important;
            margin-bottom: 10px !important;
            letter-spacing: -0.3px;
        }

        /* Status Badge */
        .mp-status-badge {
            background: #f0faf4 !important;
            border: 1.5px solid #c6ecd6;
            border-radius: 100px !important;
            padding: 5px 14px !important;
            font-weight: 500 !important;
            font-size: 13px !important;
            color: #008a22 !important;
            gap: 8px;
            width: auto !important;
            transition: all .2s ease;
        }

        .mp-status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }

        .mp-status-active {
            background: #008a22;
            box-shadow: 0 0 0 3px rgba(0,138,34,.2);
            animation: mp-pulse 2s infinite;
        }

        .mp-status-offline {
            background: #9ca3af;
        }

        @keyframes mp-pulse {
            0%, 100% { box-shadow: 0 0 0 3px rgba(0,138,34,.2); }
            50% { box-shadow: 0 0 0 6px rgba(0,138,34,.08); }
        }

        .mp-dropdown-trigger {
            background: none;
            border: none;
            padding: 4px;
            cursor: pointer;
            color: #667080;
            border-radius: 6px;
            transition: background .15s ease;
            display: flex;
            align-items: center;
        }

        .mp-dropdown-trigger:hover {
            background: #f3f4f6;
        }

        /* Dropdown Styling */
        .mp-dropdown {
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            box-shadow: 0 8px 24px rgba(20,28,37,.12) !important;
            padding: 6px !important;
            min-width: 160px !important;
        }

        .mp-dropdown .dropdown-item {
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 14px;
            font-weight: 500;
            transition: background .12s ease;
        }

        .mp-dropdown .dropdown-item:hover {
            background: #f8f9fa;
        }

        /* Bio */
        .mp-bio {
            font-size: 14px !important;
            color: #484f5b !important;
            line-height: 1.6 !important;
            margin: 14px 0 !important;
            cursor: pointer;
            padding: 10px 14px;
            background: #f9fafb;
            border-radius: 10px;
            border: 1px dashed #e5e7eb;
            transition: all .2s ease;
        }

        .mp-bio:hover {
            border-color: #FFCB11;
            background: #fffdf5;
        }

        /* Mobile View Link — hidden on desktop, shown on mobile */
        .mp-mobile-view-link {
            padding: 14px 0 4px;
            border-top: 1px solid #f0f1f3;
            display: none;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .mp-mobile-view-link a {
            font-weight: 600;
            font-size: 15px;
            color: #141c25;
            text-decoration: none;
        }

        /* Edit Section */
        .mp-edit-section {
            margin-top: 4px;
        }

        .mp-edit-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            cursor: pointer;
            border-radius: 10px;
            transition: background .15s ease;
            color: #141c25;
            margin: 4px -4px;
        }

        .mp-edit-link:hover {
            background: #f8f9fa;
        }

        .mp-edit-link .editBio {
            font-weight: 600;
            font-size: 14px;
            text-decoration: none !important;
            color: #141c25;
        }

        .mp-divider {
            height: 1px;
            background: #f0f1f3;
            margin: 8px 0 12px;
        }

        /* Contact List */
        .mp-contact-list {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .mp-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 10px 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: background .15s ease;
        }

        .mp-contact-item:hover {
            background: #f9fafb;
        }

        .mp-contact-icon {
            width: 36px;
            height: 36px;
            background: #f3f4f6;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #484f5b;
        }

        .mp-contact-text {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .mp-contact-label {
            font-weight: 600;
            font-size: 13px;
            color: #667080;
            /*text-transform: uppercase;*/
            letter-spacing: 0.4px;
        }

        .mp-contact-value {
            font-weight: 500;
            font-size: 14px;
            color: #141c25;
            word-break: break-word;
            overflow-wrap: anywhere;
            line-height: 1.5;
        }

        .mp-contact-value a {
            color: #141c25;
            text-decoration: none;
        }

        .mp-contact-value a:hover {
            /*color: #FFCB11;*/
            color: blue;
        }

        /* --- Stats Row --- */
        .mp-stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            padding: 12px;
        }

        .mp-stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 20px 18px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            border: 1px solid #f0f1f3;
            transition: transform .2s ease, box-shadow .2s ease;
            cursor: default;
            position: relative;
            overflow: hidden;
        }

        .mp-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 3px 3px 0 0;
        }

        .mp-stat-saved::before { background: #FFCB11; }
        .mp-stat-apps::before { background: #3b82f6; }
        .mp-stat-viewers::before { background: #10b981; }

        .mp-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(20,28,37,.08);
        }

        .mp-stat-icon-wrap {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mp-stat-saved .mp-stat-icon-wrap { background: #FFF8E1; color: #d4a017; }
        .mp-stat-apps .mp-stat-icon-wrap { background: #eff6ff; color: #3b82f6; }
        .mp-stat-viewers .mp-stat-icon-wrap { background: #ecfdf5; color: #10b981; }

        .mp-stat-content {
            display: flex;
            flex-direction: column;
        }

        .mp-stat-number {
            font-weight: 700;
            font-size: 28px;
            line-height: 1;
            color: #141c25;
            letter-spacing: -1px;
        }

        .mp-stat-label {
            font-weight: 400;
            font-size: 13px;
            color: #667080;
            margin-top: 4px;
        }

        .mp-stat-title {
            font-weight: 500;
            font-size: 13px;
            color: #9ca3af;
            display: none;
        }

        /* --- Sections (Work Experience, Education, Documents) --- */
        .mp-section {
            background: #fff;
            border-radius: 14px;
            margin-top: 14px;
            border: 1px solid #f0f1f3;
            overflow: hidden;
        }

        .mp-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid #f0f1f3;
        }

        .mp-section-title-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mp-section-icon {
            width: 40px;
            height: 40px;
            background: #f8f9fa;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #484f5b;
        }

        .mp-section-header h3 {
            font-weight: 700;
            font-size: 18px;
            color: #141c25;
            margin: 0;
            letter-spacing: -0.3px;
        }

        .mp-add-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            background: #fff;
            color: #141c25;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .mp-add-btn:hover {
            border-color: #FFCB11;
            background: #fffdf5;
            box-shadow: 0 2px 8px rgba(255,203,17,.15);
        }

        /* Entries */
        .mp-entry {
            display: flex;
            gap: 16px;
            padding: 20px 24px;
            border-bottom: 1px solid #f7f8f9;
            transition: background .15s ease;
        }

        .mp-entry:last-child {
            border-bottom: none;
        }

        .mp-entry:hover {
            background: #fafbfc;
        }

        .mp-entry-logo {
            flex-shrink: 0;
        }

        .mp-entry-logo img {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid #f0f1f3;
        }

        .mp-entry-body {
            flex: 1;
            min-width: 0;
        }

        .mp-entry-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }

        .mp-entry-title {
            font-weight: 600;
            font-size: 16px;
            color: #141c25;
            margin: 0 0 4px;
            line-height: 1.4;
        }

        .mp-entry-subtitle {
            font-size: 14px;
            color: #484f5b;
            margin: 0 0 6px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .mp-entry-tag {
            display: inline-flex;
            align-items: center;
            padding: 2px 10px;
            background: #f3f4f6;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 500;
            color: #667080;
        }

        .mp-entry-meta {
            font-size: 13px;
            color: #667080;
            margin: 0 0 4px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 4px;
        }

        .mp-meta-sep {
            display: inline-block;
            width: 3px;
            height: 3px;
            background: #cfd2d9;
            border-radius: 50%;
            margin: 0 4px;
        }

        .mp-entry-location {
            font-size: 13px;
            color: #667080;
            margin: 4px 0 0;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .mp-entry-summary {
            margin-top: 12px;
            padding: 12px 14px;
            background: #f9fafb;
            border-radius: 10px;
            border-left: 3px solid #FFCB11;
        }

        .mp-summary-label {
            font-weight: 600;
            font-size: 13px;
            color: #141c25;
            display: block;
            margin-bottom: 4px;
        }

        .mp-summary-text {
            font-size: 13px;
            color: #484f5b;
            line-height: 1.6;
        }

        .mp-summary-text ul, .mp-summary-text ol {
            padding-left: 18px;
            margin: 4px 0;
        }

        /* Entry Actions (three-dot menu) */
        .mp-menu-btn {
            background: none;
            border: none;
            padding: 6px;
            cursor: pointer;
            color: #9ca3af;
            border-radius: 8px;
            transition: all .15s ease;
            display: flex;
            align-items: center;
        }

        .mp-menu-btn:hover {
            background: #f3f4f6;
            color: #484f5b;
        }

        /* Document Entries */
        .mp-doc-entry .mp-doc-preview {
            flex-shrink: 0;
        }

        .mp-doc-preview img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #f0f1f3;
        }

        .mp-doc-icon {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            background: #f8f9fa;
            border: 1px solid #f0f1f3;
            color: #667080;
        }

        .mp-doc-icon span {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .mp-doc-pdf { color: #ef4444; border-color: #fecaca; background: #fef2f2; }
        .mp-doc-word { color: #3b82f6; border-color: #bfdbfe; background: #eff6ff; }

        /* Empty State */
        .mp-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            text-align: center;
        }

        .mp-empty-state p {
            font-size: 14px;
            color: #9ca3af;
            margin: 12px 0 0;
        }

        /* Mobile Options */
        .mp-mobile-opt-link {
            text-decoration: none !important;
        }

        .mp-mobile-opt-link .left-side {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .mp-mobile-opt-link .left-side span {
            font-weight: 500;
            font-size: 15px;
            color: #141c25;
        }

        /* --- Modal Improvements --- */
        .modal .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 16px 48px rgba(20,28,37,.16);
        }

        .modal .modal-header {
            border-bottom: 1px solid #f0f1f3;
            padding: 18px 24px;
        }

        .modal .modal-body {
            padding: 24px;
        }

        .modal .modal-footer {
            border-top: 1px solid #f0f1f3;
            padding: 16px 24px;
        }

        .modal .form-control {
            border-radius: 10px !important;
            border: 1.5px solid #e5e7eb;
            padding: 12px 14px;
            font-size: 14px;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .modal .form-control:focus {
            border-color: #FFCB11;
            box-shadow: 0 0 0 3px rgba(255,203,17,.15) !important;
        }

        .modal .btn-primary {
            background: #FFCB11 !important;
            color: #141c25 !important;
            border: none !important;
            border-radius: 10px;
            padding: 10px 22px;
            font-weight: 600;
            transition: all .2s ease;
        }

        .modal .btn-primary:hover {
            background: #e6b70f !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255,203,17,.3);
        }

        .modal .btn-outline-secondary {
            border-radius: 10px;
            padding: 10px 22px;
            font-weight: 500;
            border-color: #e5e7eb;
        }

        /* --- Responsive --- */
        @media (max-width: 768px) {
            .mp-mobile-view-link {
                display: flex;
            }

            .mp-stats-row {
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
                padding: 8px;
            }

            .mp-stat-card {
                padding: 14px 12px;
            }

            .mp-stat-number {
                font-size: 22px;
            }

            .mp-stat-label {
                font-size: 11px;
            }

            .mp-section {
                border-radius: 0;
                margin-top: 8px;
                border-left: none;
                border-right: none;
            }

            .mp-section-header {
                padding: 16px;
            }

            .mp-entry {
                padding: 16px;
            }

            .mp-entry-logo img {
                width: 40px;
                height: 40px;
                border-radius: 10px;
            }

            .mp-entry-title {
                font-size: 15px;
            }

            .mp-doc-preview img,
            .mp-doc-icon {
                width: 56px;
                height: 56px;
            }

            .profileEdit {
                display: none;
            }

            .profile {
                text-align: center;
                padding-top: 60px;
            }

            .profileMain .left-panel {
                display: block;
                position: relative;
                top: 0;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                flex: unset !important;
            }

            .mp-card {
                border-radius: 0 !important;
            }

            .mp-add-btn span {
                display: none;
            }

            .mp-section-header h3 {
                font-size: 16px;
            }

            .bio-edit-icon {
                display: block !important;
            }

            .location, .email, .phone {
                text-align: left;
            }

            #editContactModal label {
                display: flex;
            }

            .mp-mobile-options {
                border-radius: 0;
                margin-top: 8px;
            }
        }

        @media (max-width: 380px) {
            .mp-stats-row {
                grid-template-columns: 1fr;
            }

            .mp-stat-card {
                flex-direction: row;
                align-items: center;
                gap: 14px;
            }

            .mp-stat-card::before {
                display: none;
            }
        }

        @media (min-width: 769px) {
            .mp-stats-row {
                padding: 12px 0;
            }
        }

        /* Animations */
        .mp-section {
            animation: mp-fadeUp .4s ease both;
        }

        .mp-section:nth-child(2) { animation-delay: .05s; }
        .mp-section:nth-child(3) { animation-delay: .1s; }

        @keyframes mp-fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .mp-stat-card {
            animation: mp-fadeUp .35s ease both;
        }

        .mp-stat-card:nth-child(1) { animation-delay: .05s; }
        .mp-stat-card:nth-child(2) { animation-delay: .1s; }
        .mp-stat-card:nth-child(3) { animation-delay: .15s; }

        /* Drag-drop area (profile image modal) */
        .drag-drop-area {
            border: 2px dashed #FFCB11;
            border-radius: 14px;
            padding: 40px;
            text-align: center;
            background: #fffdf5;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .drag-drop-area:hover {
            border-color: #e6b70f;
            background: #fff8e1;
        }

        .drag-drop-area.dragover {
            border-color: #10b981;
            background: #ecfdf5;
        }

        .preview-container {
            max-width: 100%;
            max-height: 400px;
            overflow: hidden;
            border-radius: 12px;
            margin: 15px 0;
        }

        .file-input-hidden {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .upload-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .final-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #FFCB11;
        }

        /* Form control overrides */
        .form-control {
            border-radius: 10px !important;
        }

        .selectize-input {
            padding: 12px !important;
            border-radius: 10px !important;
        }
    </style>
@endpush

@push('script')

    @include('common-resource-files.summernote')
    @include('common-resource-files.selectize')

    <script src="{{ asset('/frontend/employee/division-Districts-post-station/javascript.js') }}"></script>

    <script>
        // Edit Work Experience
        $(document).on('click', '.edit-work-experience', function () {
            var jobId = $(this).attr('data-work-experience-id');
            var thisObject = $(this);
            sendAjaxRequest('employee/employee-work-experiences/'+jobId+'/edit', 'GET').then(function (response) {
                $('#workExperienceEditForm').append(response);
                $('#editWorkSummaryInput').summernote({
                    height: 300
                });
                $('.select2').selectize();
                $('#editWorkExperienceModal').modal('show');
            })
        })

        // Edit Education
        $(document).on('click', '.edit-education', function () {
            var jobId = $(this).attr('data-education-id');
            var thisObject = $(this);
            sendAjaxRequest('employee/employee-educations/'+jobId+'/edit', 'GET').then(function (response) {
                $('#educationEditForm').append(response);
                $('.select2').selectize();
                $('#editEducationModal').modal('show');
            })
        })

        // Edit Document
        $(document).on('click', '.edit-document', function () {
            var jobId = $(this).attr('data-document-id');
            sendAjaxRequest('employee/employee-documents/'+jobId+'/edit', 'GET').then(function (response) {
                $('#documentEditForm').append(response);
                $('.select2').selectize();
                $('#editDocumentModal').modal('show');
            })
        })

        // Change job active status
        $(document).on('click', '.change-job-active-status', function () {
            var val = $(this).attr('data-value');
            var msg = $(this).attr('data-msg');
            sendAjaxRequest('employee/change-job-active-status/'+val, 'GET').then(function (response) {
                if (response.status == 'success') {
                    $('#selectedRole').text(msg);
                    toastr.success(response.success);
                } else {
                    toastr.error('Something went wrong. Please try again.');
                }
            })
        })
    </script>

    <script>
        // Toggle institute name on education degree change
        function toggleInstituteNameOnEducationDegreeChange(hasInstituteNameValue = 0) {
            if (hasInstituteNameValue == 1) {
                $('#instituteNameDiv').removeClass('d-none');
                $('#universityDiv').addClass('d-none');
                $('label[for="cgpaInput"]').text('Grade');
            } else {
                $('#universityDiv').removeClass('d-none');
                $('#instituteNameDiv').addClass('d-none');
                $('input[name="institute_name"]').val('');
                $('input[name="group_name"]').val('');
                $('label[for="cgpaInput"]').text('GPA');
            }
        }

        // Disable end date on current job check
        $(document).on('change', '#currentJobCheck', function () {
            if ($(this).is(':checked')) {
                $('input[name="end_date"]').prop('disabled', true).val('');
            } else {
                $('input[name="end_date"]').prop('disabled', false);
            }
        });

        // Disable end date on current job check during edit
        $(document).on('change', '#editCurrentJobCheck', function () {
            if ($(this).is(':checked')) {
                $('input[name="end_date"]').prop('disabled', true).val('');
            } else {
                $('input[name="end_date"]').prop('disabled', false);
            }
        });
    </script>

    <!-- CropperJS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <script>
        // Profile Image Modal - Drag Drop Crop
        (function() {
            let cropper = null;
            let originalFile = null;

            const dragDropArea = document.getElementById('piDragDropArea');
            const fileInput = document.getElementById('piFileInput');
            const uploadContent = document.getElementById('piUploadContent');
            const previewContainer = document.getElementById('piPreviewContainer');
            const imagePreview = document.getElementById('piImagePreview');
            const cropControls = document.getElementById('piCropControls');
            const finalPreviewContainer = document.getElementById('piFinalPreviewContainer');
            const finalPreview = document.getElementById('piFinalPreview');
            const croppedImageData = document.getElementById('piCroppedImageData');

            dragDropArea.addEventListener('click', () => fileInput.click());
            dragDropArea.addEventListener('dragover', (e) => { e.preventDefault(); dragDropArea.classList.add('dragover'); });
            dragDropArea.addEventListener('dragleave', (e) => { e.preventDefault(); dragDropArea.classList.remove('dragover'); });
            dragDropArea.addEventListener('drop', (e) => {
                e.preventDefault();
                dragDropArea.classList.remove('dragover');
                if (e.dataTransfer.files.length > 0) handleFile(e.dataTransfer.files[0]);
            });
            fileInput.addEventListener('change', (e) => { if (e.target.files[0]) handleFile(e.target.files[0]); });

            document.getElementById('piResetCrop').addEventListener('click', (e) => { e.preventDefault(); cropper && cropper.reset(); });
            document.getElementById('piRotateLeft').addEventListener('click', (e) => { e.preventDefault(); cropper && cropper.rotate(-90); });
            document.getElementById('piRotateRight').addEventListener('click', (e) => { e.preventDefault(); cropper && cropper.rotate(90); });
            document.getElementById('piCropImage').addEventListener('click', (e) => { e.preventDefault(); handleCropImage(); });
            document.getElementById('piChangeImage').addEventListener('click', (e) => { e.preventDefault(); resetUpload(); });

            function handleFile(file) {
                if (!file.type.startsWith('image/')) { alert('Please select an image file.'); return; }
                if (file.size > 5 * 1024 * 1024) { alert('File size must be less than 5MB.'); return; }
                originalFile = file;
                const reader = new FileReader();
                reader.onload = (e) => displayImageForCropping(e.target.result);
                reader.readAsDataURL(file);
            }

            function displayImageForCropping(imageSrc) {
                uploadContent.style.display = 'none';
                previewContainer.style.display = 'block';
                cropControls.style.display = 'block';
                finalPreviewContainer.style.display = 'none';
                imagePreview.src = imageSrc;
                if (cropper) cropper.destroy();
                cropper = new Cropper(imagePreview, {
                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 0.8,
                    restore: false,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                });
            }

            function handleCropImage() {
                if (!cropper) return;
                const canvas = cropper.getCroppedCanvas({ width: 300, height: 300, imageSmoothingEnabled: true, imageSmoothingQuality: 'high' });
                canvas.toBlob((blob) => {
                    finalPreview.src = URL.createObjectURL(blob);
                    croppedImageData.value = canvas.toDataURL('image/jpeg', 0.8);
                    previewContainer.style.display = 'none';
                    cropControls.style.display = 'none';
                    finalPreviewContainer.style.display = 'block';
                }, 'image/jpeg', 0.8);
            }

            function resetUpload() {
                if (cropper) { cropper.destroy(); cropper = null; }
                fileInput.value = '';
                croppedImageData.value = '';
                originalFile = null;
                uploadContent.style.display = 'block';
                previewContainer.style.display = 'none';
                cropControls.style.display = 'none';
                finalPreviewContainer.style.display = 'none';
            }

            document.getElementById('changeProfileImageModal').addEventListener('hidden.bs.modal', function () {
                resetUpload();
            });
        })();
    </script>

    {{-- Form Validation --}}
    <script>
        // ============================================
        // COMMON VALIDATION FUNCTIONS
        // ============================================

        function validateRequired(value, fieldName) {
            if (!value || value.trim() === '') {
                toastr.error(`${fieldName} is required`);
                return false;
            }
            return true;
        }

        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                toastr.error('Please enter a valid email address');
                return false;
            }
            return true;
        }

        function validateBDPhone(phone) {
            const phoneRegex = /^0\d{10}$/;
            if (!phoneRegex.test(phone)) {
                toastr.error('Invalid Phone Number.');
                return false;
            }
            return true;
        }

        function getFieldLabel($field) {
            const $label = $('label[for="' + $field.attr('id') + '"]');
            return $label.length ? $label.text().replace('*', '').trim() : $field.attr('name');
        }

        // ============================================
        // EMPLOYEE PROFILE UPDATE FORM VALIDATION
        // ============================================

        function validateEmployeeProfileForm() {
            let isValid = true;
            const $form = $('#employeeUpdateProfile');

            $form.find('[required]').each(function() {
                const $field = $(this);
                const value = $field.val();
                const fieldLabel = getFieldLabel($field);

                if (!validateRequired(value, fieldLabel)) {
                    isValid = false;
                    $field.addClass('is-invalid');
                    return false;
                } else {
                    $field.removeClass('is-invalid');
                }
            });

            if (!isValid) return false;

            const email = $form.find('input[name="email"]').val();
            if (email && !validateEmail(email)) {
                $form.find('input[name="email"]').addClass('is-invalid');
                return false;
            } else {
                $form.find('input[name="email"]').removeClass('is-invalid');
            }

            const phone = $form.find('input[name="mobile"]').val();
            if (phone && !validateBDPhone(phone)) {
                $form.find('input[name="mobile"]').addClass('is-invalid');
                return false;
            } else {
                $form.find('input[name="mobile"]').removeClass('is-invalid');
            }

            return true;
        }

        // ============================================
        // WORK EXPERIENCE FORM VALIDATION
        // ============================================
        function validateWorkExperienceForm($form) {
            let valid = true;

            const title = $form.find('input[name="title"]').val();
            if (!title.trim()) {
                toastr.error('Position title is required');
                valid = false;
            }

            const startDate = $form.find('input[name="start_date"]').val();
            if (!startDate) {
                toastr.error('Start date is required');
                valid = false;
            }

            const isCurrent = $form.find('input[name="is_working_currently"]').is(':checked');
            const endDate = $form.find('input[name="end_date"]').val();

            if (!isCurrent && !endDate) {
                toastr.error('End date is required if not currently working');
                valid = false;
            }

            if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
                toastr.error('End date cannot be earlier than start date');
                valid = false;
            }

            return valid;
        }

        // ============================================
        // EDUCATION FORM VALIDATION
        // ============================================
        function validateEducationForm($form) {
            let valid = true;

            const degree = $form.find('[name="education_degree_name_id"]').val();
            const institute = $form.find('[name="institute_name"]').val()?.trim();
            const field = $form.find('[name="field_of_study"]').val()?.trim();
            const year = $form.find('[name="passing_year"]').val()?.trim();
            const cgpa = $form.find('[name="cgpa"]').val()?.trim();

            if (!degree) { toastr.error('Education program is required'); valid = false; }
            if (!institute) { toastr.error('Institute name is required'); valid = false; }
            else if (/\d/.test(institute)) { toastr.error('Institute name cannot contain numbers'); valid = false; }
            if (!field) { toastr.error('Field of study is required'); valid = false; }
            else if (/\d/.test(field)) { toastr.error('Field of study cannot contain numbers'); valid = false; }
            if (!year) { toastr.error('Passing year is required'); valid = false; }
            else if (!/^\d{4}$/.test(year)) { toastr.error('Passing year must be a valid year (e.g., 2022)'); valid = false; }
            if (!cgpa) { toastr.error('CGPA is required'); valid = false; }
            else if (!/^\d+(\.\d+)?$/.test(cgpa)) { toastr.error('CGPA must be a number (e.g., 3.75)'); valid = false; }

            return valid;
        }

        // ============================================
        // FORM SUBMIT HANDLERS
        // ============================================

        $(document).ready(function() {

            // Employee Profile Update Form
            $('#employeeUpdateProfile').on('submit', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const $submitBtn = $(this).find('button[type="submit"]');
                if (validateEmployeeProfileForm()) {
                    const formData = new FormData(this);
                    $submitBtn.prop('disabled', true).text('Saving...');

                    const croppedData = $('#croppedImageData').val();
                    if (croppedData) {
                        const arr = croppedData.split(',');
                        const mime = arr[0].match(/:(.*?);/)[1];
                        const bstr = atob(arr[1]);
                        let n = bstr.length;
                        const u8arr = new Uint8Array(n);
                        while (n--) { u8arr[n] = bstr.charCodeAt(n); }
                        const blob = new Blob([u8arr], { type: mime });
                        formData.delete('profile_image');
                        formData.append('profile_image', blob, 'profile.jpg');
                    }

                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            toastr.success('Profile updated successfully!');
                            $('#editContactModal').modal('hide');
                            setTimeout(() => location.reload(), 1500);
                        },
                        complete: function () {
                            $submitBtn.prop('disabled', false).text('{{ trans("common.save_changes") }}');
                        },
                        error: function(xhr) {
                            toastr.error('Failed to update profile. Please try again.');
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            // Profile Image Form
            $('#profileImageForm').on('submit', function(e) {
                e.preventDefault();
                const $submitBtn = $(this).find('button[type="submit"]');
                const croppedData = $('#piCroppedImageData').val();

                if (!croppedData) {
                    toastr.error('Please select and crop an image first.');
                    return;
                }

                const formData = new FormData(this);
                const arr = croppedData.split(',');
                const mime = arr[0].match(/:(.*?);/)[1];
                const bstr = atob(arr[1]);
                let n = bstr.length;
                const u8arr = new Uint8Array(n);
                while (n--) { u8arr[n] = bstr.charCodeAt(n); }
                const blob = new Blob([u8arr], { type: mime });
                formData.delete('profile_image');
                formData.append('profile_image', blob, 'profile.jpg');

                $submitBtn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success('Profile image updated successfully!');
                        $('#changeProfileImageModal').modal('hide');
                        setTimeout(() => location.reload(), 1500);
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false).text('{{ trans("common.save_changes") }}');
                    },
                    error: function(xhr) {
                        toastr.error('Failed to update profile image. Please try again.');
                        console.error(xhr.responseText);
                    }
                });
            });

            // Work Experience Form Validation
            $('#createEmployeeWorkExperienceForm').on('submit', function(e) {
                e.preventDefault();
                const $form = $(this);
                if (validateWorkExperienceForm($form)) {
                    this.submit();
                }
            });

            $(document).on('shown.bs.modal', '#editWorkExperienceModal', function() {
                const $form = $(this).find('form#editEmployeeWorkExperienceForm');
                $form.off('submit.validate');
                $form.on('submit.validate', function(e) {
                    e.preventDefault();
                    if (validateWorkExperienceForm($form)) {
                        this.submit();
                    }
                });
            });

            // Document validation
            const allowedExt = ['pdf','jpg','jpeg','png'];

            function validateDocumentForm($form) {
                const val = (selector) => ($form.find(selector).val() || '').toString().trim();
                const title = val('[name="title"]');
                const fileInput = $form.find('[name="file"]');
                const fileVal = fileInput.val();

                $form.find('.is-invalid').removeClass('is-invalid');

                if (!title) {
                    toastr.error('Please select or enter a document title');
                    const $titleField = $form.find('[name="title"]').first();
                    if ($titleField.length) $titleField.addClass('is-invalid');
                    return false;
                }

                if (!fileVal) {
                    toastr.error('Please upload a file');
                    fileInput.addClass('is-invalid');
                    return false;
                }

                const fileName = fileVal.split('\\').pop().split('/').pop();
                const ext = (fileName.split('.').pop() || '').toLowerCase();
                if (allowedExt.indexOf(ext) === -1) {
                    toastr.error('Only PDF, JPG, JPEG or PNG files are allowed');
                    fileInput.addClass('is-invalid');
                    return false;
                }

                return true;
            }

            // Education Form Validation
            $('#addEducationForm').on('submit', function(e) {
                e.preventDefault();
                const $form = $(this);
                if (validateEducationForm($form)) {
                    this.submit();
                }
            });

            $(document).on('shown.bs.modal', '#editEducationModal', function() {
                const $form = $(this).find('form#editEducationForm');
                $form.off('submit.validateEducation');
                $form.on('submit.validateEducation', function(e) {
                    e.preventDefault();
                    if (validateEducationForm($form)) {
                        this.submit();
                    }
                });
            });

            // Document submit handler
            $(document).on('submit', '#createEmployeeDocuments, #editEmployeeDocuments', function (e) {
                e.preventDefault();
                const $form = $(this);
                if ($form.data('submitting')) {
                    $form.removeData('submitting');
                    return true;
                }
                if (!validateDocumentForm($form)) {
                    return false;
                }
                $form.data('submitting', true);
                $form[0].submit();
            });

            // Remove invalid state dynamically
            $(document).on('input change', 'input, select, textarea', function () {
                $(this).removeClass('is-invalid');
            });
        });
    </script>

    {{-- Show profile edit btn on mobile --}}
    <script>
        $(document).on('click', '#showMobileProfileEditBox', function (event) {
            event.preventDefault();
            $('.viewoProfileforSmallDevice').addClass('d-none');
            $('.profileEdit').addClass('d-block');
        });
    </script>
@endpush
