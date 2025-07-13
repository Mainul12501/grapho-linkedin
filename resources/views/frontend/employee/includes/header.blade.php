<section class="main-header">
    <div class="container">
        <header class="py-2 px-3 d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex">
                <img src="{{ asset('/') }}frontend/employee/images/header images/Compnay logo.png" alt="Logo" class="logo" />
                <div class="search-bar flex-grow-1 mx-2 position-relative">
                    <input type="text" class="form-control ps-5" placeholder="Search jobs" />
                    <img src="{{ asset('/') }}frontend/employee/images/header images/searchIcon.png" alt="Search Icon"
                         class="position-absolute top-50 start-0 translate-middle-y ps-3" />
                </div>
            </div>
            <div>
                <div class="main-menu d-none d-md-flex gap-3 align-items-center">
                    <a href="{{ route('employee.home') }}" class="menu-item">
                        <div class="d-flex align-items-center {{ request()->is('employee/home') ? 'active' : '' }}">
                            <img src="{{ asset('/') }}frontend/employee/images/header images/home.png" alt="" class="me-2" />
                            Home
                        </div>
                    </a>
                    <a href="{{ route('employee.show-jobs') }}" class="menu-item">
                        <div class="d-flex align-items-center {{ request()->is('employee/show-jobs') ? 'active' : '' }}">
                            <img src="{{ asset('/') }}frontend/employee/images/header images/jobs.png" alt="" class="me-2" />
                            Jobs
                        </div>
                    </a>
                    <a href="" class="menu-item">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('/') }}frontend/employee/images/header images/inbox.png" alt="" class="me-2" />
                            Inbox
                        </div>
                    </a>
                    <a href="{{ route('employee.my-notifications') }}" class="menu-item">
                        <div class="d-flex align-items-center {{ request()->is('employee/my-notifications') ? 'active' : '' }}">
                            <img src="{{ asset('/') }}frontend/employee/images/header images/notifications.png" alt="" class="me-2" />
                            Notifications
                        </div>
                    </a>

                    <!-- Profile and Dropdown Container -->
                    <div class="profile-container">
                        <a href="#" class="menu-item userProfile" onclick="toggleDropdown()">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('/') }}frontend/employee/images/header images/pp.png" alt="" class="me-2" />
                                {{ auth()->user()->name ?? 'User' }}
                                <img src="{{ asset('/') }}frontend/employee/images/header images/down arrow.png" alt="" class="ms-2" />
                            </div>
                        </a>

                        <!-- Dropdown Menu -->
                        <div id="userDropdown" class="user-dropdown">
                            <a href="{{ route('employee.my-profile') }}"><img src="{{ asset('/') }}frontend/employee/images/header images/Myprofile.png" alt="" class="dropdown-icon" /> My profile</a>
                            <a href="{{ route('employee.my-saved-jobs') }}"><img src="{{ asset('/') }}frontend/employee/images/header images/Saved jobs.png" alt="" class="dropdown-icon" /> Saved jobs</a>
                            <a href="{{ route('employee.my-applications') }}"><img src="{{ asset('/') }}frontend/employee/images/header images/Myapplications.png" alt="" class="dropdown-icon" /> My applications</a>
                            <a href="{{ route('employee.my-profile-viewers') }}"><img src="{{ asset('/') }}frontend/employee/images/header images/Profilerviewers.png" alt="" class="dropdown-icon" /> Profiler viewers</a>
                            <a href="{{ route('employee.my-subscriptions') }}"><img src="{{ asset('/') }}frontend/employee/images/header images/Subscription.png" alt="" class="dropdown-icon" /> Subscription</a>
                            <a href="{{ route('employee.settings') }}"><img src="{{ asset('/') }}frontend/employee/images/header images/Settings.png" alt="" class="dropdown-icon" /> Settings</a>
                            <a href="" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();"><img src="{{ asset('/') }}frontend/employee/images/header images/Myprofile.png" alt="" class="dropdown-icon" /> Logout</a>
                            <form action="{{ route('logout') }}" method="post" id="logoutForm">
                                @csrf
                            </form>
                        </div>
                    </div>



                </div>
                <div class="d-md-none">
                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/notificationBell.png" alt="Notification" />
                </div>
            </div>
        </header>
    </div>
</section>
