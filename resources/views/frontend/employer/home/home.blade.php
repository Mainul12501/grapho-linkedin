@extends('frontend.employer.master')

@section('title', 'Employer Home')

@section('body')
    <main class="dashboardContent p-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="float-end mobile-search-float-left-0">
                        <form action="" method="get">
                            <div class="input-group mb-3" style="max-width: 400px">
                                <input type="text" name="search_text" class="form-control" placeholder="{{ trans('employer.search_company') }}">
                                <button type="submit" class="input-group-text" id="basic-addon2">{{ trans('common.search') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class=" {{ count($advertisements) > 0 ? 'col-md-8 col-sm-11 mx-auto' : ' col-md-10 me-auto' }}" id="appendContentHere">
                    @if(!\App\Helpers\ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
                        <div class="card card-body d-flex">
                            <p class="d-inline-flex">{{ trans('employer.have_something_new_on_mind') }}</p>
                            <p class="d-inline-flex"><a href="{{ route('employer.posts.create') }}" class="btn btn-sm btn-success border-0" style="background-color: #FFCB11">{{ trans('employer.post') }}</a></p>
                        </div>
                    @endif
{{--                    employee suggestion--}}
                        <div class="py-3">
                            <div >
                                <div class="row">
                                    <div class="col-12">
                                        <div>
                                            <h3>Employee Suggestions</h3>
                                        </div>
                                        <div class="employee-suggestions">
                                            <div class="owl-carousel owl-theme" >
                                                @foreach($employees as $employee)
                                                    <div class="item">
                                                        <a href="{{ route('employee-profile', $employee->id) }}" style="text-decoration: none">
                                                            <article class="talent-card">
                                                                <img src="{{ asset($employee->profile_image ?? '/frontend/user-vector-img.jpg') }}"
                                                                     alt="Mohammed Pranto" class="talent-img" style="width: 60px!important;" />
                                                                <div class="talent-details mt-2">
                                                                    <h6>{{ $employee->name ?? trans('common.employee_name') }}</h6>
                                                                    <p>{{ $employee->profile_title ?? trans('employee.profile_title') }}</p>
                                                                    <span>
                                                                    <i class="bi bi-geo-alt"></i>
                                                                    <span class="ms-1" style="text-decoration: none">{!! str()->words($employee->address, 10) ?? trans('common.user_address') !!}</span>
                                                                </span>
                                                                    <div class="talent-meta mt-2">

                                                                        <span class="p-1">{{ $employee?->employeeWorkExperiences[0]?->duration ?? 0 }}+ {{ trans('common.yrs') }}</span>
                                                                        <span class="p-1">{{ $employee?->employeeEducations[$employee->employeeEducations()->count() - 1]?->cgpa ?? 0.0 }} {{ trans('common.cgpa') }}</span>
                                                                    </div>
                                                                </div>
                                                            </article>
                                                        </a>
                                                    </div>
                                                @endforeach
                                                    <div class="item" id="viewMore">
                                                        <a href="{{ route('employer.employee-suggestions') }}" class="text-decoration-none" style="cursor: pointer">
                                                            <article class="talent-card view-more-card text-center">
                                                                <div class="view-more-icon mb-3">
                                                                    <i class="bi bi-arrow-up-right-circle"></i>
{{--                                                                    <img src="{{ isset($siteSettin) ? asset($siteSettin->logo) : '' }}" alt="site-logo" style="height: 54px; width: 54px">--}}
                                                                </div>
                                                                <h6 class="mb-1">View more talents</h6>
                                                                <p class="mb-0 text-muted small">Discover more profiles on LikewiseBD</p>
                                                            </article>
                                                        </a>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>




{{--                    contents appends here--}}
                </div>
                @if(count($advertisements) > 0)
                    <div class="col-md-4 " id="advertisementContainer">
                        @if(count($advertisements) > 0)
                            <div>
                                @foreach($advertisements as $advertisement)
                                    <div class="py-1">
                                        <a href="{{ url(`/`.$advertisement->redirect_url) }}">
                                            <img style="max-height: 300px" src="{{ asset($advertisement->banner) }}" alt="" class="img-fluid ">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

    </main>
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @media screen and (max-width: 425px){
            #advertisementContainer {display: none}
        }
        @media screen and (max-width: 768px){
            #appendContentHere {padding-left: 10px!important;}
            .mobile-search-float-left-0 {float: none!important;}
        }
        /*.owl-nav {display: none;}*/
        /*.owl-dots {display: none;}*/

        /*owl carousal css mod*/
        .owl-prev-btn, .owl-next-btn {
            font-size: 24px;
            color: #333;
            background: #fff;
            border-radius: 50%;
            padding: 6px 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            cursor: pointer;
        }

        .owl-nav {
            display: flex;
            justify-content: space-between;
            position: absolute;
            top: 30%;
            width: 100%;
        }

        .owl-nav button {
            background: transparent !important;
            border: none !important;
        }

        /*.owl-stage { width: 100%}*/

        /* keep the sidebar width fixed */
        .employeHome .sidebar { flex: 0 0 250px; min-width: 250px; }

        /* let the main content shrink instead of forcing the flex parent wider */
        .employeHome .mainContent { min-width: 0; overflow: hidden; }

        /* contain the carousel giant stage width */
        .employee-suggestions .owl-carousel,
        .employee-suggestions .owl-stage-outer { width: 100%; overflow: hidden; }
        .employee-suggestions .owl-stage { display: flex; }

        /* view more card styling */
        .view-more-card {
            min-height: 160px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f9fafc, #eef1f6);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .view-more-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }
        .view-more-icon {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #141c25;
            color: #ffcb11;
            font-size: 26px;
        }

    </style>


{{--    post header css--}}
    <style>
        /* Header layout - Horizontal flex */
        .header-div {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            flex-wrap: nowrap;
        }

        /* Company info section - Vertical stack (image on top, name below) */
        .company-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            flex-shrink: 0;
            width: 80px;
        }

        .company-img {
            display: block;
            margin-bottom: 6px;
        }

        .company-img img {
            height: 60px;
            width: 60px;
            border-radius: 8px;
            object-fit: cover;
        }

        .company-name {
            font-weight: 700;
            color: #333;
            display: block;
            font-size: 14px;
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        /* Post title - Takes remaining space */
        .post-title {
            flex: 1;
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            line-height: 1.4;
            word-wrap: break-word;
            overflow-wrap: break-word;
            padding-top: 5px;
            min-width: 0; /* Important for flex text wrapping */
        }

        /* Follow button - Right side */
        .follow-unfollow-btn {
            flex-shrink: 0;
            align-self: flex-start;
        }

        .follow-btn {
            white-space: nowrap;
            padding: 6px 16px;
            font-size: 14px;
            min-width: 90px;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .header-div {
                gap: 12px;
            }

            .post-title {
                font-size: 16px;
            }

            .follow-btn {
                padding: 5px 12px;
                font-size: 13px;
                min-width: 80px;
            }

            .company-info {
                width: 70px;
            }
        }

        @media (max-width: 576px) {
            .header-div {
                gap: 10px;
            }

            .company-info {
                width: 60px;
            }

            .company-img img {
                height: 50px;
                width: 50px;
            }

            .company-name {
                font-size: 12px;
            }

            .post-title {
                font-size: 14px;
                line-height: 1.3;
            }

            .follow-btn {
                padding: 4px 8px;
                font-size: 12px;
                min-width: 65px;
            }
        }

        @media (max-width: 400px) {
            .header-div {
                gap: 8px;
            }

            .company-info {
                width: 55px;
            }

            .company-img img {
                height: 45px;
                width: 45px;
            }

            .company-name {
                font-size: 11px;
            }

            .post-title {
                font-size: 13px;
            }

            .follow-btn {
                padding: 3px 6px;
                font-size: 11px;
                min-width: 60px;
            }
        }

        /* Card improvements */
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>

@endpush

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            responsiveClass:true,
            nav: true,
            dots: false,
            navText: [
                '<span class="owl-prev-btn">&#10094;</span>',   // left arrow
                '<span class="owl-next-btn">&#10095;</span>'    // right arrow
            ],
            responsive:{
                0:{
                    items:2,
                    nav:true
                },
                600:{
                    items:3,
                    nav:false
                },
                1000:{
                    items:3,
                    nav:true,
                    loop:false
                }
            }
        })
    </script>
    <script>
        equalizeHeights('item');
    </script>
    <script>
        var startNumber = 0;
        var endNumber = 10;
        $(document).ready(function () {
            sendAjaxRequest(`employer/home?start_number=${startNumber}`, 'GET').then(function (response) {
                $('#appendContentHere').append(response);
                startNumber += 1;
            })
        });

        let loading = false;
        $(window).on('scroll', function () {
            if (!loading && $(window).scrollTop() + $(window).height() >= $(document).height() - 10) {
                // same AJAX logic
                loading = true;
                sendAjaxRequest(`employer/home?start_number=${startNumber}`, 'GET').then(function (response) {
                    $('#appendContentHere').append(response);
                    startNumber += 10;
                    loading = false;
                })
            }
        });

    </script>

    <script>
        $(document).on('click', '.follow-btn', function () {
            let companyEmployerId = $(this).attr('data-employer-id');
            let companyEmployerName = $(this).attr('data-employer-company-name');
            let postId = $(this).attr('data-post-id');
            let followHistoryStatus = $(this).attr('data-follow-history-status');
            sendAjaxRequest(`employer/set-follow-history?employer_id=${companyEmployerId}&status=${ followHistoryStatus == 1 ? 'false' : 'true' }`, 'GET').then(function (response) {
                // console.log(response);
                if (response.status == 'success' )
                {
                    if (response.follow_status == 1)
                    {
                        toastr.success(`You followed ${companyEmployerName} successfully.`);
                        $('#followBtn'+postId).text("{{ trans('employer.unfollow') }}").attr('data-follow-history-status', 1);

                    } else if (response.follow_status == 0)
                    {
                        toastr.warning(`You Unfollowed ${companyEmployerName} successfully.`);
                        $('#followBtn'+postId).text("{{ trans('employer.follow') }}").attr('data-follow-history-status', 0);
                    }
                } else {
                    alert('Please try again.')
                }
            })
        })
    </script>
@endpush
