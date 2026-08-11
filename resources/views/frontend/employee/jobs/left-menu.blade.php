<aside class="left-panel profileOptionLeftside sj-sidebar">

    <a href="{{ route('employee.my-saved-jobs') }}" class="userOptionforMobileOptions sj-nav-link {{ request()->is('employee/my-saved-jobs') ? 'userOptionforMobileOptionsActive sj-nav-active' : '' }}">
        <div class="d-flex align-items-center">
            <div class="icon sj-nav-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="text">{{ trans('employee.my_saved_jobs') }}</div>
        </div>
    </a>

    <a href="{{ route('employee.my-applications') }}" class="userOptionforMobileOptions sj-nav-link {{ request()->is('employee/my-applications') ? 'userOptionforMobileOptionsActive sj-nav-active' : '' }}">
        <div class="d-flex align-items-center">
            <div class="icon sj-nav-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <div class="text">{{ trans('employee.my_applications') }}</div>
        </div>
    </a>

    <a href="{{ route('employee.my-profile-viewers') }}" class="userOptionforMobileOptions sj-nav-link {{ request()->is('employee/my-profile-viewers') ? 'userOptionforMobileOptionsActive sj-nav-active' : '' }}">
        <div class="d-flex align-items-center">
            <div class="icon sj-nav-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
            <div class="text">{{ trans('employee.profiler_viewers') }}</div>
        </div>
    </a>

    <a href="{{ route('employee.my-subscriptions') }}" class="userOptionforMobileOptions sj-nav-link {{ request()->is('employee/my-subscriptions') ? 'userOptionforMobileOptionsActive sj-nav-active' : '' }}">
        <div class="d-flex align-items-center">
            <div class="icon sj-nav-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
            </div>
            <div class="text">{{ trans('employee.subscription') }}</div>
        </div>
    </a>

    <a href="{{ route('employee.settings') }}" class="userOptionforMobileOptions sj-nav-link {{ request()->is('employee/settings') ? 'userOptionforMobileOptionsActive sj-nav-active' : '' }}">
        <div class="d-flex align-items-center">
            <div class="icon sj-nav-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            </div>
            <div class="text">{{ trans('employee.settings') }}</div>
        </div>
    </a>
</aside>
