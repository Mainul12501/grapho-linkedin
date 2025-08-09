<aside class="sidebar bg-white p-3">
    <a href="" class="brand mb-3 d-block">
        <img src="{{ isset($siteSetting) ? asset($siteSetting->logo) : asset('/frontend/employer/images/employersHome/logo.png') }}" alt="" class="" style="max-width: 60px; border-radius: 50%" /></a>
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a class="nav-link {{ request()->is('employer/home') ? 'active' : '' }}" href="{{ route('employer.home') }}" ><img src="{{ asset('/') }}frontend/employer/images/employersHome/HomeDesk.png" alt="" class="me-2">Home</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link {{ request()->is('employer/dashboard') ? 'active' : '' }}" href="{{ route('employer.dashboard') }}" ><img src="{{ asset('/') }}frontend/employer/images/employersHome/HomeDesk.png" alt="" class="me-2">Dashboard</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link {{ request()->is('employer/my-jobs') ? 'active' : '' }}" href="{{ route('employer.my-jobs') }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/My JobsDesk.png" alt="" class="me-2">My Jobs</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link {{ request()->is('employer/my-job-wise-applicants') ? 'active' : '' }}" href="{{ route('employer.my-job-wise-applicants') }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/ApplicantsDesk.png" alt="" class="me-2">Applicants</a>
        </li>
{{--        <li class="nav-item mb-2">--}}
{{--            <a class="nav-link {{ request()->is('employer/head-hunt') ? 'active' : '' }}" href="{{ route('employer.head-hunt') }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Head HuntDesk.png" alt="" class="me-2">Head Hunt</a>--}}
{{--        </li>--}}
        <li class="nav-item mb-2">
            <a class="nav-link {{ request()->is('employer.employer-subscriptions') ? 'active' : '' }}" href="{{ route('employer.employer-subscriptions') }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Head HuntDesk.png" alt="" class="me-2">Subscriptions</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link {{ request()->is('employer.posts') ? 'active' : '' }}" href="{{ route('employer.posts.index') }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Head HuntDesk.png" alt="" class="me-2">Posts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="#"><img src="{{ asset('/') }}frontend/employer/images/employersHome/InboxDEsk.png" alt="" class="me-2">Inbox</a>
        </li>
    </ul>
</aside>
