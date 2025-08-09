@extends('frontend.employer.master')

@section('title', 'my-jobs')

@section('body')
    <!-- Dashboard Content -->
    <main class="dashboardContent p-4">
        <div class="container-fluid">
            <div class="row">

                <!-- Main Content -->
                <section class="col-8 mx-auto">
                    <!-- my search job top -->
                    <div class="my-jobs-section mb-4 ">
                        <div class="container-fluid">
                            <form action="{{ route('employer.job-tasks.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <!-- STEP 1 -->
                                <div class="stepOne card card-body">
                                    <!-- Modal Header -->
                                    <div class="d-flex align-items-center gap-2 mb-4">
                                        <a href="{{ route('employer.my-jobs') }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt="" class="me-2" style="cursor: default;"></a>
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

                                        </div>

                                        <!-- Footer Buttons -->
{{--                                        <div class="d-flex justify-content-between align-items-center">--}}
{{--                                            <button class="btn btn-outline-dark px-4 py-2 rounded-3" data-bs-dismiss="modal">Cancel</button>--}}
{{--                                            <button id="continueToStep2" type="button" class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-3">Continue</button>--}}
{{--                                        </div>--}}
                                    </div>

                                    <!-- STEP 2 -->
                                    <div class="jobModalForPost stepTwo mt-3 pt-3" style="background-color: #f2f2f4;">
                                        <!-- Container and header -->
{{--                                        <div class="container-fluid py-3 border-bottom mb-4 bg-white">--}}
{{--                                            <div class="d-flex justify-content-between align-items-center">--}}
{{--                                                <div class="d-flex align-items-center gap-2 backToStepOne" id="backToStepOne" style="cursor:pointer">--}}
{{--                                                    <img src="{{ asset('/') }}frontend/employee/images/authentication images/leftArrow.png" alt="Back" style="width:20px; height:20px;">--}}
{{--                                                    <h5 class="fw-bold mb-0">Create a job</h5>--}}
{{--                                                </div>--}}
{{--                                                <!-- Button triggers modal -->--}}
{{--                                                --}}{{--                                <button type="button" class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#jobDetailsModal">--}}
{{--                                                --}}{{--                                    Review & Post--}}
{{--                                                --}}{{--                                </button>--}}
{{--                                                <button type="submit" class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-3" --}}{{--data-bs-toggle="modal" data-bs-target="#jobDetailsModal"--}}{{-->--}}
{{--                                                    Post Job--}}
{{--                                                </button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                        <!-- Your provided step 2 content starts here -->
                                        <div style="background-color: #f2f2f4;" class="jobModalForPost">
                                            <!-- Container and header -->



                                            <!-- Main Job Info Card -->
{{--                                            <div class="container mb-4">--}}
{{--                                                <div class="bg-white rounded-4 p-4 shadow-sm">--}}
{{--                                                    <div class="d-flex justify-content-between flex-wrap gap-3">--}}
{{--                                                        <div>--}}
{{--                                                            <h5 class="fw-semibold mb-2"><span id="formJobTitle">IT Support, Corporate Banking</span></h5>--}}
{{--                                                            <div class="d-flex flex-wrap gap-2">--}}
{{--                                                                <span class="badge bg-light text-dark"><span id="jobJobType">Full Time</span></span>--}}
{{--                                                                <span class="badge bg-light text-dark"><span id="jobjobLocationType">Hybrid</span></span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div>--}}
{{--                                                            <a href="#" class="text-decoration-none text-muted return-to-first-part"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Edit pencil.png" alt=""> Edit</a>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

                                            <!-- Experience Card -->
                                            <div class="container mb-4">
                                                <div class="bg-white rounded-4 p-4 shadow-sm">
                                                    <h6 class="fw-semibold mb-3">Required years of experience</h6>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <input type="radio" class="btn-check" name="required_experience" id="exp-any" value="any" autocomplete="off" checked>
                                                        <label class="btn btn-outline-warning" for="exp-any">Any</label>

                                                        <input type="radio" class="btn-check" name="required_experience" id="exp-1to3" value="1–3" autocomplete="off">
                                                        <label class="btn btn-outline-warning" for="exp-1to3">1–3 yrs</label>

                                                        <input type="radio" class="btn-check" name="required_experience" id="exp-0" value="0" autocomplete="off">
                                                        <label class="btn btn-outline-warning" for="exp-0">N/A</label>

                                                        <input type="radio" class="btn-check" name="required_experience" id="custom" value="custom" autocomplete="off">
                                                        <label id="showCustomExperienceField" class="btn btn-outline-warning" for="custom">Custom</label>
                                                        <span id="customExperienceField" style="display: none">
                                                            <input type="text" style="width: 60px; background-color: darkgrey;" class="btn btn-outline-primary " name="exp_range_start"> to <input type="text" style="width: 60px; background-color: darkgrey;" class="btn btn-outline-primary " name="exp_range_end"> Years
                                                        </span>

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


                                            <!-- Industry -->
                                            <div class="container mb-4">
                                                <div class="bg-white rounded-4 p-4 shadow-sm">
                                                    <h6 class="fw-semibold mb-3">Industry</h6>
                                                    {{--                                    <input type="text" class="form-control mb-3" name="" placeholder="Search universities">--}}
                                                    <select name="industry_id" id="select2-div" class="select2 form-control w-100"  >

                                                        @foreach($industries as $industryKey => $industry)
                                                            <option value="{{ $industry->id }}">{{ $industry->name ?? 'un' }}</option>
                                                        @endforeach
                                                    </select>
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
                                                </div>
                                            </div>

                                            <!-- Field of Study -->
                                            <div class="container mb-4">
                                                <div class="bg-white rounded-4 p-4 shadow-sm">
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
                                            <div class="container mb-4">
                                                <div class="bg-white rounded-4 p-4 shadow-sm">
                                                    <h6 class="fw-semibold mb-3">CGPA preference</h6>
                                                    <input type="text" name="cgpa" class="form-control" placeholder="e.g. 3.50 to 3.90">
                                                </div>
                                            </div>
                                            <!-- Gender Preference -->
                                            <div class="container mb-4">
                                                <div class="bg-white rounded-4 p-4 shadow-sm">
                                                    <h6 class="fw-semibold mb-3">Gender preference</h6>
                                                    <select name="gender" id="" class="form-control select2 w-100">
                                                        <option value="" disabled selected>Select a gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                        <option value="all">All</option>
                                                    </select>
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

                                            <button type="submit" class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-3 float-end">Submit</button>

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

                                    </div>

                                    <!-- For brevity not repeating entire step 2 HTML, will render in browser from provided -->

                                </div>
                            </form>
                        </div>
                    </div>


                </section>
            </div>
        </div>

    </main>

@endsection



@push('style')
    <style>
        .select2-container {width: 100%!important;}
    </style>
@endpush

@push('script')

    @include('common-resource-files.selectize')
    @include('common-resource-files.summernote')

    <!-- include summernote css/js -->
{{--    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>--}}

    <script>
        $(document).on('click', '.edit-job', function () {
            var jobId = $(this).attr('data-job-id');
            // var thisObject = $(this);
            // console.log(thisObject);
            sendAjaxRequest('employer/job-tasks/'+jobId+'/edit', 'GET').then(function (response) {
                // console.log(response);
                $('#editJobForm').empty().append(response);
                $('.summernote').summernote({
                    height: 300
                });
                $('.select2').selectize();
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
    </script>
@endpush
