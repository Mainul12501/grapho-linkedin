@extends('frontend.employee.master')

@section('title', 'My Profile Viewers')

@section('body')

    <!-- Mobile Back Header -->
    <section class="bg-white forSmall smallTop pv-mobile-back">
        <a href="{{ route('employee.my-profile') }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#141c25" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            {{ trans('employee.profiler_viewers') }}
        </a>
    </section>

    <!-- Main Content -->
    <div class="container container-main mt-md-5 mt-2">
        <!-- Left Side Menu -->
        @include('frontend.employee.jobs.left-menu')

        <!-- Right Content -->
        <section class="w-100 profileOptionRight pv-content">

            <!-- Page Header -->
            <div class="pv-page-header forLarge">
                <div class="pv-header-text">
                    <h1>{{ trans('employee.profiler_viewers') }}</h1>
                    <p>People who viewed your profile recently</p>
                </div>
                <div class="pv-header-count">
                    <span class="pv-count-number">{{ count($myProfileViewers) ?? 0 }}</span>
                    <span class="pv-count-label">Viewers</span>
                </div>
            </div>

            <!-- Mobile Subheader -->
            <div class="forSmall pv-mobile-subheader">
                <p>You have {{ count($myProfileViewers) ?? 0 }} profile {{ Str::plural('viewer', count($myProfileViewers)) }}</p>
            </div>

            <!-- Viewers List -->
            <div class="pv-list-wrap">
                <div class="pv-list" id="viewer-container">
                    @if(count($myProfileViewers) > 0)
                        @include('frontend.employee.base-functionalities.partials.profile-viewer-items', ['profileViewerIds' => $myProfileViewers])
                    @else
                        <div class="pv-empty-state">
                            <div class="pv-empty-icon">
                                <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#cfd2d9" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </div>
                            <h3>No profile views yet</h3>
                            <p>When employers view your profile, they'll appear here</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Infinite Scroll Loader -->
            <div id="loader" class="pv-loader" style="display:none;">
                <div class="pv-spinner"></div>
                <span>Loading more...</span>
            </div>

        </section>
    </div>

@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('frontend/page-custom-codes/employee/profile-viewers/style.css') }}">

@endpush

@push('script')
    <script src="{{ asset('frontend/page-custom-codes/employee/profile-viewers/script.js') }}"></script>
@endpush
