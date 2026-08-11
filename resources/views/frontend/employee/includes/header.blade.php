<section class="main-header">
    <div class="container">
        <header class="py-2 px-3 d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex">
{{--                <a href="{{ route('/') }}"><img src="{{ asset($siteSetting->logo ?? '/frontend/likewise.png') }}" alt="Logo" class="logo desktop-logo" style="height: 40px; min-width: 115px" /></a>--}}
                <a href="{{ route('/') }}"><img src="{{ asset('/frontend/likewise.png') }}" alt="Logo" class="logo desktop-logo" style="height: 30px; min-width: 115px" /></a>
                <div class="search-bar flex-grow-1 mx-2 position-relative">
                    <form action="{{ route('employee.show-jobs') }}" method="get" id="headerSearchForm">
                        <input type="text" class="form-control ps-5" placeholder="{{ trans('employer.search_jobs') }}" name="search_text" />
                        <img src="{{ asset('/') }}frontend/employee/images/header images/searchIcon.png" onclick="document.getElementById('headerSearchForm').submit()" alt="Search Icon"
                             class="position-absolute top-50 start-0 translate-middle-y ps-3" />
                        <input type="submit" style="display: none">
                    </form>

                </div>
            </div>
            <div>
                <div class="main-menu d-none d-md-flex gap-3 align-items-center">
                    <a href="{{ route('employee.home') }}" class="menu-item">
                        <div class="d-flex align-items-center {{ request()->is('employee/home') ? 'active' : '' }}">
                            <img src="{{ asset('/') }}frontend/employee/images/header images/home.png" alt="" class="me-2" />
                            {{ trans('employee.home') }}
                        </div>
                    </a>
                    <a href="{{ route('employee.show-jobs') }}" class="menu-item">
                        <div class="d-flex align-items-center {{ request()->is('employee/show-jobs') ? 'active' : '' }}">
                            <img src="{{ asset('/') }}frontend/employee/images/header images/jobs.png" alt="" class="me-2" />
                            {{ trans('employee.jobs') }}
                        </div>
                    </a>
                    <a href="{{ url('/chat') }}" class="menu-item" target="_blank">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('/') }}frontend/employee/images/header images/inbox.png" alt="" class="me-2" />
                            {{ trans('employee.inbox') }}
                        </div>
                    </a>
                    <a href="{{ route('employee.my-notifications') }}" class="menu-item">
                        <div class="d-flex align-items-center {{ request()->is('employee/my-notifications') ? 'active' : '' }}">
                            <img src="{{ asset('/') }}frontend/employee/images/header images/notifications.png" alt="" class="me-2" />
                            {{ trans('employee.notifications') }}
                        </div>
                    </a>

                    <!-- Profile and Dropdown Container -->
                    <div class="profile-container">
                        <a href="#" class="menu-item userProfile" onclick="toggleDropdown()">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset($loggedUser->profile_image ?? '/frontend/user-vector-img.jpg') }}" alt="" class="me-2" style="height: 35px; border-radius: 50%" />
                                {{ auth()->user()->name ?? trans('common.user') }}
                                <img src="{{ asset('/') }}frontend/employee/images/header images/down arrow.png" alt="" class="ms-2" />
                            </div>
                        </a>

                        <!-- Dropdown Menu -->
                        <div id="userDropdown" class="user-dropdown">
                            <a href="{{ route('employee.my-profile') }}"><img src="{{ asset('/') }}frontend/employee/images/header images/Myprofile.png" alt="" class="dropdown-icon" /> {{ trans('employee.my_profile') }}</a>
                            <a href="{{ route('employee.my-saved-jobs') }}"><img src="{{ asset('/') }}frontend/employee/images/header images/Saved jobs.png" alt="" class="dropdown-icon" /> {{ trans('employee.my_saved_jobs') }}</a>
                            <a href="{{ route('employee.my-applications') }}"><img src="{{ asset('/') }}frontend/employee/images/header images/Myapplications.png" alt="" class="dropdown-icon" /> {{ trans('employee.my_applications') }}</a>
                            <a href="{{ route('employee.my-profile-viewers') }}"><img src="{{ asset('/') }}frontend/employee/images/header images/Profilerviewers.png" alt="" class="dropdown-icon" /> {{ trans('employee.profiler_viewers') }}</a>
                            @if(isset($siteSetting) && $siteSetting->subscription_system_status ==1) <a href="{{ route('employee.my-subscriptions') }}"><img src="{{ asset('/') }}frontend/employee/images/header images/Subscription.png" alt="" class="dropdown-icon" /> {{ trans('employee.subscription') }}</a> @endif
                            <a href="{{ route('employee.settings') }}"><img src="{{ asset('/') }}frontend/employee/images/header images/Settings.png" alt="" class="dropdown-icon" /> {{ trans('employee.settings') }}</a>
                            <a href="" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();"><img src="{{ asset('/') }}frontend/employee/images/header images/Myprofile.png" alt="" class="dropdown-icon" /> {{ trans('employee.log_out') }}</a>
                            <form action="{{ route('logout') }}" method="post" id="logoutForm">
                                @csrf
                            </form>
                        </div>
                    </div>



                </div>
{{--                <div class="d-md-none">--}}
{{--                    <a href="{{ route('employee.my-notifications') }}"><img src="{{ asset('/') }}frontend/employee/images/contentImages/notificationBell.png" alt="Notification" /></a>--}}
{{--                </div>--}}
            </div>
        </header>
    </div>
</section>

