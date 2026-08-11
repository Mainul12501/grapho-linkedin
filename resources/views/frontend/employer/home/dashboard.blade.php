@extends('frontend.employer.master')

@section('title', 'Employer Home')

@section('body')
    <main class="ed-dashboard">
        <div class="ed-container">
            {{-- ===== Page Header ===== --}}
            <header class="ed-page-header">
                <div class="ed-header-left">
                    <h1 class="ed-page-title">Activities</h1>
                    <p class="ed-page-subtitle">Your jobs, posts &amp; company updates</p>
                </div>
                <div class="ed-header-actions">
                    <a href="{{ route('employer.my-jobs', ['show_modal' => 'create']) }}" class="ed-btn ed-btn-primary post-job-hide-mobile">
                        <i class="fa-solid fa-plus"></i>
                        <span>Post a Job</span>
                    </a>
                    <a href="{{ route('employer.posts.create') }}" class="ed-btn ed-btn-outline">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Create Post</span>
                    </a>
                </div>
            </header>

            <div class="ed-layout">
                {{-- ===== Left Sidebar: Quick Actions ===== --}}
                <aside class="ed-sidebar">
                    <div class="ed-sidebar-sticky">
                        {{-- Post a Job CTA --}}
                        <div class="ed-cta-card ed-cta-hire">
                            <div class="ed-cta-icon-wrap">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                            <h3 class="ed-cta-title">Find Your Next Hire</h3>
                            <p class="ed-cta-desc">Post a job and reach thousands of qualified candidates</p>
                            <a href="{{ route('employer.my-jobs', ['show_modal' => 'create']) }}" class="ed-btn ed-btn-dark ed-btn-block">
                                <i class="fa-solid fa-plus"></i> Post a Job
                            </a>
                        </div>

                        {{-- Head Hunt CTA --}}
                        <div class="ed-cta-card ed-cta-hunt">
                            <div class="ed-cta-icon-wrap ed-cta-icon-hunt">
                                <i class="fa-solid fa-magnifying-glass-chart"></i>
                            </div>
                            <h3 class="ed-cta-title">Head Hunt Talent</h3>
                            <p class="ed-cta-desc">Search, filter, and discover the best employees for your company</p>
                            <a href="{{ route('employer.head-hunt') }}" class="ed-btn ed-btn-outline-dark ed-btn-block">
                                <i class="fa-solid fa-crosshairs"></i> Browse Talent
                            </a>
                        </div>

                        {{-- Quick Stats --}}
                        <div class="ed-quick-links">
                            <a href="{{ route('employer.my-jobs') }}" class="ed-quick-link">
                                <i class="fa-solid fa-list-check"></i>
                                <span>My Jobs</span>
                                <i class="fa-solid fa-chevron-right ed-ql-arrow"></i>
                            </a>
                            <a href="{{ route('employer.my-job-wise-applicants') }}" class="ed-quick-link">
                                <i class="fa-solid fa-user-check"></i>
                                <span>Applicants</span>
                                <i class="fa-solid fa-chevron-right ed-ql-arrow"></i>
                            </a>
                            <a href="{{ route('employer.company-profile') }}" class="ed-quick-link">
                                <i class="fa-solid fa-building"></i>
                                <span>Company Profile</span>
                                <i class="fa-solid fa-chevron-right ed-ql-arrow"></i>
                            </a>
                        </div>
                    </div>
                </aside>

                {{-- ===== Main Content: Activity Feed ===== --}}
                <section class="ed-main">
                    <div class="ed-feed" id="item-container">
                        @include('frontend.employer.home.activity-content')

                        <div id="loader" class="ed-loader" style="display:none;">
                            <div class="ed-spinner"></div>
                            <span>Loading more...</span>
                        </div>

                        <div id="no-more-data" class="ed-end-msg" style="display:none;">
                            <i class="fa-solid fa-check-circle"></i>
                            <span>You're all caught up</span>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

    {{-- ===== View Job Modal ===== --}}
    <div class="modal fade" tabindex="-1" id="viewJobModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content ed-modal-content">
                <div class="modal-header ed-modal-header">
                    <h5 class="modal-title ed-modal-title" id="viewJobModalTitle">{{ trans('common.view_job_post') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ed-modal-body" id="viewJobModalBody">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer ed-modal-footer">
                    <button type="button" class="ed-btn ed-btn-outline" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== View Post Modal ===== --}}
    <div class="modal fade" id="viewPostModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content ed-modal-content">
                <div class="modal-header ed-modal-header">
                    <h5 class="modal-title ed-modal-title" id="viewPostModalTitle">View Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ed-modal-body" id="viewPostModalBody">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer ed-modal-footer">
                    <button type="button" class="ed-btn ed-btn-outline" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('frontend/page-custom-codes/employer/dashboard/style.css') }}">
@endpush

@push('script')
    <link rel="stylesheet" href="{{ asset('frontend/zoom-plugin/mbox.css') }}">
    <script src="{{ asset('frontend/zoom-plugin/mbox.min.js') }}"></script>

    <script>
        var lastPage = {{ $paginatedData->lastPage() }};
    </script>
    <script src="{{ asset('frontend/page-custom-codes/employer/dashboard/script.js') }}"></script>
@endpush
