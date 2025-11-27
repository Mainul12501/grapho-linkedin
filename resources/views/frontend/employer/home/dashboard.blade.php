@extends('frontend.employer.master')

@section('title', 'Employer Home')

@section('body')
    <main class="dashboardContent p-4">
        <div class="container-fluid">
            <div class="row g-4">
                <!-- Left Sidebar -->
                <aside class="col-lg-3 col-md-4">
                    <!-- Find your next hire -->
{{--                    <div class="sidebar-box hire">--}}
{{--                        <div class="sidebar-icon hire">--}}
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/findYour next Hire.png" alt="">--}}
{{--                        </div>--}}
{{--                        <h5 class="fw-bold">{{ trans('employer.head_hunt') }}</h5>--}}
{{--                        <p class="small mb-3">More than {{ \App\Models\User::where('user_type', 'employee')->count() ?? 0 }} talents are on the network waiting for your call--}}
{{--                        </p>--}}
{{--                        <a href="{{ route('employer.my-jobs', ['show_modal' => 'create']) }}" class="btn btn-dark btn-sm px-3 py-2" style="border-radius: 10px;">{{ trans('employer.post_a_job') }}</a>--}}
{{--                    </div>--}}

                    <div class="">
                        <a href="{{ route('employer.my-jobs', ['show_modal' => 'create']) }}">
                            <img src="{{ asset('/frontend/employer/images/post-jobs.jpeg') }}" alt="" class="img-fluid">
                        </a>
                    </div>


{{--                    <div class="sidebar-box delegate mt-4">--}}
{{--                        <div class="sidebar-icon delegate text-center " style="height: 70px; width: 70px;">--}}
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/user.png" alt="">--}}
{{--                            <span style="font-size: 40px;"><i class="bi bi-search bi-2x" ></i></span>--}}
{{--                        </div>--}}
{{--                        <a href="{{ route('employer.head-hunt') }}" class="btn btn-dark btn-sm px-4 f-s-23 mx-auto">Head Hunt</a>--}}
{{--                        <h6 class="fw-bold mt-3">Find Talent Employees</h6>--}}
{{--                        <p class="small mb-3 text-capitalize">search, filter and Find Best employees for your company.</p>--}}
{{--                    </div>--}}
                    <div class="mt-4">
                        <a href="{{ route('employer.head-hunt') }}">
                            <img src="{{ asset('/frontend/employer/images/22.png') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </aside>

                <!-- Main Content -->
                <section class="col-lg-9 col-md-8">
                    <!-- Open Jobs Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <h5 class="fw-bold mb-0">{{ trans('employer.open_jobs') }}</h5>
                        <a href="{{ route('employer.my-jobs') }}" class="text-decoration-none small fw-semibold d-flex align-items-center showall">
                            {{ trans('employee.show_all') }} <img src="{{ asset('/') }}frontend/employer/images/employersHome/arrow-right 1.png" alt="" class="ms-2">
                        </a>
                    </div>

                    <!-- Job Cards -->
                    <div class="row gy-3">
                        <!-- Job Card -->
                        @forelse($jobTasks as $jobTask)
                            <div class="col-12">
                                <article class="job-card">
                                    <div class="job-details <!--flex-grow-1-->">
                                        <h6 class="job-title" onclick="showJobDetails({{ $jobTask->id }}, `{{ $jobTask->job_title }}`)" style="cursor: pointer;">{{ $jobTask->job_title ?? trans('common.job_title') }}</h6>
                                        <div class="job-badges d-flex flex-wrap gap-2">
                                            <span class="badge bg-light text-secondary">{{ $jobTask?->jobType?->name ?? trans('common.full_time') }}</span>
                                            <span class="badge bg-light text-secondary">{{ $jobTask?->jobLocationType?->name ?? trans('common.on_site') }}</span>
{{--                                            <span class="badge bg-light text-secondary">Day Shift</span>--}}
                                        </div>
                                    </div>

                                    <div class="job-info">
                                        <div class="mb-2"><img src="{{ asset('/') }}frontend/employer/images/employersHome/postdOn.png" alt="" class="me-2">{{ trans('employer.posted_on') }} {{ $jobTask->created_at->format('d M, Y') ?? '16 Feb, 2025' }}</div>
                                        <div class="mb-2"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Dedline.png" alt="" class="me-2">{{ trans('employer.deadline') }} {{ \Illuminate\Support\Carbon::parse($jobTask->deadline)->format('d M, Y') ?? '16 Feb, 2025' }}</div>
                                        <div><img src="{{ asset('/') }}frontend/employer/images/employersHome/24application.png" alt="" class="me-2"><a href="{{ route('employer.my-job-applicants', $jobTask->id) }}" class="text-decoration-underline">{{ $jobTask->employeeAppliedJobs->count() ?? 0 }} {{ trans('employer.applicants') }}</a></div>
                                    </div>

                                    <div class="job-actions dropdown">
                                        <button class="btn btn-link p-0 text-secondary" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="">
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
{{--                                            <li><a class="dropdown-item" href="{{ route('employer.job-tasks.edit', $jobTask->id) }}">{{ trans('common.edit') }}</a></li>--}}
                                            <li>
                                                <form action="{{ route('employer.job-tasks.destroy', $jobTask->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item data-delete-form" type="submit">{{ trans('common.delete') }}</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </article>
                            </div>
                        @empty
                            <div class="col-12">
                                <p style="font-size: 36px;">{{ trans('employer.no_published_job_yet') }}</p>
                            </div>
                        @endforelse
                        <div class="col-12 text-center align-content-center">
                            @if(count($jobTasks) > 10)
                                {!! $jobTasks->links() !!}
                            @endif
                        </div>




                    </div>

                    <!-- Top talent picks -->
                    <div class="d-flex justify-content-between align-items-center mt-5 mb-3 flex-wrap">
                        <h5 class="fw-bold mb-0">{{ trans('employer.browse_talents_find_match') }}</h5>
                        <a href="{{ route('employer.head-hunt') }}" class="text-decoration-none small fw-semibold d-flex align-items-center showall">
                            {{ trans('employer.head_hunt') }} <img src="{{ asset('/') }}frontend/employer/images/employersHome/arrow-right 1.png" alt="" class="ms-2">
                        </a>
                    </div>

                    <div class="row g-3">
                        <!-- Talent Card 1 -->
                        @foreach($employees as $employee)
                            <div class="col-md-4 col-sm-6">
                                <a href="{{ route('employee-profile', $employee->id) }}" style="text-decoration: none">
                                    <article class="talent-card">
                                        <img src="{{ asset($employee->profile_image ?? '/frontend/user-vector-img.jpg') }}"
                                             alt="Mohammed Pranto" class="talent-img" />
                                        <div class="talent-details mt-2">
                                            <h6>{{ $employee->name ?? trans('common.employee_name') }}</h6>
                                            <p>{{ $employee->profile_title ?? trans('employee.profile_title') }}</p>
                                            <span>
                                                    <i class="bi bi-geo-alt"></i>
{{--                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">--}}
{{--                                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>--}}
{{--                                                    </svg>--}}
                                                    <span class="ms-1" style="text-decoration: none">{!! $employee->address ?? trans('common.user_address') !!}</span>
                                                </span>
                                            <div class="talent-meta mt-2">

                                                <span class="p-1">{{ $employee?->employeeWorkExperiences[0]?->duration ?? 0 }}+ {{ trans('common.yrs') }}</span>
                                                <span class="p-1">{{ $employee?->employeeEducations[$employee->employeeEducations()->count() - 1]?->cgpa ?? 0.0 }} {{ trans('common.cgpa') }}</span>
                                            </div>
                                        </div>
                                    </article>
                                </a>
                            </div>



                        @endforeach


                        <!-- Talent Card 2 -->
{{--                        <div class="col-md-4 col-sm-6">--}}
{{--                            <article class="talent-card">--}}
{{--                                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Ayesha Rahman"--}}
{{--                                     class="talent-img" />--}}
{{--                                <div class="talent-details">--}}
{{--                                    <h6>Ayesha Rahman</h6>--}}
{{--                                    <p>Front-end Developer,<br />ReactJS Specialist, UI/UX Designer</p>--}}
{{--                                    <div class="talent-meta">--}}
{{--                                        <span><i class="bi bi-geo-alt-fill"></i>Gulshan, Dhaka</span>--}}
{{--                                        <span class="badge bg-light text-secondary">2+ yrs</span>--}}
{{--                                        <span class="badge bg-light text-secondary">3.80 CGPA</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </article>--}}
{{--                        </div>--}}

{{--                        <!-- Talent Card 3 -->--}}
{{--                        <div class="col-md-4 col-sm-6">--}}
{{--                            <article class="talent-card">--}}
{{--                                <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Rafiq Hossain"--}}
{{--                                     class="talent-img" />--}}
{{--                                <div class="talent-details">--}}
{{--                                    <h6>Rafiq Hossain</h6>--}}
{{--                                    <p>Backend Developer, Node.js Expert, Software Architect</p>--}}
{{--                                    <div class="talent-meta">--}}
{{--                                        <span><i class="bi bi-geo-alt-fill"></i>Dhanmondi, Dhaka</span>--}}
{{--                                        <span class="badge bg-light text-secondary">5+ yrs</span>--}}
{{--                                        <span class="badge bg-light text-secondary">3.60 CGPA</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </article>--}}
{{--                        </div>--}}
                    </div>
                </section>
            </div>
        </div>

    </main>
    <div class="modal" tabindex="-1" id="viewJobModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewJobModalTitle">{{ trans('common.view_job_post') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewJobModalBody">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .modal .job-type {margin-bottom: 10px}


        @media screen and (max-width: 529px) {
            .job-card {
                display: flex;
                flex-wrap: wrap;
                gap: 1rem;
                position: relative;
                padding-top: 2.5rem;
                justify-content: flex-start; /* Align items to left */
                align-items: flex-start; /* Align items to top */
            }

            .job-details {
                flex: 1 1 100%;
                min-width: 0;
            }

            .job-info {
                flex: 1 1 100%;
                min-width: 200px;
            }

            .job-actions {
                position: absolute;
                /*top: 1rem;*/
                top: 37px;
                right: 1rem;
                margin-left: 0;
            }
        }

        /* For very small screens */
        @media screen and (max-width: 472px) {
            .job-card {
                flex-direction: column;
                position: relative;
                padding-top: 2.5rem;
                justify-content: flex-start;
                align-items: flex-start;
            }

            .job-actions {
                position: absolute;
                /*top: 1rem;*/
                top: 37px;
                right: 1rem;
            }
        }
    </style>
@endpush

@push('script')
    <script>
        equalizeHeights('talent-card');
    </script>
    <script>
        function showJobDetails(jobId, jobTitle = 'View Job Title') {
            sendAjaxRequest('get-job-details/'+jobId+'?render=1&show_apply=0', 'GET').then(function (response) {
                // console.log(response);
                $('#viewJobModalTitle').empty().append(jobTitle);
                $('#viewJobModalBody').empty().append(response);
                $('#viewJobModal').modal('show');
            })
        }
    </script>
@endpush

