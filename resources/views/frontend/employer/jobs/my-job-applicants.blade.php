@extends('frontend.employer.master')

@section('title', 'My Applicants')

@section('body')

    <div class="talentWrapper p-4">
        <h4 class="mb-3">
            <img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt="" />
            {{ $jobTask->job_title ?? 'Job Title' }}
        </h4>
        <small class="text-muted mb-3 d-block">{{ count($jobTask->employeeAppliedJobs) ?? 0 }} Applicants</small>

        <!-- Bootstrap Tabs -->
        <div class="talentMobileTop">
            <ul class="nav nav-tabs mb-4 talenttabbutton" id="applicationTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill px-4" id="pending-tab" data-bs-toggle="tab"
                            data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true">
                        Pending
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4" id="shortlisted-tab" data-bs-toggle="tab"
                            data-bs-target="#shortlisted" type="button" role="tab" aria-controls="shortlisted" aria-selected="false">
                        Shortlisted
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected"
                            type="button" role="tab" aria-controls="rejected" aria-selected="false">
                        Rejected
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
                                    <img src="{{ asset($pendingApplicant?->user->profile_image ?? 'frontend/employer/images/employersHome/talent-1.png') }}" alt="Ayesha Begum" class="rounded-circle"
                                         style="width: 38px; height: 38px; object-fit: cover;" />
                                    {{ $pendingApplicant?->user?->name ?? 'User Name' }}
                                </td>
                                <td>{{ $pendingApplicant?->user?->versity ?? 'Update this field : University name' }}</td>
                                <td>{{ $pendingApplicant?->user?->cgpa }}</td>
                                <td>{{ $pendingApplicant->created_at->format('D-m-Y') ?? '25-09-2024' }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="" class="btn p-0" title="View profile" aria-label="View profile">
{{--                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talen-green-tikIcon.png" alt="Profile icon" style="width: 20px; height: 20px;" />--}}
                                            <span><i class="fas fa-user-circle text-primary" style="width: 20px; height: 20px;"></i></span>
                                        </a>
                                        <a href="" class="btn p-0" title="View profile" aria-label="Shortlist applicant">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talen-green-tikIcon.png" alt="Profile icon" style="width: 20px; height: 20px;" />
                                        </a>
                                        <a href="" class="btn p-0" title="View profile" aria-label="View profile">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talent-red-closeIcon.png" alt="Profile icon" style="width: 20px; height: 20px;" />
                                        </a>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Actions menu">
                                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="More options" style="width: 20px; height: 20px;" />
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#">Send message</a></li>
                                                <li><a class="dropdown-item text-danger" href="#">Remove</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <p class="f-s-25">No Data Found</p>
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>


                <!-- Mobile Cards -->
                <div class="pending-cards">
                    <div class="card mb-3 p-3 shadow-sm rounded-3">
                        <div class="d-flex align-items-start flex-column gap-3">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talent-1.png" alt="Ayesha Begum" class="rounded-circle"
                                 style="width: 48px; height: 48px; object-fit: cover;" />
                            <div>
                                <strong>Ayesha Begum</strong><br />
                                <small>Bangladesh University of Engineering</small><br />
                                <small>CGPA: 2.9</small><br />
                                <small>Applied on: 25-09-2024</small>
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-2 justify-content-between">
                            <button class="btn btn-outline-success btn-sm flex-fill me-1">Shortlist</button>
                            <button class="btn btn-outline-danger btn-sm flex-fill mx-1">Reject</button>
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talentMobileCrossIcon.png" alt="">
                        </div>
                    </div>
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
                        <tr>
                            <td class="d-flex align-items-center gap-3">
                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/talent-2.png" alt="Ayesha Begum" class="rounded-circle"
                                     style="width: 38px; height: 38px; object-fit: cover;" />
                                Ayesha Begum
                            </td>
                            <td>Bangladesh University of Engineering</td>
                            <td>2.9</td>
                            <td>25-09-2024</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <button type="button" class="btn p-0" title="View profile" aria-label="View profile">
                                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/talentSingle userIcon.png" alt="Profile icon" style="width: 20px; height: 20px;" />
                                    </button>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Actions menu">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="More options" style="width: 20px; height: 20px;" />
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#">Remove from shortlist</a></li>
                                            <li><a class="dropdown-item" href="#">Send message</a></li>
                                            <li><a class="dropdown-item text-danger" href="#">Remove</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="pending-cards">
                    <div class="card mb-3 p-3 shadow-sm rounded-3">
                        <div class="d-flex align-items-start flex-column gap-3">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talent-2.png" alt="Ayesha Begum" class="rounded-circle"
                                 style="width: 48px; height: 48px; object-fit: cover;" />
                            <div>
                                <strong>John</strong><br />
                                <small>Bangladesh University of Engineering</small><br />
                                <small>CGPA: 2.9</small><br />
                                <small>Applied on: 25-09-2024</small>
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-2 justify-content-between">
                            <button class="btn btn-outline-dark btn-sm flex-fill mx-1">Send message</button>
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talentMobileCrossIcon.png" alt="">
                        </div>
                    </div>
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
                        <tr>
                            <td class="d-flex align-items-center gap-3">
                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/talent-2.png" alt="Ayesha Begum" class="rounded-circle"
                                     style="width: 38px; height: 38px; object-fit: cover;" />
                                John
                            </td>
                            <td>Bangladesh University of Engineering</td>
                            <td>2.9</td>
                            <td>25-09-2024</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <button type="button" class="btn p-0" title="View profile" aria-label="View profile">
                                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/talen-green-tikIcon.png" alt="Profile icon" style="width: 20px; height: 20px;" />
                                    </button>
                                    <button type="button" class="btn p-0" title="View profile" aria-label="View profile">
                                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/talent-red-closeIcon.png" alt="Profile icon" style="width: 20px; height: 20px;" />
                                    </button>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Actions menu">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="More options" style="width: 20px; height: 20px;" />
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#">Remove from shortlist</a></li>
                                            <li><a class="dropdown-item" href="#">Send message</a></li>
                                            <li><a class="dropdown-item text-danger" href="#">Remove</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="pending-cards">
                    <div class="card mb-3 p-3 shadow-sm rounded-3">
                        <div class="d-flex align-items-start flex-column gap-3">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talent-3.png" alt="Ayesha Begum" class="rounded-circle"
                                 style="width: 48px; height: 48px; object-fit: cover;" />
                            <div>
                                <strong>Fatema Begum</strong><br />
                                <small>Bangladesh University of Engineering</small><br />
                                <small>CGPA: 2.9</small><br />
                                <small>Applied on: 25-09-2024</small>
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-2 justify-content-between">
                            <button class="btn btn-outline-success btn-sm flex-fill me-1">Shortlist</button>
                            <button class="btn btn-outline-danger btn-sm flex-fill mx-1">Reject</button>
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/talentMobileCrossIcon.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
