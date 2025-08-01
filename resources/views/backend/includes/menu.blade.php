<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="{{ route('dashboard') }}">
                <img src="{{ asset('/') }}frontend/logo/logo-md.svg" class="header-brand-img desktop-logo" alt="logo">
                <img src="{{ asset('/') }}frontend/logo/logo-md.svg" class="header-brand-img toggle-logo" alt="logo">
                <img src="{{ asset('/') }}frontend/logo/logo-md.svg" class="header-brand-img light-logo" alt="logo">
                <img src="{{ asset('/') }}frontend/logo/logo-md.svg" class="header-brand-img light-logo1" alt="logo">
            </a><!-- LOGO -->
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg"
                                                                  fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg>
            </div>
            <ul class="side-menu">
                <li>
                    <h3>Menu</h3>
                </li>

                <li class="slide">
                    <a class="side-menu__item has-link {{ request()->is('dashboard') ? 'active' : '' }}" data-bs-toggle="slide" href="{{ route('dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M19.9794922,7.9521484l-6-5.2666016c-1.1339111-0.9902344-2.8250732-0.9902344-3.9589844,0l-6,5.2666016C3.3717041,8.5219116,2.9998169,9.3435669,3,10.2069702V19c0.0018311,1.6561279,1.3438721,2.9981689,3,3h2.5h7c0.0001831,0,0.0003662,0,0.0006104,0H18c1.6561279-0.0018311,2.9981689-1.3438721,3-3v-8.7930298C21.0001831,9.3435669,20.6282959,8.5219116,19.9794922,7.9521484z M15,21H9v-6c0.0014038-1.1040039,0.8959961-1.9985962,2-2h2c1.1040039,0.0014038,1.9985962,0.8959961,2,2V21z M20,19c-0.0014038,1.1040039-0.8959961,1.9985962-2,2h-2v-6c-0.0018311-1.6561279-1.3438721-2.9981689-3-3h-2c-1.6561279,0.0018311-2.9981689,1.3438721-3,3v6H6c-1.1040039-0.0014038-1.9985962-0.8959961-2-2v-8.7930298C3.9997559,9.6313477,4.2478027,9.0836182,4.6806641,8.7041016l6-5.2666016C11.0455933,3.1174927,11.5146484,2.9414673,12,2.9423828c0.4853516-0.0009155,0.9544067,0.1751099,1.3193359,0.4951172l6,5.2665405C19.7521973,9.0835571,20.0002441,9.6313477,20,10.2069702V19z"/></svg>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <li>
                    <h3>Management Modules</h3>
                </li>
{{--                @can('role-management')--}}
                    <li class="slide {{ request()->is('permission-categories*') || request()->is('permissions*')|| request()->is('roles*')|| request()->is('users') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item {{ request()->is('permission-categories*') || request()->is('permissions*')|| request()->is('roles*')|| request()->is('users') ? 'active is-expanded' : '' }}" data-bs-toggle="slide" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M21.5,21h-19C2.223877,21,2,21.223877,2,21.5S2.223877,22,2.5,22h19c0.276123,0,0.5-0.223877,0.5-0.5S21.776123,21,21.5,21z M4.5,18.0888672h5c0.1326294,0,0.2597656-0.0527344,0.3534546-0.1465454l10-10c0.000061,0,0.0001221-0.000061,0.0001831-0.0001221c0.1951294-0.1952515,0.1950684-0.5117188-0.0001831-0.7068481l-5-5c0-0.000061-0.000061-0.0001221-0.0001221-0.0001221c-0.1951904-0.1951904-0.5117188-0.1951294-0.7068481,0.0001221l-10,10C4.0526733,12.3291016,4,12.4562378,4,12.5888672v5c0,0.0001831,0,0.0003662,0,0.0005493C4.0001831,17.8654175,4.223999,18.0890503,4.5,18.0888672z M14.5,3.2958984l4.2930298,4.2929688l-2.121582,2.121582l-4.2926025-4.293396L14.5,3.2958984z M5,12.7958984l6.671814-6.671814l4.2926025,4.293396l-6.6713867,6.6713867H5V12.7958984z"/></svg>
                            <span class="side-menu__label">Role Management</span>
                            <i class="angle fa fa-angle-right"></i>
                        </a>
                        <ul class="slide-menu">
                            <li class="side-menu-label1"><a href="javascript:void(0)">Role</a></li>
                            @can('manage-permission-category')
                            <li><a href="{{ route('permission-categories.index') }}" class="slide-item {{ request()->is('permission-categories') ||request()->is('permission-categories*') ? 'active' : '' }}">Permission Category</a></li>
                            @endcan
                            @can('manage-permission')
                            <li><a href="{{ route('permissions.index') }}" class="slide-item {{ request()->is('permissions') || request()->is('permissions*') ? 'active' : '' }}">Permission</a></li>
                            @endcan
                            @can('manage-role')
                            <li><a href="{{ route('roles.index') }}" class="slide-item {{ request()->is('roles') || request()->is('roles*') ? 'active' : '' }}">Role</a></li>
                            @endcan
                            {{-- @can('manage-user')
                            <li><a href="{{ route('users.index') }}" class="slide-item {{ request()->is('users') || request()->is('users*') ? 'active' : '' }}">Users</a></li>
                            @endcan --}}

                        </ul>
                    </li>
{{--                @endcan--}}
                <li class="slide {{ request()->is('users*') /*|| request()->is('permissions*')*/ ? 'is-expanded' : '' }}">
                    <a class="side-menu__item {{ request()->is('users*') /*|| request()->is('permissions*')*/ ? 'active is-expanded' : '' }}" data-bs-toggle="slide" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M21.5,21h-19C2.223877,21,2,21.223877,2,21.5S2.223877,22,2.5,22h19c0.276123,0,0.5-0.223877,0.5-0.5S21.776123,21,21.5,21z M4.5,18.0888672h5c0.1326294,0,0.2597656-0.0527344,0.3534546-0.1465454l10-10c0.000061,0,0.0001221-0.000061,0.0001831-0.0001221c0.1951294-0.1952515,0.1950684-0.5117188-0.0001831-0.7068481l-5-5c0-0.000061-0.000061-0.0001221-0.0001221-0.0001221c-0.1951904-0.1951904-0.5117188-0.1951294-0.7068481,0.0001221l-10,10C4.0526733,12.3291016,4,12.4562378,4,12.5888672v5c0,0.0001831,0,0.0003662,0,0.0005493C4.0001831,17.8654175,4.223999,18.0890503,4.5,18.0888672z M14.5,3.2958984l4.2930298,4.2929688l-2.121582,2.121582l-4.2926025-4.293396L14.5,3.2958984z M5,12.7958984l6.671814-6.671814l4.2926025,4.293396l-6.6713867,6.6713867H5V12.7958984z"/></svg>
                        <span class="side-menu__label">User Management</span>
                        <i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1"><a href="javascript:void(0)">Role</a></li>
{{--                        @can('manage-permission-category')--}}
                            <li><a href="{{ route('pending-users') }}" class="slide-item {{ request()->is('pending-users') /*||request()->is('permission-categories*')*/ ? 'active' : '' }}">Pending Users</a></li>
{{--                        @endcan--}}
{{--                        @can('manage-permission')--}}
                            <li><a href="{{ route('users.index', ['user_type' => 'admin']) }}" class="slide-item {{ request()->is('users') || request()->is('permissions*') ? 'active' : '' }}">Admins</a></li>
{{--                        @endcan--}}
{{--                        @can('manage-role')--}}
                            <li><a href="{{ route('users.index', ['user_type' => 'employer']) }}" class="slide-item {{ request()->is('users') || request()->is('roles*') ? 'active' : '' }}">Employers</a></li>
{{--                        @endcan--}}
{{--                        @can('manage-role')--}}
                            <li><a href="{{ route('users.index', ['user_type' => 'employee']) }}" class="slide-item {{ request()->is('users') || request()->is('roles*') ? 'active' : '' }}">Employees</a></li>
{{--                        @endcan--}}
                        {{-- @can('manage-user')
                        <li><a href="{{ route('users.index') }}" class="slide-item {{ request()->is('users') || request()->is('users*') ? 'active' : '' }}">Users</a></li>
                        @endcan --}}

                    </ul>
                </li>
                {{--                @can('role-management')--}}
                <li class="slide {{ request()->is('education-degree-names*') || request()->is('educational-subject-names*') || request()->is('university-names*') || request()->is('field-of-studies*') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item {{ request()->is('permission-categories*') || request()->is('permissions*')|| request()->is('roles*')|| request()->is('users') ? 'active is-expanded' : '' }}" data-bs-toggle="slide" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M21.5,21h-19C2.223877,21,2,21.223877,2,21.5S2.223877,22,2.5,22h19c0.276123,0,0.5-0.223877,0.5-0.5S21.776123,21,21.5,21z M4.5,18.0888672h5c0.1326294,0,0.2597656-0.0527344,0.3534546-0.1465454l10-10c0.000061,0,0.0001221-0.000061,0.0001831-0.0001221c0.1951294-0.1952515,0.1950684-0.5117188-0.0001831-0.7068481l-5-5c0-0.000061-0.000061-0.0001221-0.0001221-0.0001221c-0.1951904-0.1951904-0.5117188-0.1951294-0.7068481,0.0001221l-10,10C4.0526733,12.3291016,4,12.4562378,4,12.5888672v5c0,0.0001831,0,0.0003662,0,0.0005493C4.0001831,17.8654175,4.223999,18.0890503,4.5,18.0888672z M14.5,3.2958984l4.2930298,4.2929688l-2.121582,2.121582l-4.2926025-4.293396L14.5,3.2958984z M5,12.7958984l6.671814-6.671814l4.2926025,4.293396l-6.6713867,6.6713867H5V12.7958984z"/></svg>
                        <span class="side-menu__label">Employee End Management</span>
                        <i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1"><a href="javascript:void(0)">Employee</a></li>
{{--                        @can('manage-permission-category')--}}
                            <li><a href="{{ route('education-degree-names.index') }}" class="slide-item {{ request()->is('education-degree-names') ||request()->is('education-degree-names*') ? 'active' : '' }}">Education Degree Name</a></li>
{{--                        @endcan--}}
{{--                        @can('manage-permission-category')--}}
                            <li><a href="{{ route('field-of-studies.index') }}" class="slide-item {{ request()->is('field-of-studies') ||request()->is('field-of-studies*') ? 'active' : '' }}">Field of Study</a></li>
{{--                        @endcan--}}
{{--                        @can('manage-permission-category')--}}
                            <li><a href="{{ route('university-names.index') }}" class="slide-item {{ request()->is('university-names') ||request()->is('university-names*') ? 'active' : '' }}">University Names</a></li>
{{--                        @endcan--}}
{{--                        @can('manage-permission-category')--}}
                            <li><a href="{{ route('educational-subject-names.index') }}" class="slide-item {{ request()->is('educational-subject-names') || request()->is('educational-subject-names*') ? 'active' : '' }}">Educational Subject</a></li>
{{--                        @endcan--}}
                    </ul>
                </li>
                {{--                @endcan--}}

                {{--                @can('role-management')--}}
                <li class="slide {{ request()->is('skills-categories*') || request()->is('employer-company-categories*') || request()->is('job-location-types*') || request()->is('job-types*') || request()->is('industries*') || request()->is('skills*')  ? 'is-expanded' : '' }}">
                    <a class="side-menu__item {{ request()->is('permission-categories*') || request()->is('permissions*')|| request()->is('roles*')|| request()->is('users') ? 'active is-expanded' : '' }}" data-bs-toggle="slide" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M21.5,21h-19C2.223877,21,2,21.223877,2,21.5S2.223877,22,2.5,22h19c0.276123,0,0.5-0.223877,0.5-0.5S21.776123,21,21.5,21z M4.5,18.0888672h5c0.1326294,0,0.2597656-0.0527344,0.3534546-0.1465454l10-10c0.000061,0,0.0001221-0.000061,0.0001831-0.0001221c0.1951294-0.1952515,0.1950684-0.5117188-0.0001831-0.7068481l-5-5c0-0.000061-0.000061-0.0001221-0.0001221-0.0001221c-0.1951904-0.1951904-0.5117188-0.1951294-0.7068481,0.0001221l-10,10C4.0526733,12.3291016,4,12.4562378,4,12.5888672v5c0,0.0001831,0,0.0003662,0,0.0005493C4.0001831,17.8654175,4.223999,18.0890503,4.5,18.0888672z M14.5,3.2958984l4.2930298,4.2929688l-2.121582,2.121582l-4.2926025-4.293396L14.5,3.2958984z M5,12.7958984l6.671814-6.671814l4.2926025,4.293396l-6.6713867,6.6713867H5V12.7958984z"/></svg>
                        <span class="side-menu__label">Employer End Management</span>
                        <i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1"><a href="javascript:void(0)">Employee</a></li>
                        {{--                        @can('manage-permission-category')--}}
                        <li><a href="{{ route('skills-categories.index') }}" class="slide-item {{ request()->is('skills-categories') ||request()->is('skills-categories*') ? 'active' : '' }}">Skills Category</a></li>
                        {{--                        @endcan--}}
                        {{--                        @can('manage-permission-category')--}}
                        <li><a href="{{ route('skills.index') }}" class="slide-item {{ request()->is('skills') ||request()->is('skills*') ? 'active' : '' }}">Skills</a></li>
                        {{--                        @endcan--}}
                        {{--                        @can('manage-permission-category')--}}
                        <li><a href="{{ route('industries.index') }}" class="slide-item {{ request()->is('industries') ||request()->is('industries*') ? 'active' : '' }}">Industries</a></li>
                        {{--                        @endcan--}}
                        {{--                        @can('manage-permission-category')--}}
                        <li><a href="{{ route('job-types.index') }}" class="slide-item {{ request()->is('job-types') ||request()->is('job-types*') ? 'active' : '' }}">Job Types</a></li>
                        {{--                        @endcan--}}
                        {{--                        @can('manage-permission-category')--}}
                        <li><a href="{{ route('job-location-types.index') }}" class="slide-item {{ request()->is('job-location-types') ||request()->is('job-location-types*') ? 'active' : '' }}">Job Location Types</a></li>
                        {{--                        @endcan--}}
                        {{--                        @can('manage-permission-category')--}}
                        <li><a href="{{ route('employer-company-categories.index') }}" class="slide-item {{ request()->is('employer-company-categories') ||request()->is('employer-company-categories*') ? 'active' : '' }}">Employer Company Categories</a></li>
                        {{--                        @endcan--}}
                    </ul>
                </li>
                {{--                @endcan--}}

                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('subscriptions.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M21.6,2.7c0-0.2-0.2-0.3-0.4-0.4c-3.8-1-7.9,0.3-10.4,3.3L9.5,7.1L6.8,6.4C5.7,6,4.6,6.5,4.1,7.5L2,11.2c0,0,0,0.1-0.1,0.1c-0.1,0.3,0.1,0.5,0.4,0.6l3.4,0.7c-0.3,0.9-0.6,1.8-0.7,2.7c0,0.2,0,0.3,0.1,0.4l3,2.9c0.1,0.1,0.2,0.1,0.4,0.1c0,0,0,0,0,0c0.9-0.1,1.9-0.3,2.8-0.6l0.7,3.3c0,0.2,0.3,0.4,0.5,0.4c0.1,0,0.2,0,0.2-0.1l3.7-2.1c0.9-0.5,1.3-1.6,1.1-2.6l-0.7-2.9l1.4-1.3C21.3,10.5,22.6,6.5,21.6,2.7z M3.2,11.1L4.9,8c0.3-0.6,0.9-0.8,1.5-0.6l2.3,0.6L7.7,9.2c-0.6,0.8-1.2,1.6-1.6,2.5L3.2,11.1z M16,19l-3.1,1.8l-0.6-2.9c0.9-0.4,1.7-1,2.5-1.6l1.3-1.2l0.6,2.3C16.7,18,16.5,18.7,16,19z M17.6,12.3l-3.5,3.2c-1.5,1.3-3.4,2.1-5.4,2.3l-2.6-2.6c0.3-2,1.1-3.9,2.4-5.4L10.1,8c0,0,0.1-0.1,0.1-0.1l1.4-1.6c2.2-2.6,5.8-3.8,9.1-3.1C21.4,6.6,20.3,10.1,17.6,12.3z M16.4,5.6c-1.1,0-1.9,0.9-1.9,1.9s0.9,1.9,1.9,1.9c1.1,0,1.9-0.9,1.9-1.9C18.3,6.5,17.5,5.6,16.4,5.6z M16.4,8.5c-0.5,0-0.9-0.4-0.9-0.9c0-0.5,0.4-0.9,0.9-0.9c0.5,0,0.9,0.4,0.9,0.9C17.3,8.1,16.9,8.5,16.4,8.5z"/></svg>
                        <span class="side-menu__label"> Subscription Plans</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('advertisements.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M21.6,2.7c0-0.2-0.2-0.3-0.4-0.4c-3.8-1-7.9,0.3-10.4,3.3L9.5,7.1L6.8,6.4C5.7,6,4.6,6.5,4.1,7.5L2,11.2c0,0,0,0.1-0.1,0.1c-0.1,0.3,0.1,0.5,0.4,0.6l3.4,0.7c-0.3,0.9-0.6,1.8-0.7,2.7c0,0.2,0,0.3,0.1,0.4l3,2.9c0.1,0.1,0.2,0.1,0.4,0.1c0,0,0,0,0,0c0.9-0.1,1.9-0.3,2.8-0.6l0.7,3.3c0,0.2,0.3,0.4,0.5,0.4c0.1,0,0.2,0,0.2-0.1l3.7-2.1c0.9-0.5,1.3-1.6,1.1-2.6l-0.7-2.9l1.4-1.3C21.3,10.5,22.6,6.5,21.6,2.7z M3.2,11.1L4.9,8c0.3-0.6,0.9-0.8,1.5-0.6l2.3,0.6L7.7,9.2c-0.6,0.8-1.2,1.6-1.6,2.5L3.2,11.1z M16,19l-3.1,1.8l-0.6-2.9c0.9-0.4,1.7-1,2.5-1.6l1.3-1.2l0.6,2.3C16.7,18,16.5,18.7,16,19z M17.6,12.3l-3.5,3.2c-1.5,1.3-3.4,2.1-5.4,2.3l-2.6-2.6c0.3-2,1.1-3.9,2.4-5.4L10.1,8c0,0,0.1-0.1,0.1-0.1l1.4-1.6c2.2-2.6,5.8-3.8,9.1-3.1C21.4,6.6,20.3,10.1,17.6,12.3z M16.4,5.6c-1.1,0-1.9,0.9-1.9,1.9s0.9,1.9,1.9,1.9c1.1,0,1.9-0.9,1.9-1.9C18.3,6.5,17.5,5.6,16.4,5.6z M16.4,8.5c-0.5,0-0.9-0.4-0.9-0.9c0-0.5,0.4-0.9,0.9-0.9c0.5,0,0.9,0.4,0.9,0.9C17.3,8.1,16.9,8.5,16.4,8.5z"/></svg>
                        <span class="side-menu__label"> Advertisements</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('site-settings.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M21.6,2.7c0-0.2-0.2-0.3-0.4-0.4c-3.8-1-7.9,0.3-10.4,3.3L9.5,7.1L6.8,6.4C5.7,6,4.6,6.5,4.1,7.5L2,11.2c0,0,0,0.1-0.1,0.1c-0.1,0.3,0.1,0.5,0.4,0.6l3.4,0.7c-0.3,0.9-0.6,1.8-0.7,2.7c0,0.2,0,0.3,0.1,0.4l3,2.9c0.1,0.1,0.2,0.1,0.4,0.1c0,0,0,0,0,0c0.9-0.1,1.9-0.3,2.8-0.6l0.7,3.3c0,0.2,0.3,0.4,0.5,0.4c0.1,0,0.2,0,0.2-0.1l3.7-2.1c0.9-0.5,1.3-1.6,1.1-2.6l-0.7-2.9l1.4-1.3C21.3,10.5,22.6,6.5,21.6,2.7z M3.2,11.1L4.9,8c0.3-0.6,0.9-0.8,1.5-0.6l2.3,0.6L7.7,9.2c-0.6,0.8-1.2,1.6-1.6,2.5L3.2,11.1z M16,19l-3.1,1.8l-0.6-2.9c0.9-0.4,1.7-1,2.5-1.6l1.3-1.2l0.6,2.3C16.7,18,16.5,18.7,16,19z M17.6,12.3l-3.5,3.2c-1.5,1.3-3.4,2.1-5.4,2.3l-2.6-2.6c0.3-2,1.1-3.9,2.4-5.4L10.1,8c0,0,0.1-0.1,0.1-0.1l1.4-1.6c2.2-2.6,5.8-3.8,9.1-3.1C21.4,6.6,20.3,10.1,17.6,12.3z M16.4,5.6c-1.1,0-1.9,0.9-1.9,1.9s0.9,1.9,1.9,1.9c1.1,0,1.9-0.9,1.9-1.9C18.3,6.5,17.5,5.6,16.4,5.6z M16.4,8.5c-0.5,0-0.9-0.4-0.9-0.9c0-0.5,0.4-0.9,0.9-0.9c0.5,0,0.9,0.4,0.9,0.9C17.3,8.1,16.9,8.5,16.4,8.5z"/></svg>
                        <span class="side-menu__label"> Site Settings</span>
                    </a>
                </li>



            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg>
            </div>
        </div>
    </div>
</div>
