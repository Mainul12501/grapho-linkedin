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
    <style>
        /* ================================================
           SETTINGS REDESIGN — Scoped with .st- prefix
           ================================================ */

        .st-mobile-back a {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            color: #141c25;
            padding: 16px 20px;
        }

        /* --- Sidebar Navigation (shared) --- */
        .sj-sidebar {
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            border: 1px solid #f0f1f3;
            box-shadow: 0 1px 3px rgba(20,28,37,.04), 0 6px 16px rgba(20,28,37,.03);
            padding: 8px !important;
        }

        .sj-nav-link {
            border-radius: 10px !important;
            padding: 14px 16px !important;
            margin-bottom: 2px;
            transition: all .2s ease !important;
            text-decoration: none !important;
            border-bottom: none !important;
        }

        .sj-nav-link:hover {
            background: #f8f9fa !important;
        }

        .sj-nav-link .d-flex {
            gap: 14px;
        }

        .sj-nav-icon {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            border-radius: 10px;
            color: #667080;
            flex-shrink: 0;
            margin-right: 0 !important;
            transition: all .2s ease;
        }

        .sj-nav-link:hover .sj-nav-icon {
            background: #FFF8E1;
            color: #d4a017;
        }

        .sj-nav-link .text {
            font-weight: 500 !important;
            font-size: 15px !important;
            color: #484f5b !important;
        }

        .sj-nav-active {
            background: #FFFBEB !important;
            border-left: none !important;
        }

        .sj-nav-active .sj-nav-icon {
            background: #FFCB11 !important;
            color: #141c25 !important;
        }

        .sj-nav-active .text {
            font-weight: 700 !important;
            color: #141c25 !important;
        }

        /* --- Page Header --- */
        .st-page-header {
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f1f3;
        }

        .st-header-text h1 {
            font-size: 26px;
            font-weight: 800;
            color: #141c25;
            margin: 0 0 4px;
            letter-spacing: -0.3px;
        }

        .st-header-text p {
            font-size: 14px;
            color: #7c8391;
            margin: 0;
        }

        /* --- Settings Card --- */
        .st-card {
            background: #fff;
            border: 1px solid #f0f1f3;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(20,28,37,.04), 0 6px 16px rgba(20,28,37,.03);
            overflow: hidden;
        }

        @keyframes stFadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* --- Settings Row --- */
        .st-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 28px;
            border-bottom: 1px solid #f5f6f7;
            transition: background .18s ease;
            animation: stFadeUp .4s ease both;
        }

        .st-row:hover {
            background: #fafbfc;
        }

        .st-row-last {
            border-bottom: none;
        }

        .st-row-left {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1;
            min-width: 0;
        }

        .st-row-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        /* --- Setting Icons --- */
        .st-icon {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            flex-shrink: 0;
            transition: all .2s ease;
        }

        .st-icon-lang {
            background: #EFF6FF;
            color: #3B82F6;
        }

        .st-icon-pass {
            background: #FFF7ED;
            color: #F59E0B;
        }

        .st-icon-email {
            background: #F0FDF4;
            color: #22C55E;
        }

        .st-icon-logout {
            background: #FEF2F2;
            color: #EF4444;
        }

        /* --- Labels --- */
        .st-label-group {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
        }

        .st-label {
            font-size: 15px;
            font-weight: 650;
            color: #141c25;
        }

        .st-sublabel {
            font-size: 13px;
            color: #8c919d;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .st-masked-value {
            font-size: 14px;
            color: #b0b5be;
            letter-spacing: 2px;
        }

        /* --- Language Select --- */
        .st-select-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .st-select {
            appearance: none;
            -webkit-appearance: none;
            background: #f8f9fb;
            border: 1px solid #e8e9ec;
            border-radius: 10px;
            padding: 9px 36px 9px 14px;
            font-size: 14px;
            font-weight: 600;
            color: #141c25;
            cursor: pointer;
            transition: all .2s ease;
            outline: none;
        }

        .st-select:hover {
            border-color: #d4d6db;
        }

        .st-select:focus {
            border-color: #FFCB11;
            box-shadow: 0 0 0 3px rgba(255,203,17,.15);
        }

        .st-select-arrow {
            position: absolute;
            right: 10px;
            pointer-events: none;
            color: #8c919d;
        }

        /* --- Action Buttons --- */
        .st-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #484f5b;
            background: #f3f4f6;
            border: 1px solid transparent;
            border-radius: 10px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .st-action-btn:hover {
            background: #FFFBEB;
            color: #141c25;
            border-color: #FFECB3;
        }

        .st-logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #dc2626;
            background: #FEF2F2;
            border: 1px solid transparent;
            border-radius: 10px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .st-logout-btn:hover {
            background: #FEE2E2;
            border-color: #FECACA;
        }

        /* --- Modal Styles --- */
        .st-modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 40px rgba(20,28,37,.12);
            overflow: hidden;
        }

        .st-modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid #f0f1f3;
        }

        .st-modal-title-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .st-modal-icon {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #FFF7ED;
            color: #F59E0B;
            border-radius: 10px;
        }

        #emailModal .st-modal-icon {
            background: #F0FDF4;
            color: #22C55E;
        }

        .st-modal-header .modal-title {
            font-size: 18px;
            font-weight: 700;
            color: #141c25;
            margin: 0;
        }

        .st-modal-body {
            padding: 24px;
        }

        .st-form-group {
            margin-bottom: 18px;
        }

        .st-form-group:last-child {
            margin-bottom: 0;
        }

        .st-form-label {
            display: block;
            font-size: 13px;
            font-weight: 650;
            color: #484f5b;
            margin-bottom: 6px;
        }

        .st-form-input {
            border-radius: 10px !important;
            border: 1px solid #e4e5e9 !important;
            padding: 11px 14px !important;
            font-size: 14px !important;
            transition: all .2s ease !important;
        }

        .st-form-input:focus {
            border-color: #FFCB11 !important;
            box-shadow: 0 0 0 3px rgba(255,203,17,.12) !important;
        }

        .st-modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #f0f1f3;
            gap: 10px;
        }

        .st-modal-cancel {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            color: #667080;
            background: #f3f4f6;
            border: 1px solid #e8e9ec;
            border-radius: 10px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .st-modal-cancel:hover {
            background: #e8e9ec;
        }

        .st-modal-save {
            padding: 10px 24px;
            font-size: 14px;
            font-weight: 700;
            color: #141c25;
            background: #FFCB11;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .st-modal-save:hover {
            background: #f0be00;
            box-shadow: 0 3px 12px rgba(255,203,17,.3);
        }

        /* ================================================
           RESPONSIVE
           ================================================ */

        @media (max-width: 768px) {
            .st-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 14px;
                padding: 18px 20px;
            }

            .st-row-right {
                width: 100%;
                justify-content: flex-end;
            }

            .st-icon {
                width: 40px;
                height: 40px;
                border-radius: 10px;
            }

            .st-label {
                font-size: 14px;
            }

            .st-sublabel {
                font-size: 12px;
            }

            .st-card {
                border-radius: 14px;
                border: none;
                box-shadow: 0 1px 4px rgba(20,28,37,.06);
            }

            .st-modal-content {
                border-radius: 14px;
                margin: 12px;
            }

            .st-modal-body {
                padding: 20px;
            }

            .st-modal-footer {
                flex-wrap: wrap;
            }

            .st-modal-cancel,
            .st-modal-save {
                flex: 1;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .st-row {
                padding: 16px;
            }

            .st-masked-value {
                display: none;
            }
        }
    </style>
@endpush

@push('script')
    <script>
        $(document).on('change', '#changeLocalLangOption', function () {
            var url = $(this).find('option:selected').attr('data-url');
            window.location = url;
        })
    </script>
@endpush
