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
                                        src="{{ isset($employeeDetails->profile_image) ? asset($employeeDetails->profile_image) : 'https://randomuser.me/api/portraits/men/75.jpg' }}"
                                        alt="Profile Picture"
                                        class="rounded-circle"
                                        style="width: 80px; height: 80px; object-fit: cover"
                                    />
                                </div>
                                <h5 class="fw-bold mb-1">{{ $employeeDetails->name ?? 'User Name' }}</h5>

                                @if($employeeDetails->is_open_for_hire == 1)
                                    <span class="badge d-inline-flex align-items-center mb-3 gap-2">
                                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/Open to Full-time Roles.png" alt=""> Open to Full-time Roles
                                    </span>
                                @endif

                                <p class="skills mb-3">
                                    {{ $employeeDetails->profile_title ?? 'Profile Moto like Mobile App Developer, Flutter Developer, Instructor & Mentor' }}
                                </p>
                            </div>

                            <div class="d-flex gap-2 mb-4">
                                <a href="javascript:void(0)" class="btn btn-dark flex-grow-1 d-flex align-items-center justify-content-center gap-2">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/messengerIcon.png" alt=""> Message
                                </a>
                                <a href="tel:{{ $employeeDetails->mobile }}" class="btn btn-outline-dark flex-grow-1 d-flex align-items-center justify-content-center gap-2">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profileCallIcon.png" alt=""> Call
                                </a>
                            </div>

                            <ul class="list-unstyled mb-0">
                                <li class="mb-3 d-flex align-items-center gap-3">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="">
                                    <div>
                                        <small class="fw-bold d-block">Location</small>
                                        {{ $employeeDetails->location ?? 'Ex: Dhaka, Bangladesh' }}
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-center gap-3">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile mail.png" alt="">
                                    <div>
                                        <small class="fw-bold d-block">Email</small>
                                        <a href="mailto:md.pranto@gmail.com" class="text-decoration-none">{{ $employeeDetails->email ?? 'email@gmail.com' }}</a>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-center gap-3">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile phone.png" alt="">
                                    <div>
                                        <small class="fw-bold d-block">Phone</small>
                                        {{ $employeeDetails->mobile ?? 'Ex: +880 123 456 7890' }}
                                    </div>
                                </li>
                                <li class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile website.png" alt="">
                                    <div>
                                        <small class="fw-bold d-block">Website</small>
                                        <a href="https://www.devpranto.com" target="_blank" class="text-decoration-none">{{ $employeeDetails->website ?? 'grapho.com' }}</a>
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
                            @forelse($employeeDetails->employeeWorkExperiences as $workExperience)
                                <div class="card p-4 mb-4 shadow-sm rounded-3">
                                    <div class="d-flex align-items-center mb-3 gap-3">
                                        <img src="{{ asset($workExperience->company_logo ?? '/frontend/employer/images/employersHome/profileCompany-1.png') }}" alt="UCB Logo" style=" object-fit: contain;" />
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $workExperience->position ?? 'Officer' }}</h6>
                                            <small class="text-muted">{{ $workExperience->company_name }} &bull; {{ $workExperience->job_type ?? 'Full Time' }}</small><br />
                                            <small class="text-muted">{{ $workExperience->is_working_currently == 1 ? (\Illuminate\Support\Carbon::parse($workExperience->start_date)->format('M Y') ?? 'Jan 2025').' - Present' : (\Illuminate\Support\Carbon::parse($workExperience->start_date)->format('M Y') ?? 'Jan 2025').' - '.(\Illuminate\Support\Carbon::parse($workExperience->end_date)->format('M Y') ?? 'Jan 2025') }} &bull; {{ $workExperience->duration ?? '0 Years' }}</small><br />
                                            <small class="text-muted">{{ $workExperience->office_address ?? 'Dhaka, Bangladesh' }}</small>
                                        </div>
                                    </div>
                                    <p class="mb-1 fw-semibold">Job Summary:</p>
                                    <p>{!! $workExperience->job_responsibilities ?? 'Job responsibilities' !!}</p>
                                </div>
                            @empty
                                <div class="card  p-4 mb-4 shadow-sm rounded-3">
                                    <p class="f-s-26 text-center">No Data Available</p>
                                </div>
                            @endforelse


{{--                            <div class="card p-4 shadow-sm rounded-3">--}}
{{--                                <div class="d-flex align-items-center mb-3 gap-3">--}}
{{--                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profileCompany-2.png" alt="HSBC Logo" object-fit: contain;" />--}}
{{--                                    <div>--}}
{{--                                        <h6 class="mb-0 fw-bold">Sales Intern</h6>--}}
{{--                                        <small class="text-muted">HSBC &bull; Full Time</small><br />--}}
{{--                                        <small class="text-muted">Jul 2024 - Dec 2024 &bull; 5 mos</small><br />--}}
{{--                                        <small class="text-muted">Dhaka, Bangladesh</small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <p class="mb-1 fw-semibold">Job Summary:</p>--}}
{{--                                <ul>--}}
{{--                                    <li>This was my first job in the banking field.</li>--}}
{{--                                    <li>I gained a good amount of leadership skills & learned to think about the business side of banking.</li>--}}
{{--                                    <li>After a while, I led a team of three. I had to maintain communication with the stakeholders.</li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
                        </section>


                        <!-- Education -->
                        <section class="mb-5">
                            <h5 class="fw-semibold mb-4">Education</h5>
                            @forelse($employeeDetails->employeeEducations as $education)
                                <div class="card p-4 mb-4 shadow-sm rounded-3">
                                    <div class="d-flex align-items-center mb-3 gap-3">
                                        <img src="{{ asset( $education?->universityName?->logo ?? '/frontend/employer/images/employersHome/profile-education-1.png') }}" alt="UCB Logo" style=" object-fit: contain;" />
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $education?->universityName?->name ?? 'University Name' }}</h6>
                                            <small class="text-muted">{{ $education?->educationDegreeName?->degree_name ?? 'Degree Name' }} - {{ $education?->mainSubject?->subject_name ?? '' }} &bull; CGPA {{ $education->cgpa ?? 0 }}</small><br />                                            <small class="text-muted">Jan 2017 - Jul 2024</small><br />
                                            <small class="text-muted">{{ $education->address ?? 'Address' }}</small>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="card  p-4 mb-4 shadow-sm rounded-3">
                                    <p class="f-s-26 text-center">No Data Available</p>
                                </div>
                            @endforelse


{{--                            <div class="card p-4 shadow-sm rounded-3">--}}
{{--                                <div class="d-flex align-items-center mb-3 gap-3">--}}
{{--                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile-education-2.png" alt="HSBC Logo" object-fit: contain;/>--}}
{{--                                    <div>--}}
{{--                                        <h6 class="mb-0 fw-bold">Notre Dame College</h6>--}}
{{--                                        <small class="text-muted">BBA - Marketing &bull; CGPA 3.45</small><br />--}}
{{--                                        <small class="text-muted">Jan 2017 - Jul 2024</small><br />--}}
{{--                                        <small class="text-muted">Dhaka, Bangladesh</small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </section>


                        <!-- documents -->
                        <!-- Education -->
                        <section class="mb-5">
                            <h5 class="fw-semibold mb-4">Documents</h5>
                            @forelse($employeeDetails->employeeDocuments as $document)
                                <div class="card p-4 mb-4 shadow-sm rounded-3">
                                    <div class="d-flex align-items-center mb-3 gap-3">
                                        @if( explode('/', $document->file_type)[1] == 'image' )
                                            <img style="max-width: 105px; max-height: 105px;" src="{{ isset($document->file_thumb) ? asset($document->file_thumb) : 'https://icons.iconarchive.com/icons/icons8/windows-8/512/Very-Basic-Image-File-icon.png' }}" alt="Company Logo" class="companyLogo" />
{{--                                            <img style="width: 40px; height: 42px" src="{{ isset($document->file_thumb) ? asset($document->file_thumb) : 'https://icons.iconarchive.com/icons/icons8/windows-8/512/Very-Basic-Image-File-icon.png'}}" alt="Company Logo" class="mobileLogo" />--}}
                                        @elseif( explode('/', $document->file_type)[1] == 'pdf' )
                                            <img style="max-width: 105px; max-height: 105px;" src="https://www.iconpacks.net/icons/2/free-pdf-icon-3375-thumb.png" alt="Company Logo" class="companyLogo" />
{{--                                            <img style="width: 40px; height: 42px" src="https://www.iconpacks.net/icons/2/free-pdf-icon-3375-thumb.png" alt="Company Logo" class="mobileLogo" />--}}
                                        @elseif( explode('/', $document->file_type)[1] == 'vnd.openxmlformats-officedocument.wordprocessingml.document' )
                                            <img style="max-width: 105px; max-height: 105px;" src="https://files.softicons.com/download/toolbar-icons/mono-general-icons-2-by-custom-icon-design/ico/document.ico" alt="Company Logo" class="companyLogo" />
{{--                                            <img style="width: 40px; height: 42px" src="https://files.softicons.com/download/toolbar-icons/mono-general-icons-2-by-custom-icon-design/ico/document.ico" alt="Company Logo" class="mobileLogo" />--}}
                                        @else
{{--                                            <img style="max-width: 105px; max-height: 105px;" src="{{ asset('/') }}frontend/employee/images/profile/CV.png" alt="Company Logo" class="companyLogo" />--}}
                                            <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/profile/CV.png" alt="Company Logo" class="mobileLogo" />
                                        @endif
{{--                                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/curriculam-dita.png" alt="UCB Logo" style=" object-fit: contain;" />--}}
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $document->title ?? 'File Title' }}</h6>
                                            <small class="text-muted">{{ $document->file_type ?? 'File type: ' }} &bull; {{ $document->file_size ?? '0 KB' }}</small>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="card  p-4 mb-4 shadow-sm rounded-3">
                                    <p class="f-s-26 text-center">No Data Available</p>
                                </div>
                            @endforelse


{{--                            <div class="card p-4 shadow-sm rounded-3">--}}
{{--                                <div class="d-flex align-items-center mb-3 gap-3">--}}
{{--                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/NID.png" alt="HSBC Logo" object-fit: contain;/>--}}
{{--                                    <div>--}}
{{--                                        <div>--}}
{{--                                            <h6 class="mb-0 fw-bold">Curriculum Vitae</h6>--}}
{{--                                            <small class="text-muted">PDF &bull; 325 KB</small>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </section>
                    </div>
                </div>
            </div>
@endsection
