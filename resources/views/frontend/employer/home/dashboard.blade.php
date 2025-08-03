@extends('frontend.employer.master')

@section('title', 'Employer Home')

@section('body')
    <main class="dashboardContent p-4">
        <div class="container-fluid">
            <div class="row g-4">
                <!-- Left Sidebar -->
                <aside class="col-lg-3 col-md-4">
                    <!-- Find your next hire -->
                    <div class="sidebar-box hire">
                        <div class="sidebar-icon hire">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/findYour next Hire.png" alt="">
                        </div>
                        <h5 class="fw-bold">Find your next hire</h5>
                        <p class="small mb-3">More than {{ \App\Models\User::where('user_type', 'employee')->count() ?? 0 }} talents are on the network waiting for your call
                        </p>
                        <a href="{{ route('employer.my-jobs') }}" class="btn btn-dark btn-sm px-4">Post a job</a>
                    </div>

                    <!-- Delegate your tasks -->
{{--                    <div class="sidebar-box delegate mt-4">--}}
{{--                        <div class="sidebar-icon delegate">--}}
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/user.png" alt="">--}}
{{--                        </div>--}}
{{--                        <h6 class="fw-bold">Delegate your tasks</h6>--}}
{{--                        <p class="small mb-3">You can add users who can do tasks so that you don't have to do--}}
{{--                            all the work</p>--}}
{{--                        <button class="btn btn-dark btn-sm px-4">Add user</button>--}}
{{--                    </div>--}}
                    <div class="sidebar-box delegate mt-4">
                        <div class="sidebar-icon delegate">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/user.png" alt="">
                        </div>
                        <h6 class="fw-bold">Find Talent Employees</h6>
                        <p class="small mb-3 text-capitalize">search, filter and Find Best employees for your company.</p>
                        <a href="{{ route('employer.head-hunt') }}" class="btn btn-dark btn-sm px-4">Head Hunt</a>
                    </div>
                </aside>

                <!-- Main Content -->
                <section class="col-lg-9 col-md-8">
                    <!-- Open Jobs Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <h5 class="fw-bold mb-0">Open jobs</h5>
                        <a href="{{ route('employer.my-jobs') }}" class="text-decoration-none small fw-semibold d-flex align-items-center showall">
                            Show All <img src="{{ asset('/') }}frontend/employer/images/employersHome/arrow-right 1.png" alt="" class="ms-2">
                        </a>
                    </div>

                    <!-- Job Cards -->
                    <div class="row gy-3">
                        <!-- Job Card -->
                        @forelse($jobTasks as $jobTask)
                            <div class="col-12">
                                <article class="job-card">
                                    <div class="job-details flex-grow-1">
                                        <h6 class="job-title">{{ $jobTask->job_title ?? 'Senior Officer, Corporate Banking' }}</h6>
                                        <div class="job-badges d-flex flex-wrap gap-2">
                                            <span class="badge bg-light text-secondary">{{ $jobTask?->jobType?->name ?? 'Full Time' }}</span>
                                            <span class="badge bg-light text-secondary">{{ $jobTask?->jobLocationType?->name ?? 'On-site' }}</span>
{{--                                            <span class="badge bg-light text-secondary">Day Shift</span>--}}
                                        </div>
                                    </div>

                                    <div class="job-info">
                                        <div class="mb-2"><img src="{{ asset('/') }}frontend/employer/images/employersHome/postdOn.png" alt="" class="me-2">Posted on: {{ $jobTask->created_at->format('d M, Y') ?? '16 Feb, 2025' }}</div>
                                        <div class="mb-2"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Dedline.png" alt="" class="me-2">Deadline: {{ \Illuminate\Support\Carbon::parse($jobTask->deadline)->format('d M, Y') ?? '16 Feb, 2025' }}</div>
                                        <div><img src="{{ asset('/') }}frontend/employer/images/employersHome/24application.png" alt="" class="me-2"><a href="#" class="text-decoration-underline">{{ $jobTask->employeeAppliedJobs->count() ?? 0 }} Applicants</a></div>
                                    </div>

{{--                                    <div class="job-actions dropdown">--}}
{{--                                        <button class="btn btn-link p-0 text-secondary" type="button"--}}
{{--                                                data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="">--}}
{{--                                        </button>--}}
{{--                                        <ul class="dropdown-menu dropdown-menu-end">--}}
{{--                                            <li><a class="dropdown-item" href="#">Edit</a></li>--}}
{{--                                            <li>--}}
{{--                                                <form action="{{ route('employer.job-tasks.destroy', $jobTask->id) }}" method="post">--}}
{{--                                                    @csrf--}}
{{--                                                    @method('delete')--}}
{{--                                                    <button class="dropdown-item" type="submit">Delete</button>--}}
{{--                                                </form>--}}
{{--                                            </li>--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
                                </article>
                            </div>
                        @empty
                            <div class="col-12">
                                <p style="font-size: 36px;">No Published Job yet</p>
                            </div>
                        @endforelse


                        <!-- Repeat Job Cards (clone above block) -->
{{--                        <div class="col-12">--}}
{{--                            <article class="job-card">--}}
{{--                                <div class="job-details flex-grow-1">--}}
{{--                                    <h6 class="job-title">Senior Officer, Corporate Banking</h6>--}}
{{--                                    <div class="job-badges d-flex flex-wrap gap-2">--}}
{{--                                        <span class="badge bg-light text-secondary">Full Time</span>--}}
{{--                                        <span class="badge bg-light text-secondary">On-Site</span>--}}
{{--                                        <span class="badge bg-light text-secondary">Day Shift</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="job-info">--}}
{{--                                    <div class="mb-2"><img src="{{ asset('/') }}frontend/employer/images/employersHome/postdOn.png" alt="" class="me-2">Posted on: 16 Feb, 2025</div>--}}
{{--                                    <div class="mb-2"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Dedline.png" alt="" class="me-2">Deadline: 24 Mar, 2025</div>--}}
{{--                                    <div><img src="{{ asset('/') }}frontend/employer/images/employersHome/24application.png" alt="" class="me-2"><a href="#"--}}
{{--                                                                                                                                                    class="text-decoration-underline">24 Applicants</a></div>--}}
{{--                                </div>--}}

{{--                                <div class="job-actions dropdown">--}}
{{--                                    <button class="btn btn-link p-0 text-secondary" type="button"--}}
{{--                                            data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="">--}}
{{--                                    </button>--}}
{{--                                    <ul class="dropdown-menu dropdown-menu-end">--}}
{{--                                        <li><a class="dropdown-item" href="#">Edit</a></li>--}}
{{--                                        <li><a class="dropdown-item" href="#">Delete</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </article>--}}
{{--                        </div>--}}

{{--                        <div class="col-12">--}}
{{--                            <article class="job-card">--}}
{{--                                <div class="job-details flex-grow-1">--}}
{{--                                    <h6 class="job-title">Senior Officer, Corporate Banking</h6>--}}
{{--                                    <div class="job-badges d-flex flex-wrap gap-2">--}}
{{--                                        <span class="badge bg-light text-secondary">Full Time</span>--}}
{{--                                        <span class="badge bg-light text-secondary">On-Site</span>--}}
{{--                                        <span class="badge bg-light text-secondary">Day Shift</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="job-info">--}}
{{--                                    <div class="mb-2"><img src="{{ asset('/') }}frontend/employer/images/employersHome/postdOn.png" alt="" class="me-2">Posted on: 16 Feb, 2025</div>--}}
{{--                                    <div class="mb-2"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Dedline.png" alt="" class="me-2">Deadline: 24 Mar, 2025</div>--}}
{{--                                    <div><img src="{{ asset('/') }}frontend/employer/images/employersHome/24application.png" alt="" class="me-2"><a href="#"--}}
{{--                                                                                                                                                    class="text-decoration-underline">24 Applicants</a></div>--}}
{{--                                </div>--}}

{{--                                <div class="job-actions dropdown">--}}
{{--                                    <button class="btn btn-link p-0 text-secondary" type="button"--}}
{{--                                            data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="">--}}
{{--                                    </button>--}}
{{--                                    <ul class="dropdown-menu dropdown-menu-end">--}}
{{--                                        <li><a class="dropdown-item" href="#">Edit</a></li>--}}
{{--                                        <li><a class="dropdown-item" href="#">Delete</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </article>--}}
{{--                        </div>--}}


                    </div>

                    <!-- Top talent picks -->
                    <div class="d-flex justify-content-between align-items-center mt-5 mb-3 flex-wrap">
                        <h5 class="fw-bold mb-0">Top talent picks for you</h5>
                        <a href="#" class="text-decoration-none small fw-semibold d-flex align-items-center showall">
                            Explore <img src="{{ asset('/') }}frontend/employer/images/employersHome/arrow-right 1.png" alt="" class="ms-2">
                        </a>
                    </div>

                    <div class="row g-3">
                        <!-- Talent Card 1 -->
                        @foreach($employees as $employee)
                            <div class="col-md-4 col-sm-6">
                                <a href="{{ route('employee-profile', $employee->id) }}">
                                    <article class="talent-card">
                                        <img src="{{ asset($employee->profile_image ?? '/frontend/employer/images/employersHome/talent (1).png') }}"
                                             alt="Mohammed Pranto" class="talent-img" />
                                        <div class="talent-details">
                                            <h6>{{ $employee->name ?? 'Employee Name' }}</h6>
                                            <p>{{ $employee->profile_title ?? 'Employee Profile Title' }}</p>
                                            <div class="talent-meta">
                                                <span><i class="bi bi-geo-alt-fill"></i>{!! $employee->address ?? 'Employee Address' !!}</span>
                                                {{--                                            <span class="badge bg-light text-secondary">{{ $employee->exp ?? '' }}+ yrs</span>--}}
                                                {{--                                            <span class="badge bg-light text-secondary">3.50 CGPA</span>--}}
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
@endsection

