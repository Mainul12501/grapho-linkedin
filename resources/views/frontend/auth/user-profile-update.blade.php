@extends('frontend.employee.master')
@section('title')
    Update Profile
@endsection
    @section('body')
        <div class="page" style="display: none">
            <div class="card">
                <h1>Profile Setup Wizard</h1>
                <p class="muted">4-step modal that posts each step to backend.</p>
                <button class="btn btn-primary" id="launch">Open Wizard</button>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#jobPreferenceModal" id="jobPreferenceModalBtn">
                Open Job Preference Form
            </button>
        </div>
        <form action="{{ route('logout') }}" method="post" id="logoutForm">
            @csrf
        </form>
        @if($loggedUser->user_type == 'employee')
            <div class="overlay" id="overlay" role="dialog" aria-modal="true" aria-labelledby="wizTitle">
                <div class="custom-modal" id="modal">
                    <div class="custom-modal-header">
                        <div class="title-wrap">
                            <span class="step-badge" id="stepBadge">Step 1 of 4</span>
                            <h2 id="wizTitle" style="margin:0;font-size:18px">Edit Contact Information</h2>
                        </div>
                        <button class="btn-ghost" id="closeX" style="display: none" aria-label="Close">✕</button>
                        <button class="btn-ghost" id="" type="button" style="cursor: pointer" aria-label="Close" onclick="document.getElementById('logoutForm').submit()">Logout</button>

                    </div>
                    <div class="progress"><i id="bar"></i></div>
                    <div class="custom-modal-body" id="modalBody"></div>
                    <div class="custom-modal-footer">
                        <div class="left-actions">
                            <button class="btn" id="closeBtn" style="display: none">Close</button>
                            <span class="saved" id="savedMsg" style="display: none">Saved</span>
                            <span class="error" id="errorMsg" style="display: none"></span>
                        </div>
                        <div class="right-actions">
                            <button class="btn" id="prevBtn">Previous</button>
                            <button class="btn btn-primary" id="nextBtn">Next</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 0 -->
            <template id="step-0">
                <form id="form-contact" autocomplete="on" novalidate enctype="multipart/form-data" method="post" action="">
                    <input type="hidden" name="user_id" value="{{ $loggedUser->id ?? '' }}" id="userId">
                    <input type="hidden" name="is_profile_updated" value="1" >
                    <div class="grid grid-1">
                        <div class="">
                            <div class="grid-gap-y"><label>Title <span style="color: red">*</span></label><input name="profile_title" type="text" placeholder="Mobile App Developer" value="{{ $loggedUser->profile_title ?? '' }}" required /></div>
                            <div class="grid-gap-y"><label>Name <span style="color: red">*</span></label><input name="name" type="email" value="{{ $loggedUser->name ?? '' }}" placeholder="Jhon Doe" required /></div>
                            <div class="grid-gap-y"><label>Email <span style="color: red">*</span></label><input name="email" type="email" value="{{ $loggedUser->email ?? '' }}" required /></div>
                            <div class="grid-gap-y"><label>Phone <span style="color: red">*</span></label><input name="mobile" type="tel" value="{{ $loggedUser->mobile }}" /></div>
                            <div class="grid-gap-y"><label>Gender</label><select name="gender" id="">
                                    <option value="male">Male</option><option value="female">Female</option></select></div>
                            <div class="grid-gap-y"><label>Address</label><input name="address" type="text" value="{{ $loggedUser->address ?? '' }}" /></div>
                            <div class="grid-gap-y">
                                <label>Division</label>
                                <select name="division" id="divisions" onchange="divisionsList();">
                                    <option disabled selected>Select Division</option>
                                    <option value="Barishal" >Barishal</option>
                                    <option value="Chattogram" >Chattogram</option>
                                    <option value="Dhaka" >Dhaka</option>
                                    <option value="Khulna" >Khulna</option>
                                    <option value="Mymensingh" >Mymensingh</option>
                                    <option value="Rajshahi" >Rajshahi</option>
                                    <option value="Rangpur" >Rangpur</option>
                                    <option value="Sylhet" >Sylhet</option>
                                </select>
                            </div>
                            <div class="grid-gap-y"><label>District</label><select name="district" id="distr" onchange="thanaList();"></select><!--/ Districts Section--></div>
                            <div class="grid-gap-y"><label>Post Office</label><select name="post_office" id="polic_sta"></select><!--/ Police Station Section--></div>
                            <div class="grid-gap-y"><label>Post Code</label><input name="postal_code" type="text" min="0" value="" placeholder="1200" /></div>
                            <div class="grid-gap-y"><label>Currently available to work?</label><select name="is_open_for_hire" id="">
                                    <option value="1">Yes</option><option value="0">No</option></select></div>

                        </div>
                    </div>
                    <div style="margin-top:14px;text-align:right">
                        <button class="btn btn-primary" id="employeeProfileUpdateBtn" type="button">Save Changes</button>
                    </div>
                </form>
            </template>

            <!-- STEP 1 -->
            <template id="step-1">
                <form id="form-education" autocomplete="on" novalidate>
                    @csrf
                    <div class="grid grid-1">
                        <div class="">
                            <div class="grid-gap-y">
                                <label>Program Name</label>
                                <select name="education_degree_name_id" id="">
                                    <option value="" disabled>Select Degree</option>
                                    @foreach($educationDegreeNames as $degreeName)
                                        <option value="{{ $degreeName->id }}" has-institute-name="{{ $degreeName->need_institute_field }}">{{ $degreeName->degree_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="universityDiv">
                                <div class="grid-gap-y"><label>Name of Institution</label>
                                    <input type="text" class="form-control" name="institute_name" id="instituteName" placeholder="Type here" />
{{--                                    <select name="university_name_id" class="form-control select2" id="">--}}
{{--                                        <option selected disabled>Select University</option>--}}
{{--                                        @foreach($universityNames as $universityName)--}}
{{--                                            <option value="{{ $universityName->id }}">{{ $universityName->name }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
                                </div>
                                <div class="grid-gap-y"><label>Background / Field of study</label>
                                    <input type="text" class="form-control" name="field_of_study" id="fieldOfStudyInput" placeholder="Type here" />
{{--                                    <select name="field_of_study_id" class="form-control select2" id="">--}}
{{--                                        <option selected disabled>Select Field of Study</option>--}}
{{--                                        @foreach($fieldOfStudies as $fieldOfStudy)--}}
{{--                                            <option value="{{ $fieldOfStudy->id }}">{{ $fieldOfStudy->field_name }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
                                </div>
                            </div>

                            <div class="grid-gap-y"><label>Passing Year</label><input name="passing_year" type="text" /></div>
                            <div class="grid-gap-y"><label for="cgpaInput">CGPA</label><input name="cgpa" type="text" id="cgpaInput" /></div>

                        </div>

                    </div>
                    <div style="margin-top:14px;text-align:right">
                        <button class="btn btn-primary" id="employeeEducationBtn" type="button">Add Education</button>
                    </div>
                </form>
            </template>

            <!-- STEP 2 -->
            <template id="step-2">
                <form id="form-work" autocomplete="on" novalidate method="post" action="">
                    @csrf
                    <div class="grid grid-1">
                        <div class="">
                            <div class="grid-gap-y"><label>Resignation</label><input name="title" type="text" required /></div>
                            <div class="grid-gap-y">
                                <label>Job type</label>
                                <select name="job_type" required>
                                    <option value="">Select</option>
                                    <option value="full_time">Full-time</option>
                                    <option value="part_time">Part-time</option>
                                    <option value="contractual">Contractual</option>
                                </select>
                            </div>
                            <div class="grid-gap-y"><label>Company/Organization Name</label><input list="companyDatalist" type="text" name="company_name"></div>


                        </div>
                        {{--            <div><label>Company/Organization</label><input name="company" type="text" required /></div>--}}
                        <div class="grid">
                            <div>
                                <label>From</label>
                                {{--                    <select name="start_month" required>--}}
                                {{--                        <option value="">Month</option>--}}
                                {{--                        <option>January</option><option>February</option><option>March</option>--}}
                                {{--                        <option>April</option><option>May</option><option>June</option>--}}
                                {{--                        <option>July</option><option>August</option><option>September</option>--}}
                                {{--                        <option>October</option><option>November</option><option>December</option>--}}
                                {{--                    </select>--}}
                                <input type="text" class="datepicker" id="datepicker1" name="start_date" >
                            </div>
                            {{--                <div><label>Start year</label><select name="start_year" required><option value="">Year</option></select></div>--}}
                            <div><label>To</label><input name="end_date" id="datepicker2" type="text" class="datepicker" ></div>
                        </div>
                        <div class="grid-gap-y"><label for="currentJobCheck"><input type="checkbox" id="currentJobCheck" name="is_working_currently" /> I currently work here</label></div>

                    </div>
                    <div>
                        <div class="grid-gap-y"><label>Location</label><input name="office_address" type="text" /></div>
                        <div class="grid-gap-y"><label>Job Responsibilities</label><textarea name="job_responsibilities"></textarea></div>
                    </div>
                    <div style="margin-top:14px;text-align:right">
                        <button class="btn btn-primary" id="employeeWorkExpBtn" type="button">Add Experience</button>
                    </div>
                </form>
            </template>

            <!-- STEP 3 -->
            <template id="step-3">
                <form id="form-document" autocomplete="on" novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-1">
                        <div>
                            <label>Document Title</label>
{{--                            <input name="title" type="text"  required />--}}
                            <select name="title" class="form-control select2" id="">
                                <option value="CV">CV</option>
                                <option value="NID">NID</option>
                                <option value="Certificate">Certificate</option>
                            </select>
                        </div>
                        <div>
                            <label>Document</label>
                            <input name="file" type="file" accept=".pdf,.doc,.docx,image/*" required />
                            <p class="muted">preferred (≤ 2MB)</p>
                        </div>
                    </div>
                    <div style="margin-top:14px;text-align:right">
                        <button class="btn btn-primary" id="employeeDocumentBtn" type="button">Upload Document</button>
                    </div>
                </form>
            </template>





        @elseif($loggedUser->user_type == 'employer')
            <div class="overlay" id="overlay" role="dialog" aria-modal="true" aria-labelledby="wizTitle">
                <div class="modal " id="modal">
                    <div class="modal-header">
                        <div class="title-wrap">
                            <span class="step-badge" style="display: none" id="stepBadge">Step 1 of 4</span>
                            <h2 id="wizTitle" style="margin:0;font-size:18px">Edit Company Information</h2>
                        </div>
                        <button class="btn-ghost" id="closeX" style="display: none" aria-label="Close">✕</button>
                        <button class="btn-ghost" id="" type="button" style="cursor: pointer" aria-label="Close" onclick="document.getElementById('logoutForm').submit()">Logout</button>

                    </div>
                    <div class="progress"><i id="bar"></i></div>
                    <div class="modal-body" id="modalBody"></div>
                    <div class="modal-footer">
                        <div class="left-actions">
                            <button class="btn" id="closeBtn" style="display: none">Close</button>
                            <span class="saved" id="savedMsg" style="display: none">Saved</span>
                            <span class="error" id="errorMsg" style="display: none"></span>
                        </div>
                        <div class="right-actions">
                            <button class="btn" style="display: none" id="prevBtn">Previous</button>
                            <button class="btn btn-primary" style="display: none" id="nextBtn">Next</button>
                            <button class="btn btn-primary" id="updateCompanyInfo" type="button">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 0 -->
            <template id="step-0">
                <form id="form-employer-contact" autocomplete="on" novalidate enctype="multipart/form-data" method="post" action="">
                    <div class="grid grid-1">
                        <div class="grid">
                            <div><label>Company Name <span style="color: red">*</span></label><input name="name" type="text" value="{{ $loggedUser?->employerCompany?->name ?? '' }}" placeholder="Company Name" required /></div>
                            <div><label>Address</label><input name="address" type="text" value="{{ $loggedUser->address ?? '' }}" placeholder="company Address" /></div>
                        </div>
                        <div class="grid">
                            <input type="hidden" name="user_id" value="{{ $loggedUser->id ?? '' }}" id="userId">
                            <input type="hidden" name="is_profile_updated" value="1" >
                            <div><label>Email <span style="color: red">*</span></label><input name="email" type="email" value="{{ $loggedUser->email ?? '' }}" required /></div>
                            <div><label>Phone <span style="color: red">*</span></label><input name="mobile" type="tel" value="{{ $loggedUser->mobile }}" /></div>
                        </div>
                        <div class="grid">
                            <div><label>Founded On <span style="color: red">*</span></label><input name="founded_on" type="text" placeholder="Founded On" value="" required /></div>
                            <div><label>Total Employees <span style="color: red">*</span></label><input name="total_employees" type="text"  required /></div>
                        </div>

                        <div class="grid">
                            <div>
                                <label>Company Category</label>
                                <select name="employer_company_category_id" id="">
                                    <option disabled selected>Select Company Category</option>
                                    @foreach($employerCompanyCategories as $employerCompanyCategory)
                                        <option value="{{ $employerCompanyCategory->id }}">{{ $employerCompanyCategory->category_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div>
                                <label>Industry</label>
                                <select name="industry_id" id="">
                                    <option disabled selected>Select Industry</option>
                                    @foreach($industries as $industry)
                                        <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid">
                            <div><label>Bin Number</label><input type="text" name="bin_number" value="{{ $loggedUser?->employerCompany?->bin_number ?? '' }}" placeholder="Bin Number"></div>
                            <div><label>Trade License Number</label><input type="text" name="trade_license_number" value="{{ $loggedUser?->employerCompany?->trade_license_number ?? '' }}" placeholder="Trade License Number"></div>
                        </div>
                        <div class="grid">
                            <div><label>Website</label><input name="website" type="text" value="" placeholder="www.website.com" /></div>
                            <div><label>Logo</label><input name="logo" type="file" accept="image/*" /></div>
                        </div>
                        <div class="">
                            <div><label>OverView</label><textarea name="company_overview" id="" style="width: 100%" rows="10"></textarea></div>

                        </div>
                    </div>
                    {{--            <div style="margin-top:14px;text-align:right">--}}
                    {{--                <button class="btn btn-primary" id="employeeProfileUpdateBtn" type="button">Save Changes</button>--}}
                    {{--            </div>--}}
                </form>
            </template>
        @endif


        <div class="toast" id="toast"></div>

        <datalist id="companyDatalist">
            @foreach($companyList as $company)
                <option value="{{ $company->name }}"></option>
            @endforeach
        </datalist>
    @endsection
@section('modal')
    <!-- Job Preference Modal -->
    <div class="modal fade " id="jobPreferenceModal" tabindex="-1" aria-labelledby="jobPreferenceModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobPreferenceModalLabel">Job Preferences</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div id="stepIndicator" class="step-indicator">
                            <!-- Step indicators will be generated dynamically -->
                        </div>
                    </div>

                    <!-- Form -->
                    <form id="jobPreferenceForm">


                        <!-- Step 1: You are looking for -->
                        <div class="form-step active" data-step="1">
                            <div class="text-center mb-4">
                                <h4>What are you looking for?</h4>
                                <p class="text-muted">Select your preferred work schedule</p>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <label for="workType" class="form-label">You are looking for</label>
                                    <select class="form-select-lg select2" name="job_type_id[]" multiple id="workType" required>
                                        <option value="" disabled>Choose your preference</option>
                                        @foreach($jobTypes as $jobType)
                                            <option value="{{ $jobType->id }}">{{ $jobType->name ?? '' }}</option>
                                        @endforeach
                                        {{--                                        <option value="parttime">Part-time</option>--}}
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select your work preference.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Interested in -->
                        <div class="form-step" data-step="2">
                            <div class="text-center mb-4">
                                <h4>Where do you prefer to work?</h4>
                                <p class="text-muted">Select your work location preference</p>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <label for="workLocation" class="form-label">Interested in</label>
                                    <select class="form-select-lg select2" name="job_location_type_id[]" multiple id="workLocation" required>
                                        <option value="" disabled>Choose your preference</option>
                                        @foreach($jobLocationTypes as $jobLocationType)
                                            <option value="{{ $jobLocationType->id }}">{{ $jobLocationType->name ?? '' }}</option>
                                        @endforeach
                                        {{--                                        <option value="onsite">On-site</option>--}}
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select your work location preference.
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Step 3: You are looking for -->
                        <div class="form-step " data-step="3">
                            <div class="text-center mb-4">
                                <h4>How do you look like?</h4>
                                <p class="text-muted">Set Your Profile Image</p>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <label for="workType" class="form-label">You are looking for</label>
                                    @include('common-resource-files.drag-drop-crop', ['modalId' => 'jobPreferenceModal'])
                                    <div class="invalid-feedback">
                                        Please select your work preference.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--
                        EXAMPLE: How to add a new step - Just copy this structure:

                        <div class="form-step" data-step="3">
                            <div class="text-center mb-4">
                                <h4>Your Question Title</h4>
                                <p class="text-muted">Your question description</p>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <label for="yourField" class="form-label">Your Label</label>
                                    <select class="form-select form-select-lg" name="your_field" id="yourField" required>
                                        <option value="">Choose option</option>
                                        <option value="option1">Option 1</option>
                                        <option value="option2">Option 2</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select an option.
                                    </div>
                                </div>
                            </div>
                        </div>
                        -->

                    </form>
                </div>

                <div class="modal-footer">
                    <div>
                        <!-- Previous button on the left -->
                        <button type="button" class="btn btn-outline-primary" id="jobPreferencePrevBtn">
                            Previous
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="jobPreferenceNextBtn">Next</button>
                        <button type="button" class="btn btn-success" id="jobPreferenceSubmitBtn" style="display: none;">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('/common-assets/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/auth/user-profile-update.css') }}">


{{--    job preference modal css--}}
    <style>
        .form-step {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .form-step.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .progress-bar {
            transition: width 0.3s ease;
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            background-color: #e9ecef;
            color: #6c757d;
            position: relative;
        }

        .step-circle.active {
            background-color: #0d6efd;
            color: white;
        }

        .step-circle.completed {
            background-color: #198754;
            color: white;
        }

        .step-circle:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 100%;
            width: calc(100vw / var(--total-steps) - 175px); /* default was 30px */
            height: 2px;
            background-color: #e9ecef;
            transform: translateY(-50%);
        }

        .step-circle.completed:not(:last-child)::after {
            background-color: #198754;
        }

        /* previous btn */
        #jobPreferencePrevBtn {
            border-color: #0d6efd;
            color: #0d6efd;
        }

        #jobPreferencePrevBtn:hover {
            background-color: #0d6efd;
            color: white;
        }
        /*grid gap*/
        .grid-gap-y {margin-bottom: 8px; margin-top: 8px;}
    </style>
@endpush

@push('script')


    <script src="{{ asset('/frontend/employee/division-Districts-post-station/javascript.js') }}"></script>
{{--    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>--}}
    <script src="{{ asset('/common-assets/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- select which modal will show first -->
    <script>
        $(function () {
            @if($loggedUser->user_type == 'employee')
                $('#jobPreferenceModalBtn').click();
            @else
                $('#launch').click();
            @endif
        })
    </script>

    <script>
        // Global variables

        var wizardState = {
            step: 0,
            maxStep: 3,
            saved: [false, false, false, false],
            profileId: null
        };

        // AJAX Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // function sendAjaxRequest(url, method, data = {}, button = null) {
        //     var originalText = '';
        //     if (button) {
        //         originalText = $(button).text();
        //         $(button).prop('disabled', true).text('Please wait...');
        //     }
        //
        //     return $.ajax({
        //         url: base_url + url,
        //         method: method,
        //         data: data,
        //         processData: !(data instanceof FormData),
        //         contentType: data instanceof FormData ? false : 'application/x-www-form-urlencoded; charset=UTF-8'
        //     }).always(function() {
        //         if (button) {
        //             $(button).prop('disabled', false).text(originalText);
        //         }
        //     });
        // }
        function sendAjaxRequest(url, method, data = {}, eventTriggerBtn = null) {
            var btnText = '';
            return $.ajax({ // Return the Promise from $.ajax
                url: base_url + url,
                method: method,
                data: data,
                processData: !(data instanceof FormData),
                contentType: data instanceof FormData ? false : 'application/x-www-form-urlencoded; charset=UTF-8',
                beforeSend: function () {
                    // You can show a loader here if needed
                    btnText = $(eventTriggerBtn).text();
                    $(eventTriggerBtn).attr('disabled', true).text('Please wait...');
                },
                complete: function () {
                    // Hide the loader here if needed
                    $(eventTriggerBtn).attr('disabled', false).text(btnText);
                },
            })
                .done(function (data) { // .done() for success
                    // console.log('print from dno');
                    // No need to assign to 'response' here, it's passed to .then()
                })
                .fail(function (xhr, status, error) {
                    console.log('AJAX Error:', xhr.responseText);

                    // Handle different types of errors
                    if (xhr.status === 422) {
                        // Laravel validation errors
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response.error) {
                                // Handle your custom error format: {"error":{"mobile":["The mobile has already been taken."]},"status":"error"}
                                $.each(response.error, function(field, messages) {
                                    if (Array.isArray(messages)) {
                                        messages.forEach(function(message) {
                                            toastr.error(message);
                                        });
                                    } else {
                                        toastr.error(messages);
                                    }
                                });
                            } else if (response.errors) {
                                // Handle standard Laravel validation format
                                $.each(response.errors, function(field, messages) {
                                    messages.forEach(function(message) {
                                        toastr.error(message);
                                    });
                                });
                            }
                        } catch (e) {
                            toastr.error('Validation failed. Please check your input.');
                        }
                    } else if (xhr.status === 500) {
                        toastr.error('Server error. Please try again later.');
                    } else if (xhr.status === 403) {
                        toastr.error('Access denied.');
                    } else {
                        toastr.error('An error occurred. Please try again.');
                    }
                });
        }

        // Wizard Logic
        (function() {
            const overlay = document.getElementById('overlay');
            const body = document.getElementById('modalBody');
            const title = document.getElementById('wizTitle');
            const badge = document.getElementById('stepBadge');
            const bar = document.getElementById('bar');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const closeBtn = document.getElementById('closeBtn');
            const closeX = document.getElementById('closeX');
            const savedMsg = document.getElementById('savedMsg');
            const errMsg = document.getElementById('errorMsg');
            const launch = document.getElementById('launch');
            const toastEl = document.getElementById('toast');

            const labels = [
                { title: 'Edit Contact Information' },
                { title: 'Add Work Experience' },
                { title: 'Add Education' },
                { title: 'Add Document' }
            ];

            function showToast(text, isSuccess = true) {
                toastEl.textContent = text;
                toastEl.style.backgroundColor = isSuccess ? '#d4edda' : '#f8d7da';
                toastEl.style.color = isSuccess ? '#155724' : '#721c24';
                toastEl.classList.add('show');
                setTimeout(() => toastEl.classList.remove('show'), 3000);
            }

            function updateButtons() {
                prevBtn.style.visibility = wizardState.step === 0 ? 'hidden' : 'visible';
                nextBtn.textContent = wizardState.step === wizardState.maxStep ? 'Done' : 'Next';
                nextBtn.disabled = !wizardState.saved[wizardState.step];

            }

            function showSaved(message = 'Saved') {
                savedMsg.textContent = message;
                savedMsg.classList.add('show');
                setTimeout(() => {
                    savedMsg.classList.remove('show');
                    savedMsg.textContent = 'Saved';
                }, 3000);
            }

            function showError(message = '') {
                errMsg.textContent = message;
            }

            function mountTemplate(idx) {
                body.innerHTML = '';
                const template = document.getElementById('step-' + idx);
                if (template) {
                    const clone = template.content.cloneNode(true);
                    body.appendChild(clone);

                    // Initialize datepicker after mounting
                    setTimeout(() => {
                        $('.datepicker').datepicker({
                            dateFormat: 'yy-mm-dd'
                        });
                    }, 100);
                }
            }

            function showStep(idx) {
                wizardState.step = Math.max(0, Math.min(idx, wizardState.maxStep));
                title.textContent = labels[wizardState.step].title;
                badge.textContent = `Step ${wizardState.step + 1} of ${wizardState.maxStep + 1}`;
                bar.style.width = Math.round((wizardState.step / wizardState.maxStep) * 100) + '%';
                mountTemplate(wizardState.step);
                updateButtons();
            }

            function openWizard() {
                overlay.classList.add('show');
                showStep(0);
            }

            function closeWizard() {
                overlay.classList.remove('show');
            }

            // Event Listeners
            nextBtn.addEventListener('click', () => {
                if (wizardState.step < wizardState.maxStep) {
                    showStep(wizardState.step + 1);
                } else {
                    showToast('All steps completed!');
                    @if($loggedUser->user_type == 'employee')
                        window.location.href = "{{ route('employee.home') }}";
                    @elseif($loggedUser->user_type == 'employer')
                        window.location.href = "{{ route('employer.home') }}";
                    @endif

                    setTimeout(() => closeWizard(), 1500);
                }
            });

            prevBtn.addEventListener('click', () => showStep(wizardState.step - 1));
            closeBtn.addEventListener('click', closeWizard);
            closeX.addEventListener('click', closeWizard);
            launch.addEventListener('click', openWizard);

            // Make functions globally accessible
            window.showWizardToast = showToast;
            window.showWizardSaved = showSaved;
            window.showWizardError = showError;
            window.updateWizardButtons = updateButtons;
        })();

        // Document Ready
        $(document).ready(function() {
            // Auto launch wizard
            // $('#launch').click();

            // Event delegation for dynamic buttons
            $(document).on('click', '#employeeProfileUpdateBtn', function(e) {
                e.preventDefault();
                // alert('Profile button clicked!'); // This should work now

                var formData = new FormData($('#form-contact')[0]);



                sendAjaxRequest("employee/update-profile/{!! $loggedUser->id !!}", 'POST', new FormData($('#form-contact')[0]), this)
                    .then(function (data) {
                        if (data.status == 'success') {
                            // response = data;
                            // $('#savedMsg').addClass('show').text('Profile updated successfully');
                            // toastr.success(data.msg);
                            // setTimeout(function() { $('#savedMsg').removeClass('show').text('Saved'); }, 2000);
                            wizardState.saved[0] = true;
                            window.updateWizardButtons();
                            window.showWizardSaved('Profile updated successfully!');
                            toastr.success(data.msg);
                        } else {
                            toastr.error(data.msg);
                            $('#errorMsg').text(data.message || 'An error occurred');
                        }
                    })
                    .catch(function (error) {
                        // toastr.error(error);
                        $('#errorMsg').text(error.responseText || 'An error occurred');
                    });
            });

            $(document).on('click', '#employeeWorkExpBtn', function(e) {
                e.preventDefault();

                var formData = new FormData($('#form-work')[0]);

                sendAjaxRequest('employee/employee-work-experiences', 'POST', formData, this)
                    .done(function(data) {
                        console.log('Success:', data);

                        // toastr.success('Work experience added successfully!');
                        if (data.status == 'success')
                        {
                            wizardState.saved[1] = true;
                            window.updateWizardButtons();
                            window.showWizardSaved('Work experience added successfully!');
                            toastr.success(data.success);
                        } else {
                            toastr.error(data.error);
                        }
                    })
                    .fail(function(xhr) {
                        console.error('Error:', xhr);
                        window.showWizardError('Failed to add work experience');
                        // toastr.error('Failed to add work experience');
                    });
            });

            $(document).on('click', '#employeeEducationBtn', function(e) {
                e.preventDefault();

                var formData = new FormData($('#form-education')[0]);

                sendAjaxRequest('employee/employee-educations', 'POST', formData, this)
                    .done(function(data) {

                        // toastr.success('Education added successfully!');
                        if (data.status == 'success')
                        {
                            console.log('Success:', data);
                            wizardState.saved[2] = true;
                            window.updateWizardButtons();
                            window.showWizardSaved('Education added successfully!');
                            toastr.success(data.success);
                        } else {
                            toastr.error(data.error);
                        }
                    })
                    .fail(function(xhr) {
                        console.error('Error:', xhr);
                        window.showWizardError('Failed to add education');
                        // toastr.error('Failed to add education');
                    });
            });

            $(document).on('click', '#employeeDocumentBtn', function(e) {
                e.preventDefault();

                var formData = new FormData($('#form-document')[0]);

                sendAjaxRequest('employee/employee-documents', 'POST', formData, this)
                    .done(function(data) {
                        console.log('Success:', data);

                        // toastr.success('Document uploaded successfully!');
                        if (data.status == 'success')
                        {
                            wizardState.saved[3] = true;
                            window.updateWizardButtons();
                            window.showWizardSaved('Document uploaded successfully!');
                            toastr.success(data.msg);
                        } else {
                            toastr.error(data.msg);
                        }
                    })
                    .fail(function(xhr) {
                        console.error('Error:', xhr);
                        window.showWizardError('Failed to upload document');
                        // toastr.error('Failed to upload document');
                    });
            });
            $(document).on('click', '#updateCompanyInfo', function(e) {
                e.preventDefault();

                var formData = new FormData($('#form-employer-contact')[0]);

                sendAjaxRequest('employer/update-company-info', 'POST', formData, this)
                    .done(function(data) {
                        console.log('Success:', data);

                        // toastr.success('Document uploaded successfully!');
                        if (data.status == 'success')
                        {
                            // wizardState.saved[3] = true;
                            // window.updateWizardButtons();
                            // window.showWizardSaved('Document uploaded successfully!');
                            toastr.success(data.msg);
                            setTimeout(function () {
                                window.location.href = "{{ route('employer.home') }}";
                            })
                        } else {
                            toastr.error(data.msg);
                        }
                    })
                    .fail(function(xhr) {
                        console.error('Error:', xhr);
                        window.showWizardError('Failed to update data');
                        // toastr.error('Failed to upload document');
                    });
            });

        });
    </script>

{{--    show and update job preference modal--}}
    <script>
        $(document).ready(function() {

            let currentStep = 1;
            let totalSteps = 0;

            // Initialize multi-step form
            function initMultiStepForm() {
                totalSteps = $('.form-step').length;
                generateStepIndicators();
                updateProgress();
                updateButtons();

                console.log(`Form initialized with ${totalSteps} steps`);
            }

            // Generate step indicators dynamically
            function generateStepIndicators() {
                const $indicator = $('#stepIndicator');
                $indicator.empty();
                $indicator.css('--total-steps', totalSteps);

                for (let i = 1; i <= totalSteps; i++) {
                    const $circle = $(`<div class="step-circle" data-step="${i}">${i}</div>`);
                    $indicator.append($circle);
                }

                updateStepIndicators();
            }

            // Update step indicators
            function updateStepIndicators() {
                $('.step-circle').each(function() {
                    const stepNum = parseInt($(this).data('step'));

                    $(this).removeClass('active completed');

                    if (stepNum === currentStep) {
                        $(this).addClass('active');
                    } else if (stepNum < currentStep) {
                        $(this).addClass('completed');
                    }
                });
            }

            // Update progress bar
            function updateProgress() {
                const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
                $('.progress-bar').css('width', progress + '%');
                updateStepIndicators();
            }

            // Previous button click handler
            $('#jobPreferencePrevBtn').on('click', function() {
                if (currentStep > 1) {
                    showStep(currentStep - 1);
                }
            });

            // Update buttons
            function updateButtons() {
                const $nextBtn = $('#jobPreferenceNextBtn');
                const $submitBtn = $('#jobPreferenceSubmitBtn');
                const $prevBtn = $('#jobPreferencePrevBtn');

                // Show/hide previous button
                if (currentStep === 1) {
                    $prevBtn.hide();
                } else {
                    $prevBtn.show();
                }

                if (currentStep === totalSteps) {
                    $nextBtn.hide();
                    $submitBtn.show();
                } else {
                    $nextBtn.show();
                    $submitBtn.hide();
                }
            }

            // Show specific step
            function showStep(stepNumber) {
                $('.form-step').removeClass('active');
                $(`.form-step[data-step="${stepNumber}"]`).addClass('active');

                currentStep = stepNumber;
                updateProgress();
                updateButtons();
            }

            // Validate current step
            function validateCurrentStep() {
                const $currentStep = $(`.form-step[data-step="${currentStep}"]`);
                const $requiredFields = $currentStep.find('[required]');
                let isValid = true;

                $requiredFields.each(function() {
                    const $field = $(this);
                    if (!$field.val()) {
                        $field.addClass('is-invalid');
                        isValid = false;
                    } else {
                        $field.removeClass('is-invalid');
                    }
                });

                return isValid;
            }

            // Next button click
            $('#jobPreferenceNextBtn').on('click', function() {
                if (validateCurrentStep()) {
                    if (currentStep < totalSteps) {
                        showStep(currentStep + 1);
                    }
                }
            });

            // Submit button click
            $('#jobPreferenceSubmitBtn').on('click', function() {
                if (validateCurrentStep()) {
                    submitForm();
                }
            });

            // Submit form via AJAX
            function submitForm() {
                const $submitBtn = $('#jobPreferenceSubmitBtn');
                const originalText = $submitBtn.text();

                // Show loading state
                $submitBtn.prop('disabled', true).text('Submitting...');

                // Collect form data
                const formData = {};
                $('#jobPreferenceForm').find('select, input, textarea').each(function() {
                    const name = $(this).attr('name');
                    const value = $(this).val();
                    if (name && value) {
                        formData[name] = value;
                    }
                });

                // console.log('Submitting form data:', formData);

                // AJAX request
                $.ajax({
                    url: base_url+'employee/update-employee-info', // Replace with your endpoint
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // For Laravel
                    },
                    success: function(response) {

                        // Show success message
                        showSuccessMessage();
                        toastr.success(response.success);
                        // Close modal after 2 seconds
                        setTimeout(() => {
                            $('#jobPreferenceModal').modal('hide');
                            setTimeout(() => {
                                $('#launch').click();
                            }, 500);
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        console.error('Form submission failed:', error);

                        let errorMessage = 'Form submission failed. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false).text(originalText);
                    }
                });
            }

            // Show success message
            function showSuccessMessage() {
                const successHtml = `
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <svg width="60" height="60" fill="currentColor" class="text-success" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                        </div>
                        <h4 class="text-success">Success!</h4>
                        <p class="text-muted">Your job preferences have been saved successfully.</p>
                    </div>
                `;

                $('.modal-body').html(successHtml);
                $('.modal-footer').hide();
            }

            // Reset form when modal is closed
            $('#jobPreferenceModal').on('hidden.bs.modal', function() {
                // Reset form
                // $('#jobPreferenceForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');

                // Reset to first step
                currentStep = 1;
                showStep(1);

                // Restore modal content if needed
                $('.modal-footer').show();

                // You might want to reload the original content here
                // if the success message changed the modal body
            });

            // Remove validation on field change
            $(document).on('change', '#jobPreferenceForm select, #jobPreferenceForm input', function() {
                $(this).removeClass('is-invalid');
            });

            // Initialize when modal is shown
            $('#jobPreferenceModal').on('shown.bs.modal', function() {
                initMultiStepForm();

            });

            // Also initialize on page load for immediate use
            initMultiStepForm();
        });

    </script>
   @include('common-resource-files.sim-select')
    <style>
        .ss-search {display: none!important;}
    </style>
    {{--    show and update job preference modal END--}}
{{--    drag-drop-crop start--}}

{{--    drag-drop-crop end--}}

{{--    Work Exp, Education, documents js--}}
    <script>
        // work experience currently active js
        // disable end date on current job check
        $(document).on('change', '#currentJobCheck', function () {
            if ($(this).is(':checked')) {
                $('input[name="end_date"]').prop('disabled', true).val(''); // disable and clear end date
            } else {
                $('input[name="end_date"]').prop('disabled', false); // enable back
            }
        });
        // disable end date on current job check during edit
        $(document).on('change', '#editCurrentJobCheck', function () {
            if ($(this).is(':checked')) {
                $('input[name="end_date"]').prop('disabled', true).val(''); // disable and clear end date
            } else {
                $('input[name="end_date"]').prop('disabled', false); // enable back
            }
        });

        {{--    employee education--}}
        // $(document).on('change', 'select[name="education_degree_name_id"]', function () {
        //     var selectedOption = $(this).find('option:selected');
        //     var selectedOptionAttrValue = selectedOption.attr('has-institute-name');
        //     toggleInstituteNameOnEducationDegreeChange(selectedOptionAttrValue);
        // })
        function toggleInstituteNameOnEducationDegreeChange(hasInstituteNameValue = 0)
        {
            if (hasInstituteNameValue == 1)
            {
                $('#instituteNameDiv').removeClass('d-none');
                $('#universityDiv').addClass('d-none');
                $('label[for="cgpaInput"]').text('Grade');
            } else {
                $('#universityDiv').removeClass('d-none');
                $('#instituteNameDiv').addClass('d-none');
                $('input[name="institute_name"]').val('');
                $('input[name="group_name"]').val('');
                $('label[for="cgpaInput"]').text('GPA');
            }
        }
    </script>


@endpush
