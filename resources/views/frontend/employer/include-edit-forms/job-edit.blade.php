<form action="{{ route('employer.job-tasks.update', $jobTask->id) }}" method="post" id="jobEditFormAppend" enctype="multipart/form-data">
    @csrf
    @method('put')
    <input type="hidden" name="req" value="edit">
    <!-- STEP 1 -->
    <div class="stepOne">
        <!-- Modal Header -->

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-2">
                <img src="http://127.0.0.1:8000/frontend/employer/images/employersHome/leftarrow.png" alt="" class="me-2" style="cursor: default;">
                <h5 class="mb-0 fw-semibold">{{ trans('common.edit') }} {{ trans('employer.post_job') }}</h5>
            </div>
            <button class="btn btn-sm btn-close" data-bs-dismiss="modal" type="button"></button>
        </div>

        <!-- Job Title -->
        <div class="mb-4">
            <label class="form-label fw-semibold">{{ trans('employer.job_title') }}</label>
            <input type="text" class="form-control" value="{{ $jobTask->job_title ?? '' }}" required name="job_title" placeholder="{{ trans('employer.senior_officer_corporate_banking') }}">
        </div>

        <!-- Job Type -->
        <div class="mb-4">
            <label class="form-label fw-semibold mb-2">{{ trans('employer.job_type') }}</label>
            <div class="pill-group" role="group" aria-label="Job type">
                @foreach($jobTypes as $jobTypesKey => $jobType)
                    <input type="radio" class="btn-check" name="job_type_id" {{ $jobTask->job_type_id == $jobType->id ? 'checked' : '' }} id="EDITjobType{{ $jobTypesKey }}" value="{{ $jobType->id }}" autocomplete="off" {{ $jobTypesKey == 0 ? 'checked' : '' }}>
                    <label class="btn-pill" for="EDITjobType{{ $jobTypesKey }}">{{ $jobType->name ?? 'jt' }}</label>
                @endforeach
            </div>
        </div>

        <!-- Job Location -->
        <div class="mb-4">
            <label class="form-label fw-semibold mb-2">{{ trans('employer.job_location') }}</label>
            <div class="pill-group" role="group" aria-label="Job location">
                @foreach($jobLocations as $jobLocationKey => $jobLocation)
                    <input type="radio" class="btn-check" name="job_location_type_id" {{ $jobTask->job_location_type_id == $jobLocation->id ? 'checked' : '' }} id="editJobLocation{{ $jobLocationKey }}" value="{{ $jobLocation->id }}" {{ $jobLocationKey == 0 ? 'checked' : '' }} autocomplete="off">
                    <label class="btn-pill" for="editJobLocation{{ $jobLocationKey }}">{{ $jobLocation->name ?? 'jl' }}</label>
                @endforeach
            </div>
        </div>

        <!-- Footer Buttons -->
        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-outline-dark px-4 py-2 rounded-3" data-bs-dismiss="modal">{{ trans('common.cancel') }}</button>
            <button id="continueToStep2Edit" data-continue-btn-parent-form="jobEditFormAppend" type="button" class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-3">{{ trans('common.next') }}</button>
        </div>
    </div>

    <!-- STEP 2 -->
    <div class="jobModalForPost d-none stepTwo" style="background-color: #f2f2f4;">
        <!-- Container and header -->
        <div class="container-fluid py-3 border-bottom mb-4 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2" id="backToStepOne" style="cursor:pointer">
                    <img src="{{ asset('/') }}frontend/employee/images/authentication images/leftArrow.png" alt="Back" style="width:20px; height:20px;">
                    <h5 class="fw-bold mb-0">{{ trans('common.edit') }} {{ trans('employer.post_job') }}</h5>
                </div>
                <!-- Button triggers modal -->
{{--                                                <button type="button" class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-3 show-review-btn" data-modal-id="editJobModal" --}}{{--data-bs-toggle="modal" data-bs-target="#jobDetailsModal"--}}{{-->--}}
{{--                                                    Review & Post--}}
{{--                                                </button>--}}
{{--                <button type="submit" class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-3" --}}{{--data-bs-toggle="modal" data-bs-target="#jobDetailsModal"--}}{{-->--}}
{{--                    Update Job--}}
{{--                </button>--}}
                <button class="btn btn-sm btn-close" data-bs-dismiss="modal" type="button"></button>
            </div>
        </div>
        <!-- Your provided step 2 content starts here -->
        <div style="background-color: #f2f2f4;" class="jobModalForPost">
            <!-- Container and header -->
            <!-- Main Job Info Card -->
            <div class="container px-0 border-bottom">
                <div style="border-radius: 0px" class="bg-white p-4 shadow-sm">
                    <div class="d-flex justify-content-between flex-wrap gap-3">
                        <div>
                            <h5 class="fw-semibold mb-2"><span id="formJobTitleEdit">IT Support, Corporate Banking</span></h5>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark"><span id="jobJobTypeEdit">Full Time</span></span>
                                <span class="badge bg-light text-dark"><span id="jobjobLocationTypeEdit">Hybrid</span></span>
                            </div>
                        </div>
                        <div>
                            <a href="#" class="text-decoration-none text-muted return-to-first-part"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Edit pencil.png" alt=""> {{ trans('common.edit') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Experience Card -->
            <div class="container px-0 border-bottom">
                <div style="border-radius: 0px" class="bg-white p-4 shadow-sm">
                    <h6 class="fw-semibold mb-3">{{ trans('employer.required_years_of_experience') }}</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <input type="radio" class="btn-check" name="required_experience" id="edit-exp-any" value="Any" autocomplete="off" {{ $jobTask->required_experience == 'Any' ? 'checked' : '' }} >
                        <label class="btn btn-outline-warning" style="color: black!important;" for="edit-exp-any">{{ trans('employer.any') }}</label>

                        <input type="radio" class="btn-check" name="required_experience" id="edit-exp-1to3" value="1–3 yrs" autocomplete="off" {{ $jobTask->required_experience == '1–3 yrs' ? 'checked' : '' }} >
                        <label class="btn btn-outline-warning" style="color: black!important;" for="edit-exp-1to3">1–3 {{ trans('employer.yrs') }}</label>

                        <input type="radio" class="btn-check" name="required_experience" id="edit-exp-0" value="0" autocomplete="off" {{ $jobTask->required_experience == '0' ? 'checked' : '' }} >
                        <label class="btn btn-outline-warning" style="color: black!important;" for="edit-exp-0">{{ trans('employer.na') }}</label>

                        <input type="radio" class="btn-check" name="required_experience" id="custom" value="custom" {{ $jobTask->is_custom_exp == 1 ? 'checked' : '' }} autocomplete="off">
                        <label id="editshowCustomExperienceField" style="color: black!important;" class="btn btn-outline-warning" for="custom">{{ trans('common.custom') }}</label>

                        <span id="editcustomExperienceField" style="display: none">
                                                            <input type="text" style="width: 60px; background-color: #f8ffbe; color: black!important;" class="btn btn-outline-primary " value="{{ $jobTask->is_custom_exp == 1 ? explode('-', $jobTask->required_experience)[0] : 0 }}" name="exp_range_start"> {{ trans('employer.to') }} <input type="text" style="width: 60px; background-color: #f8ffbe; color: black!important;" class="btn btn-outline-primary " value="{{ $jobTask->is_custom_exp == 1 ?explode('-', $jobTask->required_experience)[1] : 1 }}" name="exp_range_end"> {{ trans('employer.years') }}
                                                        </span>
                    </div>
                </div>
            </div>
            <!-- Industry -->
            <div class="container px-0 border-bottom">
                <div style="border-radius: 0px" class="bg-white p-4 shadow-sm">
                    <h6 class="fw-semibold mb-3">{{ trans('common.industry') }}</h6>
                    <select name="industry_id" id="industryId" class="form-control select2 industryId"  >
                        @foreach($industries as $industryKey => $industry)
                            <option value="{{ $industry->id }}" {{ $jobTask->industry_id == $industry->id ? 'selected' : '' }}>{{ $industry->name ?? 'un' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- University Preference -->
            <div class="container px-0 border-bottom">
                <div style="border-radius: 0px" class="bg-white p-4 shadow-sm">
                    <h6 class="fw-semibold mb-3">{{ trans('employer.university_preference') }}</h6>
                    {{--                                    <input type="text" class="form-control mb-3" name="" placeholder="Search universities">--}}
                    <select name="university_preference[]" id="select2-div" class=" select2"  multiple="multiple">
                        @foreach($universityNames as $universityNameKey => $universityName)
                            <option value="{{ $universityName->id }}" @if($jobTask->employerPrefferableUniversityNames) @foreach($jobTask->employerPrefferableUniversityNames as $employerPrefferableUniversityName) {{ $universityName->id == $employerPrefferableUniversityName->id ? 'selected' : '' }} @endforeach @endif>{{ $universityName->name ?? 'un' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- Field of Study -->
            <div class="container px-0 border-bottom">
                <div style="border-radius: 0px" class="bg-white p-4 shadow-sm">
                    <h6 class="fw-semibold mb-3">{{ trans('employer.field_of_study') }}</h6>
                    {{--                                    <input type="text" class="form-control mb-3" placeholder="Search field of study">--}}
                    <select name="field_of_study_preference[]" id="" class=" select2" multiple="multiple">
                        @foreach($fieldOfStudies as $fieldOfStudyKey => $fieldOfStudy)
                            <option value="{{ $fieldOfStudy->id }}"  @if($jobTask->employerPrefferableFieldOfStudyNames) @foreach($jobTask->employerPrefferableFieldOfStudyNames as $employerPrefferableFieldOfStudyName) {{ $fieldOfStudy->id == $employerPrefferableFieldOfStudyName->id ? 'selected' : '' }} @endforeach @endif >{{ $fieldOfStudy->field_name ?? 'un' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- CGPA Preference -->
            <div class="container px-0 border-bottom">
                <div style="border-radius: 0px" class="bg-white p-4 shadow-sm">
                    <h6 class="fw-semibold mb-3">{{ trans('employer.cgpa_preference') }}</h6>
                    <input type="number" min="0" name="cgpa" value="{{ $jobTask->cgpa ?? 0 }}" class="form-control" placeholder="Min 3.50">
                </div>
            </div>
            <!-- Gender Preference -->
            <div class="container px-0 border-bottom">
                <div style="border-radius: 0px" class="bg-white p-4 shadow-sm">
                    <h6 class="fw-semibold mb-3">{{ trans('employer.gender_preference') }}</h6>
                    <select name="gender" id="" class="form-control select2">
                        <option value="" disabled selected>{{ trans('employer.select_a_gender') }}</option>
                        <option value="male" {{ $jobTask->gender == 'male' ? 'selected' : '' }}>{{ trans('employer.male') }}</option>
                        <option value="female" {{ $jobTask->gender == 'female' ? 'selected' : '' }}>{{ trans('employer.female') }}</option>
                        <option value="all" {{ $jobTask->gender == 'all' ? 'selected' : '' }}>{{ trans('employer.all') }}</option>
                    </select>
                </div>
            </div>
            <!-- Salary Section -->
            <div class="container px-0 border-bottom">
                <div style="border-radius: 0px" class="bg-white p-4 shadow-sm">
                    <h6 class="fw-semibold mb-3">{{ trans('employer.salary') }}</h6>
                    <ul class="nav nav-tabs mb-3" id="salaryTab" role="tablist">
                        <li class="nav-item"><a class="nav-link {{ $jobTask->job_pref_salary_payment_type == 'monthly' ? 'active' : '' }} salary-type" data-value="monthly" data-bs-toggle="tab" href="#">{{ trans('employer.monthly') }}</a></li>
                        <li class="nav-item"><a class="nav-link salary-type {{ $jobTask->job_pref_salary_payment_type == 'hourly' ? 'active' : '' }}" data-value="hourly" data-bs-toggle="tab" href="#">{{ trans('employer.hourly') }}</a></li>
                        <li class="nav-item"><a class="nav-link salary-type {{ $jobTask->job_pref_salary_payment_type == 'yearly' ? 'active' : '' }}" data-value="yearly" data-bs-toggle="tab" href="#">{{ trans('employer.yearly') }}</a></li>
                        <li class="nav-item"><a class="nav-link salary-type {{ $jobTask->job_pref_salary_payment_type == 'fixed' ? 'active' : '' }}" data-value="fixed" data-bs-toggle="tab" href="#">{{ trans('employer.fixed_amount') }}</a></li>
                    </ul>
                    <input type="hidden" name="job_pref_salary_payment_type" class="job_pref_salary_payment_type" value="monthly">
                    <input type="number" min="0" name="salary_amount" value="{{ $jobTask->salary_amount ?? 0 }}" class="form-control mb-2" placeholder="{{ trans('employer.bdt_50000') }}">
                </div>
            </div>
            <!-- Job Description -->
            <div class="container px-0 border-bottom">
                <div style="border-radius: 0px" class="bg-white p-4 shadow-sm">
                    <h6 class="fw-semibold mb-3">{{ trans('employer.job_description_key_responsibilities') }}</h6>
                    <textarea class="form-control summernote" id="summernote2" name="description" rows="15" placeholder="{{ trans('employer.tell_more_about_job') }}">{!! $jobTask->description ?? '' !!}</textarea>
                </div>
            </div>
            <!-- Application Deadline -->
            <div class="container px-0 border-bottom">
                <div style="border-radius: 0px" class="bg-white p-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0">{{ trans('employer.application_deadline') }}</h6>
                    </div>
                    <div>
                        <div class="input-group rounded-3 border border-secondary-subtle">
                            <input type="date" name="deadline" min="{{ date('Y-m-d') }}" class="form-control" value="{{ $jobTask->deadline ?? '' }}" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- Skills Section -->
            <div class="container px-0 border-bottom">
                <div style="border-radius: 0px" class="bg-white p-4 shadow-sm">
                    <h6 class="fw-semibold mb-3">{{ trans('employer.skill_requirements') }}</h6>

                    <!-- Search Input -->
                    <div class="mb-3">
                        <input type="text" class="form-control skill-search-input" data-form="edit" placeholder="Search skills...">
                    </div>

                    <!-- Selected Skills Display -->
                    <div class="mb-3 selected-skills-container d-flex flex-wrap gap-2" data-form="edit">
                        @foreach($jobTask->jobRequiredskills as $skill)
                            <div class="selected-skill-tag" data-id="{{ $skill->id }}">
                                <input type="hidden" name="required_skills[]" value="{{ $skill->id }}">
                                <span>{{ $skill->skill_name }}</span>
                                <span class="remove-skill">&times;</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Search Results -->
                    <div class="skill-search-results d-none mb-3" data-form="edit">
                        <div class="skill-search-list d-flex flex-wrap gap-2"></div>
                    </div>

                    <!-- Category Skills -->
                    <div class="skill-category-box" data-form="edit">
                        @php $requiredSkills = $jobTask->jobRequiredskills->pluck('id')->toArray(); @endphp
                        <nav>
                            <div class="nav nav-pills" role="tablist">
                                @foreach($skillCategories as $skillCategoryKey => $skillCategory)
                                    <button class="nav-link {{ $skillCategoryKey == 0 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#editSkillCat{{ $skillCategoryKey }}" type="button">{{ $skillCategory->category_name }}</button>
                                @endforeach
                            </div>
                        </nav>
                        <div class="tab-content mt-3">
                            @foreach($skillCategories as $x => $singleSkillCategory)
                                <div class="tab-pane fade {{ $x == 0 ? 'show active' : '' }}" id="editSkillCat{{ $x }}">
                                    @foreach($singleSkillCategory->publishedSkills as $skill)
                                        <label class="btn border skill-btn m-1 {{ in_array($skill->id, $requiredSkills) ? 'selected-skill' : '' }}" data-id="{{ $skill->id }}" data-name="{{ $skill->skill_name }}">{{ $skill->skill_name }}</label>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

{{--            <div class="container px-0 border-bottom">--}}
{{--                <div style="border-radius: 0px" class="bg-white p-4 shadow-sm">--}}
{{--                    <h6 class="fw-semibold mb-3">{{ trans('employer.skill_requirements') }}</h6>--}}
{{--                    <div class="<!--d-flex flex-wrap gap-2-->">--}}

{{--                        <nav>--}}
{{--                            <div class="nav nav-pills" id="nav-tab" role="tablist">--}}
{{--                                @foreach($skillCategories as $skillCategoryKey =>$skillCategory)--}}
{{--                                    <button class="nav-link {{ $skillCategoryKey == 0 ? 'active' : '' }}" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#editskillCategory{{ $skillCategoryKey }}" type="button" role="tab" aria-controls="nav-home" aria-selected="true">{{ $skillCategory->category_name }}</button>--}}
{{--                                @endforeach--}}

{{--                                --}}{{--                                                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Skill </button>--}}
{{--                            </div>--}}
{{--                        </nav>--}}
{{--                        <div class="tab-content mt-3" id="nav-tabContent">--}}
{{--                            @php--}}
{{--                                $requiredSkills = $jobTask->jobRequiredskills->pluck('id')->toArray();--}}
{{--                            @endphp--}}
{{--                            @foreach($skillCategories as $x => $singleSkillCategory)--}}
{{--                                <div class="tab-pane fade {{ $x == 0 ? 'show active' : '' }}" id="editskillCategory{{$x}}" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">--}}
{{--                                    @foreach($singleSkillCategory->publishedSkills as $skillKey => $skill)--}}
{{--                                    @php--}}
{{--                                        $selected = false;--}}
{{--                                        if (in_array($skill->id, $requiredSkills))--}}
{{--                                            {--}}
{{--                                                $selected = true;--}}
{{--                                            }--}}
{{--                                    @endphp--}}
{{--                                        <input type="checkbox" class="btn-check" name="required_skills[]" {{ $selected ? 'checked' : '' }}  id="editskill{{ $skill->id }}" value="{{ $skill->id }}" >--}}
{{--                                        <label class="btn border select-skill p-2 {{ $selected ? 'selected-skill' : '' }}"  data-input-id="{{ $singleSkillCategory->slug }}-{{ $skillKey }}" for="editskill{{ $skill->id }}">{{ $skill->skill_name ?? 'sn' }}</label>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <!-- Status -->
            <div class="container px-0 border-bottom">
                <div style="border-radius: 0px" class="bg-white p-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0">Job Status</h6>
                    </div>
                    <div>
                        <div class="input-group rounded-3 border border-secondary-subtle">
                            <select name="status" class="form-control select2" id="">
                                <option value="on" {{ $jobTask->status == 1 ? 'selected' : '' }}>Stay Opened</option>
                                <option value="" {{ $jobTask->status == 0 ? 'selected' : '' }}>Close Job</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Submit Form -->
            <div class="container px-0 ">
                <div class="bg-white p-4 text-end shadow-sm" style="border-radius: 0px">
                    <!-- Button triggers modal -->
                    <button type="button" class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-3 show-review-btn" data-modal-id="editJobModal" {{--data-bs-toggle="modal" data-bs-target="#jobDetailsModal"--}}>
                        {{ trans('employer.review_and_post') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
