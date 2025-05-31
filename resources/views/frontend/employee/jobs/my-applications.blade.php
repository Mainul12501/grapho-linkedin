@extends('frontend.employee.master')

@section('title', 'My Applications')

@section('body')


    <section class="bg-white forSmall smallTop">
        <a href="profile.html"><img src="{{ asset('/') }}frontend/employee/images/profile/leftArrowDark.png" alt="" class="me-2"> My applications</a>
    </section>

    <!-- Main Content -->
    <div class="container container-main mt-md-5 mt-2 ">
        <!-- Left Side Menu -->
        @include('frontend.employee.jobs.left-menu')

        <!-- Right Scrollable Jobs -->
        <section class="w-100 profileOptionRight">

            <h1 class="forLarge">My applications</h1>
            <p class="">You have applied to 6 jobs</p>

            <div class="right-panel w-100 appliedJobs">
                <div class="appliedJobs-table">
                    <div class="appliedJobs-header">
                        <span>Company</span>
                        <span>Position</span>
                        <span>Applied on</span>
                        <span>Status</span>
                        <span>Action</span>
                    </div>

                    <!-- Row 1 -->
                    <div class="appliedJobs-row">
                        <div class="company">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/appliedJobs1.png" alt="UCB" />
                            <span>United Commercial Bank…</span>
                        </div>
                        <div class="position">Senior Officer, Corporate Ba…</div>
                        <div class="date">24-09-2024</div>
                        <div class="status accepted">Accepted</div>
                        <div class="action">
                            <div class="action-menu-trigger" onclick="toggleActionMenu(this)">⋮</div>
                            <div class="action-dropdown">
                                <div>Message</div>
                                <div>View Job Post</div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="appliedJobs-row">
                        <div class="company">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/appliedJobs2.png" alt="Unilever" />
                            <span>Unilever Bangladesh</span>
                        </div>
                        <div class="position">Management Trainee</div>
                        <div class="date">24-09-2024</div>
                        <div class="status pending">Pending</div>

                        <div class="action">
                            <div class="action-menu-trigger" onclick="toggleActionMenu(this)">⋮</div>
                            <div class="action-dropdown">
                                <div>Message</div>
                                <div>View Job Post</div>
                            </div>
                        </div>
                    </div>


                    <!-- Row 3 -->
                    <div class="appliedJobs-row">
                        <div class="company">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/appliedJobs3.png" alt="Unilever" />
                            <span>Grameenphone Ltd</span>
                        </div>
                        <div class="position">Next Business Leader</div>
                        <div class="date">24-09-2024</div>
                        <div class="status pending">Pending</div>

                        <div class="action">
                            <div class="action-menu-trigger" onclick="toggleActionMenu(this)">⋮</div>
                            <div class="action-dropdown">
                                <div>Message</div>
                                <div>View Job Post</div>
                            </div>
                        </div>
                    </div>


                    <!-- Row 4 -->
                    <div class="appliedJobs-row">
                        <div class="company">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/appliedJobs4.png" alt="UCB" />
                            <span>BRAC Bank Limited</span>
                        </div>
                        <div class="position">Management Trainee</div>
                        <div class="date">24-09-2024</div>
                        <div class="status accepted">Accepted</div>
                        <div class="action">
                            <div class="action-menu-trigger" onclick="toggleActionMenu(this)">⋮</div>
                            <div class="action-dropdown">
                                <div>Message</div>
                                <div>View Job Post</div>
                            </div>
                        </div>
                    </div>


                    <!-- Row 5 -->
                    <div class="appliedJobs-row">
                        <div class="company">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/appliedJobs5.png" alt="Unilever" />
                            <span>Grameenphone Ltd</span>
                        </div>
                        <div class="position">Next Business Leader</div>
                        <div class="date">24-09-2024</div>
                        <div class="status pending">Pending</div>

                        <div class="action">
                            <div class="action-menu-trigger" onclick="toggleActionMenu(this)">⋮</div>
                            <div class="action-dropdown">
                                <div>Message</div>
                                <div>View Job Post</div>
                            </div>
                        </div>
                    </div>
                    <!-- Repeat similar rows -->
                    <!-- ... -->
                </div>
            </div>

        </section>
    </div>



@endsection

