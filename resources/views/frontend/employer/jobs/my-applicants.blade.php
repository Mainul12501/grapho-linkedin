@extends('frontend.employer.master')

@section('title', 'My Applicants')

@section('body')

    <div class="container-fluid p-4">
        <h4 class="fw-bold mb-4 f-s-23">{{ trans('employer.applicants') }}</h4>
{{--        <p class="text-secondary mb-4 small">--}}
{{--            {{ trans('employer.see_all_posted_jobs') }}--}}
{{--        </p>--}}

        <div class="row g-4">
            @forelse($jobTasks as $jobTask)
                <div class="col-12 col-md-6 col-lg-6 pe-0 mt-2">
                    <a href="{{ route('employer.my-job-applicants', ['jobTask' => $jobTask->id]) }}" style="padding: 32px 40px!important;" class="d-flex justify-content-between align-items-center border rounded-3 text-decoration-none text-dark card-link bg-white" >
                        <div>
                            <h6 class="mb-1 fw-semibold">{{ $jobTask->job_title ?? 'Job Title' }}</h6>
                            <div class="d-flex align-items-center text-muted small">
                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/talentUserGroupIcon.png" alt="" class="me-1">
                                <span class="text-decoration-underline">{{ count($jobTask->employeeAppliedJobs) ?? 0 }} {{ trans('employer.applicants') }}</span>
                            </div>
                        </div>
                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/arrow-right 1.png" alt="Go" class="icon-arrow" />
                    </a>
                </div>
            @empty
                <div class="col-12 d-flex justify-content-center mt-4">
                    <div class="text-center p-5 border rounded-3 bg-white" style="max-width: 480px; width: 100%;">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#b0b8c4" viewBox="0 0 16 16">
                                <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                        </div>
                        <h5 class="fw-semibold mb-2" style="color: #141C25;">{{ trans('employer.no_available_job_found') }}</h5>
                        <p class="text-muted small mb-4">Post a job to start receiving applicants and manage them here.</p>
                        <a href="{{ route('employer.my-jobs') }}" class="btn btn-dark px-4 py-2 rounded-pill">
                            <i class="fas fa-plus me-1"></i> {{ trans('employer.my_jobs') }}
                        </a>
                    </div>
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
