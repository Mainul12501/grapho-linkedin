@extends('frontend.employee.master')

@section('title', 'My Applications')

@section('body')


    <section class="bg-white forSmall smallTop">
        <a href="{{ route('employee.my-applications') }}"><img src="{{ asset('/') }}frontend/employee/images/profile/leftArrowDark.png" alt="" class="me-2"> {{ trans('employee.my_applications') }}</a>
    </section>

    <!-- Main Content -->
    <div class="container container-main mt-md-5 mt-2 ">
        <!-- Left Side Menu -->
        @include('frontend.employee.jobs.left-menu')

        <!-- Right Scrollable Jobs -->
        <section class="w-100 profileOptionRight">

            <h1 class="forLarge">{{ trans('employee.my_applications') }}</h1>
            <p class="">{{ trans('employee.you_have_applied_to_jobs', ['count' => count($myApplications) ?? 0]) }}</p>

            <div class="right-panel w-100 appliedJobs">
                <div class="appliedJobs-table">
                    <div class="appliedJobs-header">
                        <span>{{ trans('employee.company') }}</span>
                        <span>{{ trans('employee.position') }}</span>
                        <span>{{ trans('employee.applied_on') }}</span>
                        <span>{{ trans('common.status') }}</span>
                        <span>{{ trans('common.action') }}</span>
                    </div>

                    <!-- Row 1 -->
                    @forelse($myApplications as $myApplication)
                        <div class="appliedJobs-row">
                            <div class="company">
                                <img src="{{ asset(isset($myApplication?->jobTask?->employerCompany?->logo) ? $myApplication?->jobTask?->employerCompany?->logo :'/frontend/company-vector.jpg') }}" alt="{{ $myApplication?->jobTask?->employerCompany?->name ?? 'company Name' }}"  height="28" />
                                <span>{{ $myApplication?->jobTask?->employerCompany?->name ?? 'United Commercial Bank' }}</span>
                            </div>
                            <div class="position">{{ $myApplication?->jobTask?->job_title ?? 'Job Title' }}</div>
                            <div class="date">{{ \Illuminate\Support\Carbon::parse($myApplication?->jobTask?->created_at)->format('d-m-Y') ?? '24-09-2024' }}</div>
                            <div class="status @if($myApplication?->status == 'approved') accepted @endif @if($myApplication?->status == 'pending') pending @endif @if($myApplication?->status == 'rejected') bg-danger @endif ">@if($myApplication?->status == 'approved') {{ trans('employee.approved') }} @endif @if($myApplication?->status == 'pending') {{ trans('employee.pending') }} @endif @if($myApplication?->status == 'rejected') {{ trans('employee.rejected') }} @endif</div>
                            <div class="action">
                                <div class="action-menu-trigger" onclick="toggleActionMenu(this)">⋮</div>
                                <div class="action-dropdown">
{{--                                    <div>{{ trans('common.message') }}</div>--}}
                                    <div><a href="{{ route('employee.show-jobs', ['job_task' => $myApplication?->jobTask?->id ]) }}" class="nav-link">{{ trans('common.view_job_post') }}</a></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="appliedJobs-row">
                            <p class="f-s-20 text-center">{{ trans('employee.havent_applied_any_job') }}</p>
                        </div>
                        <style>
                            .appliedJobs .appliedJobs-row {display: block};
                        </style>
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

