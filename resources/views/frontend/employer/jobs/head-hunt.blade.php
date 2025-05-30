@extends('frontend.employer.master')

@section('title', 'Head Hunt')

@section('body')

    <div class="ps-3 py-2 d-block d-md-none">
        <img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt="">
    </div>
    <!-- head hunt -->
    <div class="headHunt p-4">
        <h2 class="mb-1 fw-bold">Head Hunt</h2>
        <p class="text-muted mb-3">Browse talents & find the perfect match for your company.</p>

        <div class="headHUntFielter">
            <!-- fielter options -->
            <div class="d-flex flex-wrap gap-2 mb-3 filter-dropdowns ">

                <div class="dropdown">
                    <button class="btn btn-outline-warning btn-sm rounded-pill px-3 dropdown-toggle active" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Full-time
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Full-time</a></li>
                        <li><a class="dropdown-item" href="#">Part-time</a></li>
                        <li><a class="dropdown-item" href="#">Freelancing</a></li>
                        <li><a class="dropdown-item" href="#">Internship</a></li>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-warning btn-sm rounded-pill px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dhaka
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Dhaka</a></li>
                        <li><a class="dropdown-item" href="#">Chittagong</a></li>
                        <li><a class="dropdown-item" href="#">Khulna</a></li>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        University
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">BUET</a></li>
                        <li><a class="dropdown-item" href="#">DU</a></li>
                        <li><a class="dropdown-item" href="#">NSU</a></li>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        CGPA
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">3.00+</a></li>
                        <li><a class="dropdown-item" href="#">3.50+</a></li>
                        <li><a class="dropdown-item" href="#">4.00</a></li>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Field of study
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Computer Science</a></li>
                        <li><a class="dropdown-item" href="#">Business</a></li>
                        <li><a class="dropdown-item" href="#">Design</a></li>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Industry
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Tech</a></li>
                        <li><a class="dropdown-item" href="#">Finance</a></li>
                        <li><a class="dropdown-item" href="#">Healthcare</a></li>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Experience
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">1+ years</a></li>
                        <li><a class="dropdown-item" href="#">3+ years</a></li>
                        <li><a class="dropdown-item" href="#">5+ years</a></li>
                    </ul>
                </div>

            </div>


            <div class="input-group mb-4" style="max-width: 350px;">
                <input type="text" class="form-control" placeholder="Search talents" aria-label="Search talents" />
                <button class="btn btn-light border" type="button">
                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/search 1.png" alt="Search" style="width: 16px; height: 16px;" />
                </button>
            </div>
        </div>

        <div class="d-flex justify-content-between mb-3" style="font-size: 14px; cursor: pointer;">
            <p class="text-muted">Showing 34 results.</p>
            <div class="dropdown">
                <a class="text-muted d-flex align-items-center text-decoration-none dropdown-toggle" href="#" role="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 14px;">
                    Most relevant
                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/chevron-down 1.png" alt="Sort" class="ms-2" style="width: 12px; height: 12px;" />
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sortDropdown">
                    <li><a class="dropdown-item" href="#">Most relevant</a></li>
                    <li><a class="dropdown-item" href="#">Most recent</a></li>
                    <li><a class="dropdown-item" href="#">Highest CGPA</a></li>
                    <li><a class="dropdown-item" href="#">Most experience</a></li>
                </ul>
            </div>
        </div>


        <div class="row row-cols-1 row-cols-md-3 g-3 headhuntPP-card">
            <!-- Candidate Card Template -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/headhunt-pp1.png" alt="Mohammed Pranto" class="rounded-circle me-3" style="width: 56px; height: 56px; object-fit: cover;" />
                            <span class="badge   ms-auto fullTime d-flex align-items-center"><img src="{{ asset('/') }}frontend/employer/images/employersHome/fulltime-dot.png" alt="" class="me-1">Full-time</span>
                        </div>
                        <h5 class="card-title fw-bold mb-1">Mohammed Pranto</h5>
                        <p class="card-text mb-2" style="font-size: 14px;">
                            Mobile App Developer, Flutter Developer,<br />Instructor & Mentor
                        </p>
                        <p class="text-muted mb-1" style="font-size: 13px;">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="Location" style="width: 20px;" /> Uttara, Dhaka
                        </p>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <span class="badge bg-light text-dark">3+ yrs</span>
                            <span class="badge bg-light text-dark">3.50 CGPA</span>
                            <span class="badge bg-light text-dark">Developer</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/headhunt-pp2.png" alt="Mohammed Pranto" class="rounded-circle me-3" style="width: 56px; height: 56px; object-fit: cover;" />
                            <span class="badge   ms-auto partTime d-flex align-items-center"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Part-time-dot.png" alt="" class="me-1">Full-time</span>
                        </div>
                        <h5 class="card-title fw-bold mb-1">Mohammed Pranto</h5>
                        <p class="card-text mb-2" style="font-size: 14px;">
                            Mobile App Developer, Flutter Developer,<br />Instructor & Mentor
                        </p>
                        <p class="text-muted mb-1" style="font-size: 13px;">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="Location" style="width: 20px;" /> Uttara, Dhaka
                        </p>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <span class="badge bg-light text-dark">3+ yrs</span>
                            <span class="badge bg-light text-dark">3.50 CGPA</span>
                            <span class="badge bg-light text-dark">Developer</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/headhunt-pp3.png" alt="Mohammed Pranto" class="rounded-circle me-3" style="width: 56px; height: 56px; object-fit: cover;" />
                            <span class="badge   ms-auto Internship d-flex align-items-center"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Internship-dot.png" alt="" class="me-1">Full-time</span>
                        </div>
                        <h5 class="card-title fw-bold mb-1">Mohammed Pranto</h5>
                        <p class="card-text mb-2" style="font-size: 14px;">
                            Mobile App Developer, Flutter Developer,<br />Instructor & Mentor
                        </p>
                        <p class="text-muted mb-1" style="font-size: 13px;">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="Location" style="width: 20px;" /> Uttara, Dhaka
                        </p>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <span class="badge bg-light text-dark">3+ yrs</span>
                            <span class="badge bg-light text-dark">3.50 CGPA</span>
                            <span class="badge bg-light text-dark">Developer</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/headhunt-pp4.png" alt="Mohammed Pranto" class="rounded-circle me-3" style="width: 56px; height: 56px; object-fit: cover;" />
                            <span class="badge   ms-auto Freelancing d-flex align-items-center"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Freelancing.png" alt="" class="me-1">Full-time</span>
                        </div>
                        <h5 class="card-title fw-bold mb-1">Mohammed Pranto</h5>
                        <p class="card-text mb-2" style="font-size: 14px;">
                            Mobile App Developer, Flutter Developer,<br />Instructor & Mentor
                        </p>
                        <p class="text-muted mb-1" style="font-size: 13px;">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="Location" style="width: 20px;" /> Uttara, Dhaka
                        </p>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <span class="badge bg-light text-dark">3+ yrs</span>
                            <span class="badge bg-light text-dark">3.50 CGPA</span>
                            <span class="badge bg-light text-dark">Developer</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/headhunt-pp1.png" alt="Mohammed Pranto" class="rounded-circle me-3" style="width: 56px; height: 56px; object-fit: cover;" />
                            <span class="badge   ms-auto fullTime d-flex align-items-center"><img src="{{ asset('/') }}frontend/employer/images/employersHome/fulltime-dot.png" alt="" class="me-1">Full-time</span>
                        </div>
                        <h5 class="card-title fw-bold mb-1">Mohammed Pranto</h5>
                        <p class="card-text mb-2" style="font-size: 14px;">
                            Mobile App Developer, Flutter Developer,<br />Instructor & Mentor
                        </p>
                        <p class="text-muted mb-1" style="font-size: 13px;">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="Location" style="width: 20px;" /> Uttara, Dhaka
                        </p>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <span class="badge bg-light text-dark">3+ yrs</span>
                            <span class="badge bg-light text-dark">3.50 CGPA</span>
                            <span class="badge bg-light text-dark">Developer</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/headhunt-pp2.png" alt="Mohammed Pranto" class="rounded-circle me-3" style="width: 56px; height: 56px; object-fit: cover;" />
                            <span class="badge   ms-auto partTime d-flex align-items-center"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Part-time-dot.png" alt="" class="me-1">Full-time</span>
                        </div>
                        <h5 class="card-title fw-bold mb-1">Mohammed Pranto</h5>
                        <p class="card-text mb-2" style="font-size: 14px;">
                            Mobile App Developer, Flutter Developer,<br />Instructor & Mentor
                        </p>
                        <p class="text-muted mb-1" style="font-size: 13px;">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="Location" style="width: 20px;" /> Uttara, Dhaka
                        </p>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <span class="badge bg-light text-dark">3+ yrs</span>
                            <span class="badge bg-light text-dark">3.50 CGPA</span>
                            <span class="badge bg-light text-dark">Developer</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
