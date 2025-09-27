<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Mazharul Islam" />
    <!-- Favicon -->
    <link rel="icon" href="images/Logo icon.png" type="image/x-icon" />
    <!-- Google Font: Geist -->
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Your Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/frontend/employer/style.css') }}" />
    <title>Company profile</title>
</head>

<body class=" employeeSettings">

<div class="container-fluid bg-white d-none d-md-block">
    <div class="row align-items-center py-3 border-bottom">
        <div class="col-auto pe-0">
            <a href="{{ url()->previous() }}" class="nav-link">
                <button type="button" class="btn p-0 d-flex align-items-center topSettingButton" aria-label="Back">
                    <img src="{{ asset('/frontend/employer/images/employersHome/leftarrow.png') }}" alt="" class="me-2">
                    <span >Company profile</span>
                </button>
            </a>
        </div>
    </div>
</div>


<div class="container companyProfilecontainer mt-0 mt-md-3">
    <div class="row g-4">
        <!-- Left part -->
        <div class="col-md-4 col-12">
            <div class="card d-flex flex-column  p-4 border rounded-3">
                <div class="mb-3">
                    <img src="{{ asset( $employerCompany->logo ?? '/frontend/company-vector.jpg') }}" alt="Grameenphone Logo" class="companyProfilecontainer__logo" />
                </div>
                <h5 class="fw-semibold mb-4">{{ $employerCompany->name ?? 'Company Name' }}</h5>

                <div class="w-100">
                    <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="Location Icon" class="me-3" />
                        <div>
                            <div class="fw-semibold small mb-1">Location</div>
                            <div class="small text-muted">{{ $employerCompany->address ?? 'Company Location' }}</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile mail.png" alt="Email Icon" class="me-3" />
                        <div>
                            <div class="fw-semibold small mb-1">Email</div>
                            <a href="mailto:contact@gp.com" class="text-decoration-none small">{{ $employerCompany->email ?? 'Company Email' }}</a>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile phone.png" alt="Phone Icon" class="me-3" />
                        <div>
                            <div class="fw-semibold small mb-1">Phone</div>
                            <div class="small text-muted">{{ $employerCompany->phone ?? 'Company Phone' }}</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile website.png" alt="Website Icon" class="me-3" />
                        <div>
                            <div class="fw-semibold small mb-1">Website</div>
                            <a href="https://www.grameenphone.com" target="_blank" class="text-decoration-none small">{{ $employerCompany->website ?? 'Company Website' }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right part -->
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="d-flex justify-content-between align-items-center mb-3 companyProfilecontainer__topbar p-4">
                    <h6 class="mb-0 fw-semibold">Company overview</h6>
                </div>
                <div class=" companyProfilecontainer__right-part p-4">
                    <div class="mb-4 text-muted">
                        {!!  $employerCompany->company_overview ?? 'Company Overview' !!}
                    </div>

                    <div class="d-flex flex-wrap gap-4 companyProfilecontainer__footer-info justify-content-between">
                        <div>
                            <div class="fw-semibold">Industry</div>
                            <div>{{ $employerCompany?->industry?->name ?? 'Industry Name' }}</div>
                        </div>
                        <div>
                            <div class="fw-semibold">Number of employees</div>
                            <div>{{ $employerCompany->total_employees ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="fw-semibold">Founded on</div>
                            <div>{{ $employerCompany->founded_on ?? '1971' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<!-- Bootstrap Bundle JS (with Popper)  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Your Custom JS -->
<script src="{{ asset('/frontend/employee/script.js') }}"></script>
</body>
</html>
