@extends('frontend.employee.master')

@section('title', 'My Notifications')

@section('body')


    <!-- Main Content -->
    <section class="notificationContent">
        <div class="container">
            <h2>Notifications</h2>
            <h6>You have 2 new notifications.</h6>
            <div class="notification-list">
                <!-- Notification Item -->
                <div class="notification-item notification-viewed">
                    <div class="notification-icon">
                        <img src="{{ asset('/') }}frontend/employee/images/notification/notificationLogo2.png" alt="Notification Icon" />
                    </div>
                    <div class="notification-content">
                        <p><strong>United Commercial Bank PLC</strong> have viewed your profile.</p>
                        <span class="time">5h ago</span>
                    </div>
                    <div class="more-options"><img src="{{ asset('/') }}frontend/employee/images/contentImages/inboxThreeDotIcon.png" alt=""></div>
                </div>


                <!-- Notification Item -->
                <div class="notification-item notification-viewed">
                    <div class="notification-icon">
                        <img src="{{ asset('/') }}frontend/employee/images/notification/notificationLogo1.png" alt="Notification Icon" />
                    </div>
                    <div class="notification-content">
                        <p><strong>Unilever Bangladesh</strong> have accepted your job application: <strong>Management Trainee.</strong></p>
                        <span class="time">5h ago</span>
                    </div>
                    <div class="more-options"><img src="{{ asset('/') }}frontend/employee/images/contentImages/inboxThreeDotIcon.png" alt=""></div>
                </div>


                <!-- Another Notification Item -->
                <div class="notification-item notification-accepted">
                    <div class="notification-icon">
                        <img src="{{ asset('/') }}frontend/employee/images/notification/notificationLogo3.png" alt="Notification Icon" />
                    </div>
                    <div class="notification-content">
                        <p> <strong>United Commercial Bank PLC</strong> have posted a new job.</p>
                        <span class="time">8h ago</span>
                    </div>
                    <div class="more-options"><img src="{{ asset('/') }}frontend/employee/images/contentImages/inboxThreeDotIcon.png" alt=""></div>
                </div>

                <!-- Another Notification Item -->
                <div class="notification-item notification-accepted">
                    <div class="notification-icon">
                        <img src="{{ asset('/') }}frontend/employee/images/notification/notificationLogo1.png" alt="Notification Icon" />
                    </div>
                    <div class="notification-content">
                        <p><strong>Unilever Bangladesh</strong> have accepted your job application: <strong>Management Trainee.</strong></p>
                        <span class="time">8h ago</span>
                    </div>
                    <div class="more-options"><img src="{{ asset('/') }}frontend/employee/images/contentImages/inboxThreeDotIcon.png" alt=""></div>
                </div>

                <!-- Another Notification Item -->
                <div class="notification-item notification-accepted">
                    <div class="notification-icon">
                        <img src="{{ asset('/') }}frontend/employee/images/notification/notificationLogo3.png" alt="Notification Icon" />
                    </div>
                    <div class="notification-content">
                        <p> <strong>United Commercial Bank PLC</strong> have posted a new job.</p>
                        <span class="time">8h ago</span>
                    </div>
                    <div class="more-options"><img src="{{ asset('/') }}frontend/employee/images/contentImages/inboxThreeDotIcon.png" alt=""></div>
                </div>

                <!-- Add More Notifications as Needed -->

                <div class="show-more bg-white">
                    <a href="#">Show more</a>
                </div>
            </div>
        </div>
    </section>



@endsection
