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

                            <div class="mj-header">
                                <div class="mj-header-left">
                                    <h1 class="mj-page-title">{{ trans('employer.my_jobs') }}</h1>
                                    <p class="mj-page-subtitle">{{ trans('employer.see_all_posted_jobs') }}</p>
                                </div>
                                <button class="mj-post-btn" data-bs-toggle="modal" data-bs-target="#createJobModal">
                                    <i class="fas fa-plus"></i> {{ trans('employer.post_a_job') }}
                                </button>
                            </div>

                            <!-- Mobile Search -->
                            <div class="d-block d-md-none mb-3">
                                <div class="mj-search-wrap">
                                    <i class="fas fa-search mj-search-icon"></i>
                                    <input type="text" class="mj-search-input" id="mobile_search_text" placeholder="Search jobs..." />
                                    <button class="mj-search-clear" type="button" onclick="document.getElementById('mobile_search_text').value = '';"><i class="fas fa-times"></i></button>
                                    <button class="mj-search-submit" type="button" onclick="searchOnMobile()"><i class="fas fa-arrow-right"></i></button>
                                </div>
                                <div class="mj-tabs mt-3">
                                    <a href="{{ route('employer.my-jobs', ['job_status' => 'open']) }}" class="mj-tab {{ request('job_status') != 'closed' ? 'active' : '' }}">
                                        <span class="mj-tab-dot open"></span> {{ trans('employer.open_jobs') }}
                                    </a>
                                    <a href="{{ route('employer.my-jobs', ['job_status' => 'closed']) }}" class="mj-tab {{ request('job_status') == 'closed' ? 'active' : '' }}">
                                        <span class="mj-tab-dot closed"></span> {{ trans('employer.closed_jobs') }}
                                    </a>
                                </div>
                            </div>

                            <!-- Desktop Toolbar -->
                            <div class="mj-toolbar d-none d-md-flex">
                                <div class="mj-tabs">
                                    <a href="{{ route('employer.my-jobs', ['job_status' => 'open']) }}" class="mj-tab {{ request('job_status') != 'closed' ? 'active' : '' }}">
                                        <span class="mj-tab-dot open"></span> {{ trans('employer.open_jobs') }}
                                    </a>
                                    <a href="{{ route('employer.my-jobs', ['job_status' => 'closed']) }}" class="mj-tab {{ request('job_status') == 'closed' ? 'active' : '' }}">
                                        <span class="mj-tab-dot closed"></span> {{ trans('employer.closed_jobs') }}
                                    </a>
                                </div>
                                <div class="mj-search-wrap">
                                    <i class="fas fa-search mj-search-icon"></i>
                                    <form action="" id="searchForm" style="display:contents;">
                                        <input type="text" class="mj-search-input" id="desktop_search_text" name="search_text" value="{{ $_GET['search_text'] ?? '' }}" placeholder="{{ trans('employer.search_jobs') }}" />
                                    </form>
                                    <button class="mj-search-clear" type="button" style="cursor:pointer;" onclick="document.getElementById('desktop_search_text').value = '';"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>









                    <!-- Job Cards -->
                    <div class="row gy-3 jobCardsWrapper">
                        <!-- Job Card -->
                        @forelse($publishedJobs as $key => $publishedJob)
                            <div class="col-12">
                                <article class="job-card mj-card">
                                    <div class="mj-card-accent {{ $publishedJob->status == 1 ? 'open' : 'closed' }}"></div>
                                    <div class="mj-card-body">
                                        <div class="job-main mj-card-main clickable-area show-job-details" data-job-id="{{ $publishedJob->id }}" style="cursor: pointer;">
                                            <div class="mj-card-title-row">
                                                <h6 class="job-title mj-card-title">{{ $publishedJob->job_title ?? trans('common.job_title') }}</h6>
                                                <span class="mj-status-badge {{ $publishedJob->status == 1 ? 'open' : 'closed' }}">{{ $publishedJob->status == 1 ? 'Active' : 'Closed' }}</span>
                                            </div>
                                            <div class="job-badges mj-card-badges d-flex flex-wrap gap-2">
                                                <span class="badge">{{ $publishedJob?->jobType?->name ?? trans('common.job_type') }}</span>
                                                <span class="badge">{{ $publishedJob?->jobLocationType?->name ?? trans('common.job_location') }}</span>
                                            </div>
                                        </div>
                                        <div class="job-info mj-card-meta">
                                            <div class="mj-meta-item">
                                                <i class="far fa-calendar-plus"></i>
                                                <span>{{ trans('employer.posted_on') }} {{ $publishedJob->created_at->format('d M, Y') }}</span>
                                            </div>
                                            <div class="mj-meta-item">
                                                <i class="far fa-clock"></i>
                                                <span>{{ trans('employer.deadline') }} {{ \Illuminate\Support\Carbon::parse($publishedJob->deadline)->format('d M, Y') }}</span>
                                            </div>
                                            <div class="mj-meta-item">
                                                <i class="far fa-user"></i>
                                                <a href="{{ route('employer.my-job-applicants', ['jobTask' => $publishedJob->id]) }}">{{ $publishedJob->employeeAppliedJobs->count() ?? 0 }} {{ trans('employer.applicants') }}</a>
                                            </div>
                                        </div>
                                        <div class="job-actions mj-card-actions dropdown">
                                            <button class="mj-dots-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end mj-dropdown">
                                                <li><a class="dropdown-item close-job" href="{{ route('employer.close-job', ['jobTask' => $publishedJob->id, 'status' => $publishedJob->status == 1 ? 0 : 1]) }}" data-job-id="{{ $publishedJob->id }}"><i class="fas {{ $publishedJob->status == 1 ? 'fa-pause-circle' : 'fa-play-circle' }} me-2"></i>{{ $publishedJob->status == 1 ? 'Close Job' : 'Open Job' }}</a></li>
                                                <li><a class="dropdown-item edit-job" href="javascript:void(0)" data-job-id="{{ $publishedJob->id }}"><i class="fas fa-pen me-2"></i>{{ trans('common.edit') }}</a></li>
                                                <li>
                                                    <form action="{{ route('employer.job-tasks.destroy', $publishedJob->id) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="dropdown-item text-danger" type="submit"><i class="fas fa-trash-alt me-2"></i>{{ trans('common.delete') }}</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="mj-empty-state">
                                    <div class="mj-empty-icon">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <h5 class="mj-empty-title">{{ isset($_GET['job_status']) && $_GET['job_status'] == 'closed' ? trans('employer.no_closed_job_found') :trans('employer.no_available_job_found') }}</h5>
                                    <p class="mj-empty-text">Post your first job to start receiving applications</p>
                                    <button class="mj-post-btn" data-bs-toggle="modal" data-bs-target="#createJobModal">
                                        <i class="fas fa-plus"></i> {{ trans('employer.post_a_job') }}
                                    </button>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    @if($publishedJobs->hasPages())
                        <div class="mj-pagination mt-4">
                            {{ $publishedJobs->appends(request()->query())->links() }}
                        </div>
                    @endif
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
                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt="" class="me-2" data-bs-dismiss="modal"> <span>Job details</span>
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
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt="" data-bs-dismiss="modal" class="me-2" style="cursor: default;">
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
                                    <input type="number" min="0" name="cgpa" class="form-control" placeholder="Ex: 3.50">
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
                                    <ul class="nav nav-pills mb-3" id="salaryTab" role="tablist">
                                        <li class="nav-item"><a class="nav-link active salary-type" data-value="monthly" data-bs-toggle="pill" href="#">Monthly</a></li>
                                        <li class="nav-item"><a class="nav-link salary-type" data-value="hourly" data-bs-toggle="pill" href="#">Hourly</a></li>
                                        <li class="nav-item"><a class="nav-link salary-type" data-value="yearly" data-bs-toggle="pill" href="#">Yearly</a></li>
                                        <li class="nav-item"><a class="nav-link salary-type" data-value="fixed" data-bs-toggle="pill" href="#">Fixed amount</a></li>
                                    </ul>
                                    <input type="hidden" name="job_pref_salary_payment_type" class="job_pref_salary_payment_type" value="monthly">
                                    <input type="number" min="0" name="salary_amount" class="form-control mb-2" placeholder="Ex: 50,000">
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
                        <p class="mb-1"><b>Salary (BDT)</b></p>
                        <p ><span id="reviewSalary">BDT 10000</span> / <span id="view_job_pref_salary_payment_type">month</span></p>
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
    <link rel="stylesheet" href="{{ asset('frontend/page-custom-codes/employer/my-jobs/style.css') }}" />

@endpush

@push('script')

    @include('common-resource-files.select2')
{{--    @include('common-resource-files.')--}}
{{--    @include('common-resource-files.summernote')--}}
    <script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

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

    <script src="{{ asset('frontend/page-custom-codes/employer/my-jobs/script.js') }}"></script>

@endpush
