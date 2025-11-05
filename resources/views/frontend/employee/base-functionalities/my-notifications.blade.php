@extends('frontend.employee.master')

@section('title', 'My Notifications')

@section('body')


    <!-- Main Content -->
    <section class="notificationContent">
        <div class="container">
            <h2>{{ trans('common.title') }}</h2>
            <h6>{{ trans('common.you') }} {{ trans('common.have') }} {{$newNotifications ?? 0 }} {{ trans('common.new') }} {{ trans('common.title') }}.</h6>
            <div class="notification-list">
                <!-- Notification Item -->
                @forelse($notifications as $notification)
                    <div class="notification-item {{ $notification->is_seen == 0 ? 'notification-viewed' : 'notification-accepted' }} ">
                        <div class="notification-icon">
                            <img src="{{ asset('/') }}frontend/employee/images/notification/notificationLogo2.png" alt="Notification Icon" />
                        </div>
                        <div class="notification-content">
                            <p>{!! $notification->msg ?? 'Notification Message Here' !!}</p>
                            <span class="time">{{ \Illuminate\Support\Carbon::parse($notification->created_at)->diffForHumans() ?? '0h ago' }}</span>
                        </div>
                        <div class="more-options"><img src="{{ asset('/') }}frontend/employee/images/contentImages/inboxThreeDotIcon.png" alt=""></div>
                    </div>
                @empty

                    <!-- Another Notification Item -->
                    <div class="notification-item notification-accepted">
{{--                        <div class="notification-icon">--}}
{{--                            <img src="{{ asset('/') }}frontend/employee/images/notification/notificationLogo3.png" alt="Notification Icon" />--}}
{{--                        </div>--}}
                        <div class="notification-content">
                            <p class="text-center"> {{ trans('common.no') }} {{ trans('common.title') }} {{ trans('common.available') }} {{ trans('common.yet') }}.</p>
{{--                            <span class="time">8h ago</span>--}}
                        </div>
{{--                        <div class="more-options"><img src="{{ asset('/') }}frontend/employee/images/contentImages/inboxThreeDotIcon.png" alt=""></div>--}}
                    </div>
                @endforelse

                @if(count($notifications) > 0)
                    <div class="show-more bg-white">
    {{--                    <a href="#">Show more</a>--}}
                        {{ $notifications->links() }}
                    </div>
                @endif






{{--                <!-- Another Notification Item -->--}}
{{--                <div class="notification-item notification-accepted">--}}
{{--                    <div class="notification-icon">--}}
{{--                        <img src="{{ asset('/') }}frontend/employee/images/notification/notificationLogo1.png" alt="Notification Icon" />--}}
{{--                    </div>--}}
{{--                    <div class="notification-content">--}}
{{--                        <p><strong>Unilever Bangladesh</strong> have accepted your job application: <strong>Management Trainee.</strong></p>--}}
{{--                        <span class="time">8h ago</span>--}}
{{--                    </div>--}}
{{--                    <div class="more-options"><img src="{{ asset('/') }}frontend/employee/images/contentImages/inboxThreeDotIcon.png" alt=""></div>--}}
{{--                </div>--}}

{{--                <!-- Another Notification Item -->--}}
{{--                <div class="notification-item notification-accepted">--}}
{{--                    <div class="notification-icon">--}}
{{--                        <img src="{{ asset('/') }}frontend/employee/images/notification/notificationLogo3.png" alt="Notification Icon" />--}}
{{--                    </div>--}}
{{--                    <div class="notification-content">--}}
{{--                        <p> <strong>United Commercial Bank PLC</strong> have posted a new job.</p>--}}
{{--                        <span class="time">8h ago</span>--}}
{{--                    </div>--}}
{{--                    <div class="more-options"><img src="{{ asset('/') }}frontend/employee/images/contentImages/inboxThreeDotIcon.png" alt=""></div>--}}
{{--                </div>--}}

                <!-- Add More Notifications as Needed -->


            </div>
        </div>
    </section>



@endsection
