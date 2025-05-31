@extends('frontend.employee.master')

@section('title', 'Employee Home')

@section('body')
    <div class="container container-main mt-3">
        <aside class="left-panel p-3">
            <div class="card">
                <div class="card-body">
                    <img src="{{ asset('/') }}frontend/employee/images/header images/Thumbnail.png" alt="Profile" class="rounded-circle mb-2" width="80" />
                    <h5>Mohammed Pranto</h5>
                    <span class="badge d-flex align-items-center"><img src="{{ asset('/') }}frontend/employee/images/contentImages/Ellipse 1.png" alt=""
                                                                       class="me-2" />
            Open to work</span>
                    <p class="mt-2">
                        Mobile App Developer, Flutter Developer Instructor & Mentor
                    </p>
                    <div class="optionsInprofile">
                        <div class="options">
                            <a href="{{ route('employee.my-saved-jobs') }}" style="text-decoration: none">
                                <div class="option-card">
                                    <div class="icon bookmark">
                                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/bookmark-icon.png" alt="" />
                                    </div>
                                    <div>
                                        <div class="title">My saved jobs</div>
                                        <div class="subtitle text-dark">23 saved</div>
                                    </div>
                                    <div class="arrow">
                                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/arrow-right 1.png" alt="" />
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('employee.my-applications') }}" style="text-decoration: none">
                                <div class="option-card">
                                    <div class="icon checkmark">
                                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/checkmark-icon.png" alt="" />
                                    </div>
                                    <div>
                                        <div class="title">My applications</div>
                                        <div class="subtitle text-dark">15 applications</div>
                                    </div>
                                    <div class="arrow">
                                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/arrow-right 1.png" alt="" />
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('employee.my-profile-viewers') }}" style="text-decoration: none">
                                <div class="option-card">
                                    <div class="icon eye">
                                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/eye-icon.png" alt="" />
                                    </div>
                                    <div>
                                        <div class="title">Profiler viewers</div>
                                        <div class="subtitle text-dark">37 viewers</div>
                                    </div>
                                    <div class="arrow">
                                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/arrow-right 1.png" alt="" />
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Right Scrollable Jobs -->
        <section class="w-100">
            <div class="right-panel w-100">
                <div class="rightPanelHeadinfo">
                    <h2>Top job picks for you, Pranto!</h2>
                    <p>
                        Based on your profile, preferences, and activity like applies,
                        searches, and saves
                    </p>
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
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png" alt="Options" class="threeDot" />
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
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/bookmark.png" alt="Bookmark" class="bookmarkIcon" />
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/closeIcon.png" alt="Close" class="closeIcon" />
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
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png" alt="Options" class="threeDot" />
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
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/bookmark.png" alt="Bookmark" class="bookmarkIcon" />
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/closeIcon.png" alt="Close" class="closeIcon" />
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
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png" alt="Options" class="threeDot" />
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
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/bookmark.png" alt="Bookmark" class="bookmarkIcon" />
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/closeIcon.png" alt="Close" class="closeIcon" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="seeAll">
                    <a href="">Show All
                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/arrow-righttwo.png" alt="" class="ms-2" /></a>
                </div>
            </div>

            <div class="right-panel w-100 mb-5">
                <div class="rightPanelHeadinfo">
                    <h2>More jobs</h2>
                    <p>Jobs that people in your network are hiring for</p>
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
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png" alt="Options" class="threeDot" />
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
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/bookmark.png" alt="Bookmark" class="bookmarkIcon" />
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/closeIcon.png" alt="Close" class="closeIcon" />
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
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png" alt="Options" class="threeDot" />
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
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/bookmark.png" alt="Bookmark" class="bookmarkIcon" />
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/closeIcon.png" alt="Close" class="closeIcon" />
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
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png" alt="Options" class="threeDot" />
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
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/bookmark.png" alt="Bookmark" class="bookmarkIcon" />
                            </div>
                            <div>
                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/closeIcon.png" alt="Close" class="closeIcon" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="seeAll">
                    <a href="">Show All
                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/arrow-righttwo.png" alt="" class="ms-2" /></a>
                </div>
            </div>
            <!-- Repeat job-card as needed -->
        </section>
    </div>
@endsection
