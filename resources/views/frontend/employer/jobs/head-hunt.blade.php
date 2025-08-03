@extends('frontend.employer.master')

@section('title', 'Head Hunt')

@section('body')

    <div class="ps-3 py-2 d-block d-md-none">
        <img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt="">
    </div>
    <!-- head hunt -->
    <div class="headHunt p-4">
        <h2 class="mb-1 fw-bold">Head Hunt</h2>
        <p class="text-muted mb-3">Browse talents & find the perfect match for your company.</p>

        <div class="headHUntFielter">
            <form action="">
                <!-- fielter options -->
                <div class="d-flex flex-wrap gap-2 mb-3 filter-dropdowns ">

                    <span style="width: 150px">
                        <select name="job_type[]" id="" class="select2" multiple>
                            <option value="" selected disabled>Select Job Type</option>
                            @foreach($jobTypes as $jobType)
                                <option value="{{ $jobType->slug }}">{{ $jobType->name }}</option>
                            @endforeach
                        </select>
                    </span>
                    <span style="width: 150px">
                    <select name="job_location[]" id="" class="select2" multiple>
                        <option value="" selected disabled>Select Job Location</option>
                        @foreach($jobLocations as $jobLocation)
                            <option value="{{ $jobLocation->slug }}">{{ $jobLocation->name }}</option>
                        @endforeach
                    </select>
                </span>
                    <span style="width: 150px">
                    <select name="university_name[]" id="" class="select2" multiple>
                        <option value="" selected disabled>Select University</option>
                        @foreach($universityNames as $universityName)
                            <option value="{{ $universityName->slug }}">{{ $universityName->name }}</option>
                        @endforeach
                    </select>
                </span>
                    <span style="width: 150px">
                    <select name="industry[]" id="" class="select2" multiple>
                        <option value="" selected disabled>Select Industry</option>
                        @foreach($industries as $industry)
                            <option value="{{ $industry->slug }}">{{ $industry->name }}</option>
                        @endforeach
                    </select>
                </span>
                    <span style="width: 150px">
                    <select name="field_of_study[]" id="" class="select2" multiple>
                        <option value="" selected disabled>Select Field Of Study</option>
                        @foreach($fieldOfStudies as $fieldOfStudy)
                            <option value="{{ $fieldOfStudy->slug }}">{{ $fieldOfStudy->field_name }}</option>
                        @endforeach
                    </select>
                </span>
                    <span style="width: 150px">
                    <select name="skills[]" id="" class="select2" multiple>
                        <option value="" selected disabled>Select Skill Category</option>
                        @foreach($skillCategories as $skillCategory)
                            <optgroup label="{{ $skillCategory->category_name }}">
                                @foreach($skillCategory->skills as $skill)
                                    <option value="{{ $skill->slug }}">{{ $skill->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </span>
                </div>

                <div class="input-group mb-4" style="max-width: 350px;">
                    <input type="text" class="form-control" name="search_text" placeholder="Search talents" aria-label="Search talents" />
                    <button class="btn btn-light border" type="submit">
                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/search 1.png" alt="Search" style="width: 16px; height: 16px;" />
                    </button>
                </div>
            </form>
        </div>

        <div class="d-flex justify-content-between mb-3" style="font-size: 14px; cursor: pointer;">
            <p class="text-muted">Showing {{ count($employees) ?? 0 }} results.</p>
{{--            <div class="dropdown">--}}
{{--                <a class="text-muted d-flex align-items-center text-decoration-none dropdown-toggle" href="#" role="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 14px;">--}}
{{--                    Most relevant--}}
{{--                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/chevron-down 1.png" alt="Sort" class="ms-2" style="width: 12px; height: 12px;" />--}}
{{--                </a>--}}
{{--                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sortDropdown">--}}
{{--                    <li><a class="dropdown-item" href="#">Most relevant</a></li>--}}
{{--                    <li><a class="dropdown-item" href="#">Most recent</a></li>--}}
{{--                    <li><a class="dropdown-item" href="#">Highest CGPA</a></li>--}}
{{--                    <li><a class="dropdown-item" href="#">Most experience</a></li>--}}
{{--                </ul>--}}
{{--            </div>--}}
        </div>


        <div class="row row-cols-1 row-cols-md-3 g-3 headhuntPP-card">
            <!-- Candidate Card Template -->
            @foreach($employees as $employee)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset($employee->profile_image ?? '/frontend/employer/images/employersHome/headhunt-pp1.png') }}" alt="Mohammed Pranto" class="rounded-circle me-3" style="width: 56px; height: 56px; object-fit: cover;" />
{{--                                <span class="badge   ms-auto fullTime d-flex align-items-center"><img src="{{ asset('/') }}frontend/employer/images/employersHome/fulltime-dot.png" alt="" class="me-1">Full-time</span>--}}
                            </div>
                            <h5 class="card-title fw-bold mb-1">{{ $employee->name ?? 'Employee Name' }}</h5>
                            <p class="card-text mb-2" style="font-size: 14px;">
                                {{ $employee->profile_title ?? 'Employee Profile Title' }}
                            </p>
                            <p class="text-muted mb-1" style="font-size: 13px;">
                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="Location" style="width: 20px;" />
                                {!! $employee->address ?? 'Employee Address' !!}
                            </p>
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <span class="badge bg-light text-dark">{{ $employee?->employeeWorkExperiences[0]?->duration ?? 0 }} yrs</span>
                                <span class="badge bg-light text-dark">{{ $employee?->employeeEducations[0]?->cgpa ?? 0 }} CGPA</span>
{{--                                <span class="badge bg-light text-dark">Developer</span>--}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


{{--            <div class="col">--}}
{{--                <div class="card h-100 shadow-sm">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="d-flex align-items-center mb-3">--}}
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/headhunt-pp2.png" alt="Mohammed Pranto" class="rounded-circle me-3" style="width: 56px; height: 56px; object-fit: cover;" />--}}
{{--                            <span class="badge   ms-auto partTime d-flex align-items-center"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Part-time-dot.png" alt="" class="me-1">Full-time</span>--}}
{{--                        </div>--}}
{{--                        <h5 class="card-title fw-bold mb-1">Mohammed Pranto</h5>--}}
{{--                        <p class="card-text mb-2" style="font-size: 14px;">--}}
{{--                            Mobile App Developer, Flutter Developer,<br />Instructor & Mentor--}}
{{--                        </p>--}}
{{--                        <p class="text-muted mb-1" style="font-size: 13px;">--}}
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="Location" style="width: 20px;" /> Uttara, Dhaka--}}
{{--                        </p>--}}
{{--                        <div class="d-flex flex-wrap gap-2 mt-3">--}}
{{--                            <span class="badge bg-light text-dark">3+ yrs</span>--}}
{{--                            <span class="badge bg-light text-dark">3.50 CGPA</span>--}}
{{--                            <span class="badge bg-light text-dark">Developer</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col">--}}
{{--                <div class="card h-100 shadow-sm">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="d-flex align-items-center mb-3">--}}
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/headhunt-pp3.png" alt="Mohammed Pranto" class="rounded-circle me-3" style="width: 56px; height: 56px; object-fit: cover;" />--}}
{{--                            <span class="badge   ms-auto Internship d-flex align-items-center"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Internship-dot.png" alt="" class="me-1">Full-time</span>--}}
{{--                        </div>--}}
{{--                        <h5 class="card-title fw-bold mb-1">Mohammed Pranto</h5>--}}
{{--                        <p class="card-text mb-2" style="font-size: 14px;">--}}
{{--                            Mobile App Developer, Flutter Developer,<br />Instructor & Mentor--}}
{{--                        </p>--}}
{{--                        <p class="text-muted mb-1" style="font-size: 13px;">--}}
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="Location" style="width: 20px;" /> Uttara, Dhaka--}}
{{--                        </p>--}}
{{--                        <div class="d-flex flex-wrap gap-2 mt-3">--}}
{{--                            <span class="badge bg-light text-dark">3+ yrs</span>--}}
{{--                            <span class="badge bg-light text-dark">3.50 CGPA</span>--}}
{{--                            <span class="badge bg-light text-dark">Developer</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col">--}}
{{--                <div class="card h-100 shadow-sm">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="d-flex align-items-center mb-3">--}}
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/headhunt-pp4.png" alt="Mohammed Pranto" class="rounded-circle me-3" style="width: 56px; height: 56px; object-fit: cover;" />--}}
{{--                            <span class="badge   ms-auto Freelancing d-flex align-items-center"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Freelancing.png" alt="" class="me-1">Full-time</span>--}}
{{--                        </div>--}}
{{--                        <h5 class="card-title fw-bold mb-1">Mohammed Pranto</h5>--}}
{{--                        <p class="card-text mb-2" style="font-size: 14px;">--}}
{{--                            Mobile App Developer, Flutter Developer,<br />Instructor & Mentor--}}
{{--                        </p>--}}
{{--                        <p class="text-muted mb-1" style="font-size: 13px;">--}}
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="Location" style="width: 20px;" /> Uttara, Dhaka--}}
{{--                        </p>--}}
{{--                        <div class="d-flex flex-wrap gap-2 mt-3">--}}
{{--                            <span class="badge bg-light text-dark">3+ yrs</span>--}}
{{--                            <span class="badge bg-light text-dark">3.50 CGPA</span>--}}
{{--                            <span class="badge bg-light text-dark">Developer</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col">--}}
{{--                <div class="card h-100 shadow-sm">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="d-flex align-items-center mb-3">--}}
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/headhunt-pp1.png" alt="Mohammed Pranto" class="rounded-circle me-3" style="width: 56px; height: 56px; object-fit: cover;" />--}}
{{--                            <span class="badge   ms-auto fullTime d-flex align-items-center"><img src="{{ asset('/') }}frontend/employer/images/employersHome/fulltime-dot.png" alt="" class="me-1">Full-time</span>--}}
{{--                        </div>--}}
{{--                        <h5 class="card-title fw-bold mb-1">Mohammed Pranto</h5>--}}
{{--                        <p class="card-text mb-2" style="font-size: 14px;">--}}
{{--                            Mobile App Developer, Flutter Developer,<br />Instructor & Mentor--}}
{{--                        </p>--}}
{{--                        <p class="text-muted mb-1" style="font-size: 13px;">--}}
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="Location" style="width: 20px;" /> Uttara, Dhaka--}}
{{--                        </p>--}}
{{--                        <div class="d-flex flex-wrap gap-2 mt-3">--}}
{{--                            <span class="badge bg-light text-dark">3+ yrs</span>--}}
{{--                            <span class="badge bg-light text-dark">3.50 CGPA</span>--}}
{{--                            <span class="badge bg-light text-dark">Developer</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col">--}}
{{--                <div class="card h-100 shadow-sm">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="d-flex align-items-center mb-3">--}}
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/headhunt-pp2.png" alt="Mohammed Pranto" class="rounded-circle me-3" style="width: 56px; height: 56px; object-fit: cover;" />--}}
{{--                            <span class="badge   ms-auto partTime d-flex align-items-center"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Part-time-dot.png" alt="" class="me-1">Full-time</span>--}}
{{--                        </div>--}}
{{--                        <h5 class="card-title fw-bold mb-1">Mohammed Pranto</h5>--}}
{{--                        <p class="card-text mb-2" style="font-size: 14px;">--}}
{{--                            Mobile App Developer, Flutter Developer,<br />Instructor & Mentor--}}
{{--                        </p>--}}
{{--                        <p class="text-muted mb-1" style="font-size: 13px;">--}}
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="Location" style="width: 20px;" /> Uttara, Dhaka--}}
{{--                        </p>--}}
{{--                        <div class="d-flex flex-wrap gap-2 mt-3">--}}
{{--                            <span class="badge bg-light text-dark">3+ yrs</span>--}}
{{--                            <span class="badge bg-light text-dark">3.50 CGPA</span>--}}
{{--                            <span class="badge bg-light text-dark">Developer</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

        </div>
    </div>

@endsection

@push('script')
    @include('common-resource-files.selectize')
@endpush
