@extends('frontend.employee.master')

@section('title', 'My Applications')

@section('body')

    <!-- Mobile Back Header -->
    <section class="bg-white forSmall smallTop ma-mobile-back">
        <a href="{{ route('employee.my-profile') }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#141c25" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            {{ trans('employee.my_applications') }}
        </a>
    </section>

    <!-- Main Content -->
    <div class="container container-main mt-md-5 mt-2">
        <!-- Left Side Menu -->
        @include('frontend.employee.jobs.left-menu')

        <!-- Right Content -->
        <section class="w-100 profileOptionRight ma-content">

            <!-- Page Header -->
            <div class="ma-page-header forLarge">
                <div class="ma-header-text">
                    <h1>{{ trans('employee.my_applications') }}</h1>
{{--                    <p>{{ trans('employee.you_have_applied_to_jobs', ['count' => count($myApplications) ?? 0]) }}</p>--}}
                </div>
                <div class="ma-header-count">
                    <span class="ma-count-number">{{ count($myApplications) ?? 0 }}</span>
                    <span class="ma-count-label">Applied</span>
                </div>
            </div>

            <!-- Mobile Subheader -->
            <div class="forSmall ma-mobile-subheader">
{{--                <p>{{ trans('employee.you_have_applied_to_jobs', ['count' => count($myApplications) ?? 0]) }}</p>--}}
            </div>

            <!-- Applications Table -->
            <div class="ma-table-wrap">
                <!-- Desktop Table Header -->
                <div class="ma-table-header">
                    <span class="ma-th-company">{{ trans('employee.company') }}</span>
                    <span class="ma-th-position">{{ trans('employee.position') }}</span>
                    <span class="ma-th-date">{{ trans('employee.applied_on') }}</span>
                    <span class="ma-th-status">{{ trans('common.status') }}</span>
                    <span class="ma-th-action">{{ trans('common.action') }}</span>
                </div>

                <!-- Applications List -->
                <div class="ma-table-body" id="job-container">
                    @if(count($myApplications) > 0)
                        @include('frontend.employee.jobs.partials.my-applications-items')
                    @else
                        <div class="ma-empty-state">
                            <div class="ma-empty-icon">
                                <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#cfd2d9" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            </div>
                            <h3>No applications yet</h3>
                            <p>{{ trans('employee.havent_applied_any_job') }}</p>
                            <a href="{{ route('employee.show-jobs') }}" class="ma-browse-btn">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                Browse Jobs
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Infinite Scroll Loader -->
            <div id="loader" class="ma-loader" style="display:none;">
                <div class="ma-spinner"></div>
                <span>Loading more...</span>
            </div>

        </section>
    </div>

    <!-- Job Details Modal -->
    <div class="modal fade" id="jobModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content ma-modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="jobDetailsBody">
                    <p>Loading job details...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('frontend/page-custom-codes/employee/my-applications/style.css') }}">

@endpush

@push('script')
    <script src="{{ asset('frontend/page-custom-codes/employee/my-applications/script.js') }}"></script>
@endpush
