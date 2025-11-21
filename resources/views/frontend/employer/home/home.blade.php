@extends('frontend.employer.master')

@section('title', 'Employer Home')

@section('body')
    <main class="dashboardContent p-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="float-end">
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
                <div class=" ps-5 {{ count($advertisements) > 0 ? 'col-md-8 col-sm-10 mx-auto' : ' col-md-9 mx-auto' }}" id="appendContentHere">
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

