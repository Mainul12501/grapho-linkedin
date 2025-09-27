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
            <p class="">You have {{ count($savedJobs) ?? 0 }} saved jobs</p>

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
                                        <h3><a href="{{ route('employee.show-jobs', ['job_task' => $savedJob->id]) }}" style="text-decoration: none; color: black">{{ $savedJob->job_title ?? 'Job Title' }}</a></h3>
                                        <p>{{ $savedJob->employerCompany?->name ?? 'Company Name' }}</p>
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
                                <button class="btn">{{ $savedJob?->jobType?->name ?? 'Job Type' }}</button>
                                <button class="btn">{{ $savedJob?->jobLocationType?->name ?? 'Job Location Type' }}</button>
{{--                                <button class="btn">Day Shift</button>--}}
                            </div>
                            <div class="jobDesc">
                                <p>Gulshan, Dhaka</p>
                                <p>{{ $savedJob->required_experience ?? 0 }}+ years of experience</p>
                                @if(isset($savedJob->salary_range_start))
                                    <p>Salary: Tk. {{ $savedJob->salary_range_start }} - {{ $savedJob->salary_range_end }}</p>
                                @else
                                    <p>Salary: {{ $savedJob->job_pref_salary_payment_type }} Tk. {{ $savedJob->salary_amount }}</p>
                                @endif

                            </div>
                            <div class="jobApply d-flex justify-content-between mt-2">
                                <div>
                                    @if(!$savedJob->isApplied)
                                        <form action="{{ route('employee.apply-job', $savedJob->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn">Easy Apply</button>
                                        </form>
                                    @endif
                                    <img src="{{ asset('/') }}frontend/employee/images/profile/savedMarkIcon.png" alt="Bookmark" class="bookmarkIcon" />
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
                            <span>No Saved Jobs Yet.</span>
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
{{--    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css" rel="stylesheet">--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('click', '.closeIcon', function () {
            var jobId = $(this).attr('data-job-id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
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
@endpush
