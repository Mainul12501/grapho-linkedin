@extends('frontend.employee.master')

@section('title', 'Show Jobs')

@section('body')


    <!-- =========================================================
       FILTER BAR (All filters wrapped inside a single form)
       - Keeps layout flexible with your CSS (customWrapper)
       - Each filter block = label + readonly input + dropdown list + hidden payload
       ========================================================= -->
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
                    <span>Filters:</span>
                </div>
            </div>

            <!-- ===== Filter #1: Date posted ===== -->
            <div class="custom-select" data-filter-key="date_posted" data-placeholder="Most Recent">
{{--                <label class="custom-select-label">Date</label>--}}
                <input type="text" class="form-control select-box locationSearch" placeholder="Select..." readonly />
                <div class="dropdown-menu locationDropdown">
                    <input type="text" class="form-control search-box searchBar" placeholder="Search..." />
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="date24h" value="7" />
                        <label for="date24h">Most Recent</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="date15d" value="7" />
                        <label for="date15d">Last 15 days</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="date30d" value="30" />
                        <label for="date30d">Last 30 days</label>
                    </div>
                </div>
                <input type="hidden" class="filter-payload" name="filters[date_posted]" value="[]">
            </div>

            <!-- ===== Filter #2: Job type ===== -->
            <div class="custom-select" data-filter-key="company_type" data-placeholder="Job type">
{{--                <label class="custom-select-label">Job type</label>--}}
                <input type="text" class="form-control select-box locationSearch" placeholder="Select..." readonly />
                <div class="dropdown-menu locationDropdown">
                    <input type="text" class="form-control search-box searchBar" placeholder="Search..." />
                    @foreach($JobTypes as $JobType)
                        <div class="checkbox-item">
                            <input type="checkbox" class="locationCheckbox" id="ctype-{{ $JobType->slug }}" value="{{ $JobType->slug }}" />
                            <label for="ctype-{{ $JobType->slug }}">{{ $JobType->name }}</label>
                        </div>
                    @endforeach
                </div>
                <input type="hidden" class="filter-payload" name="filters[job_type]" value="[]">
            </div>

            <!-- ===== Filter #3: Location ===== -->
            <div class="custom-select" data-filter-key="location" data-placeholder="Location">
{{--                <label class="custom-select-label">Location</label>--}}
                <input type="text" class="form-control select-box locationSearch" placeholder="Select..." readonly />
                <div class="dropdown-menu locationDropdown">
                    <input type="text" class="form-control search-box searchBar" placeholder="Search..." />

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
            <div class="custom-select" data-filter-key="industry" data-placeholder="industry">
{{--                <label class="custom-select-label">Industry</label>--}}
                <input type="text" class="form-control select-box locationSearch" placeholder="Select..." readonly />
                <div class="dropdown-menu locationDropdown">
                    <input type="text" class="form-control search-box searchBar" placeholder="Search..." />
                    @foreach($industries as $industry)
                        <div class="checkbox-item">
                            <input type="checkbox" class="locationCheckbox" id="ind-{{ $industry->slug }}" value="{{ $industry->slug }}" />
                            <label for="ind-{{ $industry->slug }}">{{ $industry->name }}</label>
                        </div>

                    @endforeach
                </div>
                <input type="hidden" class="filter-payload" name="filters[industry]" value="[]">
            </div>

            <!-- ===== Filter #6: Job Workplace type ===== -->
            <div class="custom-select" data-filter-key="salary" data-placeholder="Job Nature">
{{--                <label class="custom-select-label">Job Nature</label>--}}
                <input type="text" class="form-control select-box locationSearch" placeholder="Select..." readonly />
                <div class="dropdown-menu locationDropdown">
                    <input type="text" class="form-control search-box searchBar" placeholder="Search..." />
                    @foreach($jobLocationTypes as $jobLocationType)
                        <div class="checkbox-item">
                            <input type="checkbox" class="locationCheckbox" id="jlt-{{ $jobLocationType->slug }}" value="{{ $jobLocationType->slug }}" />
                            <label for="jlt-{{ $jobLocationType->slug }}">{{ $jobLocationType->name }}</label>
                        </div>

                    @endforeach
                </div>
                <input type="hidden" class="filter-payload" name="filters[job_location_type]" value="[]">
            </div>

            <!-- Clear All button (resets the filter selections) -->
            <button type="button" class="clear-all-btn btn d-flex" style="border: 1px solid gray" id="clearAllBtn">Clear All</button>
            <button type="submit" class="clear-all-btn btn d-flex" style="border: 1px solid gray" id="clearAllBtn">Filter</button>
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
                <div class="job-options">
                    <!-- Header above results -->
                    <div class="search-header card border-0 py-3 jobSearchResultText border-end" style="">
                        <h5 class="p-l-20">Showing {{ count($jobTasks) ?? 0 }} results</h5>
                    </div>
                    <!-- Job card #1 -->
                    @forelse($jobTasks as $key => $jobTask)
                        <div class="job-card job-card-ajax {{ $singleJobTask->id == $jobTask->id ? 'active' : '' }}" onclick="setLetSideActiveJob({{ $key }})" data-job-id="{{ $jobTask->id }}" id="job-{{ $key }}">
                            <div class="row">
                                <div class="col-2">
                                    <img src="{{ isset($jobTask?->employerCompany?->logo) ? asset($jobTask?->employerCompany?->logo) : asset('/frontend/employee/images/contentImages/jobCardLogo.png') }}" alt="{{ $jobTask->job_title }}" class="img-fluid" />
                                </div>
                                <div class="col-10">
                                    <h5 class="mb-0">{{ $jobTask->job_title ?? 'Senior Officer, Corporate Banking' }}</h5>
                                    <p>{{ $jobTask?->employerCompany?->name ?? 'United Commercial Bank PLC' }}</p>
                                    <div class="job-type d-flex ">
                                        <span class="badge" style="background-color: lightgrey">{{ $jobTask?->jobType?->name ?? 'Full x Time' }}</span>
                                        <span class="badge" style="background-color: lightgrey">{{ $jobTask?->jobLocationType?->name ?? 'On-Site' }}</span>
                                        {{--                                        <span class="badge">Day Shift</span>--}}
                                    </div>
                                    <p class="job-location mt-2 mb-0">{{ $jobTask?->employerCompany?->address ?? 'Dhaka' }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="job-card"  style="min-height: 570px">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <p class="text-danger text-center">Sorry!! No Job Found.</p>
                                </div>
                            </div>
                        </div>
                    @endforelse

                </div>

                <!-- ---------- Right: Details panel (initial prompt) ---------- -->
                @if($foundData)
                    <div class="job-details" id="" style="display: block;">
                        <div class="company-info mb-2">
                            <img style="height: 40px; margin-right: 10px;" src="{{ isset($singleJobTask?->employerCompany?->logo) ? asset($singleJobTask?->employerCompany?->logo) : asset('/frontend/employee/images/contentImages/jobCardLogo.png') }}" alt="{{ $singleJobTask?->employerCompany?->name ?? 'job-0' }}" class="company-logo">
                            <div class="company-details d-flex pt-2" style="padding-top: 14px;">
                                <h3 class="p-t-5">{{ $singleJobTask?->employerCompany?->name ?? 'company name' }}</h3>
                                <span class="mx-1 p-t-5">,</span>
                                <p class="p-t-5">{{ $singleJobTask?->employerCompany?->address ?? 'company address' }}</p>
                            </div>
                        </div>
                        <h4 class="job-title mb-2">{{ $singleJobTask->job_title }}</h4>
                        <div class="job-type"><span class="badge">{{ $singleJobTask?->jobType?->name ?? 'job type' }}</span> <span class="badge">{{ $singleJobTask?->jobLocationType?->name ?? 'job location' }}</span> </div>
                        <div class="d-flex gap-2 mt-3 mb-4">
                            @if(!$isApplied)
                                <form class="apply-form" action="{{ route('employee.apply-job', $singleJobTask->id) }}" method="POST">
                                    @csrf
                                    {{--                            <input type="hidden" name="jobId" value="">--}}
                                    {{--                            <input type="hidden" name="jobTitle" value="Relationship Manager">--}}
                                    <div class="actions  mt-2">
                                        <button type="submit" class="apply-btn show-apply-model"  data-job-id="{{ $singleJobTask->id }}" data-job-company-logo="{{ asset($singleJobTask?->employerCompany?->logo) ?? '' }}">Easy Apply</button>
                                        {{--                                <button type="button" class="share-btn">Share profile</button>--}}
                                        {{--                                <button type="button" class="save-btn">--}}
                                        {{--                                    <img src="images/contentImages/saveIcon.png" alt="Save Icon" class="save-icon"> Save--}}
                                        {{--                                </button>--}}
                                    </div>
                                </form>
                                {{--                        <a href="javascript:void(0)" onclick="document.getElementById('applyJob{{ $singleJobTask->id }}').submit()" class="apply-btn" style="text-decoration: none;">Easy Apply</a>--}}
                            @endif
                            @if(!$isSaved)
                                <button class="save-btn" data-job-id="{{ $singleJobTask->id }}"><img src="{{ asset('/') }}frontend/employee/images/contentImages/saveIcon.png" alt="Save Icon" class="save-icon"> Save</button>
                            @endif
                        </div>

                        <h5 style="" class="fw-bold">About {{ $singleJobTask?->employerCompany?->name ?? 'company Name' }}</h5>
                        <p>{{ $singleJobTask?->employerCompany?->company_overview ?? 'company overview' }}</p>
                        <h5 class="fw-bold">Job Requirements</h5>
                        <div class="job-requirements ms-0">
                            {!! $singleJobTask->description ?? 'job description here' !!}
                        </div>
                    </div>
                @else
                    <div class="job-details" style="min-height: 570px">
                        <p class="text-danger text-center f-s-20 fw-bold">Sorry!! No job found.</p>
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
                    <h2>Share your profile?</h2>
                </div>
                <p class="modal-description">To apply, you need to share your profile with the company.</p>
                <div class="modal-buttons">
                    <form action="" method="post" id="applyShareForm">
                        @csrf
                        <button class="share-profile-btn w-100 mb-2" {{-- onclick="shareProfile()"--}} type="submit">Share My Profile</button>
                    </form>
                    <button class="cancel-btn w-100" onclick="closeEasyApplyModal()">Cancel</button>
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
                You applied for the job:
                <span id="appliedJobTitle">Senior Officer, Corporate Banking</span>
                <span class="close-btn" onclick="closeNotification()">
          <img src="{{ asset('/') }}frontend/employee/images/contentImages/easyApplynotificationCloseIcon.png" alt="" />
        </span>
            </div>
        </div>
    </section>



@endsection


{{--Note: customize script js during printing dynamic data in this page--}}
@push('style')
    <style>
        .custom-select {
            max-width: 160px !important;
            min-width: 130px !important;
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
    </style>
@endpush
@push('script')
    @include('common-resource-files.selectize')
    <script>
        $(document).on('click', '.job-card-ajax', function () {
            var jobId = $(this).attr('data-job-id');
            sendAjaxRequest('get-job-details/'+jobId, 'GET').then(function (response) {
                var job = response.job;
                const jobDetailsDiv = document.querySelector('.job-details');
                jobDetailsDiv.style.display = 'block';
                jobDetailsDiv.innerHTML = `
                                    <div class="company-info mb-2">
                        <img style="height: 40px; margin-right: 10px;" src="${base_url+job.employer_company.logo}" alt="${job.employer_company.name}-logo" class="company-logo">
                        <div class="company-details d-flex  pt-2" style="padding-top: 14px;">
                            <h3 class="p-t-5">${job.employer_company.name}</h3>
                            <span class="mx-1 p-t-5">,</span>
                            <p class="p-t-5">${job.employer_company.address ?? 'Dhaka'}</p>
                        </div>
                    </div>
                    <h4 class="job-title mb-2">${job.job_title ?? 'Job Title'}</h4>
                    <div class="job-type"><span class="badge">${job.job_type.name}</span> <span class="badge">${job.job_location_type.name}</span> </div>
                    <div class="d-flex gap-2  mb-4">
                        ${!response.isApplied ? `
                    <form class="apply-form " action="${base_url}employee/apply-job/${job.id}" method="POST">
<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
      <div class="actions  mt-2">
        <button type="submit" class="apply-btn show-apply-model" data-job-id="${job.id}" data-job-company-logo="${base_url+job.employer_company.logo}">Easy Apply</button>
      </div>
    </form>
                    ` : ''}
                    ${!response.isSaved ? `<button class="save-btn" data-job-id="${job.id}"><img src="${base_url}frontend/employee/images/contentImages/saveIcon.png" alt="Save Icon" title="Save Job" class="save-icon"> Save</button>` : ''}
                    </div>
                    <h5>About ${job.employer_company.name}</h5>
                    <p>${job.employer_company.company_overview}</p>
                    <h5>Job Requirements</h5>
                    <div class="job-requirements ms-0">${job.description}</ul>
                `;
            });

        })

        $(document).on('click', '.save-btn', function () {
            var jobId = $(this).attr('data-job-id');
            sendAjaxRequest('employee/save-job/'+jobId, 'GET').then(function (response) {
                // console.log(response);
                if (response.status == 'success')
                {
                    $(this).addClass('d-none');
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
@endpush
