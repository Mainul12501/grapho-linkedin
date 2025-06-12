@extends('frontend.employee.master')

@section('title', 'Settings')

@section('body')


    <section class="bg-white forSmall smallTop">
        <a href=""><img src="{{ asset('/') }}frontend/employee/images/profile/leftArrowDark.png" alt="" class="me-2"> Settings</a>
    </section>

    <!-- Main Content -->
    <div class="container container-main mt-md-5 mt-2 ">
        <!-- Left Side Menu -->
        @include('frontend.employee.jobs.left-menu')

        <!-- Right Scrollable Jobs -->
        <section class="w-100 profileOptionRight">
            <h1 class="forLarge">Settings</h1>

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
                        <span>Change password</span>
                    </div>
                    <div class="option">
                        <span>********</span>
                        <span data-bs-toggle="modal" data-bs-target="settingModal" style="cursor: pointer">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/arrowRightLight.png" alt="Right Arrow"  />
                        </span>
                    </div>
                </div>

                <div class="settings-row d-flex justify-content-between p-4 border-bottom">
                    <div class="icon">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/Change Email.png" alt="Email Icon" class="me-2"/>
                        <span>Change Email</span>
                    </div>
                    <div class="option">
                        <span>md.pranto@gmail.com</span>
                        <img src="{{ asset('/') }}frontend/employee/images/profile/arrowRightLight.png" alt="Right Arrow" />
                    </div>
                </div>

                <div class="settings-row d-flex justify-content-between p-4">
                    <div class="icon">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/Log out.png" alt="Logout Icon" class="me-2"/>
                        <span>Log out</span>
                    </div>
                    <div class="option">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/arrowRightLight.png" alt="Right Arrow" />
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="settingModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile Setting</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label for="email" class="col-md-3">Email</label>
                            <div class="col-md-9">
                                <input type="email" id="email" name="email" class="" />
                            </div>
                        </div>
                        <div class="row mt-2">
                            <label for="prevPass" class="col-md-3">Previous Password</label>
                            <div class="col-md-9">
                                <input type="password" id="prevPass" name="prev_pass" class="" />
                            </div>
                        </div>
                        <div class="row mt-2">
                            <label for="newPass" class="col-md-3">New Password</label>
                            <div class="col-md-9">
                                <input type="password" name="new_pass" id="newPass" class="" />
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4 mx-auto">
                                <img src="" alt="" class="" style="height: 80px" >
                            </div>
                        </div>
                        <div class="row mt-2">
                            <label for="newPass" class="col-md-3">Profile Image</label>
                            <input type="password" name="new_pass" class="col-md-9" id="newPass" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
