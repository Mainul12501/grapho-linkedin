@extends('frontend.employee.master')

@section('title', 'My Profile')

@section('body')

    <!-- Main Content -->
    <div class="container container-main mt-3 profileMain">
        <aside class="left-panel p-3">
            <div class="card">
                <div class="card-body profile">
                    <img src="{{ asset(auth()->user()->profile_image ?? '/frontend/user-vector-img.jpg') }}" alt="Profile" class="rounded-circle mb-2" width="80" />
                    <h5>{{ auth()->user()->name ?? trans('common.user_name') }}</h5>

                    <div class="d-flex justify-content-center justify-content-md-start">
                        <div class="dropdown d-flex align-items-center">
                            <span class="badge d-flex align-items-center">
                              <img src="{{ asset('/') }}frontend/employee/images/profile/Ellipse 1.png" alt="" class="me-2" />
                              <span id="selectedRole" >{{ auth()->user()->is_open_for_hire == 1 ? trans('employee.open_to_work') : trans('employee.offline') }}</span>
                            </span>
                            <img src="{{ asset('/') }}frontend/employee/images/profile/downArrow.png" alt="" data-bs-toggle="dropdown" aria-expanded="false" class="ms-2" style="cursor: pointer;" />

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item change-job-active-status" href="javascript:void(0)" data-value="1" data-msg="{{ trans('employee.open_to_work') }}">{{ trans('employee.open_to_work') }}</a></li>
                                <li><a class="dropdown-item change-job-active-status" href="javascript:void(0)" data-value="0" data-msg="{{ trans('employee.offline') }}">{{ trans('employee.offline') }}</a></li>
{{--                                <li><a class="dropdown-item" href="#" onclick="updateRole('Open to Internship')">Open to Internship</a></li>--}}
{{--                                <li><a class="dropdown-item" href="#" onclick="updateRole('Open to Freelance Projects')">Open to Freelance Projects</a></li>--}}
                            </ul>
                        </div>
                    </div>



                    <p class="mt-2" data-bs-toggle="modal" data-bs-target="#editBioModal">
                        {{ auth()->user()->profile_title ?? 'user profile title here.' }}
                    </p>

                    <div class="viewoProfileforSmallDevice py-3 " style="border-top: 1px solid lightgrey;">
                        <a href="">{{ trans('employee.view_profile_details') }}</a>
                        <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right dark.png" alt="">
                    </div>

                    <!-- editt profile -->
                    <div class="profileEdit">
                        <!-- Trigger for Edit Bio Modal -->
                        <h2 class="">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/editIcon.png" alt="" class="me-1" />
                            <span class="editBio" data-bs-toggle="modal" data-bs-target="#editBioModal">{{ trans('employee.edit_bio') }}</span>
                        </h2>

                        <hr />
                        <div class="profileIngo location">
                            <div class="row">
                                <div class="col-2">
                                    <img src="{{ asset('/') }}frontend/employee/images/profile/location.png" alt="" />
                                </div>
                                <div class="col-10">
                                    <h4 class="mb-0">{{ trans('common.address') }}</h4>
                                    <p>{{ auth()->user()->address ?? trans('common.user_address') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="profileIngo email">
                            <div class="row">
                                <div class="col-2">
                                    <img src="{{ asset('/') }}frontend/employee/images/profile/email.png" alt="" />
                                </div>
                                <div class="col-10">
                                    <h4 class="mb-0">{{ trans('common.email') }}</h4>
                                    <p><a href="">{{ auth()->user()->email ?? 'user email' }}</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="profileIngo phone">
                            <div class="row">
                                <div class="col-2">
                                    <img src="{{ asset('/') }}frontend/employee/images/profile/phone.png" alt="" />
                                </div>
                                <div class="col-10">
                                    <h4 class="mb-0">{{ trans('common.phone') }}</h4>
                                    <p>{{ auth()->user()->mobile ?? '01500000000' }}</p>
                                </div>
                            </div>
                        </div>
{{--                        <div class="profileIngo website">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-2">--}}
{{--                                    <img src="{{ asset('/') }}frontend/employee/images/profile/website.png" alt="" />--}}
{{--                                </div>--}}
{{--                                <div class="col-10">--}}
{{--                                    <h4 class="mb-0">Website</h4>--}}
{{--                                    <p><a href="">{{ auth()->user()->website ?? 'domain.com' }}</a></p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <!-- edit contact with modal -->

                        <!-- Edit Contact Info (Existing Button) -->
                        <h2 class="mt-3">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/editIcon.png" alt="" class="me-1" />
                            <span class="editBio" data-bs-toggle="modal" data-bs-target="#editContactModal">{{ trans('employee.edit_contact_info') }}</span>
                        </h2>

                        <!-- Modal for Edit Contact -->
                        <div class="modal fade" id="editContactModal" tabindex="-1" aria-labelledby="editContactModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog custom-modal1 modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editContactModalLabel">
                                            <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-1" />
                                            {{ trans('employee.edit_contact_information') }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                                    </div>
                                    <form action="{{ route('employee.update-profile', auth()->id()) }}" method="post" enctype="multipart/form-data" id="employeeUpdateProfile">
                                        @csrf
                                        <div class="modal-body">
                                            <!-- Form for editing contact info -->

                                                <div class="mb-3">
                                                    <label for="nameInput" class="form-label">{{ trans('common.name') }}</label>
                                                    <input type="text" name="name" class="form-control" id="nameInput" value="{!! auth()->user()->name ?? '' !!}" placeholder="{{ trans('auth.type_here') }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="emailInput" class="form-label">{{ trans('common.email') }}</label>
                                                    <input type="email" name="email" class="form-control" id="emailInput" value="{!! auth()->user()->email ?? '' !!}" placeholder="{{ trans('auth.type_here') }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phoneInput" class="form-label">{{ trans('common.phone') }}</label>
                                                    <input type="tel" class="form-control" id="phoneInput" value="{!! auth()->user()->mobile ?? '' !!}" name="mobile" placeholder="{{ trans('auth.type_here') }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phoneInput" class="form-label">{{ trans('employee.gender') }}</label>
                                                    <select name="gender" class=" select2" id="">
                                                        <option value="male" {{ auth()->user()->gender == 'male' ? 'selected' : '' }}>{{ trans('employee.male') }}</option>
                                                        <option value="female" {{ auth()->user()->gender == 'female' ? 'selected' : '' }}>{{ trans('employee.female') }}</option>
                                                    </select>
                                                </div>
                                            <div class="mb-3">
                                                <label for="locationInput" class="form-label">{{ trans('common.address') }}</label>
                                                <textarea name="address" class="form-control" id="locationInput" cols="30" rows="5">{!! auth()->user()->address ?? '' !!}</textarea>
                                            </div>

                                                <div class="mb-3">
                                                    <label for="divisions" class="form-label">{{ trans('employee.division') }}</label>
                                                    <select name="division" id="divisions" onchange="divisionsList()" class="form-control w-100" data-placeholder="Select Division">
                                                        <option value="Barishal" {{ auth()->user()->division == 'Barishal' ? 'selected' : '' }}>Barishal</option>
                                                        <option value="Chattogram" {{ auth()->user()->division == 'Chattogram' ? 'selected' : '' }}>Chattogram</option>
                                                        <option value="Dhaka" {{ auth()->user()->division == 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                                                        <option value="Khulna" {{ auth()->user()->division == 'Khulna' ? 'selected' : '' }}>Khulna</option>
                                                        <option value="Mymensingh" {{ auth()->user()->division == 'Mymensingh' ? 'selected' : '' }}>Mymensingh</option>
                                                        <option value="Rajshahi" {{ auth()->user()->division == 'Rajshahi' ? 'selected' : '' }}>Rajshahi</option>
                                                        <option value="Rangpur" {{ auth()->user()->division == 'Rangpur' ? 'selected' : '' }}>Rangpur</option>
                                                        <option value="Sylhet" {{ auth()->user()->division == 'Sylhet' ? 'selected' : '' }}>Sylhet</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="distr" class="form-label">{{ trans('employee.district') }}</label>
                                                    <select name="district" id="distr" onchange="thanaList()" class="form-control w-100" data-placeholder="Select District">
                                                        <option value="">{{ auth()->user()->district ?? '' }}</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="polic_sta" class="form-label">{{ trans('employee.post_office') }}</label>
                                                    <select name="post_office" id="polic_sta"  class="form-control w-100" data-placeholder="Select District">
                                                        <option value="">{{ auth()->user()->post_office ?? '' }}</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="polic_sta" class="form-label">{{ trans('employee.post_code') }}</label>
                                                    <input type="text" name="postal_code" value="{{ auth()->user()->postal_code ?? '' }}" class="form-control" />
                                                </div>
                                            <div class="mb-3">
                                                <label for="phoneInput" class="form-label">{{ trans('common.website') }}</label>
                                                <input type="text" class="form-control" id="phoneInput" name="website" value="{!! auth()->user()->website ?? '' !!}" placeholder="{{ trans('auth.type_here') }}" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="profileImage" class="form-label">{{ trans('employee.profile_image') }}</label>
{{--                                                <input type="file" class="form-control" id="profileImage" name="profile_image" />--}}

{{--                                                drag drop crop start--}}
                                                <!-- Drag & Drop Area -->
                                                <!-- Drag & Drop Area -->
                                                <div class="drag-drop-area" id="dragDropArea">
                                                    <input type="file" class="file-input-hidden" id="profileImage" name="profile_image" accept="image/*">
                                                    <div class="upload-content" id="uploadContent">
                                                        <div class="upload-icon">📁</div>
                                                        <h5>{{ trans('employee.drag_drop_image') }}</h5>
                                                        <p class="text-muted">{{ trans('employee.or_click_to_browse') }}</p>
                                                        <small class="text-muted">{{ trans('employee.supports_jpg_png_gif') }}</small>
                                                    </div>
                                                </div>

                                                <!-- Image Preview & Cropping Area -->
                                                <div class="preview-container" id="previewContainer" style="display: none;">
                                                    <img id="imagePreview" style="max-width: 100%;">
                                                </div>

                                                <!-- Crop Controls -->
                                                <div class="crop-controls mt-3" id="cropControls" style="display: none;">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm" id="resetCrop">
                                                            🔄 {{ trans('employee.reset') }}
                                                        </button>
                                                        <button type="button" class="btn btn-outline-secondary btn-sm" id="rotateLeft">
                                                            ↺ {{ trans('employee.rotate_left') }}
                                                        </button>
                                                        <button type="button" class="btn btn-outline-secondary btn-sm" id="rotateRight">
                                                            ↻ {{ trans('employee.rotate_right') }}
                                                        </button>
                                                        <button type="button" class="btn btn-success btn-sm" id="cropImage">
                                                            ✂️ {{ trans('employee.crop_image') }}
                                                        </button>
                                                        <button type="button" class="btn btn-success btn-sm" id="saveImage" style="display: none">
                                                            ✂️ {{ trans('employee.save_image') }}
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Final Preview -->
                                                <div class="text-center mt-3" id="finalPreviewContainer" style="display: none;">
                                                    <h6>Cropped Image:</h6>
                                                    <img id="finalPreview" class="final-preview" alt="Cropped preview">
                                                    <div class="mt-2">
                                                        <button type="button" class="btn btn-outline-primary btn-sm" id="changeImage">
                                                            {{ trans('employee.change_image') }}
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- Hidden input for cropped image data -->
                                                <input type="hidden" id="croppedImageData" name="cropped_image_data">

                                                <!-- Add the preview container, crop controls, and final preview divs here -->
                                                <!-- (Copy from the artifact above) -->
{{--                                                drag drop crop end--}}





                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            {{ trans('common.close') }}
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            {{ trans('common.save_changes') }}
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

                <!-- Saved Jobs -->
                <div class="col-4 saveJobs">
                    <div class="row">
                        <div class="col-1 me-2">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/saveJobIcon.png" alt="">
                        </div>
                        <div class="col-8">
                            <h2>{{ trans('employee.my_saved_jobs') }}</h2>
                        </div>
                        <div class="col-2 text-end">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" class="profileRightArrow">
                        </div>
                    </div>
                    <h1 class="mt-2">{{ auth()->user()->employeeSavedJobs()->count() ?? 0 }}</h1>
                    <p class="mb-0">{{ trans('employee.jobs_saved') }}</p>
                </div>

                <!-- My Applications -->
                <div class="col-4 myApplication">
                    <div class="row">
                        <div class="col-1 me-2">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/myApplicationIcon.png" alt="">
                        </div>
                        <div class="col-8">
                            <h2>{{ trans('employee.my_applications') }}</h2>
                        </div>
                        <div class="col-2 text-end">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" class="profileRightArrow">
                        </div>
                    </div>
                    <h1 class="mt-2">{{ auth()->user()->employeeAppliedJobs()->count() ?? 0 }}</h1>
                    <p class="mb-0">{{ trans('employee.applications') }}</p>
                </div>

                <!-- Profile Viewers -->
                <div class="col-4">
                    <div class="row">
                        <div class="col-1 me-2">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/ProfileViewer.png" alt="">
                        </div>
                        <div class="col-8">
                            <h2>{{ trans('employee.my_profile_viewers') }}</h2>
                        </div>
                        <div class="col-2 text-end">
                            <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" class="profileRightArrow">
                        </div>
                    </div>
                    <h1 class="mt-2">{{ auth()->user()->viewEmployeeIds()->count() ?? 0 }}</h1>
                    <p class="mb-0">{{ trans('employee.viewers') }}</p>
                </div>
            </div>

            <!-- mobile user option -->
            <div class="right-panel w-100 userOptionforMobile">
                <div class="userOptionforMobileWraperMain">

                    <a href="{{ route('employee.my-saved-jobs') }}" class="userOptionforMobileOptions">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="left-side">
                                <img src="{{ asset('/') }}frontend/employee/images/header images/Saved jobs.png" alt="" /> Saved jobs
                            </div>
                            <div class="right-side">
                                <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" />
                            </div>
                        </div>
                    </a>


                    <a href="{{ route('employee.my-applications') }}" class="userOptionforMobileOptions">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="left-side">
                                <img src="{{ asset('/') }}frontend/employee/images/header images/Myapplications.png" alt="" /> My applications
                            </div>
                            <div class="right-side">
                                <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" />
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('employee.my-profile-viewers') }}" class="userOptionforMobileOptions">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="left-side">
                                <img src="{{ asset('/') }}frontend/employee/images/header images/Profilerviewers.png" alt="" /> Profiler viewers
                            </div>
                            <div class="right-side">
                                <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" />
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('employee.my-subscriptions') }}" class="userOptionforMobileOptions">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="left-side">
                                <img src="{{ asset('/') }}frontend/employee/images/header images/Subscription.png" alt="" /> {{ trans('employee.subscription') }}
                            </div>
                            <div class="right-side">
                                <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" />
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('employee.settings') }}" class="userOptionforMobileOptions">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="left-side">
                                <img src="{{ asset('/') }}frontend/employee/images/header images/Settings.png" alt="" /> {{ trans('employee.settings') }}
                            </div>
                            <div class="right-side">
                                <img src="{{ asset('/') }}frontend/employee/images/profile/arrow-right 1.png" alt="" />
                            </div>
                        </div>
                    </a>

                </div>
            </div>


            <!-- work experience -->
            <div class="right-panel w-100 ps-4 pt-3">
                <div class="d-flex align-items-center justify-content-between profileOverview">
                    <h3>{{ trans('employee.work_experiences') }}</h3>
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#addWorkExperienceModal">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/plusIcon.png" alt="" /> {{ trans('common.add') }}
                    </button>


                </div>
                @foreach($workExperiences as $workExperience)
                    <div class="row jobCard border-bottom">
                        <div class="col-2 col-md-1">
                            <img  src="{{ isset($workExperience->company_logo) ? asset($workExperience->company_logo) : asset('/frontend/company-vector.jpg') }}" alt="Company Logo" class="companyLogo" style="height: 56px; border-radius: 50%" />
                            <img style="width: 40px; height: 42px" src="{{ asset( $workExperience->company_logo ?? '/frontend/company-vector.jpg') }}" alt="Company Logo"
                                 class="mobileLogo" />
                        </div>
                        <div class="col-10 col-md-11">
                            <div class="jobPosition d-flex justify-content-between">
                                <div class="d-flex">
                                    <div class="profileCard">
                                        <h3>{{ $workExperience->title ?? 'Executive Officer, Sales' }}</h3>
                                        <h4>
                                            {{ $workExperience->company_name ?? trans('common.company_name') }}
                                            <img src="{{ asset('/') }}frontend/employee/images/profile/dotDevider.png" alt="" />
                                            <span>
                                                {{ $workExperience->job_type == 'part_time' ? "Part Time" : '' }}
                                                {{ $workExperience->job_type == 'full_time' ? trans('common.full_time') : '' }}
                                                {{ $workExperience->job_type == 'contractual' ? "Contractual" : '' }}
                                            </span>
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
                                            <div>{!! str()->words($workExperience->job_responsibilities, 30, ' ......') ?? 'job responsibilities' !!}</div>
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
                                            <li><a class="dropdown-item edit-work-experience f-s-15" data-work-experience-id="{{ $workExperience->id }}" href="javascript:void(0)">{{ trans('common.edit') }}</a></li>
                                            <li>
                                                <form action="{{ route('employee.employee-work-experiences.destroy', $workExperience->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item data-delete-form f-s-15" type="submit">{{ trans('common.delete') }}</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- education -->
            <div class="right-panel w-100  ps-4 pt-3">
                <div class="d-flex align-items-center justify-content-between profileOverview">
                    <!-- Education Add Button (Existing Button) -->
                    <h3>{{ trans('employee.education') }}</h3>
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#addEducationModal">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/plusIcon.png" alt="" /> {{ trans('common.add') }}
                    </button>

                </div>
                @forelse($employeeEducations as $employeeEducation)
                    <div class="row jobCard border-bottom">
                        <div class="col-2 col-md-1">
                            <img src="{{ asset('/') }}frontend/company-vector.jpg" alt="Company Logo" class="companyLogo" style="height: 56px; border-radius: 50%" />
                            <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/company-vector.jpg" alt="Company Logo"
                                 class="mobileLogo" />
                        </div>
                        <div class="col-10 col-md-11">
                            <div class="jobPosition d-flex justify-content-between">
                                <div class="d-flex">
                                    <div class="profileCard">
{{--                                        <h3>{{ $employeeEducation?->universityName?->name ?? 'North South University' }}</h3>--}}
                                        <h3>{{ $employeeEducation?->institute_name ?? 'Institute Name' }}</h3>
                                        <h4>
                                            {{ $employeeEducation?->educationDegreeName?->degree_name ?? 'BBA' }} - {{ $employeeEducation?->field_of_study ?? 'Field Of Study' }}
                                            <img src="{{ asset('/') }}frontend/employee/images/profile/dotDevider.png" alt="" />
                                            <span>{{ trans('common.cgpa') }} {{ $employeeEducation->cgpa ?? 0.00 }}</span>
                                        </h4>
                                        <p class="mb-0">
                                            Passing Year: {{ $employeeEducation->passing_year ?? '1990' }}
{{--                                            <img src="{{ asset('/') }}frontend/employee/images/profile/2ndDotDevider.png" alt="" />--}}
{{--                                            <span>2 yrs 5 mos</span>--}}
                                        </p>
{{--                                        <p>--}}
{{--                                            {!! $employeeEducation->address ?? '' !!}--}}
{{--                                        </p>--}}
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
                                            <li><a class="dropdown-item edit-education f-s-15" data-education-id="{{ $employeeEducation->id }}" href="javascript:void(0)">{{ trans('common.edit') }}</a></li>
                                            <li>
                                                <form action="{{ route('employee.employee-educations.destroy', $employeeEducation->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item data-delete-form f-s-15" type="submit">{{ trans('common.delete') }}</button>
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
                            <p class="f-s-35">{{ trans('employee.no_education_info_enlisted') }}</p>
                        </div>
                    </div>
                @endforelse


            </div>

            <!-- documents -->
            <div class="right-panel w-100 ps-4 pt-3">
                <div class="d-flex align-items-center justify-content-between profileOverview">
                    <!-- Document Add Button (Existing Button) -->
                    <h3>{{ trans('employee.documents') }}</h3>
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/plusIcon.png" alt="" /> {{ trans('common.add') }}
                    </button>

                </div>

                @forelse($employeeDocuments as $employeeDocument)
                    <div class="row jobCard border-bottom">
                        <div class="col-2">
                            <a href="{{ file_exists($employeeDocument->file) ? asset($employeeDocument->file) : '' }}" download="">

                                @if( explode('/', $employeeDocument->file_type)[1] == 'image' )
                                    <img style="max-width: 105px; max-height: 105px;" src="{{ isset($employeeDocument->file_thumb) ? asset($employeeDocument->file_thumb) : 'https://icons.iconarchive.com/icons/icons8/windows-8/512/Very-Basic-Image-File-icon.png' }}" alt="Company Logo" class="companyLogo" />
                                    <img style="width: 40px; height: 42px" src="{{ isset($employeeDocument->file_thumb) ? asset($employeeDocument->file_thumb) : 'https://icons.iconarchive.com/icons/icons8/windows-8/512/Very-Basic-Image-File-icon.png'}}" alt="Company Logo" class="mobileLogo" />
                                @elseif( explode('/', $employeeDocument->file_type)[1] == 'pdf' )
                                    <img style="max-width: 105px; max-height: 105px;" src="https://www.iconpacks.net/icons/2/free-pdf-icon-3375-thumb.png" alt="Company Logo" class="companyLogo" />
                                    <img style="width: 40px; height: 42px" src="https://www.iconpacks.net/icons/2/free-pdf-icon-3375-thumb.png" alt="Company Logo" class="mobileLogo" />
                                @elseif( explode('/', $employeeDocument->file_type)[1] == 'vnd.openxmlformats-officedocument.wordprocessingml.document' )
                                    <img style="max-width: 105px; max-height: 105px;" src="https://files.softicons.com/download/toolbar-icons/mono-general-icons-2-by-custom-icon-design/ico/document.ico" alt="Company Logo" class="companyLogo" />
                                    <img style="width: 40px; height: 42px" src="https://files.softicons.com/download/toolbar-icons/mono-general-icons-2-by-custom-icon-design/ico/document.ico" alt="Company Logo" class="mobileLogo" />
                                @else
                                    <img style="max-width: 105px; max-height: 105px;" src="{{ asset('/') }}frontend/employee/images/profile/CV.png" alt="Company Logo" class="companyLogo" />
                                    <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/profile/CV.png" alt="Company Logo" class="mobileLogo" />
                                @endif
                            </a>
                        </div>

                        <div class="col-10">
                            <div class="jobPosition d-flex justify-content-between">
                                <div class="d-flex">
                                    <div class="profileCard">
                                        <h3>{{ $employeeDocument->title }}</h3>
                                        <p class="mb-0">
                                            {{ explode('/', $employeeDocument->file_type)[0] }} {{--- Present--}}
                                            <img src="{{ asset('/') }}frontend/employee/images/profile/2ndDotDevider.png" alt="" />
                                            <span>{{ $employeeDocument->file_size ?? 0 }} KB</span>
                                        </p>
{{--                                        <p>Dhaka, Bangladesh</p>--}}
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
                                            <li><a class="dropdown-item edit-document f-s-15" data-document-id="{{ $employeeDocument->id }}" href="javascript:void(0)">{{ trans('common.edit') }}</a></li>
                                            <li>
                                                <form action="{{ route('employee.employee-documents.destroy', $employeeDocument->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item data-delete-form f-s-15" type="submit">{{ trans('common.delete') }}</button>
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
                            <span class="f-s-35">{{ trans('employee.no_documents_available') }}</span>
                        </div>
                    </div>
                @endforelse


{{--                <div class="row jobCard border-bottom">--}}
{{--                    <div class="col-2">--}}
{{--                        <img src="{{ asset('/') }}frontend/employee/images/profile/NID.png" alt="Company Logo" class="companyLogo" />--}}
{{--                        <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/profile/NID.png" alt="Company Logo" class="mobileLogo" />--}}
{{--                    </div>--}}
{{--                    <div class="col-10">--}}
{{--                        <div class="jobPosition d-flex justify-content-between">--}}
{{--                            <div class="d-flex">--}}
{{--                                <div class="profileCard">--}}
{{--                                    <h3>National ID card</h3>--}}
{{--                                    <p class="mb-0">--}}
{{--                                        JPG - Present--}}
{{--                                        <img src="{{ asset('/') }}frontend/employee/images/profile/2ndDotDevider.png" alt="" />--}}
{{--                                        <span>325 KB</span>--}}
{{--                                    </p>--}}
{{--                                    <p>Dhaka, Bangladesh</p>--}}
{{--                                    <div class="profileSummery mt-4"></div>--}}
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
        </section>
    </div>


@endsection

@section('modal')



    <!-- Modal for Add Work Experience -->
    <div class="modal fade" id="addWorkExperienceModal" tabindex="-1"
         aria-labelledby="addWorkExperienceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWorkExperienceModalLabel">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-1" />{{ trans('employee.add_work_experience') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <form action="{{ route('employee.employee-work-experiences.store') }}" method="post" enctype="multipart/form-data" id="createEmployeeWorkExperienceForm">
                    <div class="modal-body">
                        <!-- Form for adding work experience -->

                            @csrf
                            <div class="mb-4">
                                <label for="jobTitleInput" class="form-label">{{ trans('employee.position') }}</label>
                                <input type="text" class="form-control" required name="title" id="jobTitleInput" placeholder="{{ trans('auth.type_here') }}" />
                            </div>

                            <div class="mb-4">
                                <label for="jobTypeInput" class="form-label">{{ trans('common.job_type') }}</label>
                                <select class="form-control" id="jobTypeInput" name="job_type">
                                    <option value="">Select</option>
                                    <option value="full_time">Full-time</option>
                                    <option value="part_time">Part-time</option>
                                    <option value="contractual">Contractual</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="companyInput" class="form-label">{{ trans('employee.company_organization') }}</label>
                                <input type="text" class="form-control" required list="companyDatalist" name="company_name" id="companyInput" placeholder="{{ trans('auth.type_here') }}" />

{{--                                <label for="companyLogo" class="form-label mt-3">Company/Organization Logo</label>--}}
{{--                                <input type="file" class="form-control" name="company_logo" id="companyLogo" accept="image/*" />--}}
                            </div>

                            <div class="mb-4">

                                <div class="d-flex">
    {{--                                <select class="form-control me-2" id="startMonthInput" name="">--}}
    {{--                                    <option value="">Month</option>--}}
    {{--                                    <option value="jan">January</option>--}}
    {{--                                    <option value="feb">February</option>--}}
    {{--                                    <!-- Add other months -->--}}
    {{--                                </select>--}}
                                    <span style="width: 100%; margin-right: 5px;">
                                        <label for="startDateInput" class="form-label">{{ trans('employee.from') }}</label>
                                        <input type="date" name="start_date" class="form-control m-1" />
                                    </span>

    {{--                                <select class="form-control" id="startYearInput" name="">--}}
    {{--                                    <option value="">Year</option>--}}
    {{--                                    <option value="2021">2021</option>--}}
    {{--                                    <option value="2020">2020</option>--}}
    {{--                                    <!-- Add more years -->--}}
    {{--                                </select>--}}
                                    <span style="width: 100%; margin-left: 5px;">
                                        <label for="startDateInput" class="form-label">{{ trans('employee.to') }}</label>
                                        <input type="date" name="end_date" class="form-control m-1" />
                                    </span>

                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="currentJobCheck" name="is_working_currently" />
                                    <label class="form-check-label" for="currentJobCheck">{{ trans('employee.i_currently_work_here') }}</label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="locationInput" class="form-label">{{ trans('common.location') }}</label>
                                <input type="text" class="form-control" name="office_address"  id="locationInput" placeholder="{{ trans('auth.type_here') }}" />
                            </div>

                            <div class="mb-4">
                                <label for="workSummaryInput" class="form-label">{{ trans('employee.responsibilities') }}</label>
                                <textarea class="form-control summernote" name="job_responsibilities" id="workSummaryInput" rows="4" placeholder="{{ trans('auth.type_here') }}"></textarea>
                            </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ trans('common.close') }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            {{ trans('employee.add_experience') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Edit Work Experience -->
    <div class="modal fade" id="editWorkExperienceModal" tabindex="-1"
         aria-labelledby="addWorkExperienceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWorkExperienceModalLabel">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-1" />{{ trans('employee.update_work_experience') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <div id="workExperienceEditForm">

                </div>
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
                        {{ trans('employee.add_education') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <form action="{{ route('employee.employee-educations.store') }}" method="post" enctype="multipart/form-data" id="addEducationForm">
                    @csrf
                    <div class="modal-body">
                        <!-- Form for adding education -->

                        <div class="mb-4">
                            <label for="degreeInput" class="form-label">{{ trans('employee.program_name') }}</label>
{{--                            <input type="text" class="form-control" id="degreeInput" placeholder="{{ trans('auth.type_here') }}" />--}}
                            <select name="education_degree_name_id" class="form-control " required id="">
{{--                                <option  disabled>Select Education Program</option>--}}
                                @foreach($educationDegreeNames as $educationDegreeName)
                                    <option value="{{ $educationDegreeName->id }}" has-institute-name="{{ $educationDegreeName->need_institute_field }}">{{ $educationDegreeName->degree_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="universityDiv">
                            <div class="mb-4">
                                <label for="universityInput" class="form-label">{{ trans('employee.name_of_institution') }}</label>
                                                            <input type="text" required class="form-control" name="institute_name" id="universityInput" placeholder="{{ trans('auth.type_here') }}" />
{{--                                <select name="university_name_id" class="form-control select2" id="">--}}
{{--                                    <option  disabled>Select University</option>--}}
{{--                                    @foreach($universityNames as $universityName)--}}
{{--                                        <option value="{{ $universityName->id }}">{{ $universityName->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
                            </div>

                            <div class="mb-4">
                                <label for="fieldOfStudyInput" class="form-label">{{ trans('employee.background_field_of_study') }}</label>
                                                            <input required type="text" class="form-control" name="field_of_study" id="fieldOfStudyInput" placeholder="{{ trans('auth.type_here') }}" />
{{--                                <select name="field_of_study_id" class="form-control select2" id="">--}}
{{--                                    <option selected disabled>Select Field of Study</option>--}}
{{--                                    @foreach($fieldOfStudies as $fieldOfStudy)--}}
{{--                                        <option value="{{ $fieldOfStudy->id }}">{{ $fieldOfStudy->field_name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
                            </div>
                        </div>

{{--                        <div id="instituteNameDiv" class="d-none">--}}
{{--                            <div class="mb-4 " >--}}
{{--                                <label for="instituteName" class="form-label">Institute Name</label>--}}
{{--                                <input type="text" class="form-control" name="institute_name" id="instituteName" placeholder="Type here" />--}}
{{--                            </div>--}}
{{--                            <div class="mb-4 " >--}}
{{--                                <label for="groupName" class="form-label">Group Name</label>--}}
{{--                                <select name="group_name" class="form-control" id="">--}}
{{--                                    <option value="science">Science</option>--}}
{{--                                    <option value="commerce">Commerce</option>--}}
{{--                                    <option value="arts">Arts</option>--}}
{{--                                    <option value="technical">Technical</option>--}}
{{--                                    <option value="others">Others</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="mb-4">
                            <label for="passingYear" class="form-label">{{ trans('employee.passing_year') }}</label>
                            <input type="text" required class="form-control" name="passing_year" id="passingYear" placeholder="{{ trans('auth.type_here') }}" />
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
                            <label for="cgpaInput" class="form-label">{{ trans('employee.cgpa') }}</label>
                            <input type="text" required name="cgpa" class="form-control" id="cgpaInput" placeholder="{{ trans('auth.type_here') }}" />
                        </div>

{{--                        <div class="mb-4">--}}
{{--                            <label for="locationInput" class="form-label">Location</label>--}}
{{--                            <input type="text" name="address" class="form-control" id="locationInput" placeholder="Type here" />--}}
{{--                        </div>--}}
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ trans('common.close') }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            {{ trans('employee.add_education') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <datalist id="companyDatalist">
        @foreach($companyList as $company)
            <option value="{{ $company->name }}"></option>
        @endforeach
    </datalist>

    <!-- Modal for Add Education -->
    <div class="modal fade" id="editEducationModal" tabindex="-1" aria-labelledby="addEducationModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEducationModalLabel">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-1" />
                        {{ trans('employee.edit_education') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <div id="educationEditForm">

                </div>
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
                        {{ trans('employee.add_document') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <form action="{{ route('employee.employee-documents.store') }}" id="createEmployeeDocuments" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!-- Form for adding document -->

                            <div class="mb-3">
                                <label for="documentFileTitleInput" class="form-label">{{ trans('employee.document_title') }}</label>
                                <div class="d-flex align-items-center">
{{--                                    <input type="text" name="title" class="form-control" id="documentFileTitleInput" />--}}
                                    <select name="title" required class=" select2" id="" style="width: 100%;">
                                        <option value="CV">CV</option>
                                        <option value="NID">NID</option>
                                        <option value="Certificate">Certificate</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="documentFileInput" class="form-label">{{ trans('employee.document_file') }}</label>
                                <div class="d-flex align-items-center">
                                    <input type="file" required name="file" class="form-control" id="documentFileInput" />
{{--                                    <span class="ms-2">cv.pdf <small>(PDF - 325 KB)</small></span>--}}
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ trans('common.close') }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            {{ trans('employee.upload_document') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Add Document -->
    <div class="modal fade" id="editDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDocumentModalLabel">
                        <img src="{{ asset('/') }}frontend/employee/images/profile/profileLeftArrow.png" alt="" class="me-1" />
                        {{ trans('employee.edit_document') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>
                <div id="documentEditForm">

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
                        {{ trans('employee.edit_bio') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('common.close') }}"></button>
                </div>

                <form action="{{ route('employee.update-profile', auth()->id()) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bioTextarea" class="form-label">{{ trans('employee.your_bio') }}</label>
                            <textarea class="form-control" id="bioTextarea" name="profile_title" rows="5" placeholder="{{ trans('auth.type_here') }}">{{ auth()->user()->profile_title ?? 'Mobile App Developer, Flutter Developer Instructor & Mentor' }}</textarea>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('employee.save_bio') }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('style')
    <style>
        .form-control {border-radius: 0px}
        .selectize-input {padding: 15px!important;}
    </style>
@endpush
@push('script')

    <!-- include summernote css/js -->
   @include('common-resource-files.summernote')
   @include('common-resource-files.selectize')

    <script src="{{ asset('/frontend/employee/division-Districts-post-station/javascript.js') }}"></script>

    <script>
        $(document).on('click', '.edit-work-experience', function () {
            var jobId = $(this).attr('data-work-experience-id');
            var thisObject = $(this);
            // console.log(thisObject);
            sendAjaxRequest('employee/employee-work-experiences/'+jobId+'/edit', 'GET').then(function (response) {
                // console.log(response);
                $('#workExperienceEditForm').append(response);
                $('#editWorkSummaryInput').summernote({
                    height: 300
                });
                // $('.select2').select2();
                $('.select2').selectize();
                $('#editWorkExperienceModal').modal('show');
            })
        })
        $(document).on('click', '.edit-education', function () {
            var jobId = $(this).attr('data-education-id');
            var thisObject = $(this);
            // console.log(thisObject);
            sendAjaxRequest('employee/employee-educations/'+jobId+'/edit', 'GET').then(function (response) {
                // console.log(response);
                $('#educationEditForm').append(response);
                // $('#editWorkSummaryInput').summernote({
                //     height: 300
                // });
                // $('.select2').select2();
                $('.select2').selectize();
                $('#editEducationModal').modal('show');
            })
        })
        $(document).on('click', '.edit-document', function () {
            var jobId = $(this).attr('data-document-id');
            // var thisObject = $(this);
            // console.log(thisObject);
            sendAjaxRequest('employee/employee-documents/'+jobId+'/edit', 'GET').then(function (response) {
                // console.log(response);
                $('#documentEditForm').append(response);
                // $('#editWorkSummaryInput').summernote({
                //     height: 300
                // });
                // $('.select2').select2();
                $('.select2').selectize();
                $('#editDocumentModal').modal('show');
            })
        })
        // change job active status
        $(document).on('click', '.change-job-active-status', function () {
            var val = $(this).attr('data-value');
            var msg = $(this).attr('data-msg');
            // var thisObject = $(this);
            // console.log(thisObject);
            sendAjaxRequest('employee/change-job-active-status/'+val, 'GET').then(function (response) {
                // console.log(response);
                if (response.status == 'success')
                {
                    $('#selectedRole').text(msg);
                    toastr.success(response.success);
                } else {
                    toastr.error('Something went wrong. Please try again.');
                }
            })
        })
    </script>

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

    <!-- drag drop crop -->
    <style>
        .drag-drop-area {
            border: 2px dashed #007bff;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            background: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .drag-drop-area:hover {
            border-color: #0056b3;
            background: #e3f2fd;
        }

        .drag-drop-area.dragover {
            border-color: #28a745;
            background: #d4edda;
        }

        .preview-container {
            max-width: 100%;
            max-height: 400px;
            overflow: hidden;
            border-radius: 8px;
            margin: 15px 0;
        }

        .cropper-container {
            max-height: 400px;
        }

        .file-input-hidden {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .upload-icon {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 15px;
        }

        .final-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
        }

        @media (max-width: 768px) {
            .profileMain .left-panel {
                width: 100% !important;
                margin-left: auto!important;
                margin-right: auto!important;
            }
        }

        @media (max-width: 768px) {
            .profile {
                padding-top: 15px;
                padding-bottom: 0px!important;
            }
        }
        @media (max-width: 426px) {
            .search-bar {
                display: none;
            }
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <script>
        let cropper = null;
        let originalFile = null;

        // DOM Elements
        const dragDropArea = document.getElementById('dragDropArea');
        const fileInput = document.getElementById('profileImage');
        const uploadContent = document.getElementById('uploadContent');
        const previewContainer = document.getElementById('previewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const cropControls = document.getElementById('cropControls');
        const finalPreviewContainer = document.getElementById('finalPreviewContainer');
        const finalPreview = document.getElementById('finalPreview');
        const croppedImageData = document.getElementById('croppedImageData');

        // Event Listeners
        dragDropArea.addEventListener('click', () => fileInput.click());
        dragDropArea.addEventListener('dragover', handleDragOver);
        dragDropArea.addEventListener('drop', handleDrop);
        dragDropArea.addEventListener('dragleave', handleDragLeave);
        fileInput.addEventListener('change', handleFileSelect);

        document.getElementById('resetCrop').addEventListener('click', () => cropper.reset());
        document.getElementById('rotateLeft').addEventListener('click', () => cropper.rotate(-90));
        document.getElementById('rotateRight').addEventListener('click', () => cropper.rotate(90));
        document.getElementById('cropImage').addEventListener('click', handleCropImage);
        document.getElementById('changeImage').addEventListener('click', resetUpload);
        document.getElementById('saveImage').addEventListener('click', handleSaveImage);

        // Drag and Drop Functions
        function handleDragOver(e) {
            e.preventDefault();
            dragDropArea.classList.add('dragover');
        }

        function handleDragLeave(e) {
            e.preventDefault();
            dragDropArea.classList.remove('dragover');
        }

        function handleDrop(e) {
            e.preventDefault();
            dragDropArea.classList.remove('dragover');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFile(files[0]);
            }
        }

        function handleFileSelect(e) {
            const file = e.target.files[0];
            if (file) {
                handleFile(file);
            }
        }

        function handleFile(file) {
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please select an image file.');
                return;
            }

            // Validate file size (5MB max)
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB.');
                return;
            }

            originalFile = file;

            // Create FileReader to display image
            const reader = new FileReader();
            reader.onload = function(e) {
                displayImageForCropping(e.target.result);
            };
            reader.readAsDataURL(file);
        }

        function displayImageForCropping(imageSrc) {
            // Hide upload area and show preview
            uploadContent.style.display = 'none';
            previewContainer.style.display = 'block';
            cropControls.style.display = 'block';
            finalPreviewContainer.style.display = 'none';

            // Set image source
            imagePreview.src = imageSrc;

            // Initialize cropper
            if (cropper) {
                cropper.destroy();
            }

            cropper = new Cropper(imagePreview, {
                aspectRatio: 1, // Square crop for profile image
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 0.8,
                restore: false,
                guides: true,
                center: true,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
            });
        }

        function handleCropImage() {
            if (!cropper) return;

            // Get cropped canvas
            const canvas = cropper.getCroppedCanvas({
                width: 300,
                height: 300,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            // Convert to blob and display final preview
            canvas.toBlob((blob) => {
                const url = URL.createObjectURL(blob);
                finalPreview.src = url;

                // Store cropped image data
                croppedImageData.value = canvas.toDataURL('image/jpeg', 0.8);

                // Show final preview and hide cropping interface
                previewContainer.style.display = 'none';
                cropControls.style.display = 'none';
                finalPreviewContainer.style.display = 'block';

            }, 'image/jpeg', 0.8);
        }

        function resetUpload() {
            // Reset everything
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }

            fileInput.value = '';
            croppedImageData.value = '';
            originalFile = null;

            // Show upload area
            uploadContent.style.display = 'block';
            previewContainer.style.display = 'none';
            cropControls.style.display = 'none';
            finalPreviewContainer.style.display = 'none';
        }

        function handleSaveImage() {
            if (!croppedImageData.value) {
                alert('Please select and crop an image first.');
                return;
            }

            // Here you can submit the form or handle the cropped image data
            // The cropped image data is available in croppedImageData.value as base64

            console.log('Cropped image data:', croppedImageData.value);
            alert('Image saved successfully! Check console for base64 data.');

            // You can now submit this data to your server
            // Example: Send via AJAX or submit the form
        }

        // Reset when modal is closed
        document.getElementById('editContactModal').addEventListener('hidden.bs.modal', function () {
            resetUpload();
        });
        // toggle institute name on education degree change
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

    </script>


{{--    form validation start--}}
    <script>
        // ============================================
        // COMMON VALIDATION FUNCTIONS
        // ============================================

        /**
         * Validate required fields
         */
        function validateRequired(value, fieldName) {
            if (!value || value.trim() === '') {
                toastr.error(`${fieldName} is required`);
                return false;
            }
            return true;
        }

        /**
         * Validate email format
         */
        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                toastr.error('Please enter a valid email address');
                return false;
            }
            return true;
        }

        /**
         * Validate Bangladeshi phone number
         * Must start with 0 and be exactly 11 digits
         */
        function validateBDPhone(phone) {
            const phoneRegex = /^0\d{10}$/;
            if (!phoneRegex.test(phone)) {
                toastr.error('Invalid Phone Number.');
                return false;
            }
            return true;
        }

        /**
         * Get field label text or name
         */
        function getFieldLabel($field) {
            const $label = $('label[for="' + $field.attr('id') + '"]');
            return $label.length ? $label.text().replace('*', '').trim() : $field.attr('name');
        }

        // ============================================
        // EMPLOYEE PROFILE UPDATE FORM VALIDATION
        // ============================================

        function validateEmployeeProfileForm() {
            let isValid = true;
            const $form = $('#employeeUpdateProfile');

            // Validate all required fields
            $form.find('[required]').each(function() {
                const $field = $(this);
                const value = $field.val();
                const fieldLabel = getFieldLabel($field);

                if (!validateRequired(value, fieldLabel)) {
                    isValid = false;
                    $field.addClass('is-invalid');
                    return false; // Break loop on first error
                } else {
                    $field.removeClass('is-invalid');
                }
            });

            if (!isValid) return false;

            // Validate email
            const email = $form.find('input[name="email"]').val();
            if (email && !validateEmail(email)) {
                $form.find('input[name="email"]').addClass('is-invalid');
                return false;
            } else {
                $form.find('input[name="email"]').removeClass('is-invalid');
            }

            // Validate phone
            const phone = $form.find('input[name="mobile"]').val();
            if (phone && !validateBDPhone(phone)) {
                $form.find('input[name="mobile"]').addClass('is-invalid');
                return false;
            } else {
                $form.find('input[name="mobile"]').removeClass('is-invalid');
            }

            return true;
        }


        // ============================================
        // WORK EXPERIENCE FORM VALIDATION LOGIC
        // ============================================
        function validateWorkExperienceForm($form) {
            let valid = true;

            // title required
            const title = $form.find('input[name="title"]').val();
            if (!title.trim()) {
                toastr.error('Position title is required');
                valid = false;
            }

            // start date required
            const startDate = $form.find('input[name="start_date"]').val();
            if (!startDate) {
                toastr.error('Start date is required');
                valid = false;
            }

            // end date check
            const isCurrent = $form.find('input[name="is_working_currently"]').is(':checked');
            const endDate = $form.find('input[name="end_date"]').val();

            if (!isCurrent && !endDate) {
                toastr.error('End date is required if not currently working');
                valid = false;
            }

            if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
                toastr.error('End date cannot be earlier than start date');
                valid = false;
            }

            return valid;
        }

        // ===================== COMMON VALIDATION FUNCTION =====================
        function validateEducationForm($form) {
            let valid = true;

            const degree = $form.find('[name="education_degree_name_id"]').val();
            const institute = $form.find('[name="institute_name"]').val()?.trim();
            const field = $form.find('[name="field_of_study"]').val()?.trim();
            const year = $form.find('[name="passing_year"]').val()?.trim();
            const cgpa = $form.find('[name="cgpa"]').val()?.trim();

            // 1️⃣ Education degree
            if (!degree) {
                toastr.error('Education program is required');
                valid = false;
            }

            // 2️⃣ Institute name - required, no digits allowed
            if (!institute) {
                toastr.error('Institute name is required');
                valid = false;
            } else if (/\d/.test(institute)) {
                toastr.error('Institute name cannot contain numbers');
                valid = false;
            }

            // 3️⃣ Field of study - required, no digits allowed
            if (!field) {
                toastr.error('Field of study is required');
                valid = false;
            } else if (/\d/.test(field)) {
                toastr.error('Field of study cannot contain numbers');
                valid = false;
            }

            // 4️⃣ Passing year - required, must be 4-digit number
            if (!year) {
                toastr.error('Passing year is required');
                valid = false;
            } else if (!/^\d{4}$/.test(year)) {
                toastr.error('Passing year must be a valid year (e.g., 2022)');
                valid = false;
            }

            // 5️⃣ CGPA - required, numeric, allows decimal
            if (!cgpa) {
                toastr.error('CGPA is required');
                valid = false;
            } else if (!/^\d+(\.\d+)?$/.test(cgpa)) {
                toastr.error('CGPA must be a number (e.g., 3.75)');
                valid = false;
            }

            return valid;
        }


        // ============================================
        // FORM SUBMIT HANDLERS
        // ============================================

        $(document).ready(function() {

            // Employee Profile Update Form
            $('#employeeUpdateProfile').on('submit', function(e) {
                e.preventDefault();

                if (validateEmployeeProfileForm()) {
                    // All validations passed - submit the form
                    $(this).off('submit').submit();
                }
            });

            // ===================================================
            // WORK EXPERIENCE FORM VALIDATION (STATIC + DYNAMIC)
            // ===================================================

            // Handle static create form
            $('#createEmployeeWorkExperienceForm').on('submit', function(e) {
                e.preventDefault();
                const $form = $(this);
                if (validateWorkExperienceForm($form)) {
                    this.submit();
                }
            });

            // Handle dynamic edit form (when modal is shown)
            $(document).on('shown.bs.modal', '#editWorkExperienceModal', function() {
                const $form = $(this).find('form#editEmployeeWorkExperienceForm');

                // Unbind any duplicate handler first (in case modal is opened multiple times)
                $form.off('submit.validate');

                // Then reattach
                $form.on('submit.validate', function(e) {
                    e.preventDefault();
                    if (validateWorkExperienceForm($form)) {
                        this.submit();
                    }
                });
            });

           // documents
// Helper: allowed extensions
            const allowedExt = ['pdf','jpg','jpeg','png'];

            // Validation function that runs on submit only
            function validateDocumentForm($form) {
                // trim helper
                const val = (selector) => ($form.find(selector).val() || '').toString().trim();

                const title = val('[name="title"]');
                const fileInput = $form.find('[name="file"]');
                const fileVal = fileInput.val();

                // clear previous invalid states
                $form.find('.is-invalid').removeClass('is-invalid');

                // title required
                if (!title) {
                    toastr.error('Please select or enter a document title');
                    // try to mark field (select or input)
                    const $titleField = $form.find('[name="title"]').first();
                    if ($titleField.length) $titleField.addClass('is-invalid');
                    return false;
                }

                // file required
                if (!fileVal) {
                    toastr.error('Please upload a file');
                    fileInput.addClass('is-invalid');
                    return false;
                }

                // extension check
                // fileVal could be C:\fakepath\file.pdf or just file.pdf
                const fileName = fileVal.split('\\').pop().split('/').pop();
                const ext = (fileName.split('.').pop() || '').toLowerCase();
                if (allowedExt.indexOf(ext) === -1) {
                    toastr.error('Only PDF, JPG, JPEG or PNG files are allowed');
                    fileInput.addClass('is-invalid');
                    return false;
                }

                // All good
                return true;
            }

            // ===================== ADD FORM VALIDATION (STATIC) =====================
            $('#addEducationForm').on('submit', function(e) {
                e.preventDefault();
                const $form = $(this);
                if (validateEducationForm($form)) {
                    this.submit();
                }
            });

            // ===================== EDIT FORM VALIDATION (DYNAMIC MODAL) =====================
            $(document).on('shown.bs.modal', '#editEducationModal', function() {
                const $form = $(this).find('form#editEducationForm');

                // remove old handler first to prevent duplicates
                $form.off('submit.validateEducation');

                $form.on('submit.validateEducation', function(e) {
                    e.preventDefault();
                    if (validateEducationForm($form)) {
                        this.submit();
                    }
                });
            });

            // documents
// Delegated handler for both create + edit forms, runs only on submit
            $(document).on('submit', '#createEmployeeDocuments, #editEmployeeDocuments', function (e) {
                e.preventDefault(); // always prevent and decide manually
                const $form = $(this);

                // If we are in the middle of programmatic submit, allow native submit to pass through
                if ($form.data('submitting')) {
                    // cleanup the flag immediately (optional)
                    $form.removeData('submitting');
                    return true; // allow native submit to continue
                }

                // Run validations (only when actual user submits)
                if (!validateDocumentForm($form)) {
                    // invalid -> stop submission (we already prevented default)
                    return false;
                }

                // Valid -> set a flag and submit natively (so browser performs file upload/normal submit)
                $form.data('submitting', true);
                $form[0].submit(); // native submit (will trigger this handler again, but flag will let it pass)
            });

            // Remove invalid state dynamically
            $(document).on('input change', 'input, select, textarea', function () {
                $(this).removeClass('is-invalid');
            });

            // Remove validation error class on input
            // $('input, select, textarea').on('input change', function() {
            //     $(this).removeClass('is-invalid');
            // });

        });
    </script>
{{--    form validation end--}}


@endpush
