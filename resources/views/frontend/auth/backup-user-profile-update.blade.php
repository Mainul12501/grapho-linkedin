<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Profile Wizard (4-step modal)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('frontend/auth/user-profile-update.css') }}">
</head>
<body>
<div class="page" style="display: none">
    <div class="card">
        <h1>Profile Setup Wizard</h1>
        <p class="muted">4-step modal that posts each step to backend.</p>
        <button class="btn btn-primary" id="launch">Open Wizard</button>
    </div>
</div>
<form action="{{ route('logout') }}" method="post" id="logoutForm">
    @csrf
</form>
@if($loggedUser->user_type == 'employee')
    <div class="overlay" id="overlay" role="dialog" aria-modal="true" aria-labelledby="wizTitle">
        <div class="modal" id="modal">
            <div class="modal-header">
                <div class="title-wrap">
                    <span class="step-badge" id="stepBadge">Step 1 of 4</span>
                    <h2 id="wizTitle" style="margin:0;font-size:18px">Edit Contact Information</h2>
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
                    <button class="btn" id="prevBtn">Previous</button>
                    <button class="btn btn-primary" id="nextBtn">Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- STEP 0 -->
    <template id="step-0">
        <form id="form-contact" autocomplete="on" novalidate enctype="multipart/form-data" method="post" action="">
            <div class="grid grid-1">
                <div class="grid">
                    <div><label>Name <span style="color: red">*</span></label><input name="name" type="email" value="{{ $loggedUser->name ?? '' }}" placeholder="Jhon Doe" required /></div>
                    <div><label>Address</label><input name="address" type="text" value="{{ $loggedUser->address ?? '' }}" /></div>
                </div>
                <div class="grid">
                    <div><label>Title <span style="color: red">*</span></label><input name="profile_title" type="text" placeholder="Mobile App Developer" value="{{ $loggedUser->profile_title ?? '' }}" required /></div>
                    <div><label>profile Image <span style="color: red">*</span></label><input name="profile_image" type="file" accept="image/*" required /></div>
                </div>
                <div class="grid">
                    <input type="hidden" name="user_id" value="{{ $loggedUser->id ?? '' }}" id="userId">
                    <input type="hidden" name="is_profile_updated" value="1" >
                    <div><label>Email <span style="color: red">*</span></label><input name="email" type="email" value="{{ $loggedUser->email ?? '' }}" required /></div>
                    <div><label>Phone <span style="color: red">*</span></label><input name="mobile" type="tel" value="{{ $loggedUser->mobile }}" /></div>
                </div>
                <div class="grid">
                    <div>
                        <label>Division</label>
                        <select name="division" id="divisions" onchange="divisionsList();">
                            <option disabled selected>Select Division</option>
                            <option value="Barishal" {{ $loggedUser->division == 'Barishal' ? 'selected' : '' }}>Barishal</option>
                            <option value="Chattogram" {{ $loggedUser->division == 'Chattogram' ? 'selected' : '' }}>Chattogram</option>
                            <option value="Dhaka" {{ $loggedUser->division == 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                            <option value="Khulna" {{ $loggedUser->division == 'Khulna' ? 'selected' : '' }}>Khulna</option>
                            <option value="Mymensingh" {{ $loggedUser->division == 'Mymensingh' ? 'selected' : '' }}>Mymensingh</option>
                            <option value="Rajshahi" {{ $loggedUser->division == 'Rajshahi' ? 'selected' : '' }}>Rajshahi</option>
                            <option value="Rangpur" {{ $loggedUser->division == 'Rangpur' ? 'selected' : '' }}>Rangpur</option>
                            <option value="Sylhet" {{ $loggedUser->division == 'Sylhet' ? 'selected' : '' }}>Sylhet</option>
                        </select>
                    </div>
                    <div><label>District</label><select name="district" id="distr" onchange="thanaList();"></select><!--/ Districts Section--></div>
                </div>
                <div class="grid">
                    <div><label>Post Office</label><select name="post_office" id="polic_sta"></select><!--/ Police Station Section--></div>
                    <div><label>Post Code</label><input name="postal_code" type="text" min="0" value="" placeholder="1200" /></div>
                </div>
                <div class="grid">
                    <div><label>Gender</label><select name="gender" id="">
                            <option value="male">Male</option><option value="female">Female</option></select></div>
                    <div><label>Website</label><input name="website" type="text" value="" placeholder="www.website.com" /></div>
                </div>
                <div class="grid">
                    <div><label>Currently available to work?</label><select name="is_open_for_hire" id="">
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
        <form id="form-work" autocomplete="on" novalidate method="post" action="">
            @csrf
            <div class="grid grid-1">
                <div class="grid">
                    <div><label>Resignation</label><input name="title" type="text" required /></div>
                    <div>
                        <label>Job type</label>
                        <select name="job_type" required>
                            <option value="">Select</option>
                            <option value="full_time">Full-time</option>
                            <option value="part_time">Part-time</option>
                            <option value="contractual">Contractual</option>
                        </select>
                    </div>
                </div>
                <div class="grid">
                    <div><label>Company/Organization Name</label><input type="text" name="company_name"></div>
                    <div><label>Company/Organization Logo</label><input name="company_logo" type="file" placeholder="" /></div>
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
                <div><label><input type="checkbox" name="is_working_currently" /> I currently work here</label></div>
                <div><label>Location</label><input name="office_address" type="text" /></div>
                <div><label>Job Responsibilities</label><textarea name="job_responsibilities"></textarea></div>
            </div>
            <div style="margin-top:14px;text-align:right">
                <button class="btn btn-primary" id="employeeWorkExpBtn" type="button">Add Experience</button>
            </div>
        </form>
    </template>

    <!-- STEP 2 -->
    <template id="step-2">
        <form id="form-education" autocomplete="on" novalidate>
            @csrf
            <div class="grid grid-1">
                <div class="grid">
                    <div>
                        <label>Education Program</label>
                        <select name="education_degree_name_id" id="">
                            <option value="" disabled>Select Degree</option>
                            @foreach($educationDegreeNames as $degreeName)
                                <option value="{{ $degreeName->id }}">{{ $degreeName->degree_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div><label>University name</label>
                        <select name="university_name_id" class="form-control select2" id="">
                            <option selected disabled>Select University</option>
                            @foreach($universityNames as $universityName)
                                <option value="{{ $universityName->id }}">{{ $universityName->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid">
                    <div><label>Field of study</label>
                        <select name="field_of_study_id" class="form-control select2" id="">
                            <option selected disabled>Select Field of Study</option>
                            @foreach($fieldOfStudies as $fieldOfStudy)
                                <option value="{{ $fieldOfStudy->id }}">{{ $fieldOfStudy->field_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div><label>Passing Year</label><input name="passing_year" type="text" /></div>
                </div>
                {{--            <div class="grid">--}}
                {{--                <div><label>Start month</label><select name="edu_start_month">--}}
                {{--                        <option value="">Month</option><option>January</option><option>February</option>--}}
                {{--                        <option>March</option><option>April</option><option>May</option>--}}
                {{--                        <option>June</option><option>July</option><option>August</option>--}}
                {{--                        <option>September</option><option>October</option><option>November</option><option>December</option>--}}
                {{--                    </select></div>--}}
                {{--                <div><label>Start year</label><select name="edu_start_year"><option value="">Year</option></select></div>--}}
                {{--            </div>--}}
                {{--            <div class="grid">--}}
                {{--                <div><label>End month</label><select name="edu_end_month">--}}
                {{--                        <option value="">Month</option><option>January</option><option>February</option>--}}
                {{--                        <option>March</option><option>April</option><option>May</option>--}}
                {{--                        <option>June</option><option>July</option><option>August</option>--}}
                {{--                        <option>September</option><option>October</option><option>November</option><option>December</option>--}}
                {{--                    </select></div>--}}
                {{--                <div><label>End year</label><select name="edu_end_year"><option value="">Year</option></select></div>--}}
                {{--            </div>--}}
                <div class="grid">
                    <div><label>CGPA</label><input name="cgpa" type="text" /></div>
                    <div><label>Address</label><input name="address" type="text" /></div>
                </div>
            </div>
            <div style="margin-top:14px;text-align:right">
                <button class="btn btn-primary" id="employeeEducationBtn" type="button">Add Education</button>
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
                    <input name="title" type="text"  required />
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
        <div class="modal" id="modal">
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

<!-- Scripts -->
<script>
    var base_url = "{{ url('/') }}/"; // Change this to your actual base URL
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('/frontend/employee/division-Districts-post-station/javascript.js') }}"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
        $('#launch').click();

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

</body>
</html>
