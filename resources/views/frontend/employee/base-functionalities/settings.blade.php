@extends('frontend.employee.master')

@section('title', 'Settings')

@section('body')


    <section class="bg-white forSmall smallTop">
        <a href=""><img src="{{ asset('/') }}frontend/employee/images/profile/leftArrowDark.png" alt="" class="me-2"> {{ trans('employee.settings') }}</a>
    </section>

    <!-- Main Content -->
    <div class="container container-main mt-md-5 mt-2 ">
        <!-- Left Side Menu -->
        @include('frontend.employee.jobs.left-menu')

        <!-- Right Scrollable Jobs -->
        <section class="w-100 profileOptionRight">
            <h1 class="forLarge">{{ trans('employee.settings') }}</h1>

            <div class="right-panel w-100 settings py-4 rounded">

{{--                <div class="settings-row d-flex justify-content-between p-4 border-bottom">--}}
{{--                    <div class="icon">--}}
{{--                        <img src="{{ asset('/') }}frontend/employee/images/profile/languageSElect.png" alt="Language Icon" class="me-2"/>--}}
{{--                        <span>Language</span>--}}
{{--                    </div>--}}
{{--                    <div class="option">--}}
{{--                        <select>--}}
{{--                            <option>English</option>--}}
{{--                            <option>Bangla</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="settings-row d-flex justify-content-between p-4 border-bottom">
                    <div class="icon">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/Change password.png" alt="Password Icon" class="me-2"/>
                        <span>{{ trans('employee.change_password') }}</span>
                    </div>
                    <div class="option">
                        <span>********</span>
                        <span data-bs-toggle="modal" data-bs-target="#settingModal" style="cursor: pointer">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/arrowRightLight.png" alt="Right Arrow"  />
                        </span>
                    </div>
                </div>

                <div class="settings-row d-flex justify-content-between p-4 border-bottom">
                    <div class="icon">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/Change Email.png" alt="Email Icon" class="me-2"/>
                        <span>{{ trans('employee.change_email') }}</span>
                    </div>
                    <div class="option">
                        <span>{{ auth()->user()->email ?? 'demo@email.com' }}</span>
                        <span data-bs-toggle="modal" data-bs-target="#emailModal" style="cursor: pointer">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/arrowRightLight.png" alt="Right Arrow" />
                        </span>
                    </div>
                </div>

                <div class="settings-row d-flex justify-content-between p-4">
                    <div class="icon">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/Log out.png" alt="Logout Icon" class="me-2"/>
                        <span>{{ trans('employee.log_out') }}</span>
                    </div>
                    <div class="option">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/arrowRightLight.png" onclick="document.getElementById('logoutForm').submit()" alt="Right Arrow" />
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="settingModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ trans('employee.change_password') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <form action="{{ route('employee.update-profile', auth()->id()) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="row mt-2">
                            <label for="prevPass" class="col-md-3">{{ trans('employee.previous_password') }}</label>
                            <div class="col-md-9">
                                <input type="password" id="prevPass" name="prev_password" class="form-control" placeholder="{{ trans('auth.type_here') }}" />
                            </div>
                        </div>
                        <div class="row mt-2">
                            <label for="newPass" class="col-md-3">{{ trans('auth.new_password') }}</label>
                            <div class="col-md-9">
                                <input type="password" name="new_password" id="newPass" class="form-control" placeholder="{{ trans('auth.type_here') }}" />
                            </div>
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
    <!-- Email Modal -->
    <div class="modal fade" id="emailModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ trans('employee.change_email') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <form action="{{ route('employee.update-profile', auth()->id()) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="row mt-2">
                            <label for="email" class="col-md-3">{{ trans('common.email') }}</label>
                            <div class="col-md-9">
                                <input type="email" id="email" name="email" class="form-control" value="{{ auth()->user()->email ?? '' }}" placeholder="{{ trans('auth.type_here') }}" />
                            </div>
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
@endsection

