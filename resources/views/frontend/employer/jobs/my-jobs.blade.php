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
                                    <h5 class="fw-bold mb-1 f-s-28">My Jobs</h5>
                                    <p class="text-muted small mb-0">See all your posted jobs here</p>
                                </div>
                                <!-- Post a job button -->
                                <!-- Post a job button -->
                                <button class="btn btn-warning text-dark fw-semibold rounded-3 px-4 py-2"
                                        data-bs-toggle="modal" data-bs-target="#createJobModal">
                                    Post a job
                                </button>
{{--                                <a href="{{ route('employer.job-tasks.create') }}"  class="btn btn-warning text-dark fw-semibold rounded-3 px-4 py-2">Post a job</a>--}}

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
                            <div class="d-none d-md-flex justify-content-between align-items-center gap-3 mb-3 flex-wrap">
                                <!-- Filter Buttons (Left Side) -->
                                <div id="t2" class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('employer.my-jobs', ['job_status' => 'open']) }}"><button class="btn {{  request('job_status') != 'closed' ? 'btn-dark' : 'btn-light' }} btn-sm rounded-pill px-3">Open Jobs</button></a>
                                    <a href="{{ route('employer.my-jobs', ['job_status' => 'closed']) }}"><button class="btn  {{ request('job_status') && request('job_status') == 'closed' ? 'btn-dark text-white' : 'btn-light text-muted' }} btn-sm rounded-pill px-3 ">Closed Jobs</button></a>
                                </div>

                                <!-- Desktop Search (Right Side) -->
                                <div id="t1" style="max-width: 320px; width: 100%;">
                                    <form action="" id="searchForm">
                                        <div class="input-group">
                                          <span class="input-group-text bg-white border-end-0" onclick="document.getElementById('searchForm').submit();">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/search 1.png" alt="">
                                          </span>
                                            <input type="text" class="form-control border-start-0" name="search_text" placeholder="Search jobs " />
                                        </div>
                                    </form>
                                </div>
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
                                    <div class="job-main clickable-area  show-job-details" data-job-id="{{ $publishedJob->id }}" {{--data-bs-toggle="modal" data-bs-target="#jobDetailsModal"--}} style="cursor: pointer;">
                                        <div class="job-details">
                                            <h6 class="job-title fw-semibold mb-2">{{ $publishedJob->job_title ?? 'Job Title' }}</h6>
                                            <div class="job-badges d-flex flex-wrap gap-2 mb-2">
                                                <span class="badge bg-light text-secondary">{{ $publishedJob?->jobType?->name ?? 'Job Type' }}</span>
                                                <span class="badge bg-light text-secondary">{{ $publishedJob?->jobLocationType?->name ?? 'JobLocationType' }}</span>
{{--                                                <span class="badge bg-light text-secondary">Day Shift</span>--}}
                                            </div>
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
                                            <a href="{{ route('employer.my-job-applicants', ['jobTask' => $publishedJob->id]) }}" class="text-decoration-underline">{{ $publishedJob->employeeAppliedJobs->count() ?? 0 }} Applicants</a>
                                        </div>
                                    </div>

                                    <!-- ✅ Dropdown (Three Dot) -->
                                    <div class="job-actions dropdown">
                                        <button class="btn btn-link p-0 text-secondary"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="">
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item edit-job" href="javascript:void(0)" data-job-id="{{ $publishedJob->id }}">Edit</a></li>
{{--                                            <li><a class="dropdown-item " href="{{ route('employer.job-tasks.edit', $publishedJob->id) }}" data-job-id="{{ $publishedJob->id }}">Edit</a></li>--}}
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
                            <div class="job-card "  style="min-height: 570px; justify-content: center!important;">
                                <div class="row">
                                    <div class="col-md-11 mx-auto">
                                        <div class="card card-body border-0">
                                            <div class="d-flex text-center align-content-center">
                                                <p>
                                                    <img src="{{ asset('/frontend/think.svg') }}" alt="empty-img" class="" style="max-height: 300px; min-width: 300px">
                                                </p>
                                                <p class="text-danger text-center f-s-20 fw-bold p-5" style="margin-top: 10px">Sorry!!
                                                    <br> No Available job Found.</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
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
                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt="" class="me-2"> Job details
                    </h6>
                    <div class="d-flex gap-2">
{{--                        <button class="btn btn-outline-secondary btn-sm">--}}
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/Edit pencil.png" alt=""> Edit--}}
{{--                        </button>--}}
                        <button class="btn btn-light btn-sm btn-close" data-bs-dismiss="modal">
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="">--}}
                        </button>
                    </div>
                </div>

                <div id="printJobDetailsHere">
                    <!-- Company Info -->
                    <div class="mb-2">
                        <img id="detailsCompanyLogo" src="{{ asset('/') }}frontend/employer/images/employersHome/UCB logo.png" alt="company logo" style="height: 30px; border-radius: 50%">
                        <span class="fw-semibold" id="detailsCompanyName">United Commercial Bank PLC</span> ·
                        <span class="text-muted" id="detailsCompanyAddress">Gulshan, Dhaka</span>
                    </div>

                    <!-- Job Title -->
                    <h4 class="fw-bold mb-3" id="detailsJobTitle">Senior Officer, Corporate Banking</h4>

                    <!-- Tags -->
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="badge bg-light text-dark fw-medium" id="detailsJobType">Full Time</span>
                        <span class="badge bg-light text-dark fw-medium" id="detailsJobLocationType">On-Site</span>
                        {{--                    <span class="badge bg-light text-dark fw-medium">Day Shift</span>--}}
                    </div>

                    <!-- About -->
                    <h6 class="fw-semibold mb-2" >About <span id="detailsAboutCompanyName">UCB</span></h6>
                    <p class="text-muted" id="detailsCompanyOverview" style="line-height: 1.6;">
                        Be part of the world's most successful, purpose-led business. Work with brands that are well-loved around the world, that improve the lives of our consumers and the communities around us. We promote innovation, big and small, to make our business win and grow; and we believe in business as a force for good. Unleash your curiosity, challenge ideas and disrupt processes; use your energy to make this happen.
                        <br><br>
                        Our brilliant business leaders and colleagues provide mentorship and inspiration, so you can be at your best. Every day, nine out of ten Indian households use our products to feel good, look good and get more out of life – giving us a unique opportunity to build a brighter future.
                    </p>

                    <!-- Requirements -->
                    <h6 class="fw-semibold mt-4 mb-2">Job Requirements</h6>
                    <ul class="text-muted" id="detailsJobDescription" style="line-height: 1.8;">
                        <li>Analyse internal and external data to identify geography-wise issues/opportunities and action upon them.</li>
                        <li>Work with media teams and other stakeholders to deploy effective communication for Surf across traditional and new-age media platforms.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <!-- Create Job Modal -->
    <div class="modal fade" id="createJobModal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content p-4 rounded-4">
                <div style="display: none">
                    <input type="text" id="companyLogo" value="{{ asset(auth()->user()?->employerCompany?->logo ?? '/frontend/company-vector.jpg') }}">
                    <input type="text" id="companyName" value="{{ auth()->user()?->employerCompany?->name ?? 'Company Name' }}">
                    <input type="text" id="companyAddress" value="{{ auth()->user()?->employerCompany?->address ?? 'Company Address' }}">
                    <input type="text" id="companyOverview" value="{{ auth()->user()?->employerCompany?->company_overview ?? 'Company Overview' }}">
                </div>
                <form action="{{ route('employer.job-tasks.store') }}" id="jobCreateForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- STEP 1 -->
                    <div class="wizard-step stepOne">
                        <!-- Modal Header -->
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt="" class="me-2" style="cursor: default;">
                            <h5 class="mb-0 fw-semibold">Post job</h5>
                            <button type="button" class="btn-close position-absolute" style="right: 4%;" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Job Title -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Job title</label>
                            <input type="text" class="form-control" required name="job_title" placeholder="Job Title here">
                        </div>

                        <!-- Job Type -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Job type</label>
                            <div class="pill-group" role="group" aria-label="Job type">
                                @foreach($jobTypes as $jobTypesKey => $jobType)
                                    <input type="radio" class="btn-check" name="job_type_id" id="jobType{{ $jobTypesKey }}" value="{{ $jobType->id }}" {{ $jobTypesKey == 0 ? 'checked' : '' }}>
                                    <label class="btn-pill" for="jobType{{ $jobTypesKey }}">{{ $jobType->name ?? 'jt' }}</label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Job Location -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Job location</label>
                            <div class="pill-group">
                                @foreach($jobLocations as $jobLocationKey => $jobLocation)
                                    <input type="radio" class="btn-check" name="job_location_type_id" id="jobLocation{{ $jobLocationKey }}" value="{{ $jobLocation->id }}" {{ $jobLocationKey == 0 ? 'checked' : '' }} autocomplete="off">
                                    <label class="btn-pill" for="jobLocation{{ $jobLocationKey }}">{{ $jobLocation->name ?? 'jl' }}</label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Footer Buttons -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <button class="btn btn-outline-dark px-4 py-2 rounded-3" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button id="continueToStep2" type="button" class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-3">Continue</button>
                        </div>
                    </div>

                    <!-- STEP 2 -->
                    <div class="jobModalForPost wizard-step d-none stepTwo" style="background-color: #f2f2f4;">
                        <!-- Container and header -->
                        <div class="container-fluid py-3 border-bottom mb-4 bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2 backToStepOne" id="backToStepOne" style="cursor:pointer">
                                    <img src="{{ asset('/') }}frontend/employee/images/authentication images/leftArrow.png" alt="Back" style="width:20px; height:20px;">
                                    <h5 class="fw-bold mb-0">Post job</h5>
                                </div>
                                <!-- Button triggers modal -->
{{--                                <button type="button" class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-3 show-review-btn" data-modal-id="createJobModal" --}}{{--data-bs-toggle="modal" data-bs-target="#jobDetailsModal"--}}{{-->--}}
{{--                                    Review & Post--}}
{{--                                </button>--}}
{{--                                <button type="submit" class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#jobDetailsModal">--}}
{{--                                    Post Job--}}
{{--                                </button>--}}
                            </div>
                        </div>

                        <!-- Your provided step 2 content starts here -->
                        <div style="background-color: #f2f2f4;" class="jobModalForPost">
                            <!-- Container and header -->



                            <!-- Main Job Info Card -->
                            <div class="container px-0 border-bottom">
                                <div class="bg-white p-4 shadow-sm" style="border-radius: 0px">
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
                            <div class="container px-0 border-bottom">
                                <div class="bg-white  p-4 shadow-sm" style="border-radius: 0px">
                                    <h6 class="fw-semibold mb-3">Required years of experience</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        <input type="radio" class="btn-check" name="required_experience" id="exp-any" value="Any" autocomplete="off" checked>
                                        <label class="btn btn-outline-warning" style="color: black" for="exp-any">Any</label>

                                        <input type="radio" class="btn-check" name="required_experience" id="exp-1to3" value="1–3 yrs" autocomplete="off">
                                        <label class="btn btn-outline-warning" style="color: black" for="exp-1to3">1–3 yrs</label>

                                        <input type="radio" class="btn-check" name="required_experience" id="exp-0" value="0" autocomplete="off">
                                        <label class="btn btn-outline-warning" style="color: black" for="exp-0">N/A</label>

                                        <input type="radio" class="btn-check" name="required_experience" id="custom" value="custom" autocomplete="off">
                                        <label id="showCustomExperienceField" style="color: black" class="btn btn-outline-warning" for="custom">Custom</label>
                                        <span id="customExperienceField" style="display: none">
                                                            <input type="text" style="width: 60px; background-color: #f8ffbe; color: black!important;" class="btn btn-outline-primary " name="exp_range_start"> to <input type="text" style="width: 60px; background-color: #f8ffbe; color: black!important;" class="btn btn-outline-primary " name="exp_range_end"> Years
                                                        </span>

                                    </div>
                                </div>
                            </div>


                            <!-- Industry -->
                            <div class="container px-0 border-bottom">
                                <div class="bg-white  p-4 shadow-sm" style="border-radius: 0px">
                                    <h6 class="fw-semibold mb-3">Industry</h6>
{{--                                    <input type="text" class="form-control mb-3" name="" placeholder="Search universities">--}}
                                    <select name="industry_id" id="industryId" class="form-control select2 industryId"  >

                                        @foreach($industries as $industryKey => $industry)
                                            <option value="{{ $industry->id }}">{{ $industry->name ?? 'un' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- University Preference -->
                            <div class="container px-0 border-bottom">
                                <div class="bg-white  p-4 shadow-sm" style="border-radius: 0px">
                                    <h6 class="fw-semibold mb-3">University preference</h6>
{{--                                    <input type="text" class="form-control mb-3" name="" placeholder="Search universities">--}}
                                    <select name="university_preference[]" id="select2-div" class=" select2"  multiple="multiple">

                                        @foreach($universityNames as $universityNameKey => $universityName)
                                            <option value="{{ $universityName->id }}">{{ $universityName->name ?? 'un' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Field of Study -->
                            <div class="container px-0 border-bottom">
                                <div class="bg-white  p-4 shadow-sm" style="border-radius: 0px">
                                    <h6 class="fw-semibold mb-3">Field of study preference</h6>
{{--                                    <input type="text" class="form-control mb-3" placeholder="Search field of study">--}}
                                    <select name="field_of_study_preference[]" id="" class=" select2" multiple="multiple">
                                        @foreach($fieldOfStudies as $fieldOfStudyKey => $fieldOfStudy)
                                            <option value="{{ $fieldOfStudy->id }}">{{ $fieldOfStudy->field_name ?? 'un' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- CGPA Preference -->
                            <div class="container px-0 border-bottom">
                                <div class="bg-white  p-4 shadow-sm" style="border-radius: 0px">
                                    <h6 class="fw-semibold mb-3">CGPA preference</h6>
                                    <input type="text" name="cgpa" class="form-control" placeholder="e.g. 3.50 to 3.90">
                                </div>
                            </div>

                            <!-- Gender Preference -->
                            <div class="container px-0 border-bottom">
                                <div class="bg-white p-4 shadow-sm" style="border-radius: 0px">
                                    <h6 class="fw-semibold mb-3">Gender preference</h6>
                                    <select name="gender" id="" class="form-control select2">
                                        <option value="" disabled selected>Select a gender</option>
                                        <option value="male" >Male</option>
                                        <option value="female" >Female</option>
                                        <option value="all" >All</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Salary Section -->
                            <div class="container px-0 border-bottom">
                                <div class="bg-white  p-4 shadow-sm" style="border-radius: 0px">
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
                            <div class="container px-0 border-bottom">
                                <div class="bg-white p-4 shadow-sm" style="border-radius: 0px">
                                    <h6 class="fw-semibold mb-3">Job description & Key responsibilities</h6>
                                    <textarea class="form-control" id="summernote" name="description" rows="15" placeholder="Tell more about the job - specifications & responsibilities..."></textarea>
                                </div>
                            </div>

                            <!-- Application Deadline -->
                            <div class="container px-0 border-bottom">
                                <div class="bg-white p-4 shadow-sm" style="border-radius: 0px">
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
                            <div class="container px-0 border-bottom">
                                <div class="bg-white  p-4 shadow-sm" style="border-radius: 0px">
                                    <h6 class="fw-semibold mb-3">Skill requirements</h6>
                                    <div class="<!--d-flex flex-wrap gap-2-->">
{{--                                        <span class="badge bg-light text-dark">Sales</span>--}}
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
                                                <div class="tab-pane fade {{ $x == 0 ? 'show active' : '' }}" id="skillCategory{{$x}}" >
                                                    @foreach($singleSkillCategory->publishedSkills as $skillKey => $skill)
                                                        <input type="checkbox" class="btn-check" name="required_skills[]" id="{{ $singleSkillCategory->category_name }}-{{ $skillKey }}" value="{{ $skill->id }}" >
                                                        <label class="btn border select-skill" data-input-id="{{ $singleSkillCategory->category_name }}-{{ $skillKey }}" for="{{ $singleSkillCategory->category_name }}-{{ $skillKey }}">{{ $skill->skill_name ?? 'sn' }}</label>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Form -->
                            <div class="container px-0 ">
                                <div class="bg-white p-4 text-end shadow-sm" style="border-radius: 0px">
                                    <!-- Button triggers modal -->
                                    <button type="button" class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-3 show-review-btn" data-modal-id="createJobModal" {{--data-bs-toggle="modal" data-bs-target="#jobDetailsModal"--}}>
                                        Review & Post
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Create Job Modal End -->

    <!-- Detailed Job Review Modal -->
    <div class="modal fade modal-over-modal" id="jobDetailsModalReview" style="">
        <div class="modal-dialog modal-lg " style="height: calc(100vh - 5px); margin: 5px auto;">
            <div class="modal-content rounded-4 p-4" style="height: 100%; overflow-y: auto;">
                <!-- Header with back arrow and buttons -->
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom" id="reviewBorderBottom" style="padding: 16px 24px; background: #fff; border-radius: 16px 16px 0px 0px;">
                    <h6 class="mb-0 fw-semibold d-flex align-items-center gap-2 hide-review-modal" style="font-weight: 600; font-size: 1rem; cursor: pointer;">
                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt="Back" style="width: 24px; height: 24px;">
                        Review job details
                    </h6>
                    <button id="modalPostJobBtn" req-for="create" class="btn btn-warning fw-bold" style="padding: 8px 20px; border-radius: 12px; font-weight: 700; font-size: 1rem;">
                        Post job
                    </button>

                </div>

                <!-- Snackbar / Toast -->
                <div id="snackbar" class="snackbar">
                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/toasterTik.png" alt="Success" class="snackbar-icon">
                    <span class="snackbar-text">You posted the job: <b id="" class="reviewJobTitle" style="font-size: 19px">Senior Officer, Corporate Banking</b></span>
{{--                    <button id="snackbar-close" class="snackbar-close"><img src="{{ asset('/') }}frontend/employer/images/employersHome/ToasterCross.png" alt=""></button>--}}
                </div>

                <!-- Snackbar / Toast -->


                <!-- Company Info -->
                <div class="mb-2 d-flex align-items-center gap-2">
                    <img id="modalCompanyLogo" src="{{ asset('/') }}frontend/employer/images/employersHome/UCB logo.png" alt="UCB Logo" style="height:24px;">
                    <span class="fw-semibold companyName">United Commercial Bank PLC</span>
                    <span class="text-muted" id="companyAddress">&middot; Gulshan, Dhaka</span>
                </div>

                <!-- Job Title -->
                <h4 class="fw-bold mb-3 reviewJobTitle" id="reviewJobTitle" >Senior Officer, Corporate Banking</h4>

                <!-- Tags -->
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-light text-dark fw-medium" id="reviewJobType">Full Time</span>
                    <span class="badge bg-light text-dark fw-medium" id="reviewJobLocationType">On-Site</span>
                </div>

                <div class="row my-4">
                    <div class="col-md-4">
                        <p class="mb-1"><b>Required Experience</b></p>
                        <p id="reviewExperience">1-3 Years</p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1"><b>Application Deadline</b></p>
                        <p id="reviewDeadline">20-5-25</p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1"><b>Salary</b></p>
                        <p id="reviewSalary">BDT 10000</p>
                    </div>
                </div>

                <!-- About Section -->
                <h6 class="fw-semibold mt-1 mb-2">About <b class="companyName">UCB</b></h6>
                <p class="text-muted companyOverview" id="" style="line-height: 1.6;">
                    Be part of the world's most successful, purpose-led business. Work with brands that are well-loved around the world, that improve the lives of our consumers and the communities around us. We promote innovation, big and small, to make our business win and grow; and we believe in business as a force for good. Unleash your curiosity, challenge ideas and disrupt processes; use your energy to make this happen.
                    <br><br>
                    Our brilliant business leaders and colleagues provide mentorship and inspiration, so you can be at your best. Every day, nine out of ten Indian households use our products to feel good, look good and get more out of life – giving us a unique opportunity to build a brighter future.
                </p>

                <!-- Job Requirements -->
                <h6 class="fw-semibold mt-2 mb-2">Job Requirements</h6>
                <span class="text-justify" id="reviewJobRequirements">
                    <ul class="text-muted" style="line-height: 1.8;">
                        <li>Analyse internal and external data to identify geography-wise issues/opportunities and action upon them.</li>
                        <li>Work with media teams and other stakeholders to deploy effective communication for Surf across traditional and new-age media platforms.</li>
                    </ul>
                </span>

                <!-- field of study -->
                <h6 class="fw-semibold mt-4 mb-2">Field Of Study Preference</h6>
                <span>
                    <ul id="printFieldOfStudy" class="mb-0">
                        <li>Business</li>
                    </ul>
                </span>
                <!-- University -->
                <h6 class="fw-semibold mt-4 mb-2">University Preference</h6>
                <span>
                    <ul id="printUniversity" class="mb-0">
                        <li>JU</li>
                    </ul>
                </span>
                <!-- University -->
                <h6 class="fw-semibold mt-4 mb-2">Required CGPA</h6>
                <p id="printCgpa" class="mb-0">

                </p>
            </div>
        </div>
    </div>

    <!-- Edit Job Modal -->
    <div class="modal fade" id="editJobModal" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-4 rounded-4">
                <div class="" id="editJobForm">

                </div>
            </div>
        </div>
    </div>
    <!-- Create Job Modal End -->

@endsection

@push('style')
    <style>
        /* Fix Select2 dropdown positioning in modals */
        .select2-container {
            width: 100%!important;
            z-index: 2000 !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #FFCB11!important;
        }
        .select2-search__field {display: none!important;}
        .selected-skill {
            color: black!important;
            background-color: #FFCB11!important;
        }
        /*modal over modal show*/
        /* Ensure second modal appears over first modal */
        #jobDetailsModalReview {
            z-index: 1060 !important;
        }

        #jobDetailsModalReview + .modal-backdrop {
            z-index: 1059 !important;
        }
    </style>
{{--    show job details css--}}
    <style>
        .job-type .badge {
            background-color: #edeff2;
            border-radius: 100px;
            padding: 6px 12px;
            font-weight: 500;
            font-size: 14px;
            line-height: 120%;
            letter-spacing: -1%;
            color: #484f5b;
            cursor: pointer;
        }
        .about-company-name {margin-top: 10px}

        /* modal codes*/
        #reviewBorderBottom {
            margin: -16px -24px 0 -24px; /* Negative margin to extend to parent edges */
            padding: 16px 24px;
            border-bottom: 2px solid #dee2e6; /* or your desired color */
        }

    </style>
@endpush

@push('script')

    @include('common-resource-files.sim-select')
    @include('common-resource-files.summernote')

    <script>
        $(document).on('click', '.edit-job', function () {

            var jobId = $(this).attr('data-job-id');
            // var thisObject = $(this);
            // // console.log(thisObject);

            sendAjaxRequest('employer/job-tasks/'+jobId+'/edit', 'GET').then(function (response) {
                // console.log(response);
                $('#editJobForm').empty().append(response);
                $('.summernote').summernote({
                    height: 300
                });
                // $('.select2').selectize();
                document.querySelectorAll('.select2').forEach(function (el) {
                    new SlimSelect({
                        select: el,
                        events: {
                            searchFilter: (option, search) => {
                                return option.text.toLowerCase().indexOf(search.toLowerCase()) !== -1;
                            }
                        }
                    });
                });
                $('#editJobModal').modal('show');
            })
        })
    </script>

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
        $(document).on('click', '#continueToStep2', function () {
            $('#formJobTitle').text($('input[name="job_title"]').val());
            $('#jobJobType').text($('label[for="'+$('input[name="job_type_id"]').attr('id')+'"]').text());
            $('#jobjobLocationType').text($('label[for="'+$('input[name="job_location_type_id"]').attr('id')+'"]').text());
            // document.querySelector('#createJobModal .stepOne').classList.add('d-none');
            $('.stepOne').addClass('d-none');
            // document.querySelector('#createJobModal .jobModalForPost').classList.remove('d-none');
            $('.jobModalForPost').removeClass('d-none');
            $('.stepTwo').removeClass('d-none');
        })
        $(document).on('click', '#createJobModal #backToStepOne', function () {
            // document.querySelector('#createJobModal .stepOne').classList.remove('d-none');
            $('#createJobModal .stepOne').removeClass('d-none');
            // document.querySelector('#createJobModal .jobModalForPost').classList.add('d-none');
            $('#createJobModal .jobModalForPost').addClass('d-none');
        })
        $(document).on('click', '#editJobModal #backToStepOne', function () {
            $('#editJobModal .stepOne').removeClass('d-none');
            $('#editJobModal .jobModalForPost').addClass('d-none');
        })
        $(document).on('click', '#showCustomExperienceField', function () {
            $('#customExperienceField').toggle();
        })
        $(document).on('click', '#editshowCustomExperienceField', function () {
            $('#editcustomExperienceField').toggle();
        })
    </script>
    <script>
        // document.getElementById('continueToStep2')?.addEventListener('click', function () {
        //     $('#formJobTitle').text($('input[name="job_title"]').val());
        //     $('#jobJobType').text($('label[for="'+$('input[name="job_type_id"]').attr('id')+'"]').text());
        //     $('#jobjobLocationType').text($('label[for="'+$('input[name="job_location_type_id"]').attr('id')+'"]').text());
        //     document.querySelector('#createJobModal .stepOne').classList.add('d-none');
        //     document.querySelector('#createJobModal .jobModalForPost').classList.remove('d-none');
        //     $('.stepTwo').removeClass('d-none');
        // });

        // document.getElementById('backToStepOne')?.addEventListener('click', function () {
        //     document.querySelector('#createJobModal .stepOne').classList.remove('d-none');
        //     document.querySelector('#createJobModal .jobModalForPost').classList.add('d-none');
        // });
        $(document).on('click', '.show-job-details', function () {
            var jobId = $(this).attr('data-job-id');
            sendAjaxRequest('get-job-details/'+jobId+'?render=1', 'GET', {job_task: jobId})
                .then(function (response) {
                    // console.log(response.job);
                    // if (response.status == 'success')
                    // {
                    //     var job = response.job;
                    //     $('#detailsCompanyLogo').attr('src', base_url+job.employer_company.logo);
                    //     $('#detailsCompanyName').text(job.employer_company.name);
                    //     $('#detailsAboutCompanyName').text(job.employer_company.name);
                    //     $('#detailsCompanyAddress').text(job.employer_company.address);
                    //     $('#detailsJobTitle').text(job.job_title);
                    //     $('#detailsJobType').text(job.job_type.name);
                    //     $('#detailsJobLocationType').text(job.job_location_type.name);
                    //     $('#detailsCompanyOverview').html(job.employer_company.company_overview);
                    //     $('#detailsJobDescription').html(job.description);
                    //     $('#jobDetailsModal').modal('show');
                    // } else {
                    //     toastr.error('Something went wrong. Please try again.')
                    // }
                    $('#printJobDetailsHere').empty().append(response);
                    $('#jobDetailsModal').modal('show');
                })
        })
        $(document).on('click', '.select-skill', function () {
            let inputId = $(this).attr('data-input-id');
            let input = $("#" + inputId);
            if (!$(this).hasClass('selected-skill'))
            {
                // Check and add style
                input.prop('checked', true);
                $(this).addClass('selected-skill');
            } else {
                // Uncheck and remove style
                input.prop('checked', false);
                $(this).removeClass('selected-skill');
            }
        });
        $(document).on('click', '.show-review-btn', function () {
            var getModalId = $(this).attr('data-modal-id');
            $(this).blur();
            showReviewModalWithData(`#${getModalId} `);
            $('#modalPostJobBtn').attr('req-for', 'create').attr('data-modal-id', getModalId).addClass('submit-form-after-review');
            // $('#createJobModal').modal('hide');
            setTimeout(function () {
                $('#jobDetailsModalReview').modal('show');
            }, 50)

        });
        $(document).on('click', '.hide-review-modal', function () {
            // $(this).blur();
            // showReviewModalWithData();
            // $('#modalPostJobBtn').attr('req-for', 'create');
            $('#jobDetailsModalReview').modal('hide');
            // setTimeout(function () {
            //     $('#jobDetailsModalReview').modal('show');
            // }, 50)

        });
        $(document).on('click', '.submit-form-after-review', function () {
            var modalId = $(this).attr('data-modal-id');
            $(`#${modalId} form`).submit();
        });
        function showReviewModalWithData(parentModalId = '#createJobModal ') {
            // collect values
            var companyLogo = $('#companyLogo').val();
            var companyName = $('#companyName').val();
            var companyAddress = $('#companyAddress').val();
            var companyOverview = $('#companyOverview').val();

            var jobTitle = $(parentModalId+'input[name="job_title"]').val();

            var jobType = $(parentModalId+'label[for="'+$(parentModalId+'input[name="job_type_id"]').attr('id')+'"]').text();
            var jobLocationType = $(parentModalId+'label[for="'+$('input[name="job_location_type_id"]').attr('id')+'"]').text();
            var requiredExperience = $(parentModalId+'input[name="required_experience"]').val();
            var description = $(parentModalId+'textarea[name="description"]').val();

            var finalExperience = '';
            if (requiredExperience == 'custom')
            {
                finalExperience = $(parentModalId+'input[name="exp_range_start"]').val()+' - '+$('input[name="exp_range_end"]').val();
            } else {
                finalExperience = requiredExperience;
            }
            var deadline = $(parentModalId+'input[name="deadline"]').val();
            var salary = $(parentModalId+'input[name="salary_amount"]').val();
            var cgpa = $(parentModalId+'input[name="cgpa"]').val();
            var cgpa = $(parentModalId+'input[name="cgpa"]').val();
            // var field_of_study_preference = $('select[name="field_of_study_preference[]"]').val();
            // var university_preference = $('select[name="university_preference[]"]').val();
            // console.log('fos: '+field_of_study_preference);
            // console.log('uni: '+university_preference);

            var selectedFOSTexts = [];
            $(parentModalId+'select[name="field_of_study_preference[]"] option:selected').each(function() {
                selectedFOSTexts.push($(this).text());
            });

            var selectedVersityTexts = [];
            $(parentModalId+'select[name="university_preference[]"] option:selected').each(function() {
                selectedVersityTexts.push($(this).text());
            });

            // print values
            $('.reviewJobTitle').text(jobTitle);
            $('#companyLogo').text(companyLogo);
            $('#modalCompanyLogo').attr('src', companyLogo);
            $('.companyName').text(companyName);
            $('#companyAddress').text(companyAddress);
            $('.companyOverview').html(companyOverview);

            $('#reviewJobType').text(jobType);
            $('#reviewJobLocationType').text(jobLocationType);
            $('#reviewExperience').text(finalExperience);
            $('#reviewDeadline').text(deadline);
            $('#reviewSalary').text(salary);
            $('#printCgpa').text(cgpa);
            $('#reviewJobRequirements').empty();
            $('#reviewJobRequirements').html(description);

            $('#printFieldOfStudy').empty();
            $.each(selectedFOSTexts, function(index, text) {
                $('#printFieldOfStudy').append('<li>' + text + '</li>');
            });
            $('#printUniversity').empty();
            $.each(selectedVersityTexts, function(index, text) {
                $('#printUniversity').append('<li>' + text + '</li>');
            });

        }
    </script>
@endpush
