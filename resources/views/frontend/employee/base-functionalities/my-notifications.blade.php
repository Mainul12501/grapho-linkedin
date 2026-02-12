@extends('frontend.employee.master')

@section('title', 'My Notifications')

@section('body')


    <!-- Main Content -->
    <section class="notificationContent">
        <div class="container">
            <h2>{{ trans('employee.notifications') }}</h2>
            <h6>{{ trans('common.you') }} {{ trans('common.have') }} {{$newNotifications ?? 0 }} {{ trans('common.new') }} {{ trans('common.message') }}.</h6>
            <div class="notification-list" id="notification-container">
                @include('frontend.employee.base-functionalities.partials.notification-items',['webNotifications' => $notifications])
                <!-- Notification Item -->
{{--                @forelse($notifications as $notification)--}}
{{--                    <div class="notification-item {{ $notification->is_seen == 0 ? 'notification-viewed' : 'notification-accepted' }} ">--}}
{{--                        <div class="notification-icon">--}}
{{--                            <img src="{{ asset('/') }}frontend/employee/images/notification/notificationLogo2.png" alt="Notification Icon" />--}}
{{--                        </div>--}}
{{--                        <div class="notification-content">--}}
{{--                            <p>{!! $notification->msg ?? 'Notification Message Here' !!}</p>--}}
{{--                            <span class="time">{{ \Illuminate\Support\Carbon::parse($notification->created_at)->diffForHumans() ?? '0h ago' }}</span>--}}
{{--                        </div>--}}
{{--                        <div class="more-options"><img src="{{ asset('/') }}frontend/employee/images/contentImages/inboxThreeDotIcon.png" alt=""></div>--}}
{{--                    </div>--}}
{{--                @empty--}}

{{--                    <!-- Another Notification Item -->--}}
{{--                    <div class="notification-item notification-accepted">--}}
{{--                        <div class="notification-icon">--}}
{{--                            <img src="{{ asset('/') }}frontend/employee/images/notification/notificationLogo3.png" alt="Notification Icon" />--}}
{{--                        </div>--}}
{{--                        <div class="notification-content">--}}
{{--                            <p class="text-center"> {{ trans('common.no') }} {{ trans('common.message') }} {{ trans('common.available') }} {{ trans('common.yet') }}.</p>--}}
{{--                            <span class="time">8h ago</span>--}}
{{--                        </div>--}}
{{--                        <div class="more-options"><img src="{{ asset('/') }}frontend/employee/images/contentImages/inboxThreeDotIcon.png" alt=""></div>--}}
{{--                    </div>--}}
{{--                @endforelse--}}

                @if(count($notifications) == 0)
                                        <!-- Another Notification Item -->
                                        <div class="notification-item notification-accepted">
{{--                                            <div class="notification-icon">--}}
{{--                                                <img src="{{ asset('/') }}frontend/employee/images/notification/notificationLogo3.png" alt="Notification Icon" />--}}
{{--                                            </div>--}}
                                            <div class="notification-content">
                                                <p class="text-center"> {{ trans('common.no') }} {{ trans('common.message') }} {{ trans('common.available') }} {{ trans('common.yet') }}.</p>
{{--                                                <span class="time">8h ago</span>--}}
                                            </div>
{{--                                            <div class="more-options"><img src="{{ asset('/') }}frontend/employee/images/contentImages/inboxThreeDotIcon.png" alt=""></div>--}}
                                        </div>
                @endif

            </div>
            <div id="loader" style="display:none;text-align:center;padding:15px">
                Loading...
            </div>
        </div>
    </section>



@endsection

@push('script')
    <script>
        let page = 1;
        let loading = false;

        $(window).on('scroll', function () {

            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 150) {

                if (loading) return;
                loading = true;
                page++;

                $('#loader').show();

                $.get('?page=' + page, function (data) {

                    if (data.trim() === '') {
                        $('#loader').hide();
                        return;
                    }

                    $('#notification-container').append(data);
                    loading = false;
                    $('#loader').hide();
                });
            }
        });
    </script>
    <script>
        $(document).on('click', '.make-seen', function () {
            var notificationId  = $(this).attr('data-notification-id');
            let $this = $(this);
            sendAjaxRequest('employee/make-msg-seen/'+notificationId, 'POST').then(function (response) {
                if (response.status == 'success')
                {
                    $this.removeClass('notification-viewed').addClass('notification-accepted');
                    toastr.success(response.msg);
                } else {
                    toastr.error(response.msg);
                }

            })
        })
    </script>
@endpush
