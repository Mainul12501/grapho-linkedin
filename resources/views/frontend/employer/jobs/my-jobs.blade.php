@extends('frontend.employer.master')

@section('title', 'my-jobs')

@section('body')
    <main class="dashboardContent p-4">
        <div class="container-fluid">
            <div class="row">

                <!-- Main Content -->
                <section class="col-12">
                    <!-- my search job top -->
                    <div class="my-jobs-section mb-4">
                        <div class="container-fluid">

                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                                <!-- Heading -->
                                <div>
                                    <h5 class="fw-bold mb-1">My Jobs</h5>
                                    <p class="text-muted small mb-0">See all your posted jobs here</p>
                                </div>
                                <!-- Post a job button -->
                                <!-- Post a job button -->
                                <button class="btn btn-warning text-dark fw-semibold rounded-3 px-4 py-2"
                                        data-bs-toggle="modal" data-bs-target="#createJobModal">
                                    Post a job
                                </button>

                            </div>

                            <!-- ✅ Mobile Search -->
                            <div class="d-block d-md-none mb-3">
                                <div class="input-group">
        <span class="input-group-text bg-white border-end-0">
          <img src="{{ asset('/') }}frontend/employer/images/employersHome/search 1.png" alt="">
        </span>
                                    <input type="text" class="form-control border-start-0" placeholder="Search jobs (mobile)" />
                                </div>
                            </div>

                            <!-- ✅ Desktop Search -->
                            <div class="d-none d-md-flex justify-content-end mb-3">
                                <div style="max-width: 320px; width: 100%;">
                                    <div class="input-group">
          <span class="input-group-text bg-white border-end-0">
          <img src="{{ asset('/') }}frontend/employer/images/employersHome/search 1.png" alt="">
          </span>
                                        <input type="text" class="form-control border-start-0" placeholder="Search jobs (desktop)" />
                                    </div>
                                </div>
                            </div>

                            <!-- Filter Buttons -->
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-dark btn-sm rounded-pill px-3">Open Jobs</button>
                                <button class="btn btn-light btn-sm rounded-pill px-3 text-muted">Drafts</button>
                                <button class="btn btn-light btn-sm rounded-pill px-3 text-muted">Archives</button>
                            </div>
                        </div>
                    </div>









                    <!-- Job Cards -->
                    <div class="row gy-3 jobCardsWrapper">
                        <!-- Job Card -->
                        <div class="col-12">
                            <article class="job-card d-flex flex-wrap justify-content-between align-items-start gap-3">

                                <!-- ✅ Modal Trigger Area -->
                                <div class="job-main clickable-area flex-grow-1" data-bs-toggle="modal" data-bs-target="#jobDetailsModal" style="cursor: pointer;">
                                    <div class="job-details">
                                        <h6 class="job-title fw-semibold mb-2">Senior Officer, Corporate Banking</h6>
                                        <div class="job-badges d-flex flex-wrap gap-2 mb-2">
                                            <span class="badge bg-light text-secondary">Full Time</span>
                                            <span class="badge bg-light text-secondary">On-Site</span>
                                            <span class="badge bg-light text-secondary">Day Shift</span>
                                        </div>
                                    </div>
                                    <div class="job-info text-muted small">
                                        <div class="mb-1">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/postdOn.png" class="me-1" alt=""> Posted on: 16 Feb, 2025
                                        </div>
                                        <div class="mb-1">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/Dedline.png" class="me-1" alt=""> Deadline: 24 Mar, 2025
                                        </div>
                                        <div>
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/24application.png" class="me-1" alt="">
                                            <a href="#" class="text-decoration-underline">24 Applicants</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- ✅ Dropdown (Three Dot) -->
                                <div class="job-actions dropdown">
                                    <button class="btn btn-link p-0 text-secondary"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="">
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>

                        <div class="col-12">
                            <article class="job-card d-flex flex-wrap justify-content-between align-items-start gap-3">

                                <!-- ✅ Modal Trigger Area -->
                                <div class="job-main clickable-area flex-grow-1" data-bs-toggle="modal" data-bs-target="#jobDetailsModal" style="cursor: pointer;">
                                    <div class="job-details">
                                        <h6 class="job-title fw-semibold mb-2">Senior Officer, Corporate Banking</h6>
                                        <div class="job-badges d-flex flex-wrap gap-2 mb-2">
                                            <span class="badge bg-light text-secondary">Full Time</span>
                                            <span class="badge bg-light text-secondary">On-Site</span>
                                            <span class="badge bg-light text-secondary">Day Shift</span>
                                        </div>
                                    </div>
                                    <div class="job-info text-muted small">
                                        <div class="mb-1">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/postdOn.png" class="me-1" alt=""> Posted on: 16 Feb, 2025
                                        </div>
                                        <div class="mb-1">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/Dedline.png" class="me-1" alt=""> Deadline: 24 Mar, 2025
                                        </div>
                                        <div>
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/24application.png" class="me-1" alt="">
                                            <a href="#" class="text-decoration-underline">24 Applicants</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- ✅ Dropdown (Three Dot) -->
                                <div class="job-actions dropdown">
                                    <button class="btn btn-link p-0 text-secondary"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="">
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>


                        <div class="col-12">
                            <article class="job-card d-flex flex-wrap justify-content-between align-items-start gap-3">

                                <!-- ✅ Modal Trigger Area -->
                                <div class="job-main clickable-area flex-grow-1" data-bs-toggle="modal" data-bs-target="#jobDetailsModal" style="cursor: pointer;">
                                    <div class="job-details">
                                        <h6 class="job-title fw-semibold mb-2">Senior Officer, Corporate Banking</h6>
                                        <div class="job-badges d-flex flex-wrap gap-2 mb-2">
                                            <span class="badge bg-light text-secondary">Full Time</span>
                                            <span class="badge bg-light text-secondary">On-Site</span>
                                            <span class="badge bg-light text-secondary">Day Shift</span>
                                        </div>
                                    </div>
                                    <div class="job-info text-muted small">
                                        <div class="mb-1">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/postdOn.png" class="me-1" alt=""> Posted on: 16 Feb, 2025
                                        </div>
                                        <div class="mb-1">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/Dedline.png" class="me-1" alt=""> Deadline: 24 Mar, 2025
                                        </div>
                                        <div>
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/24application.png" class="me-1" alt="">
                                            <a href="#" class="text-decoration-underline">24 Applicants</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- ✅ Dropdown (Three Dot) -->
                                <div class="job-actions dropdown">
                                    <button class="btn btn-link p-0 text-secondary"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="">
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>

                        <div class="col-12">
                            <article class="job-card d-flex flex-wrap justify-content-between align-items-start gap-3">

                                <!-- ✅ Modal Trigger Area -->
                                <div class="job-main clickable-area flex-grow-1" data-bs-toggle="modal" data-bs-target="#jobDetailsModal" style="cursor: pointer;">
                                    <div class="job-details">
                                        <h6 class="job-title fw-semibold mb-2">Senior Officer, Corporate Banking</h6>
                                        <div class="job-badges d-flex flex-wrap gap-2 mb-2">
                                            <span class="badge bg-light text-secondary">Full Time</span>
                                            <span class="badge bg-light text-secondary">On-Site</span>
                                            <span class="badge bg-light text-secondary">Day Shift</span>
                                        </div>
                                    </div>
                                    <div class="job-info text-muted small">
                                        <div class="mb-1">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/postdOn.png" class="me-1" alt=""> Posted on: 16 Feb, 2025
                                        </div>
                                        <div class="mb-1">
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/Dedline.png" class="me-1" alt=""> Deadline: 24 Mar, 2025
                                        </div>
                                        <div>
                                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/24application.png" class="me-1" alt="">
                                            <a href="#" class="text-decoration-underline">24 Applicants</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- ✅ Dropdown (Three Dot) -->
                                <div class="job-actions dropdown">
                                    <button class="btn btn-link p-0 text-secondary"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="">
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>


                    </div>
                </section>
            </div>
        </div>

    </main>
@endsection


@section('modal')


    <!-- Job Details Modal -->
    <div class="modal fade" id="jobDetailsModal" tabindex="-1" aria-labelledby="jobDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 fw-semibold">
                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt="" class="me-2"> Job details
                    </h6>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/Edit pencil.png" alt=""> Edit
                        </button>
                        <button class="btn btn-light btn-sm">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="">
                        </button>
                    </div>
                </div>

                <!-- Company Info -->
                <div class="mb-2">
                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/UCB logo.png" alt=""> <span class="fw-semibold">United Commercial Bank PLC</span> · <span class="text-muted">Gulshan, Dhaka</span>
                </div>

                <!-- Job Title -->
                <h4 class="fw-bold mb-3">Senior Officer, Corporate Banking</h4>

                <!-- Tags -->
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <span class="badge bg-light text-dark fw-medium">Full Time</span>
                    <span class="badge bg-light text-dark fw-medium">On-Site</span>
                    <span class="badge bg-light text-dark fw-medium">Day Shift</span>
                </div>

                <!-- About -->
                <h6 class="fw-semibold mb-2">About UCB</h6>
                <p class="text-muted" style="line-height: 1.6;">
                    Be part of the world's most successful, purpose-led business. Work with brands that are well-loved around the world, that improve the lives of our consumers and the communities around us. We promote innovation, big and small, to make our business win and grow; and we believe in business as a force for good. Unleash your curiosity, challenge ideas and disrupt processes; use your energy to make this happen.
                    <br><br>
                    Our brilliant business leaders and colleagues provide mentorship and inspiration, so you can be at your best. Every day, nine out of ten Indian households use our products to feel good, look good and get more out of life – giving us a unique opportunity to build a brighter future.
                </p>

                <!-- Requirements -->
                <h6 class="fw-semibold mt-4 mb-2">Job Requirements</h6>
                <ul class="text-muted" style="line-height: 1.8;">
                    <li>Analyse internal and external data to identify geography-wise issues/opportunities and action upon them.</li>
                    <li>Work with media teams and other stakeholders to deploy effective communication for Surf across traditional and new-age media platforms.</li>
                </ul>
            </div>
        </div>
    </div>





    <!-- Create Job Modal -->
    <div class="modal fade" id="createJobModal" tabindex="-1" aria-hidden="true">
@endsection
