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

            <!-- First Dropdown -->
            <div class="custom-select">
                <input type="text" class="form-control select-box locationSearch" value="Most Recent" readonly />
                <div class="dropdown-menu locationDropdown">
                    <input type="text" class="form-control search-box searchBar" placeholder="Search location..." />
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="dhaka1" checked />
                        <label for="dhaka1">Last 24 hours</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="chittagong1" />
                        <label for="chittagong1">Last 7 days</label>
                    </div>
                </div>
            </div>

            <!-- Second Dropdown -->
            <div class="custom-select">
                <input type="text" class="form-control select-box locationSearch" value="Private Firm" readonly />
                <div class="dropdown-menu locationDropdown">
                    <input type="text" class="form-control search-box searchBar" placeholder="Search location..." />
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="dhaka2" checked />
                        <label for="dhaka2">Consulting Firms</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="chittagong2" />
                        <label for="chittagong2">Law Firms</label>
                    </div>
                </div>
            </div>

            <!-- Third Dropdown -->
            <div class="custom-select">
                <input type="text" class="form-control select-box locationSearch select-boxCustom" value="Dhaka" readonly />
                <div class="dropdown-menu locationDropdown">
                    <input type="text" class="form-control search-box searchBar" placeholder="Search location..." />
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="dhaka3" checked />
                        <label for="dhaka3">Dhaka</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="chittagong3" />
                        <label for="chittagong3">Chittagong</label>
                    </div>
                </div>
            </div>

            <!-- Fourth Dropdown -->
            <div class="custom-select">
                <input type="text" class="form-control select-box locationSearch select-boxCustom" value="Industry" readonly />
                <div class="dropdown-menu locationDropdown">
                    <input type="text" class="form-control search-box searchBar" placeholder="Search location..." />
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="dhaka4" checked />
                        <label for="dhaka4">Information Technology</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="chittagong4" />
                        <label for="chittagong4">Finance & Accounting</label>
                    </div>
                </div>
            </div>

            <!-- Fifth Dropdown -->
            <div class="custom-select">
                <input type="text" class="form-control select-box locationSearch" value="Company" readonly />
                <div class="dropdown-menu locationDropdown">
                    <input type="text" class="form-control search-box searchBar" placeholder="Search location..." />
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="dhaka5" checked />
                        <label for="dhaka5">Google</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="chittagong5" />
                        <label for="chittagong5">Microsoft</label>
                    </div>
                </div>
            </div>

            <!-- Sixth Dropdown -->
            <div class="custom-select">
                <input type="text" class="form-control select-box locationSearch" value="Salary" readonly />
                <div class="dropdown-menu locationDropdown">
                    <input type="text" class="form-control search-box searchBar" placeholder="Search location..." />
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="dhaka6" checked />
                        <label for="dhaka6">Below 20,000 BDT</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" class="locationCheckbox" id="chittagong6" />
                        <label for="chittagong6">20,000 - 50,000 BDT</label>
                    </div>
                </div>
            </div>

            <!-- Clear All Button -->
            <button class="clear-all-btn d-flex" id="clearAllBtn">Clear All</button>
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
                                    <img src="{{ isset($jobTask?->employerCompany?->logo) ? asset($jobTask?->employerCompany?->logo) : asset('/frontend/employee/images/contentImages/jobCardLogo.png') }}" alt="" />
                                </div>
                                <div class="col-10">
                                    <h5>{{ $jobTask->job_task ?? 'Senior Officer, Corporate Banking' }}</h5>
                                    <p>{{ $jobTask?->employerCompany?->name ?? 'United Commercial Bank PLC' }}</p>
                                    <div class="job-type d-flex justify-content-between">
                                        <span class="badge">{{ $jobTask?->jobType?->name ?? 'Full Time' }}</span>
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
                <div class="job-details" id="job-details">
                    <p>click any job to see details</p>
                </div>

{{--                <div class="job-details" id="job-details" style="display: block;">--}}
{{--                    <div class="company-info">--}}
{{--                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/jobCardLogo.png" alt="United Commercial Bank PLC Logo" class="company-logo">--}}
{{--                        <div class="company-details">--}}
{{--                            <h3>United Commercial Bank PLC</h3>--}}
{{--                            <p>Gulshan, Dhaka</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <h4 class="job-title">Senior Officer, Corporate Banking</h4>--}}
{{--                    <div class="job-type"><span class="badge">Full Time</span> <span class="badge">On-Site</span> <span class="badge">Day Shift</span></div>--}}
{{--                    <button class="apply-btn">Easy Apply</button>--}}
{{--                    <button class="save-btn"><img src="{{ asset('/') }}frontend/employee/images/contentImages/saveIcon.png" alt="Save Icon" class="save-icon"> Save</button>--}}
{{--                    <h5>About United Commercial Bank PLC</h5>--}}
{{--                    <p>Be part of the world’s most successful, purpose-led business...</p>--}}
{{--                    <h5>Job Requirements</h5>--}}
{{--                    <ul class="job-requirements"><li>Analyse internal data...</li><li>Work with media teams...</li><li>Create communication strategies...</li></ul>--}}
{{--                </div>--}}



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
    <script>
        $(document).on('click', '.job-card', function () {
            var jobId = $(this).attr('data-job-id');
            callAjaxRequest('get-job-details/'+jobId, 'GET').then(function (job) {
                console.log(job.employer_company);
                const jobDetailsDiv = document.querySelector('.job-details');
                jobDetailsDiv.style.display = 'block';
                jobDetailsDiv.innerHTML = `
      <div class="company-info">
        <img src="${job.employer_company.logo}" alt="${job.employer_company.name} Logo" class="company-logo">
        <div class="company-details">
          <h3>${job.employer_company.name}</h3>
          <p>${job.employer_company.address}</p>
        </div>
      </div>
      <h4 class="job-title">${job.job_title}</h4>
      <div class="job-type">${job.jobType.map(type => `<span class="badge">${type}</span>`).join(' ')}</div>
      <button class="apply-btn">${job.applyButtonText}</button>
      <button class="save-btn"><img src="${job.saveButtonIcon}" alt="Save Icon" class="save-icon"> Save</button>
      <h5>About ${job.companyName}</h5>
      <p>${job.description}</p>
      <h5>Job Requirements</h5>
      <ul class="job-requirements">${job.requirements.map(req => `<li>${req}</li>`).join('')}</ul>
    `;
                jobDetailsDiv.querySelector('.apply-btn').addEventListener('click', showEasyApplyModal);
            });

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
