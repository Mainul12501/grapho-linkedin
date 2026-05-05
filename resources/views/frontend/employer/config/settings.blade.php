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
    <link rel="stylesheet" href="{{ asset('frontend/page-custom-codes/employer/settings/style.css') }}">

@endpush

@push('script')
    <script src="{{ asset('frontend/page-custom-codes/employer/settings/script.js') }}"></script>
    {{-- Profile edit validation --}}

@endpush
