@extends('frontend.employer.master')

@section('title', 'Company Profile')

@section('body')
    <div class="employeeSettings">

        <div class="container companyProfilecontainer mt-0 mt-md-3">
            <div class="row g-4">
                <!-- Left part -->
                <div class="col-md-4 col-12 text-break">
                    <div class="card d-flex flex-column  p-4 border rounded-3">
                        <div class="mb-3">
                            <img src="{{ asset( $companyDetails->logo ??  '/frontend/company-vector.jpg') }}" alt="{{ $companyDetails->name ?? 'company' }}-Logo" class="companyProfilecontainer__logo" />
                        </div>
                        <h5 class="fw-semibold mb-4">{{ $companyDetails->name ?? 'Company Name' }}</h5>

                        <div class="w-100">
                            <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="Location Icon" class="me-3" />
                                <div>
                                    <div class="fw-semibold small mb-1">Location</div>
                                    <div class="small text-muted">{!! $companyDetails->address ?? 'Dhaka, Bangladesh' !!}</div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile mail.png" alt="Email Icon" class="me-3" />
                                <div>
                                    <div class="fw-semibold small mb-1">Email</div>
                                    <a href="mailto:contact@gp.com" class="text-decoration-none small">{{ $companyDetails->email ?? 'email@company.com' }}</a>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile phone.png" alt="Phone Icon" class="me-3" />
                                <div>
                                    <div class="fw-semibold small mb-1">Phone</div>
                                    <div class="small text-muted">{{ $companyDetails->phone ?? '01600000000' }}</div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3 companyProfilecontainer__contact-item">
                                <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile website.png" alt="Website Icon" class="me-3" />
                                <div>
                                    <div class="fw-semibold small mb-1">Website</div>
                                    <a href="https://www.grameenphone.com" target="_blank" class="text-decoration-none small">{{ $companyDetails->website ?? 'company.com' }}</a>
                                </div>
                            </div>
                            @if($employerView)
                                <button class="btn btn-link p-0 mt-3 editButtonCompanyProfile" data-bs-toggle="modal" data-bs-target="#employerCompanyEditModal" style="font-size: 0.9rem;"> <img src="{{ asset('/') }}frontend/employer/images/employersHome/Edit pencil.png" alt=""> Edit contact info</button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right part -->
                <div class="col-md-8 col-12">
                    <div class="card">
                        <div class="d-flex justify-content-between align-items-center mb-3 companyProfilecontainer__topbar p-4 border-bottom">
                            <h6 class="mb-0 fw-semibold">Company overview</h6>
                            @if($employerView)
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#employerCompanyEditModal">Edit</button>
                            @endif
                            @if(!$employerView)
                                <div class="text-warning">
                                    <a href="{{ route('twilio.view') }}" class="f-s-18" title="Video Call"><i class="fa-solid text-success fa-video"></i></a>
                                    <a href="{{ url('/chat/'.$companyDetails->id) }}" class="f-s-18" title="Send Message"><i class="fa-brands text-success fa-telegram"></i></a>
                                </div>
                            @endif
                        </div>
                        <div class=" companyProfilecontainer__right-part pb-4 pt-1 px-4">
                            <div class="mb-4">
                                {!! $companyDetails->company_overview ?? strip_tags('<p class="f-s-30">Company Overview Not found</p>') !!}
                            </div>

                            <div class="d-flex flex-wrap gap-4 companyProfilecontainer__footer-info justify-content-between">
                                <div>
                                    <div class="fw-semibold">Industry</div>
                                    <div>{{ $companyDetails?->industry?->name ?? 'Telecommunication' }}</div>
                                </div>
                                <div>
                                    <div class="fw-semibold">Number of employees</div>
                                    <div>{{ $companyDetails->total_employees ?? 0 }}</div>
                                </div>
                                <div>
                                    <div class="fw-semibold">Founded on</div>
                                    <div>{{ $companyDetails->founded_on ?? '1971' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- modal -->
    <div class="modal fade" id="employerCompanyEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Company Info</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('employer.update-company-info') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Company Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $companyDetails->name ?? '' }}" placeholder="Enter Your Full Name" >
                            </div>
                            <div class="col-md-6">
                                <label for="">Email</label>
                                <input type="text" class="form-control" name="email" value="{{ $companyDetails->email ?? '' }}" placeholder="Enter Your Email" >
                            </div>
                            <div class="col-md-6">
                                <label for="">Mobile</label>
                                <input type="text" class="form-control" name="phone" value="{{ $companyDetails->phone ?? '' }}" placeholder="Enter Your Mobile Number" >
                            </div>
                            <div class="col-md-6">
                                <label for="">Website</label>
                                <input type="text" class="form-control" name="website" value="{{ $companyDetails->website ?? '' }}" placeholder="Enter Company website address" >
                            </div>
                        </div>
                        <div class="row mt-3">

                            <div class="col-md-6">
                                <label for="">Number of employees</label>
                                <input type="text" class="form-control" name="total_employees" value="{{ $companyDetails->total_employees ?? '' }}" placeholder="Enter Number of employees" >
                            </div>
                            <div class="col-md-6">
                                <label for="">Founded on</label>
                                <input type="text" class="form-control" name="founded_on" value="{{ $companyDetails->founded_on ?? '' }}" placeholder="Enter Founded Year" >
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="selectCompanyCategory">Select Company Category</label>
                                <select name="employer_company_category_id" id="selectCompanyCategory" class="form-control select2">
                                    <option value="">Select Industry</option>
                                    @foreach ($employerCompanyCategories as $employerCompanyCategory)
                                        <option value="{{ $employerCompanyCategory->id }}" {{ $companyDetails->employer_company_category_id == $employerCompanyCategory->id ? 'selected' : '' }}>{{ $employerCompanyCategory->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="selectIndustry">Select Industry</label>
                                <select name="industry_id" id="selectIndustry" class="form-control select2">
                                    <option value="">Select Industry</option>
                                    @foreach ($industries as $industry)
                                        <option value="{{ $industry->id }}" {{ $companyDetails->industry_id == $industry->id ? 'selected' : '' }}>{{ $industry->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="setLogo">Set Logo</label>
                                <div>
                                    <input type="file" name="logo" class="" accept="image/*" />

                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                @if(isset($companyDetails->logo))
                                    <img src="{{ asset($companyDetails->logo) }}" alt="Company Logo" placeholder="Enter Company Logo" class="img-fluid mt-2" style="max-height: 80px; max-width: 100px;">
                                @endif
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="companyOverview">Company Overview</label>
                                <textarea name="company_overview" class="form-control summernote" id="" cols="30" rows="10">{!! $companyDetails->company_overview !!}</textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="">BIN Number</label>
                                <input type="text" class="form-control" name="bin_number" value="{{ $companyDetails->bin_number ?? '' }}" />
                            </div>
                            <div class="col-md-6">
                                <label for="">Trade License Number</label>
                                <input type="text" class="form-control" name="trade_license_number" value="{{ $companyDetails->trade_license_number ?? '' }}" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('script')
    @include('common-resource-files.selectize')
    @include('common-resource-files.summernote')
@endpush
