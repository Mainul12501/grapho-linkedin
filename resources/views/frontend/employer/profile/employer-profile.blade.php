@extends('frontend.employer.master')

@section('title', 'Employer Profile')

@section('body')

            <div class="ps-3 py-2 d-block d-md-none">
                <img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt="">
            </div>

            <div class="employerProfile container-fluid py-2">
                <div class="row g-4">
                    <!-- Left profile card -->
                    <div class="col-lg-3">
                        <div class="card rounded-3 p-4 sticky-lg-top profileLeftCard" style="top: 80px;">
                            <div class="mb-4 profile-left-card-info">
                                <div class="">
                                    <img
                                        src="https://randomuser.me/api/portraits/men/75.jpg"
                                        alt="Profile Picture"
                                        class="rounded-circle"
                                        style="width: 80px; height: 80px; object-fit: cover"
                                    />
                                </div>
                                <h5 class="fw-bold mb-1">Mohammed Pranto</h5>

                                <span class="badge d-inline-flex align-items-center mb-3 gap-2">
  <img src="{{ asset('/') }}frontend/employer/images/employersHome/Open to Full-time Roles.png" alt=""> Open to Full-time Roles
</span>

                                <p class="skills mb-3">
                                    Mobile App Developer, Flutter Developer, Instructor & Mentor
                                </p>
                            </div>

                            <div class="d-flex gap-2 mb-4">
                                <button class="btn btn-dark flex-grow-1 d-flex align-items-center justify-content-center gap-2">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/messengerIcon.png" alt=""> Message
                                </button>
                                <button class="btn btn-outline-dark flex-grow-1 d-flex align-items-center justify-content-center gap-2">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profileCallIcon.png" alt=""> Call
                                </button>
                            </div>

                            <ul class="list-unstyled mb-0">
                                <li class="mb-3 d-flex align-items-center gap-3">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="">
                                    <div>
                                        <small class="fw-bold d-block">Location</small>
                                        Dhaka, Bangladesh
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-center gap-3">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile mail.png" alt="">
                                    <div>
                                        <small class="fw-bold d-block">Email</small>
                                        <a href="mailto:md.pranto@gmail.com" class="text-decoration-none">md.pranto@gmail.com</a>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-center gap-3">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile phone.png" alt="">
                                    <div>
                                        <small class="fw-bold d-block">Phone</small>
                                        +8801653523779
                                    </div>
                                </li>
                                <li class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile website.png" alt="">
                                    <div>
                                        <small class="fw-bold d-block">Website</small>
                                        <a href="https://www.devpranto.com" target="_blank" class="text-decoration-none">www.devpranto.com</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Right content -->
                    <div class="col-lg-9">
                        <!-- Work Experiences -->
                        <section class="mb-5">
                            <h5 class="fw-semibold mb-4">Work experiences</h5>

                            <div class="card p-4 mb-4 shadow-sm rounded-3">
                                <div class="d-flex align-items-center mb-3 gap-3">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profileCompany-1.png" alt="UCB Logo" style=" object-fit: contain;" />
                                    <div>
                                        <h6 class="mb-0 fw-bold">Executive Officer, Sales</h6>
                                        <small class="text-muted">United Commercial Bank PLC &bull; Full Time</small><br />
                                        <small class="text-muted">Jan 2025 - Present &bull; 2 yrs 5 mos</small><br />
                                        <small class="text-muted">Dhaka, Bangladesh</small>
                                    </div>
                                </div>
                                <p class="mb-1 fw-semibold">Job Summary:</p>
                                <ul>
                                    <li>This was my first job in the banking field.</li>
                                    <li>I gained a good amount of leadership skills & learned to think about the business side of banking.</li>
                                    <li>After a while, I led a team of three. I had to maintain communication with the stakeholders.</li>
                                </ul>
                            </div>

                            <div class="card p-4 shadow-sm rounded-3">
                                <div class="d-flex align-items-center mb-3 gap-3">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profileCompany-2.png" alt="HSBC Logo" object-fit: contain;" />
                                    <div>
                                        <h6 class="mb-0 fw-bold">Sales Intern</h6>
                                        <small class="text-muted">HSBC &bull; Full Time</small><br />
                                        <small class="text-muted">Jul 2024 - Dec 2024 &bull; 5 mos</small><br />
                                        <small class="text-muted">Dhaka, Bangladesh</small>
                                    </div>
                                </div>
                                <p class="mb-1 fw-semibold">Job Summary:</p>
                                <ul>
                                    <li>This was my first job in the banking field.</li>
                                    <li>I gained a good amount of leadership skills & learned to think about the business side of banking.</li>
                                    <li>After a while, I led a team of three. I had to maintain communication with the stakeholders.</li>
                                </ul>
                            </div>
                        </section>


                        <!-- Education -->
                        <section class="mb-5">
                            <h5 class="fw-semibold mb-4">Education</h5>

                            <div class="card p-4 mb-4 shadow-sm rounded-3">
                                <div class="d-flex align-items-center mb-3 gap-3">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile-education-1.png" alt="UCB Logo" style=" object-fit: contain;" />
                                    <div>
                                        <h6 class="mb-0 fw-bold">North South University</h6>
                                        <small class="text-muted">BBA - Marketing &bull; CGPA 3.45</small><br />
                                        <small class="text-muted">Jan 2017 - Jul 2024</small><br />
                                        <small class="text-muted">Dhaka, Bangladesh</small>
                                    </div>
                                </div>
                            </div>

                            <div class="card p-4 shadow-sm rounded-3">
                                <div class="d-flex align-items-center mb-3 gap-3">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile-education-2.png" alt="HSBC Logo" object-fit: contain;/>
                                    <div>
                                        <h6 class="mb-0 fw-bold">Notre Dame College</h6>
                                        <small class="text-muted">BBA - Marketing &bull; CGPA 3.45</small><br />
                                        <small class="text-muted">Jan 2017 - Jul 2024</small><br />
                                        <small class="text-muted">Dhaka, Bangladesh</small>
                                    </div>
                                </div>
                            </div>
                        </section>


                        <!-- documents -->
                        <!-- Education -->
                        <section class="mb-5">
                            <h5 class="fw-semibold mb-4">Documents</h5>

                            <div class="card p-4 mb-4 shadow-sm rounded-3">
                                <div class="d-flex align-items-center mb-3 gap-3">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/curriculam-dita.png" alt="UCB Logo" style=" object-fit: contain;" />
                                    <div>
                                        <h6 class="mb-0 fw-bold">Curriculum Vitae</h6>
                                        <small class="text-muted">PDF &bull; 325 KB</small>
                                    </div>
                                </div>
                            </div>

                            <div class="card p-4 shadow-sm rounded-3">
                                <div class="d-flex align-items-center mb-3 gap-3">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/NID.png" alt="HSBC Logo" object-fit: contain;/>
                                    <div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Curriculum Vitae</h6>
                                            <small class="text-muted">PDF &bull; 325 KB</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
@endsection
