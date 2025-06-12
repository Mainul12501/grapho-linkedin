@extends('frontend.employee.master')

@section('title', 'My Applications')

@section('body')


    <section class="bg-white forSmall smallTop">
        <a href="{{ route('employee.my-applications') }}"><img src="{{ asset('/') }}frontend/employee/images/profile/leftArrowDark.png" alt="" class="me-2"> My applications</a>
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
                    @forelse($myApplications as $myApplication)
                        <div class="appliedJobs-row">
                            <div class="company">
                                <img src="{{ asset(isset($myApplication?->jobTask?->employerCompany?->logo) ? $myApplication?->jobTask?->employerCompany?->logo :'/frontend/employee/images/profile/appliedJobs1.png') }}" alt="{{ $myApplication?->jobTask?->employerCompany?->name ?? 'company Name' }}" />
                                <span>{{ $myApplication?->jobTask?->employerCompany?->name ?? 'United Commercial Bank' }}</span>
                            </div>
                            <div class="position">{{ $myApplication?->jobTask?->job_title ?? 'Job Title' }}</div>
                            <div class="date">{{ \Illuminate\Support\Carbon::parse($myApplication?->jobTask?->created_at)->format('d-m-Y') ?? '24-09-2024' }}</div>
                            <div class="status @if($myApplication?->status == 'approved') accepted @endif @if($myApplication?->status == 'pending') pending @endif @if($myApplication?->status == 'rejected') bg-danger @endif ">@if($myApplication?->status == 'approved') Approved @endif @if($myApplication?->status == 'pending') Pending @endif @if($myApplication?->status == 'rejected') Rejected @endif</div>
                            <div class="action">
                                <div class="action-menu-trigger" onclick="toggleActionMenu(this)">⋮</div>
                                <div class="action-dropdown">
                                    <div>Message</div>
                                    <div><a href="{{ route('employee.show-jobs', ['job_task' => $myApplication?->jobTask?->id ]) }}" class="nav-link">View Job Post</a></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="appliedJobs-row">
                            <p class="f-s-35">You haven't applied any job yet.</p>
                        </div>
                    @endforelse


                    <!-- Row 2 -->
{{--                    <div class="appliedJobs-row">--}}
{{--                        <div class="company">--}}
{{--                            <img src="{{ asset('/') }}frontend/employee/images/profile/appliedJobs2.png" alt="Unilever" />--}}
{{--                            <span>Unilever Bangladesh</span>--}}
{{--                        </div>--}}
{{--                        <div class="position">Management Trainee</div>--}}
{{--                        <div class="date">24-09-2024</div>--}}
{{--                        <div class="status pending">Pending</div>--}}

{{--                        <div class="action">--}}
{{--                            <div class="action-menu-trigger" onclick="toggleActionMenu(this)">⋮</div>--}}
{{--                            <div class="action-dropdown">--}}
{{--                                <div>Message</div>--}}
{{--                                <div>View Job Post</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <!-- ... -->
                </div>
            </div>

        </section>
    </div>



@endsection

