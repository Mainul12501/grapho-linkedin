@extends('frontend.employer.master')

@section('title', 'Company Profile')

@section('body')
    <div class="employeeSettings">

        <div class="container companyProfilecontainer mt-0 mt-md-3">
            <div class="row g-4">
                <!-- Left part -->
                <div class="col-md-4 col-12">
                    <div class="card d-flex flex-column  p-4 border rounded-3">
                        <div class="mb-3">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/gpLogo.png" alt="Grameenphone Logo" class="companyProfilecontainer__logo" />
                        </div>
                        <h5 class="fw-semibold mb-4">Grameenphone Ltd.</h5>

                        <div class="w-100">
                            <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="Location Icon" class="me-3" />
                                <div>
                                    <div class="fw-semibold small mb-1">Location</div>
                                    <div class="small text-muted">Dhaka, Bangladesh</div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile mail.png" alt="Email Icon" class="me-3" />
                                <div>
                                    <div class="fw-semibold small mb-1">Email</div>
                                    <a href="mailto:contact@gp.com" class="text-decoration-none small">contact@gp.com</a>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile phone.png" alt="Phone Icon" class="me-3" />
                                <div>
                                    <div class="fw-semibold small mb-1">Phone</div>
                                    <div class="small text-muted">+8801653523779</div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile website.png" alt="Website Icon" class="me-3" />
                                <div>
                                    <div class="fw-semibold small mb-1">Website</div>
                                    <a href="https://www.grameenphone.com" target="_blank" class="text-decoration-none small">www.grameenphone.com</a>
                                </div>
                            </div>

                            <button class="btn btn-link p-0 mt-3 editButtonCompanyProfile" style="font-size: 0.9rem;"> <img src="{{ asset('/') }}frontend/employer/images/employersHome/Edit pencil.png" alt=""> Edit contact info</button>
                        </div>
                    </div>
                </div>

                <!-- Right part -->
                <div class="col-md-8 col-12">
                    <div class="card">
                        <div class="d-flex justify-content-between align-items-center mb-3 companyProfilecontainer__topbar p-4">
                            <h6 class="mb-0 fw-semibold">Company overview</h6>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                        </div>
                        <div class=" companyProfilecontainer__right-part p-4">
                            <div class="mb-4">
                                <p class="mb-3">
                                    The right and contemporary use of technology is key to the progress of a nation. Keeping this in mind, Grameenphone always brings future-proof technology in order to facilitate your progress. The possibilities in this new world are immense and someone as bright as you should be the forerunner in leading the change. At the end of the day, Grameenphone believes, individual progresses eventually accumulate in progress of a nation.
                                </p>
                                <p class="mb-3">
                                    A career at Grameenphone is about going beyond your ability to help society move ahead. Challenges here are met not by individuals but by teams – teams that live by the values, strives to innovate & are always ready to take on the challenge of creating winning solutions. Armed with the most employee friendly policies of the country and avant-garde infrastructure, the Grameenphone employees are relentless in their mission to help the customers to reap the benefit of staying connected.
                                </p>
                                <p>
                                    In Grameenphone, we believe in the power of people to transform the society for the better. So we are dedicated to build and develop supreme talents that are at par with its unyielding growth. So explore your opportunities with Grameenphone today if you are ready to Go Beyond.
                                </p>
                            </div>

                            <div class="d-flex flex-wrap gap-4 companyProfilecontainer__footer-info justify-content-between">
                                <div>
                                    <div class="fw-semibold">Industry</div>
                                    <div>Telecommunication</div>
                                </div>
                                <div>
                                    <div class="fw-semibold">Number of employees</div>
                                    <div>500+</div>
                                </div>
                                <div>
                                    <div class="fw-semibold">Founded on</div>
                                    <div>1997</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>

@endsection
