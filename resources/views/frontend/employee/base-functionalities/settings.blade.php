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
                        <img src="{{ asset('/') }}frontend/employee/images/profile/arrowRightLight.png" alt="Right Arrow" />
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

