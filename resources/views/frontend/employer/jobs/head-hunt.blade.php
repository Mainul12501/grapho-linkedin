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

        <section class="bg-white">
            <div class="container">
                <!-- Filters form -->
                <form id="jobFilters" class="customWrapper" method="get" action="/jobs" data-autosubmit="true" >
        <!-- Filters: label (icon + text) -->
                <div class="fielterIcon me-2">
                    <div>
                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/Filter.png" alt="" class="me-1">
                        <span>Filters:</span>
                    </div>
                </div>

                <!-- ===== Filter #1: Date posted ===== -->
                <div class="custom-select" data-filter-key="workplace_type" data-placeholder="Select Workplace Type">
                    <label class="custom-select-label">Workplace Type</label>
                    <input type="text" class="form-control select-box locationSearch" placeholder="Select Workplace Type" readonly="">
                    <div class="dropdown-menu locationDropdown" style="max-height: none;">
                        <input type="text" class="form-control search-box searchBar" placeholder="Search...">
                        @foreach($jobTypes  as $jobType)
                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" id="workplace-{{ $jobType->id }}" value="{{ $jobType->slug }}">
                                <label for="workplace-{{ $jobType->id }}">{{ $jobType->name }}</label>
                            </div>
                        @endforeach

{{--                        <div class="checkbox-item">--}}
{{--                            <input type="checkbox" class="locationCheckbox" id="date7d">--}}
{{--                            <label for="date7d">Last 7 days</label>--}}
{{--                        </div>--}}
                    </div>
                    <input type="hidden" class="filter-payload" name="filters[job_type]" value="[]">
                </div>

                <!-- ===== Filter #2: Company type ===== -->
                <div class="custom-select" data-filter-key="university_name" data-placeholder="Select University Name">
                    <label class="custom-select-label">University Name</label>
                    <input type="text" class="form-control select-box locationSearch" placeholder="Select company type" readonly="">
                    <div class="dropdown-menu locationDropdown" style="max-height: none;">
                        <input type="text" class="form-control search-box searchBar" placeholder="Search...">
                        @foreach($universityNames  as $universityName)
                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" id="uni-{{ $universityName->id }}" value="{{ $universityName->slug }}">
                                <label for="uni-{{ $universityName->id }}">{{ $universityName->name }}</label>
                            </div>

                        @endforeach
{{--                        <div class="checkbox-item">--}}
{{--                            <input type="checkbox" class="locationCheckbox" id="ctype-consult">--}}
{{--                            <label for="ctype-consult">Consulting Firms</label>--}}
{{--                        </div>--}}
{{--                        <div class="checkbox-item">--}}
{{--                            <input type="checkbox" class="locationCheckbox" id="ctype-law">--}}
{{--                            <label for="ctype-law">Law Firms</label>--}}
{{--                        </div>--}}
                    </div>
                    <input type="hidden" class="filter-payload" name="filters[university_name]" value="[]">
                </div>

                <!-- ===== Filter #3: Location ===== -->
                <div class="custom-select" data-filter-key="location" data-placeholder="Select District">
                    <label class="custom-select-label">District</label>
                    <input type="text" class="form-control select-box locationSearch" placeholder="Select District" readonly="">
                    <div class="dropdown-menu locationDropdown" style="max-height: none;">
                        <input type="text" class="form-control search-box searchBar" placeholder="Search...">

                        <div class="checkbox-item"><input type="checkbox" value="Bagerhat" class="locationCheckbox" id="loc-Bagerhat" /> <label for="loc-Bagerhat">Bagerhat</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Bandarban" class="locationCheckbox" id="loc-Bandarban" /> <label for="loc-Bandarban">Bandarban</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Barguna" class="locationCheckbox" id="loc-Barguna" /> <label for="loc-Barguna">Barguna</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Barisal" class="locationCheckbox" id="loc-Barisal" /> <label for="loc-Barisal">Barisal</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Bhola" class="locationCheckbox" id="loc-Bhola" /> <label for="loc-Bhola">Bhola</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Bogura" class="locationCheckbox" id="loc-Bogura" /> <label for="loc-Bogura">Bogura</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Brahmanbaria" class="locationCheckbox" id="loc-Brahmanbaria" /> <label for="loc-Brahmanbaria">Brahmanbaria</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Chandpur" class="locationCheckbox" id="loc-Chandpur" /> <label for="loc-Chandpur">Chandpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Chapainawabganj" class="locationCheckbox" id="loc-Chapainawabganj" /> <label for="loc-Chapainawabganj">Chapainawabganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Chattogram" class="locationCheckbox" id="loc-Chattogram" /> <label for="loc-Chattogram">Chattogram</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Chuadanga" class="locationCheckbox" id="loc-Chuadanga" /> <label for="loc-Chuadanga">Chuadanga</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Coxs Bazar" class="locationCheckbox" id="loc-Coxs-Bazar" /> <label for="loc-Coxs-Bazar">Cox's Bazar</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Cumilla" class="locationCheckbox" id="loc-Cumilla" /> <label for="loc-Cumilla">Cumilla</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Dhaka" class="locationCheckbox" id="loc-Dhaka" /> <label for="loc-Dhaka">Dhaka</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Dinajpur" class="locationCheckbox" id="loc-Dinajpur" /> <label for="loc-Dinajpur">Dinajpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Faridpur" class="locationCheckbox" id="loc-Faridpur" /> <label for="loc-Faridpur">Faridpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Feni" class="locationCheckbox" id="loc-Feni" /> <label for="loc-Feni">Feni</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Gaibandha" class="locationCheckbox" id="loc-Gaibandha" /> <label for="loc-Gaibandha">Gaibandha</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Gazipur" class="locationCheckbox" id="loc-Gazipur" /> <label for="loc-Gazipur">Gazipur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Gopalganj" class="locationCheckbox" id="loc-Gopalganj" /> <label for="loc-Gopalganj">Gopalganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Habiganj" class="locationCheckbox" id="loc-Habiganj" /> <label for="loc-Habiganj">Habiganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Jamalpur" class="locationCheckbox" id="loc-Jamalpur" /> <label for="loc-Jamalpur">Jamalpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Jashore" class="locationCheckbox" id="loc-Jashore" /> <label for="loc-Jashore">Jashore</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Jhalokati" class="locationCheckbox" id="loc-Jhalokati" /> <label for="loc-Jhalokati">Jhalokati</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Jhenaidah" class="locationCheckbox" id="loc-Jhenaidah" /> <label for="loc-Jhenaidah">Jhenaidah</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Joypurhat" class="locationCheckbox" id="loc-Joypurhat" /> <label for="loc-Joypurhat">Joypurhat</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Khagrachari" class="locationCheckbox" id="loc-Khagrachari" /> <label for="loc-Khagrachari">Khagrachari</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Khulna" class="locationCheckbox" id="loc-Khulna" /> <label for="loc-Khulna">Khulna</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Kishoreganj" class="locationCheckbox" id="loc-Kishoreganj" /> <label for="loc-Kishoreganj">Kishoreganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Kurigram" class="locationCheckbox" id="loc-Kurigram" /> <label for="loc-Kurigram">Kurigram</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Kushtia" class="locationCheckbox" id="loc-Kushtia" /> <label for="loc-Kushtia">Kushtia</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Lakshmipur" class="locationCheckbox" id="loc-Lakshmipur" /> <label for="loc-Lakshmipur">Lakshmipur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Lalmonirhat" class="locationCheckbox" id="loc-Lalmonirhat" /> <label for="loc-Lalmonirhat">Lalmonirhat</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Madaripur" class="locationCheckbox" id="loc-Madaripur" /> <label for="loc-Madaripur">Madaripur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Magura" class="locationCheckbox" id="loc-Magura" /> <label for="loc-Magura">Magura</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Manikganj" class="locationCheckbox" id="loc-Manikganj" /> <label for="loc-Manikganj">Manikganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Meherpur" class="locationCheckbox" id="loc-Meherpur" /> <label for="loc-Meherpur">Meherpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Moulvibazar" class="locationCheckbox" id="loc-Moulvibazar" /> <label for="loc-Moulvibazar">Moulvibazar</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Munshiganj" class="locationCheckbox" id="loc-Munshiganj" /> <label for="loc-Munshiganj">Munshiganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Mymensingh" class="locationCheckbox" id="loc-Mymensingh" /> <label for="loc-Mymensingh">Mymensingh</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Naogaon" class="locationCheckbox" id="loc-Naogaon" /> <label for="loc-Naogaon">Naogaon</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Narail" class="locationCheckbox" id="loc-Narail" /> <label for="loc-Narail">Narail</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Narayanganj" class="locationCheckbox" id="loc-Narayanganj" /> <label for="loc-Narayanganj">Narayanganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Narsingdi" class="locationCheckbox" id="loc-Narsingdi" /> <label for="loc-Narsingdi">Narsingdi</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Natore" class="locationCheckbox" id="loc-Natore" /> <label for="loc-Natore">Natore</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Netrokona" class="locationCheckbox" id="loc-Netrokona" /> <label for="loc-Netrokona">Netrokona</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Nilphamari" class="locationCheckbox" id="loc-Nilphamari" /> <label for="loc-Nilphamari">Nilphamari</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Noakhali" class="locationCheckbox" id="loc-Noakhali" /> <label for="loc-Noakhali">Noakhali</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Pabna" class="locationCheckbox" id="loc-Pabna" /> <label for="loc-Pabna">Pabna</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Panchagarh" class="locationCheckbox" id="loc-Panchagarh" /> <label for="loc-Panchagarh">Panchagarh</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Patuakhali" class="locationCheckbox" id="loc-Patuakhali" /> <label for="loc-Patuakhali">Patuakhali</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Pirojpur" class="locationCheckbox" id="loc-Pirojpur" /> <label for="loc-Pirojpur">Pirojpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Rajbari" class="locationCheckbox" id="loc-Rajbari" /> <label for="loc-Rajbari">Rajbari</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Rajshahi" class="locationCheckbox" id="loc-Rajshahi" /> <label for="loc-Rajshahi">Rajshahi</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Rangamati" class="locationCheckbox" id="loc-Rangamati" /> <label for="loc-Rangamati">Rangamati</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Rangpur" class="locationCheckbox" id="loc-Rangpur" /> <label for="loc-Rangpur">Rangpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Satkhira" class="locationCheckbox" id="loc-Satkhira" /> <label for="loc-Satkhira">Satkhira</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Shariatpur" class="locationCheckbox" id="loc-Shariatpur" /> <label for="loc-Shariatpur">Shariatpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Sherpur" class="locationCheckbox" id="loc-Sherpur" /> <label for="loc-Sherpur">Sherpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Sirajganj" class="locationCheckbox" id="loc-Sirajganj" /> <label for="loc-Sirajganj">Sirajganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Sunamganj" class="locationCheckbox" id="loc-Sunamganj" /> <label for="loc-Sunamganj">Sunamganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Sylhet" class="locationCheckbox" id="loc-Sylhet" /> <label for="loc-Sylhet">Sylhet</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Tangail" class="locationCheckbox" id="loc-Tangail" /> <label for="loc-Tangail">Tangail</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Thakurgaon" class="locationCheckbox" id="loc-Thakurgaon" /> <label for="loc-Thakurgaon">Thakurgaon</label></div>


                    </div>
                    <input type="hidden" class="filter-payload" name="filters[district]" value="[]">
                </div>

                <!-- ===== Filter #4: Industry ===== -->
                <div class="custom-select" data-filter-key="industry" data-placeholder="Select industry">
                    <label class="custom-select-label">Industry</label>
                    <input type="text" class="form-control select-box locationSearch" placeholder="Select industry" readonly="">
                    <div class="dropdown-menu locationDropdown" style="max-height: none;">
                        <input type="text" class="form-control search-box searchBar" placeholder="Search...">
                        @foreach($industries  as $industry)
                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" id="ind-{{ $industry->id }}" value="{{ $industry->slug }}">
                                <label for="ind-{{ $industry->id }}">{{ $industry->name }}</label>
                            </div>

                        @endforeach
{{--                        <div class="checkbox-item">--}}
{{--                            <input type="checkbox" class="locationCheckbox" id="ind-it">--}}
{{--                            <label for="ind-it">Information Technology</label>--}}
{{--                        </div>--}}
{{--                        <div class="checkbox-item">--}}
{{--                            <input type="checkbox" class="locationCheckbox" id="ind-fin">--}}
{{--                            <label for="ind-fin">Finance &amp; Accounting</label>--}}
{{--                        </div>--}}
                    </div>
                    <input type="hidden" class="filter-payload" name="filters[industry]" value="[]">
                </div>

                <!-- ===== Filter #5: Company ===== -->
                <div class="custom-select" data-filter-key="field_of_study" data-placeholder="Select Field Of Study">
                    <label class="custom-select-label">Field Of Study</label>
                    <input type="text" class="form-control select-box locationSearch" placeholder="Select company" readonly="">
                    <div class="dropdown-menu locationDropdown" style="max-height: none;">
                        <input type="text" class="form-control search-box searchBar" placeholder="Search...">
                        @foreach($fieldOfStudies  as $fieldOfStudy)
                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" id="fos-{{ $fieldOfStudy->id }}" value="{{ $fieldOfStudy->slug }}">
                                <label for="fos-{{ $fieldOfStudy->id }}">{{ $fieldOfStudy->field_name }}</label>
                            </div>
                        @endforeach
{{--                        <div class="checkbox-item">--}}
{{--                            <input type="checkbox" class="locationCheckbox" id="co-google">--}}
{{--                            <label for="co-google">Google</label>--}}
{{--                        </div>--}}
{{--                        <div class="checkbox-item">--}}
{{--                            <input type="checkbox" class="locationCheckbox" id="co-ms">--}}
{{--                            <label for="co-ms">Microsoft</label>--}}
{{--                        </div>--}}
                    </div>
                    <input type="hidden" class="filter-payload" name="filters[field_of_study]" value="[]">
                </div>

                <!-- ===== Filter #6: Salary ===== -->
                <div class="custom-select" data-filter-key="skills" data-placeholder="Select Skills">
                    <label class="custom-select-label">Skills</label>
                    <input type="text" class="form-control select-box locationSearch" placeholder="Select salary range" readonly="">
                    <div class="dropdown-menu locationDropdown" style="max-height: none;">
                        <input type="text" class="form-control search-box searchBar" placeholder="Search...">
                        @foreach($skillCategories as $skillCategory)
                            <span style="font-weight: bold">{{ $skillCategory->category_name }}</span>
                            @foreach($skillCategory->skills as $skill)
                                <div class="checkbox-item">
                                    <input type="checkbox" class="locationCheckbox" id="skill-{{ $skill->id }}" value="{{ $skill->slug }}">
                                    <label for="skill-{{ $skill->id }}">{{ $skill->skill_name }}</label>
                                </div>
                            @endforeach
                        @endforeach

{{--                        <div class="checkbox-item">--}}
{{--                            <input type="checkbox" class="locationCheckbox" id="sal-low">--}}
{{--                            <label for="sal-low">Below 20,000 BDT</label>--}}
{{--                        </div>--}}
{{--                        <div class="checkbox-item">--}}
{{--                            <input type="checkbox" class="locationCheckbox" id="sal-mid">--}}
{{--                            <label for="sal-mid">20,000 - 50,000 BDT</label>--}}
{{--                        </div>--}}
                    </div>
                    <input type="hidden" class="filter-payload" name="filters[skills]" value="[]">
                </div>

                    <!-- ===== Filter #7: Gender ===== -->
                    <div class="custom-select" data-filter-key="gender" data-placeholder="Select Gender">
                        <label class="custom-select-label">Gender</label>
                        <input type="text" class="form-control select-box locationSearch" placeholder="Select Gender" readonly="">
                        <div class="dropdown-menu locationDropdown" style="max-height: none;">
                            <input type="text" class="form-control search-box searchBar" placeholder="Search...">

                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" id="co-male" value="male">
                                <label for="co-male">Male</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" id="co-female" value="female">
                                <label for="co-female">Female</label>
                            </div>
                        </div>
                        <input type="hidden" class="filter-payload" name="filters[gender]" value="[]">
                    </div>
                    <!-- ===== Filter #7: CGPA ===== -->
                    <div class="custom-select" data-filter-key="cgpa" data-placeholder="Select CGPA">
                        <label class="custom-select-label">CGPA</label>
                        <input type="text" class="form-control select-box locationSearch" style="background-image: none" name="cgpa" placeholder="Set Minimum Gender" >
                    </div>
                    <!-- ===== Filter #7: Experience ===== -->
                    <div class="custom-select" data-filter-key="cgpa" data-placeholder="Select Experience">
                        <label class="custom-select-label">Experience</label>
                        <input type="text" class="form-control select-box locationSearch" style="background-image: none" name="experience" placeholder="Set Minimum Gender" >
                    </div>
                    <!-- ===== Filter #7: Search Text ===== -->
                    <div class="custom-select" data-filter-key="search_text" data-placeholder="Select Search Text">
                        <label class="custom-select-label">Search Text</label>
                        <input type="text" class="form-control select-box locationSearch" style="background-image: none; max-width: 250px!important;" name="search_text" placeholder="Set Minimum Gender" >
                    </div>

                <!-- Clear All button (resets the filter selections) -->
                <button type="button" class="clear-all-btn d-flex" id="clearAllBtn">Clear All</button>
                <button type="submit" class="clear-all-btn btn d-flex" id="clearAllBtn">Filter</button>
                </form>
            </div>
        </section>

        <div class="d-flex justify-content-between mb-3" style="font-size: 14px; cursor: pointer;">
            <p class="text-muted">Showing {{ count($employees) ?? 0 }} results.</p>

        </div>


        <div class="row row-cols-1 row-cols-md-3 g-3 headhuntPP-card">
            <!-- Candidate Card Template -->
            @foreach($employees as $employee)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset($employee->profile_image ?? '/frontend/user-vector-img.jpg') }}" alt="{{ $employee->name ?? '' }}" class="rounded-circle me-3" style="width: 56px; height: 56px; object-fit: cover;" />
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

        </div>
    </div>

@endsection

@push('style')
    <style>
        .custom-select {
            max-width: 170px !important;
            min-width: 150px !important;
        }
    </style>
@endpush

@push('script')
    @include('common-resource-files.selectize')

{{--    <link rel="stylesheet" href="{{ asset('/frontend/employee/headerStyle.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('/frontend/employee/mainstyle.css') }}">
    <script src="{{ asset('/frontend/employee/script.js') }}"></script>

@endpush
