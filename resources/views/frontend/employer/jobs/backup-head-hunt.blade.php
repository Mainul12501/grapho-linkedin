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

                    <span style="width: 300px;" class="float-start">
                        <label for="searchJobType">Job Type</label> <br>
                        <select name="job_type[]" id="searchJobType" class="select2 w-100" multiple data-placeholder="Select Job Type">
{{--                            <option value="" selected disabled>Select Job Type</option>--}}
                            @foreach($jobTypes as $jobType)
                                <option value="{{ $jobType->slug }}">{{ $jobType->name }}</option>
                            @endforeach
                        </select>
                    </span>
                    <span style="width: 300px;" class="float-start">
                        <label for="searchUniversity">University</label> <br>
                    <select name="university_name[]" id="searchUniversity" class="select2 w-100" multiple data-placeholder="Select University">
{{--                        <option value="" selected disabled>Select University</option>--}}
                        @foreach($universityNames as $universityName)
                            <option value="{{ $universityName->slug }}">{{ $universityName->name }}</option>
                        @endforeach
                    </select>
                </span>
                    <span style="width: 300px;" class="float-start">
                        <label for="searchIndustry">Industry</label> <br>
                    <select name="industry[]" id="searchIndustry" class="select2 w-100" multiple data-placeholder="Select Industry">
{{--                        <option value="" selected disabled>Select Industry</option>--}}
                        @foreach($industries as $industry)
                            <option value="{{ $industry->slug }}">{{ $industry->name }}</option>
                        @endforeach
                    </select>
                </span>
                    <span style="width: 300px;" class="float-start">
                        <label for="searchFieldOfStudy">Field Of Study</label> <br>
                    <select name="field_of_study[]" id="searchFieldOfStudy" class="select2 w-100" multiple data-placeholder="Select Field Of Study">
{{--                        <option value="" selected disabled>Select Field Of Study</option>--}}
                        @foreach($fieldOfStudies as $fieldOfStudy)
                            <option value="{{ $fieldOfStudy->slug }}">{{ $fieldOfStudy->field_name }}</option>
                        @endforeach
                    </select>
                </span>
                    <span style="width: auto" class="float-start">
                        <label for="select Skills">Skills</label> <br>
                    <select name="skills[]" id="select Skills" class="select2 w-100" multiple data-placeholder="Select Skill Category">
{{--                        <option value="" selected disabled>Select Skill Category</option>--}}
                        @foreach($skillCategories as $skillCategory)
                            <optgroup label="{{ $skillCategory->category_name }}">
                                @foreach($skillCategory->skills as $skill)
                                    <option value="{{ $skill->slug }}">{{ $skill->skill_name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </span>

                    <span style="width: 300px;" class="float-start">
                        <label for="searchGender">Gender</label> <br>
                    <select name="gender" id="searchGender" class="select2 w-100" data-placeholder="Select gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </span>
                    <span style="width: 300px;" class="float-start">
                        <label for="searchDistrict">District</label> <br>
                        <select name="district" id="searchDistrict" class="select2 w-100" data-placeholder="Select District">
                          <option value="" selected disabled>-- Select District --</option>
                          <option value="Barguna">Barguna</option>
                          <option value="Bagerhat">Bagerhat</option>
                          <option value="Bandarban">Bandarban</option>
                          <option value="Barishal">Barishal</option>
                          <option value="Bhola">Bhola</option>
                          <option value="Bogura">Bogura</option>
                          <option value="Brahmanbaria">Brahmanbaria</option>
                          <option value="Chapai Nawabganj">Chapai Nawabganj</option>
                          <option value="Chattogram">Chattogram</option>
                          <option value="Chandpur">Chandpur</option>
                          <option value="Chuadanga">Chuadanga</option>
                          <option value="Cumilla">Cumilla</option>
                          <option value="Cox's Bazar">Cox's Bazar</option>
                          <option value="Dhaka">Dhaka</option>
                          <option value="Dinajpur">Dinajpur</option>
                          <option value="Faridpur">Faridpur</option>
                          <option value="Feni">Feni</option>
                          <option value="Gaibandha">Gaibandha</option>
                          <option value="Gazipur">Gazipur</option>
                          <option value="Gopalganj">Gopalganj</option>
                          <option value="Habiganj">Habiganj</option>
                          <option value="Jamalpur">Jamalpur</option>
                          <option value="Jashore">Jashore</option>
                          <option value="Jhalokati">Jhalokati</option>
                          <option value="Jhenaidah">Jhenaidah</option>
                          <option value="Joypurhat">Joypurhat</option>
                          <option value="Khagrachhari">Khagrachhari</option>
                          <option value="Khulna">Khulna</option>
                          <option value="Kishoreganj">Kishoreganj</option>
                          <option value="Kurigram">Kurigram</option>
                          <option value="Kushtia">Kushtia</option>
                          <option value="Lakshmipur">Lakshmipur</option>
                          <option value="Lalmonirhat">Lalmonirhat</option>
                          <option value="Madaripur">Madaripur</option>
                          <option value="Magura">Magura</option>
                          <option value="Meherpur">Meherpur</option>
                          <option value="Moulvibazar">Moulvibazar</option>
                          <option value="Munshiganj">Munshiganj</option>
                          <option value="Mymensingh">Mymensingh</option>
                          <option value="Naogaon">Naogaon</option>
                          <option value="Narayanganj">Narayanganj</option>
                          <option value="Narsingdi">Narsingdi</option>
                          <option value="Natore">Natore</option>
                          <option value="Netrokona">Netrokona</option>
                          <option value="Nilphamari">Nilphamari</option>
                          <option value="Noakhali">Noakhali</option>
                          <option value="Pabna">Pabna</option>
                          <option value="Panchagarh">Panchagarh</option>
                          <option value="Patuakhali">Patuakhali</option>
                          <option value="Pirojpur">Pirojpur</option>
                          <option value="Rajbari">Rajbari</option>
                          <option value="Rajshahi">Rajshahi</option>
                          <option value="Rangamati">Rangamati</option>
                          <option value="Rangpur">Rangpur</option>
                          <option value="Satkhira">Satkhira</option>
                          <option value="Shariatpur">Shariatpur</option>
                          <option value="Sherpur">Sherpur</option>
                          <option value="Sirajganj">Sirajganj</option>
                          <option value="Sunamganj">Sunamganj</option>
                          <option value="Sylhet">Sylhet</option>
                          <option value="Tangail">Tangail</option>
                          <option value="Thakurgaon">Thakurgaon</option>
                        </select>

                </span>
                    <span style="width: 300px;" class="float-start">
                        <label for="searchGender">CGPA</label> <br>
                    <input type="text" class="form-control" name="cgpa" placeholder="Max CGPA">
                </span>
                    <span style="width: 300px;" class="float-start">
                        <label for="searchGender">Experience</label> <br>
                    <input type="text" class="form-control" name="experience" placeholder="Max Experience">
                </span>
                    <span class="mb-4" style="max-width: 350px;">
                         <label for="searchGender">Search Text</label> <br>
                        <span class="input-group">
                            <input type="text" class="form-control" name="search_text" placeholder="Search talents" aria-label="Search talents" />
                        <button class="btn btn-light border" type="submit">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/search 1.png" alt="Search" style="width: 16px; height: 16px;" />
                        </button>
                        </span>
                    </span>
                </div>

{{--                <div class="input-group mb-4" style="max-width: 350px;">--}}
{{--                    <input type="text" class="form-control" name="search_text" placeholder="Search talents" aria-label="Search talents" />--}}
{{--                    <button class="btn btn-light border" type="submit">--}}
{{--                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/search 1.png" alt="Search" style="width: 16px; height: 16px;" />--}}
{{--                    </button>--}}
{{--                </div>--}}
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
