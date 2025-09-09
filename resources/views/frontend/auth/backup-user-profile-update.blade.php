<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Profile Wizard (4-step modal)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('/frontend/auth/user-profile-update.css') }}">
</head>
<body>
<div class="page d-none">
    <div class="card">
        <h1>Profile Setup Wizard</h1>
        <p class="muted">4-step modal that posts each step to backend (mocked if backend not present).</p>
        <button class="btn btn-primary" id="launch">Open Wizard</button>
    </div>
</div>

<div class="overlay" id="overlay" role="dialog" aria-modal="true" aria-labelledby="wizTitle">
    <div class="modal" id="modal">
        <div class="modal-header">
            <div class="title-wrap">
                <span class="step-badge" id="stepBadge">Step 1 of 4</span>
                <h2 id="wizTitle" style="margin:0;font-size:18px">Edit Contact Information</h2>
            </div>
            <button class="btn-ghost" id="closeX" aria-label="Close">✕</button>
        </div>
        <div class="progress"><i id="bar"></i></div>
        <div class="modal-body" id="modalBody"></div>
        <div class="modal-footer">
            <div class="left-actions">
                <button class="btn" id="closeBtn">Close</button>
                <span class="saved" id="savedMsg">Saved</span>
                <span class="error" id="errorMsg"></span>
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
{{--            <div><label>Address</label><input name="location" type="text" value="Dhaka, Bangladesh" required /></div>--}}
            <div class="grid">
                <div><label>Name</label><input name="name" type="email" value="{{ $loggedUser->name ?? '' }}" placeholder="Jhon Doe" required /></div>
                <div><label>Address</label><input name="address" type="text" value="{{ $loggedUser->address ?? '' }}" /></div>
            </div>
            <div class="grid">
                <div><label>profile Title</label><input name="profile_title" type="text" placeholder="Mobile App Developer" value="{{ $loggedUser->profile_title ?? '' }}" required /></div>
                <div><label>profile Image</label><input name="profile_image" type="file" accept="image/*" required /></div>
            </div>
            <div class="grid">
                <div><label>Email</label><input name="email" type="email" value="{{ $loggedUser->email ?? '' }}" required /></div>
                <div><label>Phone</label><input name="mobile" type="tel" value="{{ $loggedUser->mobile }}" /></div>
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
{{--            <div><label>Website</label><input name="website" type="text" value="www.devpranto.com" /></div>--}}
        </div>
        <div style="margin-top:14px;text-align:right">
            <button class="btn btn-primary" id="employeeProfileUpdateBtn" data-action="save" type="button">Save Changes</button>
        </div>
    </form>
</template>

<!-- STEP 1 -->
<template id="step-1">
    <form id="form-work" autocomplete="on" novalidate method="post" action="">
        @csrf
        <div class="grid grid-1">
            <div class="grid">
                <div><label>Job title</label><input name="job_title" type="text" required /></div>
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
                    <label>Start Date</label>
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
                <div><label>End Date</label><input name="end_date" id="datepicker2" type="text" class="datepicker" ></div>
            </div>
            <div><label><input type="checkbox" name="is_working_currently" /> I currently work here</label></div>
            <div><label>Address</label><input name="office_address" type="text" /></div>
            <div><label>Job Responsibilities</label><textarea name="job_responsibilities"></textarea></div>
        </div>
        <div style="margin-top:14px;text-align:right">
            <button class="btn btn-primary" data-action="save" id="employeeWorkExpBtn" type="button">Add Experience</button>
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
            <button class="btn btn-primary" data-action="save" id="employeeEducationBtn" type="button">Add Education</button>
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
            <button class="btn btn-primary" id="employeeDocumentBtn" data-action="save" type="button">Upload Document</button>
        </div>
    </form>
</template>

<div class="toast" id="toast"></div>
<script>
    var base_url = "{{ url('/') }}/";
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{ asset('/frontend/employee/division-Districts-post-station/javascript.js') }}"></script>
<!-- Toastr Css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{--jquery UI--}}
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var response;
    var btnText = '';

    function sendAjaxRequest(url, method, data = {}, eventTriggerBtn = null) {
        return $.ajax({ // Return the Promise from $.ajax
            url: base_url + url,
            method: method,
            data: data,
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
            .fail(function (error) { // .fail() for error
                toastr.error(error);
                // The error will also be propagated to the .catch() when called
            });
    }
</script>
<script>
    (function () {
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
            { title: 'Edit Contact Information', save: 'Save Changes' },
            { title: 'Add Work Experience', save: 'Add Experience' },
            { title: 'Add Education', save: 'Add Education' },
            { title: 'Add Document', save: 'Upload Document' }
        ];

        let step = 0, maxStep = 3, saved = [false, false, false, false], profileId = null;

        function showToast(text, ok = true) {
            toastEl.textContent = text;
            toastEl.style.borderColor = ok ? '#ddd' : 'rgba(217,48,37,.3)';
            toastEl.classList.add('show');
            setTimeout(() => toastEl.classList.remove('show'), 2000);
        }
        function spinnerHTML() { return '<span class="spinner"></span>'; }

        // Always Mock Backend
        async function apiPost(path, payload, multipart = false) {
            return new Promise(res => {
                setTimeout(() => {
                    if (path === '/contact') res({ success: true, profile_id: 'mock_123' });
                    else if (path === '/experience') res({ success: true, experience_id: 'exp_1' });
                    else if (path === '/education') res({ success: true, education_id: 'edu_1' });
                    else if (path === '/document') res({ success: true, file_id: 'file_1' });
                }, 500);
            });
        }

        function fillYears(sel, from = 1980, to = new Date().getFullYear()+1) {
            for (let y=to;y>=from;y--) {
                const o=document.createElement('option');o.value=o.textContent=y;sel.appendChild(o);
            }
        }

        function mountTemplate(idx) {
            body.innerHTML = '';
            const tpl = document.getElementById('step-' + idx);
            body.appendChild(tpl.content.cloneNode(true));
            body.querySelectorAll('select[name="start_year"], select[name="edu_start_year"], select[name="edu_end_year"]')
                .forEach(sel => fillYears(sel, 1980));
            const saveBtn = body.querySelector('[data-action="save"]');
            if (saveBtn) {
                saveBtn.textContent = labels[idx].save;
                saveBtn.addEventListener('click', onSaveClick); /*form validation*/
            }
        }

        function showStep(idx) {
            step = Math.max(0, Math.min(idx, maxStep));
            title.textContent = labels[step].title;
            badge.textContent = `Step ${step + 1} of ${maxStep + 1}`;
            bar.style.width = Math.round((step / maxStep) * 100) + '%';
            mountTemplate(step);
            updateButtons();
        }

        function updateButtons() {
            prevBtn.style.visibility = step === 0 ? 'hidden' : 'visible';
            nextBtn.textContent = (step === maxStep) ? 'Finish' : 'Next';
            nextBtn.disabled = !saved[step];
        }

        async function onSaveClick() {
            try {
                setError('');
                savedMsg.classList.remove('show');
                const btn = this; btn.innerHTML = spinnerHTML() + 'Saving...'; btn.disabled = true;
                if (step === 0) {
                    const f = body.querySelector('#form-contact');
                    const email = f.email.value.trim();
                    if (email && !/^\S+@\S+\.\S+$/.test(email)) throw new Error('Invalid email');
                    const payload = { location: f.address.value.trim(), email, phone: f.mobile.value.trim(), website: f.website.value.trim() };
                    const r = await apiPost('/contact', payload); profileId = r.profile_id;

                }
                if (step === 1) {
                    if (!profileId) throw new Error('Missing profile_id');
                    const f = body.querySelector('#form-work');
                    const payload = { profile_id: profileId, job_title: f.job_title.value.trim(), job_type: f.job_type.value, company_name: f.company_name.value.trim(), start_date: f.start_date.value, office_address: f.office_address.value.trim(), job_responsibilities: f.job_responsibilities.value.trim() };
                    if (!payload.job_title || !payload.job_type || !payload.company_name || !payload.start_date ) throw new Error('Please fill required fields');
                    await apiPost('/experience', payload);
                }
                if (step === 2) {
                    if (!profileId) throw new Error('Missing profile_id');
                    const f = body.querySelector('#form-education');
                    const payload = { profile_id: profileId, education_degree_name_id: f.education_degree_name_id.value.trim(), university_name_id: f.university_name_id.value.trim(), field_of_study_id: f.field_of_study_id.value.trim(), passing_year: f.passing_year.value,  cgpa: f.cgpa.value.trim(), address: f.address.value.trim() };
                    if (!payload.education_degree_name_id || !payload.university_name_id || !payload.field_of_study_id || !payload.passing_year) throw new Error('Please fill required fields');
                    await apiPost('/education', payload);
                }
                if (step === 3) {
                    if (!profileId) throw new Error('Missing profile_id');
                    const f = body.querySelector('#form-document');
                    const file = f.file.files[0];
                    if (!file) throw new Error('Please choose a file');
                    if (file.size > 2 * 1024 * 1024) throw new Error('File too large (>2MB)');
                    const fd = new FormData(); fd.append('file', file); fd.append('profile_id', profileId);
                    await apiPost('/document', fd, true);
                }
                saved[step] = true;
                savedMsg.classList.add('show'); updateButtons();
                showToast('Saved successfully');
            } catch (e) { setError(e.message || 'Save failed'); showToast(e.message || 'Save failed', false); }
            finally { this.disabled = false; this.innerHTML = labels[step].save; }
        }
        function setError(t=''){errMsg.textContent=t;}

        function openWizard() { overlay.classList.add('show'); showStep(0); }
        function closeWizard() { overlay.classList.remove('show'); }

        function assignDatePicker() {
            $( ".datepicker" ).datepicker({
                dateFormat: "yy-mm-dd",
            });
            $( "#datepicker1" ).datepicker({
                dateFormat: "yy-mm-dd",
            });
            $( "#datepicker2" ).datepicker({
                dateFormat: "yy-mm-dd",
            });
        }

        nextBtn.addEventListener('click', () => step<maxStep?showStep(step+1):(showToast('All steps completed. Closing wizard.'),closeWizard()));
        prevBtn.addEventListener('click', () => showStep(step-1));
        closeBtn.addEventListener('click', closeWizard);
        closeX.addEventListener('click', closeWizard);
        launch.addEventListener('click', openWizard);
        nextBtn.addEventListener('click', assignDatePicker);
    })();
</script>
<script>
    $(document).ready(function() {
        // Additional jQuery code can be added here if needed
        $('#launch').trigger('click');

    });
    console.log($('#employeeProfileUpdateBtn').text());
    $(document).on('click', '#employeeProfileUpdateBtn', function () {
        alert('profile');
        // event.preventDefault();
        sendAjaxRequest("employee/update-profile/{!! $loggedUser->id !!}", 'POST', new FormData($('#form-contact')[0]), this)
            .then(function (data) {
                alert('ajax profile');
                if (data.status == 'success') {
                    // response = data;
                    $('#savedMsg').addClass('show').text('Profile updated successfully');
                    toastr.success(data.msg);
                    setTimeout(function() { $('#savedMsg').removeClass('show').text('Saved'); }, 2000);
                } else {
                    toastr.error(data.msg);
                    $('#errorMsg').text(data.message || 'An error occurred');
                }
            })
            .catch(function (error) {
                toastr.error(error);
                $('#errorMsg').text(error.responseText || 'An error occurred');
            });
    })
    $(document).on('click', '#employeeWorkExpBtn', function (e) {
        alert('work');
        event.preventDefault();
        sendAjaxRequest("employee/employee-work-experiences", 'POST', new FormData($('#form-work')[0]), this)
            .then(function (data) {
                if (data.status == 'success') {
                    // response = data;
                    $('#savedMsg').addClass('show').text('Profile updated successfully');
                    toastr.success(data.success);
                    setTimeout(function() { $('#savedMsg').removeClass('show').text('Saved'); }, 2000);
                } else {
                    toastr.error(data.error);
                    $('#errorMsg').text(data.message || 'An error occurred');
                }
            })
            .catch(function (error) {
                toastr.error(error);
                $('#errorMsg').text(error.responseText || 'An error occurred');
            });
    })
    $(document).on('click', '#employeeEducationBtn', function (e) {
        alert('education');
        event.preventDefault();
        sendAjaxRequest("employee/employee-educations", 'POST', new FormData($('#form-education')[0]), this)
            .then(function (data) {
                if (data.status == 'success') {
                    // response = data;
                    $('#savedMsg').addClass('show').text('Profile updated successfully');
                    toastr.success(data.success);
                    setTimeout(function() { $('#savedMsg').removeClass('show').text('Saved'); }, 2000);
                } else {
                    toastr.error(data.error);
                    $('#errorMsg').text(data.message || 'An error occurred');
                }
            })
            .catch(function (error) {
                toastr.error(error);
                $('#errorMsg').text(error.responseText || 'An error occurred');
            });
    })
    $(document).on('click', '#employeeDocumentBtn', function (e) {
        alert('document');
        event.preventDefault();
        sendAjaxRequest("employee/employee-documents", 'POST', new FormData($('#form-document')[0]), this)
            .then(function (data) {
                if (data.status == 'success') {
                    // response = data;
                    $('#savedMsg').addClass('show').text('Profile updated successfully');
                    toastr.success(data.msg);
                    setTimeout(function() { $('#savedMsg').removeClass('show').text('Saved'); }, 2000);
                } else {
                    toastr.error(data.msg);
                    $('#errorMsg').text(data.message || 'An error occurred');
                }
            })
            .catch(function (error) {
                toastr.error(error);
                $('#errorMsg').text(error.responseText || 'An error occurred');
            });
    })
</script>
</body>
</html>
