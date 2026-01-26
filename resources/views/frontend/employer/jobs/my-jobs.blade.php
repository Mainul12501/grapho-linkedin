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
                                    <h5 class="fw-bold mb-1 f-s-28">{{ trans('employer.my_jobs') }}</h5>
                                    <p class="text-muted small mb-0">{{ trans('employer.see_all_posted_jobs') }}</p>
                                </div>
                                <!-- Post a job button -->
                                <!-- Post a job button -->
                                <button class="btn btn-warning text-dark fw-semibold rounded-3 px-4 py-2"
                                        data-bs-toggle="modal" data-bs-target="#createJobModal">
                                    {{ trans('employer.post_a_job') }}
                                </button>
{{--                                <a href="{{ route('employer.job-tasks.create') }}"  class="btn btn-warning text-dark fw-semibold rounded-3 px-4 py-2">Post a job</a>--}}

                            </div>

                            <!-- ✅ Mobile Search -->
                            <div class="d-block d-md-none mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-white " onclick="searchOnMobile()">
                                      <img src="{{ asset('/') }}frontend/employer/images/employersHome/search 1.png" alt="">
                                    </span>
                                    <input type="text" class="form-control border-start-0" id="mobile_search_text" placeholder="Search jobs (mobile)" />
                                    <span class="input-group-text bg-white border-end-0" onclick="document.getElementById('mobile_search_text').value = '';">
{{--                                      <img src="{{ asset('/') }}frontend/employer/images/employersHome/search 1.png" alt="">--}}
                                        <i class="fas fa-close"></i>
                                    </span>
                                </div>

                                <div id="t2" class="d-flex flex-wrap gap-2 mt-3">
                                    <a href="{{ route('employer.my-jobs', ['job_status' => 'open']) }}"><button class="btn {{  request('job_status') != 'closed' ? 'btn-dark' : 'btn-light' }} btn-sm rounded-pill px-3">{{ trans('employer.open_jobs') }}</button></a>
                                    <a href="{{ route('employer.my-jobs', ['job_status' => 'closed']) }}"><button class="btn  {{ request('job_status') && request('job_status') == 'closed' ? 'btn-dark text-white' : 'btn-light text-muted' }} btn-sm rounded-pill px-3 ">{{ trans('employer.closed_jobs') }}</button></a>
                                </div>
                            </div>

                            <!-- ✅ Desktop Search -->
                            <div class="d-none d-md-flex justify-content-between align-items-center gap-3 mb-3 flex-wrap">
                                <!-- Filter Buttons (Left Side) -->
                                <div id="t2" class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('employer.my-jobs', ['job_status' => 'open']) }}"><button class="btn {{  request('job_status') != 'closed' ? 'btn-dark' : 'btn-light' }} btn-sm rounded-pill px-3">{{ trans('employer.open_jobs') }}</button></a>
                                    <a href="{{ route('employer.my-jobs', ['job_status' => 'closed']) }}"><button class="btn  {{ request('job_status') && request('job_status') == 'closed' ? 'btn-dark text-white' : 'btn-light text-muted' }} btn-sm rounded-pill px-3 ">{{ trans('employer.closed_jobs') }}</button></a>
                                </div>

                                <!-- Desktop Search (Right Side) -->
                                <div id="t1" style="max-width: 320px; width: 100%;">
                                    <form action="" id="searchForm">
                                        <div class="input-group">
                                          <span class="input-group-text bg-white " onclick="document.getElementById('searchForm').submit();">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/search 1.png" alt="">
                                          </span>
                                            <input type="text" class="form-control border-start-0" id="desktop_search_text" name="search_text" value="{{  $_GET['search_text'] ?? '' }}" placeholder="{{ trans('employer.search_jobs') }}" />
                                            <span class="input-group-text bg-white " style="cursor:pointer;" onclick="document.getElementById('desktop_search_text').value = '';">
{{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/search 1.png" alt="">--}}
                                                <i class="fas fa-close"></i>
                                          </span>
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
                                            <h6 class="job-title fw-semibold mb-2">{{ $publishedJob->job_title ?? trans('common.job_title') }}</h6>
                                            <div class="job-badges d-flex flex-wrap gap-2 mb-2">
                                                <span class="badge bg-light text-secondary">{{ $publishedJob?->jobType?->name ?? trans('common.job_type') }}</span>
                                                <span class="badge bg-light text-secondary">{{ $publishedJob?->jobLocationType?->name ?? trans('common.job_location') }}</span>
{{--                                                <span class="badge bg-light text-secondary">Day Shift</span>--}}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="job-info text-muted small">
                                        <div class="mb-1">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/postdOn.png" class="me-1" alt=""> {{ trans('employer.posted_on') }} {{ $publishedJob->created_at->format('d M, Y') ?? '16 Feb, 2025' }}
                                        </div>
                                        <div class="mb-1">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/Dedline.png" class="me-1" alt=""> {{ trans('employer.deadline') }} {{ \Illuminate\Support\Carbon::parse($publishedJob->deadline)->format('d M, Y') ?? '16 Feb, 2025' }}
                                        </div>
                                        <div>
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/24application.png" class="me-1" alt="">
                                            <a href="{{ route('employer.my-job-applicants', ['jobTask' => $publishedJob->id]) }}" class="text-decoration-underline">{{ $publishedJob->employeeAppliedJobs->count() ?? 0 }} {{ trans('employer.applicants') }}</a>
                                        </div>
                                    </div>

                                    <!-- ✅ Dropdown (Three Dot) -->
                                    <div class="job-actions dropdown">
                                        <button class="btn btn-link p-0 text-secondary"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="">
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">

                                                <li><a class="dropdown-item close-job" href="{{ route('employer.close-job', ['jobTask' => $publishedJob->id, 'status' => $publishedJob->status == 1 ? 0 : 1]) }}" data-job-id="{{ $publishedJob->id }}">{{ $publishedJob->status == 1 ? 'Close Job' : 'Open Job' }}</a></li>

                                            <li><a class="dropdown-item edit-job" href="javascript:void(0)" data-job-id="{{ $publishedJob->id }}">{{ trans('common.edit') }}</a></li>
{{--                                            <li><a class="dropdown-item " href="{{ route('employer.job-tasks.edit', $publishedJob->id) }}" data-job-id="{{ $publishedJob->id }}">Edit</a></li>--}}
                                            <li>
                                                <form action="{{ route('employer.job-tasks.destroy', $publishedJob->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item" type="submit">{{ trans('common.delete') }}</button>
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
{{--                                                    <img src="{{ asset('/frontend/think.svg') }}" alt="empty-img" class="" style="max-height: 300px;">--}}
                                                </p>
                                                <p class="text-danger text-center f-s-20 fw-bold p-5" style="margin-top: 10px">{{ trans('employer.no_available_job_found') }}</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse


                    </div>
                </section>
            </div>
        </div>

    </main>

@endsection


@section('modal')


    <!-- Job Details Modal -->
    <div class="modal fade" id="jobDetailsModal"  aria-labelledby="jobDetailsModalLabel" aria-hidden="true">
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
    <div class="modal fade" id="createJobModal" data-bs-backdrop="static" data-bs-focus="false">
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
                            <button type="button" class="btn-close position-absolute modal-redirect-previous-page"  style="right: 4%;" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Job Title -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Job title <span class="text-danger">*</span></label>
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
                            <button id="continueToStep2" data-continue-btn-parent-form="jobCreateForm" type="button" class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-3">Continue</button>
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
                                    <select name="university_preference[]" id="select2-div" class=" select2"  multiple="multiple" data-placeholder="Select Universities">

                                        @foreach($universityNames as $universityNameKey => $universityName)
                                            <option value="{{ $universityName->id }}">{{ $universityName->name ?? 'un' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Field of Study -->
                            <div class="container px-0 border-bottom">
                                <div class="bg-white  p-4 shadow-sm" style="border-radius: 0px">
                                    <h6 class="fw-semibold mb-3">Field of study </h6>
{{--                                    <input type="text" class="form-control mb-3" placeholder="Search field of study">--}}
                                    <select name="field_of_study_preference[]" id="" class=" select2" multiple="multiple" data-placeholder="Select Field Of Studies">
                                        @foreach($fieldOfStudies as $fieldOfStudyKey => $fieldOfStudy)
                                            <option value="{{ $fieldOfStudy->id }}">{{ $fieldOfStudy->field_name ?? 'un' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- CGPA Preference -->
                            <div class="container px-0 border-bottom">
                                <div class="bg-white  p-4 shadow-sm" style="border-radius: 0px">
                                    <h6 class="fw-semibold mb-3">CGPA </h6>
                                    <input type="number" min="0" name="cgpa" class="form-control" placeholder="Min 3.50">
                                </div>
                            </div>

                            <!-- Gender Preference -->
                            <div class="container px-0 border-bottom">
                                <div class="bg-white p-4 shadow-sm" style="border-radius: 0px">
                                    <h6 class="fw-semibold mb-3">Gender  <span class="text-danger">*</span></h6>
                                    <select name="gender" id="" required class="form-control select2">
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
                                    <input type="number" min="0" name="salary_amount" class="form-control mb-2" placeholder="BDT 50,000">
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
                                        <h6 class="fw-semibold mb-0">Application deadline <span class="text-danger">*</span></h6>
{{--                                        <div class="form-check form-switch mb-0">--}}
{{--                                            <input class="form-check-input" type="checkbox" role="switch" id="deadlineToggle" checked>--}}
{{--                                        </div>--}}
                                    </div>
                                    <div>
                                        <div class="input-group rounded-3 border border-secondary-subtle">
                                            <input type="date" required name="deadline" min="{{ date('Y-m-d') }}" class="form-control" value="" />
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Skills Section -->
                            <div class="container px-0 border-bottom">
                                <div class="bg-white p-4 shadow-sm" style="border-radius: 0px">
                                    <h6 class="fw-semibold mb-3">Skill requirements</h6>

                                    <!-- Search Input -->
                                    <div class="mb-3">
{{--                                        <input type="text" class="form-control skill-search-input" data-form="create" placeholder="Search skills...">--}}
                                        <div class="input-group">
                                            <input type="text" class="form-control skill-search-input" data-form="create" placeholder="Search skills...">
                                            <span class="input-group-text clear-skill-search" data-form="create" style="cursor: pointer; display: none;">
                                                <i class="fas fa-times"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Selected Skills Display -->
                                    <div class="mb-3 selected-skills-container d-flex flex-wrap gap-2" data-form="create"></div>

                                    <!-- Search Results -->
                                    <div class="skill-search-results d-none mb-3" data-form="create">
                                        <div class="skill-search-list d-flex flex-wrap gap-2"></div>
                                    </div>

                                    <!-- Category Skills -->
                                    <div class="skill-category-box" data-form="create">
                                        <nav>
                                            <div class="nav nav-pills" role="tablist">
                                                @foreach($skillCategories as $skillCategoryKey => $skillCategory)
                                                    <button class="nav-link {{ $skillCategoryKey == 0 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#createSkillCat{{ $skillCategoryKey }}" type="button">{{ $skillCategory->category_name }}</button>
                                                @endforeach
                                            </div>
                                        </nav>
                                        <div class="tab-content mt-3">
                                            @foreach($skillCategories as $x => $singleSkillCategory)
                                                <div class="tab-pane fade {{ $x == 0 ? 'show active' : '' }}" id="createSkillCat{{ $x }}">
                                                    @foreach($singleSkillCategory->publishedSkills as $skill)
                                                        <label class="btn border skill-btn m-1" data-id="{{ $skill->id }}" data-name="{{ $skill->skill_name }}">{{ $skill->skill_name }}</label>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
{{--                            single create form -- skills--}}
{{--                            <div class="container px-0 border-bottom">--}}
{{--                                <div class="bg-white  p-4 shadow-sm" style="border-radius: 0px">--}}
{{--                                    <h6 class="fw-semibold mb-3">Skill requirements</h6>--}}
{{--                                    <div class="<!--d-flex flex-wrap gap-2-->" id="createJobSkillBox">--}}

{{--                                        <!-- Search Input -->--}}
{{--                                        <div class="mb-3">--}}
{{--                                            <input type="text" class="form-control" id="skillSearchInput" placeholder="Search skills...">--}}
{{--                                        </div>--}}

{{--                                        <div class="mb-3 append-selected-skill-here-to-send-server d-flex flex-wrap gap-2">--}}

{{--                                        </div>--}}

{{--                                        <!-- Search Results Container (hidden by default) -->--}}
{{--                                        <div id="skillSearchResults" class="d-none mb-3">--}}
{{--                                            <p class="text-muted small mb-2">Search Results:</p>--}}
{{--                                            <div id="skillSearchResultsList" class="d-flex flex-wrap gap-2"></div>--}}
{{--                                        </div>--}}
{{--                                        <span class="badge bg-light text-dark">Sales</span>--}}
{{--                                        <nav id="skillCategoryNav">--}}
{{--                                            <div class="nav nav-pills" id="nav-tab" role="tablist">--}}
{{--                                                @foreach($skillCategories as $skillCategoryKey =>$skillCategory)--}}
{{--                                                    <button class="nav-link {{ $skillCategoryKey == 0 ? 'active' : '' }}" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#skillCategory{{ $skillCategoryKey }}" type="button" role="tab" aria-controls="nav-home" aria-selected="true">{{ $skillCategory->category_name }}</button>--}}
{{--                                                @endforeach--}}

{{--                                                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Skill </button>--}}
{{--                                            </div>--}}
{{--                                        </nav>--}}
{{--                                        <div class="tab-content mt-3" id="nav-tabContent">--}}
{{--                                            @foreach($skillCategories as $x => $singleSkillCategory)--}}
{{--                                                <div class="tab-pane fade {{ $x == 0 ? 'show active' : '' }}" id="skillCategory{{$x}}" >--}}
{{--                                                    @foreach($singleSkillCategory->publishedSkills as $skillKey => $skill)--}}
{{--                                                        <input type="checkbox" class="btn-check" --}}{{--name="required_skills[]"--}}{{-- id="{{ $singleSkillCategory->slug }}-{{ $skillKey }}" value="{{ $skill->id }}" >--}}
{{--                                                        <label class="btn border select-skill" data-input-id="{{ $singleSkillCategory->slug }}-{{ $skillKey }}" for="{{ $singleSkillCategory->slug }}-{{ $skillKey }}">{{ $skill->skill_name ?? 'sn' }}</label>--}}
{{--                                                    @endforeach--}}
{{--                                                </div>--}}
{{--                                            @endforeach--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

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
                    <img id="modalCompanyLogo" src="{{ asset('/frontend/company-vector.jpg') }}" alt="company Logo" style="height:24px;">
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
                <h6 class="fw-semibold mt-4 mb-2 toggle-fosp d-none">Field Of Study</h6>
                <span>
                    <ul id="printFieldOfStudy" class="mb-0">
                        <li>Business</li>
                    </ul>
                </span>
                <!-- University -->
                <h6 class="fw-semibold mt-4 mb-2 toggle-uni d-none">University Preference</h6>
                <span>
                    <ul id="printUniversity" class="mb-0">
                        <li>JU</li>
                    </ul>
                </span>
                <!-- University -->
                <h6 class="fw-semibold mt-4 mb-2 toggle-cgpa d-none">Required CGPA</h6>
                <p id="printCgpa" class="mb-0">

                </p>
                <!-- University -->
                <h6 class="fw-semibold mt-4 mb-2 toggle-skills d-none">Required Skills</h6>
                <span>
                    <ul id="printSkills" class="mb-0">
                        <li>Web</li>
                    </ul>
                </span>
            </div>
        </div>
    </div>

    <!-- Edit Job Modal -->
    <div class="modal fade" id="editJobModal" data-bs-focus="false" data-bs-backdrop="static">
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
        /* hide select 2 search field */
        /*.select2-search__field {display: none!important;}*/
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




         /* Mobile: Position job-actions at top right */
          @media screen and (max-width: 768px) {
                .job-card {
                  position: relative;
                  padding-right: 3rem;
                }
                .job-actions {
                  position: absolute;
                  /*top: 1rem;*/
                  top: 25px;
                  right: 1rem;
                  margin-left: 0;
                }
              }



        /*fix job title long content desing issue*/
        .job-card .job-title {
            white-space: normal !important;
            overflow: visible !important;
            text-overflow: clip !important;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
            max-width: 350px !important; /* Direct width limit on title itself */
        }

        .job-card .job-main {
            width: 350px !important; /* Fixed width instead of max-width */
        }

        /* Mobile adjustments */
        @media screen and (max-width: 768px) {
            .job-card .job-main {
                width: auto !important;
            }
            .job-card .job-title {
                max-width: 100% !important;
            }
        }

        /*search skill box*/
        .skill-search-item {
            display: inline-block;
        }
        .select-skill-search {
            cursor: pointer;
        }
        .select-skill-search small {
            font-size: 10px;
        }
        /* Selected skill tag styles */
        .selected-skill-tag {
            display: inline-flex;
            align-items: center;
            background-color: #FFCB11;
            color: #000;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            gap: 8px;
        }
        .selected-skill-tag .remove-skill {
            cursor: pointer;
            font-weight: bold;
            font-size: 18px;
            line-height: 1;
        }
        .selected-skill-tag .remove-skill:hover {
            color: red;
        }
        .skill-btn.selected-skill {
            background-color: #FFCB11 !important;
            color: #000 !important;
        }
        .skill-search-item label {
            cursor: pointer;
        }
        .skill-search-item label small {
            font-size: 10px;
        }
        /*.selected-skill-tag {*/
        /*    display: inline-flex;*/
        /*    align-items: center;*/
        /*    background-color: #FFCB11;*/
        /*    color: #000;*/
        /*    padding: 5px 10px;*/
        /*    border-radius: 20px;*/
        /*    font-size: 14px;*/
        /*    gap: 8px;*/
        /*}*/
        /*.selected-skill-tag .remove-skill {*/
        /*    cursor: pointer;*/
        /*    font-weight: bold;*/
        /*    font-size: 16px;*/
        /*    line-height: 1;*/
        /*    opacity: 0.7;*/
        /*}*/
        /*.selected-skill-tag .remove-skill:hover {*/
        /*    opacity: 1;*/
        /*}*/

        /* Clear skill search button */
        .clear-skill-search {
            background-color: #fff;
            border-left: 0;
        }
        .clear-skill-search:hover {
            background-color: #f8f9fa;
        }
        .skill-search-input:focus + .clear-skill-search {
            border-color: #86b7fe;
        }
    </style>
@endpush

@push('script')

    @include('common-resource-files.select2')
{{--    @include('common-resource-files.')--}}
{{--    @include('common-resource-files.summernote')--}}
    <script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            CKEDITOR.replace( 'summernote', {
                versionCheck: false,
                height: 450
            } );
        })
        function searchOnMobile() {
            window.location ="{{ route('employer.my-jobs') }}?search_text="+$('#mobile_search_text').val();
        }
    </script>

    @if(isset($_GET['show_modal']) && $_GET['show_modal'] == 'create')
        <script>
            var previousPage = "{{ url()->previous() }}";
            $(document).ready(function () {

                $('.modal-redirect-previous-page').attr('data-enable-previous','true');
                $('#createJobModal').modal('show');
            })
            $(document).on('click', '.modal-redirect-previous-page', function () {
                if ($(this).attr('data-enable-previous') == 'true')
                    window.location.href = previousPage;
            })
        </script>
    @endif

    <script>
        $(document).on('click', '.edit-job', function () {

            var jobId = $(this).attr('data-job-id');
            // var thisObject = $(this);
            // // console.log(thisObject);

            sendAjaxRequest('employer/job-tasks/'+jobId+'/edit', 'GET').then(function (response) {
                // console.log(response);
                $('#editJobForm').empty().append(response);
                // $('.summernote').summernote({
                //     height: 300
                // });
                $('.select2').select2({
                    width: "100%",
                });
                CKEDITOR.replace( 'summernote2', {
                    versionCheck: false
                } );

                // Fix for single select focus issue
                // $(document).on('select2:open', () => {
                //     setTimeout(() => {
                //         document.querySelector('.select2-container--open .select2-search__field').focus();
                //     }, 0);
                // });
                $('#editJobModal').modal('show');
            })
        })
    </script>

{{--    </style>--}}
    <script >
        $(document).ready(function() {
            // $('#summernote').summernote({
            //     height: 200
            // });

        });
        $(document).on('click', '.salary-type', function () {
            setInputValueByClassName($(this), 'job_pref_salary_payment_type', 'data-value');
        })
        $(document).on('click', '.return-to-first-part', function () {
            $('.stepTwo').addClass('d-none');
            $('.stepOne').removeClass('d-none');
        })
        $(document).on('click', '#continueToStep2', function () {
            var btnParentForm = $(this).attr('data-continue-btn-parent-form');
            $('#formJobTitle').text($('#'+btnParentForm+' input[name="job_title"]').val());
            $('#jobJobType').text($('#'+btnParentForm+' label[for="'+$('#'+btnParentForm+' input[name="job_type_id"]:checked').attr('id')+'"]').text());
            $('#jobjobLocationType').text($('#'+btnParentForm+' label[for="'+$('#'+btnParentForm+' input[name="job_location_type_id"]:checked').attr('id')+'"]').text());
            // document.querySelector('#createJobModal .stepOne').classList.add('d-none');
            $('.stepOne').addClass('d-none');
            // document.querySelector('#createJobModal .jobModalForPost').classList.remove('d-none');
            $('.jobModalForPost').removeClass('d-none');
            $('.stepTwo').removeClass('d-none');
        })
        $(document).on('click', '#continueToStep2Edit', function () {
            var btnParentForm = $(this).attr('data-continue-btn-parent-form');

            $('#formJobTitleEdit').text($('#'+btnParentForm+' input[name="job_title"]').val());
            $('#jobJobTypeEdit').text($('#'+btnParentForm+' label[for="'+$('#'+btnParentForm+' input[name="job_type_id"]:checked').attr('id')+'"]').text());
            $('#jobjobLocationTypeEdit').text($('#'+btnParentForm+' label[for="'+$('#'+btnParentForm+' input[name="job_location_type_id"]:checked').attr('id')+'"]').text());
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
        // old select skill code
        // $(document).on('click', '.select-skill', function () {
        //     let inputId = $(this).attr('data-input-id');
        //     let input = $("#" + inputId);
        //     if (!$(this).hasClass('selected-skill'))
        //     {
        //         // Check and add style
        //         input.prop('checked', true);
        //         $(this).addClass('selected-skill');
        //     } else {
        //         // Uncheck and remove style
        //         input.prop('checked', false);
        //         $(this).removeClass('selected-skill');
        //     }
        // });


        $(document).on('click', '.show-review-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // const formId = 'jobCreateForm';
            const formId = $(this).closest('form').attr('id');

            // Run validation FIRST
            if (validateJobForm(formId)) {
                // ✅ Validation passed - proceed with original functionality
                var getModalId = $(this).attr('data-modal-id');
                $(this).blur();

                // Call your existing function
                showReviewModalWithData(`#${getModalId} `);

                // Set attributes for submit button
                $('#modalPostJobBtn')
                    .attr('req-for', 'create')
                    .attr('data-modal-id', getModalId)
                    .addClass('submit-form-after-review');

                // Show review modal after short delay
                setTimeout(function () {
                    $('#jobDetailsModalReview').modal('show');
                }, 50);

                return true;
            } else {
                // ❌ Validation failed - stop everything
                toastr.error('Validation failed! Please fix the errors before reviewing.');

                // Scroll to first error
                const firstError = $('.is-invalid, .validation-error').first();
                if (firstError.length) {
                    firstError[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                }

                return false;
            }
        });


        $(document).on('click', '.hide-review-modal', function () {

            $('#jobDetailsModalReview').modal('hide');

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

            var jobType = $(parentModalId+'label[for="'+$(parentModalId+'input[name="job_type_id"]:checked').attr('id')+'"]').text();
            var jobLocationType = $(parentModalId+'label[for="'+$('input[name="job_location_type_id"]:checked').attr('id')+'"]').text();
            var requiredExperience = $(parentModalId+'input[name="required_experience"]:checked').val();
            // var description = $(parentModalId+'textarea[name="description"]').val();
            if (parentModalId == '#createJobModal ')
                var description = CKEDITOR.instances['summernote'].getData();
            else
                var description = CKEDITOR.instances['summernote2'].getData();

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
            // var field_of_study_preference = $('select[name="field_of_study_preference[]"]').val();
            // var university_preference = $('select[name="university_preference[]"]').val();
            // console.log('fos: '+field_of_study_preference);
            // console.log('uni: '+university_preference);

            var selectedFOSTexts = [];
            $(parentModalId+'select[name="field_of_study_preference[]"] option:selected').each(function() {
                selectedFOSTexts.push($(this).text());
            });
            if (selectedFOSTexts.length > 0)
                $('.toggle-fosp').removeClass('d-none');

            var selectedVersityTexts = [];
            $(parentModalId+'select[name="university_preference[]"] option:selected').each(function() {
                selectedVersityTexts.push($(this).text());
            });
            if (selectedVersityTexts.length > 0)
                $('.toggle-uni').removeClass('d-none');

            var selectedSkillsTexts = [];
            $(parentModalId+'.selected-skills-container .selected-skill-tag').each(function() {
                selectedSkillsTexts.push($(this).find('span:first').text());
            });
            if (selectedSkillsTexts.length > 0)
                $('.toggle-skills').removeClass('d-none');

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
            if (cgpa.length > 0)
            {
                $('.toggle-cgpa').removeClass('d-none');
            }
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

            $('#printSkills').empty();
            $.each(selectedSkillsTexts, function(index, text) {
                $('#printSkills').append('<li>' + text + '</li>');
            });

            // $('#printSkills').empty();
            // $.each(selectedSkillsTexts, function(index, text) {
            //     $('#printSkills').append('<span class="badge bg-light text-dark me-1 mb-1">' + text + '</span>');
            // });

        }
    </script>





{{--    job form validations--}}
    <script>
        // Common validation function for job forms
        function validateJobForm(formId) {
            const form = document.getElementById(formId);
            let isValid = true;
            let errors = [];

            // Clear previous error messages
            clearErrors(form);

            // 1. Job Title - Required
            const jobTitle = form.querySelector('[name="job_title"]');
            if (!jobTitle || !jobTitle.value.trim()) {
                showError(jobTitle, 'Job title is required');
                errors.push('Job title is required');
                isValid = false;
            }

            // 2. Job Type - Required (at least one radio should be checked)
            const jobType = form.querySelector('[name="job_type_id"]:checked');
            if (!jobType) {
                const jobTypeContainer = form.querySelector('[name="job_type_id"]')?.closest('.mb-4');
                showError(jobTypeContainer, 'Please select a job type');
                errors.push('Job type is required');
                isValid = false;
            }

            // 3. Job Location Type - Required
            const jobLocationType = form.querySelector('[name="job_location_type_id"]:checked');
            if (!jobLocationType) {
                const locationContainer = form.querySelector('[name="job_location_type_id"]')?.closest('.mb-4');
                showError(locationContainer, 'Please select a job location type');
                errors.push('Job location type is required');
                isValid = false;
            }

            // 4. Required Experience - Required
            const experience = form.querySelector('[name="required_experience"]:checked');
            if (!experience) {
                const expContainer = form.querySelector('[name="required_experience"]')?.closest('.bg-white');
                showError(expContainer, 'Please select required experience');
                errors.push('Required experience is required');
                isValid = false;
            } else if (experience.value === 'custom') {
                // Validate custom experience range
                const expRangeStart = form.querySelector('[name="exp_range_start"]');
                const expRangeEnd = form.querySelector('[name="exp_range_end"]');

                if (!expRangeStart?.value || !expRangeEnd?.value) {
                    showError(expRangeStart?.parentElement, 'Please enter both start and end years for custom experience');
                    errors.push('Custom experience range incomplete');
                    isValid = false;
                } else if (parseInt(expRangeStart.value) >= parseInt(expRangeEnd.value)) {
                    showError(expRangeStart?.parentElement, 'End year must be greater than start year');
                    errors.push('Invalid experience range');
                    isValid = false;
                }
            }

            // 5. Industry - Required
            const industry = form.querySelector('[name="industry_id"]');
            if (!industry || !industry.value) {
                showError(industry, 'Please select an industry');
                errors.push('Industry is required');
                isValid = false;
            }

            // 6. University Preference - At least one required
            // const universities = form.querySelectorAll('[name="university_preference[]"]');
            // const selectedUniversities = Array.from(universities).filter(u => u.selected);
            // if (selectedUniversities.length === 0) {
            //     const uniSelect = form.querySelector('[name="university_preference[]"]');
            //     showError(uniSelect?.closest('.bg-white'), 'Please select at least one university');
            //     errors.push('At least one university preference is required');
            //     isValid = false;
            // }

            // 7. Field of Study - At least one required
            // const fieldOfStudy = form.querySelectorAll('[name="field_of_study_preference[]"]');
            // const selectedFields = Array.from(fieldOfStudy).filter(f => f.selected);
            // if (selectedFields.length === 0) {
            //     const fieldSelect = form.querySelector('[name="field_of_study_preference[]"]');
            //     showError(fieldSelect?.closest('.bg-white'), 'Please select at least one field of study');
            //     errors.push('At least one field of study is required');
            //     isValid = false;
            // }

            // 8. CGPA - Required, must be a number, min 0
            const cgpa = form.querySelector('[name="cgpa"]');
            // if (!cgpa || !cgpa.value.trim()) {
            //     showError(cgpa, 'CGPA is required');
            //     errors.push('CGPA is required');
            //     isValid = false;
            // } else
                if (isNaN(cgpa.value) || parseFloat(cgpa.value) < 0) {
                showError(cgpa, 'CGPA must be a valid number greater than or equal to 0');
                errors.push('Invalid CGPA');
                isValid = false;
            } else if (parseFloat(cgpa.value) > 4.0) {
                showError(cgpa, 'CGPA cannot exceed 4.0');
                errors.push('CGPA too high');
                isValid = false;
            }

            // 9. Gender - Required
            const gender = form.querySelector('[name="gender"]');
            if (!gender || !gender.value) {
                showError(gender, 'Please select a gender.');
                errors.push('Gender is required');
                isValid = false;
            }

            // 10. Salary Payment Type - Required
            // const salaryType = form.querySelector('[name="job_pref_salary_payment_type"]');
            // if (!salaryType || !salaryType.value) {
            //     const salaryContainer = form.querySelector('.nav-tabs')?.closest('.bg-white');
            //     showError(salaryContainer, 'Please select a salary payment type');
            //     errors.push('Salary payment type is required');
            //     isValid = false;
            // }

            // 11. Salary Amount - Required, must be a number, min 0
            const salary = form.querySelector('[name="salary_amount"]');
            // if (!salary || !salary.value.trim()) {
            //     showError(salary, 'Salary amount is required');
            //     errors.push('Salary amount is required');
            //     isValid = false;
            // } else
            //     if (isNaN(salary.value) || parseFloat(salary.value) <= 0) {
            //     showError(salary, 'Salary must be a valid number greater than 0');
            //     errors.push('Invalid salary amount');
            //     isValid = false;
            // }

            // 12. Description - Required
            // const description = form.querySelector('[name="description"]');
            // if (!description || !description.value.trim()) {
            //     showError(description, 'Job description is required');
            //     errors.push('Job description is required');
            //     isValid = false;
            // }

            // 13. Deadline - Required, must be a future date
            const deadline = form.querySelector('[name="deadline"]');
            if (!deadline || !deadline.value) {
                showError(deadline, 'Application deadline is required');
                errors.push('Application deadline is required');
                isValid = false;
            } else {
                const selectedDate = new Date(deadline.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Reset time to compare dates only

                if (selectedDate <= today) {
                    showError(deadline, 'Application deadline must be a future date');
                    errors.push('Invalid deadline date');
                    isValid = false;
                }
            }

            // Display summary if there are errors
            if (!isValid) {
                displayErrorSummary(form, errors);
            }

            return isValid;
        }

        // Helper function to show error messages
        function showError(element, message) {
            if (!element) return;

            // Add error class to input
            if (element.tagName === 'INPUT' || element.tagName === 'SELECT' || element.tagName === 'TEXTAREA') {
                element.classList.add('is-invalid');

                // Create error message element
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback d-block';
                errorDiv.textContent = message;
                element.parentNode.appendChild(errorDiv);
            } else {
                // For containers
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger mt-2 validation-error';
                errorDiv.textContent = message;
                element.appendChild(errorDiv);
            }
        }

        // Helper function to clear all errors
        function clearErrors(form) {
            // Remove error classes
            form.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });

            // Remove error messages
            form.querySelectorAll('.invalid-feedback, .validation-error, .error-summary').forEach(el => {
                el.remove();
            });
        }

        // Display error summary at the top of the form
        function displayErrorSummary(form, errors) {
            const summaryDiv = document.createElement('div');
            summaryDiv.className = 'alert alert-danger error-summary mb-3';
            summaryDiv.innerHTML = `
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            ${errors.map(error => `<li>${error}</li>`).join('')}
        </ul>
    `;

            // Insert at the beginning of the visible step
            const activeStep = form.querySelector('.wizard-step:not(.d-none)');
            if (activeStep) {
                activeStep.insertBefore(summaryDiv, activeStep.firstChild);
                // Scroll to top of modal
                summaryDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        // Initialize validation with jQuery
        $(document).ready(function() {

            // CRITICAL: Validate when clicking "Review & Post" button
            // $(document).on('click', '.show-review-btn', function(e) {
            //     e.preventDefault();
            //     e.stopPropagation();
            //
            //     const formId = 'jobCreateForm';
            //
            //     // Run validation
            //     if (validateJobForm(formId)) {
            //         // Validation passed - allow rest of the functions to work
            //         console.log('Validation passed! Proceeding with review...');
            //
            //         // Add your review modal logic here
            //         // Example: $('#jobDetailsModal').modal('show');
            //
            //         // Or submit the form
            //         // $('#' + formId).submit();
            //
            //         return true;
            //     } else {
            //         // Validation failed - stop everything
            //         console.log('Validation failed! Please fix errors.');
            //         return false;
            //     }
            // });

            // Validate on form submit (as backup)
            $('#jobCreateForm').on('submit', function(e) {
                if (!validateJobForm('jobCreateForm')) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
            });

            // Handle continue to step 2 button
            $('#continueToStep2').on('click', function(e) {
                e.preventDefault();

                const form = $('#jobCreateForm');
                clearErrors(form[0]);
                let isValid = true;
                let errors = [];

                // Validate only Step 1 fields
                const jobTitle = form.find('[name="job_title"]');
                if (!jobTitle.val() || !jobTitle.val().trim()) {
                    showError(jobTitle[0], 'Job title is required');
                    errors.push('Job title is required');
                    isValid = false;
                }

                const jobType = form.find('[name="job_type_id"]:checked');
                if (jobType.length === 0) {
                    const container = form.find('[name="job_type_id"]').first().closest('.mb-4');
                    showError(container[0], 'Please select a job type');
                    errors.push('Job type is required');
                    isValid = false;
                }

                const jobLocationType = form.find('[name="job_location_type_id"]:checked');
                if (jobLocationType.length === 0) {
                    const container = form.find('[name="job_location_type_id"]').first().closest('.mb-4');
                    showError(container[0], 'Please select a job location type');
                    errors.push('Job location type is required');
                    isValid = false;
                }

                if (!isValid) {
                    displayErrorSummary(form[0], errors);
                } else {
                    // Proceed to step 2
                    $('.stepOne').addClass('d-none');
                    $('.stepTwo').removeClass('d-none');
                }
            });

            // Handle back to step 1
            $('#backToStepOne, .return-to-first-part').on('click', function(e) {
                e.preventDefault();
                $('.stepTwo').addClass('d-none');
                $('.stepOne').removeClass('d-none');
                clearErrors($('#jobCreateForm')[0]);
            });

            // Salary type selection handler
            $(document).on('click', '.salary-type', function(e) {
                e.preventDefault();
                $('.salary-type').removeClass('active');
                $(this).addClass('active');
                $('.job_pref_salary_payment_type').val($(this).data('value'));
            });

            // Custom experience field toggle
            $('[name="required_experience"]').on('change', function() {
                if ($(this).val() === 'custom') {
                    $('#customExperienceField').show();
                } else {
                    $('#customExperienceField').hide();
                }
            });

            // Real-time validation - clear error on input
            $(document).on('blur', '#jobCreateForm input, #jobCreateForm select, #jobCreateForm textarea', function() {
                $(this).removeClass('is-invalid');
                $(this).parent().find('.invalid-feedback').remove();
            });

            // Clear error when selecting from multi-select
            $(document).on('change', '#jobCreateForm select[multiple]', function() {
                $(this).removeClass('is-invalid');
                $(this).closest('.bg-white').find('.validation-error').remove();
            });
        });

        // When user clicks "Review & Post"
        // $('.show-review-btn').on('click', function(e) {
        //     e.preventDefault(); // Stop default behavior
        //
        //     if (validateJobForm('jobCreateForm')) {
        //         // ✅ VALIDATION PASSED
        //         // Add your next steps here:
        //         // - Show review modal
        //         // - Submit form
        //         // - Whatever you need
        //         return true;
        //     } else {
        //         // ❌ VALIDATION FAILED
        //         // User sees errors, nothing else happens
        //         return false;
        //     }
        // });
    </script>


{{--    search skill box--}}
{{--    common -create-edit-form skills--}}
    <script>
        $(document).ready(function() {
            let searchTimer;

            // Get form type from element
            function getForm(el) {
                return $(el).closest('[data-form]').data('form') || $(el).data('form');
            }

            // Check if skill is selected
            function isSelected(form, skillId) {
                return $(`.selected-skills-container[data-form="${form}"] .selected-skill-tag[data-id="${skillId}"]`).length > 0;
            }

            // Add skill
            function addSkill(form, skillId, skillName) {
                if (isSelected(form, skillId)) return;

                var tag = `<div class="selected-skill-tag" data-id="${skillId}">
              <input type="hidden" name="required_skills[]" value="${skillId}">
              <span>${skillName}</span>
              <span class="remove-skill">&times;</span>
          </div>`;

                $(`.selected-skills-container[data-form="${form}"]`).append(tag);
                $(`.skill-category-box[data-form="${form}"] .skill-btn[data-id="${skillId}"]`).addClass('selected-skill');
                $(`.skill-search-results[data-form="${form}"] .skill-btn[data-id="${skillId}"]`).addClass('selected-skill');
            }

            // Remove skill
            function removeSkill(form, skillId) {
                $(`.selected-skills-container[data-form="${form}"] .selected-skill-tag[data-id="${skillId}"]`).remove();
                $(`.skill-category-box[data-form="${form}"] .skill-btn[data-id="${skillId}"]`).removeClass('selected-skill');
                $(`.skill-search-results[data-form="${form}"] .skill-btn[data-id="${skillId}"]`).removeClass('selected-skill');
            }

            // Show categories
            function showCategories(form) {
                $(`.skill-search-results[data-form="${form}"]`).addClass('d-none');
                $(`.skill-category-box[data-form="${form}"]`).show();
            }

            // Show search results
            function showSearchResults(form) {
                $(`.skill-search-results[data-form="${form}"]`).removeClass('d-none');
                $(`.skill-category-box[data-form="${form}"]`).hide();
            }

            // Click on category skill
            $(document).on('click', '.skill-category-box .skill-btn', function(e) {
                e.preventDefault();
                var form = getForm(this);
                var skillId = $(this).data('id');
                var skillName = $(this).data('name');

                if (isSelected(form, skillId)) {
                    removeSkill(form, skillId);
                } else {
                    addSkill(form, skillId, skillName);
                }
            });

            // Click on search result skill
            $(document).on('click', '.skill-search-results .skill-btn', function(e) {
                e.preventDefault();
                var form = getForm(this);
                var skillId = $(this).data('id');
                var skillName = $(this).data('name');

                if (isSelected(form, skillId)) {
                    removeSkill(form, skillId);
                } else {
                    addSkill(form, skillId, skillName);
                }
            });

            // Click remove button
            $(document).on('click', '.remove-skill', function(e) {
                e.preventDefault();
                var tag = $(this).closest('.selected-skill-tag');
                var form = getForm(tag.closest('.selected-skills-container'));
                var skillId = tag.data('id');
                removeSkill(form, skillId);
            });

            // Search input
            $(document).on('input', '.skill-search-input', function() {
                clearTimeout(searchTimer);
                var input = $(this);
                var form = input.data('form');
                var query = input.val().trim();

                if (query === '') {
                    showCategories(form);
                    return;
                }

                searchTimer = setTimeout(function() {
                    $.ajax({
                        url: '{{ route("search-skills") }}',
                        method: 'GET',
                        data: { q: query },
                        success: function(skills) {
                            var html = '';
                            if (skills.length === 0) {
                                html = '<p class="text-muted">No skills found</p>';
                            } else {
                                skills.forEach(function(skill) {
                                    var selected = isSelected(form, skill.id) ? 'selected-skill' : '';
                                    var category = skill.skills_category ? ' <small class="text-muted">(' + skill.skills_category.category_name + ')</small>' : '';
                                    html += `<label class="btn border skill-btn m-1 ${selected}" data-id="${skill.id}" data-name="${skill.skill_name}">${skill.skill_name}${category}</label>`;
                                });
                            }
                            $(`.skill-search-results[data-form="${form}"] .skill-search-list`).html(html);
                            showSearchResults(form);
                        }
                    });
                }, 300);
            });

            // Show/hide clear button based on input value
            $(document).on('input', '.skill-search-input', function() {
                const form = $(this).data('form');
                const hasValue = $(this).val().trim().length > 0;
                $(`.clear-skill-search[data-form="${form}"]`).toggle(hasValue);
            });

            // Clear skill search input and show category skills
            $(document).on('click', '.clear-skill-search', function() {
                const form = $(this).data('form');
                $(`.skill-search-input[data-form="${form}"]`).val('').focus();
                $(`.skill-search-results[data-form="${form}"]`).addClass('d-none');
                $(`.skill-category-box[data-form="${form}"]`).show();
                $(this).hide();
            });

            // Modal events - Create
            $('#createJobModal').on('shown.bs.modal', function() {
                $('.skill-search-input[data-form="create"]').val('');
                showCategories('create');
            });

            $('#createJobModal').on('hidden.bs.modal', function() {
                $('.skill-search-input[data-form="create"]').val('');
                $('.selected-skills-container[data-form="create"]').empty();
                $('.skill-category-box[data-form="create"] .skill-btn').removeClass('selected-skill');
                showCategories('create');
            });

            // Modal events - Edit
            $('#editJobModal').on('shown.bs.modal', function() {
                $('.skill-search-input[data-form="edit"]').val('');
                showCategories('edit');
            });

            $('#editJobModal').on('hidden.bs.modal', function() {
                $('.skill-search-input[data-form="edit"]').val('');
                showCategories('edit');
            });
        });
    </script>

{{--    only create form skills--}}
{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            let searchTimeout;--}}

{{--            // Force show categories on page load--}}
{{--            function showCategories() {--}}
{{--                $('#skillSearchResults').addClass('d-none');--}}
{{--                $('#createJobSkillBox nav').show().removeClass('d-none');--}}
{{--                $('#createJobSkillBox .tab-content').show().removeClass('d-none');--}}
{{--            }--}}

{{--            // Force hide categories and show search results--}}
{{--            function showSearchResults() {--}}
{{--                $('#skillSearchResults').removeClass('d-none');--}}
{{--                $('#createJobSkillBox nav').hide();--}}
{{--                $('#createJobSkillBox .tab-content').hide();--}}
{{--            }--}}

{{--            // Initialize - show categories--}}
{{--            showCategories();--}}

{{--            // Add skill to selected container--}}
{{--            function addSkillToSelected(skillId, skillName) {--}}
{{--                if ($('.append-selected-skill-here-to-send-server').find(`input[value="${skillId}"]`).length > 0) {--}}
{{--                    return;--}}
{{--                }--}}

{{--                const skillTag = `--}}
{{--              <div class="selected-skill-tag" data-skill-id="${skillId}">--}}
{{--                  <input type="hidden" name="required_skills[]" value="${skillId}">--}}
{{--                  <span>${skillName}</span>--}}
{{--                  <span class="remove-skill" data-skill-id="${skillId}">&times;</span>--}}
{{--              </div>--}}
{{--          `;--}}
{{--                $('.append-selected-skill-here-to-send-server').append(skillTag);--}}
{{--            }--}}

{{--            // Remove skill from selected container--}}
{{--            function removeSkillFromSelected(skillId) {--}}
{{--                $(`.append-selected-skill-here-to-send-server .selected-skill-tag[data-skill-id="${skillId}"]`).remove();--}}
{{--            }--}}

{{--            // Check if skill is selected--}}
{{--            function isSkillSelected(skillId) {--}}
{{--                return $('.append-selected-skill-here-to-send-server').find(`input[value="${skillId}"]`).length > 0;--}}
{{--            }--}}

{{--            // Update UI state for a skill--}}
{{--            function updateSkillUI(skillId, isSelected) {--}}
{{--                // Update regular skill buttons in categories--}}
{{--                $('#createJobSkillBox input[type="checkbox"]').each(function() {--}}
{{--                    if ($(this).val() == skillId) {--}}
{{--                        $(this).prop('checked', isSelected);--}}
{{--                        var labelFor = $(this).attr('id');--}}
{{--                        var label = $('label[for="' + labelFor + '"]');--}}
{{--                        if (isSelected) {--}}
{{--                            label.addClass('selected-skill');--}}
{{--                        } else {--}}
{{--                            label.removeClass('selected-skill');--}}
{{--                        }--}}
{{--                    }--}}
{{--                });--}}

{{--                // Update search result buttons--}}
{{--                var searchCheckbox = $('#search-skill-' + skillId);--}}
{{--                if (searchCheckbox.length) {--}}
{{--                    searchCheckbox.prop('checked', isSelected);--}}
{{--                    var searchLabel = $('.select-skill-search[data-skill-id="' + skillId + '"]');--}}
{{--                    if (isSelected) {--}}
{{--                        searchLabel.addClass('selected-skill');--}}
{{--                    } else {--}}
{{--                        searchLabel.removeClass('selected-skill');--}}
{{--                    }--}}
{{--                }--}}
{{--            }--}}

{{--            // Handle regular skill selection (from category tabs)--}}
{{--            $(document).on('click', '.select-skill', function(e) {--}}
{{--                e.preventDefault();--}}
{{--                e.stopPropagation();--}}

{{--                var inputId = $(this).attr('data-input-id');--}}
{{--                var input = $('#' + inputId);--}}
{{--                var skillId = input.val();--}}
{{--                var skillName = $(this).text().trim();--}}

{{--                if (isSkillSelected(skillId)) {--}}
{{--                    removeSkillFromSelected(skillId);--}}
{{--                    input.prop('checked', false);--}}
{{--                    $(this).removeClass('selected-skill');--}}
{{--                } else {--}}
{{--                    addSkillToSelected(skillId, skillName);--}}
{{--                    input.prop('checked', true);--}}
{{--                    $(this).addClass('selected-skill');--}}
{{--                }--}}
{{--            });--}}

{{--            // Handle search result skill selection--}}
{{--            $(document).on('click', '.select-skill-search', function(e) {--}}
{{--                e.preventDefault();--}}
{{--                e.stopPropagation();--}}

{{--                var skillId = $(this).data('skill-id');--}}
{{--                var skillName = $(this).data('skill-name');--}}

{{--                if (isSkillSelected(skillId)) {--}}
{{--                    removeSkillFromSelected(skillId);--}}
{{--                    updateSkillUI(skillId, false);--}}
{{--                } else {--}}
{{--                    addSkillToSelected(skillId, skillName);--}}
{{--                    updateSkillUI(skillId, true);--}}
{{--                }--}}
{{--            });--}}

{{--            // Handle remove skill button click--}}
{{--            $(document).on('click', '.remove-skill', function(e) {--}}
{{--                e.preventDefault();--}}
{{--                e.stopPropagation();--}}

{{--                var skillId = $(this).data('skill-id');--}}
{{--                removeSkillFromSelected(skillId);--}}
{{--                updateSkillUI(skillId, false);--}}
{{--            });--}}

{{--            // Skill search handler--}}
{{--            $('#skillSearchInput').on('input keyup change', function() {--}}
{{--                clearTimeout(searchTimeout);--}}
{{--                var query = $(this).val();--}}

{{--                // If empty, show categories immediately--}}
{{--                if (!query || query.trim() === '') {--}}
{{--                    showCategories();--}}
{{--                    return;--}}
{{--                }--}}

{{--                searchTimeout = setTimeout(function() {--}}
{{--                    $.ajax({--}}
{{--                        url: '{{ route("search-skills") }}',--}}
{{--                        method: 'GET',--}}
{{--                        data: { q: query.trim() },--}}
{{--                        success: function(skills) {--}}
{{--                            if (skills.length === 0) {--}}
{{--                                $('#skillSearchResultsList').html('<p class="text-muted">No skills found</p>');--}}
{{--                            } else {--}}
{{--                                var html = '';--}}
{{--                                skills.forEach(function(skill) {--}}
{{--                                    var isSelected = isSkillSelected(skill.id);--}}
{{--                                    var selectedClass = isSelected ? 'selected-skill' : '';--}}
{{--                                    var categoryName = skill.skills_category ? skill.skills_category.category_name : '';--}}

{{--                                    html += '<div class="skill-search-item">' +--}}
{{--                                        '<input type="checkbox" class="btn-check skill-search-checkbox" ' +--}}
{{--                                        'id="search-skill-' + skill.id + '" ' +--}}
{{--                                        'value="' + skill.id + '" ' +--}}
{{--                                        (isSelected ? 'checked' : '') + '>' +--}}
{{--                                        '<label class="btn border select-skill-search ' + selectedClass + '" ' +--}}
{{--                                        'for="search-skill-' + skill.id + '" ' +--}}
{{--                                        'data-skill-id="' + skill.id + '" ' +--}}
{{--                                        'data-skill-name="' + skill.skill_name + '">' +--}}
{{--                                        skill.skill_name +--}}
{{--                                        (categoryName ? ' <small class="text-muted">(' + categoryName + ')</small>' : '') +--}}
{{--                                        '</label>' +--}}
{{--                                        '</div>';--}}
{{--                                });--}}
{{--                                $('#skillSearchResultsList').html(html);--}}
{{--                            }--}}
{{--                            showSearchResults();--}}
{{--                        },--}}
{{--                        error: function() {--}}
{{--                            $('#skillSearchResultsList').html('<p class="text-danger">Error searching skills</p>');--}}
{{--                        }--}}
{{--                    });--}}
{{--                }, 300);--}}
{{--            });--}}

{{--            // When modal opens--}}
{{--            $('#createJobModal').on('shown.bs.modal', function() {--}}
{{--                $('#skillSearchInput').val('');--}}
{{--                showCategories();--}}
{{--            });--}}

{{--            // When modal closes--}}
{{--            $('#createJobModal').on('hidden.bs.modal', function() {--}}
{{--                $('#skillSearchInput').val('');--}}
{{--                showCategories();--}}
{{--                $('.append-selected-skill-here-to-send-server').empty();--}}
{{--                $('#createJobSkillBox input[type="checkbox"]').prop('checked', false);--}}
{{--                $('#createJobSkillBox .select-skill').removeClass('selected-skill');--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

@endpush
