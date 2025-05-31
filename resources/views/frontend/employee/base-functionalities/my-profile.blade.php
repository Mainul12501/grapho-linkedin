@extends('frontend.employee.master')

@section('title', 'My Profile')

@section('body')

    <!-- Main Content -->
    <div class="container container-main mt-3 profileMain">
        <aside class="left-panel p-3">
            <div class="card">
                <div class="card-body profile">
                    <img src="{{ asset('/') }}frontend/employee/images/header images/Thumbnail.png" alt="Profile" class="rounded-circle mb-2" width="80" />
                    <h5>Mohammed Pranto</h5>
                    <div class="d-flex justify-content-center justify-content-md-start">
            <span class="badge d-flex align-items-center"><img src="{{ asset('/') }}frontend/employee/images/profile/Ellipse 1.png" alt="" class="me-2" />
              Open to Full-time Roles</span>
                        <img src="{{ asset('/') }}frontend/employee/images/profile/downArrow.png" alt="" />
                    </div>

                    <p class="mt-2">
                        Mobile App Developer, Flutter Developer Instructor & Mentor
                    </p>

                    <div class="viewoProfileforSmallDevice py-4">
                        <a href="">View profile details</a>
                        <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right dark.png" alt="">
                    </div>

                    <!-- editt profile -->
                    <div class="profileEdit">
                        <h2 class="">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/editIcon.png" alt="" class="me-1" />
                            <span class="editBio">Edit bio</span>
                        </h2>
                        <hr />
                        <div class="profileIngo location">
                            <div class="row">
                                <div class="col-2">
                                    <img src="{{ asset('/') }}frontend/employee/images/profile/location.png" alt="" />
                                </div>
                                <div class="col-10">
                                    <h4 class="mb-0">Location</h4>
                                    <p>Dhaka, Bangladesh</p>
                                </div>
                            </div>
                        </div>
                        <div class="profileIngo email">
                            <div class="row">
                                <div class="col-2">
                                    <img src="{{ asset('/') }}frontend/employee/images/profile/email.png" alt="" />
                                </div>
                                <div class="col-10">
                                    <h4 class="mb-0">Email</h4>
                                    <p><a href="">md.pranto@gmail.com</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="profileIngo phone">
                            <div class="row">
                                <div class="col-2">
                                    <img src="{{ asset('/') }}frontend/employee/images/profile/phone.png" alt="" />
                                </div>
                                <div class="col-10">
                                    <h4 class="mb-0">Phone</h4>
                                    <p>+8801653523779</p>
                                </div>
                            </div>
                        </div>
                        <div class="profileIngo website">
                            <div class="row">
                                <div class="col-2">
                                    <img src="{{ asset('/') }}frontend/employee/images/profile/website.png" alt="" />
                                </div>
                                <div class="col-10">
                                    <h4 class="mb-0">Website</h4>
                                    <p><a href="">www.devpranto.com</a></p>
                                </div>
                            </div>
                        </div>

                        <!-- edit contact with modal -->

                        <!-- Edit Contact Info (Existing Button) -->
                        <h2 class="mt-3">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/editIcon.png" alt="" class="me-1" />
                            <span class="editBio" data-bs-toggle="modal" data-bs-target="#editContactModal">Edit contact info</span>
                        </h2>

                        <!-- Modal for Edit Contact -->
                        <div class="modal fade" id="editContactModal" tabindex="-1" aria-labelledby="editContactModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog custom-modal1">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editContactModalLabel">
                                            <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-1" />
                                            Edit Contact Information
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form for editing contact info -->
                                        <form>
                                            <div class="mb-3">
                                                <label for="locationInput" class="form-label">Location</label>
                                                <input type="text" class="form-control" id="locationInput" value="Dhaka, Bangladesh" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="emailInput" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="emailInput" value="md.pranto@gmail.com" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="phoneInput" class="form-label">Phone</label>
                                                <input type="tel" class="form-control" id="phoneInput" value="+8801653523779" />
                                            </div>

                                            <div class="mb-3">
                                                <label for="phoneInput" class="form-label">Website</label>
                                                <input type="tel" class="form-control" id="phoneInput" value="+www.devpranto.com" />
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="button" class="btn btn-primary">
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- jQuery for controlling sticky behavior when modal opens/closes -->
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            // When the Edit Contact modal is opened
                            $("#editContactModal").on("shown.bs.modal", function () {
                                // Remove sticky position from the left-panel when the modal is open
                                $(".left-panel").css("position", "relative");
                            });

                            // When the Edit Contact modal is closed
                            $("#editContactModal").on("hidden.bs.modal", function () {
                                // Restore sticky position to the left-panel when the modal is closed
                                $(".left-panel").css("position", "sticky");
                            });
                        </script>

                        <!-- edit contact with modal -->
                    </div>
                </div>
            </div>
        </aside>

        <!-- Right Scrollable Jobs -->
        <section class="w-100">
            <div class="row jobdashboard p-3 justify-content-between">
                <!-- save jobs -->
                <div class="col-4 saveJobs">
                    <div class="row mb-3">
                        <div class="col-1 me-2">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/saveJobIcon.png" alt="" />
                        </div>
                        <div class="col-8">
                            <h2>My saved jobs</h2>
                        </div>
                        <div class="col-2 text-end">
                            <a href="{{ route('employee.my-saved-jobs') }}"><img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" class="profileRightArrow" /></a>
                        </div>
                    </div>
                    <h1>23</h1>
                    <p class="mb-0">Jobs saved</p>
                </div>
                <!-- My applications -->
                <div class="col-4 myApplication">
                    <div class="row mb-3">
                        <div class="col-1 me-2">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/myApplicationIcon.png" alt="" />
                        </div>
                        <div class="col-8">
                            <h2>My applications</h2>
                        </div>
                        <div class="col-2 text-end">
                            <a href="{{ route('employee.my-saved-jobs') }}"><img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" class="profileRightArrow" /></a>
                        </div>
                    </div>
                    <h1>15</h1>
                    <p class="mb-0">Applications</p>
                </div>
                <!-- Profiler viewers -->
                <div class="col-4 profileViewer">
                    <div class="row mb-3">
                        <div class="col-1 me-2">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/ProfileViewer.png" alt="" />
                        </div>
                        <div class="col-8">
                            <h2>My Profile Viewers</h2>
                        </div>
                        <div class="col-2 text-end">
                            <a href="{{ route('employee.my-profile-viewers') }}"><img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" class="profileRightArrow" /></a>
                        </div>
                    </div>
                    <h1>37</h1>
                    <p class="mb-0">Viewers</p>
                </div>
            </div>

            <!-- mobile user option -->
            <div class="right-panel w-100 userOptionforMobile">
                <div class="userOptionforMobileWraperMain">

                    <a href="#" class="userOptionforMobileOptions">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="left-side">
                                <img src="{{ asset('/') }}frontend/employee/images/header images/Saved jobs.png" alt="" /> Saved jobs
                            </div>
                            <div class="right-side">
                                <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" />
                            </div>
                        </div>
                    </a>


                    <a href="#" class="userOptionforMobileOptions">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="left-side">
                                <img src="{{ asset('/') }}frontend/employee/images/header images/Myapplications.png" alt="" /> My applications
                            </div>
                            <div class="right-side">
                                <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" />
                            </div>
                        </div>
                    </a>

                    <a href="#" class="userOptionforMobileOptions">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="left-side">
                                <img src="{{ asset('/') }}frontend/employee/images/header images/Profilerviewers.png" alt="" /> Profiler viewers
                            </div>
                            <div class="right-side">
                                <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" />
                            </div>
                        </div>
                    </a>

                    <a href="#" class="userOptionforMobileOptions">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="left-side">
                                <img src="{{ asset('/') }}frontend/employee/images/header images/Subscription.png" alt="" /> Subscription
                            </div>
                            <div class="right-side">
                                <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" />
                            </div>
                        </div>
                    </a>

                    <a href="#" class="userOptionforMobileOptions">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="left-side">
                                <img src="{{ asset('/') }}frontend/employee/images/header images/Settings.png" alt="" /> Settings
                            </div>
                            <div class="right-side">
                                <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" />
                            </div>
                        </div>
                    </a>

                </div>
            </div>


            <!-- work experience -->
            <div class="right-panel w-100">
                <div class="d-flex align-items-center justify-content-between profileOverview">
                    <h3>Work experiences</h3>
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#addWorkExperienceModal">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/plusIcon.png" alt="" /> Add
                    </button>

                    <!-- Modal for Add Work Experience -->
                    <div class="modal fade" id="addWorkExperienceModal" tabindex="-1"
                         aria-labelledby="addWorkExperienceModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addWorkExperienceModalLabel">
                                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-1" />Add Work Experience
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form for adding work experience -->
                                    <form>
                                        <div class="mb-4">
                                            <label for="jobTitleInput" class="form-label">Job title</label>
                                            <input type="text" class="form-control" id="jobTitleInput" placeholder="Type here" />
                                        </div>

                                        <div class="mb-4">
                                            <label for="jobTypeInput" class="form-label">Job type</label>
                                            <select class="form-control" id="jobTypeInput">
                                                <option value="">Select</option>
                                                <option value="full-time">Full-time</option>
                                                <option value="part-time">Part-time</option>
                                                <option value="internship">Internship</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label for="companyInput" class="form-label">Company/Organization</label>
                                            <input type="text" class="form-control" id="companyInput" placeholder="Type here" />
                                        </div>

                                        <div class="mb-4">
                                            <label for="startDateInput" class="form-label">Start date</label>
                                            <div class="d-flex">
                                                <select class="form-control me-2" id="startMonthInput">
                                                    <option value="">Month</option>
                                                    <option value="jan">January</option>
                                                    <option value="feb">February</option>
                                                    <!-- Add other months -->
                                                </select>
                                                <select class="form-control" id="startYearInput">
                                                    <option value="">Year</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2020">2020</option>
                                                    <!-- Add more years -->
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="currentJobCheck" />
                                                <label class="form-check-label" for="currentJobCheck">I currently work here</label>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="locationInput" class="form-label">Location</label>
                                            <input type="text" class="form-control" id="locationInput" placeholder="Type here" />
                                        </div>

                                        <div class="mb-4">
                                            <label for="workSummaryInput" class="form-label">Job summary</label>
                                            <textarea class="form-control" id="workSummaryInput" rows="4" placeholder="Type here"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="button" class="btn btn-primary">
                                        Add Experience
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row jobCard border-bottom">
                    <div class="col-2 col-md-1">
                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/companyLogoFor job.png" alt="Company Logo" class="companyLogo" />
                        <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/contentImages/companyLogoFor job.png" alt="Company Logo"
                             class="mobileLogo" />
                    </div>
                    <div class="col-10 col-md-11">
                        <div class="jobPosition d-flex justify-content-between">
                            <div class="d-flex">
                                <div class="profileCard">
                                    <h3>Executive Officer, Sales</h3>
                                    <h4>
                                        United Commercial Bank PLC
                                        <img src="{{ asset('/') }}frontend/employee/images/profile/dotDevider.png" alt="" />
                                        <span>Full Time</span>
                                    </h4>
                                    <p class="mb-0">
                                        Jan 2025 - Present
                                        <img src="{{ asset('/') }}frontend/employee/images/profile/2ndDotDevider.png" alt="" />
                                        <span>2 yrs 5 mos</span>
                                    </p>
                                    <p>Dhaka, Bangladesh</p>
                                    <div class="profileSummery mt-4">
                                        <h4>Job Summary:</h4>
                                        <ul>
                                            <li>This was my first job in the banking field.</li>
                                            <li>
                                                I gained a good amount of leadership skills & learned
                                                to think about the business side of banking.
                                            </li>
                                            <li>
                                                After a while, I led a team of three . I had to
                                                maintain communication with the stakeholders.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png" alt="Options" class="threeDot" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row jobCard border-bottom">
                    <div class="col-2 col-md-1">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/hrbcLogo.png" alt="Company Logo" class="companyLogo" />
                        <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/profile/hrbcLogo.png" alt="Company Logo"
                             class="mobileLogo" />
                    </div>
                    <div class="col-10 col-md-11">
                        <div class="jobPosition d-flex justify-content-between">
                            <div class="d-flex">
                                <div class="profileCard">
                                    <h3>Sales Intern</h3>
                                    <h4>
                                        HSBC <img src="{{ asset('/') }}frontend/employee/images/profile/dotDevider.png" alt="" />
                                        <span>Full Time</span>
                                    </h4>
                                    <p class="mb-0">
                                        Jan 2025 - Present
                                        <img src="{{ asset('/') }}frontend/employee/images/profile/2ndDotDevider.png" alt="" />
                                        <span>2 yrs 5 mos</span>
                                    </p>
                                    <p>Dhaka, Bangladesh</p>
                                    <div class="profileSummery mt-4">
                                        <h4>Job Summary:</h4>
                                        <ul>
                                            <li>This was my first job in the banking field.</li>
                                            <li>
                                                I gained a good amount of leadership skills & learned
                                                to think about the business side of banking.
                                            </li>
                                            <li>
                                                After a while, I led a team of three . I had to
                                                maintain communication with the stakeholders.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png" alt="Options" class="threeDot" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- education -->
            <div class="right-panel w-100">
                <div class="d-flex align-items-center justify-content-between profileOverview">
                    <!-- Education Add Button (Existing Button) -->
                    <h3>Education</h3>
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#addEducationModal">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/plusIcon.png" alt="" /> Add
                    </button>

                    <!-- Modal for Add Education -->
                    <div class="modal fade" id="addEducationModal" tabindex="-1" aria-labelledby="addEducationModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addEducationModalLabel">
                                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-1" />
                                        Add Education
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form for adding education -->
                                    <form>
                                        <div class="mb-4">
                                            <label for="degreeInput" class="form-label">Degree</label>
                                            <input type="text" class="form-control" id="degreeInput" placeholder="Type here" />
                                        </div>

                                        <div class="mb-4">
                                            <label for="universityInput" class="form-label">University name</label>
                                            <input type="text" class="form-control" id="universityInput" placeholder="Type here" />
                                        </div>

                                        <div class="mb-4">
                                            <label for="fieldOfStudyInput" class="form-label">Field of study</label>
                                            <input type="text" class="form-control" id="fieldOfStudyInput" placeholder="Type here" />
                                        </div>

                                        <div class="mb-4">
                                            <label for="majorSubjectInput" class="form-label">Major subject</label>
                                            <input type="text" class="form-control" id="majorSubjectInput" placeholder="Type here" />
                                        </div>

                                        <div class="mb-4">
                                            <label for="startDateInput" class="form-label">Start date</label>
                                            <div class="d-flex">
                                                <select class="form-control me-2" id="startMonthInput">
                                                    <option value="">Month</option>
                                                    <option value="jan">January</option>
                                                    <option value="feb">February</option>
                                                    <!-- Add other months -->
                                                </select>
                                                <select class="form-control" id="startYearInput">
                                                    <option value="">Year</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2020">2020</option>
                                                    <!-- Add more years -->
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="endDateInput" class="form-label">End date</label>
                                            <div class="d-flex">
                                                <select class="form-control me-2" id="endMonthInput">
                                                    <option value="">Month</option>
                                                    <option value="jan">January</option>
                                                    <option value="feb">February</option>
                                                    <!-- Add other months -->
                                                </select>
                                                <select class="form-control" id="endYearInput">
                                                    <option value="">Year</option>
                                                    <option value="2023">2023</option>
                                                    <option value="2022">2022</option>
                                                    <!-- Add more years -->
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="cgpaInput" class="form-label">CGPA</label>
                                            <input type="text" class="form-control" id="cgpaInput" placeholder="Type here" />
                                        </div>

                                        <div class="mb-4">
                                            <label for="locationInput" class="form-label">Location</label>
                                            <input type="text" class="form-control" id="locationInput" placeholder="Type here" />
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="button" class="btn btn-primary">
                                        Add Education
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row jobCard border-bottom">
                    <div class="col-2 col-md-1">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/norSouthUnivercity.png" alt="Company Logo" class="companyLogo" />
                        <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/profile/norSouthUnivercity.png" alt="Company Logo"
                             class="mobileLogo" />
                    </div>
                    <div class="col-10 col-md-11">
                        <div class="jobPosition d-flex justify-content-between">
                            <div class="d-flex">
                                <div class="profileCard">
                                    <h3>North South University</h3>
                                    <h4>
                                        BBA - Marketing
                                        <img src="{{ asset('/') }}frontend/employee/images/profile/dotDevider.png" alt="" />
                                        <span>CGPA 3.45</span>
                                    </h4>
                                    <p class="mb-0">
                                        Jan 2025 - Present
                                        <img src="{{ asset('/') }}frontend/employee/images/profile/2ndDotDevider.png" alt="" />
                                        <span>2 yrs 5 mos</span>
                                    </p>
                                    <p>Dhaka, Bangladesh</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png" alt="Options" class="threeDot" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row jobCard border-bottom">
                    <div class="col-2 col-md-1">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/noterDemCollage.png" alt="Company Logo" class="companyLogo" />
                        <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/profile/noterDemCollage.png" alt="Company Logo"
                             class="mobileLogo" />
                    </div>
                    <div class="col-10 col-md-11">
                        <div class="jobPosition d-flex justify-content-between">
                            <div class="d-flex">
                                <div class="profileCard">
                                    <h3>Notre Dame College</h3>
                                    <h4>
                                        HSC - Science
                                        <img src="{{ asset('/') }}frontend/employee/images/profile/dotDevider.png" alt="" />
                                        <span>GPA 5.00</span>
                                    </h4>
                                    <p class="mb-0">
                                        Jan 2025 - Present
                                        <img src="{{ asset('/') }}frontend/employee/images/profile/2ndDotDevider.png" alt="" />
                                        <span>2 yrs 5 mos</span>
                                    </p>
                                    <p>Dhaka, Bangladesh</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png" alt="Options" class="threeDot" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row jobCard border-bottom">
                    <div class="col-2 col-md-1">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/sentGourgeScool.png" alt="Company Logo" class="companyLogo" />
                        <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/profile/sentGourgeScool.png" alt="Company Logo"
                             class="mobileLogo" />
                    </div>
                    <div class="col-10 col-md-11">
                        <div class="jobPosition d-flex justify-content-between">
                            <div class="d-flex">
                                <div class="profileCard">
                                    <h3>St. Gregory’s High School</h3>
                                    <h4>
                                        SSC - Science<img src="{{ asset('/') }}frontend/employee/images/profile/dotDevider.png" alt="" />
                                        <span>GPA 5.00</span>
                                    </h4>
                                    <p class="mb-0">
                                        Jan 2025 - Present
                                        <img src="{{ asset('/') }}frontend/employee/images/profile/2ndDotDevider.png" alt="" />
                                        <span>2 yrs 5 mos</span>
                                    </p>
                                    <p>Dhaka, Bangladesh</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png" alt="Options" class="threeDot" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- documents -->
            <div class="right-panel w-100">
                <div class="d-flex align-items-center justify-content-between profileOverview">
                    <!-- Document Add Button (Existing Button) -->
                    <h3>Documents</h3>
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/plusIcon.png" alt="" /> Add
                    </button>

                    <!-- Modal for Add Document -->
                    <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addDocumentModalLabel">
                                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-1" />
                                        Add Document
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form for adding document -->
                                    <form>
                                        <div class="mb-4">
                                            <label for="documentFileInput" class="form-label">Document</label>
                                            <div class="d-flex align-items-center">
                                                <input type="file" class="form-control" id="documentFileInput" />
                                                <span class="ms-2">cv.pdf <small>(PDF - 325 KB)</small></span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="button" class="btn btn-primary">
                                        Upload Document
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row jobCard border-bottom">
                    <div class="col-2">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/CV.png" alt="Company Logo" class="companyLogo" />
                        <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/profile/CV.png" alt="Company Logo" class="mobileLogo" />
                    </div>

                    <div class="col-10">
                        <div class="jobPosition d-flex justify-content-between">
                            <div class="d-flex">
                                <div class="profileCard">
                                    <h3>Curriculum Vitae</h3>
                                    <p class="mb-0">
                                        PDF - Present
                                        <img src="{{ asset('/') }}frontend/employee/images/profile/2ndDotDevider.png" alt="" />
                                        <span>325 KB</span>
                                    </p>
                                    <p>Dhaka, Bangladesh</p>
                                    <div class="profileSummery mt-4"></div>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png" alt="Options" class="threeDot" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row jobCard border-bottom">
                    <div class="col-2">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/NID.png" alt="Company Logo" class="companyLogo" />
                        <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/profile/NID.png" alt="Company Logo" class="mobileLogo" />
                    </div>
                    <div class="col-10">
                        <div class="jobPosition d-flex justify-content-between">
                            <div class="d-flex">
                                <div class="profileCard">
                                    <h3>National ID card</h3>
                                    <p class="mb-0">
                                        JPG - Present
                                        <img src="{{ asset('/') }}frontend/employee/images/profile/2ndDotDevider.png" alt="" />
                                        <span>325 KB</span>
                                    </p>
                                    <p>Dhaka, Bangladesh</p>
                                    <div class="profileSummery mt-4"></div>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png" alt="Options" class="threeDot" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row jobCard border-bottom">
                    <div class="col-2">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/DMC.png" alt="Company Logo" class="companyLogo" />
                        <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/profile/DMC.png" alt="Company Logo" class="mobileLogo" />
                    </div>
                    <div class="col-10">
                        <div class="jobPosition d-flex justify-content-between">
                            <div class="d-flex">
                                <div class="profileCard">
                                    <h3>Digital Marketing Certification</h3>
                                    <p class="mb-0">
                                        PDF - Present
                                        <img src="{{ asset('/') }}frontend/employee/images/profile/2ndDotDevider.png" alt="" />
                                        <span>325 KB</span>
                                    </p>
                                    <p>Dhaka, Bangladesh</p>
                                    <div class="profileSummery mt-4"></div>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png" alt="Options" class="threeDot" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
