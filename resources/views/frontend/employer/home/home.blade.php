@extends('frontend.employer.master')

@section('title', 'Employer Home')

@section('body')
    <main class="dashboardContent p-4">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-md-6 mx-auto" id="appendContentHere">
                    <div class="card card-body d-flex">
                        <p class="d-inline-flex">Have Something New On mind?</p>
                        <p class="d-inline-flex"><a href="{{ route('employer.posts.create') }}" class="btn btn-sm btn-success">Add Post</a></p>
                    </div>
{{--                    contents appends here--}}
                </div>
            </div>
        </div>

    </main>
@endsection


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
                        $('#followBtn'+postId).text('Unfollow').attr('data-follow-history-status', 1);

                    } else if (response.follow_status == 0)
                    {
                        $('#followBtn'+postId).text('Follow').attr('data-follow-history-status', 0);
                    }
                } else {
                    alert('Please try again.')
                }
            })
        })
    </script>
@endpush

