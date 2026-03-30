@extends('frontend.employer.master')

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

@push('style')
    <style>
        .notificationContent h2{
            font-weight: 600;
            font-size: 24px;
            line-height: 100%;
            letter-spacing: -2%;
            color: #141C25;
        }

        .notificationContent h6{
            font-weight: 400;
            font-size: 16px;
            line-height: 160%;
            letter-spacing: -1%;
            color: #484f5b;
            margin-bottom: 20px;
        }

        .notificationContent .container {
            max-width: 760px;
            margin: 0 auto;
            padding: 20px;
        }

        .notificationContent .notification-list {
            list-style: none;
            padding: 0;
        }

        .notificationContent .notification-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: #fff;
            position: relative;
            border-bottom: 1px solid #E5E7EB;
        }

        .notificationContent .notification-item:hover {
            background-color: #f1f1f1;
        }

        .notificationContent .notification-viewed {
            background-color: #FFCB111A;
        }

        .notificationContent .notification-accepted {
            background-color: #fff;
        }

        .notificationContent .notification-icon img {
            margin-right: 15px;
        }

        .notificationContent .notification-content {
            flex-grow: 1;
        }

        .notificationContent .notification-content p {
            font-size: 14px;
            margin: 0;
        }

        .notificationContent .notification-content .time {
            font-size: 12px;
            color: #6c757d;
        }

        .notificationContent .more-options {
            font-size: 20px;
            color: #6c757d;
            cursor: pointer;
        }

        .notificationContent .show-more a {
            display: block;
            text-decoration: none;
            padding: 10px 0;
            font-weight: 600;
            font-size: 16px;
            line-height: 150%;
            letter-spacing: -1%;
            text-align: center;
            color: #141C25;
        }

        .notificationContent .show-more a:hover {
            text-decoration: underline;
        }
    </style>
@endpush

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
