@extends('frontend.employee.master')

@section('title', 'My Saved Jobs')

@section('body')


    <section class="bg-white forSmall smallTop">
        <a href=""><img src="{{ asset('/') }}frontend/employee/images/profile/leftArrowDark.png" alt="" class="me-2"> Saved jobs</a>
    </section>

    <!-- Main Content -->
    <div class="container container-main mt-md-5 mt-2 ">
        <!-- Left Side Menu -->
        @include('frontend.employee.jobs.left-menu')


        <!-- Right Scrollable Jobs -->
        <section class="w-100 profileOptionRight">

            <h1 class="forLarge">Saved jobs</h1>
            <p class="">You have 12 saved jobs</p>

            <div class="right-panel w-100">
                @forelse()

                @empty
                    <div class="row">
                        <div class="col-12">
                            <span>No Saved Jobs Yet.</span>
                        </div>
                    </div>
                @endforelse
                <div class="row jobCard border-bottom">
                    <div class="col-md-1">
                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/companyLogoFor job.png" alt="Company Logo" class="companyLogo" />
                    </div>
                    <div class="col-md-11">
                        <div class="jobPosition d-flex justify-content-between">
                            <div class="d-flex">
                                <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/contentImages/companyLogoFor job.png"
                                     alt="Company Logo" class="mobileLogo" />

                                <div class="paddingforMobile">
                                    <h3>Senior Officer, Corporate Banking</h3>
                                    <p>United Commercial Bank PLC</p>
                                </div>
                            </div>
                            <div>
                                <div class="dropdown">
                                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png"
                                         alt="Options"
                                         class="threeDot"
                                         role="button"
                                         data-bs-toggle="dropdown"
                                         aria-expanded="false" />

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Save Job</a></li>
                                        <li><a class="dropdown-item" href="#">Share</a></li>
                                        <li><a class="dropdown-item" href="#">Report</a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="jobTypeBtn">
                            <button class="btn">Full Time</button>
                            <button class="btn">On-Site</button>
                            <button class="btn">Day Shift</button>
                        </div>
                        <div class="jobDesc">
                            <p>Gulshan, Dhaka</p>
                            <p>3+ years of experience</p>
                            <p>Salary: Tk. 3,00,000+</p>
                        </div>
                        <div class="jobApply d-flex justify-content-between">
                            <div>
                                <button class="btn">Easy Apply</button>
                                <img src="{{ asset('/') }}frontend/employee/images/profile/savedMarkIcon.png" alt="Bookmark" class="bookmarkIcon" />
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/closeIcon.png" alt="Close" class="closeIcon" data-bs-toggle="modal"
                                     data-bs-target="#closeConfirmModal" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row jobCard border-bottom">
                    <div class="col-md-1">
                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/companyLogoFor job.png" alt="Company Logo" class="companyLogo" />
                    </div>
                    <div class="col-md-11">
                        <div class="jobPosition d-flex justify-content-between">
                            <div class="d-flex">
                                <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/contentImages/companyLogoFor job.png"
                                     alt="Company Logo" class="mobileLogo" />

                                <div class="paddingforMobile">
                                    <h3>Senior Officer, Corporate Banking</h3>
                                    <p>United Commercial Bank PLC</p>
                                </div>
                            </div>
                            <div>
                                <div class="dropdown">
                                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png"
                                         alt="Options"
                                         class="threeDot"
                                         role="button"
                                         data-bs-toggle="dropdown"
                                         aria-expanded="false" />

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Save Job</a></li>
                                        <li><a class="dropdown-item" href="#">Share</a></li>
                                        <li><a class="dropdown-item" href="#">Report</a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="jobTypeBtn">
                            <button class="btn">Full Time</button>
                            <button class="btn">On-Site</button>
                            <button class="btn">Day Shift</button>
                        </div>
                        <div class="jobDesc">
                            <p>Gulshan, Dhaka</p>
                            <p>3+ years of experience</p>
                            <p>Salary: Tk. 3,00,000+</p>
                        </div>
                        <div class="jobApply d-flex justify-content-between">
                            <div>
                                <button class="btn">Easy Apply</button>
                                <img src="{{ asset('/') }}frontend/employee/images/profile/savedMarkIcon.png" alt="Bookmark" class="bookmarkIcon" />
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/closeIcon.png" alt="Close" class="closeIcon" data-bs-toggle="modal"
                                     data-bs-target="#closeConfirmModal" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row jobCard border-bottom">
                    <div class="col-md-1">
                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/companyLogoFor job.png" alt="Company Logo" class="companyLogo" />
                    </div>
                    <div class="col-md-11">
                        <div class="jobPosition d-flex justify-content-between">
                            <div class="d-flex">
                                <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/contentImages/companyLogoFor job.png"
                                     alt="Company Logo" class="mobileLogo" />

                                <div class="paddingforMobile">
                                    <h3>Senior Officer, Corporate Banking</h3>
                                    <p>United Commercial Bank PLC</p>
                                </div>
                            </div>
                            <div>
                                <div class="dropdown">
                                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png"
                                         alt="Options"
                                         class="threeDot"
                                         role="button"
                                         data-bs-toggle="dropdown"
                                         aria-expanded="false" />

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Save Job</a></li>
                                        <li><a class="dropdown-item" href="#">Share</a></li>
                                        <li><a class="dropdown-item" href="#">Report</a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="jobTypeBtn">
                            <button class="btn">Full Time</button>
                            <button class="btn">On-Site</button>
                            <button class="btn">Day Shift</button>
                        </div>
                        <div class="jobDesc">
                            <p>Gulshan, Dhaka</p>
                            <p>3+ years of experience</p>
                            <p>Salary: Tk. 3,00,000+</p>
                        </div>
                        <div class="jobApply d-flex justify-content-between">
                            <div>
                                <button class="btn">Easy Apply</button>
                                <img src="{{ asset('/') }}frontend/employee/images/profile/savedMarkIcon.png" alt="Bookmark" class="bookmarkIcon" />
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/closeIcon.png" alt="Close" class="closeIcon" data-bs-toggle="modal"
                                     data-bs-target="#closeConfirmModal" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="right-panel w-100">

                <div class="row jobCard border-bottom">
                    <div class="col-md-1">
                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/companyLogoFor job.png" alt="Company Logo" class="companyLogo" />
                    </div>
                    <div class="col-md-11">
                        <div class="jobPosition d-flex justify-content-between">
                            <div class="d-flex">
                                <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/contentImages/companyLogoFor job.png"
                                     alt="Company Logo" class="mobileLogo" />

                                <div class="paddingforMobile">
                                    <h3>Senior Officer, Corporate Banking</h3>
                                    <p>United Commercial Bank PLC</p>
                                </div>
                            </div>
                            <div>
                                <div class="dropdown">
                                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png"
                                         alt="Options"
                                         class="threeDot"
                                         role="button"
                                         data-bs-toggle="dropdown"
                                         aria-expanded="false" />

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Save Job</a></li>
                                        <li><a class="dropdown-item" href="#">Share</a></li>
                                        <li><a class="dropdown-item" href="#">Report</a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="jobTypeBtn">
                            <button class="btn">Full Time</button>
                            <button class="btn">On-Site</button>
                            <button class="btn">Day Shift</button>
                        </div>
                        <div class="jobDesc">
                            <p>Gulshan, Dhaka</p>
                            <p>3+ years of experience</p>
                            <p>Salary: Tk. 3,00,000+</p>
                        </div>
                        <div class="jobApply d-flex justify-content-between">
                            <div>
                                <button class="btn">Easy Apply</button>
                                <img src="{{ asset('/') }}frontend/employee/images/profile/savedMarkIcon.png" alt="Bookmark" class="bookmarkIcon" />
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/closeIcon.png" alt="Close" class="closeIcon" data-bs-toggle="modal"
                                     data-bs-target="#closeConfirmModal" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row jobCard border-bottom">
                    <div class="col-md-1">
                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/companyLogoFor job.png" alt="Company Logo" class="companyLogo" />
                    </div>
                    <div class="col-md-11">
                        <div class="jobPosition d-flex justify-content-between">
                            <div class="d-flex">
                                <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/contentImages/companyLogoFor job.png"
                                     alt="Company Logo" class="mobileLogo" />

                                <div class="paddingforMobile">
                                    <h3>Senior Officer, Corporate Banking</h3>
                                    <p>United Commercial Bank PLC</p>
                                </div>
                            </div>
                            <div>
                                <div class="dropdown">
                                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png"
                                         alt="Options"
                                         class="threeDot"
                                         role="button"
                                         data-bs-toggle="dropdown"
                                         aria-expanded="false" />

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Save Job</a></li>
                                        <li><a class="dropdown-item" href="#">Share</a></li>
                                        <li><a class="dropdown-item" href="#">Report</a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="jobTypeBtn">
                            <button class="btn">Full Time</button>
                            <button class="btn">On-Site</button>
                            <button class="btn">Day Shift</button>
                        </div>
                        <div class="jobDesc">
                            <p>Gulshan, Dhaka</p>
                            <p>3+ years of experience</p>
                            <p>Salary: Tk. 3,00,000+</p>
                        </div>
                        <div class="jobApply d-flex justify-content-between">
                            <div>
                                <button class="btn">Easy Apply</button>
                                <img src="{{ asset('/') }}frontend/employee/images/profile/savedMarkIcon.png" alt="Bookmark" class="bookmarkIcon" />
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/closeIcon.png" alt="Close" class="closeIcon" data-bs-toggle="modal"
                                     data-bs-target="#closeConfirmModal" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row jobCard border-bottom">
                    <div class="col-md-1">
                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/companyLogoFor job.png" alt="Company Logo" class="companyLogo" />
                    </div>
                    <div class="col-md-11">
                        <div class="jobPosition d-flex justify-content-between">
                            <div class="d-flex">
                                <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/contentImages/companyLogoFor job.png"
                                     alt="Company Logo" class="mobileLogo" />

                                <div class="paddingforMobile">
                                    <h3>Senior Officer, Corporate Banking</h3>
                                    <p>United Commercial Bank PLC</p>
                                </div>
                            </div>
                            <div>
                                <div class="dropdown">
                                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png"
                                         alt="Options"
                                         class="threeDot"
                                         role="button"
                                         data-bs-toggle="dropdown"
                                         aria-expanded="false" />

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Save Job</a></li>
                                        <li><a class="dropdown-item" href="#">Share</a></li>
                                        <li><a class="dropdown-item" href="#">Report</a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="jobTypeBtn">
                            <button class="btn">Full Time</button>
                            <button class="btn">On-Site</button>
                            <button class="btn">Day Shift</button>
                        </div>
                        <div class="jobDesc">
                            <p>Gulshan, Dhaka</p>
                            <p>3+ years of experience</p>
                            <p>Salary: Tk. 3,00,000+</p>
                        </div>
                        <div class="jobApply d-flex justify-content-between">
                            <div>
                                <button class="btn">Easy Apply</button>
                                <img src="{{ asset('/') }}frontend/employee/images/profile/savedMarkIcon.png" alt="Bookmark" class="bookmarkIcon" />
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/closeIcon.png" alt="Close" class="closeIcon" data-bs-toggle="modal"
                                     data-bs-target="#closeConfirmModal" />
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!-- Repeat job-card as needed -->
        </section>

    </div>


@endsection

@section('modal')

    <!-- Minimal Bootstrap Modal -->
    <div class="modal fade" id="closeConfirmModal" tabindex="-1" aria-labelledby="closeConfirmLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title" id="closeConfirmLabel">Are you sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Do you really want to close this job suggestion?
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Yes</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')

@endpush
