@extends('frontend.employee.master')

@section('title', 'Settings')

@section('body')

    <!-- Mobile Back Header -->
    <section class="bg-white forSmall smallTop st-mobile-back">
        <a href="{{ route('employee.my-profile') }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#141c25" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            {{ trans('employee.settings') }}
        </a>
    </section>

    <!-- Main Content -->
    <div class="container container-main mt-md-5 mt-2">
        <!-- Left Side Menu -->
        @include('frontend.employee.jobs.left-menu')

        <!-- Right Content -->
        <section class="w-100 profileOptionRight st-content">

            <!-- Page Header -->
            <div class="st-page-header forLarge">
                <div class="st-header-text">
                    <h1>{{ trans('employee.settings') }}</h1>
                    <p>Manage your account preferences</p>
                </div>
            </div>

            <!-- Settings Card -->
            <div class="st-card">

                <!-- Language -->
                <div class="st-row" style="animation-delay: 0s">
                    <div class="st-row-left">
                        <div class="st-icon st-icon-lang">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        </div>
                        <div class="st-label-group">
                            <span class="st-label">{{ trans('index.language') }}</span>
                            <span class="st-sublabel">Choose your preferred language</span>
                        </div>
                    </div>
                    <div class="st-row-right">
                        <div class="st-select-wrap">
                            <select id="changeLocalLangOption" class="st-select">
                                <option {{ session('locale') == 'en' ? 'selected' : '' }} data-url="{{ route('change-local-language', ['local' => 'English']) }}">English</option>
                                <option {{ session('locale') == 'bn' ? 'selected' : '' }} data-url="{{ route('change-local-language', ['local' => 'Bangla']) }}">Bangla</option>
                            </select>
                            <svg class="st-select-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="st-row" style="animation-delay: .04s">
                    <div class="st-row-left">
                        <div class="st-icon st-icon-pass">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <div class="st-label-group">
                            <span class="st-label">{{ trans('employee.change_password') }}</span>
                            <span class="st-sublabel">Update your account password</span>
                        </div>
                    </div>
                    <div class="st-row-right">
                        <span class="st-masked-value">••••••••</span>
                        <button type="button" class="st-action-btn" data-bs-toggle="modal" data-bs-target="#settingModal">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Change
                        </button>
                    </div>
                </div>

                <!-- Change Email -->
                <div class="st-row" style="animation-delay: .08s">
                    <div class="st-row-left">
                        <div class="st-icon st-icon-email">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <div class="st-label-group">
                            <span class="st-label">{{ trans('employee.change_email') }}</span>
                            <span class="st-sublabel">{{ auth()->user()->email ?? 'demo@email.com' }}</span>
                        </div>
                    </div>
                    <div class="st-row-right">
                        <button type="button" class="st-action-btn" data-bs-toggle="modal" data-bs-target="#emailModal">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Change
                        </button>
                    </div>
                </div>

                <!-- Logout -->
                <div class="st-row st-row-last" style="animation-delay: .12s">
                    <div class="st-row-left">
                        <div class="st-icon st-icon-logout">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        </div>
                        <div class="st-label-group">
                            <span class="st-label">{{ trans('employee.log_out') }}</span>
                            <span class="st-sublabel">Sign out of your account</span>
                        </div>
                    </div>
                    <div class="st-row-right">
                        <form id="logoutForm" action="{{ route('logout') }}" method="post">
                            @csrf
                        </form>
                        <button type="button" class="st-logout-btn" onclick="document.getElementById('logoutForm').submit()">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Log Out
                        </button>
                    </div>
                </div>

            </div>

        </section>
    </div>

@endsection

@section('modal')
    <!-- Change Password Modal -->
    <div class="modal fade" id="settingModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content st-modal-content">
                <div class="modal-header st-modal-header">
                    <div class="st-modal-title-group">
                        <div class="st-modal-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <h5 class="modal-title">{{ trans('employee.change_password') }}</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <form action="{{ route('employee.update-profile', auth()->id()) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body st-modal-body">
                        <div class="st-form-group">
                            <label for="prevPass" class="st-form-label">{{ trans('employee.previous_password') }}</label>
                            <input type="password" id="prevPass" name="prev_password" class="form-control st-form-input" placeholder="{{ trans('auth.type_here') }}" />
                        </div>
                        <div class="st-form-group">
                            <label for="newPass" class="st-form-label">{{ trans('auth.new_password') }}</label>
                            <input type="password" name="new_password" id="newPass" class="form-control st-form-input" placeholder="{{ trans('auth.type_here') }}" />
                        </div>
                    </div>
                    <div class="modal-footer st-modal-footer">
                        <button type="button" class="st-modal-cancel" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                        <button type="submit" class="st-modal-save">{{ trans('common.save_changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Email Modal -->
    <div class="modal fade" id="emailModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content st-modal-content">
                <div class="modal-header st-modal-header">
                    <div class="st-modal-title-group">
                        <div class="st-modal-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <h5 class="modal-title">{{ trans('employee.change_email') }}</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <form action="{{ route('employee.update-profile', auth()->id()) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body st-modal-body">
                        <div class="st-form-group">
                            <label for="email" class="st-form-label">{{ trans('common.email') }}</label>
                            <input type="email" id="email" name="email" class="form-control st-form-input" value="{{ auth()->user()->email ?? '' }}" placeholder="{{ trans('auth.type_here') }}" />
                        </div>
                    </div>
                    <div class="modal-footer st-modal-footer">
                        <button type="button" class="st-modal-cancel" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                        <button type="submit" class="st-modal-save">{{ trans('common.save_changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('frontend/page-custom-codes/employee/settings/style.css') }}">
@endpush

@push('script')
    <script>
        $(document).on('change', '#changeLocalLangOption', function () {
            var url = $(this).find('option:selected').attr('data-url');
            window.location = url;
        })
    </script>
@endpush
