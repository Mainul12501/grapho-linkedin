@extends('frontend.employer.master')

@section('title', 'Employer Profile')

@section('body')

            <div class="ps-3 py-2 d-block d-md-none bg-white">
                <a href="{{ url()->previous() }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt=""></a>
            </div>
            <style>
                @media screen and (max-width: 426px){
                    .mobile-padding-0 {
                        padding: 0px!important;
                        border-radius: 0px!important;
                    }
                    .p-sm-0 {padding-top: 0px!important;}
                }
                @media (max-width: 768px) {
                    .profileLeftCard {
                        border-radius: 0px !important;
                        border: 0px!important;
                    }
                }
            </style>

            <div class="employerProfile container-fluid py-2 p-sm-0">
                <div class="row g-4">
                    <!-- Left profile card -->
                    <div class="col-lg-3 mobile-padding-0">
                        <div class="card rounded-3 p-4  profileLeftCard" style="">
                            <div class="mb-4 profile-left-card-info">
                                <div class="">
                                    <img
                                        src="{{ isset($employeeDetails->profile_image) ? asset($employeeDetails->profile_image) : asset('/frontend/user-vector-img.jpg') }}"
                                        alt="Profile Picture"
                                        class="rounded-circle"
                                        style="width: 80px; height: 80px; object-fit: cover"
                                    />
                                </div>
                                <h5 class="fw-bold mb-2 mt-3 f-s-23" style="border-radius: 0px">{{ $employeeDetails->name ?? 'User Name' }}</h5>

                                @if($employeeDetails->is_open_for_hire == 1)
                                    <span class="badge d-inline-flex align-items-center mb-3 gap-2">
                                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/Open to Full-time Roles.png" alt=""> Open to hire
                                    </span>
                                @endif

                                <p class="skills mb-3">
                                    {{ $employeeDetails->profile_title ?? 'Employee profile Title here' }}
                                </p>
                            </div>

                            <div class="d-flex gap-2 mb-4">
                                <a href="{{ url("/chat/$employeeDetails->id" ) }}" target="_blank" class="btn btn-dark flex-grow-1 d-flex align-items-center justify-content-center gap-2">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/messengerIcon.png" alt=""> {{ trans('common.message') }}
                                </a>
                                <a href="tel:{{ $employeeDetails->mobile }}" class="btn btn-outline-dark flex-grow-1 d-flex align-items-center justify-content-center gap-2">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profileCallIcon.png" alt=""> Call
                                </a>
                            </div>

                            <ul class="list-unstyled mb-0 d-block d-md-none">
                                <li class="mb-3 d-flex align-items-center gap-3">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile location.png" alt="">
                                    <div>
                                        <small class="fw-bold d-block">{{ trans('common.location') }}</small>
                                        {{ $employeeDetails->location ?? 'Ex: Dhaka, Bangladesh' }}
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-center gap-3">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile mail.png" alt="">
                                    <div>
                                        <small class="fw-bold d-block">{{ trans('common.email') }}</small>
                                        <a href="mailto:md.pranto@gmail.com" class="text-decoration-none">{{ $employeeDetails->email ?? 'email@gmail.com' }}</a>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-center gap-3">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile phone.png" alt="">
                                    <div>
                                        <small class="fw-bold d-block">{{ trans('common.phone') }}</small>
                                        {{ $employeeDetails->mobile ?? 'Ex: +880 123 456 7890' }}
                                    </div>
                                </li>
                                {{--                                <li class="d-flex align-items-center gap-3">--}}
                                {{--                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/profile website.png" alt="">--}}
                                {{--                                    <div>--}}
                                {{--                                        <small class="fw-bold d-block">Website</small>--}}
                                {{--                                        <a href="https://www.devpranto.com" target="_blank" class="text-decoration-none">{{ $employeeDetails->website ?? 'grapho.com' }}</a>--}}
                                {{--                                    </div>--}}
                                {{--                                </li>--}}
                            </ul>
                        </div>
                    </div>
                    <style>
                        @media screen and (max-width: 576px) {
                            .card-sm-only {
                                border: none !important;
                                background: none !important;
                                box-shadow: none !important;
                                padding-bottom: 10px!important;
                                padding-left: 0px!important;
                            }
                        }
                    </style>
                    <!-- Right content -->
                    <div class="col-lg-9">
                        <!-- Work Experiences -->
                        <section class="mb-5">
                            <h5 class="card card-sm-only mb-0 p-4 p-md-4 ps-md-4 ps-0 fw-semibold f-s-23" style="border-radius: 0px!important;">{{ trans('employee.work_experiences') }}</h5>
                            @forelse($employeeDetails->employeeWorkExperiences as $workExperience)
                                <div class="card p-4 shadow-sm rounded-3" style="border-radius: 0px!important;">
                                    <div class="d-flex align-items-start mb-3 gap-3">
                                        <img src="{{ asset($workExperience->company_logo ?? (isset($siteSetting) ? $siteSetting->common_institute_logo : '/frontend/company-vector.jpg')) }}" alt="company Logo" style=" object-fit: contain; height: 60px; border-radius: 50%" />
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $workExperience->position ?? 'Officer' }}</h6>
                                            <small class="text-muted">{{ $workExperience->company_name }} &bull; {{ $workExperience->job_type ?? 'Full Time' }}</small><br />
                                            <small class="text-muted">{{ $workExperience->is_working_currently == 1 ? (\Illuminate\Support\Carbon::parse($workExperience->start_date)->format('M Y') ?? 'Jan 1971').' - Present' : (\Illuminate\Support\Carbon::parse($workExperience->start_date)->format('M Y') ?? 'Jan 2025').' - '.(\Illuminate\Support\Carbon::parse($workExperience->end_date)->format('M Y') ?? 'Jan 2025') }} &bull; {{ $workExperience->duration ?? '0 Years' }}</small><br />
                                            <small class="text-muted">{{ $workExperience->office_address ?? 'Dhaka, Bangladesh' }}</small>

                                            <p class="mb-1 fw-semibold mt-2">Job Summary:</p>
                                            <div>
                                                {!! str()->words($workExperience->job_responsibilities, 30, ' ....') ?? 'Job responsibilities' !!}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @empty
                                <div class="card  p-4 mb-4 shadow-sm rounded-3" style="border-radius: 0px!important">
                                    <p class="f-s-26 text-center">No Data Available</p>
                                </div>
                            @endforelse
                        </section>


                        <!-- Education -->
                        <section class="mb-5">
                            <h5 class="card card-sm-only mb-0 fw-semibold p-4 f-s-23" style="border-radius: 0px!important">{{ trans('employee.education') }}</h5>
                            @forelse($employeeDetails->employeeEducations as $education)
                                <div class="card p-4 shadow-sm rounded-3" style="border-radius: 0px!important;">
                                    <div class="d-flex align-items-start mb-3 gap-3">
                                        <img src="{{ asset( $education?->universityName?->logo ?? (isset($siteSetting) ? $siteSetting->common_institute_logo : '/frontend/company-vector.jpg')) }}" alt="institute Logo" style=" object-fit: contain; border-radius: 50%" height="60"  />
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $education?->institute_name ?? 'Institute Name' }}</h6>
                                            <small class="text-muted">{{ $education?->educationDegreeName?->degree_name ?? 'Degree Name' }} - {{ $education?->field_of_study ?? '' }} &bull; CGPA {{ $education->cgpa ?? 0 }}</small><br />                                            <small class="text-muted">Jan 2017 - Jul 2024</small><br />
{{--                                            <small class="text-muted">{{ $education->address ?? 'Address' }}</small>--}}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="card  p-4 mb-4 shadow-sm rounded-3" style="border-radius: 0px!important">
                                    <p class="f-s-26 text-center">No Data Available</p>
                                </div>
                            @endforelse
                        </section>


                        <!-- documents -->
                        <!-- Education -->
                        <section class="mb-5">
                            <h5 class="card card-sm-only mb-0 fw-semibold p-4 f-s-23">{{ trans('employee.documents') }}</h5>
                            @forelse($employeeDetails->employeeDocuments as $document)
                                <div class="card p-4 shadow-sm rounded-3" style="border-radius: 0px!important;">
                                    <div class="d-flex align-items-center mb-3 gap-3">
                                        <a href="{{ asset($document->file) }}" download="">
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
                                                <img style="width: 105px; height: 105px" src="https://files.softicons.com/download/toolbar-icons/mono-general-icons-2-by-custom-icon-design/ico/document.ico" alt="Company Logo" class="mobileLogo" />
                                            @endif
                                        </a>
{{--                                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/curriculam-dita.png" alt="UCB Logo" style=" object-fit: contain;" />--}}
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $document->title ?? 'File Title' }}</h6>
                                            <small class="text-muted">{{ $document->file_type ?? 'File type: ' }} &bull; {{ $document->file_size ?? '0 KB' }}</small>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="card  p-4 mb-4 shadow-sm rounded-3" style="border-radius: 0px!important">
                                    <p class="f-s-26 text-center">No Data Available</p>
                                </div>
                            @endforelse
                        </section>
                    </div>
                </div>
            </div>
@endsection
