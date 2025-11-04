@extends('frontend.employer.master')

@section('title', 'My Applicants')

@section('body')

    <div class="container-fluid p-4">
        <h4 class="fw-bold mb-2 f-s-23">My talents</h4>
        <p class="text-secondary mb-4 small">
            Here the applicants are grouped based on the jobs they applied for
        </p>

        <div class="row g-4">
            @forelse($jobTasks as $jobTask)
                <div class="col-12 col-md-6 col-lg-6 pe-0 mt-2">
                    <a href="{{ route('employer.my-job-applicants', ['jobTask' => $jobTask->id]) }}" style="padding: 32px 40px!important;" class="d-flex justify-content-between align-items-center border rounded-3 text-decoration-none text-dark card-link bg-white" >
                        <div>
                            <h6 class="mb-1 fw-semibold">{{ $jobTask->job_title ?? 'Job Title' }}</h6>
                            <div class="d-flex align-items-center text-muted small">
                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/talentUserGroupIcon.png" alt="" class="me-1">
                                <span class="text-decoration-underline">{{ count($jobTask->employeeAppliedJobs) ?? 0 }} Applicants</span>
                            </div>
                        </div>
                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/arrow-right 1.png" alt="Go" class="icon-arrow" />
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <p class="f-s-26">No Active Jobs Available.</p>
                </div>
            @endforelse

{{--            <div class="col-12 col-md-6 col-lg-6">--}}
{{--                <a href="job1.html" class="d-flex justify-content-between align-items-center border rounded-3 p-4 text-decoration-none text-dark card-link bg-white">--}}
{{--                    <div>--}}
{{--                        <h6 class="mb-1 fw-semibold">Senior Officer, Corporate Banking</h6>--}}
{{--                        <div class="d-flex align-items-center text-muted small">--}}
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talentUserGroupIcon.png" alt="" class="me-1">--}}
{{--                            <span class="text-decoration-underline">24 Applicants</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/arrow-right 1.png" alt="Go" class="icon-arrow" />--}}
{{--                </a>--}}
{{--            </div>--}}


        </div>
    </div>

@endsection
