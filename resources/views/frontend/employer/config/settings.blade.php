@extends('frontend.employer.master')

@section('title', 'Settings')

@section('body')
    <div class="employeeSettings">
        <div class="container settings">
            <!-- Topbar -->


            <div class="row mt-4">
                <!-- Left menu -->
                @include('frontend.employer.config.side-menu')

                <!-- Right main content -->
                <section class="col-md-9 col-12 settingsRightContent ">
                    <h2 class="mb-4 settings-menu d-none d-md-block">{{ trans('employer.my_account') }}</h2>
                    <div class="card settings-content">
                        <form>

                            <!-- Full Name -->
                            <div class="mb-3 d-flex justify-content-between align-items-center border-bottom p-3">
                                <div class="d-flex align-items-center" style="gap:8px;">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/Settings-Full Name.png" alt="user-icon" style="height: 30px">
                                    {{ trans('employer.full_name') }}
                                </div>
                                <div class="border px-5 py-2 rounded" data-bs-toggle="modal" data-bs-target="#employeeSettingsModal" style="cursor: pointer">
                                    <span>{{ $loggedUser->name ?? 'User Name' }}</span>
                                </div>
                            </div>

                            <!-- Change Password -->
                            <div class="mb-3 d-flex justify-content-between align-items-center p-3 border-bottom">
                                <div class="d-flex align-items-center" style="gap:8px;">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/Settings-Change password.png" alt="">
                                    {{ trans('employee.change_password') }}
                                </div>
                                <div class="d-flex align-items-center text-end" style="gap:8px; cursor:pointer;">
                                    <span>********</span>
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/arrow-right 1.png" alt="" data-bs-toggle="modal" data-bs-target="#employeePasswordChangeModal">
                                </div>
                            </div>

                            <!-- Change Email -->
                            <div class="mb-3 d-flex justify-content-between align-items-center p-3 border-bottom">
                                <div class="d-flex align-items-center" style="gap:8px;">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/Settings-Change Email.png" alt="">
                                    {{ trans('employee.change_email') }}
                                </div>
                                <div class="d-flex align-items-center text-end" style="gap:8px; cursor:pointer;">
                                    <span class="text-muted">md.pranto@gmail.com</span>
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/arrow-right 1.png" alt="" data-bs-toggle="modal" data-bs-target="#employeeSettingsModal">
                                </div>
                            </div>


                            <!-- Language -->
                            <div class="mb-3 d-flex justify-content-between align-items-center p-3 border-bottom">
                                <div class="d-flex align-items-center" style="gap:8px;">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/settings-Language.png" alt="">
                                    {{ trans('employee.language') }}
                                </div>
                                <div class="d-flex align-items-center" style="gap:8px;">
                                    <div class="dropdown">
                                        <button class="btn btn-light dropdown-toggle py-1 px-3" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight: normal; font-size: 1rem;">
                                            @if(session('locale') == 'bn')
                                                {{ trans('employee.bangla') }}
                                            @else
                                                {{ trans('employee.english') }}
                                            @endif
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                                            <li><a class="dropdown-item {{ session('locale') == 'en' ? 'active' : '' }}" href="{{ route('change-local-language', ['local' => 'English']) }}">{{ trans('employee.english') }}</a></li>
                                            <li><a class="dropdown-item {{ session('locale') == 'bn' ? 'active' : '' }}" href="{{ route('change-local-language', ['local' => 'Bangla']) }}">{{ trans('employee.bangla') }}</a></li>
                                        </ul>
                                    </div>
{{--                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/arrow-right 1.png" alt="">--}}
                                </div>
                            </div>


                            <!-- Log out -->
                            <div class="d-flex justify-content-between align-items-center p-3">
                                <div class="d-flex align-items-center" style="gap:8px;">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/settings-Log out.png" alt="">
                                    {{ trans('employee.log_out') }}
                                </div>
                                <a href="#" class="d-flex align-items-center text-decoration-none" style="gap:8px; cursor:pointer;" onclick="event.preventDefault(); document.getElementById('pageLogoutForm').submit();">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/arrow-right 1.png" alt="">
                                </a>
                                <form action="{{ route('logout') }}" method="post" id="pageLogoutForm">
                                    @csrf
                                </form>
                            </div>

                        </form>
                    </div>
                </section>



            </div>
        </div>
    </div>

@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="employeeSettingsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ trans('employer.edit_settings') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('employer.update-settings') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div>
                            <label for="">{{ trans('employer.full_name') }}</label>
                            <input type="text" class="form-control" name="name" value="{{ $loggedUser->name ?? '' }}" placeholder="{{ trans('employer.enter_your_full_name') }}" >
                        </div>
                        <div class="mt-3">
                            <label for="">{{ trans('common.email') }}</label>
                            <input type="text" class="form-control" name="email" value="{{ $loggedUser->email ?? '' }}" placeholder="{{ trans('employer.enter_your_email') }}" >
                        </div>
                        <div class="mt-3">
                            <label for="">{{ trans('employer.mobile') }}</label>
                            <input type="text" class="form-control" name="mobile" value="{{ $loggedUser->mobile ?? '' }}" placeholder="{{ trans('employer.enter_your_email') }}" >
                        </div>
                        <div class="mt-3">
                            <label for="">{{ trans('employee.profile_image') }}</label>
                            <input type="file" class="form-control" name="profile_image" placeholder="{{ trans('employer.enter_profile_image') }}" accept="image/*" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('common.save_changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="employeePasswordChangeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ trans('employer.change_password_label') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('auth.user-password-update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div>
                            <label for="">{{ trans('employee.previous_password') }}</label>
                            <input type="password" class="form-control" name="old_password" required placeholder="{{ trans('employer.enter_old_password') }}" >
                        </div>
                        <div class="mt-3">
                            <label for="">{{ trans('employer.new_password') }}</label>
                            <input type="text" class="form-control" name="password" required placeholder="{{ trans('employer.enter_new_password') }}" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('employee.change_password') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
{{--    profile edit validation--}}
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
                    // Additional validation for valid BD operator prefixes (optional but recommended)
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

                // 3. Email Validation (optional but good practice)
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

                // 4. Profile Image Validation (optional - check file type and size)
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

                // ✅ All validations passed - submit the form
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
