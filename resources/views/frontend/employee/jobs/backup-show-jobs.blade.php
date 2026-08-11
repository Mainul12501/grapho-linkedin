@extends('frontend.employee.master')

@section('title', 'Show Jobs')

@section('body')

    <section class="bg-white">
        <div class="container customWrapper">
            <div class="fielterIcon me-2">
                <div>
                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/Filter.png" alt="" class="me-1" />
                    <span>Filters:</span>
                </div>
            </div>

            <div class="d-flex">
                <form action="" class="d-flex">

                    <span class="mx-1">
                        <div>
                            <label for="searchLocationType">Location Type</label>
                        </div>
                        <div>
                            <select name="job_location_type[]" multiple id="searchLocationType" class="select2 mx-1" style="width: 200px" data-placeholder="Select Location Type">
{{--                        <option value="" disabled selected>Select Location Type</option>--}}
                                @foreach($jobLocationTypes as $jobLocationType)
                                    <option value="{{ $jobLocationType->slug }}">{{ $jobLocationType->name }}</option>
                                @endforeach
                    </select>
                        </div>
                </span>
                    <span class="mx-1">
                        <label for="searchIndustry">Industry</label> <br>
                    <select name="industry[]" multiple id="searchIndustry" class="select2 mx-1" style="width: 200px" data-placeholder="Select Industry">
{{--                        <option value="" disabled selected>Select Industry</option>--}}
                        @foreach($industries as $industry)
                            <option value="{{ $industry->slug }}">{{ $industry->name }}</option>
                        @endforeach
                    </select>
                </span>
                    <span class="mx-1">
                        <label for="searchCompany">Company</label> <br>
                    <select name="company[]" multiple id="searchCompany" class="select2 ms-1" style="width: 200px" data-placeholder="Select Company">
{{--                        <option value="" disabled selected>Select Company</option>--}}
                        @foreach($companies as $company)
                            <option value="{{ $company->slug }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </span>
                    <span class="mx-1">
                        <label for="searchCompany">Search Job</label> <br>
                        <input type="text" name="search_text" class="form-control" />
                    </span>

                    <!-- Clear All Button -->
                    <button type="submit" class="clear-all-btn border-1 btn btn-outline-primary btn-sm" id="clearAllBtn">Filter</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="job-search-results">
        <div class="container">
            <!-- Job Listings and Details Section -->

            <!-- Search Results Header -->
            <div class="search-header my-3 jobSearchResultText">
                <h5>Showing {{ count($jobTasks) ?? 0 }} "Sales Jobs" results</h5>
            </div>

            <div class="job-listings-container d-flex">
                <!-- Left Side: List of Jobs -->
                <div class="job-options">
                    @foreach($jobTasks as $key => $jobTask)
                        <div class="job-card job-card-ajax" {{--onclick="showJobDetails(1)"--}} data-job-id="{{ $jobTask->id }}" id="job-{{ $key }}">
                            <div class="row">
                                <div class="col-2">
                                    <img src="{{ isset($jobTask?->employerCompany?->logo) ? asset($jobTask?->employerCompany?->logo) : asset('/frontend/employee/images/contentImages/jobCardLogo.png') }}" alt="{{ $jobTask->job_title }}" class="img-fluid" />
                                </div>
                                <div class="col-10">
                                    <h5>{{ $jobTask->job_title ?? 'Senior Officer, Corporate Banking' }}</h5>
                                    <p>{{ $jobTask?->employerCompany?->name ?? 'United Commercial Bank PLC' }}</p>
                                    <div class="job-type d-flex ">
                                        <span class="badge">{{ $jobTask?->jobType?->name ?? 'Full x Time' }}</span>
                                        <span class="badge">{{ $jobTask?->jobLocationType?->name ?? 'On-Site' }}</span>
{{--                                        <span class="badge">Day Shift</span>--}}
                                    </div>
                                    <p class="job-location mt-2">{{ $jobTask?->employerCompany?->address ?? 'Dhaka' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach


                    <!-- Repeat for more job cards with different IDs -->
{{--                    <div class="job-card" onclick="showJobDetails(2)" id="job-2">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-2">--}}
{{--                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/jobCardLogo.png" alt="" />--}}
{{--                            </div>--}}
{{--                            <div class="col-10">--}}
{{--                                <h5>Senior Officer, Corporate Banking</h5>--}}
{{--                                <p>United Commercial Bank PLC</p>--}}
{{--                                <div class="job-type d-flex justify-content-between">--}}
{{--                                    <span class="badge">Full Time</span>--}}
{{--                                    <span class="badge">On-Site</span>--}}
{{--                                    <span class="badge">Day Shift</span>--}}
{{--                                </div>--}}
{{--                                <p class="job-location mt-2">Gulshan, Dhaka</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <!-- Add more job cards as needed -->

{{--                    <div class="job-card" onclick="showJobDetails(3)" id="job-3">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-2">--}}
{{--                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/jobCardLogo.png" alt="" />--}}
{{--                            </div>--}}
{{--                            <div class="col-10">--}}
{{--                                <h5>Senior Officer, Corporate Banking</h5>--}}
{{--                                <p>United Commercial Bank PLC</p>--}}
{{--                                <div class="job-type d-flex justify-content-between">--}}
{{--                                    <span class="badge">Full Time</span>--}}
{{--                                    <span class="badge">On-Site</span>--}}
{{--                                    <span class="badge">Day Shift</span>--}}
{{--                                </div>--}}
{{--                                <p class="job-location mt-2">Gulshan, Dhaka</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="job-card" onclick="showJobDetails(4)" id="job-4">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-2">--}}
{{--                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/jobCardLogo.png" alt="" />--}}
{{--                            </div>--}}
{{--                            <div class="col-10">--}}
{{--                                <h5>Senior Officer, Corporate Banking</h5>--}}
{{--                                <p>United Commercial Bank PLC</p>--}}
{{--                                <div class="job-type d-flex justify-content-between">--}}
{{--                                    <span class="badge">Full Time</span>--}}
{{--                                    <span class="badge">On-Site</span>--}}
{{--                                    <span class="badge">Day Shift</span>--}}
{{--                                </div>--}}
{{--                                <p class="job-location mt-2">Gulshan, Dhaka</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>

                <!-- Right Side: Job Details (Initially Visible) -->
{{--                <div class="job-details" id="job-details">--}}
{{--                    <p>click any job to see details</p>--}}
{{--                </div>--}}

                <div class="job-details" id="" style="display: block;">
                    <div class="company-info">
                        <img src="{{ isset($singleJobTask?->employerCompany?->logo) ? asset($singleJobTask?->employerCompany?->logo) : asset('/frontend/employee/images/contentImages/jobCardLogo.png') }}" alt="{{ $singleJobTask?->employerCompany?->name ?? 'job-0' }}" class="company-logo">
                        <div class="company-details">
                            <h3>{{ $singleJobTask?->employerCompany?->name ?? 'company name' }}</h3>
                            <p>{{ $singleJobTask?->employerCompany?->address ?? 'company address' }}</p>
                        </div>
                    </div>
                    <h4 class="job-title">{{ $singleJobTask->job_title }}</h4>
                    <div class="job-type"><span class="badge">{{ $singleJobTask?->jobType?->name ?? 'job type' }}</span> <span class="badge">{{ $singleJobTask?->jobLocationType?->name ?? 'job location' }}</span> </div>
                    @if(!$isApplied)
                        <a href="javascript:void(0)" onclick="document.getElementById('applyJob{{ $singleJobTask->id }}').submit()" class="apply-btn" style="text-decoration: none;">Easy Apply</a>
                    @endif
                    @if(!$isSaved)
                        <button class="save-btn" data-job-id="{{ $singleJobTask->id }}"><img src="{{ asset('/') }}frontend/employee/images/contentImages/saveIcon.png" alt="Save Icon" class="save-icon"> Save</button>
                    @endif
                    <form action="{{ route('employee.apply-job', $singleJobTask->id) }}" method="post" id="applyJob{{ $singleJobTask->id }}">
                        @csrf
                    </form>


                    <h5 style="">About {{ $singleJobTask?->employerCompany?->name ?? 'company Name' }}</h5>
                    <p>{{ $singleJobTask?->employerCompany?->company_overview ?? 'company overview' }}</p>
                    <h5>Job Requirements</h5>
                    <div class="job-requirements">
                        {!! $singleJobTask->description ?? 'job description here' !!}
                    </div>
                </div>




            </div>
        </div>


        <!-- Easy Apply Modal -->
        <div class="easy-apply-modal" id="easyApplyModal">
            <div class="modal-content">
                <!-- Modal Image -->
                <div class="modal-header">
                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/notificationImage.png" alt="Company Logo" class="modal-image" />
                    <h2>Share your profile?</h2>
                </div>
                <!-- Modal Paragraph -->
                <p class="modal-description">
                    To apply, you need to share your profile with the company.
                </p>
                <!-- Modal Buttons -->
                <div class="modal-buttons">
                    <button class="share-profile-btn w-100 mb-2" onclick="shareProfile()">
                        Share my profile
                    </button>
                    <button class="cancel-btn w-100" onclick="closeEasyApplyModal()">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- Success Notification -->
        <div class="notification" id="notification">
            <div class="notification-content">
                <span class="checkmark"><img src="{{ asset('/') }}frontend/employee/images/contentImages/easyApplyNotificationIcon.png" alt="" /></span>
                You applied for the job: Senior Officer, Corporate Banking
                <span class="close-btn" onclick="closeNotification()"><img src="{{ asset('/') }}frontend/employee/images/contentImages/easyApplynotificationCloseIcon.png" alt="" /></span>
            </div>
        </div>
        <!-- easy apply modal -->
    </section>


@endsection


{{--Note: customize script js during printing dynamic data in this page--}}

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
                                    <div class="company-info">
                        <img src="${base_url+job.employer_company.logo}" alt="${job.employer_company.name}-logo" class="company-logo">
                        <div class="company-details">
                            <h3>${job.employer_company.name}</h3>
                            <p>${job.employer_company.address ?? 'Dhaka'}</p>
                        </div>
                    </div>
                    <h4 class="job-title">${job.job_title ?? 'Job Title'}</h4>
                    <div class="job-type"><span class="badge">${job.job_type.name}</span> <span class="badge">${job.job_location_type.name}</span> </div>
                    ${!response.isApplied ? `<a href="javascript:void(0)" onclick="document.getElementById('applyJob${ job.id }').submit()" class="apply-btn" style="text-decoration: none;">Easy Apply</a>` : ''}
                    ${!response.isSaved ? `<button class="save-btn" data-job-id="${job.id}"><img src="${base_url}frontend/employee/images/contentImages/saveIcon.png" alt="Save Icon" class="save-icon"> Save</button>` : ''}

                    <form action="${base_url}employee/apply-job/${job.id}" method="post" id="applyJob${job.id}">
                        <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">

                     </form>


                    <h5>About ${job.employer_company.name}</h5>
                    <p>${job.employer_company.company_overview}</p>
                    <h5>Job Requirements</h5>
                    <div class="job-requirements">${job.description}</ul>
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
    </script>
    <script>
        // Initialize dropdown and handle dynamic resizing
        function initDropdown(dropdownElement) {
            const searchBar = dropdownElement.querySelector(".searchBar");
            const locationDropdown =
                dropdownElement.querySelector(".locationDropdown");
            const locationSearch = dropdownElement.querySelector(".locationSearch");
            const dropdownMenu = dropdownElement.querySelector(".dropdown-menu");

            // Toggle dropdown on click
            locationSearch.addEventListener("click", () => {
                locationDropdown.style.display =
                    locationDropdown.style.display === "block" ? "none" : "block";
            });

            // Handle search input
            searchBar.addEventListener("input", (e) => {
                const query = e.target.value.toLowerCase();
                const items = dropdownElement.querySelectorAll(".checkbox-item");
                items.forEach((item) => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(query) ? "block" : "none";
                });
            });

            // Update input field when selections change
            const updateSelectedLocations = () => {
                const selectedLocations = [];
                const checkboxes =
                    dropdownElement.querySelectorAll(".locationCheckbox");
                checkboxes.forEach((checkbox) => {
                    if (checkbox.checked) {
                        selectedLocations.push(checkbox.nextElementSibling.textContent);
                    }
                });

                locationSearch.value =
                    selectedLocations.join(", ") || "Select an option";
            };

            const checkboxes =
                dropdownElement.querySelectorAll(".locationCheckbox");
            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener("change", updateSelectedLocations);
            });

            // Close dropdown when clicking outside
            window.addEventListener("click", (e) => {
                if (!e.target.closest(".custom-select")) {
                    locationDropdown.style.display = "none";
                }
            });

            // Dynamically resize the dropdown based on content
            dropdownMenu.style.maxHeight = "none";
        }

        // Reset all dropdowns to the selected values
        function resetAllDropdowns() {
            const checkboxes = document.querySelectorAll(".locationCheckbox");
            checkboxes.forEach((checkbox) => {
                checkbox.checked = false;
            });

            const locationSearchFields =
                document.querySelectorAll(".locationSearch");
            locationSearchFields.forEach((input) => {
                input.value = "Select an option"; // Reset to the placeholder or selected value
            });
        }

        // Event listener for "Clear All" button
        document
            .getElementById("clearAllBtn")
            .addEventListener("click", resetAllDropdowns);

        // Initialize all dropdowns
        const dropdowns = document.querySelectorAll(".custom-select");
        dropdowns.forEach(initDropdown);
    </script>
@endpush
