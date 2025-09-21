@extends('frontend.employee.master')

@section('title', 'Employee Home')

@section('body')
    <div class="container container-main mt-3">
        <aside class="left-panel p-3 col-md-3">
            <div class="card">
                <div class="card-body">
                    <img src="{{ asset(auth()->user()->profile_image ?? '/frontend/user-vector-img.jpg') }}" alt="Profile" class="rounded-circle mb-2" width="80" />
                    <h5>{{ auth()->user()->name ?? 'User' }}</h5>
                    <span class="badge d-flex align-items-center">
                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/Ellipse 1.png" alt="" class="me-2" />
                        {{ auth()->user()->is_open_for_hire == 1 ? 'Open to work' : 'Offline' }}
                    </span>
                    <p class="mt-2">
                        {{ auth()->user()->profile_title ?? 'User Bio' }}
                    </p>
                    <p class="mt-1">
                        {{ auth()->user()->address ?? 'User Address' }}
                    </p>
                    <div class="optionsInprofile">
                        <div class="options  border rounded">
                            <a href="{{ route('employee.my-saved-jobs') }}" style="text-decoration: none">
                                <div class="option-card">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="icon bookmark">
                                            <img src="{{ asset('/') }}frontend/employee/images/contentImages/bookmark-icon.png" alt="" />
                                        </div>
                                        <div>
                                            <div class="title">My saved jobs</div>
                                            <div class="subtitle text-dark"><span id="savedJobsNumber">{{ $totalSavedJobs }}</span> saved</div>
                                        </div>
                                    </div>

                                    <div class="arrow">
                                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/arrow-right 1.png" alt="" />
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('employee.my-applications') }}" style="text-decoration: none">
                                <div class="option-card">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="icon checkmark">
                                            <img src="{{ asset('/') }}frontend/employee/images/contentImages/checkmark-icon.png" alt="" />
                                        </div>
                                        <div>
                                            <div class="title">My applications</div>
                                            <div class="subtitle text-dark">{{ $totalAppliedApplications }} applications</div>
                                        </div>
                                    </div>

                                    <div class="arrow">
                                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/arrow-right 1.png" alt="" />
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('employee.my-profile-viewers') }}" style="text-decoration: none">
                                <div class="option-card">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="icon eye">
                                            <img src="{{ asset('/') }}frontend/employee/images/contentImages/eye-icon.png" alt="" />
                                        </div>
                                        <div>
                                            <div class="title">Profiler viewers</div>
                                            <div class="subtitle text-dark">{{ $totalViewedEmployers }} viewers</div>
                                        </div>
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
            @if(count($topJobsForEmployee) > 0)
                <div class="right-panel w-100" style="margin-top: 16px!important;">
                    <div class="rightPanelHeadinfo border-bottom">
                        <h2>Top job picks for you, {{ auth()->user()->name ?? 'User Name' }}!</h2>
                        <p>
                            Based on your profile, preferences, and activities like applies, searches, and saves
                        </p>
                    </div>

                    @foreach($topJobsForEmployee as $topJobForEmployee)
                        <div class="row jobCard border-bottom">
                            <div class="col-md-2 col-lg-1 pe-0">
                                <img src="{{ asset($topJobForEmployee?->employerCompany?->logo ?? '/frontend/company-vector.jpg') }}" alt="Company Logo" class="companyLogo img-fluid" style="height: 65px; border-radius: 50%;" />
                            </div>
                            <div class="col-md-10 col-lg-11">
                                <div class="jobPosition d-flex justify-content-between">
                                    <div class="d-flex">
                                        <img style="width: 40px; height: 42px" src="{{ asset($topJobForEmployee?->employerCompany?->logo ?? '/frontend/company-vector.jpg') }}"
                                             alt="Company Logo" class="mobileLogo" />

                                        <div class="paddingforMobile">
                                            <h3>{{ $topJobForEmployee->job_title  ?? 'Job Title' }}</h3>
                                            <p>{{ $topJobForEmployee?->employerCompany?->name ?? 'Company Name' }}</p>
                                        </div>
                                    </div>
{{--                                    <div class="dropdown">--}}
{{--                                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png" alt="Options" class="threeDot" role="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                                        <ul class="dropdown-menu dropdown-menu-end" style="">--}}
{{--                                            <li><a class="dropdown-item" href="{{ route('employee.save-job', $topJobForEmployee->id) }}">Save Job</a></li>--}}
{{--                                            <li><a class="dropdown-item" href="#">Share</a></li>--}}
{{--                                            <li><a class="dropdown-item" href="#">Report</a></li>--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="jobTypeBtn">
                                    <button class="btn">{{ $topJobForEmployee?->jobType?->name ?? 'Full Time' }}</button>
                                    <button class="btn">{{ $topJobForEmployee?->jobLocationType?->name ?? 'On Site' }}</button>
{{--                                    <button class="btn">Day Shift</button>--}}
                                </div>
                                <div class="jobDesc">
                                    <p>{!! $topJobForEmployee->employerCompany?->address ?? 'Dhaka' !!}</p>
                                    <p>{{ $topJobForEmployee->required_experience ?? 0 }} years of experience</p>
                                    <p>Salary: Tk. {{ $topJobForEmployee->salary_amount ?? 0 }}/{{ $topJobForEmployee->job_pref_salary_payment_type }}</p>
                                </div>
                                <div class="jobApply d-flex justify-content-between">
                                    <div>
                                        @if(!$topJobForEmployee['isApplied'])
                                            <form action="{{ route('employee.apply-job', $topJobForEmployee->id) }}" method="post" style="float: left">
                                                @csrf
                                                <button title="Apply Job" type="submit" class="btn flex-column show-apply-model" data-job-id="{{ $topJobForEmployee->id }}" data-job-company-logo="{{ asset($topJobForEmployee?->employerCompany?->logo) ?? '' }}">Easy Apply</button>
                                            </form>
                                        @endif

{{--                                        @if(!auth()->user()?->employeeSavedJobs->contains($topJobForEmployee->id))--}}
{{--                                            <img src="{{ asset('/') }}frontend/employee/images/contentImages/bookmark.png" alt="Bookmark" data-job-id="{{ $topJobForEmployee->id }}" class="bookmarkIcon save-btnx" />--}}
{{--                                        @endif--}}
{{--                                        @if(!auth()->user()?->employeeSavedJobs->contains($topJobForEmployee->id))--}}
                                            <img title="Save Job" src="{{ !auth()->user()?->employeeSavedJobs->contains($topJobForEmployee->id) ? asset('/frontend/employee/images/contentImages/bookmark.png') : 'https://cdn-icons-png.flaticon.com/512/3817/3817226.png' }}" alt="Bookmark" data-job-id="{{ $topJobForEmployee->id }}" style="max-height: 40px" class="bookmarkIcon {{ !auth()->user()?->employeeSavedJobs->contains($topJobForEmployee->id) ? 'save-btnx' : '' }}" />
{{--                                        @endif--}}
                                    </div>
{{--                                    <div>--}}
{{--                                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/closeIcon.png" alt="Close" class="closeIcon" />--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    @endforeach


                    <div class="seeAll">
                        <a href="{{ route('employee.show-jobs') }}">Show All
                            <img src="{{ asset('/') }}frontend/employee/images/contentImages/arrow-righttwo.png" alt="" class="ms-2" /></a>
                    </div>
                </div>
            @endif

            <div class="right-panel w-100 mb-5">
                <div class="rightPanelHeadinfo">
                    <h2>More jobs</h2>
                    <p>Jobs that people in your network are hiring for</p>
                </div>

                @foreach($moreJobsForEmployee as $topJobForEmployee)
                    <div class="row jobCard border-bottom">
                        <div class="col-md-2 col-lg-1 pe-0" style="border-radius: 50%">
                            <img src="{{ asset($topJobForEmployee?->employerCompany?->logo ?? '/frontend/employee/images/contentImages/companyLogoFor job.png') }}" alt="Company Logo" class="companyLogo" />
                        </div>
                        <div class="col-md-10 col-lg-11">
                            <div class="jobPosition d-flex justify-content-between">
                                <div class="d-flex">
                                    <img style="width: 40px; height: 42px" src="{{ asset($topJobForEmployee?->employerCompany?->logo ?? '/frontend/employee/images/contentImages/companyLogoFor job.png') }}"
                                         alt="Company Logo" class="mobileLogo" />

                                    <div class="paddingforMobile">
                                        <h3>{{ $topJobForEmployee->job_title  ?? 'Senior Officer, Corporate Banking' }}</h3>
                                        <p>{{ $topJobForEmployee?->employerCompany?->name ?? 'United Commercial Bank PLC' }}</p>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png" alt="Options" class="threeDot" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <ul class="dropdown-menu dropdown-menu-end" style="">
                                        <li><a class="dropdown-item" href="{{ route('employee.save-job', $topJobForEmployee->id) }}">Save Job</a></li>
                                        <li><a class="dropdown-item" href="#">Share</a></li>
                                        <li><a class="dropdown-item" href="#">Report</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="jobTypeBtn">
                                <button class="btn">{{ $topJobForEmployee?->jobType?->name ?? 'Full Time' }}</button>
                                <button class="btn">{{ $topJobForEmployee?->jobLocationType?->name ?? 'On Site' }}</button>
                                {{--                                    <button class="btn">Day Shift</button>--}}
                            </div>
                            <div class="jobDesc">
                                <p>{!! $topJobForEmployee->employerCompany?->address ?? 'Gulshan, Dhaka' !!}</p>
                                <p>{{ $topJobForEmployee->required_experience ?? 0 }} years of experience</p>
                                <p>Salary: Tk. {{ $topJobForEmployee->salary_amount ?? 0 }}/{{ $topJobForEmployee->job_pref_salary_payment_type }}</p>
                            </div>
                            <div class="jobApply d-flex justify-content-between">
                                <div>
                                    @if(!$topJobForEmployee['isApplied'])
                                        <form action="{{ route('employee.apply-job', $topJobForEmployee->id) }}" method="post" style="float: left">
                                            @csrf
                                            <button type="submit" title="Apply Job" class="btn flex-column show-apply-model" data-job-id="{{ $topJobForEmployee->id }}" data-job-company-logo="{{ asset($topJobForEmployee?->employerCompany?->logo) ?? '' }}">Easy Apply</button>
                                        </form>
                                    @endif
{{--                                    @if(!auth()->user()?->employeeSavedJobs->contains($topJobForEmployee->id))--}}
                                        <img title="Save Job" src="{{ auth()->user()?->employeeSavedJobs->contains($topJobForEmployee->id) ? 'https://cdn-icons-png.flaticon.com/512/3817/3817226.png' : asset('/frontend/employee/images/contentImages/bookmark.png') }}" alt="Bookmark" data-job-id="{{ $topJobForEmployee->id }}" style="max-height: 40px" class="bookmarkIcon ms-2 {{ !auth()->user()?->employeeSavedJobs->contains($topJobForEmployee->id) ? 'save-btnx' : '' }}" />
{{--                                    @endif--}}
                                </div>
                                {{--                                    <div>--}}
                                {{--                                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/closeIcon.png" alt="Close" class="closeIcon" />--}}
                                {{--                                    </div>--}}
                            </div>
                        </div>
                    </div>
                @endforeach


                <div class="seeAll">
                    <a href="{{ route('employee.show-jobs') }}">Show All
                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/arrow-righttwo.png" alt="" class="ms-2" /></a>
                </div>
            </div>
            <!-- Repeat job-card as needed -->
        </section>
    </div>
    <div class="easy-apply-modal" id="easyApplyModal">
        <div class="modal-content">
            <div class="modal-header">
{{--                <img src="images/contentImages/notificationImage.png" alt="Company Logo" class="modal-image" />--}}
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
@endsection

@push('style')
    <style>
        .save-btnx {
            border: 0px!important;

        }
        .apply-btn, .save-btnx {
            padding: 0px;
            margin: 0px 0px 0px 5px;
        }
        .companyLogo {width: 65px}
        .border {border: 2px solid #e5e7ebaf !important;}
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
    <script>
        $(document).on('click', '.save-btnx', function () {
            var jobId = $(this).attr('data-job-id');
            var thisObject = $(this);
            console.log(thisObject);
            sendAjaxRequest('employee/save-job/'+jobId, 'GET').then(function (response) {

                if (response.status == 'success')
                {
                    // thisObject.addClass('d-none');
                    thisObject.attr('src', 'https://cdn-icons-png.flaticon.com/512/3817/3817226.png');
                    sendAjaxRequest('employee/get-total-saved-jobs', 'GET').then(function (res) {
                        $('#savedJobsNumber').text(res);
                    })
                    toastr.success(response.msg);
                }
                else if (response.status == 'error')
                {
                    toastr.error(response.msg);
                }
            })
        })
    </script>
{{--    show and apply job modal--}}
    <script>
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
