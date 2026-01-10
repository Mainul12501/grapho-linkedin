@extends('frontend.employee.master')

@section('title', 'Show Jobs')

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


    <!-- =========================================================
       FILTER BAR (All filters wrapped inside a single form)
       - Keeps layout flexible with your CSS (customWrapper)
       - Each filter block = label + readonly input + dropdown list + hidden payload
       ========================================================= -->
    <!-- Filters Wrapper -->
{{--    @include('frontend.employee.includes.show-job-filters')--}}
    <section class="bg-white border-bottom">
        <div class="container">
            <!-- Filters form -->
            <form
                id="jobFilters"
                class="customWrapper"
                method="GET"
                action=""
                data-autosubmit="true"
            ><!-- set to 'false' to disable auto submit -->
                <!-- Filters: label (icon + text) -->
                <div class="fielterIcon me-2">
                    <div>
                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/Filter.png" alt="" class="me-1" />
                        <span>{{ trans('common.filters') }}</span>
                    </div>
                </div>

                <!-- ===== Filter #1: Date posted ===== -->
                <div class="custom-select" data-filter-key="date_posted" style="max-width: 145px!important;" data-placeholder="{{ trans('common.most_recent') }}">
                    {{--                <label class="custom-select-label">Date</label>--}}
                    <input type="text" class="form-control select-box locationSearch" placeholder="{{ trans('common.search') }}" readonly />
                    <div class="dropdown-menu locationDropdown">
                        <input type="text" class="form-control search-box searchBar" placeholder="{{ trans('common.search') }}" />
                        <div class="checkbox-item">
                            <input type="checkbox" class="locationCheckbox" id="date24h" value="7"  {{ in_array("7", getSelectedFilters('date_posted')) ? 'checked' : '' }} />
                            <label for="date24h">{{ trans('common.most_recent') }}</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" class="locationCheckbox" id="date15d" value="15"  {{ in_array("15", getSelectedFilters('date_posted')) ? 'checked' : '' }} />
                            <label for="date15d">{{ trans('common.last_15_days') }}</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" class="locationCheckbox" id="date30d" value="30" {{ in_array("30", getSelectedFilters('date_posted')) ? 'checked' : '' }} />
                            <label for="date30d">{{ trans('common.last_30_days') }}</label>
                        </div>
                    </div>
                    <input type="hidden" class="filter-payload" name="filters[date_posted]" value="[]">
                </div>

                <!-- ===== Filter #2: Job type ===== -->
                <div class="custom-select" data-filter-key="company_type" style="max-width: 115px!important;" data-placeholder="{{ trans('common.job_type') }}">
                    {{--                <label class="custom-select-label">Job type</label>--}}
                    <input type="text" class="form-control select-box locationSearch" placeholder="{{ trans('common.search') }}" readonly />
                    <div class="dropdown-menu locationDropdown">
                        <input type="text" class="form-control search-box searchBar" placeholder="{{ trans('common.search') }}" />
                        @foreach($JobTypes as $JobType)
                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" id="ctype-{{ $JobType->slug }}" value="{{ $JobType->slug }}" {{ in_array($JobType->slug, getSelectedFilters('job_type')) ? 'checked' : '' }} />
                                <label for="ctype-{{ $JobType->slug }}">{{ $JobType->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" class="filter-payload" name="filters[job_type]" value="[]">
                </div>

                <!-- ===== Filter #3: Location ===== -->
                <div class="custom-select" data-filter-key="location" style="max-width: 112px!important;" data-placeholder="{{ trans('common.location') }}">
                    {{--                <label class="custom-select-label">Location</label>--}}
                    <input type="text" class="form-control select-box locationSearch" placeholder="{{ trans('common.search') }}" readonly />
                    <div class="dropdown-menu locationDropdown">
                        <input type="text" class="form-control search-box searchBar" placeholder="{{ trans('common.search') }}" />

                        <div class="checkbox-item"><input type="checkbox" value="Bagerhat" {{ in_array("Bagerhat", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Bagerhat" /> <label for="loc-Bagerhat">Bagerhat</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Bandarban" {{ in_array("Bandarban", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Bandarban" /> <label for="loc-Bandarban">Bandarban</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Barguna" {{ in_array("Barguna", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Barguna" /> <label for="loc-Barguna">Barguna</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Barisal" {{ in_array("Barisal", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Barisal" /> <label for="loc-Barisal">Barisal</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Bhola" {{ in_array("Bhola", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Bhola" /> <label for="loc-Bhola">Bhola</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Bogura" {{ in_array("Bogura", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Bogura" /> <label for="loc-Bogura">Bogura</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Brahmanbaria" {{ in_array("Brahmanbaria", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Brahmanbaria" /> <label for="loc-Brahmanbaria">Brahmanbaria</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Chandpur" {{ in_array("Chandpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Chandpur" /> <label for="loc-Chandpur">Chandpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Chapainawabganj" {{ in_array("Chapainawabganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Chapainawabganj" /> <label for="loc-Chapainawabganj">Chapainawabganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Chattogram" {{ in_array("Chattogram", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Chattogram" /> <label for="loc-Chattogram">Chattogram</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Chuadanga" {{ in_array("Chuadanga", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Chuadanga" /> <label for="loc-Chuadanga">Chuadanga</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Coxs Bazar" {{ in_array("Coxs Bazar", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Coxs-Bazar" /> <label for="loc-Coxs-Bazar">Cox's Bazar</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Cumilla" {{ in_array("Cumilla", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Cumilla" /> <label for="loc-Cumilla">Cumilla</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Dhaka" {{ in_array("Dhaka", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Dhaka" /> <label for="loc-Dhaka">Dhaka</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Dinajpur" {{ in_array("Dinajpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Dinajpur" /> <label for="loc-Dinajpur">Dinajpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Faridpur" {{ in_array("Faridpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Faridpur" /> <label for="loc-Faridpur">Faridpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Feni" {{ in_array("Feni", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Feni" /> <label for="loc-Feni">Feni</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Gaibandha" {{ in_array("Gaibandha", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Gaibandha" /> <label for="loc-Gaibandha">Gaibandha</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Gazipur" {{ in_array("Gazipur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Gazipur" /> <label for="loc-Gazipur">Gazipur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Gopalganj" {{ in_array("Gopalganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Gopalganj" /> <label for="loc-Gopalganj">Gopalganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Habiganj" {{ in_array("Habiganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Habiganj" /> <label for="loc-Habiganj">Habiganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Jamalpur" {{ in_array("Jamalpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Jamalpur" /> <label for="loc-Jamalpur">Jamalpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Jashore" {{ in_array("Jashore", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Jashore" /> <label for="loc-Jashore">Jashore</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Jhalokati" {{ in_array("Jhalokati", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Jhalokati" /> <label for="loc-Jhalokati">Jhalokati</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Jhenaidah" {{ in_array("Jhenaidah", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Jhenaidah" /> <label for="loc-Jhenaidah">Jhenaidah</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Joypurhat" {{ in_array("Joypurhat", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Joypurhat" /> <label for="loc-Joypurhat">Joypurhat</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Khagrachari" {{ in_array("Khagrachari", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Khagrachari" /> <label for="loc-Khagrachari">Khagrachari</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Khulna" {{ in_array("Khulna", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Khulna" /> <label for="loc-Khulna">Khulna</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Kishoreganj" {{ in_array("Kishoreganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Kishoreganj" /> <label for="loc-Kishoreganj">Kishoreganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Kurigram" {{ in_array("Kurigram", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Kurigram" /> <label for="loc-Kurigram">Kurigram</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Kushtia" {{ in_array("Kushtia", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Kushtia" /> <label for="loc-Kushtia">Kushtia</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Lakshmipur" {{ in_array("Lakshmipur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Lakshmipur" /> <label for="loc-Lakshmipur">Lakshmipur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Lalmonirhat" {{ in_array("Lalmonirhat", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Lalmonirhat" /> <label for="loc-Lalmonirhat">Lalmonirhat</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Madaripur" {{ in_array("Madaripur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Madaripur" /> <label for="loc-Madaripur">Madaripur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Magura" {{ in_array("Magura", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Magura" /> <label for="loc-Magura">Magura</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Manikganj" {{ in_array("Manikganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Manikganj" /> <label for="loc-Manikganj">Manikganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Meherpur" {{ in_array("Meherpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Meherpur" /> <label for="loc-Meherpur">Meherpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Moulvibazar" {{ in_array("Moulvibazar", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Moulvibazar" /> <label for="loc-Moulvibazar">Moulvibazar</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Munshiganj" {{ in_array("Munshiganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Munshiganj" /> <label for="loc-Munshiganj">Munshiganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Mymensingh" {{ in_array("Mymensingh", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Mymensingh" /> <label for="loc-Mymensingh">Mymensingh</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Naogaon" {{ in_array("Naogaon", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Naogaon" /> <label for="loc-Naogaon">Naogaon</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Narail" {{ in_array("Narail", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Narail" /> <label for="loc-Narail">Narail</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Narayanganj" {{ in_array("Narayanganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Narayanganj" /> <label for="loc-Narayanganj">Narayanganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Narsingdi" {{ in_array("Narsingdi", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Narsingdi" /> <label for="loc-Narsingdi">Narsingdi</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Natore" {{ in_array("Natore", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Natore" /> <label for="loc-Natore">Natore</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Netrokona" {{ in_array("Netrokona", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Netrokona" /> <label for="loc-Netrokona">Netrokona</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Nilphamari" {{ in_array("Nilphamari", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Nilphamari" /> <label for="loc-Nilphamari">Nilphamari</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Noakhali" {{ in_array("Noakhali", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Noakhali" /> <label for="loc-Noakhali">Noakhali</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Pabna" {{ in_array("Pabna", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Pabna" /> <label for="loc-Pabna">Pabna</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Panchagarh" {{ in_array("Panchagarh", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Panchagarh" /> <label for="loc-Panchagarh">Panchagarh</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Patuakhali" {{ in_array("Patuakhali", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Patuakhali" /> <label for="loc-Patuakhali">Patuakhali</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Pirojpur" {{ in_array("Pirojpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Pirojpur" /> <label for="loc-Pirojpur">Pirojpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Rajbari" {{ in_array("Rajbari", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Rajbari" /> <label for="loc-Rajbari">Rajbari</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Rajshahi" {{ in_array("Rajshahi", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Rajshahi" /> <label for="loc-Rajshahi">Rajshahi</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Rangamati" {{ in_array("Rangamati", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Rangamati" /> <label for="loc-Rangamati">Rangamati</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Rangpur" {{ in_array("Rangpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Rangpur" /> <label for="loc-Rangpur">Rangpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Satkhira" {{ in_array("Satkhira", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Satkhira" /> <label for="loc-Satkhira">Satkhira</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Shariatpur" {{ in_array("Shariatpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Shariatpur" /> <label for="loc-Shariatpur">Shariatpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Sherpur" {{ in_array("Sherpur", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Sherpur" /> <label for="loc-Sherpur">Sherpur</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Sirajganj" {{ in_array("Sirajganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Sirajganj" /> <label for="loc-Sirajganj">Sirajganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Sunamganj" {{ in_array("Sunamganj", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Sunamganj" /> <label for="loc-Sunamganj">Sunamganj</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Sylhet" {{ in_array("Sylhet", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Sylhet" /> <label for="loc-Sylhet">Sylhet</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Tangail" {{ in_array("Tangail", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Tangail" /> <label for="loc-Tangail">Tangail</label></div>
                        <div class="checkbox-item"><input type="checkbox" value="Thakurgaon" {{ in_array("Thakurgaon", getSelectedFilters('district')) ? 'checked' : '' }} class="locationCheckbox" id="loc-Thakurgaon" /> <label for="loc-Thakurgaon">Thakurgaon</label></div>

                    </div>
                    <input type="hidden" class="filter-payload" name="filters[district]" value="[]">
                </div>

                <!-- ===== Filter #4: Industry ===== -->
                <div class="custom-select" data-filter-key="industry" style="max-width: 110px!important;" data-placeholder="{{ trans('common.industry') }}">
                    {{--                <label class="custom-select-label">Industry</label>--}}
                    <input type="text" class="form-control select-box locationSearch" placeholder="{{ trans('common.search') }}" readonly />
                    <div class="dropdown-menu locationDropdown">
                        <input type="text" class="form-control search-box searchBar" placeholder="{{ trans('common.search') }}" />
                        @foreach($industries as $industry)
                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" id="ind-{{ $industry->slug }}" {{ in_array($industry->slug, getSelectedFilters('industry')) ? 'checked' : '' }} value="{{ $industry->slug }}" />
                                <label for="ind-{{ $industry->slug }}">{{ $industry->name }}</label>
                            </div>

                        @endforeach
                    </div>
                    <input type="hidden" class="filter-payload" name="filters[industry]" value="[]">
                </div>

                <!-- ===== Filter #6: Job Workplace type ===== -->
                <div class="custom-select" data-filter-key="salary" style="max-width: 132px!important;" data-placeholder="{{ trans('common.job_nature') }}">
                    {{--                <label class="custom-select-label">Job Nature</label>--}}
                    <input type="text" class="form-control select-box locationSearch" placeholder="{{ trans('common.search') }}" readonly />
                    <div class="dropdown-menu locationDropdown">
                        <input type="text" class="form-control search-box searchBar" placeholder="{{ trans('common.search') }}" />
                        @foreach($jobLocationTypes as $jobLocationType)
                            <div class="checkbox-item">
                                <input type="checkbox" class="locationCheckbox" {{ in_array($jobLocationType->slug, getSelectedFilters('job_location_type')) ? 'checked' : '' }} id="jlt-{{ $jobLocationType->slug }}" value="{{ $jobLocationType->slug }}" />
                                <label for="jlt-{{ $jobLocationType->slug }}">{{ $jobLocationType->name }}</label>
                            </div>

                        @endforeach
                    </div>
                    <input type="hidden" class="filter-payload" name="filters[job_location_type]" value="[]">
                </div>

                <!-- Clear All button (resets the filter selections) -->
                <div>
                    <button type="submit" class="clear-all-btn btn btn-sm border px-2 " style="border: 1px solid lightgrey!important;" id="saveBtn">{{ trans('common.search') }}</button>
                    <button type="button" class="clear-all-btn btn btn-sm border px-2" style="border: 1px solid lightgrey!important;" id="clearAllBtn">{{ trans('common.clear_all') }}</button>
                </div>

            </form>
        </div>
    </section>

    <!-- =========================================================
         RESULTS: Job list (left) + Details panel (right)
         ========================================================= -->
    <section class="job-search-results">
        <div class="container">


            <!-- Two-column layout container -->
            <div class="job-listings-container d-flex">

                <!-- ---------- Left: Job cards list ---------- -->
                <div class="job-options" id="job-options-container">
                    <!-- Header above results -->
                    <div class="search-header card border-0 py-3 jobSearchResultText border-end" style="">
                        <h5 class="p-l-20">{{ trans('common.showing_results') }} : {{ count($jobTasks) ?? 0 }} results</h5>
                    </div>
                    <!-- Job card #1 -->
                    <div id="job-list-container">
                        @forelse($jobTasks as $key => $jobTask)
                            <div  class="job-card job-card-ajax border-bottom {{ $singleJobTask->id == $jobTask->id ? 'active' : '' }}" onclick="setLetSideActiveJob({{ $key }})" data-job-id="{{ $jobTask->id }}" id="job-{{ $key }}">
                                <div class="row">
                                    <div class="col-2">
                                        {{--                                    <a href="{{ route('view-company-profile', $jobTask->employer_company_id) }}">--}}
                                        <img style="cursor: pointer" src="{{ isset($jobTask?->employerCompany?->logo) ? asset($jobTask?->employerCompany?->logo) : asset('/frontend/employee/images/contentImages/jobCardLogo.png') }}" alt="{{ $jobTask->job_title }}" class="img-fluid" />
                                        {{--                                    </a>--}}
                                    </div>
                                    <div class="col-10">
                                        <h5 class="mb-0 ">{{ $jobTask->job_title ?? trans('common.job_title') }}</h5>
                                        <p class="text-muted">
                                            {{--                                        <a href="{{ route('view-company-profile', $jobTask->employer_company_id) }}" class="text-muted nav-link">--}}
                                            {{ $jobTask?->employerCompany?->name ?? trans('common.company_name') }}
                                            {{--                                        </a>--}}
                                        </p>
                                        <div class="job-type d-flex text-muted">
                                            <span class="badge" style="background-color: #EDEFF2">{{ $jobTask?->jobType?->name ?? trans('common.full_time') }}</span>
                                            <span class="badge" style="background-color: #EDEFF2">{{ $jobTask?->jobLocationType?->name ?? trans('common.on_site') }}</span>
                                            {{--                                        <span class="badge">Day Shift</span>--}}
                                        </div>
                                        <p class="job-location mt-2 mb-0 text-muted">{{ $jobTask?->employerCompany?->address ?? trans('common.company_address') }}</p>
                                        <p class="job-location mt-2 show-only-mobile mb-0 text-muted">{{ $jobTask->required_experience ?? 0 }} years experience</p>
                                        <p class="job-location mt-2 show-only-mobile mb-0 text-muted">Salary: {{ $jobTask->salary_amount ?? 0 }}/{{ $jobTask->job_pref_salary_payment_type ?? 'month' }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="job-card"  style="min-height: 570px">
                                <div class="row">
                                    <div class="col-md-12 mx-auto">
                                        <div class="card card-body border-0">
                                            <div class="d-flex text-center">
                                                <p>
                                                    <img src="{{ asset('/frontend/think.svg') }}" alt="empty-img" class="" style="max-height: 300px; min-width: 300px">
                                                </p>
                                            </div>
                                            <p class="text-danger text-center f-s-20 fw-bold p-5" style="margin-top: 10px">{{ trans('common.sorry_no_job_found') }}</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                </div>
                <!-- Loading indicator -->
                <!-- Loading indicator - positioned absolutely -->
                <div id="loading-indicator" class="loading-overlay" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <!-- ---------- Right: Details panel (initial prompt) ---------- -->
                @if($foundData)
                    <div class="job-details" id="jobDetailsWithData" style="display: block; padding-left: 20px!important; margin-left: 20px!important; padding-bottom: 25px!important;">
                        <div class="company-info mb-2">
                            <a href="{{ route('view-company-profile', ['employerCompany' => $singleJobTask->employer_company_id, 'view' => 'employee']) }}">
                                <img style="height: 40px; margin-right: 10px; cursor: pointer" src="{{ isset($singleJobTask?->employerCompany?->logo) ? asset($singleJobTask?->employerCompany?->logo) : asset('/frontend/employee/images/contentImages/jobCardLogo.png') }}" alt="{{ $singleJobTask?->employerCompany?->name ?? 'job-0' }}" class="company-logo">
                            </a>
                            <div class="company-details d-flex pt-2" style="padding-top: 14px;">
                                <h3 class="p-t-5">
                                    <a href="{{ route('view-company-profile', ['employerCompany' => $singleJobTask->employer_company_id, 'view' => 'employee']) }}" class="text-muted nav-link">{{ $singleJobTask?->employerCompany?->name ?? trans('common.company_name') }}</a>
                                </h3>
                                <span class="mx-1 p-t-5">,</span>
                                <p class="p-t-5">{{ $singleJobTask?->employerCompany?->address ?? trans('common.company_address') }}</p>
                            </div>
                        </div>
                        <h4 class="job-title mb-2 f-s-19">{{ $singleJobTask->job_title }}</h4>
                        <div class="job-type"><span class="badge">{{ $singleJobTask?->jobType?->name ?? trans('common.job_type') }}</span> <span class="badge">{{ $singleJobTask?->jobLocationType?->name ?? trans('common.job_location') }}</span> </div>
                        <div class="d-flex gap-2 mt-1 mb-2">
                            @if(!$isApplied)
                                <form action="" method="post" class="apply-form">
                                    @csrf
                                    <div class="">
                                        <button style="padding: 8px 20px;" type="submit" class="apply-btn show-apply-model"  data-job-id="{{ $singleJobTask->id }}" data-job-company-logo="{{ asset($singleJobTask?->employerCompany?->logo) ?? '' }}">{{ trans('employee.easy_apply') }}</button>

                                    </div>
                                </form>
                                {{--                        <a href="javascript:void(0)" onclick="document.getElementById('applyJob{{ $singleJobTask->id }}').submit()" class="apply-btn" style="text-decoration: none;">Easy Apply</a>--}}
                            @else
                                <form action="" method="post" class="apply-form">
                                    <div class="">
                                        <button style="padding: 8px 20px;" type="submit" class="apply-btn " disabled >{{ trans('employee.applied') }}</button>

                                    </div>
                                </form>
                            @endif
                                @if(!$isSaved)
                                    <button style="padding: 6px 20px; background-color: #0d6efd; color: white" is-saved="no" class="save-btn btn btn-primary" data-job-id="{{ $singleJobTask->id }}"><img id="saveBtnImg{{ $singleJobTask->id }}" src="{{ asset('/frontend/employee/images/bookmark-white.png') }}" alt="Save Icon" class="save-icon"> <span id="saveBtnTxt{{ $singleJobTask->id }}">{{ trans('common.save') }}</span></button>
{{--                                @else--}}
{{--                                    <button style="padding: 6px 20px;" is-saved="yes" class="save-btn btn btn-primary" data-job-id="{{ $singleJobTask->id }}"><img id="saveBtnImg{{ $singleJobTask->id }}" src="{{ asset('/frontend/bookmark-circle.png') }}" style="height: 20px; width: 20px" alt="Save Icon" class=""> <span id="saveBtnTxt{{ $singleJobTask->id }}">{{ trans('common.saved') }}</span></button>--}}
                                @endif
                        </div>


                        <h5 style="" class="fw-bold">{{ trans('employer.about') }} {{ $singleJobTask?->employerCompany?->name ?? trans('common.company_name') }}</h5>
                        <p class="text-muted">{{ $singleJobTask?->employerCompany?->company_overview ?? trans('employer.company_overview') }}</p>
                        <h5 class="fw-bold">{{ trans('employer.job_requirements') }}</h5>
                        <div class="job-requirements ms-0 text-muted" style="color: gray">
                            {!! $singleJobTask->description ?? trans('employer.job_description_key_responsibilities') !!}
                        </div>
                    </div>
                @else
                    <div class="job-details" id="jobDetailsWithoutData" style="min-height: 570px">
                        <div class="row mt-5">
                            <div class="col-md-11 mx-auto">
                                <div class="card card-body border-0">
                                    <div class="d-flex text-center">
                                        <p>
                                            <img src="{{ asset('/frontend/think.svg') }}" alt="empty-img" class="" style="max-height: 300px; min-width: 300px">
                                        </p>
                                        <p class="text-danger text-center f-s-20 fw-bold p-5" style="margin-top: 75px">{{ trans('common.sorry_no_job_found') }}</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        <!-- =======================================================
             SHARE PROFILE MODAL (Easy Apply helper)
             - Keeps your existing modal structure & handlers
             ======================================================= -->
        <div class="easy-apply-modal" id="easyApplyModal">
            <div class="modal-content">
                <div class="modal-header">
{{--                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/notificationImage.png" alt="Company Logo" class="modal-image" />--}}
                    <div>
                        <div class="images-container">
                            <!-- User Profile Image -->
                            <img src="{{ asset( auth()->user()->profile_image ?? '/frontend/user-vector-img.jpg') }}" alt="Your Profile" class="user-image" />

                            <!-- Arrow Icon -->
                            <div class="arrow-icon">
                                <i class="fas fa-arrow-right"></i>
                            </div>

                            <!-- Company Logo -->
                            <img src="https://img.freepik.com/free-photo/horizontal-shot-handsome-young-guy-with-blue-eyes-bristle-has-positive-expression_273609-2960.jpg" alt="Company Logo" class="company-image" />
                        </div>
                    </div>
                    <h2>{{ trans('common.share_your_profile') }}</h2>
                </div>
                <p class="modal-description">{{ trans('common.to_apply_share_profile') }}</p>
                <div class="modal-buttons">
                    <form action="" method="post" id="applyShareForm">
                        @csrf
                        <button class="share-profile-btn w-100 mb-2" {{-- onclick="shareProfile()"--}} type="submit">{{ trans('common.share_my_profile') }}</button>
                    </form>
                    <button class="cancel-btn w-100" onclick="closeEasyApplyModal()">{{ trans('common.cancel') }}</button>
                </div>
            </div>
        </div>

        <!-- =======================================================
             APPLY SUCCESS TOAST (kept as-is per your page)
             ======================================================= -->
        <!-- Apply success toast -->
        <div class="notification" id="notification">
            <div class="notification-content">
        <span class="checkmark">
          <img src="{{ asset('/') }}frontend/employee/images/contentImages/easyApplyNotificationIcon.png" alt="" />
        </span>
                {{ trans('employee.you_applied_for_job') }}
                <span id="appliedJobTitle">Senior Officer, Corporate Banking</span>
                <span class="close-btn" onclick="closeNotification()">
          <img src="{{ asset('/') }}frontend/employee/images/contentImages/easyApplynotificationCloseIcon.png" alt="" />
        </span>
            </div>
        </div>
    </section>


{{--    modal for mobile view--}}
    <div class="modal fade" id="jobDeatilsForModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{--Job Details--}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="job-details" id="jobDeatilsForMobile">

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection


{{--Note: customize script js during printing dynamic data in this page--}}
@push('style')
    <style>
        .custom-select {
            max-width: 145px !important;
            min-width: 100px !important;
        }
        .job-options{margin-right: 0px}
        .job-details{padding: 20px 40px}
    </style>
    {{--    apply modal two image set--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .images-container {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: 1.5rem;
            height: 100px;
        }

        .user-image {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            background-color: white;
            position: relative;
            z-index: 3;
        }

        .company-image {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid white;
            background-color: white;
            position: relative;
            z-index: 1;
            margin-left: -25px;
        }

        .pill-shape {
            width: 60px;
            height: 30px;
            background: linear-gradient(135deg, #ff4757 0%, #ff3742 100%);
            border-radius: 15px;
            position: relative;
            overflow: hidden;
        }

        .pill-shape::before {
            content: '';
            position: absolute;
            top: 6px;
            left: 6px;
            width: 48px;
            height: 18px;
            background: linear-gradient(135deg, #ff6b7d 0%, #ff4757 100%);
            border-radius: 12px;
        }

        .arrow-icon {
            background-color: #ffd32a;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #000;
            position: absolute;
            z-index: 4;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            border: 2px solid white;
        }

        .modal-description {
            text-align: center;
            color: #6c757d;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .share-profile-btn {
            background-color: #0d6efd;
            border: none;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .share-profile-btn:hover {
            background-color: #0b5ed7;
        }

        .cancel-btn {
            background-color: transparent;
            border: 2px solid #dee2e6;
            color: #6c757d;
            padding: 10px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .cancel-btn:hover {
            border-color: #adb5bd;
            color: #495057;
        }
        .easy-apply-modal .modal-buttons button:hover {
            /*background-color: #0033a0;*/
            color: white;
        }
        .select-box { padding: 1px 32px 1px 16px !important;}
        .custom-select{max-width: 135px!important;}

        @media screen and (max-width: 768px) {
            .apply-btn, .save-btn {
                width: auto!important;
            }
            #jobDetailsWithData {display: none!important;};
            #jobDetailsWithoutData {display: none!important;};
        }
        @media screen and (min-width: 768px) {
            .job-options{
                /*max-height: calc(100vh - 200px);*/
                max-height: 600px;
                overflow-y: scroll;
                position: relative; /* Important for absolute positioning of loader */
            }
        }


        /*loading icon*/
        /* Loading overlay styles */
        .loading-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            text-align: center;
            z-index: 10;
            pointer-events: none; /* Allows scrolling through the overlay */
        }

        /* Alternative: Fixed at bottom of scrollable container */
        .loading-overlay-sticky {
            position: sticky;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            padding: 15px;
            text-align: center;
            z-index: 10;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }

        /*fix job details modal for mobile view*/
        .job-details{
            padding: 0px 5px!important;
            margin-top: 0px!important;
            box-shadow: none!important;
        }
    </style>


{{--    filter responsive codes--}}
    <style>
        .show-only-mobile {display: none}
        @media (max-width: 768px) {
            .customWrapper {
                 overflow-x: visible!important;
                flex-wrap: wrap;
                padding: 20px;
                /* margin-top: 15px; */
            }
            .show-only-mobile {
                display: block;
            }
        }
    </style>
@endpush
@push('script')
    @include('common-resource-files.selectize')
    <script>
        $(document).on('click', '.job-card-ajax', function () {
            var jobId = $(this).attr('data-job-id');
            sendAjaxRequest('get-job-details/'+jobId+'?render=1', 'GET').then(function (response) {
                console.log(response);
                if (window.innerWidth > 768)
                {
                    const jobDetailsDiv = document.querySelector('.job-details');
                    jobDetailsDiv.style.display = 'block';
                    jobDetailsDiv.innerHTML = response;
                } else {
                    const jobDetailsDiv = document.querySelector('#jobDeatilsForMobile');
                    jobDetailsDiv.style.display = 'block';
                    jobDetailsDiv.innerHTML = response;
                    $('#jobDeatilsForModal').modal('show');
                }

            });

        })

        $(document).on('click', '.save-btn', function () {
            var jobId = $(this).attr('data-job-id');
            var isSaved = $(this).attr('is-saved');
            if (isSaved == 'yes')
            {
                toastr.info('{{ trans('common.saved') }}');
                return;
            }
            sendAjaxRequest('employee/save-job/'+jobId, 'GET').then(function (response) {
                // console.log(response);
                if (response.status == 'success')
                {
                    $(this).attr('disabled', true);
                    $('#saveBtnImg'+jobId).attr('src', "{{ asset('/frontend/bookmark-circle.png') }}");
                    $('#saveBtnTxt'+jobId).text('{{ trans('common.saved') }}');
                    toastr.success(response.msg);
                }
                else if (response.status == 'error')
                {
                    toastr.error(response.msg);
                }
            })
        })

        // show apply job modal
        $(document).on('click', '.show-apply-model', function (){
            event.preventDefault();
            var applyModal = $('#easyApplyModal');
            var jobId = $(this).attr('data-job-id');
            var companyLogo = $(this).attr('data-job-company-logo');
            var applyFormUrl = base_url+'employee/apply-job/'+jobId;
            $('.company-image').attr('src', companyLogo);
            $('#applyShareForm').attr('action', applyFormUrl);
            applyModal.css({
                display: "flex"
            });
        })
    </script>

{{--    clear all event--}}
    <script>
        // Clear All
        const clearBtn = document.getElementById('clearAllBtn');
        if (clearBtn) clearBtn.addEventListener('click', resetAllDropdowns);

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
    </script>

{{--    auto append jobs in left menu--}}
    <script>
        let currentPage = 1;
        let isLoading = false;
        let hasMorePages = {{ $jobTasks->hasMorePages() ? 'true' : 'false' }};
        let jobCounter = {{ count($jobTasks) }};
        let observer;

        $(document).ready(function() {
            initInfiniteScroll();
        });

        function initInfiniteScroll() {
            // Create a sentinel element at the bottom
            const sentinel = $('<div id="scroll-sentinel" style="height: 1px;"></div>');
            $('#job-list-container').append(sentinel);

            // Configure Intersection Observer
            const options = {
                root: document.querySelector('#job-options-container'),
                rootMargin: '100px', // Trigger 100px before reaching the sentinel
                threshold: 0
            };

            observer = new IntersectionObserver(handleIntersection, options);
            observer.observe(document.getElementById('scroll-sentinel'));
        }

        function handleIntersection(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting && !isLoading && hasMorePages) {
                    loadMoreJobs();
                }
            });
        }

        function loadMoreJobs() {
            isLoading = true;
            $('#loading-indicator').show();

            // Get current filters and search params
            const urlParams = new URLSearchParams(window.location.search);
            const params = {
                page: currentPage + 1
            };

            // Add existing filters
            if (urlParams.has('search_text')) {
                params.search_text = urlParams.get('search_text');
            }

            if (urlParams.has('filters')) {
                params.filters = urlParams.get('filters');
            }

            $.ajax({
                url: '{{ route("employee.show-jobs") }}',
                type: 'GET',
                data: params,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.html) {
                        // Insert new jobs before the sentinel
                        $('#scroll-sentinel').before(response.html);

                        // Update state
                        currentPage = response.next_page;
                        hasMorePages = response.has_more;

                        // Update job counter
                        jobCounter += $(response.html).filter('.job-card').length;
                        $('#job-count').text(jobCounter);

                        // Re-bind click events if needed
                        bindJobCardEvents();

                        // If no more pages, remove observer
                        if (!hasMorePages) {
                            observer.disconnect();
                            $('#scroll-sentinel').remove();
                        }
                    }

                    $('#loading-indicator').hide();
                    isLoading = false;
                },
                error: function(xhr, status, error) {
                    console.error('Error loading more jobs:', error);
                    $('#loading-indicator').hide();
                    isLoading = false;
                }
            });
        }

        function bindJobCardEvents() {
            // Re-bind any event handlers for newly loaded job cards if necessary
            $('.job-card-ajax').off('click').on('click', function() {
                // Your existing click handler logic
                var jobId = $(this).attr('data-job-id');
                sendAjaxRequest('get-job-details/'+jobId+'?render=1', 'GET').then(function (response) {
                    console.log(response);
                    if (window.innerWidth > 768)
                    {
                        const jobDetailsDiv = document.querySelector('.job-details');
                        jobDetailsDiv.style.display = 'block';
                        jobDetailsDiv.innerHTML = response;
                    } else {
                        const jobDetailsDiv = document.querySelector('#jobDeatilsForMobile');
                        jobDetailsDiv.style.display = 'block';
                        jobDetailsDiv.innerHTML = response;
                        $('#jobDeatilsForModal').modal('show');
                    }

                });
            });
        }
    </script>
@endpush
