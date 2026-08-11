@foreach($webNotifications as $notification)
    <div class="notification-item make-seen {{ $notification->is_seen == 0 ? 'notification-viewed' : 'notification-accepted' }}" data-notification-id="{{ $notification->id }}" style="cursor: pointer">
        <div class="notification-icon">
            @if($notification->notification_type != null && $notification->notification_type != 'view_profile')
                <img src="{{ asset('/') }}frontend/employee/images/notification/notificationLogo2.png">
            @else
                <img src="{{ asset('/frontend/circle-eye.png') }}">
            @endif


        </div>

        <div class="notification-content">
            <p>{!! $notification->msg !!}</p>
            <span class="time">
                {{ optional($notification->created_at)->diffForHumans() }}
            </span>
        </div>

{{--        <div class="more-options">--}}
{{--            <img src="{{ asset('/') }}frontend/employee/images/contentImages/inboxThreeDotIcon.png">--}}
{{--        </div>--}}
    </div>
@endforeach
