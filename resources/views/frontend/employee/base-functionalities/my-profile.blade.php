@extends('frontend.employee.master')

@section('title', 'My Profile')

@section('body')

    <!-- Main Content -->
    <div class="container container-main mt-3 profileMain">
        <aside class="left-panel p-3">
            <div class="card">
                <div class="card-body profile">
                    <img src="{{ asset('/') }}frontend/employee/images/header images/Thumbnail.png" alt="Profile" class="rounded-circle mb-2" width="80" />
                    <h5>{{ auth()->user()->name ?? 'Mohammed Pranto' }}</h5>

                    <div class="d-flex justify-content-center justify-content-md-start">
                        <div class="dropdown d-flex align-items-center">
    <span class="badge d-flex align-items-center">
      <img src="{{ asset('/') }}frontend/employee/images/profile/Ellipse 1.png" alt="" class="me-2" />
      <span id="selectedRole">{{ auth()->user()->is_open_for_hire == 1 ? 'Open to Hire' : 'Offline' }}</span>
    </span>
                            <img src="{{ asset('/') }}frontend/employee/images/profile/downArrow.png" alt="" data-bs-toggle="dropdown" aria-expanded="false" class="ms-2" style="cursor: pointer;" />

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="updateRole('Open to Full-time Roles')">Open to Hire</a></li>
                                <li><a class="dropdown-item" href="#" onclick="updateRole('Open to Part-time Roles')">Offline</a></li>
{{--                                <li><a class="dropdown-item" href="#" onclick="updateRole('Open to Internship')">Open to Internship</a></li>--}}
{{--                                <li><a class="dropdown-item" href="#" onclick="updateRole('Open to Freelance Projects')">Open to Freelance Projects</a></li>--}}
                            </ul>
                        </div>
                    </div>



                    <p class="mt-2">
                        {{ auth()->user()->profile_title ?? 'Mobile App Developer, Flutter Developer Instructor & Mentor' }}
                    </p>

                    <div class="viewoProfileforSmallDevice py-4">
                        <a href="">View profile details</a>
                        <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right dark.png" alt="">
                    </div>

                    <!-- editt profile -->
                    <div class="profileEdit">
                        <!-- Trigger for Edit Bio Modal -->
                        <h2 class="">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/editIcon.png" alt="" class="me-1" />
                            <span class="editBio" data-bs-toggle="modal" data-bs-target="#editBioModal">Edit bio</span>
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
                                    <form action="{{ route('employee.update-profile', auth()->id()) }}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <!-- Form for editing contact info -->
                                                <div class="mb-3">
                                                    <label for="locationInput" class="form-label">Location</label>
                                                    <textarea name="address" class="form-control" id="locationInput" cols="30" rows="5">{!! auth()->user()->address ?? '' !!}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="emailInput" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="emailInput" value="{!! auth()->user()->email ?? '' !!}" placeholder="md.pranto@gmail.com" />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phoneInput" class="form-label">Phone</label>
                                                    <input type="tel" class="form-control" id="phoneInput" value="{!! auth()->user()->mobile ?? '' !!}" name="mobile" placeholder="+8801653523779" />
                                                </div>

                                                <div class="mb-3">
                                                    <label for="phoneInput" class="form-label">Website</label>
                                                    <input type="tel" class="form-control" id="phoneInput" name="website" value="{!! auth()->user()->website ?? '' !!}" placeholder="www.devpranto.com" />
                                                </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            Save Changes
                                        </button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>


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
                            <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" class="profileRightArrow" />
                        </div>
                    </div>
                    <h1>{{ auth()->user()->employeeSavedJobs()->count() ?? 0 }}</h1>
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
                            <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" class="profileRightArrow" />
                        </div>
                    </div>
                    <h1>{{ auth()->user()->employeeAppliedJobs()->count() ?? 0 }}</h1>
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
                            <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" class="profileRightArrow" />
                        </div>
                    </div>
                    <h1>{{ auth()->user()->employeeAppliedJobs()->count() ?? 0 }}</h1>
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


                </div>
                @foreach($workExperiences as $workExperience)
                    <div class="row jobCard border-bottom">
                        <div class="col-2 col-md-1">
                            <img src="{{ isset($workExperience->company_logo) ? asset($workExperience->company_logo) : asset('/frontend/employee/images/contentImages/companyLogoFor job.png') }}" alt="Company Logo" class="companyLogo" />
                            <img style="width: 40px; height: 42px" src="{{ asset( $workExperience->company_logo ?? '/frontend/employee/images/contentImages/companyLogoFor job.png') }}" alt="Company Logo"
                                 class="mobileLogo" />
                        </div>
                        <div class="col-10 col-md-11">
                            <div class="jobPosition d-flex justify-content-between">
                                <div class="d-flex">
                                    <div class="profileCard">
                                        <h3>{{ $workExperience->title ?? 'Executive Officer, Sales' }}</h3>
                                        <h4>
                                            {{ $workExperience->company_name ?? 'United Commercial Bank PLC' }}
                                            <img src="{{ asset('/') }}frontend/employee/images/profile/dotDevider.png" alt="" />
                                            <span>{{ $workExperience->job_type ?? 'Full Time' }}</span>
                                        </h4>
                                        <p class="mb-0">
                                            {{ \Illuminate\Support\Carbon::parse($workExperience->start_date)->format('M Y') }} - {{ $workExperience->is_working_currently == 1 ? 'Present' : \Illuminate\Support\Carbon::parse($workExperience->end_date)->format('M Y') }}
                                            <img src="{{ asset('/') }}frontend/employee/images/profile/2ndDotDevider.png" alt="" />
{{--                                            <span>2 yrs 5 mos</span>--}}
                                            <span>{{ differTime($workExperience->start_date, $workExperience->is_working_currently == 1 ? now() : $workExperience->end_date ) }}</span>
                                        </p>
                                        <p>{{ $workExperience->office_address ?? 'Dhaka' }}</p>
                                        <div class="profileSummery mt-4">
                                            <h4>Job Summary:</h4>
                                            <div>{!! $workExperience->job_responsibilities ?? 'job responsibilities' !!}</div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="dropdown">
                                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png"
                                             alt="Options"
                                             class="threeDot"
                                             role="button"
                                             data-bs-toggle="dropdown"
                                             aria-expanded="false" />

                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li>
                                                <form action="{{ route('employee.employee-work-experiences.destroy', $workExperience->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item" type="submit">Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

{{--                <div class="row jobCard border-bottom">--}}
{{--                    <div class="col-2 col-md-1">--}}
{{--                        <img src="{{ asset('/') }}frontend/employee/images/profile/hrbcLogo.png" alt="Company Logo" class="companyLogo" />--}}
{{--                        <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/profile/hrbcLogo.png" alt="Company Logo"--}}
{{--                             class="mobileLogo" />--}}
{{--                    </div>--}}
{{--                    <div class="col-10 col-md-11">--}}
{{--                        <div class="jobPosition d-flex justify-content-between">--}}
{{--                            <div class="d-flex">--}}
{{--                                <div class="profileCard">--}}
{{--                                    <h3>Sales Intern</h3>--}}
{{--                                    <h4>--}}
{{--                                        HSBC <img src="{{ asset('/') }}frontend/employee/images/profile/dotDevider.png" alt="" />--}}
{{--                                        <span>Full Time</span>--}}
{{--                                    </h4>--}}
{{--                                    <p class="mb-0">--}}
{{--                                        Jan 2025 - Present--}}
{{--                                        <img src="{{ asset('/') }}frontend/employee/images/profile/2ndDotDevider.png" alt="" />--}}
{{--                                        <span>2 yrs 5 mos</span>--}}
{{--                                    </p>--}}
{{--                                    <p>Dhaka, Bangladesh</p>--}}
{{--                                    <div class="profileSummery mt-4">--}}
{{--                                        <h4>Job Summary:</h4>--}}
{{--                                        <ul>--}}
{{--                                            <li>This was my first job in the banking field.</li>--}}
{{--                                            <li>--}}
{{--                                                I gained a good amount of leadership skills & learned--}}
{{--                                                to think about the business side of banking.--}}
{{--                                            </li>--}}
{{--                                            <li>--}}
{{--                                                After a while, I led a team of three . I had to--}}
{{--                                                maintain communication with the stakeholders.--}}
{{--                                            </li>--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <div class="dropdown">--}}
{{--                                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png"--}}
{{--                                         alt="Options"--}}
{{--                                         class="threeDot"--}}
{{--                                         role="button"--}}
{{--                                         data-bs-toggle="dropdown"--}}
{{--                                         aria-expanded="false" />--}}

{{--                                    <ul class="dropdown-menu dropdown-menu-end">--}}
{{--                                        <li><a class="dropdown-item" href="#">Edit</a></li>--}}
{{--                                        <li><a class="dropdown-item" href="#">Delete</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>

            <!-- education -->
            <div class="right-panel w-100">
                <div class="d-flex align-items-center justify-content-between profileOverview">
                    <!-- Education Add Button (Existing Button) -->
                    <h3>Education</h3>
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#addEducationModal">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/plusIcon.png" alt="" /> Add
                    </button>

                </div>
                @forelse($employeeEducations as $employeeEducation)
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
                                        <h3>{{ $employeeEducation?->universityName?->name ?? 'North South University' }}</h3>
                                        <h4>
                                            {{ $employeeEducation?->educationDegreeName?->degree_name ?? 'BBA' }} - {{ $employeeEducation?->fieldOfStudy?->field_name ?? 'Marketing' }}
                                            <img src="{{ asset('/') }}frontend/employee/images/profile/dotDevider.png" alt="" />
                                            <span>CGPA {{ $employeeEducation->cgpa ?? 0.00 }}</span>
                                        </h4>
                                        <p class="mb-0">
                                            Passing Year: {{ $employeeEducation->passing_year ?? '1990' }}
{{--                                            <img src="{{ asset('/') }}frontend/employee/images/profile/2ndDotDevider.png" alt="" />--}}
{{--                                            <span>2 yrs 5 mos</span>--}}
                                        </p>
                                        <p>
                                            {!! $employeeEducation->address ?? '' !!}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div class="dropdown">
                                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png"
                                             alt="Options"
                                             class="threeDot"
                                             role="button"
                                             data-bs-toggle="dropdown"
                                             aria-expanded="false" />

                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li>
                                                <form action="{{ route('employee.employee-educations.destroy', $employeeEducation->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item" type="submit">Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="row jobCard border-bottom">
                        <div class="col-12">
                            <p class="f-s-35">No Education Info Enlisted.</p>
                        </div>
                    </div>
                @endforelse

{{--                <div class="row jobCard border-bottom">--}}
{{--                    <div class="col-2 col-md-1">--}}
{{--                        <img src="{{ asset('/') }}frontend/employee/images/profile/noterDemCollage.png" alt="Company Logo" class="companyLogo" />--}}
{{--                        <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/profile/noterDemCollage.png" alt="Company Logo"--}}
{{--                             class="mobileLogo" />--}}
{{--                    </div>--}}
{{--                    <div class="col-10 col-md-11">--}}
{{--                        <div class="jobPosition d-flex justify-content-between">--}}
{{--                            <div class="d-flex">--}}
{{--                                <div class="profileCard">--}}
{{--                                    <h3>Notre Dame College</h3>--}}
{{--                                    <h4>--}}
{{--                                        HSC - Science--}}
{{--                                        <img src="{{ asset('/') }}frontend/employee/images/profile/dotDevider.png" alt="" />--}}
{{--                                        <span>GPA 5.00</span>--}}
{{--                                    </h4>--}}
{{--                                    <p class="mb-0">--}}
{{--                                        Jan 2025 - Present--}}
{{--                                        <img src="{{ asset('/') }}frontend/employee/images/profile/2ndDotDevider.png" alt="" />--}}
{{--                                        <span>2 yrs 5 mos</span>--}}
{{--                                    </p>--}}
{{--                                    <p>Dhaka, Bangladesh</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <div class="dropdown">--}}
{{--                                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png"--}}
{{--                                         alt="Options"--}}
{{--                                         class="threeDot"--}}
{{--                                         role="button"--}}
{{--                                         data-bs-toggle="dropdown"--}}
{{--                                         aria-expanded="false" />--}}

{{--                                    <ul class="dropdown-menu dropdown-menu-end">--}}
{{--                                        <li><a class="dropdown-item" href="#">Edit</a></li>--}}
{{--                                        <li><a class="dropdown-item" href="#">Delete</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>

            <!-- documents -->
            <div class="right-panel w-100">
                <div class="d-flex align-items-center justify-content-between profileOverview">
                    <!-- Document Add Button (Existing Button) -->
                    <h3>Documents</h3>
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/plusIcon.png" alt="" /> Add
                    </button>

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
                                <div class="dropdown">
                                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png"
                                         alt="Options"
                                         class="threeDot"
                                         role="button"
                                         data-bs-toggle="dropdown"
                                         aria-expanded="false" />

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
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
                                <div class="dropdown">
                                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png"
                                         alt="Options"
                                         class="threeDot"
                                         role="button"
                                         data-bs-toggle="dropdown"
                                         aria-expanded="false" />

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
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
                                <div class="dropdown">
                                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png"
                                         alt="Options"
                                         class="threeDot"
                                         role="button"
                                         data-bs-toggle="dropdown"
                                         aria-expanded="false" />

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


@endsection

@section('modal')



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
                <form action="{{ route('employee.employee-work-experiences.store') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <!-- Form for adding work experience -->

                            @csrf
                            <div class="mb-4">
                                <label for="jobTitleInput" class="form-label">Job title</label>
                                <input type="text" class="form-control" name="title" id="jobTitleInput" placeholder="Type here" />
                            </div>

                            <div class="mb-4">
                                <label for="jobTypeInput" class="form-label">Job type</label>
                                <select class="form-control" id="jobTypeInput" name="job_type">
                                    <option value="">Select</option>
                                    <option value="full_time">Full-time</option>
                                    <option value="part_time">Part-time</option>
                                    <option value="contractual">Contractual</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="companyInput" class="form-label">Company/Organization</label>
                                <input type="text" class="form-control" name="company_name" id="companyInput" placeholder="Type here" />

                                <label for="companyLogo" class="form-label">Company/Organization Logo</label>
                                <input type="file" class="form-control" name="company_logo" id="companyLogo" accept="image/*" />
                            </div>

                            <div class="mb-4">
                                <label for="startDateInput" class="form-label">Start date</label>
                                <div class="d-flex">
    {{--                                <select class="form-control me-2" id="startMonthInput" name="">--}}
    {{--                                    <option value="">Month</option>--}}
    {{--                                    <option value="jan">January</option>--}}
    {{--                                    <option value="feb">February</option>--}}
    {{--                                    <!-- Add other months -->--}}
    {{--                                </select>--}}
                                    <input type="date" name="start_date" class="form-control m-1" />
    {{--                                <select class="form-control" id="startYearInput" name="">--}}
    {{--                                    <option value="">Year</option>--}}
    {{--                                    <option value="2021">2021</option>--}}
    {{--                                    <option value="2020">2020</option>--}}
    {{--                                    <!-- Add more years -->--}}
    {{--                                </select>--}}
                                    <input type="date" name="end_date" class="form-control m-1" />
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="currentJobCheck" name="is_working_currently" />
                                    <label class="form-check-label" for="currentJobCheck">I currently work here</label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="locationInput" class="form-label">Location</label>
                                <input type="text" class="form-control" name="office_address"  id="locationInput" placeholder="Type here" />
                            </div>

                            <div class="mb-4">
                                <label for="workSummaryInput" class="form-label">Job summary</label>
                                <textarea class="form-control summernote" name="job_responsibilities" id="workSummaryInput" rows="4" placeholder="Type here"></textarea>
                            </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Add Experience
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                <form action="{{ route('employee.employee-educations.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!-- Form for adding education -->

                        <div class="mb-4">
                            <label for="degreeInput" class="form-label">Education Program</label>
{{--                            <input type="text" class="form-control" id="degreeInput" placeholder="Type here" />--}}
                            <select name="education_degree_name_id" class="form-control select2" id="">
                                <option selected disabled>Select Education Program</option>
                                @foreach($educationDegreeNames as $educationDegreeName)
                                    <option value="{{ $educationDegreeName->id }}">{{ $educationDegreeName->degree_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="universityInput" class="form-label">University name</label>
{{--                            <input type="text" class="form-control" id="universityInput" placeholder="Type here" />--}}
                            <select name="university_name_id" class="form-control select2" id="">
                                <option selected disabled>Select University</option>
                                @foreach($universityNames as $universityName)
                                    <option value="{{ $universityName->id }}">{{ $universityName->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="fieldOfStudyInput" class="form-label">Field of study</label>
                            <input type="text" class="form-control" id="fieldOfStudyInput" placeholder="Type here" />
                            <select name="field_of_study_id" class="form-control select2" id="">
                                <option selected disabled>Select Field of Study</option>
                                @foreach($fieldOfStudies as $fieldOfStudy)
                                    <option value="{{ $fieldOfStudy->id }}">{{ $fieldOfStudy->field_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="passingYear" class="form-label">Passing Year</label>
                            <input type="text" class="form-control" name="passing_year" id="passingYear" placeholder="Type here" />
                        </div>
{{--                        <div class="mb-4">--}}
{{--                            <label for="majorSubjectInput" class="form-label">Major subject</label>--}}
{{--                            <input type="text" class="form-control" id="majorSubjectInput" placeholder="Type here" />--}}
{{--                        </div>--}}

{{--                        <div class="mb-4">--}}
{{--                            <label for="startDateInput" class="form-label">Start date</label>--}}
{{--                            <div class="d-flex">--}}
{{--                                <select class="form-control me-2" id="startMonthInput">--}}
{{--                                    <option value="">Month</option>--}}
{{--                                    <option value="jan">January</option>--}}
{{--                                    <option value="feb">February</option>--}}
{{--                                    <!-- Add other months -->--}}
{{--                                </select>--}}
{{--                                <select class="form-control" id="startYearInput">--}}
{{--                                    <option value="">Year</option>--}}
{{--                                    <option value="2021">2021</option>--}}
{{--                                    <option value="2020">2020</option>--}}
{{--                                    <!-- Add more years -->--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="mb-4">--}}
{{--                            <label for="endDateInput" class="form-label">End date</label>--}}
{{--                            <div class="d-flex">--}}
{{--                                <select class="form-control me-2" id="endMonthInput">--}}
{{--                                    <option value="">Month</option>--}}
{{--                                    <option value="jan">January</option>--}}
{{--                                    <option value="feb">February</option>--}}
{{--                                    <!-- Add other months -->--}}
{{--                                </select>--}}
{{--                                <select class="form-control" id="endYearInput">--}}
{{--                                    <option value="">Year</option>--}}
{{--                                    <option value="2023">2023</option>--}}
{{--                                    <option value="2022">2022</option>--}}
{{--                                    <!-- Add more years -->--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="mb-4">
                            <label for="cgpaInput" class="form-label">CGPA</label>
                            <input type="text" name="cgpa" class="form-control" id="cgpaInput" placeholder="Type here" />
                        </div>

                        <div class="mb-4">
                            <label for="locationInput" class="form-label">Location</label>
                            <input type="text" name="address" class="form-control" id="locationInput" placeholder="Type here" />
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Add Education
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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


    <!-- Edit Bio Modal -->
    <div class="modal fade" id="editBioModal" tabindex="-1" aria-labelledby="editBioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="editBioModalLabel">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-2" />
                        Edit Bio
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('employee.update-profile', auth()->id()) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bioTextarea" class="form-label">Your Bio</label>
                            <textarea class="form-control" id="bioTextarea" name="profile_title" rows="5" placeholder="Write about yourself...">{{ auth()->user()->profile_title ?? 'Mobile App Developer, Flutter Developer Instructor & Mentor' }}</textarea>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Bio</button>
                </div>
                </form>
            </div>
        </div>
    </div>










@endsection
@push('script')

    <!-- include summernote css/js -->
   @include('common-resource-files.summernote')
   @include('common-resource-files.selectize')

    <!-- jQuery for controlling sticky behavior when modal opens/closes -->
    {{--                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}
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
@endpush
