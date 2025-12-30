<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Mazharul Islam" />
    <!-- Favicon -->
    <link rel="icon" href="images/Logo icon.png" type="image/x-icon" />
    <!-- Google Font: Geist -->
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Your Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/frontend/employer/style.css') }}" />
    <title>Company profile</title>
    <style>
        .companyProfilecontainer__contact-item img {
            height: 40px;
            width: 40px;
        }
    </style>
</head>

<body class=" employeeSettings">

<div class="container-fluid bg-white d-none d-md-block">
    <div class="row align-items-center py-3 border-bottom">
        <div class="col-auto pe-0">
            <a href="{{ url()->previous() }}" class="nav-link">
                <button type="button" class="btn p-0 d-flex align-items-center topSettingButton" aria-label="Back">
                    <img src="{{ asset('/frontend/employer/images/employersHome/leftarrow.png') }}" alt="" class="me-2">
                    <span >{{ $employerCompany->name ?? 'LikewiseBd' }}</span>
                </button>
            </a>
        </div>
    </div>
</div>


<div class="container companyProfilecontainer mt-0 mt-md-3">
    <div class="row g-4">
        <!-- Left part -->
        <div class="col-sm-3 col-12">
            <div class="card d-flex flex-column  p-4 border rounded-3">
                <div class="mb-3">
                    <img src="{{ asset( $employerCompany->logo ?? '/frontend/company-vector.jpg') }}" alt="Grameenphone Logo" class="companyProfilecontainer__logo" />
                </div>
                <h5 class="fw-semibold mb-4">{{ $employerCompany->name ?? 'Company Name' }}</h5>

                <div class="w-100">
                    <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="Location Icon" class="me-3" />
                        <div>
                            <div class="fw-semibold small mb-1">Location</div>
                            <div class="small text-muted">{{ $employerCompany->address ?? 'Company Location' }}</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile mail.png" alt="Email Icon" class="me-3" />
                        <div>
                            <div class="fw-semibold small mb-1">Email</div>
                            <a href="mailto:contact@gp.com" class="text-decoration-none small">{{ $employerCompany->email ?? 'Company Email' }}</a>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile phone.png" alt="Phone Icon" class="me-3" />
                        <div>
                            <div class="fw-semibold small mb-1">Phone</div>
                            <div class="small text-muted">{{ $employerCompany->phone ?? 'Company Phone' }}</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile website.png" alt="Website Icon" class="me-3" />
                        <div>
                            <div class="fw-semibold small mb-1">Website</div>
                            <a href="https://www.grameenphone.com" target="_blank" class="text-decoration-none small">{{ $employerCompany->website ?? 'Company Website' }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right part -->
        <div class="col-sm-9">
            <div class="card">
                <div class="d-flex justify-content-between align-items-center mb-3 companyProfilecontainer__topbar p-4">
                    <h6 class="mb-0 fw-semibold">{{ trans('employer.company_overview') }}</h6>
                </div>
                <div class=" companyProfilecontainer__right-part p-4 overview-height" >
                    <div class="mb-4 text-muted">
{{--                        {!!  $employerCompany->company_overview ?? 'Company Overview' !!}--}}
                        <div id="short-overview">

                            {!! str()->words($employerCompany->company_overview, 25, '<span id="show-full-btn" style="color: #FFCB11; cursor: pointer">  View all</span>') ?? strip_tags('<p class="f-s-30">Company Overview Not found</p>') !!}
                        </div>
                        <div id="long-overview" style="display: none;">
                            {!! $employerCompany->company_overview ?? strip_tags('<p class="f-s-30">Company Overview Not found</p>') !!} <span id="show-less-btn" style="color: #FFCB11; cursor: pointer"> ...View less</span>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-4 companyProfilecontainer__footer-info justify-content-between">
                        <div>
                            <div class="fw-semibold">{{ trans('common.industry') }}</div>
                            <div>{{ $employerCompany?->industry?->name ?? 'Industry Name' }}</div>
                        </div>
                        <div>
                            <div class="fw-semibold">{{ trans('employer.total_employees') }}</div>
                            <div>{{ $employerCompany->total_employees ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="fw-semibold">{{ trans('employer.founded_on') }}</div>
                            <div>{{ $employerCompany->founded_on ?? '1971' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


{{--    activities--}}
    <div class="row mt-3">
        <div class="col-12 col-md-9 mx-auto-custom ms-auto">
            <h3>{{ $employerCompany->name ?? '' }} Activities</h3>

            <!-- Job Cards -->
            <div class="row gy-3" id="item-container">
                <!-- Job Card -->
                @if(isset($paginatedData))
                    @include('frontend.employer.home.activity-content')
                @endif

                <div id="loader" class="text-center my-3" style="display:none;">
                    <img src="{{ asset('frontend/spinner.gif') }}" width="40"> Loading...
                </div>
                <div id="no-more-data" class="text-center my-2 text-muted" style="display:none;">
                    No more results
                </div>
            </div>
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

<style>
    .apply-btn, .save-btn {
        padding: 12px 20px;
        margin: 10px 0;
        background-color: #ffcb11;
        border: none;
        border-radius: 16px;
        cursor: pointer;
        display: inline-block;
        font-weight: 600;
        font-size: 18px;
        line-height: 150%;
        letter-spacing: -1%;
        text-align: center;
        color: #141c25;
    }
    .save-icon {
        width: 20px;
        height: 20px;
        margin-right: 10px;
        vertical-align: middle;
        color: white!important;
    }
    .font-white {color: white!important;}
    /* Post card responsive styles */
    .post-card-container {
        max-height: none;
        overflow: hidden;
    }

    .post-card-image {
        width: 100%;
        height: auto;
        max-height: none;
        object-fit: cover;
        border-radius: 0.375rem 0.375rem 0 0 !important;
    }

    /* Mobile-specific padding */
    @media screen and (max-width: 767px) {
        .post-card-container .py-3 {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }

        .post-card-container h3 {
            font-size: 1.25rem;
        }
    }

    /* Desktop styles - horizontal layout */
    @media screen and (min-width: 768px) {
        .post-card-container {
            max-height: 200px;
        }

        .post-card-image {
            height: 200px;
            max-height: 200px;
            border-radius: 0.375rem 0 0 0.375rem !important;
        }
    }

    @media screen and (max-width: 991px){
        .mx-auto-custom {
            margin-left: auto!important;
            margin-right: auto!important;
        }
    }

    @media screen and (min-width: 991px){
        .overview-height {min-height: 350px!important;}
    }
</style>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Bootstrap Bundle JS (with Popper)  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Your Custom JS -->
<script src="{{ asset('/frontend/employee/script.js') }}"></script>
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
    $(document).ready(function () {
        $('.zoom-img').mBox();
    });
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
<script>
    var base_url = "{!! url('/') !!}/";

    let response;

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

</body>
</html>
