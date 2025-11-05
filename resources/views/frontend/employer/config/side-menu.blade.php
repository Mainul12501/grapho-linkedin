<nav class="col-md-3 col-12 mb-4 mb-md-0 settings-menu d-none d-md-block">
    <ul class="nav flex-md-column nav-pills gap-3">
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ request()->is('employer/settings') ? 'active' : '' }}" href="{{ route('employer.settings') }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Settings-Full Name.png" alt="" class="me-2"> {{ trans('employer.my_account') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ request()->is('employer/employer-user-management') ? 'active' : '' }}" href="{{ route('employer.employer-user-management') }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Settings_userManagement-Aticve.png" alt="" class="me-2"> {{ trans('home.users_management') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="#"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Setting-Terms & Policies.png" alt="" class="me-2"> {{ trans('home.terms_policies') }}</a>
        </li>
    </ul>
</nav>
