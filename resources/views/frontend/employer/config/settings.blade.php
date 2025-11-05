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
