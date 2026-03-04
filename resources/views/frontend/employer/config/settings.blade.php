@extends('frontend.employer.master')

@section('title', 'Settings')

@section('body')
    <main class="dashboardContent p-3 p-md-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-11 mx-auto">

                    <!-- Page Header -->
                    <div class="st-page-header">
                        <h1 class="st-page-title">{{ trans('employer.my_account') }}</h1>
                        <p class="st-page-subtitle">Manage your account settings and preferences</p>
                    </div>

                    <div class="row g-4">

                        <!-- Side Menu -->
                        <nav class="col-lg-3 col-md-4 d-none d-md-block">
                            <div class="st-sidenav">
                                <a href="{{ route('employer.settings') }}" class="st-nav-item {{ request()->is('employer/settings') ? 'active' : '' }}">
                                    <div class="st-nav-icon">
                                        <i class="fa-solid fa-gear"></i>
                                    </div>
                                    <span>{{ trans('employer.my_account') }}</span>
                                </a>
                                <a href="{{ route('employer.employer-user-management') }}" class="st-nav-item {{ request()->is('employer/employer-user-management') ? 'active' : '' }}">
                                    <div class="st-nav-icon">
                                        <i class="fa-solid fa-users-gear"></i>
                                    </div>
                                    <span>{{ trans('home.users_management') }}</span>
                                </a>
                            </div>
                        </nav>

                        <!-- Settings Content -->
                        <section class="col-lg-9 col-md-8 col-12">
                            <div class="st-card">

                                <!-- Full Name -->
                                <div class="st-row" data-bs-toggle="modal" data-bs-target="#employeeSettingsModal">
                                    <div class="st-row-left">
                                        <div class="st-icon">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <div class="st-label-group">
                                            <span class="st-label">{{ trans('employer.full_name') }}</span>
                                            <span class="st-sublabel">Update your display name</span>
                                        </div>
                                    </div>
                                    <div class="st-row-right">
                                        <span class="st-value">{{ $loggedUser->name ?? 'User Name' }}</span>
                                        <i class="fa-solid fa-chevron-right st-arrow"></i>
                                    </div>
                                </div>

                                <!-- Change Password -->
                                <div class="st-row" data-bs-toggle="modal" data-bs-target="#employeePasswordChangeModal">
                                    <div class="st-row-left">
                                        <div class="st-icon">
                                            <i class="fa-solid fa-lock"></i>
                                        </div>
                                        <div class="st-label-group">
                                            <span class="st-label">{{ trans('employee.change_password') }}</span>
                                            <span class="st-sublabel">Secure your account with a new password</span>
                                        </div>
                                    </div>
                                    <div class="st-row-right">
                                        <span class="st-value st-masked">••••••••</span>
                                        <i class="fa-solid fa-chevron-right st-arrow"></i>
                                    </div>
                                </div>

                                <!-- Change Email -->
                                <div class="st-row" data-bs-toggle="modal" data-bs-target="#employeeSettingsModal">
                                    <div class="st-row-left">
                                        <div class="st-icon">
                                            <i class="fa-solid fa-envelope"></i>
                                        </div>
                                        <div class="st-label-group">
                                            <span class="st-label">{{ trans('employee.change_email') }}</span>
                                            <span class="st-sublabel">Update your email address</span>
                                        </div>
                                    </div>
                                    <div class="st-row-right">
                                        <span class="st-value">{{ $loggedUser->email ?? 'email@example.com' }}</span>
                                        <i class="fa-solid fa-chevron-right st-arrow"></i>
                                    </div>
                                </div>

                                <!-- Language -->
                                <div class="st-row st-row-no-click">
                                    <div class="st-row-left">
                                        <div class="st-icon">
                                            <i class="fa-solid fa-globe"></i>
                                        </div>
                                        <div class="st-label-group">
                                            <span class="st-label">{{ trans('employee.language') }}</span>
                                            <span class="st-sublabel">Choose your preferred language</span>
                                        </div>
                                    </div>
                                    <div class="st-row-right">
                                        <div class="dropdown">
                                            <button class="st-lang-btn dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-language"></i>
                                                @if(session('locale') == 'bn')
                                                    {{ trans('employee.bangla') }}
                                                @else
                                                    {{ trans('employee.english') }}
                                                @endif
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end st-dropdown" aria-labelledby="languageDropdown">
                                                <li>
                                                    <a class="dropdown-item {{ session('locale') == 'en' ? 'active' : '' }}" href="{{ route('change-local-language', ['local' => 'English']) }}">
                                                        {{ trans('employee.english') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item {{ session('locale') == 'bn' ? 'active' : '' }}" href="{{ route('change-local-language', ['local' => 'Bangla']) }}">
                                                        {{ trans('employee.bangla') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Log Out -->
                                <div class="st-row st-row-danger" onclick="event.preventDefault(); document.getElementById('pageLogoutForm').submit();">
                                    <div class="st-row-left">
                                        <div class="st-icon st-icon-danger">
                                            <i class="fa-solid fa-right-from-bracket"></i>
                                        </div>
                                        <div class="st-label-group">
                                            <span class="st-label st-label-danger">{{ trans('employee.log_out') }}</span>
                                            <span class="st-sublabel">Sign out of your account</span>
                                        </div>
                                    </div>
                                    <div class="st-row-right">
                                        <i class="fa-solid fa-chevron-right st-arrow"></i>
                                    </div>
                                </div>

                                <form action="{{ route('logout') }}" method="post" id="pageLogoutForm">
                                    @csrf
                                </form>

                            </div>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('modal')
    <!-- Edit Settings Modal -->
    <div class="modal fade" id="employeeSettingsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content st-modal">
                <div class="modal-header st-modal-header">
                    <h5 class="modal-title st-modal-title">{{ trans('employer.edit_settings') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('employer.update-settings') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body st-modal-body">
                        <div class="st-form-group">
                            <label class="st-form-label">{{ trans('employer.full_name') }}</label>
                            <input type="text" class="form-control st-input" name="name" value="{{ $loggedUser->name ?? '' }}" placeholder="{{ trans('employer.enter_your_full_name') }}">
                        </div>
                        <div class="st-form-group">
                            <label class="st-form-label">{{ trans('common.email') }}</label>
                            <input type="text" class="form-control st-input" name="email" value="{{ $loggedUser->email ?? '' }}" placeholder="{{ trans('employer.enter_your_email') }}">
                        </div>
                        <div class="st-form-group">
                            <label class="st-form-label">{{ trans('employer.mobile') }}</label>
                            <input type="text" class="form-control st-input" name="mobile" value="{{ $loggedUser->mobile ?? '' }}" placeholder="{{ trans('employer.enter_your_email') }}">
                        </div>
                        <div class="st-form-group">
                            <label class="st-form-label">{{ trans('employee.profile_image') }}</label>
                            <input type="file" class="form-control st-input" name="profile_image" placeholder="{{ trans('employer.enter_profile_image') }}" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer st-modal-footer">
                        <button type="button" class="btn st-btn-cancel" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                        <button type="submit" class="btn st-btn-save">{{ trans('common.save_changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Password Change Modal -->
    <div class="modal fade" id="employeePasswordChangeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content st-modal">
                <div class="modal-header st-modal-header">
                    <h5 class="modal-title st-modal-title">{{ trans('employer.change_password_label') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('auth.user-password-update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body st-modal-body">
                        <div class="st-form-group">
                            <label class="st-form-label">{{ trans('employee.previous_password') }}</label>
                            <input type="password" class="form-control st-input" name="old_password" required placeholder="{{ trans('employer.enter_old_password') }}">
                        </div>
                        <div class="st-form-group">
                            <label class="st-form-label">{{ trans('employer.new_password') }}</label>
                            <input type="text" class="form-control st-input" name="password" required placeholder="{{ trans('employer.enter_new_password') }}">
                        </div>
                    </div>
                    <div class="modal-footer st-modal-footer">
                        <button type="button" class="btn st-btn-cancel" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                        <button type="submit" class="btn st-btn-save">{{ trans('employee.change_password') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        /* =============================================
           Employer Settings — eh- design system
           ============================================= */

        /* --- Page Header --- */
        .st-page-header {
            margin-bottom: 24px;
            padding-top: 4px;
        }

        .st-page-title {
            font-size: 24px;
            font-weight: 700;
            color: #0F172A;
            margin: 0;
            line-height: 1.2;
        }

        .st-page-subtitle {
            font-size: 13px;
            color: #64748B;
            margin: 4px 0 0;
        }

        /* --- Side Navigation --- */
        .st-sidenav {
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 8px;
            /*position: sticky;*/
            position: static;
            top: 80px;
        }
        .st-sidenav .active i, .st-sidenav .active span {color: white!important;}

        .st-nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            border-radius: 10px;
            text-decoration: none;
            color: #475569;
            font-size: 14px;
            font-weight: 500;
            transition: all .2s;
        }

        .st-nav-item:hover {
            background: #F8FAFC;
            color: #0F172A;
        }

        .st-nav-item.active {
            background: #141C25;
            color: #fff;
            font-weight: 600;
        }

        .st-nav-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #64748B;
            flex-shrink: 0;
            transition: all .2s;
        }

        .st-nav-item.active .st-nav-icon {
            background: rgba(255,203,17,.2);
            color: #FFCB11;
        }

        .st-nav-item:hover .st-nav-icon {
            background: #E2E8F0;
            color: #0F172A;
        }

        .st-nav-item.active:hover .st-nav-icon {
            background: rgba(255,203,17,.2);
            color: #FFCB11;
        }

        /* --- Settings Card --- */
        .st-card {
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            overflow: hidden;
        }

        /* --- Settings Row --- */
        .st-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            border-bottom: 1px solid #F1F5F9;
            cursor: pointer;
            transition: background .15s;
            gap: 12px;
        }

        .st-row:last-of-type {
            border-bottom: none;
        }

        .st-row:hover {
            background: #F8FAFC;
        }

        .st-row-no-click {
            cursor: default;
        }

        .st-row-no-click:hover {
            background: transparent;
        }

        .st-row-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .st-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #64748B;
            flex-shrink: 0;
            transition: all .2s;
        }

        .st-row:hover .st-icon {
            background: #E2E8F0;
            color: #0F172A;
        }

        .st-row-no-click:hover .st-icon {
            background: #F1F5F9;
            color: #64748B;
        }

        .st-icon-danger {
            background: #FEF2F2;
            color: #EF4444;
        }

        .st-row:hover .st-icon-danger {
            background: #FEE2E2;
            color: #DC2626;
        }

        .st-label-group {
            min-width: 0;
        }

        .st-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #0F172A;
            line-height: 1.3;
        }

        .st-label-danger {
            color: #EF4444;
        }

        .st-sublabel {
            display: block;
            font-size: 12px;
            color: #94A3B8;
            margin-top: 2px;
            line-height: 1.3;
        }

        .st-row-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .st-value {
            font-size: 13px;
            color: #64748B;
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .st-masked {
            letter-spacing: 2px;
            color: #94A3B8;
        }

        .st-arrow {
            font-size: 11px;
            color: #CBD5E1;
            transition: transform .2s, color .2s;
        }

        .st-row:hover .st-arrow {
            color: #64748B;
            transform: translateX(2px);
        }

        /* --- Language Button --- */
        .st-lang-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #F1F5F9;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 7px 14px;
            font-size: 13px;
            font-weight: 600;
            color: #0F172A;
            cursor: pointer;
            transition: all .2s;
            font-family: 'Geist', sans-serif;
        }

        .st-lang-btn:hover,
        .st-lang-btn:focus {
            background: #E2E8F0;
            border-color: #CBD5E1;
        }

        .st-lang-btn i {
            color: #FFCB11;
        }

        .st-dropdown {
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(15,23,42,.1);
            padding: 4px;
            min-width: 140px;
        }

        .st-dropdown .dropdown-item {
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: 500;
            color: #475569;
            transition: all .15s;
        }

        .st-dropdown .dropdown-item:hover {
            background: #F1F5F9;
            color: #0F172A;
        }

        .st-dropdown .dropdown-item.active {
            background: #141C25;
            color: #FFCB11;
            font-weight: 600;
        }

        /* --- Modal Styles --- */
        .st-modal {
            border: none;
            border-radius: 16px;
            overflow: hidden;
        }

        .st-modal-header {
            border-bottom: 1px solid #F1F5F9;
            padding: 20px 24px;
        }

        .st-modal-title {
            font-size: 18px;
            font-weight: 700;
            color: #0F172A;
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
            font-weight: 600;
            color: #0F172A;
            margin-bottom: 6px;
        }

        .st-input {
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            color: #0F172A;
            transition: border-color .2s, box-shadow .2s;
            font-family: 'Geist', sans-serif;
        }

        .st-input:focus {
            border-color: #FFCB11;
            box-shadow: 0 0 0 3px rgba(255,203,17,.15);
        }

        .st-input::placeholder {
            color: #94A3B8;
        }

        .st-modal-footer {
            border-top: 1px solid #F1F5F9;
            padding: 16px 24px;
            gap: 8px;
        }

        .st-btn-cancel {
            background: #F1F5F9;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            transition: all .2s;
            font-family: 'Geist', sans-serif;
        }

        .st-btn-cancel:hover {
            background: #E2E8F0;
            color: #0F172A;
        }

        .st-btn-save {
            background: #141C25;
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-size: 13px;
            font-weight: 700;
            color: #FFCB11;
            transition: all .2s;
            font-family: 'Geist', sans-serif;
        }

        .st-btn-save:hover {
            background: #0F172A;
            color: #FFCB11;
        }

        /* =============================================
           Responsive
           ============================================= */

        @media (max-width: 767px) {
            .st-page-header {
                margin-bottom: 16px;
            }

            .st-page-title {
                font-size: 20px;
            }

            .st-card {
                border-radius: 12px;
            }

            .st-row {
                padding: 14px 16px;
                gap: 10px;
            }

            .st-icon {
                width: 36px;
                height: 36px;
                font-size: 14px;
                border-radius: 8px;
            }

            .st-label {
                font-size: 13px;
            }

            .st-sublabel {
                font-size: 11px;
            }

            .st-value {
                max-width: 120px;
                font-size: 12px;
            }

            .st-modal-header {
                padding: 16px 18px;
            }

            .st-modal-body {
                padding: 18px;
            }

            .st-modal-footer {
                padding: 14px 18px;
            }
        }

        @media (max-width: 575px) {
            .st-row {
                padding: 12px 14px;
            }

            .st-row-left {
                gap: 10px;
            }

            .st-icon {
                width: 34px;
                height: 34px;
                font-size: 13px;
            }

            .st-label {
                font-size: 12.5px;
            }

            .st-value {
                max-width: 90px;
                font-size: 11px;
            }

            .st-sublabel {
                display: none;
            }

            .st-lang-btn {
                padding: 6px 10px;
                font-size: 12px;
            }
        }
    </style>
@endpush

@push('script')
    {{-- Profile edit validation --}}
    <script>
        // Employee Settings Form Validation
        $(document).ready(function() {

            // Validate Employee Settings Form on Submit
            $('#employeeSettingsModal form').on('submit', function(e) {
                e.preventDefault();

                // Clear previous errors
                clearSettingsErrors();

                let isValid = true;
                let errors = [];

                // 1. Name Validation - Required
                const nameInput = $(this).find('[name="name"]');
                const nameValue = nameInput.val().trim();

                if (!nameValue) {
                    showSettingsError(nameInput, 'Full name is required');
                    errors.push('Full name is required');
                    isValid = false;
                } else if (nameValue.length < 3) {
                    showSettingsError(nameInput, 'Full name must be at least 3 characters');
                    errors.push('Full name must be at least 3 characters');
                    isValid = false;
                }

                // 2. Mobile Validation - Bangladeshi format (01XXXXXXXXX - 11 digits starting with 01)
                const mobileInput = $(this).find('[name="mobile"]');
                const mobileValue = mobileInput.val().trim();

                if (!mobileValue) {
                    showSettingsError(mobileInput, 'Mobile number is required');
                    errors.push('Mobile number is required');
                    isValid = false;
                } else {
                    // Check if mobile contains only digits
                    const onlyDigits = /^[0-9]+$/;
                    if (!onlyDigits.test(mobileValue)) {
                        showSettingsError(mobileInput, 'Mobile number must contain only digits (no text or special characters)');
                        errors.push('Invalid mobile format - only digits allowed');
                        isValid = false;
                    }
                    // Check Bangladeshi mobile format: starts with 01 and exactly 11 digits
                    else if (!mobileValue.startsWith('01')) {
                        showSettingsError(mobileInput, 'Bangladeshi mobile number must start with 01');
                        errors.push('Mobile must start with 01');
                        isValid = false;
                    } else if (mobileValue.length !== 11) {
                        showSettingsError(mobileInput, 'Bangladeshi mobile number must be exactly 11 digits');
                        errors.push('Mobile must be 11 digits');
                        isValid = false;
                    }
                    // Additional validation for valid BD operator prefixes
                    else {
                        const validPrefixes = ['013', '014', '015', '016', '017', '018', '019'];
                        const prefix = mobileValue.substring(0, 3);
                        if (!validPrefixes.includes(prefix)) {
                            showSettingsError(mobileInput, 'Invalid Bangladeshi mobile operator (must start with 013-019)');
                            errors.push('Invalid mobile operator prefix');
                            isValid = false;
                        }
                    }
                }

                // 3. Email Validation
                const emailInput = $(this).find('[name="email"]');
                const emailValue = emailInput.val().trim();

                if (emailValue) {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailPattern.test(emailValue)) {
                        showSettingsError(emailInput, 'Please enter a valid email address');
                        errors.push('Invalid email format');
                        isValid = false;
                    }
                }

                // 4. Profile Image Validation
                const profileImageInput = $(this).find('[name="profile_image"]');
                if (profileImageInput[0].files.length > 0) {
                    const file = profileImageInput[0].files[0];
                    const fileSize = file.size / 1024 / 1024; // Convert to MB
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];

                    if (!allowedTypes.includes(file.type)) {
                        showSettingsError(profileImageInput, 'Profile image must be a valid image file (JPEG, PNG, GIF, WEBP)');
                        errors.push('Invalid image file type');
                        isValid = false;
                    } else if (fileSize > 5) {
                        showSettingsError(profileImageInput, 'Profile image must be less than 5MB');
                        errors.push('Image file too large');
                        isValid = false;
                    }
                }

                // Show error summary if validation fails
                if (!isValid) {
                    displaySettingsErrorSummary(errors);

                    // Scroll to first error
                    const firstError = $('#employeeSettingsModal .is-invalid').first();
                    if (firstError.length) {
                        firstError[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }

                    return false;
                }

                // All validations passed - submit the form
                this.submit();
            });

            // Real-time validation - clear errors on input
            $('#employeeSettingsModal').on('input', 'input', function() {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').remove();
                $('.settings-error-summary').remove();
            });

            // Clear errors when modal is closed
            $('#employeeSettingsModal').on('hidden.bs.modal', function() {
                clearSettingsErrors();
            });

            // Real-time mobile number formatting and validation
            $('#employeeSettingsModal [name="mobile"]').on('input', function() {
                // Remove any non-digit characters
                let value = $(this).val().replace(/\D/g, '');

                // Limit to 11 digits
                if (value.length > 11) {
                    value = value.substring(0, 11);
                }

                $(this).val(value);
            });
        });

        // Helper function to show error for settings form
        function showSettingsError(element, message) {
            element.addClass('is-invalid');

            const errorDiv = $('<div class="invalid-feedback d-block"></div>').text(message);
            element.after(errorDiv);
        }

        // Helper function to clear all errors in settings form
        function clearSettingsErrors() {
            $('#employeeSettingsModal .is-invalid').removeClass('is-invalid');
            $('#employeeSettingsModal .invalid-feedback').remove();
            $('#employeeSettingsModal .settings-error-summary').remove();
        }

        // Display error summary at the top of modal body
        function displaySettingsErrorSummary(errors) {
            const summaryHtml = `
        <div class="alert alert-danger settings-error-summary mb-3">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                ${errors.map(error => `<li>${error}</li>`).join('')}
            </ul>
        </div>
    `;

            $('#employeeSettingsModal .modal-body').prepend(summaryHtml);
        }
    </script>
@endpush
