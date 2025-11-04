@extends('frontend.employer.master')

@section('title', 'Head Hunt')

@section('body')

    @php
        function getSelectedFilters($filterKey) {
            $filters = request('filters', []);
            if (!isset($filters[$filterKey])) {
                return [];
            }

            $value = $filters[$filterKey];

            if (is_string($value)) {
                $decoded = json_decode($value, true);
                return is_array($decoded) ? $decoded : [];
            }

            return is_array($value) ? $value : [];
        }
    @endphp

    <div class="ps-3 py-2 d-block d-md-none">
        <img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt="">
    </div>
    <!-- head hunt -->
    <div class="headHunt p-4">
        <h2 class="mb-1 fw-bold f-s-23">Head Hunt</h2>
        <p class="text-muted mb-3">Browse talents & find the perfect match for your company.</p>

        <section class="bg-white">
            <div class="container">
                <!-- Filters form -->
                <form id="jobFilters" class="customWrapper" method="get" action="" data-autosubmit="true" >
        <!-- Filters: label (icon + text) -->
                <div class="fielterIcon me-2">
                    <div>
                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/Filter.png" alt="" class="me-1">
                        <span>Filters:</span>
                    </div>
                </div>

                <!-- ===== Filter #1: Date posted ===== -->
                <div class="custom-select" data-filter-key="job_type" style="max-width: 120px!important;" data-placeholder="Job Type">
{{--                    <label class="custom-select-label">Workplace Type</label>--}}
                    <input type="text" class="form-control select-box locationSearch" placeholder="Select Workplace Type" readonly="">
                    <div class="dropdown-menu locationDropdown" style="max-height: none;">
                        <input type="text" class="form-control search-box searchBar" placeholder="Search...">
                        @foreach($jobTypes  as $jobType)
                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" {{ in_array($jobType->slug, getSelectedFilters('job_type')) ? 'checked' : '' }} id="workplace-{{ $jobType->id }}" value="{{ $jobType->slug }}">
                                <label for="workplace-{{ $jobType->id }}">{{ $jobType->name }}</label>
                            </div>
                        @endforeach

                    </div>
                    <input type="hidden" class="filter-payload" name="filters[job_type]" value="[]">
                </div>

                <!-- ===== Filter #2: Company type ===== -->
                <div class="custom-select" data-filter-key="university_name" style="max-width: 125px!important;" data-placeholder="University">
{{--                    <label class="custom-select-label">University Name</label>--}}
                    <input type="text" class="form-control select-box locationSearch" placeholder="Select company type" readonly="">
                    <div class="dropdown-menu locationDropdown" style="max-height: none;">
                        <input type="text" class="form-control search-box searchBar" placeholder="Search...">
                        @foreach($universityNames  as $universityName)
                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" id="uni-{{ $universityName->id }}" {{ in_array($universityName->slug, getSelectedFilters('university_name')) ? 'checked' : '' }} value="{{ $universityName->slug }}">
                                <label for="uni-{{ $universityName->id }}">{{ $universityName->name }}</label>
                            </div>

                        @endforeach
                    </div>
                    <input type="hidden" class="filter-payload" name="filters[university_name]" value="[]">
                </div>

                <!-- ===== Filter #3: Location ===== -->
                <div class="custom-select" data-filter-key="district" style="max-width: 105px!important;" data-placeholder="District">
{{--                    <label class="custom-select-label">District</label>--}}
                    <input type="text" class="form-control select-box locationSearch" placeholder="Select District" readonly="">
                    <div class="dropdown-menu locationDropdown" style="max-height: none;">
                        <input type="text" class="form-control search-box searchBar" placeholder="Search...">

                        <div class="checkbox-item"><input type="checkbox" value="Bagerhat" {{ in_array('Bagerhat', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Bagerhat" /> <label for="loc-Bagerhat">Bagerhat</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Bandarban" {{ in_array('Bandarban', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Bandarban" /> <label for="loc-Bandarban">Bandarban</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Barguna" {{ in_array('Barguna', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Barguna" /> <label for="loc-Barguna">Barguna</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Barisal" {{ in_array('Barisal', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Barisal" /> <label for="loc-Barisal">Barisal</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Bhola" {{ in_array('Bhola', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Bhola" /> <label for="loc-Bhola">Bhola</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Bogura" {{ in_array('Bogura', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Bogura" /> <label for="loc-Bogura">Bogura</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Brahmanbaria" {{ in_array('Brahmanbaria', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Brahmanbaria" /> <label for="loc-Brahmanbaria">Brahmanbaria</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Chandpur" {{ in_array('Chandpur', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Chandpur" /> <label for="loc-Chandpur">Chandpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Chapainawabganj" {{ in_array('Chapainawabganj', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Chapainawabganj" /> <label for="loc-Chapainawabganj">Chapainawabganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Chattogram" {{ in_array('Chattogram', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Chattogram" /> <label for="loc-Chattogram">Chattogram</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Chuadanga" {{ in_array('Chuadanga', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Chuadanga" /> <label for="loc-Chuadanga">Chuadanga</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Coxs Bazar" {{ in_array('Coxs Bazar', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Coxs-Bazar" /> <label for="loc-Coxs-Bazar">Cox's Bazar</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Cumilla" {{ in_array('Cumilla', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Cumilla" /> <label for="loc-Cumilla">Cumilla</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Dhaka" {{ in_array('Dhaka', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Dhaka" /> <label for="loc-Dhaka">Dhaka</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Dinajpur" {{ in_array('Dinajpur', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Dinajpur" /> <label for="loc-Dinajpur">Dinajpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Faridpur" {{ in_array('Faridpur', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Faridpur" /> <label for="loc-Faridpur">Faridpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Feni" {{ in_array('Feni', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Feni" /> <label for="loc-Feni">Feni</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Gaibandha" {{ in_array('Gaibandha', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Gaibandha" /> <label for="loc-Gaibandha">Gaibandha</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Gazipur" {{ in_array('Gazipur', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Gazipur" /> <label for="loc-Gazipur">Gazipur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Gopalganj" {{ in_array('Gopalganj', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Gopalganj" /> <label for="loc-Gopalganj">Gopalganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Habiganj" {{ in_array('Habiganj', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Habiganj" /> <label for="loc-Habiganj">Habiganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Jamalpur" {{ in_array('Jamalpur', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Jamalpur" /> <label for="loc-Jamalpur">Jamalpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Jashore" {{ in_array('Jashore', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Jashore" /> <label for="loc-Jashore">Jashore</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Jhalokati" {{ in_array('Jhalokati', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Jhalokati" /> <label for="loc-Jhalokati">Jhalokati</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Jhenaidah" {{ in_array('Jhenaidah', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Jhenaidah" /> <label for="loc-Jhenaidah">Jhenaidah</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Joypurhat" {{ in_array('Joypurhat', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Joypurhat" /> <label for="loc-Joypurhat">Joypurhat</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Khagrachari" {{ in_array('Khagrachari', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Khagrachari" /> <label for="loc-Khagrachari">Khagrachari</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Khulna" {{ in_array('Khulna', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Khulna" /> <label for="loc-Khulna">Khulna</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Kishoreganj" {{ in_array('Kishoreganj', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Kishoreganj" /> <label for="loc-Kishoreganj">Kishoreganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Kurigram" {{ in_array('Kurigram', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Kurigram" /> <label for="loc-Kurigram">Kurigram</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Kushtia" {{ in_array('Kushtia', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Kushtia" /> <label for="loc-Kushtia">Kushtia</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Lakshmipur" {{ in_array('Lakshmipur', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Lakshmipur" /> <label for="loc-Lakshmipur">Lakshmipur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Lalmonirhat" {{ in_array('Lalmonirhat', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Lalmonirhat" /> <label for="loc-Lalmonirhat">Lalmonirhat</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Madaripur" {{ in_array('Madaripur', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Madaripur" /> <label for="loc-Madaripur">Madaripur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Magura" {{ in_array('Magura', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Magura" /> <label for="loc-Magura">Magura</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Manikganj" {{ in_array('Manikganj', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Manikganj" /> <label for="loc-Manikganj">Manikganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Meherpur" {{ in_array('Meherpur', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Meherpur" /> <label for="loc-Meherpur">Meherpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Moulvibazar" {{ in_array('Moulvibazar', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Moulvibazar" /> <label for="loc-Moulvibazar">Moulvibazar</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Munshiganj" {{ in_array('Munshiganj', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Munshiganj" /> <label for="loc-Munshiganj">Munshiganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Mymensingh" {{ in_array('Mymensingh', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Mymensingh" /> <label for="loc-Mymensingh">Mymensingh</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Naogaon" {{ in_array('Naogaon', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Naogaon" /> <label for="loc-Naogaon">Naogaon</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Narail" {{ in_array('Narail', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Narail" /> <label for="loc-Narail">Narail</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Narayanganj" {{ in_array('Narayanganj', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Narayanganj" /> <label for="loc-Narayanganj">Narayanganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Narsingdi" {{ in_array('Narsingdi', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Narsingdi" /> <label for="loc-Narsingdi">Narsingdi</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Natore" {{ in_array('Natore', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Natore" /> <label for="loc-Natore">Natore</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Netrokona" {{ in_array('Netrokona', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Netrokona" /> <label for="loc-Netrokona">Netrokona</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Nilphamari" {{ in_array('Nilphamari', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Nilphamari" /> <label for="loc-Nilphamari">Nilphamari</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Noakhali" {{ in_array('Noakhali', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Noakhali" /> <label for="loc-Noakhali">Noakhali</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Pabna" {{ in_array('Pabna', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Pabna" /> <label for="loc-Pabna">Pabna</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Panchagarh" {{ in_array('Panchagarh', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Panchagarh" /> <label for="loc-Panchagarh">Panchagarh</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Patuakhali" {{ in_array('Patuakhali', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Patuakhali" /> <label for="loc-Patuakhali">Patuakhali</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Pirojpur" {{ in_array('Pirojpur', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Pirojpur" /> <label for="loc-Pirojpur">Pirojpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Rajbari" {{ in_array('Rajbari', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Rajbari" /> <label for="loc-Rajbari">Rajbari</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Rajshahi" {{ in_array('Rajshahi', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Rajshahi" /> <label for="loc-Rajshahi">Rajshahi</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Rangamati" {{ in_array('Rangamati', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Rangamati" /> <label for="loc-Rangamati">Rangamati</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Rangpur" {{ in_array('Rangpur', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Rangpur" /> <label for="loc-Rangpur">Rangpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Satkhira" {{ in_array('Satkhira', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Satkhira" /> <label for="loc-Satkhira">Satkhira</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Shariatpur" {{ in_array('Shariatpur', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Shariatpur" /> <label for="loc-Shariatpur">Shariatpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Sherpur" {{ in_array('Sherpur', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Sherpur" /> <label for="loc-Sherpur">Sherpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Sirajganj" {{ in_array('Sirajganj', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Sirajganj" /> <label for="loc-Sirajganj">Sirajganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Sunamganj" {{ in_array('Sunamganj', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Sunamganj" /> <label for="loc-Sunamganj">Sunamganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Sylhet" {{ in_array('Sylhet', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Sylhet" /> <label for="loc-Sylhet">Sylhet</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Tangail" {{ in_array('Tangail', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Tangail" /> <label for="loc-Tangail">Tangail</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Thakurgaon" {{ in_array('Thakurgaon', getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Thakurgaon" /> <label for="loc-Thakurgaon">Thakurgaon</label></div>
                    </div>
                    <input type="hidden" class="filter-payload" name="filters[district]" value="[]">
                </div>

                <!-- ===== Filter #4: Industry ===== -->
                <div class="custom-select" data-filter-key="industry" style="max-width: 110px!important;" data-placeholder="industry">
{{--                    <label class="custom-select-label">Industry</label>--}}
                    <input type="text" class="form-control select-box locationSearch" placeholder="Select industry" readonly="">
                    <div class="dropdown-menu locationDropdown" style="max-height: none;">
                        <input type="text" class="form-control search-box searchBar" placeholder="Search...">
                        @foreach($industries  as $industry)
                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" id="ind-{{ $industry->id }}" {{ in_array($industry->slug, getSelectedFilters('industry')) ? 'checked' : '' }} value="{{ $industry->slug }}">
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
                <div class="custom-select" data-filter-key="field_of_study" style="max-width: 155px!important;" data-placeholder="Field Of Study">
{{--                    <label class="custom-select-label">Field Of Study</label>--}}
                    <input type="text" class="form-control select-box locationSearch" placeholder="Select company" readonly="">
                    <div class="dropdown-menu locationDropdown" style="max-height: none;">
                        <input type="text" class="form-control search-box searchBar" placeholder="Search...">
                        @foreach($fieldOfStudies  as $fieldOfStudy)
                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" {{ in_array($fieldOfStudy->slug, getSelectedFilters('field_of_study')) ? 'checked' : '' }} id="fos-{{ $fieldOfStudy->id }}" value="{{ $fieldOfStudy->slug }}">
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
                <div class="custom-select" data-filter-key="skills" style="max-width: 90px!important;" data-placeholder="Skills">
{{--                    <label class="custom-select-label">Skills</label>--}}
                    <input type="text" class="form-control select-box locationSearch" placeholder="Select salary range" readonly="">
                    <div class="dropdown-menu locationDropdown" style="max-height: none;">
                        <input type="text" class="form-control search-box searchBar" placeholder="Search...">
                        @foreach($skillCategories as $skillCategory)
                            <span style="font-weight: bold">{{ $skillCategory->category_name }}</span>
                            @foreach($skillCategory->skills as $skill)
                                <div class="checkbox-item">
                                    <input type="checkbox" class="locationCheckbox" {{ in_array($skill->slug, getSelectedFilters('skills')) ? 'checked' : '' }} id="skill-{{ $skill->id }}" value="{{ $skill->slug }}">
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
                    <div class="custom-select" data-filter-key="gender" style="max-width: 105px!important;" data-placeholder="Gender">
{{--                        <label class="custom-select-label">Gender</label>--}}
                        <input type="text" class="form-control select-box locationSearch" placeholder="Gender" readonly="">
                        <div class="dropdown-menu locationDropdown" style="max-height: none;">
                            <input type="text" class="form-control search-box searchBar" placeholder="Search...">

                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" {{ in_array('male', getSelectedFilters('gender')) ? 'checked' : '' }} id="co-male" value="male">
                                <label for="co-male">Male</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" {{ in_array('female', getSelectedFilters('gender')) ? 'checked' : '' }} id="co-female" value="female">
                                <label for="co-female">Female</label>
                            </div>
                        </div>
                        <input type="hidden" class="filter-payload" name="filters[gender]" value="[]">
                    </div>
                    <!-- ===== Filter #7: CGPA ===== -->
                    <div class="custom-select" data-filter-key="cgpa" style="max-width: 100px!important;" data-placeholder="CGPA">
{{--                        <label class="custom-select-label">CGPA</label>--}}
                        <input type="text" class="form-control select-box locationSearch" value="{{ request('cgpa') }}" style="background-image: none" name="cgpa" placeholder="CGPA" >
                    </div>
                    <!-- ===== Filter #7: Experience ===== -->
                    <div class="custom-select" data-filter-key="experience" style="max-width: 130px!important;" data-placeholder="Experience">
{{--                        <label class="custom-select-label">Experience</label>--}}
                        <input type="text" class="form-control select-box locationSearch" style="background-image: none" value="{{ request('experience') ?? '' }}" name="experience" placeholder="Experience" >
                    </div>
                    <!-- ===== Filter #7: Search Text ===== -->
                    <div class="custom-select" data-filter-key="search_text" style="max-width: 166px!important;" data-placeholder="Search Text">
{{--                        <label class="custom-select-label">Search Text</label>--}}
                        <input type="text" class="form-control select-box locationSearch" value="{{ request('search_text') ?? '' }}" style="background-image: none; max-width: 250px!important;" name="search_text" placeholder="Search by text" >
                    </div>

                <!-- Clear All button (resets the filter selections) -->
                    <button type="submit" class="clear-all-btn border btn d-flex" style="border: 1px solid gray" id="saveBtn">Search</button>
                    <button type="button" class="clear-all-btn border btn d-flex" style="border: 1px solid gray" id="clearAllBtn">Clear All</button>
                </form>
            </div>
        </section>

        <div class="d-flex justify-content-between mb-3 mt-3" style="font-size: 14px; cursor: pointer;">
            <p class="text-muted">Showing {{ count($employees) ?? 0 }} results.</p>

        </div>


        <div class="row row-cols-1 row-cols-md-3 g-3 headhuntPP-card">
            <!-- Candidate Card Template -->
            @forelse($employees as $employee)
                <div class="col p-1">
                    <a href="{{ route('employee-profile', $employee->id) }}" style="text-decoration: none">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset($employee->profile_image ?? '/frontend/user-vector-img.jpg') }}" alt="{{ $employee->name ?? '' }}" class="rounded-circle me-3" style="width: 56px; height: 56px; object-fit: cover;" />
                                    @if(isset($employee?->jobTypes[0]))
                                        <span class="badge   ms-auto fullTime d-flex align-items-center"><img src="{{ asset('/frontend/employer/images/employersHome/fulltime-dot.png') }}" alt="" class="me-1">{{ $employee?->jobTypes[0]?->name ?? '' }}</span>
                                    @endif
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
                    </a>
                </div>
            @empty
                <div class="col-11 mx-auto" style="width: 91.66%">
                    <div class="card card-body border-0">
                        <div class="d-flex text-center mx-auto">
                            <p>
                                <img src="{{ asset('/frontend/think.svg') }}" alt="empty-img" class="" style="max-height: 300px; min-width: 300px">
                            </p>
                            <p class="text-danger text-center f-s-20 fw-bold p-5" style="margin-top: 75px">Sorry!! No Employee found.</p>
                        </div>

                    </div>
                </div>
            @endforelse

        </div>
    </div>

@endsection

@push('style')
    <style>
        .custom-select {
            max-width: 145px !important;
            min-width: 100px !important;
        }
        .select-box { padding: 1px 32px 1px 16px !important;}
    </style>
@endpush

@push('script')
    @include('common-resource-files.selectize')

{{--    <link rel="stylesheet" href="{{ asset('/frontend/employee/headerStyle.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('/frontend/employee/mainstyle.css') }}">
{{--    <script src="{{ asset('/frontend/employee/script.js') }}"></script>--}}
    <script>
        /* =================================================
   JOBS PAGE – FILTER DROPDOWNS (labels, payloads, UX)
   - Fixed to properly send array data to server
================================================= */
        window.addEventListener('DOMContentLoaded', function () {
            const filterWrapper = document.querySelector('.customWrapper');
            if (!filterWrapper) return; // page guard

            // Initialize all dropdown widgets
            document.querySelectorAll('.custom-select').forEach(initDropdown);

            // Clear All
            const clearBtn = document.getElementById('clearAllBtn');
            if (clearBtn) clearBtn.addEventListener('click', resetAllDropdowns);

            function initDropdown(dropdownEl) {
                const searchBar        = dropdownEl.querySelector('.searchBar');
                const panel            = dropdownEl.querySelector('.locationDropdown');
                const input            = dropdownEl.querySelector('.locationSearch');
                const dropdownMenu     = dropdownEl.querySelector('.dropdown-menu');
                const hiddenPayload    = dropdownEl.querySelector('.filter-payload');
                const filterKey        = dropdownEl.dataset.filterKey || 'filter';
                const placeholderText  = dropdownEl.dataset.placeholder || 'Select...';

                if (!panel || !input) return;

                // Initial UI: no default selection → show placeholder
                input.value = '';
                input.placeholder = placeholderText;
                input.classList.remove('select-boxCustom');

                // Toggle open/close
                input.addEventListener('click', () => {
                    const isOpen = panel.style.display === 'block';
                    document.querySelectorAll('.locationDropdown').forEach(dd => dd.style.display = 'none');
                    panel.style.display = isOpen ? 'none' : 'block';
                });

                // Search filter
                if (searchBar) {
                    searchBar.addEventListener('input', (e) => {
                        const q = e.target.value.toLowerCase();
                        dropdownEl.querySelectorAll('.checkbox-item').forEach(item => {
                            item.style.display = item.textContent.toLowerCase().includes(q) ? 'block' : 'none';
                        });
                    });
                }

                // Update selected labels + UI + hidden payload
                const updateSelected = () => {
                    const values = Array.from(dropdownEl.querySelectorAll('.locationCheckbox'))
                        .filter(cb => cb.checked)
                        .map(cb => cb.value)
                        .filter(Boolean);

                    // Get the LABELS from the checked checkboxes for the visible input field
                    const labels = Array.from(dropdownEl.querySelectorAll('.locationCheckbox'))
                        .filter(cb => cb.checked)
                        .map(cb => cb.nextElementSibling?.textContent?.trim() || '')
                        .filter(Boolean);

                    // Display text + active bg
                    if (labels.length) {
                        input.value = labels.join(', ');
                        input.classList.add('select-boxCustom');
                    } else {
                        input.value = '';
                        input.placeholder = placeholderText;
                        input.classList.remove('select-boxCustom');
                    }

                    // FIXED: Remove existing hidden inputs for this filter
                    const existingInputs = dropdownEl.querySelectorAll('input[type="hidden"][data-filter-value]');
                    existingInputs.forEach(inp => inp.remove());

                    // FIXED: Create separate hidden inputs for each selected value
                    // This allows Laravel to receive them as an array
                    if (values.length > 0) {
                        values.forEach(value => {
                            const hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = `filters[${filterKey}][]`; // Note the [] for array
                            hiddenInput.value = value;
                            hiddenInput.setAttribute('data-filter-value', 'true');
                            dropdownEl.appendChild(hiddenInput);
                        });
                    }

                    // Remove the old single hidden input if it exists
                    if (hiddenPayload) {
                        hiddenPayload.remove();
                    }

                    // Optional: live object & event for backend hooks
                    window.JOB_FILTERS = window.JOB_FILTERS || {};
                    window.JOB_FILTERS[filterKey] = labels;
                    document.dispatchEvent(new CustomEvent('filters:change', { detail: { ...window.JOB_FILTERS } }));
                };

                // Bind all checkboxes
                dropdownEl.querySelectorAll('.locationCheckbox')
                    .forEach(cb => cb.addEventListener('change', updateSelected));

                // Close when clicking outside
                window.addEventListener('click', (e) => {
                    if (!e.target.closest('.custom-select')) {
                        panel.style.display = 'none';
                    }
                });

                // Allow content to define height
                if (dropdownMenu) dropdownMenu.style.maxHeight = 'none';

                // Ensure clean start
                updateSelected();
            }

            function resetAllDropdowns() {
                document.querySelectorAll('.custom-select').forEach(dropdownEl => {
                    dropdownEl.querySelectorAll('.locationCheckbox').forEach(cb => (cb.checked = false));

                    // Remove all dynamic hidden inputs
                    dropdownEl.querySelectorAll('input[type="hidden"][data-filter-value]').forEach(inp => inp.remove());

                    const input = dropdownEl.querySelector('.locationSearch');
                    const placeholderText = dropdownEl.dataset.placeholder || 'Select...';
                    if (input) {
                        input.value = '';
                        input.placeholder = placeholderText;
                        input.classList.remove('select-boxCustom');
                    }

                    const panel = dropdownEl.querySelector('.locationDropdown');
                    if (panel) panel.style.display = 'none';
                });

                // Reset live object + event
                window.JOB_FILTERS = {};
                document.dispatchEvent(new CustomEvent('filters:change', { detail: {} }));
            }
        });
    </script>

@endpush
