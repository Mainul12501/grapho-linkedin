@extends('frontend.employer.master')

@section('title', 'my-jobs')

@section('body')
    <!-- Dashboard Content -->
    <main class="dashboardContent p-4">
        <div class="container-fluid">
            <div class="row">

                <!-- Main Content -->
                <section class="col-12">
                    <!-- my search job top -->
                    <div class="my-jobs-section mb-4">
                        <div class="container-fluid">

                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                                <!-- Heading -->
                                <div>
                                    <h5 class="fw-bold mb-1">My Jobs</h5>
                                    <p class="text-muted small mb-0">See all your posted jobs here</p>
                                </div>
                                <!-- Post a job button -->
                                <!-- Post a job button -->
                                <button class="btn btn-warning text-dark fw-semibold rounded-3 px-4 py-2"
                                        data-bs-toggle="modal" data-bs-target="#createJobModal">
                                    Post a job
                                </button>

                            </div>

                            <!-- ✅ Mobile Search -->
                            <div class="d-block d-md-none mb-3">
                                <div class="input-group">
        <span class="input-group-text bg-white border-end-0">
          <img src="{{ asset('/') }}frontend/employer/images/employersHome/search 1.png" alt="">
        </span>
                                    <input type="text" class="form-control border-start-0" placeholder="Search jobs (mobile)" />
                                </div>
                            </div>

                            <!-- ✅ Desktop Search -->
                            <div class="d-none d-md-flex justify-content-end mb-3">
                                <div style="max-width: 320px; width: 100%;">
                                    <div class="input-group">
          <span class="input-group-text bg-white border-end-0">
          <img src="{{ asset('/') }}frontend/employer/images/employersHome/search 1.png" alt="">
          </span>
                                        <input type="text" class="form-control border-start-0" placeholder="Search jobs (desktop)" />
                                    </div>
                                </div>
                            </div>

                            <!-- Filter Buttons -->
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-dark btn-sm rounded-pill px-3">Open Jobs</button>
{{--                                <button class="btn btn-light btn-sm rounded-pill px-3 text-muted">Drafts</button>--}}
{{--                                <button class="btn btn-light btn-sm rounded-pill px-3 text-muted">Archives</button>--}}
                            </div>
                        </div>
                    </div>









                    <!-- Job Cards -->
                    <div class="row gy-3 jobCardsWrapper">
                        <!-- Job Card -->
                        @forelse($publishedJobs as $key => $publishedJob)
                            <div class="col-12">
                                <article class="job-card d-flex flex-wrap justify-content-between align-items-start gap-3">

                                    <!-- ✅ Modal Trigger Area -->
                                    <div class="job-main clickable-area flex-grow-1" data-bs-toggle="modal" data-bs-target="#jobDetailsModal" style="cursor: pointer;">
                                        <div class="job-details">
                                            <h6 class="job-title fw-semibold mb-2">{{ $publishedJob->job_title ?? 'Senior Officer, Corporate Banking' }}</h6>
                                            <div class="job-badges d-flex flex-wrap gap-2 mb-2">
                                                <span class="badge bg-light text-secondary">{{ $publishedJob?->jobType?->name ?? 'Full Time' }}</span>
                                                <span class="badge bg-light text-secondary">{{ $publishedJob?->jobLocationType?->name ?? 'On-site' }}</span>
{{--                                                <span class="badge bg-light text-secondary">Day Shift</span>--}}
                                            </div>
                                        </div>
                                        <div class="job-info text-muted small">
                                            <div class="mb-1">
                                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/postdOn.png" class="me-1" alt=""> Posted on: {{ $publishedJob->created_at->format('d M, Y') ?? '16 Feb, 2025' }}
                                            </div>
                                            <div class="mb-1">
                                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/Dedline.png" class="me-1" alt=""> Deadline: {{ \Illuminate\Support\Carbon::parse($publishedJob->deadline)->format('d M, Y') ?? '16 Feb, 2025' }}
                                            </div>
                                            <div>
                                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/24application.png" class="me-1" alt="">
                                                <a href="#" class="text-decoration-underline">24 Applicants</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ✅ Dropdown (Three Dot) -->
                                    <div class="job-actions dropdown">
                                        <button class="btn btn-link p-0 text-secondary"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="">
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
{{--                                            <li><a class="dropdown-item" href="#">Edit</a></li>--}}
                                            <li>
                                                <form action="{{ route('employer.job-tasks.destroy', $publishedJob->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item" type="submit">Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </article>
                            </div>
                        @empty
                            <div class="col-12">
                                <p style="font-size: 36px;">No Published Job yet</p>
                            </div>
                        @endforelse


{{--                        <div class="col-12">--}}
{{--                            <article class="job-card d-flex flex-wrap justify-content-between align-items-start gap-3">--}}

{{--                                <!-- ✅ Modal Trigger Area -->--}}
{{--                                <div class="job-main clickable-area flex-grow-1" data-bs-toggle="modal" data-bs-target="#jobDetailsModal" style="cursor: pointer;">--}}
{{--                                    <div class="job-details">--}}
{{--                                        <h6 class="job-title fw-semibold mb-2">Senior Officer, Corporate Banking</h6>--}}
{{--                                        <div class="job-badges d-flex flex-wrap gap-2 mb-2">--}}
{{--                                            <span class="badge bg-light text-secondary">Full Time</span>--}}
{{--                                            <span class="badge bg-light text-secondary">On-Site</span>--}}
{{--                                            <span class="badge bg-light text-secondary">Day Shift</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="job-info text-muted small">--}}
{{--                                        <div class="mb-1">--}}
{{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/postdOn.png" class="me-1" alt=""> Posted on: 16 Feb, 2025--}}
{{--                                        </div>--}}
{{--                                        <div class="mb-1">--}}
{{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/Dedline.png" class="me-1" alt=""> Deadline: 24 Mar, 2025--}}
{{--                                        </div>--}}
{{--                                        <div>--}}
{{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/24application.png" class="me-1" alt="">--}}
{{--                                            <a href="#" class="text-decoration-underline">24 Applicants</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <!-- ✅ Dropdown (Three Dot) -->--}}
{{--                                <div class="job-actions dropdown">--}}
{{--                                    <button class="btn btn-link p-0 text-secondary"--}}
{{--                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
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
{{--                            <article class="job-card d-flex flex-wrap justify-content-between align-items-start gap-3">--}}

{{--                                <!-- ✅ Modal Trigger Area -->--}}
{{--                                <div class="job-main clickable-area flex-grow-1" data-bs-toggle="modal" data-bs-target="#jobDetailsModal" style="cursor: pointer;">--}}
{{--                                    <div class="job-details">--}}
{{--                                        <h6 class="job-title fw-semibold mb-2">Senior Officer, Corporate Banking</h6>--}}
{{--                                        <div class="job-badges d-flex flex-wrap gap-2 mb-2">--}}
{{--                                            <span class="badge bg-light text-secondary">Full Time</span>--}}
{{--                                            <span class="badge bg-light text-secondary">On-Site</span>--}}
{{--                                            <span class="badge bg-light text-secondary">Day Shift</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="job-info text-muted small">--}}
{{--                                        <div class="mb-1">--}}
{{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/postdOn.png" class="me-1" alt=""> Posted on: 16 Feb, 2025--}}
{{--                                        </div>--}}
{{--                                        <div class="mb-1">--}}
{{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/Dedline.png" class="me-1" alt=""> Deadline: 24 Mar, 2025--}}
{{--                                        </div>--}}
{{--                                        <div>--}}
{{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/24application.png" class="me-1" alt="">--}}
{{--                                            <a href="#" class="text-decoration-underline">24 Applicants</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <!-- ✅ Dropdown (Three Dot) -->--}}
{{--                                <div class="job-actions dropdown">--}}
{{--                                    <button class="btn btn-link p-0 text-secondary"--}}
{{--                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
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
{{--                            <article class="job-card d-flex flex-wrap justify-content-between align-items-start gap-3">--}}

{{--                                <!-- ✅ Modal Trigger Area -->--}}
{{--                                <div class="job-main clickable-area flex-grow-1" data-bs-toggle="modal" data-bs-target="#jobDetailsModal" style="cursor: pointer;">--}}
{{--                                    <div class="job-details">--}}
{{--                                        <h6 class="job-title fw-semibold mb-2">Senior Officer, Corporate Banking</h6>--}}
{{--                                        <div class="job-badges d-flex flex-wrap gap-2 mb-2">--}}
{{--                                            <span class="badge bg-light text-secondary">Full Time</span>--}}
{{--                                            <span class="badge bg-light text-secondary">On-Site</span>--}}
{{--                                            <span class="badge bg-light text-secondary">Day Shift</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="job-info text-muted small">--}}
{{--                                        <div class="mb-1">--}}
{{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/postdOn.png" class="me-1" alt=""> Posted on: 16 Feb, 2025--}}
{{--                                        </div>--}}
{{--                                        <div class="mb-1">--}}
{{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/Dedline.png" class="me-1" alt=""> Deadline: 24 Mar, 2025--}}
{{--                                        </div>--}}
{{--                                        <div>--}}
{{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/24application.png" class="me-1" alt="">--}}
{{--                                            <a href="#" class="text-decoration-underline">24 Applicants</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <!-- ✅ Dropdown (Three Dot) -->--}}
{{--                                <div class="job-actions dropdown">--}}
{{--                                    <button class="btn btn-link p-0 text-secondary"--}}
{{--                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
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
                </section>
            </div>
        </div>

    </main>

@endsection


@section('modal')


    <!-- Job Details Modal -->
    <div class="modal fade" id="jobDetailsModal" tabindex="-1" aria-labelledby="jobDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 fw-semibold">
                        <img src="{{ asset('/') }}frontend/employee/images/employersHome/leftarrow.png" alt="" class="me-2"> Job details
                    </h6>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/Edit pencil.png" alt=""> Edit
                        </button>
                        <button class="btn btn-light btn-sm">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="">
                        </button>
                    </div>
                </div>

                <!-- Company Info -->
                <div class="mb-2">
                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/UCB logo.png" alt=""> <span class="fw-semibold">United Commercial Bank PLC</span> · <span class="text-muted">Gulshan, Dhaka</span>
                </div>

                <!-- Job Title -->
                <h4 class="fw-bold mb-3">Senior Officer, Corporate Banking</h4>

                <!-- Tags -->
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <span class="badge bg-light text-dark fw-medium">Full Time</span>
                    <span class="badge bg-light text-dark fw-medium">On-Site</span>
                    <span class="badge bg-light text-dark fw-medium">Day Shift</span>
                </div>

                <!-- About -->
                <h6 class="fw-semibold mb-2">About UCB</h6>
                <p class="text-muted" style="line-height: 1.6;">
                    Be part of the world's most successful, purpose-led business. Work with brands that are well-loved around the world, that improve the lives of our consumers and the communities around us. We promote innovation, big and small, to make our business win and grow; and we believe in business as a force for good. Unleash your curiosity, challenge ideas and disrupt processes; use your energy to make this happen.
                    <br><br>
                    Our brilliant business leaders and colleagues provide mentorship and inspiration, so you can be at your best. Every day, nine out of ten Indian households use our products to feel good, look good and get more out of life – giving us a unique opportunity to build a brighter future.
                </p>

                <!-- Requirements -->
                <h6 class="fw-semibold mt-4 mb-2">Job Requirements</h6>
                <ul class="text-muted" style="line-height: 1.8;">
                    <li>Analyse internal and external data to identify geography-wise issues/opportunities and action upon them.</li>
                    <li>Work with media teams and other stakeholders to deploy effective communication for Surf across traditional and new-age media platforms.</li>
                </ul>
            </div>
        </div>
    </div>





    <!-- Create Job Modal -->
    <!-- Create Job Modal -->
    <div class="modal fade" id="createJobModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-4 rounded-4">

                <form action="{{ route('employer.job-tasks.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- STEP 1 -->
                    <div class="stepOne">
                        <!-- Modal Header -->
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt="" class="me-2" style="cursor: default;">
                            <h5 class="mb-0 fw-semibold">Create a job</h5>
                        </div>

                        <!-- Job Title -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Job title</label>
                            <input type="text" class="form-control" name="job_title" placeholder="Senior Officer, Corporate Banking">
                        </div>

                        <!-- Job Type -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Job type</label>
                            <div class="btn-group d-flex flex-wrap gap-2" role="group" aria-label="Job type">
                                @foreach($jobTypes as $jobTypesKey => $jobType)
                                    <input type="radio" class="btn-check" name="job_type_id" id="jobType{{ $jobTypesKey }}" value="{{ $jobType->id }}" autocomplete="off" {{ $jobTypesKey == 0 ? 'checked' : '' }}>
                                    <label class="btn btn-outline-warning" for="jobType{{ $jobTypesKey }}">{{ $jobType->name ?? 'jt' }}</label>
                                @endforeach


{{--                                <input type="radio" class="btn-check" name="jobType" id="parttime" value="Part time" autocomplete="off">--}}
{{--                                <label class="btn btn-outline-warning" for="parttime">Part time</label>--}}

{{--                                <input type="radio" class="btn-check" name="jobType" id="internship" value="Internship" autocomplete="off">--}}
{{--                                <label class="btn btn-outline-warning" for="internship">Internship</label>--}}

{{--                                <input type="radio" class="btn-check" name="jobType" id="freelance" value="Freelance" autocomplete="off">--}}
{{--                                <label class="btn btn-outline-warning" for="freelance">Freelance</label>--}}
                            </div>
                        </div>

                        <!-- Job Location -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Job location</label>
                            <div class="btn-group d-flex flex-wrap gap-2" role="group" aria-label="Job location">
                                @foreach($jobLocations as $jobLocationKey => $jobLocation)
                                    <input type="radio" class="btn-check" name="job_location_type_id" id="jobLocation{{ $jobLocationKey }}" value="{{ $jobLocation->id }}" {{ $jobLocationKey == 0 ? 'checked' : '' }} autocomplete="off">
                                    <label class="btn btn-outline-warning" for="jobLocation{{ $jobLocationKey }}">{{ $jobLocation->name ?? 'jl' }}</label>
                                @endforeach

{{--                                <input type="radio" class="btn-check" name="jobLocation" id="hybrid" value="Hybrid" autocomplete="off" checked>--}}
{{--                                <label class="btn btn-outline-warning" for="hybrid">Hybrid</label>--}}

{{--                                <input type="radio" class="btn-check" name="jobLocation" id="remote" value="Remote" autocomplete="off">--}}
{{--                                <label class="btn btn-outline-warning" for="remote">Remote</label>--}}
                            </div>
                        </div>

                        <!-- Footer Buttons -->
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-outline-dark px-4 py-2 rounded-3" data-bs-dismiss="modal">Cancel</button>
                            <button id="continueToStep2" type="button" class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-3">Continue</button>
                        </div>
                    </div>

                    <!-- STEP 2 -->
                    <div class="jobModalForPost d-none stepTwo" style="background-color: #f2f2f4;">
                        <!-- Container and header -->
                        <div class="container-fluid py-3 border-bottom mb-4 bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2" id="backToStepOne" style="cursor:pointer">
                                    <img src="{{ asset('/') }}frontend/employer/images/authentication images/leftArrow.png" alt="Back" style="width:20px; height:20px;">
                                    <h5 class="fw-bold mb-0">Create a job</h5>
                                </div>
                                <!-- Button triggers modal -->
{{--                                <button type="button" class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#jobDetailsModal">--}}
{{--                                    Review & Post--}}
{{--                                </button>--}}
                                <button type="submit" class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-3" {{--data-bs-toggle="modal" data-bs-target="#jobDetailsModal"--}}>
                                    Post Job
                                </button>
                            </div>
                        </div>

                        <!-- Your provided step 2 content starts here -->
                        <div style="background-color: #f2f2f4;" class="jobModalForPost">
                            <!-- Container and header -->



                            <!-- Main Job Info Card -->
                            <div class="container mb-4">
                                <div class="bg-white rounded-4 p-4 shadow-sm">
                                    <div class="d-flex justify-content-between flex-wrap gap-3">
                                        <div>
                                            <h5 class="fw-semibold mb-2"><span id="formJobTitle">IT Support, Corporate Banking</span></h5>
                                            <div class="d-flex flex-wrap gap-2">
                                                <span class="badge bg-light text-dark"><span id="jobJobType">Full Time</span></span>
                                                <span class="badge bg-light text-dark"><span id="jobjobLocationType">Hybrid</span></span>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="#" class="text-decoration-none text-muted return-to-first-part"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Edit pencil.png" alt=""> Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Experience Card -->
                            <div class="container mb-4">
                                <div class="bg-white rounded-4 p-4 shadow-sm">
                                    <h6 class="fw-semibold mb-3">Required years of experience</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        <input type="radio" class="btn-check" name="required_experience" id="exp-any" value="Any" autocomplete="off" checked>
                                        <label class="btn btn-outline-warning" for="exp-any">Any</label>

                                        <input type="radio" class="btn-check" name="required_experience" id="exp-1to3" value="1–3 yrs" autocomplete="off">
                                        <label class="btn btn-outline-warning" for="exp-1to3">1–3 yrs</label>

                                        <input type="radio" class="btn-check" name="required_experience" id="exp-0" value="0" autocomplete="off">
                                        <label class="btn btn-outline-warning" for="exp-0">N/A</label>

{{--                                        <input type="radio" class="btn-check" name="required_experience" id="exp-3to5" value="3–5 yrs" autocomplete="off">--}}
{{--                                        <label class="btn btn-outline-warning" for="exp-3to5">3–5 yrs</label>--}}

{{--                                        <input type="radio" class="btn-check" name="required_experience" id="exp-5plus" value="5+ yrs" autocomplete="off">--}}
{{--                                        <label class="btn btn-outline-warning" for="exp-5plus">5+ yrs</label>--}}
{{--                                        <select name="required_experience" class="form-control" id="">--}}
{{--                                            <option value="1">1 Years</option>--}}
{{--                                            <option value="3">3 Years</option>--}}
{{--                                            <option value="5">5 Years</option>--}}
{{--                                        </select>--}}
                                    </div>
                                </div>
                            </div>


                            <!-- University Preference -->
                            <div class="container mb-4">
                                <div class="bg-white rounded-4 p-4 shadow-sm">
                                    <h6 class="fw-semibold mb-3">University preference</h6>
{{--                                    <input type="text" class="form-control mb-3" name="" placeholder="Search universities">--}}
                                    <select name="university_preference[]" id="select2-div" class=" select2"  multiple="multiple">

                                        @foreach($universityNames as $universityNameKey => $universityName)
                                            <option value="{{ $universityName->id }}">{{ $universityName->name ?? 'un' }}</option>
                                        @endforeach
                                    </select>
{{--                                    <div class="d-flex flex-wrap gap-2">--}}
{{--                                        <span class="badge bg-light text-dark">North South University <img src="{{ asset('/') }}frontend/employer/images/employersHome/crossCirle.png" alt=""></span>--}}
{{--                                        <span class="badge bg-light text-dark">IBA, Dhaka University <img src="{{ asset('/') }}frontend/employer/images/employersHome/crossCirle.png" alt=""></span>--}}
{{--                                    </div>--}}
                                </div>
                            </div>

                            <!-- Field of Study -->
                            <div class="container mb-4">
                                <div class="bg-white rounded-4 p-4 shadow-sm">
                                    <h6 class="fw-semibold mb-3">Field of study</h6>
{{--                                    <input type="text" class="form-control mb-3" placeholder="Search field of study">--}}
                                    <select name="field_of_study_preference[]" id="" class=" select2" multiple="multiple">
                                        @foreach($fieldOfStudies as $fieldOfStudyKey => $fieldOfStudy)
                                            <option value="{{ $fieldOfStudy->id }}">{{ $fieldOfStudy->field_name ?? 'un' }}</option>
                                        @endforeach
                                    </select>
{{--                                    <div class="d-flex flex-wrap gap-2">--}}
{{--                                        <span class="badge bg-light text-dark">Business <img src="{{ asset('/') }}frontend/employer/images/employersHome/crossCirle.png" alt=""></span>--}}
{{--                                        <span class="badge bg-light text-dark">Marketing <img src="{{ asset('/') }}frontend/employer/images/employersHome/crossCirle.png" alt=""></span>--}}
{{--                                    </div>--}}
                                </div>
                            </div>

                            <!-- CGPA Preference -->
                            <div class="container mb-4">
                                <div class="bg-white rounded-4 p-4 shadow-sm">
                                    <h6 class="fw-semibold mb-3">CGPA preference</h6>
                                    <input type="text" name="cgpa" class="form-control" placeholder="e.g. 3.50 to 3.90">
                                </div>
                            </div>

                            <!-- Salary Section -->
                            <div class="container mb-4">
                                <div class="bg-white rounded-4 p-4 shadow-sm">
                                    <h6 class="fw-semibold mb-3">Salary</h6>
                                    <ul class="nav nav-tabs mb-3" id="salaryTab" role="tablist">
                                        <li class="nav-item"><a class="nav-link active salary-type" data-value="monthly" data-bs-toggle="tab" href="#">Monthly</a></li>
                                        <li class="nav-item"><a class="nav-link salary-type" data-value="hourly" data-bs-toggle="tab" href="#">Hourly</a></li>
                                        <li class="nav-item"><a class="nav-link salary-type" data-value="yearly" data-bs-toggle="tab" href="#">Yearly</a></li>
                                        <li class="nav-item"><a class="nav-link salary-type" data-value="fixed" data-bs-toggle="tab" href="#">Fixed amount</a></li>
                                    </ul>
                                    <input type="hidden" name="job_pref_salary_payment_type" class="job_pref_salary_payment_type" value="monthly">
                                    <input type="text" name="salary_amount" class="form-control mb-2" placeholder="BDT 50,000">
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="rangeCheck">--}}
{{--                                        <label class="form-check-label text-muted" for="rangeCheck">Use salary range</label>--}}
{{--                                    </div>--}}
                                </div>
                            </div>

                            <!-- Job Description -->
                            <div class="container mb-4">
                                <div class="bg-white rounded-4 p-4 shadow-sm">
                                    <h6 class="fw-semibold mb-3">Job description & Key responsibilities</h6>
                                    <textarea class="form-control" id="summernote" name="description" rows="15" placeholder="Tell more about the job - specifications & responsibilities..."></textarea>
                                </div>
                            </div>

                            <!-- Application Deadline -->
                            <div class="container mb-4">
                                <div class="bg-white rounded-4 p-4 shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-semibold mb-0">Application deadline</h6>
{{--                                        <div class="form-check form-switch mb-0">--}}
{{--                                            <input class="form-check-input" type="checkbox" role="switch" id="deadlineToggle" checked>--}}
{{--                                        </div>--}}
                                    </div>
                                    <div>
                                        <div class="input-group rounded-3 border border-secondary-subtle">
                                            <input type="date" name="deadline" class="form-control" value="" />
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- Skills Section -->
                            <div class="container mb-4">
                                <div class="bg-white rounded-4 p-4 shadow-sm">
                                    <h6 class="fw-semibold mb-3">Skill requirements</h6>
                                    <div class="<!--d-flex flex-wrap gap-2-->">
{{--                                        <span class="badge bg-light text-dark">Sales</span>--}}
{{--                                        <span class="badge bg-dark text-white">Management</span>--}}
{{--                                        <span class="badge bg-light text-dark">Banking</span>--}}
{{--                                        <span class="badge bg-light text-dark">Marketing</span>--}}
{{--                                        <span class="badge bg-light text-dark">Customer Service</span>--}}
{{--                                        <span class="badge bg-light text-dark">Product Development</span>--}}
{{--                                        <span class="badge bg-light text-dark">Human Resources</span>--}}
{{--                                        <span class="badge bg-light text-dark">IT Support</span>--}}
{{--                                        <span class="badge bg-light text-dark">Finance</span>--}}

                                        <nav>
                                            <div class="nav nav-pills" id="nav-tab" role="tablist">
                                                @foreach($skillCategories as $skillCategoryKey =>$skillCategory)
                                                    <button class="nav-link {{ $skillCategoryKey == 0 ? 'active' : '' }}" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#skillCategory{{ $skillCategoryKey }}" type="button" role="tab" aria-controls="nav-home" aria-selected="true">{{ $skillCategory->category_name }}</button>
                                                @endforeach

{{--                                                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Skill </button>--}}
                                            </div>
                                        </nav>
                                        <div class="tab-content mt-3" id="nav-tabContent">
                                            @foreach($skillCategories as $x => $singleSkillCategory)
                                                <div class="tab-pane fade {{ $x == 0 ? 'show active' : '' }}" id="skillCategory{{$x}}" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                                    @foreach($singleSkillCategory->publishedSkills as $skillKey => $skill)
                                                        <input type="radio" class="btn-check" name="required_skills[]" id="skill{{ $skillKey }}" value="{{ $skill->id }}" autocomplete="off">
                                                        <label class="btn btn-outline-warning" for="skill{{ $skillKey }}">{{ $skill->skill_name ?? 'sn' }}</label>
                                                    @endforeach

{{--                                                    <input type="radio" class="btn-check" name="required_experience" id="exp-3to5q" value="3–5 yrs" autocomplete="off">--}}
{{--                                                    <label class="btn btn-outline-warning" for="exp-3to5q">3–5 yrs</label>--}}

                                                </div>
                                            @endforeach

{{--                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">--}}

{{--                                                <input type="radio" class="btn-check" name="required_experience" id="exp-3to5" value="3–5 yrs" autocomplete="off">--}}
{{--                                                <label class="btn btn-outline-warning" for="exp-3to5">3–5 yrs</label>--}}

{{--                                                <input type="radio" class="btn-check" name="required_experience" id="exp-3to5x" value="3–5 yrs" autocomplete="off">--}}
{{--                                                <label class="btn btn-outline-warning" for="exp-3to5x">3–5 yrs</label>--}}

{{--                                            </div>--}}
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <!-- Filter Tags -->
{{--                            <div class="container mb-5">--}}
{{--                                <div class="bg-white rounded-4 p-4 shadow-sm">--}}
{{--                                    <h6 class="fw-semibold mb-3">What are you looking for? <span class="text-muted">(Select max 3)</span></h6>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="school">--}}
{{--                                        <label class="form-check-label" for="school">School/College</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="university" checked>--}}
{{--                                        <label class="form-check-label" for="university">University</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="cgpa" checked>--}}
{{--                                        <label class="form-check-label" for="cgpa">CGPA</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="location">--}}
{{--                                        <label class="form-check-label" for="location">Location</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="experience">--}}
{{--                                        <label class="form-check-label" for="experience">Job experience</label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                        </div>








                        <!-- Detailed Job Review Modal -->
                        <div class="modal fade" id="jobDetailsModal" tabindex="-1" aria-labelledby="jobDetailsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-4 p-4">

                                    <!-- Header with back arrow and buttons -->
                                    <div class="d-flex justify-content-between align-items-center mb-4" style="padding: 16px 24px; background: #fff; border-radius: 16px;">
                                        <h6 class="mb-0 fw-semibold d-flex align-items-center gap-2" style="font-weight: 600; font-size: 1rem; cursor: pointer;">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt="Back" style="width: 24px; height: 24px;">
                                            Review job details
                                        </h6>
                                        <button id="modalPostJobBtn" class="btn btn-warning fw-bold" style="padding: 8px 20px; border-radius: 12px; font-weight: 700; font-size: 1rem;">
                                            Post job
                                        </button>

                                    </div>

                                    <!-- Snackbar / Toast -->
                                    <div id="snackbar" class="snackbar">
                                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/toasterTik.png" alt="Success" class="snackbar-icon">
                                        <span class="snackbar-text">You posted the job: <b>Senior Officer, Corporate Banking</b></span>
                                        <button id="snackbar-close" class="snackbar-close"><img src="{{ asset('/') }}frontend/employer/images/employersHome/ToasterCross.png" alt=""></button>
                                    </div>

                                    <!-- Snackbar / Toast -->


                                    <!-- Company Info -->
                                    <div class="mb-2 d-flex align-items-center gap-2">
                                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/UCB logo.png" alt="UCB Logo" style="height:24px;">
                                        <span class="fw-semibold">United Commercial Bank PLC</span>
                                        <span class="text-muted">&middot; Gulshan, Dhaka</span>
                                    </div>

                                    <!-- Job Title -->
                                    <h4 class="fw-bold mb-3">Senior Officer, Corporate Banking</h4>

                                    <!-- Tags -->
                                    <div class="d-flex flex-wrap gap-2 mb-4">
                                        <span class="badge bg-light text-dark fw-medium">Full Time</span>
                                        <span class="badge bg-light text-dark fw-medium">On-Site</span>
                                        <span class="badge bg-light text-dark fw-medium">Day Shift</span>
                                    </div>

                                    <!-- About Section -->
                                    <h6 class="fw-semibold mb-2">About UCB</h6>
                                    <p class="text-muted" style="line-height: 1.6;">
                                        Be part of the world's most successful, purpose-led business. Work with brands that are well-loved around the world, that improve the lives of our consumers and the communities around us. We promote innovation, big and small, to make our business win and grow; and we believe in business as a force for good. Unleash your curiosity, challenge ideas and disrupt processes; use your energy to make this happen.
                                        <br><br>
                                        Our brilliant business leaders and colleagues provide mentorship and inspiration, so you can be at your best. Every day, nine out of ten Indian households use our products to feel good, look good and get more out of life – giving us a unique opportunity to build a brighter future.
                                    </p>

                                    <!-- Job Requirements -->
                                    <h6 class="fw-semibold mt-4 mb-2">Job Requirements</h6>
                                    <ul class="text-muted" style="line-height: 1.8;">
                                        <li>Analyse internal and external data to identify geography-wise issues/opportunities and action upon them.</li>
                                        <li>Work with media teams and other stakeholders to deploy effective communication for Surf across traditional and new-age media platforms.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <!-- For brevity not repeating entire step 2 HTML, will render in browser from provided -->

                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@push('style')
    <style>
        .select2-container {width: 100%!important;}
    </style>
@endpush

@push('script')

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
        integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
        integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    ></script>
    <script>
        $(function () {
            $(".select2").selectize();
        });
    </script>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

{{--    </style>--}}
    <script >
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 200
            });

        });
        $(document).on('click', '.salary-type', function () {
            setInputValueByClassName($(this), 'job_pref_salary_payment_type', 'data-value');
        })
        $(document).on('click', '.return-to-first-part', function () {
            $('.stepTwo').addClass('d-none');
            $('.stepOne').removeClass('d-none');
        })
    </script>
    <script>
        document.getElementById('continueToStep2')?.addEventListener('click', function () {
            $('#formJobTitle').text($('input[name="job_title"]').val());
            $('#jobJobType').text($('label[for="'+$('input[name="job_type_id"]').attr('id')+'"]').text());
            $('#jobjobLocationType').text($('label[for="'+$('input[name="job_location_type_id"]').attr('id')+'"]').text());
            document.querySelector('#createJobModal .stepOne').classList.add('d-none');
            document.querySelector('#createJobModal .jobModalForPost').classList.remove('d-none');
            $('.stepTwo').removeClass('d-none');
        });

        document.getElementById('backToStepOne')?.addEventListener('click', function () {
            document.querySelector('#createJobModal .stepOne').classList.remove('d-none');
            document.querySelector('#createJobModal .jobModalForPost').classList.add('d-none');
        });
    </script>
@endpush
