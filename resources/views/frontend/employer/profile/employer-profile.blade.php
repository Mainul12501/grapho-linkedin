@extends('frontend.employer.master')

@section('title', 'Employee Profile')

@section('body')
    <div class="ep-wrapper">
        {{-- Mobile Back Bar --}}
        <div class="ep-mobile-back d-block d-md-none">
            <a href="{{ url()->previous() }}" class="ep-back-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Back
            </a>
        </div>

        <div class="ep-container">
            <div class="ep-grid">
                {{-- Left Column: Identity Card --}}
                <aside class="ep-sidebar">
                    <div class="ep-identity-card">
                        {{-- Avatar & Name --}}
                        <div class="ep-avatar-section">
                            <div class="ep-avatar-ring">
                                <img src="{{ isset($employeeDetails->profile_image) ? asset($employeeDetails->profile_image) : asset('/frontend/user-vector-img.jpg') }}"
                                     alt="{{ $employeeDetails->name ?? 'Profile' }}"
                                     class="ep-avatar-img" />
                            </div>
                            <h2 class="ep-name">{{ $employeeDetails->name ?? 'User Name' }}</h2>

                            @if($employeeDetails->is_open_for_hire == 1)
                                <span class="ep-hire-badge">
                                    <span class="ep-hire-dot"></span>
                                    Open to hire
                                </span>
                            @endif

                            <p class="ep-title">{{ $employeeDetails->profile_title ?? 'Employee profile title' }}</p>
                        </div>

                        {{-- Action Buttons --}}
                        @if($employeeDetails->is_open_for_hire == 1)
                            <div class="ep-actions">
                                <a href="{{ url("/chat/$employeeDetails->id") }}" target="_blank" class="ep-btn ep-btn-primary">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                    {{ trans('common.message') }}
                                </a>
                                <a href="tel:{{ $employeeDetails->mobile }}" class="ep-btn ep-btn-outline">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    Call
                                </a>
                            </div>
                        @endif

                        {{-- Contact Info --}}
                        <div class="ep-contact-list">
                            @if(isset($employeeDetails->address))
                                <div class="ep-contact-item">
                                    <div class="ep-contact-icon ep-icon-location">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    </div>
                                    <div class="ep-contact-info">
                                        <span class="ep-contact-label">{{ trans('common.location') }}</span>
                                        <span class="ep-contact-value">{{ $employeeDetails->address }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($employeeDetails->email)
                                <div class="ep-contact-item">
                                    <div class="ep-contact-icon ep-icon-email">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                    </div>
                                    <div class="ep-contact-info">
                                        <span class="ep-contact-label">{{ trans('common.email') }}</span>
                                        <a href="mailto:{{ $employeeDetails->email }}" class="ep-contact-value ep-contact-link">{{ $employeeDetails->email }}</a>
                                    </div>
                                </div>
                            @endif

                            @if($employeeDetails->mobile)
                                <div class="ep-contact-item">
                                    <div class="ep-contact-icon ep-icon-phone">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    </div>
                                    <div class="ep-contact-info">
                                        <span class="ep-contact-label">{{ trans('common.phone') }}</span>
                                        <span class="ep-contact-value">{{ $employeeDetails->mobile }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </aside>

                {{-- Right Column: Content --}}
                <main class="ep-main">

                    {{-- Work Experiences --}}
                    <section class="ep-section">
                        <div class="ep-section-header">
                            <div class="ep-section-icon ep-icon-work">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                            </div>
                            <h3 class="ep-section-title">{{ trans('employee.work_experiences') }}</h3>
                        </div>

                        <div class="ep-section-body">
                            @forelse($employeeDetails->employeeWorkExperiences as $index => $workExperience)
                                <div class="ep-experience-item" style="animation-delay: {{ $index * 0.05 }}s">
                                    <div class="ep-exp-logo">
                                        <img src="{{ asset($workExperience->company_logo ?? (isset($siteSetting) ? $siteSetting->common_institute_logo : '/frontend/company-vector.jpg')) }}" alt="{{ $workExperience->company_name }}" />
                                    </div>
                                    <div class="ep-exp-content">
                                        <h4 class="ep-exp-position">{{ $workExperience->position ?? 'Officer' }}</h4>
                                        <p class="ep-exp-company">
                                            {{ $workExperience->company_name }}
                                            <span class="ep-dot"></span>
                                            <span class="ep-exp-type">{{ $workExperience->job_type ?? 'Full Time' }}</span>
                                        </p>
                                        <p class="ep-exp-dates">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                            {{ $workExperience->is_working_currently == 1
                                                ? (\Illuminate\Support\Carbon::parse($workExperience->start_date)->format('M Y')).' - Present'
                                                : (\Illuminate\Support\Carbon::parse($workExperience->start_date)->format('M Y')).' - '.(\Illuminate\Support\Carbon::parse($workExperience->end_date)->format('M Y'))
                                            }}
                                            <span class="ep-dot"></span>
                                            {{ $workExperience->duration ?? '0 Years' }}
                                        </p>
                                        @if($workExperience->office_address)
                                            <p class="ep-exp-location">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                                {{ $workExperience->office_address }}
                                            </p>
                                        @endif
                                        @if($workExperience->job_responsibilities)
                                            <div class="ep-exp-summary">
                                                <span class="ep-exp-summary-label">Job Summary</span>
                                                <div class="ep-exp-summary-text">
                                                    {!! str()->words($workExperience->job_responsibilities, 30, ' ....') !!}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="ep-empty-state">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                    <p>No work experience added yet</p>
                                </div>
                            @endforelse
                        </div>
                    </section>

                    {{-- Education --}}
                    <section class="ep-section">
                        <div class="ep-section-header">
                            <div class="ep-section-icon ep-icon-edu">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 1.66 2.69 3 6 3s6-1.34 6-3v-5"/></svg>
                            </div>
                            <h3 class="ep-section-title">{{ trans('employee.education') }}</h3>
                        </div>

                        <div class="ep-section-body">
                            @forelse($employeeDetails->employeeEducations as $index => $education)
                                <div class="ep-education-item" style="animation-delay: {{ $index * 0.05 }}s">
                                    <div class="ep-edu-logo">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                    </div>
                                    <div class="ep-edu-content">
                                        <h4 class="ep-edu-institute">{{ $education?->institute_name ?? 'Institute Name' }}</h4>
                                        <p class="ep-edu-degree">
                                            {{ $education?->educationDegreeName?->degree_name ?? 'Degree Name' }}
                                            @if($education?->field_of_study)
                                                - {{ $education->field_of_study }}
                                            @endif
                                        </p>
                                        <div class="ep-edu-meta">
                                            @if($education->cgpa)
                                                <span class="ep-edu-badge">CGPA {{ $education->cgpa }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="ep-empty-state">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 1.66 2.69 3 6 3s6-1.34 6-3v-5"/></svg>
                                    <p>No education records added yet</p>
                                </div>
                            @endforelse
                        </div>
                    </section>

                    {{-- Documents --}}
                    <section class="ep-section">
                        <div class="ep-section-header">
                            <div class="ep-section-icon ep-icon-doc">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            </div>
                            <h3 class="ep-section-title">{{ trans('employee.documents') }}</h3>
                        </div>

                        <div class="ep-section-body">
                            @forelse($employeeDetails->employeeDocuments as $index => $document)
                                <a href="{{ asset($document->file) }}" download class="ep-document-item" style="animation-delay: {{ $index * 0.05 }}s">
                                    <div class="ep-doc-icon-wrap">
                                        @php $fileSubType = explode('/', $document->file_type)[1] ?? ''; @endphp
                                        @if($fileSubType == 'image')
                                            <div class="ep-doc-icon ep-doc-image">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                            </div>
                                        @elseif($fileSubType == 'pdf')
                                            <div class="ep-doc-icon ep-doc-pdf">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                            </div>
                                        @else
                                            <div class="ep-doc-icon ep-doc-file">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ep-doc-info">
                                        <h4 class="ep-doc-title">{{ $document->title ?? 'File Title' }}</h4>
                                        <p class="ep-doc-meta">{{ $document->file_size ?? '0 KB' }}</p>
                                    </div>
                                    <div class="ep-doc-download">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                    </div>
                                </a>
                            @empty
                                <div class="ep-empty-state">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    <p>No documents uploaded yet</p>
                                </div>
                            @endforelse
                        </div>
                    </section>

                </main>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        /* ========================================
           EMPLOYEE PROFILE — ep- prefix
           ======================================== */

        .ep-wrapper {
            background: #f6f7f9;
            min-height: 100vh;
            padding-bottom: 80px;
        }

        /* --- Mobile Back Bar --- */
        .ep-mobile-back {
            background: #fff;
            padding: 12px 16px;
            border-bottom: 1px solid #f0f1f3;
        }
        .ep-back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #334155;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }
        .ep-back-link:hover { color: #0f172a; }

        /* --- Container --- */
        .ep-container {
            /*max-width: 1000px;*/
            max-width: 95%;
            margin: 0 auto;
            padding: 24px 20px 0;
        }

        /* --- Grid --- */
        .ep-grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 22px;
            align-items: start;
        }

        /* ========================================
           LEFT SIDEBAR — Identity Card
           ======================================== */
        .ep-sidebar {
            position: static;
        }
        .ep-identity-card {
            background: #fff;
            border: 1px solid #f0f1f3;
            border-radius: 16px;
            padding: 28px 22px;
            box-shadow: 0 1px 3px rgba(20,28,37,.04), 0 6px 16px rgba(20,28,37,.03);
        }

        /* Avatar */
        .ep-avatar-section {
            text-align: center;
            padding-bottom: 22px;
            border-bottom: 1px solid #f0f1f3;
            margin-bottom: 20px;
        }
        .ep-avatar-ring {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            border: 3px solid #f0f1f3;
            padding: 3px;
            margin: 0 auto 14px;
            position: relative;
        }
        .ep-avatar-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        .ep-name {
            font-size: 19px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 8px;
            letter-spacing: -0.3px;
        }
        .ep-hire-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            background: #dcfce7;
            color: #15803d;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .ep-hire-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #22c55e;
            animation: ep-pulse 2s ease-in-out infinite;
        }
        @keyframes ep-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
        .ep-title {
            font-size: 13.5px;
            color: #64748b;
            margin: 0;
            line-height: 1.5;
        }

        /* Action Buttons */
        .ep-actions {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
        }
        .ep-btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: all .2s;
            cursor: pointer;
            border: none;
        }
        .ep-btn-primary {
            background: #141c25;
            color: #fff !important;
        }
        .ep-btn-primary:hover {
            background: #0f172a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(20,28,37,.2);
        }
        .ep-btn-primary svg { stroke: #fff; }
        .ep-btn-outline {
            background: #fff;
            color: #141c25 !important;
            border: 1.5px solid #e2e8f0;
        }
        .ep-btn-outline:hover {
            border-color: #FFCB11;
            background: #fffdf5;
        }

        /* Contact */
        .ep-contact-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .ep-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .ep-contact-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .ep-icon-location { background: #eef2ff; }
        .ep-icon-location svg { stroke: #6366f1; }
        .ep-icon-email { background: #fef3c7; }
        .ep-icon-email svg { stroke: #d97706; }
        .ep-icon-phone { background: #dcfce7; }
        .ep-icon-phone svg { stroke: #16a34a; }

        .ep-contact-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .ep-contact-label {
            font-size: 10.5px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .ep-contact-value {
            font-size: 13px;
            font-weight: 500;
            color: #334155;
            word-break: break-word;
        }
        .ep-contact-link {
            text-decoration: none;
            color: #334155;
        }
        .ep-contact-link:hover { color: #FFCB11; }

        /* ========================================
           RIGHT MAIN — Sections
           ======================================== */
        .ep-section {
            background: #fff;
            border: 1px solid #f0f1f3;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(20,28,37,.04), 0 6px 16px rgba(20,28,37,.03);
            margin-bottom: 18px;
            overflow: hidden;
        }
        .ep-section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 18px 22px;
            border-bottom: 1px solid #f0f1f3;
        }
        .ep-section-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .ep-icon-work { background: #fef3c7; }
        .ep-icon-work svg { stroke: #b8860b; }
        .ep-icon-edu { background: #eef2ff; }
        .ep-icon-edu svg { stroke: #6366f1; }
        .ep-icon-doc { background: #e0f2fe; }
        .ep-icon-doc svg { stroke: #0284c7; }

        .ep-section-title {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }
        .ep-section-body {
            padding: 0;
        }

        /* --- Experience Items --- */
        .ep-experience-item {
            display: flex;
            gap: 16px;
            padding: 20px 22px;
            border-bottom: 1px solid #f8f9fa;
            animation: ep-fadeIn 0.4s ease-out both;
        }
        .ep-experience-item:last-child { border-bottom: none; }
        .ep-experience-item:hover { background: #fcfcfd; }

        @keyframes ep-fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .ep-exp-logo {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            border: 1px solid #f0f1f3;
            overflow: hidden;
            flex-shrink: 0;
            background: #fafbfc;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ep-exp-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .ep-exp-content { flex: 1; min-width: 0; }
        .ep-exp-position {
            font-size: 14.5px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 4px;
        }
        .ep-exp-company {
            font-size: 13px;
            color: #475569;
            margin: 0 0 6px;
            font-weight: 500;
        }
        .ep-exp-type {
            color: #94a3b8;
            font-weight: 500;
        }
        .ep-dot {
            display: inline-block;
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: #cbd5e1;
            vertical-align: middle;
            margin: 0 6px;
        }
        .ep-exp-dates,
        .ep-exp-location {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12.5px;
            color: #94a3b8;
            margin: 0 0 3px;
            font-weight: 500;
        }
        .ep-exp-dates svg,
        .ep-exp-location svg {
            stroke: #cbd5e1;
            flex-shrink: 0;
        }
        .ep-exp-summary {
            margin-top: 10px;
            padding: 10px 14px;
            background: #f8fafc;
            border-radius: 8px;
            border-left: 3px solid #FFCB11;
        }
        .ep-exp-summary-label {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 4px;
        }
        .ep-exp-summary-text {
            font-size: 13px;
            color: #475569;
            line-height: 1.65;
        }

        /* --- Education Items --- */
        .ep-education-item {
            display: flex;
            gap: 14px;
            padding: 18px 22px;
            border-bottom: 1px solid #f8f9fa;
            animation: ep-fadeIn 0.4s ease-out both;
        }
        .ep-education-item:last-child { border-bottom: none; }
        .ep-education-item:hover { background: #fcfcfd; }

        .ep-edu-logo {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .ep-edu-logo svg { stroke: #6366f1; }
        .ep-edu-content { flex: 1; min-width: 0; }
        .ep-edu-institute {
            font-size: 14.5px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 4px;
        }
        .ep-edu-degree {
            font-size: 13px;
            color: #475569;
            margin: 0 0 6px;
            font-weight: 500;
        }
        .ep-edu-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        .ep-edu-badge {
            display: inline-flex;
            padding: 3px 10px;
            border-radius: 6px;
            background: #fef3c7;
            color: #b8860b;
            font-size: 11.5px;
            font-weight: 700;
        }

        /* --- Document Items --- */
        .ep-document-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 22px;
            border-bottom: 1px solid #f8f9fa;
            text-decoration: none;
            transition: background .15s;
            animation: ep-fadeIn 0.4s ease-out both;
        }
        .ep-document-item:last-child { border-bottom: none; }
        .ep-document-item:hover { background: #fcfcfd; }

        .ep-doc-icon-wrap { flex-shrink: 0; }
        .ep-doc-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ep-doc-image { background: #dcfce7; }
        .ep-doc-image svg { stroke: #16a34a; }
        .ep-doc-pdf { background: #fee2e2; }
        .ep-doc-pdf svg { stroke: #dc2626; }
        .ep-doc-file { background: #e0f2fe; }
        .ep-doc-file svg { stroke: #0284c7; }

        .ep-doc-info { flex: 1; min-width: 0; }
        .ep-doc-title {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 2px;
        }
        .ep-doc-meta {
            font-size: 12px;
            color: #94a3b8;
            margin: 0;
            font-weight: 500;
        }
        .ep-doc-download {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1.5px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all .15s;
        }
        .ep-doc-download svg { stroke: #94a3b8; }
        .ep-document-item:hover .ep-doc-download {
            border-color: #FFCB11;
            background: #fffdf5;
        }
        .ep-document-item:hover .ep-doc-download svg { stroke: #b8860b; }

        /* --- Empty State --- */
        .ep-empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #cbd5e1;
        }
        .ep-empty-state svg {
            stroke: #e2e8f0;
            margin-bottom: 10px;
        }
        .ep-empty-state p {
            font-size: 13.5px;
            font-weight: 600;
            color: #94a3b8;
            margin: 0;
        }

        /* ========================================
           RESPONSIVE
           ======================================== */
        @media (max-width: 992px) {
            .ep-grid {
                grid-template-columns: 260px 1fr;
                gap: 16px;
            }
        }

        @media (max-width: 768px) {
            .ep-container {
                padding: 16px 0 0;
            }
            .ep-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .ep-sidebar {
                position: static;
            }
            .ep-identity-card {
                border-radius: 0;
                border-left: none;
                border-right: none;
                padding: 22px 18px;
            }
            .ep-section {
                border-radius: 0;
                border-left: none;
                border-right: none;
                margin-bottom: 10px;
            }
            .ep-section-header {
                padding: 16px 18px;
            }
            .ep-experience-item,
            .ep-education-item,
            .ep-document-item {
                padding: 16px 18px;
            }
            .ep-actions {
                gap: 8px;
            }
            .ep-btn {
                padding: 10px 12px;
                font-size: 13px;
            }
        }

        @media (max-width: 480px) {
            .ep-avatar-ring {
                width: 80px;
                height: 80px;
            }
            .ep-name {
                font-size: 17px;
            }
            .ep-exp-logo {
                width: 40px;
                height: 40px;
                border-radius: 10px;
            }
            .ep-exp-summary {
                padding: 8px 12px;
            }
        }
    </style>
@endpush
