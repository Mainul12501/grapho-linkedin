<aside class="left-panel  profileOptionLeftside">

    <a href="{{ route('employee.my-saved-jobs') }}" class="userOptionforMobileOptions  {{ request()->is('employee/my-saved-jobs') ? 'userOptionforMobileOptionsActive' : '' }}">
        <div class="d-flex align-items-center">
            <div class="icon">
                <img src="{{ asset('/') }}frontend/employee/images/profile/bookMarkColor.png" alt="Saved jobs" />
            </div>
            <div class="text">Saved jobs</div>
        </div>
    </a>

    <a href="{{ route('employee.my-applications') }}" class="userOptionforMobileOptions {{ request()->is('employee/my-applications') ? 'userOptionforMobileOptionsActive' : '' }}">
        <div class="d-flex align-items-center">
            <div class="icon">
                <img src="{{ asset('/') }}frontend/employee/images/header images/Myapplications.png" alt="My applications" />
            </div>
            <div class="text">My applications</div>
        </div>
    </a>

    <a href="{{ route('employee.my-profile-viewers') }}" class="userOptionforMobileOptions {{ request()->is('employee/my-profile-viewers') ? 'userOptionforMobileOptionsActive' : '' }}">
        <div class="d-flex align-items-center">
            <div class="icon">
                <img src="{{ asset('/') }}frontend/employee/images/header images/Profilerviewers.png" alt="Profiler viewers" />
            </div>
            <div class="text">Profiler viewers</div>
        </div>
    </a>

    <a href="{{ route('employee.my-subscriptions') }}" class="userOptionforMobileOptions {{ request()->is('employee/my-subscriptions') ? 'userOptionforMobileOptionsActive' : '' }}">
        <div class="d-flex align-items-center">
            <div class="icon">
                <img src="{{ asset('/') }}frontend/employee/images/header images/Subscription.png" alt="Subscription" />
            </div>
            <div class="text">Subscription</div>
        </div>
    </a>

    <a href="{{ route('employee.settings') }}" class="userOptionforMobileOptions {{ request()->is('employee/settings') ? 'userOptionforMobileOptionsActive' : '' }}">
        <div class="d-flex align-items-center">
            <div class="icon">
                <img src="{{ asset('/') }}frontend/employee/images/header images/Settings.png" alt="Settings" />
            </div>
            <div class="text">Settings</div>
        </div>
    </a>
</aside>
