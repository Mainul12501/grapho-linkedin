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
                            <p class="d-inline-flex"><a href="{{ route('employer.posts.create') }}" class="btn btn-sm btn-success">{{ trans('employer.post') }}</a></p>
                        </div>
                    @endif

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
    <style>
        @media screen and (max-width: 425px){
            #advertisementContainer {display: none}
        }
        @media screen and (max-width: 768px){
            #appendContentHere {padding-left: 10px!important;}
            .mobile-search-float-left-0 {float: none!important;}
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
            let postId = $(this).attr('data-post-id');
            let followHistoryStatus = $(this).attr('data-follow-history-status');
            sendAjaxRequest(`employer/set-follow-history?employer_id=${companyEmployerId}&status=${ followHistoryStatus == 1 ? 'false' : 'true' }`, 'GET').then(function (response) {
                console.log(response);
                if (response.status == 'success' )
                {
                    if (response.follow_status == 1)
                    {
                        toastr.success('You followed this employer successfully.');
                        $('#followBtn'+postId).text("{{ trans('employer.unfollow') }}").attr('data-follow-history-status', 1);

                    } else if (response.follow_status == 0)
                    {
                        toastr.warning('You Unfollowed this employer successfully.');
                        $('#followBtn'+postId).text("{{ trans('employer.follow') }}").attr('data-follow-history-status', 0);
                    }
                } else {
                    alert('Please try again.')
                }
            })
        })
    </script>
@endpush

