@extends('frontend.employer.master')

@section('title', 'Company Profile')

@section('body')
    <div class="cp-wrapper">
        <div class="cp-container">
            {{-- Page Header --}}
            <div class="cp-page-header">
                <h1 class="cp-page-title">Company Profile</h1>
                @if($employerView)
                    <button type="button" class="cp-edit-trigger" data-bs-toggle="modal" data-bs-target="#employerCompanyEditModal">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit Profile
                    </button>
                @endif
            </div>

            <div class="cp-grid">
                {{-- Left Card: Company Identity --}}
                <div class="cp-identity-card">
                    <div class="cp-logo-section">
                        <div class="cp-logo-ring">
                            <img src="{{ asset($companyDetails->logo ?? '/frontend/company-vector.jpg') }}" alt="{{ $companyDetails->name ?? 'company' }}-Logo" class="cp-logo-img" />
                        </div>
                        <h3 class="cp-company-name">{{ $companyDetails->name ?? 'Company Name' }}</h3>
                        @if(isset($companyDetails->industry))
                            <span class="cp-industry-pill">{{ $companyDetails->industry->name }}</span>
                        @endif
                    </div>

                    <div class="cp-contact-list">
                        <div class="cp-contact-item">
                            <div class="cp-contact-icon cp-icon-location">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            </div>
                            <div class="cp-contact-info">
                                <span class="cp-contact-label">Location</span>
                                <span class="cp-contact-value">{!! $companyDetails->address ?? 'Dhaka, Bangladesh' !!}</span>
                            </div>
                        </div>

                        <div class="cp-contact-item">
                            <div class="cp-contact-icon cp-icon-email">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            </div>
                            <div class="cp-contact-info">
                                <span class="cp-contact-label">Email</span>
                                <a href="mailto:{{ $companyDetails->email ?? '' }}" class="cp-contact-value cp-contact-link">{{ $companyDetails->email ?? 'email@company.com' }}</a>
                            </div>
                        </div>

                        <div class="cp-contact-item">
                            <div class="cp-contact-icon cp-icon-phone">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </div>
                            <div class="cp-contact-info">
                                <span class="cp-contact-label">Phone</span>
                                <span class="cp-contact-value">{{ $companyDetails->phone ?? '01600000000' }}</span>
                            </div>
                        </div>

                        <div class="cp-contact-item">
                            <div class="cp-contact-icon cp-icon-web">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                            </div>
                            <div class="cp-contact-info">
                                <span class="cp-contact-label">Website</span>
                                <a href="{{ $companyDetails->website ?? '#' }}" target="_blank" class="cp-contact-value cp-contact-link">{{ $companyDetails->website ?? '' }}</a>
                            </div>
                        </div>
                    </div>

                    @if($employerView)
                        <button class="cp-edit-contact-btn" data-bs-toggle="modal" data-bs-target="#employerCompanyEditModal">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit contact info
                        </button>
                    @endif
                </div>

                {{-- Right Card: Company Overview --}}
                <div class="cp-overview-card">
                    <div class="cp-overview-header">
                        <h4 class="cp-overview-title">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                            Company Overview
                        </h4>
                        @if($employerView)
                            <button type="button" class="cp-edit-btn" data-bs-toggle="modal" data-bs-target="#employerCompanyEditModal">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit
                            </button>
                        @endif
                    </div>

                    <div class="cp-overview-body">
                        <div class="cp-overview-text">
                            <div id="short-overview">
                                {!! str()->words($companyDetails->company_overview, 80, '<span id="show-full-btn" class="cp-view-toggle">View all</span>') ?? '<p class="cp-no-overview">Company overview not available</p>' !!}
                            </div>
                            <div id="long-overview" style="display: none;">
                                {!! $companyDetails->company_overview ?? '<p class="cp-no-overview">Company overview not available</p>' !!}
                                <span id="show-less-btn" class="cp-view-toggle">View less</span>
                            </div>
                        </div>
                    </div>

                    <div class="cp-stats-row">
                        <div class="cp-stat-item">
                            <div class="cp-stat-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                            </div>
                            <span class="cp-stat-label">Industry</span>
                            <span class="cp-stat-value">{{ $companyDetails?->industry?->name ?? 'Not specified' }}</span>
                        </div>
                        <div class="cp-stat-item">
                            <div class="cp-stat-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            <span class="cp-stat-label">Employees</span>
                            <span class="cp-stat-value">{{ $companyDetails->total_employees ?? 0 }}</span>
                        </div>
                        <div class="cp-stat-item">
                            <div class="cp-stat-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </div>
                            <span class="cp-stat-label">Founded</span>
                            <span class="cp-stat-value">{{ $companyDetails->founded_on ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Activity Section --}}
            @if(isset($_GET['view']) && $_GET['view'] == 'employer')
                <div class="cp-activity-section">
                    <div class="cp-activity-header">
                        <h3 class="cp-activity-title">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                            {{ $companyDetails->name ?? '' }} Activities
                        </h3>
                    </div>

                    <div class="row gy-3" id="item-container">
                        @if(isset($paginatedData))
                            @include('frontend.employer.home.activity-content')
                        @endif

                        <div id="loader" class="cp-loader" style="display:none;">
                            <div class="cp-spinner"></div>
                            Loading...
                        </div>

                        <div id="no-more-data" class="cp-no-more" style="display:none;">
                            No more results
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('modal')
    {{-- Edit Company Modal --}}
    <div class="modal fade" id="employerCompanyEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg cp-modal-dialog">
            <div class="modal-content cp-modal-content">
                <div class="cp-modal-header">
                    <div class="cp-modal-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </div>
                    <div>
                        <h5 class="cp-modal-title">{{ trans('employer.edit_company_information') }}</h5>
                        <p class="cp-modal-subtitle">Update your company details below</p>
                    </div>
                    <button type="button" class="cp-modal-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
                <form action="{{ route('employer.update-company-info') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="cp-modal-body">
                        <div class="cp-form-grid">
                            <div class="cp-form-group">
                                <label class="cp-form-label">{{ trans('employer.company_name') }}</label>
                                <input type="text" class="form-control cp-form-input" name="name" value="{{ $companyDetails->name ?? '' }}" placeholder="{{ trans('employer.enter_your_full_name') }}">
                            </div>
                            <div class="cp-form-group">
                                <label class="cp-form-label">{{ trans('common.email') }}</label>
                                <input type="text" class="form-control cp-form-input" name="email" value="{{ $companyDetails->email ?? '' }}" placeholder="{{ trans('employer.enter_your_email') }}">
                            </div>
                            <div class="cp-form-group">
                                <label class="cp-form-label">{{ trans('employer.mobile') }}</label>
                                <input type="text" class="form-control cp-form-input" name="phone" value="{{ $companyDetails->phone ?? '' }}" placeholder="{{ trans('employer.mobile') }}">
                            </div>
                            <div class="cp-form-group">
                                <label class="cp-form-label">{{ trans('common.website') }}</label>
                                <input type="text" class="form-control cp-form-input" name="website" value="{{ $companyDetails->website ?? '' }}" placeholder="{{ trans('common.website') }}">
                            </div>
                            <div class="cp-form-group">
                                <label class="cp-form-label">{{ trans('employer.total_employees') }}</label>
                                <input type="text" class="form-control cp-form-input" name="total_employees" value="{{ $companyDetails->total_employees ?? '' }}" placeholder="{{ trans('employer.total_employees') }}">
                            </div>
                            <div class="cp-form-group">
                                <label class="cp-form-label">{{ trans('employer.founded_on') }}</label>
                                <input type="text" class="form-control cp-form-input" name="founded_on" value="{{ $companyDetails->founded_on ?? '' }}" placeholder="{{ trans('employer.founded_on') }}">
                            </div>
                            <div class="cp-form-group">
                                <label class="cp-form-label">{{ trans('employer.select_company_category') }}</label>
                                <select name="employer_company_category_id" id="selectCompanyCategory" class="select2">
                                    <option value="">{{ trans('employer.select_industry') }}</option>
                                    @foreach ($employerCompanyCategories as $employerCompanyCategory)
                                        <option value="{{ $employerCompanyCategory->id }}" {{ $companyDetails->employer_company_category_id == $employerCompanyCategory->id ? 'selected' : '' }}>{{ $employerCompanyCategory->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="cp-form-group">
                                <label class="cp-form-label">{{ trans('employer.select_industry') }}</label>
                                <select name="industry_id" id="selectIndustry" class="select2">
                                    <option value="">{{ trans('employer.select_industry') }}</option>
                                    @foreach ($industries as $industry)
                                        <option value="{{ $industry->id }}" {{ $companyDetails->industry_id == $industry->id ? 'selected' : '' }}>{{ $industry->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="cp-form-group cp-form-full" style="margin-top: 16px;">
                            <label class="cp-form-label">{{ trans('employer.logo') }}</label>
                            <div class="cp-logo-upload">
                                <div class="cp-upload-area">
                                    <input type="file" name="logo" accept="image/*" class="cp-file-input" />
                                    <div class="cp-upload-placeholder">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                        <span>Choose file</span>
                                    </div>
                                </div>
                                @if(isset($companyDetails->logo))
                                    <img src="{{ asset($companyDetails->logo) }}" alt="Company Logo" class="cp-current-logo">
                                @endif
                            </div>
                        </div>

                        <div class="cp-form-group cp-form-full" style="margin-top: 16px;">
                            <label class="cp-form-label">{{ trans('employer.company_overview') }}</label>
                            <textarea name="company_overview" class="form-control summernote" cols="30" rows="10">{!! $companyDetails->company_overview !!}</textarea>
                        </div>

                        <div class="cp-form-grid" style="margin-top: 16px;">
                            <div class="cp-form-group">
                                <label class="cp-form-label">BIN Number</label>
                                <input type="text" class="form-control cp-form-input" name="bin_number" value="{{ $companyDetails->bin_number ?? '' }}">
                            </div>
                            <div class="cp-form-group">
                                <label class="cp-form-label">Trade License Number</label>
                                <input type="text" class="form-control cp-form-input" name="trade_license_number" value="{{ $companyDetails->trade_license_number ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="cp-modal-footer">
                        <button type="button" class="cp-btn-cancel" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                        <button type="submit" class="cp-btn-save">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            {{ trans('common.save_changes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- View Job Modal --}}
    <div class="modal" id="viewJobModal">
        <div class="modal-dialog modal-dialog-centered modal-lg cp-modal-dialog">
            <div class="modal-content cp-modal-content">
                <div class="cp-modal-header">
                    <div class="cp-modal-icon cp-modal-icon-job">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    </div>
                    <h5 class="cp-modal-title" id="viewJobModalTitle">View Job</h5>
                    <button type="button" class="cp-modal-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
                <div class="cp-modal-body" id="viewJobModalBody">
                    <p>Loading...</p>
                </div>
                <div class="cp-modal-footer">
                    <button type="button" class="cp-btn-cancel" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- View Post Modal --}}
    <div class="modal" id="viewPostModal">
        <div class="modal-dialog modal-dialog-centered modal-lg cp-modal-dialog">
            <div class="modal-content cp-modal-content">
                <div class="cp-modal-header">
                    <div class="cp-modal-icon cp-modal-icon-post">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    </div>
                    <h5 class="cp-modal-title" id="viewPostModalTitle">View Post</h5>
                    <button type="button" class="cp-modal-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
                <div class="cp-modal-body" id="viewPostModalBody">
                    <p>Loading...</p>
                </div>
                <div class="cp-modal-footer">
                    <button type="button" class="cp-btn-cancel" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        /* ========================================
           COMPANY PROFILE — cp- prefix
           ======================================== */

        .cp-wrapper {
            background: #f6f7f9;
            min-height: 100vh;
            padding: 24px 0 80px;
        }
        .cp-container {
            /*max-width: 960px;*/
            max-width: 90%;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* --- Page Header --- */
        .cp-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .cp-page-title {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            letter-spacing: -0.3px;
        }
        .cp-edit-trigger {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            background: #fff;
            color: #334155;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
        }
        .cp-edit-trigger:hover {
            border-color: #FFCB11;
            background: #fffdf5;
            color: #0f172a;
        }

        /* --- Grid Layout --- */
        .cp-grid {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 20px;
            align-items: start;
        }

        /* --- Identity Card (Left) --- */
        .cp-identity-card {
            background: #fff;
            border: 1px solid #f0f1f3;
            border-radius: 16px;
            padding: 28px 24px;
            box-shadow: 0 1px 3px rgba(20,28,37,.04), 0 6px 16px rgba(20,28,37,.03);
        }
        .cp-logo-section {
            text-align: center;
            margin-bottom: 24px;
            padding-bottom: 24px;
            border-bottom: 1px solid #f0f1f3;
        }
        .cp-logo-ring {
            width: 88px;
            height: 88px;
            border-radius: 20px;
            border: 2px solid #f0f1f3;
            padding: 4px;
            margin: 0 auto 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fafbfc;
        }
        .cp-logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 14px;
        }
        .cp-company-name {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 8px;
        }
        .cp-industry-pill {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            background: #fef9e7;
            color: #b8860b;
            font-size: 12px;
            font-weight: 600;
        }

        /* --- Contact Items --- */
        .cp-contact-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .cp-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .cp-contact-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .cp-icon-location { background: #eef2ff; color: #6366f1; }
        .cp-icon-location svg { stroke: #6366f1; }
        .cp-icon-email { background: #fef3c7; color: #d97706; }
        .cp-icon-email svg { stroke: #d97706; }
        .cp-icon-phone { background: #dcfce7; color: #16a34a; }
        .cp-icon-phone svg { stroke: #16a34a; }
        .cp-icon-web { background: #e0f2fe; color: #0284c7; }
        .cp-icon-web svg { stroke: #0284c7; }

        .cp-contact-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .cp-contact-label {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .cp-contact-value {
            font-size: 13.5px;
            font-weight: 500;
            color: #334155;
            word-break: break-word;
        }
        .cp-contact-link {
            text-decoration: none;
            color: #334155;
            transition: color .15s;
        }
        .cp-contact-link:hover {
            color: #FFCB11;
        }

        .cp-edit-contact-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 20px;
            padding: 0;
            border: none;
            background: none;
            color: #141c25;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: underline;
            text-underline-offset: 3px;
            transition: color .15s;
        }
        .cp-edit-contact-btn:hover {
            color: #FFCB11;
        }

        /* --- Overview Card (Right) --- */
        .cp-overview-card {
            background: #fff;
            border: 1px solid #f0f1f3;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(20,28,37,.04), 0 6px 16px rgba(20,28,37,.03);
            overflow: hidden;
        }
        .cp-overview-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid #f0f1f3;
        }
        .cp-overview-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }
        .cp-overview-title svg {
            stroke: #94a3b8;
        }
        .cp-edit-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            background: #fff;
            color: #475569;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }
        .cp-edit-btn:hover {
            border-color: #FFCB11;
            background: #fffdf5;
        }

        .cp-overview-body {
            padding: 20px 24px 24px;
        }
        .cp-overview-text {
            font-size: 14px;
            line-height: 1.75;
            color: #475569;
        }
        .cp-overview-text p {
            color: #475569;
        }
        .cp-no-overview {
            color: #94a3b8;
            font-style: italic;
        }
        .cp-view-toggle {
            color: #FFCB11;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            transition: color .15s;
        }
        .cp-view-toggle:hover {
            color: #d4a500;
        }

        /* --- Stats Row --- */
        .cp-stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            border-top: 1px solid #f0f1f3;
        }
        .cp-stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 16px;
            text-align: center;
            position: relative;
        }
        .cp-stat-item:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 16px;
            bottom: 16px;
            width: 1px;
            background: #f0f1f3;
        }
        .cp-stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
        }
        .cp-stat-icon svg {
            stroke: #94a3b8;
        }
        .cp-stat-label {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .cp-stat-value {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
        }

        /* --- Activity Section --- */
        .cp-activity-section {
            margin-top: 28px;
        }
        .cp-activity-header {
            margin-bottom: 16px;
        }
        .cp-activity-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }
        .cp-activity-title svg {
            stroke: #FFCB11;
        }
        .cp-loader {
            text-align: center;
            padding: 24px;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .cp-spinner {
            width: 20px;
            height: 20px;
            border: 2.5px solid #f0f1f3;
            border-top-color: #FFCB11;
            border-radius: 50%;
            animation: cp-spin .7s linear infinite;
        }
        @keyframes cp-spin {
            to { transform: rotate(360deg); }
        }
        .cp-no-more {
            text-align: center;
            padding: 20px;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 500;
        }

        /* ========================================
           MODAL STYLES
           ======================================== */
        .cp-modal-dialog {
            max-width: 720px;
        }
        .cp-modal-content {
            border: none !important;
            border-radius: 16px !important;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(20,28,37,.18) !important;
        }
        .cp-modal-header {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 20px 24px;
            border-bottom: 1px solid #f0f1f3;
            background: #fafbfc;
        }
        .cp-modal-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #FFCB11, #ffe066);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .cp-modal-icon svg {
            stroke: #141c25;
        }
        .cp-modal-icon-job {
            background: linear-gradient(135deg, #fef3c7, #fde68a) !important;
        }
        .cp-modal-icon-job svg { stroke: #b8860b !important; }
        .cp-modal-icon-post {
            background: linear-gradient(135deg, #eef2ff, #c7d2fe) !important;
        }
        .cp-modal-icon-post svg { stroke: #6366f1 !important; }

        .cp-modal-title {
            font-size: 17px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            flex: 1;
        }
        .cp-modal-subtitle {
            font-size: 12.5px;
            color: #94a3b8;
            margin: 2px 0 0;
            font-weight: 500;
        }
        .cp-modal-close {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1.5px solid #e2e8f0;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #64748b;
            transition: all .15s;
            margin-left: auto;
            flex-shrink: 0;
        }
        .cp-modal-close:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }
        .cp-modal-body {
            padding: 24px;
            max-height: 65vh;
            overflow-y: auto;
        }
        .cp-modal-body::-webkit-scrollbar { width: 5px; }
        .cp-modal-body::-webkit-scrollbar-track { background: transparent; }
        .cp-modal-body::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }

        .cp-modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 24px;
            border-top: 1px solid #f0f1f3;
            background: #fafbfc;
        }
        .cp-btn-cancel {
            padding: 9px 18px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            background: #fff;
            color: #475569;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }
        .cp-btn-cancel:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }
        .cp-btn-save {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            border: 1.5px solid #FFCB11;
            border-radius: 10px;
            background: #FFCB11;
            color: #141c25;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s;
        }
        .cp-btn-save:hover {
            background: #e5b600;
            border-color: #e5b600;
        }

        /* --- Form Styles --- */
        .cp-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .cp-form-group {
            display: flex;
            flex-direction: column;
        }
        .cp-form-full {
            grid-column: 1 / -1;
        }
        .cp-form-label {
            font-size: 12.5px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
        }
        .cp-form-input {
            padding: 9px 14px !important;
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 10px !important;
            font-size: 13.5px !important;
            color: #0f172a !important;
            transition: border-color .15s, box-shadow .15s !important;
        }
        .cp-form-input:focus {
            border-color: #FFCB11 !important;
            box-shadow: 0 0 0 3px rgba(255,203,17,.15) !important;
        }

        .cp-logo-upload {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .cp-upload-area {
            position: relative;
            flex: 1;
        }
        .cp-file-input {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            z-index: 2;
        }
        .cp-upload-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border: 1.5px dashed #d1d5db;
            border-radius: 10px;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 500;
            background: #fafbfc;
            transition: all .15s;
        }
        .cp-upload-area:hover .cp-upload-placeholder {
            border-color: #FFCB11;
            background: #fffdf5;
        }
        .cp-current-logo {
            max-height: 60px;
            max-width: 80px;
            border-radius: 8px;
            border: 1px solid #f0f1f3;
            object-fit: contain;
        }

        /* --- Post image styles (for modals) --- */
        .post-image-wrapper { height: 200px; overflow: hidden; }
        .single-post-image { width: 100%; height: 100%; object-fit: cover; display: block; }
        .image-grid { display: grid; grid-template-columns: repeat(2, 1fr); grid-template-rows: repeat(2, 1fr); width: 100%; height: 100%; gap: 2px; }
        .grid-image-wrapper { width: 100%; height: 100%; overflow: hidden; position: relative; cursor: pointer; }
        .image-grid img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .more-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.6); color: #fff; font-size: 26px; font-weight: 600; display: flex; align-items: center; justify-content: center; }

        /* ========================================
           RESPONSIVE
           ======================================== */
        @media (max-width: 768px) {
            .cp-wrapper {
                padding: 16px 0 100px;
            }
            .cp-container {
                padding: 0 14px;
            }
            .cp-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            .cp-page-header {
                margin-bottom: 16px;
            }
            .cp-page-title {
                font-size: 18px;
            }
            .cp-identity-card {
                padding: 20px 18px;
            }
            .cp-logo-ring {
                width: 72px;
                height: 72px;
            }
            .cp-overview-header {
                padding: 16px 18px;
            }
            .cp-overview-body {
                padding: 16px 18px 20px;
            }
            .cp-stats-row {
                grid-template-columns: 1fr;
            }
            .cp-stat-item:not(:last-child)::after {
                display: none;
            }
            .cp-stat-item:not(:last-child) {
                border-bottom: 1px solid #f0f1f3;
            }
            .cp-stat-item {
                flex-direction: row;
                gap: 12px;
                text-align: left;
                padding: 14px 18px;
            }
            .cp-stat-icon {
                margin-bottom: 0;
            }
            .cp-stat-label {
                margin-bottom: 0;
            }
            .cp-form-grid {
                grid-template-columns: 1fr;
            }
            .cp-modal-body {
                padding: 16px;
            }
            .cp-modal-header {
                padding: 16px;
            }
            .cp-modal-footer {
                padding: 14px 16px;
            }
            .cp-logo-upload {
                flex-direction: column;
                align-items: flex-start;
            }
            .cp-upload-area {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .cp-edit-trigger span {
                display: none;
            }
            .cp-company-name {
                font-size: 16px;
            }
            .cp-contact-icon {
                width: 32px;
                height: 32px;
                border-radius: 8px;
            }
        }
    </style>
@endpush

@push('script')
    @include('common-resource-files.selectize')
    @include('common-resource-files.summernote')

    {{-- Company Information Form Validation --}}
    <script>
        $(document).ready(function() {
            $('#employerCompanyEditModal form').on('submit', function(e) {
                e.preventDefault();
                clearCompanyErrors();

                let isValid = true;
                let errors = [];

                const nameInput = $(this).find('[name="name"]');
                const nameValue = nameInput.val().trim();
                if (!nameValue) {
                    showCompanyError(nameInput, 'Company name is required');
                    errors.push('Company name is required');
                    isValid = false;
                } else if (nameValue.length < 2) {
                    showCompanyError(nameInput, 'Company name must be at least 2 characters');
                    errors.push('Company name must be at least 2 characters');
                    isValid = false;
                }

                const emailInput = $(this).find('[name="email"]');
                const emailValue = emailInput.val().trim();
                if (!emailValue) {
                    showCompanyError(emailInput, 'Email is required');
                    errors.push('Email is required');
                    isValid = false;
                } else {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailPattern.test(emailValue)) {
                        showCompanyError(emailInput, 'Please enter a valid email address');
                        errors.push('Invalid email format');
                        isValid = false;
                    }
                }

                const mobileInput = $(this).find('[name="phone"]');
                const mobileValue = mobileInput.val().trim();
                if (mobileValue) {
                    const onlyDigits = /^[0-9]+$/;
                    if (!onlyDigits.test(mobileValue)) {
                        showCompanyError(mobileInput, 'Mobile number must contain only digits');
                        errors.push('Invalid mobile format');
                        isValid = false;
                    } else if (!mobileValue.startsWith('01')) {
                        showCompanyError(mobileInput, 'Mobile number must start with 01');
                        errors.push('Mobile must start with 01');
                        isValid = false;
                    } else if (mobileValue.length !== 11) {
                        showCompanyError(mobileInput, 'Mobile number must be exactly 11 digits');
                        errors.push('Mobile must be 11 digits');
                        isValid = false;
                    } else {
                        const validPrefixes = ['013', '014', '015', '016', '017', '018', '019'];
                        const prefix = mobileValue.substring(0, 3);
                        if (!validPrefixes.includes(prefix)) {
                            showCompanyError(mobileInput, 'Invalid operator (must start with 013-019)');
                            errors.push('Invalid mobile operator prefix');
                            isValid = false;
                        }
                    }
                }

                const binInput = $(this).find('[name="bin_number"]');
                const binValue = binInput.val().trim();
                if (!binValue) {
                    showCompanyError(binInput, 'BIN Number is required');
                    errors.push('BIN Number is required');
                    isValid = false;
                } else if (!/^[0-9]+$/.test(binValue)) {
                    showCompanyError(binInput, 'BIN Number must contain only digits');
                    errors.push('BIN Number must contain only digits');
                    isValid = false;
                } else if (binValue.length < 6) {
                    showCompanyError(binInput, 'BIN Number must be at least 6 characters');
                    errors.push('Invalid BIN Number length');
                    isValid = false;
                }

                const tradeInput = $(this).find('[name="trade_license_number"]');
                const tradeValue = tradeInput.val().trim();
                if (!tradeValue) {
                    showCompanyError(tradeInput, 'Trade License Number is required');
                    errors.push('Trade License Number is required');
                    isValid = false;
                } else if (!/^[0-9]+$/.test(tradeValue)) {
                    showCompanyError(tradeInput, 'Trade License Number must contain only digits');
                    errors.push('Trade License Number must contain only digits');
                    isValid = false;
                } else if (tradeValue.length < 6) {
                    showCompanyError(tradeInput, 'Trade License Number must be at least 6 characters');
                    errors.push('Invalid Trade License Number length');
                    isValid = false;
                }

                const websiteInput = $(this).find('[name="website"]');
                const websiteValue = websiteInput.val().trim();
                if (websiteValue) {
                    const urlPattern = /^(https?:\/\/)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)$/;
                    if (!urlPattern.test(websiteValue)) {
                        showCompanyError(websiteInput, 'Please enter a valid website URL');
                        errors.push('Invalid website URL');
                        isValid = false;
                    }
                }

                const employeesInput = $(this).find('[name="total_employees"]');
                const employeesValue = employeesInput.val().trim();
                if (employeesValue) {
                    if (isNaN(employeesValue) || parseInt(employeesValue) < 1) {
                        showCompanyError(employeesInput, 'Total employees must be a valid number greater than 0');
                        errors.push('Invalid total employees value');
                        isValid = false;
                    }
                }

                const categoryInput = $(this).find('[name="employer_company_category_id"]');
                const categoryValue = categoryInput.val();
                if (!categoryValue) {
                    showCompanyError(categoryInput.next('.select2-container'), 'Please select a company category');
                    errors.push('Company category is required');
                    isValid = false;
                }

                const industryInput = $(this).find('[name="industry_id"]');
                const industryValue = industryInput.val();
                if (!industryValue) {
                    showCompanyError(industryInput.next('.select2-container'), 'Please select an industry');
                    errors.push('Industry is required');
                    isValid = false;
                }

                const logoInput = $(this).find('[name="logo"]');
                if (logoInput[0].files.length > 0) {
                    const file = logoInput[0].files[0];
                    const fileSize = file.size / 1024 / 1024;
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                    if (!allowedTypes.includes(file.type)) {
                        showCompanyError(logoInput, 'Logo must be a valid image file (JPEG, PNG, GIF, WEBP)');
                        errors.push('Invalid logo file type');
                        isValid = false;
                    } else if (fileSize > 5) {
                        showCompanyError(logoInput, 'Logo must be less than 5MB');
                        errors.push('Logo file too large');
                        isValid = false;
                    }
                }

                if (!isValid) {
                    displayCompanyErrorSummary(errors);
                    const firstError = $('#employerCompanyEditModal .is-invalid').first();
                    if (firstError.length) {
                        $('#employerCompanyEditModal .modal-body, #employerCompanyEditModal .cp-modal-body').animate({
                            scrollTop: firstError.offset().top - $('#employerCompanyEditModal .cp-modal-body').offset().top + $('#employerCompanyEditModal .cp-modal-body').scrollTop() - 20
                        }, 500);
                    }
                    return false;
                }

                this.submit();
            });

            $('#employerCompanyEditModal').on('input change', 'input, select, textarea', function() {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').remove();
                $(this).next('.select2-container').removeClass('is-invalid');
                $(this).next('.select2-container').siblings('.invalid-feedback').remove();
                $('.company-error-summary').remove();
            });

            $('#employerCompanyEditModal').on('hidden.bs.modal', function() {
                clearCompanyErrors();
            });

            $('#employerCompanyEditModal [name="phone"]').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length > 11) value = value.substring(0, 11);
                $(this).val(value);
            });

            $('#employerCompanyEditModal [name="total_employees"]').on('input', function() {
                $(this).val($(this).val().replace(/\D/g, ''));
            });
        });

        function showCompanyError(element, message) {
            element.addClass('is-invalid');
            const errorDiv = $('<div class="invalid-feedback d-block"></div>').text(message);
            if (element.hasClass('select2-container')) {
                element.after(errorDiv);
            } else {
                element.after(errorDiv);
            }
        }

        function clearCompanyErrors() {
            $('#employerCompanyEditModal .is-invalid').removeClass('is-invalid');
            $('#employerCompanyEditModal .invalid-feedback').remove();
            $('#employerCompanyEditModal .company-error-summary').remove();
        }

        function displayCompanyErrorSummary(errors) {
            const summaryHtml = `
                <div class="alert alert-danger company-error-summary mb-3" style="border-radius:10px;font-size:13px;">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        ${errors.map(error => `<li>${error}</li>`).join('')}
                    </ul>
                </div>
            `;
            $('#employerCompanyEditModal .cp-modal-body').prepend(summaryHtml);
        }
    </script>

    {{-- Load contents on scroll --}}
    <script>
        let page = 1;
        let loading = false;
        let lastPage = {{ $paginatedData->lastPage() }};

        function loadMoreData() {
            if (loading || page >= lastPage) return;

            loading = true;
            page++;
            $("#loader").show();

            $.ajax({
                url: "?page=" + page + "&view=employer&employer_id={{ $companyDetails->id }}",
                type: "GET",
                success: function(res) {
                    if (res.empty) {
                        if (!$(".no-activity").length) {
                            $("#item-container").append(res.html);
                        }
                        $("#no-more-data").show();
                        page = lastPage;
                        return;
                    }
                    $("#item-container").append(res.html);
                },
                complete: function() {
                    loading = false;
                    $("#loader").hide();
                }
            });
        }

        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() + 200 >= $(document).height()) {
                loadMoreData();
            }
        });
    </script>

    {{-- Show/hide overview --}}
    <script>
        $(document).on('click', '#show-full-btn', function () {
            $('#short-overview').css('display', 'none');
            $('#long-overview').css('display', 'block');
        });
        $(document).on('click', '#show-less-btn', function () {
            $('#short-overview').css('display', 'block');
            $('#long-overview').css('display', 'none');
        });
    </script>

    {{-- Zoom plugin & AJAX modals --}}
    <link rel="stylesheet" href="{{ asset('frontend/zoom-plugin/mbox.css') }}">
    <script src="{{ asset('frontend/zoom-plugin/mbox.min.js') }}"></script>
    <script>
        function sendAjaxRequest(url, method, data = {}) {
            return $.ajax({
                url: base_url + url,
                method: method,
                data: data
            })
            .done(function (data) {})
            .fail(function (error) {
                toastr.error(error);
            });
        }

        function showJobDetails(jobId, jobTitle = 'View Job Title') {
            sendAjaxRequest('get-job-details/' + jobId + '?render=1&show_apply=1', 'GET').then(function (response) {
                $('#viewJobModalTitle').empty().append(jobTitle);
                $('#viewJobModalBody').empty().append(response);
                $('#viewJobModal').modal('show');
            });
        }

        function showPostDetails(postId, postTitle = 'View Post Title') {
            sendAjaxRequest('employee-view-post/' + postId + '?render=1', 'GET').then(function (response) {
                $('#viewPostModalTitle').empty().append(postTitle);
                $('#viewPostModalBody').empty().append(response);
                $('.zoom-img').mBox();
                $('#viewPostModal').modal('show');
            });
        }

        $(document).on('click', '.ed-post-click', function(e) {
            e.preventDefault();
            var postId = $(this).data('post-id');
            var postTitle = $(this).data('post-title') || 'View Post';
            showPostDetails(postId, postTitle);
        });
    </script>
@endpush
