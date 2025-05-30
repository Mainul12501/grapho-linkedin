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
                    <h2 class="mb-4 settings-menu d-none d-md-block">My account</h2>
                    <div class="card settings-content">
                        <form>

                            <!-- Full Name -->
                            <div class="mb-3 d-flex justify-content-between align-items-center border-bottom p-3">
                                <div class="d-flex align-items-center" style="gap:8px;">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/Settings-Full Name.png" alt="">
                                    Full Name
                                </div>
                                <div class="border px-5 py-2 rounded" >
                                    <span>Md. Pranto</span>
                                </div>
                            </div>

                            <!-- Change Password -->
                            <div class="mb-3 d-flex justify-content-between align-items-center p-3 border-bottom">
                                <div class="d-flex align-items-center" style="gap:8px;">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/Settings-Change password.png" alt="">
                                    Change password
                                </div>
                                <div class="d-flex align-items-center text-end" style="gap:8px; cursor:pointer;">
                                    <span>********</span>
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/arrow-right 1.png" alt="">
                                </div>
                            </div>

                            <!-- Change Email -->
                            <div class="mb-3 d-flex justify-content-between align-items-center p-3 border-bottom">
                                <div class="d-flex align-items-center" style="gap:8px;">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/Settings-Change Email.png" alt="">
                                    Change Email
                                </div>
                                <div class="d-flex align-items-center text-end" style="gap:8px; cursor:pointer;">
                                    <span class="text-muted">md.pranto@gmail.com</span>
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/arrow-right 1.png" alt="">
                                </div>
                            </div>


                            <!-- Language -->
                            <div class="mb-3 d-flex justify-content-between align-items-center p-3 border-bottom">
                                <div class="d-flex align-items-center" style="gap:8px;">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/settings-Language.png" alt="">
                                    Language
                                </div>
                                <div class="d-flex align-items-center" style="gap:8px;">
                                    <div class="dropdown">
                                        <button class="btn btn-light dropdown-toggle py-1 px-3" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight: normal; font-size: 1rem;">
                                            English
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                                            <li><a class="dropdown-item" href="#">English</a></li>
                                            <li><a class="dropdown-item" href="#">Spanish</a></li>
                                            <li><a class="dropdown-item" href="#">French</a></li>
                                            <!-- Add more languages here -->
                                        </ul>
                                    </div>
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/arrow-right 1.png" alt="">
                                </div>
                            </div>


                            <!-- Log out -->
                            <div class="d-flex justify-content-between align-items-center p-3">
                                <div class="d-flex align-items-center" style="gap:8px;">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/settings-Log out.png" alt="">
                                    Log out
                                </div>
                                <a href="#" class="d-flex align-items-center text-decoration-none" style="gap:8px; cursor:pointer;">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/arrow-right 1.png" alt="">
                                </a>
                            </div>

                        </form>
                    </div>
                </section>



            </div>
        </div>
    </div>

@endsection
