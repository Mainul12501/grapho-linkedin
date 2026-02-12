@extends('frontend.employer.master')

@section('title', 'Company Profile')

@section('body')
    <div class="employeeSettings">

        <div class="container companyProfilecontainer mt-0 mt-md-3">
            <div class="row g-4">
                <!-- Left part -->
                <div class="col-md-4 col-12 text-break">
                    <div class="card d-flex flex-column  p-4 border rounded-3">
                        <div class="mb-3">
                            <img src="{{ asset( $companyDetails->logo ??  '/frontend/company-vector.jpg') }}" alt="{{ $companyDetails->name ?? 'company' }}-Logo" class="companyProfilecontainer__logo" />
                        </div>
                        <h5 class="fw-semibold mb-4">{{ $companyDetails->name ?? 'Company Name' }}</h5>

                        <div class="w-100">
                            <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="Location Icon" class="me-3" />
                                <div>
                                    <div class="fw-semibold small mb-1">Location</div>
                                    <div class="small text-muted">{!! $companyDetails->address ?? 'Dhaka, Bangladesh' !!}</div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile mail.png" alt="Email Icon" class="me-3" />
                                <div>
                                    <div class="fw-semibold small mb-1">Email</div>
                                    <a href="mailto:contact@gp.com" class="text-decoration-none small">{{ $companyDetails->email ?? 'email@company.com' }}</a>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile phone.png" alt="Phone Icon" class="me-3" />
                                <div>
                                    <div class="fw-semibold small mb-1">Phone</div>
                                    <div class="small text-muted">{{ $companyDetails->phone ?? '01600000000' }}</div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile website.png" alt="Website Icon" class="me-3" />
                                <div>
                                    <div class="fw-semibold small mb-1">Website</div>
                                    <a href="https://www.grameenphone.com" target="_blank" class="text-decoration-none small">{{ $companyDetails->website ?? '' }}</a>
                                </div>
                            </div>
                            @if($employerView)
                                <button class="btn btn-link p-0 mt-3 editButtonCompanyProfile" data-bs-toggle="modal" data-bs-target="#employerCompanyEditModal" style="font-size: 0.9rem;"> <img src="{{ asset('/') }}frontend/employer/images/employersHome/Edit pencil.png" alt=""> Edit contact info</button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right part -->
                <div class="col-md-8 col-12">
                    <div class="card">
                        <div class="d-flex justify-content-between align-items-center mb-3 companyProfilecontainer__topbar p-4 border-bottom">
                            <h6 class="mb-0 fw-semibold">Company overview</h6>
                            @if($employerView)
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#employerCompanyEditModal">Edit</button>
                            @endif
{{--                            @if(!$employerView)--}}
{{--                                <div class="text-warning">--}}
{{--                                    <a href="{{ route('twilio.view') }}" class="f-s-18" title="Video Call"><i class="fa-solid text-success fa-video"></i></a>--}}
{{--                                    <a href="{{ url('/chat/'.$companyDetails->id) }}" class="f-s-18" title="Send Message"><i class="fa-brands text-success fa-telegram"></i></a>--}}
{{--                                </div>--}}
{{--                            @endif--}}
                        </div>
                        <div class=" companyProfilecontainer__right-part pb-4 pt-1 px-4">
                            <div class="mb-4">
                                <div id="short-overview">

                                    {!! str()->words($companyDetails->company_overview, 25, '<span id="show-full-btn" style="color: #FFCB11; cursor: pointer">  View all</span>') ?? strip_tags('<p class="f-s-30">Company Overview Not found</p>') !!}
                                </div>
                                <div id="long-overview" style="display: none;">
                                    {!! $companyDetails->company_overview ?? strip_tags('<p class="f-s-30">Company Overview Not found</p>') !!} <span id="show-less-btn" style="color: #FFCB11; cursor: pointer"> ...View less</span>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-4 companyProfilecontainer__footer-info justify-content-between">
                                <div>
                                    <div class="fw-semibold">Industry</div>
                                    <div>{{ $companyDetails?->industry?->name ?? 'Telecommunication' }}</div>
                                </div>
                                <div>
                                    <div class="fw-semibold">Number of employees</div>
                                    <div>{{ $companyDetails->total_employees ?? 0 }}</div>
                                </div>
                                <div>
                                    <div class="fw-semibold">Founded on</div>
                                    <div>{{ $companyDetails->founded_on ?? '1971' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($_GET['view']) && $_GET['view'] == 'employer')
        <div class="row mt-3">
            <div class="col-10 mx-auto">
                <h3>{{ $companyDetails->name ?? '' }} Activities</h3>

                <!-- Job Cards -->
                <div class="row gy-3" id="item-container">
                    <!-- Job Card -->
                    @if(isset($paginatedData))
                        @include('frontend.employer.home.activity-content')
                    @endif

                    {{--                        <div class="col-12 text-center align-content-center">--}}
                    {{--                            @if(count($paginatedData) > 10)--}}
                    {{--                                {!! $paginatedData->links() !!}--}}
                    {{--                            @endif--}}
                    {{--                        </div>--}}

                    <div id="loader" class="text-center my-3" style="display:none;">
                        <img src="{{ asset('frontend/spinner.gif') }}" width="40"> Loading...
                    </div>

                    <div id="no-more-data" class="text-center my-2 text-muted" style="display:none;">
                        No more results
                    </div>


                </div>

            </div>
        </div>
    @endif

@endsection

@section('modal')
    <!-- modal -->
    <div class="modal fade" id="employerCompanyEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ trans('employer.edit_company_information') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('employer.update-company-info') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">{{ trans('employer.company_name') }}</label>
                                <input type="text" class="form-control" name="name" value="{{ $companyDetails->name ?? '' }}" placeholder="{{ trans('employer.enter_your_full_name') }}" >
                            </div>
                            <div class="col-md-6">
                                <label for="">{{ trans('common.email') }}</label>
                                <input type="text" class="form-control" name="email" value="{{ $companyDetails->email ?? '' }}" placeholder="{{ trans('employer.enter_your_email') }}" >
                            </div>
                            <div class="col-md-6">
                                <label for="">{{ trans('employer.mobile') }}</label>
                                <input type="text" class="form-control" name="phone" value="{{ $companyDetails->phone ?? '' }}" placeholder="{{ trans('employer.mobile') }}" >
                            </div>
                            <div class="col-md-6">
                                <label for="">{{ trans('common.website') }}</label>
                                <input type="text" class="form-control" name="website" value="{{ $companyDetails->website ?? '' }}" placeholder="{{ trans('common.website') }}" >
                            </div>
                        </div>
                        <div class="row mt-3">

                            <div class="col-md-6">
                                <label for="">{{ trans('employer.total_employees') }}</label>
                                <input type="text" class="form-control" name="total_employees" value="{{ $companyDetails->total_employees ?? '' }}" placeholder="{{ trans('employer.total_employees') }}" >
                            </div>
                            <div class="col-md-6">
                                <label for="">{{ trans('employer.founded_on') }}</label>
                                <input type="text" class="form-control" name="founded_on" value="{{ $companyDetails->founded_on ?? '' }}" placeholder="{{ trans('employer.founded_on') }}" >
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="selectCompanyCategory">{{ trans('employer.select_company_category') }}</label>
                                <select name="employer_company_category_id" id="selectCompanyCategory" class=" select2">
                                    <option value="">{{ trans('employer.select_industry') }}</option>
                                    @foreach ($employerCompanyCategories as $employerCompanyCategory)
                                        <option value="{{ $employerCompanyCategory->id }}" {{ $companyDetails->employer_company_category_id == $employerCompanyCategory->id ? 'selected' : '' }}>{{ $employerCompanyCategory->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="selectIndustry">{{ trans('employer.select_industry') }}</label>
                                <select name="industry_id" id="selectIndustry" class=" select2">
                                    <option value="">{{ trans('employer.select_industry') }}</option>
                                    @foreach ($industries as $industry)
                                        <option value="{{ $industry->id }}" {{ $companyDetails->industry_id == $industry->id ? 'selected' : '' }}>{{ $industry->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="setLogo">{{ trans('employer.logo') }}</label>
                                <div>
                                    <input type="file" name="logo" class="" accept="image/*" />

                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                @if(isset($companyDetails->logo))
                                    <img src="{{ asset($companyDetails->logo) }}" alt="Company Logo" placeholder="Enter Company Logo" class="img-fluid mt-2" style="max-height: 80px; max-width: 100px;">
                                @endif
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="companyOverview">{{ trans('employer.company_overview') }}</label>
                                <textarea name="company_overview" class="form-control summernote" id="" cols="30" rows="10">{!! $companyDetails->company_overview !!}</textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="">BIN Number</label>
                                <input type="text" class="form-control" name="bin_number" value="{{ $companyDetails->bin_number ?? '' }}" />
                            </div>
                            <div class="col-md-6">
                                <label for="">Trade License Number</label>
                                <input type="text" class="form-control" name="trade_license_number" value="{{ $companyDetails->trade_license_number ?? '' }}" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('common.save_changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal"  id="viewJobModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewJobModalTitle">View Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewJobModalBody">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal"  id="viewPostModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPostModalTitle">View Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewPostModalBody">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .companyProfilecontainer__contact-item img {
            width: 40px;
            height: 40px;
        }
    </style>
@endpush

@push('script')
    @include('common-resource-files.selectize')
    @include('common-resource-files.summernote')

{{--    profile info validate--}}
    <script>
        // Company Information Form Validation
        $(document).ready(function() {

            // Validate Company Edit Form on Submit
            $('#employerCompanyEditModal form').on('submit', function(e) {
                e.preventDefault();

                // Clear previous errors
                clearCompanyErrors();

                let isValid = true;
                let errors = [];

                // 1. Company Name - Required
                const nameInput = $(this).find('[name="name"]');
                const nameValue = nameInput.val().trim();

                if (!nameValue) {
                    showCompanyError(nameInput, 'Company name is required');
                    errors.push('Company name is required');
                    isValid = false;
                } else if (nameValue.length < 2) {
                    showCompanyError(nameInput, 'Company name must be at least 2 characters');
                    errors.push('Company name must be at least 2 characters');
                    isValid = false;
                }

                // 2. Email - Required and Valid Format
                const emailInput = $(this).find('[name="email"]');
                const emailValue = emailInput.val().trim();

                if (!emailValue) {
                    showCompanyError(emailInput, 'Email is required');
                    errors.push('Email is required');
                    isValid = false;
                } else {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailPattern.test(emailValue)) {
                        showCompanyError(emailInput, 'Please enter a valid email address');
                        errors.push('Invalid email format');
                        isValid = false;
                    }
                }

                // 3. Mobile - Bangladeshi Format (01XXXXXXXXX - 11 digits starting with 01)
                const mobileInput = $(this).find('[name="phone"]');
                const mobileValue = mobileInput.val().trim();

                if (mobileValue) {
                    // Check if mobile contains only digits
                    const onlyDigits = /^[0-9]+$/;
                    if (!onlyDigits.test(mobileValue)) {
                        showCompanyError(mobileInput, 'Mobile number must contain only digits (no text or special characters)');
                        errors.push('Invalid mobile format - only digits allowed');
                        isValid = false;
                    }
                    // Check Bangladeshi mobile format: starts with 01 and exactly 11 digits
                    else if (!mobileValue.startsWith('01')) {
                        showCompanyError(mobileInput, 'Mobile number must start with 01');
                        errors.push('Mobile must start with 01');
                        isValid = false;
                    } else if (mobileValue.length !== 11) {
                        showCompanyError(mobileInput, 'Mobile number must be exactly 11 digits');
                        errors.push('Mobile must be 11 digits');
                        isValid = false;
                    }
                    // Additional validation for valid BD operator prefixes
                    else {
                        const validPrefixes = ['013', '014', '015', '016', '017', '018', '019'];
                        const prefix = mobileValue.substring(0, 3);
                        if (!validPrefixes.includes(prefix)) {
                            showCompanyError(mobileInput, 'Invalid Mobile operator (must start with 013-019)');
                            errors.push('Invalid mobile operator prefix');
                            isValid = false;
                        }
                    }
                }

                // 4. BIN Number - Required
                const binInput = $(this).find('[name="bin_number"]');
                const binValue = binInput.val().trim();

                if (!binValue) {
                    showCompanyError(binInput, 'BIN Number is required');
                    errors.push('BIN Number is required');
                    isValid = false;
                } else if (!/^[0-9]+$/.test(binValue)) {
                    showCompanyError(binInput, 'BIN Number must contain only digits');
                    errors.push('BIN Number must contain only digits');
                    isValid = false;
                } else if (binValue.length < 6) {
                    showCompanyError(binInput, 'BIN Number must be at least 6 characters');
                    errors.push('Invalid BIN Number length');
                    isValid = false;
                }

                // 5. Trade License Number - Required
                const tradeInput = $(this).find('[name="trade_license_number"]');
                const tradeValue = tradeInput.val().trim();

                if (!tradeValue) {
                    showCompanyError(tradeInput, 'Trade License Number is required');
                    errors.push('Trade License Number is required');
                    isValid = false;
                } else if (!/^[0-9]+$/.test(tradeValue)) {
                    showCompanyError(tradeInput, 'Trade License Number must contain only digits');
                    errors.push('Trade License Number must contain only digits');
                    isValid = false;
                } else if (tradeValue.length < 6) {
                    showCompanyError(tradeInput, 'Trade License Number must be at least 6 characters');
                    errors.push('Invalid Trade License Number length');
                    isValid = false;
                }

                // 6. Website Validation (Optional but validated if provided)
                const websiteInput = $(this).find('[name="website"]');
                const websiteValue = websiteInput.val().trim();

                if (websiteValue) {
                    // Basic URL pattern validation
                    const urlPattern = /^(https?:\/\/)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)$/;
                    if (!urlPattern.test(websiteValue)) {
                        showCompanyError(websiteInput, 'Please enter a valid website URL');
                        errors.push('Invalid website URL');
                        isValid = false;
                    }
                }

                // 7. Total Employees Validation (Optional but must be number if provided)
                const employeesInput = $(this).find('[name="total_employees"]');
                const employeesValue = employeesInput.val().trim();

                if (employeesValue) {
                    if (isNaN(employeesValue) || parseInt(employeesValue) < 1) {
                        showCompanyError(employeesInput, 'Total employees must be a valid number greater than 0');
                        errors.push('Invalid total employees value');
                        isValid = false;
                    }
                }

                // 8. Company Category - Required
                const categoryInput = $(this).find('[name="employer_company_category_id"]');
                const categoryValue = categoryInput.val();

                if (!categoryValue) {
                    showCompanyError(categoryInput.next('.select2-container'), 'Please select a company category');
                    errors.push('Company category is required');
                    isValid = false;
                }

                // 9. Industry - Required
                const industryInput = $(this).find('[name="industry_id"]');
                const industryValue = industryInput.val();

                if (!industryValue) {
                    showCompanyError(industryInput.next('.select2-container'), 'Please select an industry');
                    errors.push('Industry is required');
                    isValid = false;
                }

                // 10. Logo Validation (Optional - check file type and size if uploaded)
                const logoInput = $(this).find('[name="logo"]');
                if (logoInput[0].files.length > 0) {
                    const file = logoInput[0].files[0];
                    const fileSize = file.size / 1024 / 1024; // Convert to MB
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];

                    if (!allowedTypes.includes(file.type)) {
                        showCompanyError(logoInput, 'Logo must be a valid image file (JPEG, PNG, GIF, WEBP)');
                        errors.push('Invalid logo file type');
                        isValid = false;
                    } else if (fileSize > 5) {
                        showCompanyError(logoInput, 'Logo must be less than 5MB');
                        errors.push('Logo file too large');
                        isValid = false;
                    }
                }

                // Show error summary if validation fails
                if (!isValid) {
                    displayCompanyErrorSummary(errors);

                    // Scroll to first error
                    const firstError = $('#employerCompanyEditModal .is-invalid').first();
                    if (firstError.length) {
                        $('#employerCompanyEditModal .modal-body').animate({
                            scrollTop: firstError.offset().top - $('#employerCompanyEditModal .modal-body').offset().top + $('#employerCompanyEditModal .modal-body').scrollTop() - 20
                        }, 500);
                    }

                    return false;
                }

                // ✅ All validations passed - submit the form
                this.submit();
            });

            // Real-time validation - clear errors on input
            $('#employerCompanyEditModal').on('input change', 'input, select, textarea', function() {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').remove();
                $(this).next('.select2-container').removeClass('is-invalid');
                $(this).next('.select2-container').siblings('.invalid-feedback').remove();
                $('.company-error-summary').remove();
            });

            // Clear errors when modal is closed
            $('#employerCompanyEditModal').on('hidden.bs.modal', function() {
                clearCompanyErrors();
            });

            // Real-time mobile number formatting
            $('#employerCompanyEditModal [name="phone"]').on('input', function() {
                // Remove any non-digit characters
                let value = $(this).val().replace(/\D/g, '');

                // Limit to 11 digits
                if (value.length > 11) {
                    value = value.substring(0, 11);
                }

                $(this).val(value);
            });

            // Total employees - only allow numbers
            $('#employerCompanyEditModal [name="total_employees"]').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                $(this).val(value);
            });
        });

        // Helper function to show error for company form
        function showCompanyError(element, message) {
            element.addClass('is-invalid');

            const errorDiv = $('<div class="invalid-feedback d-block"></div>').text(message);

            // Handle select2 elements differently
            if (element.hasClass('select2-container')) {
                element.after(errorDiv);
            } else {
                element.after(errorDiv);
            }
        }

        // Helper function to clear all errors in company form
        function clearCompanyErrors() {
            $('#employerCompanyEditModal .is-invalid').removeClass('is-invalid');
            $('#employerCompanyEditModal .invalid-feedback').remove();
            $('#employerCompanyEditModal .company-error-summary').remove();
        }

        // Display error summary at the top of modal body
        function displayCompanyErrorSummary(errors) {
            const summaryHtml = `
        <div class="alert alert-danger company-error-summary mb-3">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                ${errors.map(error => `<li>${error}</li>`).join('')}
            </ul>
        </div>
    `;

            $('#employerCompanyEditModal .modal-body').prepend(summaryHtml);
        }
    </script>

{{--    load contents on scroll--}}
    <script>
        let page = 1;
        let loading = false;
        let lastPage = {{ $paginatedData->lastPage() }};

        function loadMoreData() {
            if (loading || page >= lastPage) return;

            loading = true;
            page++;
            $("#loader").show();

            $.ajax({
                url: "?page=" + page+"&view=employer&employer_id={{ $companyDetails->id }}",
                type: "GET",
                success: function(res) {
                    if (res.empty) {
                        if (!$(".no-activity").length) {
                            $("#item-container").append(res.html);
                        }

                        $("#no-more-data").show();
                        page = lastPage;
                        return;
                    }

                    $("#item-container").append(res.html);


                },
                complete: function() {
                    loading = false;
                    $("#loader").hide();
                }
            });
        }

        // Detect scroll bottom
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() + 200 >= $(document).height()) {
                loadMoreData();
            }
        });
    </script>

{{--    show hide overview--}}
    <script>
        $(document).on('click', '#show-full-btn', function () {
            $('#short-overview').css('display', 'none');
            $('#long-overview').css('display', 'block');
        })
        $(document).on('click', '#show-less-btn', function () {
            $('#short-overview').css('display', 'block');
            $('#long-overview').css('display', 'none');
        })
    </script>
    <link rel="stylesheet" href="{{ asset('frontend/zoom-plugin/mbox.css') }}">
    <script src="{{ asset('frontend/zoom-plugin/mbox.min.js') }}"></script>
    <script>
        {{--var base_url = "{!! url('/') !!}/";--}}

        // let response;

        function sendAjaxRequest(url, method, data = {}) {
            return $.ajax({ // Return the Promise from $.ajax
                url: base_url + url,
                method: method,
                data: data
            })
                .done(function (data) { // .done() for success
                    // console.log(data.job.employer_company);
                    // console.log('print from dno');
                    // No need to assign to 'response' here, it's passed to .then()
                })
                .fail(function (error) { // .fail() for error
                    toastr.error(error);
                    // The error will also be propagated to the .catch() when called
                });
        }
        function showJobDetails(jobId, jobTitle = 'View Job Title') {
            sendAjaxRequest('get-job-details/'+jobId+'?render=1&show_apply=1', 'GET').then(function (response) {
                // console.log(response);
                $('#viewJobModalTitle').empty().append(jobTitle);
                $('#viewJobModalBody').empty().append(response);
                $('#viewJobModal').modal('show');
            })
        }
        function showPostDetails(postId, postTitle = 'View Post Title') {
            sendAjaxRequest('employee-view-post/'+postId+'?render=1', 'GET').then(function (response) {
                // console.log(response);
                $('#viewPostModalTitle').empty().append(postTitle);
                $('#viewPostModalBody').empty().append(response);
                $('.zoom-img').mBox();
                $('#viewPostModal').modal('show');
            })
        }
    </script>
    <style>
        .post-image-wrapper {
            height: 200px;
            overflow: hidden;
        }

        /* Single image */
        .single-post-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Grid layout */
        .image-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(2, 1fr);
            width: 100%;
            height: 100%;
            gap: 2px;
        }

        .grid-image-wrapper {
            width: 100%;
            height: 100%;
            overflow: hidden;
            position: relative;
            cursor: pointer;
        }

        .image-grid img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* +N overlay */
        .more-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            font-size: 26px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }

    </style>
@endpush
