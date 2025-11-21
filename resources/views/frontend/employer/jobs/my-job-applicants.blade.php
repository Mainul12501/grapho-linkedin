@extends('frontend.employer.master')

@section('title', 'My Applicants')

@section('body')

    <div class="talentWrapper p-4">
        <h4 class="mb-3">
            <a href="{{ route('employer.my-job-wise-applicants') }}">
                <img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt="" />
            </a>
            {{ $jobTask->job_title ?? 'Job Title' }}
        </h4>
        <small class="text-muted mb-3 d-block">{{ count($jobTask->employeeAppliedJobs) ?? 0 }} {{ trans('employer.applicants') }}</small>

        <!-- Bootstrap Tabs -->
        <div class="talentMobileTop">
            <ul class="nav nav-tabs mb-4 talenttabbutton flex-wrap" id="applicationTabs" role="tablist">
                <li class="nav-item mx-1 p-1" role="presentation">
                    <button class="nav-link active rounded-pill px-4 tab-btn-bg" id="pending-tab" data-bs-toggle="tab"
                            data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true">
                        {{ trans('employee.pending') }}
                    </button>
                </li>
                <li class="nav-item mx-1 p-1" role="presentation">
                    <button class="nav-link rounded-pill px-4 tab-btn-bg" id="shortlisted-tab" data-bs-toggle="tab"
                            data-bs-target="#shortlisted" type="button" role="tab" aria-controls="shortlisted" aria-selected="false">
                        {{ trans('employee.shortlisted') }}
                    </button>
                </li>
                <li class="nav-item mx-1 p-1" role="presentation">
                    <button class="nav-link rounded-pill px-4 tab-btn-bg" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#approved"
                            type="button" role="tab" aria-controls="rejected" aria-selected="false">
                        {{ trans('employee.approved') }}
                    </button>
                </li>
                <li class="nav-item mx-1 p-1" role="presentation">
                    <button class="nav-link rounded-pill px-4 tab-btn-bg" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected"
                            type="button" role="tab" aria-controls="rejected" aria-selected="false">
                        {{ trans('employee.rejected') }}
                    </button>
                </li>
            </ul>
            <!-- Search input -->
{{--            <div class="mb-3 d-flex justify-content-end talentsearchbar">--}}
{{--                <input type="search" class="form-control w-100" placeholder="Search applicants" />--}}
{{--            </div>--}}
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="applicationTabsContent">

            <!-- Pending Tab Pane -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab" tabindex="0">
                <!-- Desktop Table -->
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr class="bg-light text-secondary small">
                            <th scope="col" style="min-width: 220px;">Applicant name</th>
                            <th scope="col" style="min-width: 160px;">University</th>
                            <th scope="col" style="min-width: 70px;">CGPA</th>
                            <th scope="col" style="min-width: 110px;">Applied on</th>
                            <th scope="col" style="min-width: 90px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($pendingApplicants as $pendingApplicant)
                            <tr>
                                <td class="d-flex align-items-center gap-3">
                                    <img src="{{ asset($pendingApplicant?->user->profile_image ?? 'frontend/user-vector-img.jpg') }}" alt="user-image" class="rounded-circle"
                                         style="width: 38px; height: 38px; object-fit: cover;" />
                                    {{ $pendingApplicant?->user?->name ?? 'User Name' }}
                                </td>
                                <td>{{ $pendingApplicant?->user?->employeeEducations[count($pendingApplicant?->user?->employeeEducations)-1]?->universityName?->name ?? '' }}</td>
                                <td>{{ $pendingApplicant?->user?->employeeEducations[count($pendingApplicant?->user?->employeeEducations)-1]?->cgpa ?? '0.00' }}</td>
                                <td>{{ $pendingApplicant->created_at->format('D-m-Y') ?? '25-09-2024' }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="{{ route('employee-profile', ['employeeId' => $pendingApplicant?->user?->id]) }}" class="btn p-0" title="View profile" aria-label="View profile">
{{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talen-green-tikIcon.png" alt="Profile icon" style="width: 20px; height: 20px;" />--}}
{{--                                            <span><i class="fas fa-user-circle text-primary" style="width: 20px; height: 20px;"></i></span>--}}
                                            <img src="{{ asset('/frontend/employer/images/profile.png') }}" alt="More options" style="max-width: 22px; max-height: 22px;" />
                                        </a>
                                        <a href="{{ route('employer.change-employee-job-application-status', ['jobTask' => $pendingApplicant?->job_task_id, 'user' => $pendingApplicant?->user?->id, 'status' => 'shortlisted']) }}" class="btn p-0" title="Shortlist This Applicant" aria-label="Shortlist applicant">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talen-green-tikIcon.png" alt="Profile icon" style="width: 20px; height: 20px;" />
                                        </a>
                                        <a href="{{ route('employer.change-employee-job-application-status', ['jobTask' => $pendingApplicant?->job_task_id, 'user' => $pendingApplicant?->user?->id, 'status' => 'rejected']) }}" class="btn p-0" title="Reject This Applicant" aria-label="Reject This Applicant">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talent-red-closeIcon.png" alt="Profile icon" style="width: 20px; height: 20px;" />
                                        </a>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Actions menu">
                                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="More options" style="width: 20px; height: 20px;" />
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="{{ route('user', $pendingApplicant?->user?->id) }}" target="_blank">{{ trans('common.message') }}</a></li>
{{--                                                <li><a class="dropdown-item text-danger" href="#">Remove</a></li>--}}
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <p class="f-s-25 text-center mx-auto">No Data Found</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Mobile Cards -->
                <div class="pending-cards">
                    @forelse($pendingApplicants as $pendingApplicant)
                        <div class="card mb-3 p-3 shadow-sm rounded-3">
                            <div class="d-flex align-items-start flex-column gap-3">
                                <img src="{{ asset($pendingApplicant?->user->profile_image ?? 'frontend/user-vector-img.jpg') }}" alt="Ayesha Begum" class="rounded-circle"
                                     style="width: 48px; height: 48px; object-fit: cover;" />
                                <div>
                                    <strong>{{ $pendingApplicant?->user?->name ?? 'User Name' }}</strong><br />
                                    <small>{{ $pendingApplicant?->user?->versity ?? 'Update this field : University name' }}</small><br />
                                    <small>CGPA: {{ $pendingApplicant?->user?->cgpa }}</small><br />
                                    <small>Applied on: {{ $pendingApplicant->created_at->format('D-m-Y') ?? '25-09-2024' }}</small>
                                </div>
                            </div>
                            <div class="mt-3 d-flex gap-2 justify-content-between">
                                <a href="{{ route('employee-profile', ['employeeId' => $pendingApplicant?->user?->id]) }}" style="background-color: #0a53be" class="btn mobile-btn-custom btn-sm flex-fill me-1 text-white">{{ trans('employee.view_profile_details') }}</a>
                                <a href="{{ route('employer.change-employee-job-application-status', ['jobTask' => $pendingApplicant?->job_task_id, 'user' => $pendingApplicant?->user?->id, 'status' => 'shortlisted']) }}" style="background-color: #008A221F; color: #008A22" class="btn mobile-btn-custom btn-sm flex-fill me-1">{{ trans('employee.shortlisted') }}</a>
                                <a href="{{ route('employer.change-employee-job-application-status', ['jobTask' => $pendingApplicant?->job_task_id, 'user' => $pendingApplicant?->user?->id, 'status' => 'rejected']) }}" style="background-color: #E8191C1F; color: #E8191C" class="btn mobile-btn-custom btn-sm flex-fill mx-1">{{ trans('employee.rejected') }}</a>
{{--                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/talentMobileCrossIcon.png" alt="">--}}
                            </div>
                        </div>
                    @empty
                        <div class="card mb-3 p-3 shadow-sm rounded-3">
                            <div class="d-flex align-items-start flex-column gap-3">
                                <p class="f-s-26 text-center mx-auto">No Data Found</p>
                            </div>
                        </div>
                    @endforelse

                </div>

            </div>

            <!-- Shortlisted Tab Pane -->
            <div class="tab-pane fade" id="shortlisted" role="tabpanel" aria-labelledby="shortlisted-tab" tabindex="0">
                <!-- Desktop Table -->
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr class="bg-light text-secondary small">
                            <th scope="col" style="min-width: 220px;">Applicant name</th>
                            <th scope="col" style="min-width: 160px;">University</th>
                            <th scope="col" style="min-width: 70px;">CGPA</th>
                            <th scope="col" style="min-width: 110px;">Applied on</th>
                            <th scope="col" style="min-width: 90px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($shortListedApplicants as $shortListedApplicant)
                            <tr>
                                <td class="d-flex align-items-center gap-3">
                                    <img src="{{ asset($shortListedApplicant?->user->profile_image ?? 'frontend/user-vector-img.jpg') }}" alt="Ayesha Begum" class="rounded-circle"
                                         style="width: 38px; height: 38px; object-fit: cover;" />
                                    {{ $shortListedApplicant?->user?->name ?? 'User Name' }}
                                </td>
                                <td>{{ $shortListedApplicant?->user?->versity ?? 'Update this field : University name' }}</td>
                                <td>{{ $shortListedApplicant?->user?->cgpa }}</td>
                                <td>{{ $shortListedApplicant->created_at->format('D-m-Y') ?? '25-09-2024' }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="{{ route('employee-profile', ['employeeId' => $shortListedApplicant?->user?->id]) }}" class="btn p-0" title="View profile" aria-label="View profile">
                                            {{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talen-green-tikIcon.png" alt="Profile icon" style="width: 20px; height: 20px;" />--}}
{{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="More options" style="width: 20px; height: 20px;" />--}}
                                            <span><i class="fas fa-user-circle text-primary" style="width: 20px; height: 20px;"></i></span>
                                        </a>
                                        <a href="{{ route('employer.change-employee-job-application-status', ['jobTask' => $shortListedApplicant->job_task_id, 'user' => $shortListedApplicant?->user?->id, 'status' => 'approved']) }}" class="btn p-0" title="Approve Request" aria-label="Shortlist applicant">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talen-green-tikIcon.png" alt="Profile icon" style="width: 20px; height: 20px;" />
                                        </a>
                                        <a href="{{ route('employer.change-employee-job-application-status', ['jobTask' => $shortListedApplicant->job_task_id, 'user' => $shortListedApplicant?->user?->id, 'status' => 'rejected']) }}" class="btn p-0" title="Reject Applicant" aria-label="View profile">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talent-red-closeIcon.png" alt="Profile icon" style="width: 20px; height: 20px;" />
                                        </a>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Actions menu">
                                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="More options" style="width: 20px; height: 20px;" />
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="{{ route('user', $shortListedApplicant?->user?->id) }}">Send message</a></li>
{{--                                                <li><a class="dropdown-item text-danger" href="#">Remove</a></li>--}}
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <p class="f-s-25 text-center mx-auto">No Data Found</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="pending-cards">
                    @forelse($shortListedApplicants as $shortListedApplicant)
                    <div class="card mb-3 p-3 shadow-sm rounded-3">
                        <div class="d-flex align-items-start flex-column gap-3">
                            <img src="{{ asset($shortListedApplicant?->user->profile_image ?? 'frontend/user-vector-img.jpg') }}" alt="Ayesha Begum" class="rounded-circle"
                                 style="width: 48px; height: 48px; object-fit: cover;" />
                            <div>
                                <strong>{{ $shortListedApplicant?->user?->name ?? 'User Name' }}</strong><br />
                                <small>{{ $shortListedApplicant?->user?->versity ?? 'Update this field : University name' }}</small><br />
                                <small>CGPA: {{ $shortListedApplicant?->user?->cgpa }}</small><br />
                                <small>Applied on: {{ $shortListedApplicant->created_at->format('D-m-Y') ?? '25-09-2024' }}</small>
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-2 justify-content-between">
                            <a href="{{ route('employee-profile', ['employeeId' => $shortListedApplicant?->user?->id]) }}" class="btn btn-primary text-white btn-sm flex-fill me-1">View Profile</a>
                            <a href="{{ route('employer.change-employee-job-application-status', ['jobTask' => $shortListedApplicant->job_task_id, 'user' => $shortListedApplicant?->user?->id, 'status' => 'approved']) }}" style="background-color: #008A221F; color: #008A22" class="btn mobile-btn-custom btn-sm flex-fill me-1">Approve</a>
                            <a href="{{ route('employer.change-employee-job-application-status', ['jobTask' => $shortListedApplicant->job_task_id, 'user' => $shortListedApplicant?->user?->id, 'status' => 'rejected']) }}" style="background-color: #E8191C1F; color: #E8191C" class="btn mobile-btn-custom btn-sm flex-fill mx-1">Reject</a>
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talentMobileCrossIcon.png" alt="">--}}
                        </div>
                    </div>
                    @empty
                        <div class="card mb-3 p-3 shadow-sm rounded-3">
                            <div class="d-flex align-items-start flex-column gap-3">
                                <p class="f-s-26 text-center mx-auto">No Data Found</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>


            <!-- Rejected Tab Pane -->
            <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab" tabindex="0">
                <!-- Desktop Table -->
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr class="bg-light text-secondary small">
                            <th scope="col" style="min-width: 220px;">Applicant name</th>
                            <th scope="col" style="min-width: 160px;">University</th>
                            <th scope="col" style="min-width: 70px;">CGPA</th>
                            <th scope="col" style="min-width: 110px;">Applied on</th>
                            <th scope="col" style="min-width: 90px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($rejectedApplicants as $rejectedApplicant)
                            <tr>
                                <td class="d-flex align-items-center gap-3">
                                    <img src="{{ asset($rejectedApplicant?->user->profile_image ?? 'frontend/user-vector-img.jpg') }}" alt="Ayesha Begum" class="rounded-circle"
                                         style="width: 38px; height: 38px; object-fit: cover;" />
                                    {{ $rejectedApplicant?->user?->name ?? 'User Name' }}
                                </td>
                                <td>{{ $rejectedApplicant?->user?->versity ?? 'Update this field : University name' }}</td>
                                <td>{{ $rejectedApplicant?->user?->cgpa }}</td>
                                <td>{{ $rejectedApplicant->created_at->format('D-m-Y') ?? '25-09-2024' }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="{{ route('employee-profile', ['employeeId' => $rejectedApplicant?->user?->id]) }}" class="btn p-0" title="View profile" aria-label="View profile">
                                            {{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talen-green-tikIcon.png" alt="Profile icon" style="width: 20px; height: 20px;" />--}}
{{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="More options" style="width: 20px; height: 20px;" />--}}
                                                                                        <span><i class="fas fa-user-circle text-primary" style="width: 20px; height: 20px;"></i></span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <p class="f-s-25 text-center">No Data Found</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="pending-cards">
                    @forelse($rejectedApplicants as $rejectedApplicant))
                    <div class="card mb-3 p-3 shadow-sm rounded-3">
                        <div class="d-flex align-items-start flex-column gap-3">
                            <img src="{{ asset($rejectedApplicant?->user->profile_image ?? 'frontend/user-vector-img.jpg') }}" alt="Ayesha Begum" class="rounded-circle"
                                 style="width: 48px; height: 48px; object-fit: cover;" />
                            <div>
                                <strong>{{ $rejectedApplicant?->user?->name ?? 'User Name' }}</strong><br />
                                <small>{{ $rejectedApplicant?->user?->versity ?? 'Update this field : University name' }}</small><br />
                                <small>CGPA: {{ $rejectedApplicant?->user?->cgpa }}</small><br />
                                <small>Applied on: {{ $rejectedApplicant->created_at->format('D-m-Y') ?? '25-09-2024' }}</small>
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-2 justify-content-between">
                            <a href="{{ route('employee-profile', ['employeeId' => $rejectedApplicant?->user?->id]) }}" class="btn btn-outline-primary btn-sm flex-fill me-1">View Profile</a>
{{--                            <a href="" class="btn btn-outline-success btn-sm flex-fill me-1">Shortlist</a>--}}
{{--                            <a href="" class="btn btn-outline-danger btn-sm flex-fill mx-1">Reject</a>--}}
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talentMobileCrossIcon.png" alt="">--}}
                        </div>
                    </div>
                    @empty
                        <div class="card mb-3 p-3 shadow-sm rounded-3">
                            <div class="d-flex align-items-start flex-column gap-3">
                                <p class="f-s-26 text-center">No Data Found</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Approved Tab Pane -->
            <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="rejected-tab" tabindex="0">
                <!-- Desktop Table -->
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr class="bg-light text-secondary small">
                            <th scope="col" style="min-width: 220px;">Applicant name</th>
                            <th scope="col" style="min-width: 160px;">University</th>
                            <th scope="col" style="min-width: 70px;">CGPA</th>
                            <th scope="col" style="min-width: 110px;">Applied on</th>
                            <th scope="col" style="min-width: 90px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($approvedApplicants as $approvedApplicant)
                            <tr>
                                <td class="d-flex align-items-center gap-3">
                                    <img src="{{ asset($approvedApplicant?->user->profile_image ?? 'frontend/user-vector-img.jpg') }}" alt="Ayesha Begum" class="rounded-circle"
                                         style="width: 38px; height: 38px; object-fit: cover;" />
                                    {{ $approvedApplicant?->user?->name ?? 'User Name' }}
                                </td>
                                <td>{{ $approvedApplicant?->user?->versity ?? 'Update this field : University name' }}</td>
                                <td>{{ $approvedApplicant?->user?->cgpa }}</td>
                                <td>{{ $approvedApplicant->created_at->format('D-m-Y') ?? '25-09-2024' }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="{{ route('employee-profile', ['employeeId' => $approvedApplicant?->user?->id]) }}" class="btn p-0" title="View profile" aria-label="View profile">
                                            {{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talen-green-tikIcon.png" alt="Profile icon" style="width: 20px; height: 20px;" />--}}
{{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="More options" style="width: 20px; height: 20px;" />--}}
                                                                                        <span><i class="fas fa-user-circle text-primary" style="width: 20px; height: 20px;"></i></span>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <p class="f-s-25 text-center">No Data Found</p>
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="pending-cards">
                    @forelse($approvedApplicants as $approvedApplicant))
                    <div class="card mb-3 p-3 shadow-sm rounded-3">
                        <div class="d-flex align-items-start flex-column gap-3">
                            <img src="{{ asset($approvedApplicant?->user->profile_image ?? 'frontend/user-vector-img.jpg') }}" alt="Ayesha Begum" class="rounded-circle"
                                 style="width: 48px; height: 48px; object-fit: cover;" />
                            <div>
                                <strong>{{ $approvedApplicant?->user?->name ?? 'User Name' }}</strong><br />
                                <small>{{ $approvedApplicant?->user?->versity ?? 'Update this field : University name' }}</small><br />
                                <small>CGPA: {{ $approvedApplicant?->user?->cgpa }}</small><br />
                                <small>Applied on: {{ $approvedApplicant->created_at->format('D-m-Y') ?? '25-09-2024' }}</small>
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-2 justify-content-between">
                            <a href="{{ route('employee-profile', ['employeeId' => $approvedApplicant?->user?->id]) }}" class="btn btn-primary text-white btn-sm flex-fill me-1">View Profile</a>
{{--                            <a href="" class="btn btn-outline-success btn-sm flex-fill me-1">Shortlist</a>--}}
{{--                            <a href="" class="btn btn-outline-danger btn-sm flex-fill mx-1">Reject</a>--}}
{{--                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talentMobileCrossIcon.png" alt="">--}}
                        </div>
                    </div>
                    @empty
                        <div class="card mb-3 p-3 shadow-sm rounded-3">
                            <div class="d-flex align-items-start flex-column gap-3">
                                <p class="f-s-26 text-center mx-auto">No Data Found</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .tab-btn-bg {
            background-color: lightgrey;
            color: black;
        }
        .mobile-btn-custom {
            padding: 6px 12px;
            gap: 12px;
        }
    </style>
@endpush
