<aside class="sidebar bg-white p-3">
    <a href="" class="brand mb-3 d-block">
{{--        <img src="{{ isset($siteSetting) ? asset($siteSetting->logo) : asset('/frontend/likewise.png') }}" alt="" class="" style="max-height: 40px; max-width: 120px; min-width: 90px" /></a>--}}
        <img src="{{ asset('/frontend/likewise.png') }}" alt="" class="" style="max-height: 40px; max-width: 120px; min-width: 90px" /></a>
    <ul class="nav flex-column">
        <li class="nav-item mb-2" style="">
            <a class="nav-link {{ request()->is('employer/home') ? 'active' : '' }}" href="{{ route('employer.home') }}" ><img src="{{ asset('/') }}frontend/employer/images/employersHome/HomeDesk.png" alt="" class="me-2">{{ trans('employer.home') }}</a>
        </li>
        <li class="nav-item mb-2" style="">
            <a class="nav-link {{ request()->is('employer/dashboard') ? 'active' : '' }}" href="{{ route('employer.dashboard', ['is_own' => 'true']) }}" ><img src="{{ asset('/backend/assets/images/dashboard.png') }}" alt="" style="height: 20px" class="me-2">{{ trans('employer.dashboard') }}</a>
        </li>
        <li class="nav-item mb-2" style="">
            <a class="nav-link {{ request()->is('employer/my-jobs') ? 'active' : '' }}" href="{{ route('employer.my-jobs') }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/My JobsDesk.png" alt="" class="me-2">{{ trans('employer.my_jobs') }}</a>
        </li>
        <li class="nav-item mb-2" style="">
            <a class="nav-link {{ request()->is('employer/my-job-wise-applicants') || request()->is('employer/my-job-applicants/*') ? 'active' : '' }}" href="{{ route('employer.my-job-wise-applicants') }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/ApplicantsDesk.png" alt="" class="me-2">{{ trans('employer.applicants') }}</a>
        </li>
{{--        <li class="nav-item mb-2">--}}
{{--            <a class="nav-link {{ request()->is('employer/head-hunt') ? 'active' : '' }}" href="{{ route('employer.head-hunt') }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Head HuntDesk.png" alt="" class="me-2">Head Hunt</a>--}}
{{--        </li>--}}
        @if(isset($siteSetting) && $siteSetting->subscription_system_status ==1)
            <li class="nav-item mb-2" style="">
                <a class="nav-link {{ request()->is('employer.employer-subscriptions') ? 'active' : '' }}" href="{{ route('employer.employer-subscriptions') }}"><img src="{{ asset('/backend/assets/images/save-money.png') }}" style="height: 20px" alt="" class="me-2">{{ trans('employer.subscriptions') }}</a>
            </li>
        @endif

{{--        <li class="nav-item mb-2">--}}
{{--            <a class="nav-link {{ request()->is('employer.posts') ? 'active' : '' }}" href="{{ route('employer.posts.index') }}"><img src="{{ asset('/backend/assets/images/post.png') }}" style="height: 20px;" alt="" class="me-2">{{ trans('employer.posts') }}</a>--}}
{{--        </li>--}}
        <li class="nav-item" style="">
            <a class="nav-link " href="{{ url('/chat') }}" target="_blank"><img src="{{ asset('/') }}frontend/employer/images/employersHome/InboxDEsk.png" alt="" class="me-2">{{ trans('employer.inbox') }}</a>
        </li>
    </ul>
</aside>
