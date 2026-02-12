@extends('frontend.employee.master')

@section('title', 'My Saved Jobs')

@section('body')


    <section class="bg-white forSmall smallTop">
        <a href="{{ route('employee.my-profile') }}"><img src="{{ asset('/') }}frontend/employee/images/profile/leftArrowDark.png" alt="" class="me-2"> {{ trans('employee.jobs_saved') }}</a>
    </section>

    <!-- Main Content -->
    <div class="container container-main mt-md-5 mt-2 ">
        <!-- Left Side Menu -->
        @include('frontend.employee.jobs.left-menu')


        <!-- Right Scrollable Jobs -->
        <section class="w-100 profileOptionRight">

            <h1 class="forLarge">{{ trans('employee.jobs_saved') }}</h1>
            <p class="">{{ trans('employee.you_have_applied_to_jobs', ['count' => count($savedJobs) ?? 0]) }}</p>

            <div class="right-panel w-100">
                @forelse($savedJobs as $key => $savedJob)
                    <div class="row jobCard border-bottom">
                        <div class="col-md-1">
                            <img src="{{ asset(isset($savedJob?->employerCompany?->logo) ? $savedJob?->employerCompany?->logo : '/frontend/company-vector.jpg') }}" style="height: 65px; border-radius: 50%;" alt="Company Logo" class="companyLogo" />
                        </div>
                        <div class="col-md-11">
                            <div class="jobPosition d-flex justify-content-between">
                                <div class="d-flex">
                                    <img style="width: 40px; height: 42px" src="{{ asset(isset($savedJob?->employerCompany?->logo) ? $savedJob?->employerCompany?->logo : '/frontend/company-vector.jpg') }}"
                                         alt="Company Logo" class="mobileLogo" />
                                    <div class="paddingforMobile">
                                        <h3><a href="{{ route('employee.show-jobs', ['job_task' => $savedJob->id]) }}" style="text-decoration: none; color: black">{{ $savedJob->job_title ?? trans('common.job_title') }}</a></h3>
                                        <p>{{ $savedJob->employerCompany?->name ?? trans('common.company_name') }}</p>
                                    </div>
                                </div>
                                <div>
{{--                                    <div class="dropdown">--}}
{{--                                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png"--}}
{{--                                             alt="Options"--}}
{{--                                             class="threeDot"--}}
{{--                                             role="button"--}}
{{--                                             data-bs-toggle="dropdown"--}}
{{--                                             aria-expanded="false" />--}}

{{--                                        <ul class="dropdown-menu dropdown-menu-end">--}}
{{--                                            <li><a class="dropdown-item" href="#">Save Job</a></li>--}}
{{--                                            <li><a class="dropdown-item" href="#">Share</a></li>--}}
{{--                                            <li><a class="dropdown-item" href="#">Report</a></li>--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
                                    <div>
                                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/closeIcon.png" data-job-id="{{ $savedJob->id }}" alt="Close" class="closeIcon" />
                                    </div>
                                </div>
                            </div>
                            <div class="jobTypeBtn">
                                <button class="btn">{{ $savedJob?->jobType?->name ?? trans('common.job_type') }}</button>
                                <button class="btn">{{ $savedJob?->jobLocationType?->name ?? trans('common.job_location') }}</button>
{{--                                <button class="btn">Day Shift</button>--}}
                            </div>
                            <div class="jobDesc">
                                <p>{{ $savedJob?->employerCompany?->address ?? trans('common.company_address') }}</p>
                                <p>{{ $savedJob->required_experience ?? 0 }}+ {{ trans('employee.years_of_experience') }}</p>
                                @if(isset($savedJob->salary_range_start))
                                    <p>{{ trans('employee.salary') }}: Tk. {{ $savedJob->salary_range_start }} - {{ $savedJob->salary_range_end }}</p>
                                @else
                                    <p>{{ trans('employee.salary') }}: {{ $savedJob->job_pref_salary_payment_type }} Tk. {{ $savedJob->salary_amount }}</p>
                                @endif

                            </div>
                            <div class="jobApply d-flex justify-content-between mt-2">
                                <div>
                                    @if(!\App\Helpers\ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
                                        @if(!$savedJob['isApplied']['isApplied'])
                                            <form action="{{ route('employee.apply-job', $savedJob->id) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn show-apply-model"  data-job-id="{{ $savedJob->id }}" data-job-company-logo="{{ asset($savedJob?->employerCompany?->logo) ?? '' }}" >{{ trans('employee.easy_apply') }}</button>
                                            </form>
                                        @endif
                                    @endif
{{--                                    <img src="{{ asset('/') }}frontend/employee/images/profile/savedMarkIcon.png" alt="Bookmark" class="bookmarkIcon" />--}}
                                </div>
{{--                                <div>--}}
{{--                                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/closeIcon.png" data-job-id="{{ $savedJob->id }}" alt="Close" class="closeIcon" />--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="row">
                        <div class="col-12">
                            <span class="text-center d-block mx-auto">{{ trans('employee.havent_applied_any_job') }}</span>
                        </div>
                    </div>
                @endforelse


{{--                <div class="row jobCard border-bottom">--}}
{{--                    <div class="col-md-1">--}}
{{--                        <img src="{{ asset('/') }}frontend/employee/images/contentImages/companyLogoFor job.png" alt="Company Logo" class="companyLogo" />--}}
{{--                    </div>--}}
{{--                    <div class="col-md-11">--}}
{{--                        <div class="jobPosition d-flex justify-content-between">--}}
{{--                            <div class="d-flex">--}}
{{--                                <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/contentImages/companyLogoFor job.png"--}}
{{--                                     alt="Company Logo" class="mobileLogo" />--}}

{{--                                <div class="paddingforMobile">--}}
{{--                                    <h3>Senior Officer, Corporate Banking</h3>--}}
{{--                                    <p>United Commercial Bank PLC</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <div class="dropdown">--}}
{{--                                    <img src="{{ asset('/') }}frontend/employee/images/contentImages/threedot.png"--}}
{{--                                         alt="Options"--}}
{{--                                         class="threeDot"--}}
{{--                                         role="button"--}}
{{--                                         data-bs-toggle="dropdown"--}}
{{--                                         aria-expanded="false" />--}}

{{--                                    <ul class="dropdown-menu dropdown-menu-end">--}}
{{--                                        <li><a class="dropdown-item" href="#">Save Job</a></li>--}}
{{--                                        <li><a class="dropdown-item" href="#">Share</a></li>--}}
{{--                                        <li><a class="dropdown-item" href="#">Report</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="jobTypeBtn">--}}
{{--                            <button class="btn">Full Time</button>--}}
{{--                            <button class="btn">On-Site</button>--}}
{{--                            <button class="btn">Day Shift</button>--}}
{{--                        </div>--}}
{{--                        <div class="jobDesc">--}}
{{--                            <p>Gulshan, Dhaka</p>--}}
{{--                            <p>3+ years of experience</p>--}}
{{--                            <p>Salary: Tk. 3,00,000+</p>--}}
{{--                        </div>--}}
{{--                        <div class="jobApply d-flex justify-content-between">--}}
{{--                            <div>--}}
{{--                                <button class="btn">Easy Apply</button>--}}
{{--                                <img src="{{ asset('/') }}frontend/employee/images/profile/savedMarkIcon.png" alt="Bookmark" class="bookmarkIcon" />--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <img src="{{ asset('/') }}frontend/employee/images/contentImages/closeIcon.png" alt="Close" class="closeIcon" data-bs-toggle="modal"--}}
{{--                                     data-bs-target="#closeConfirmModal" />--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}






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
@endsection

@section('modal')

    <!-- Minimal Bootstrap Modal -->
    <div class="modal fade" id="closeConfirmModal" tabindex="-1" aria-labelledby="closeConfirmLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title" id="closeConfirmLabel">{{ trans('common.are_you_sure') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Do you really want to close this job suggestion?
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('common.no') }}</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ trans('common.yes') }}</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <style>
        .swal2-confirm  {background-color: #FFCB11!important; color: black}
        .swal2-cancel  {background-color: #0d6efd!important;}
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
        .modal .job-type {margin-bottom: 10px}
        .share-profile-btn {background-color: #ffcb11 !important}
        .easy-apply-modal .cancel-btn {background-color: #0d6efd !important; color: white;}
    </style>
@endpush


@push('script')
{{--    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css" rel="stylesheet">--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('click', '.closeIcon', function () {
            var jobId = $(this).attr('data-job-id');
            Swal.fire({
                title: "{{ trans('common.are_you_sure') }}",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "{{ trans('common.yes') }}, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    sendAjaxRequest('employee/delete-saved-job/'+jobId, 'GET').then(function (response) {
                        if (response.status == 'success')
                        {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success",
                                showCancelButton: false,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Success!"
                            }).then((res) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                                // footer: '<a href="#">Why do I have this issue?</a>'
                            });
                        }
                    })
                }
            });
        })
    </script>

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
