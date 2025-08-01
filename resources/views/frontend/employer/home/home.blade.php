@extends('frontend.employer.master')

@section('title', 'Employer Home')

@section('body')
    <main class="dashboardContent p-4">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-md-6 mx-auto" id="appendContentHere">
                    <div class="card card-body d-flex">
                        <p class="d-inline-flex">Have Something New On mind?</p>
                        <p class="d-inline-flex"><a href="{{ route('employer.posts.create') }}" class="btn btn-sm btn-success">Create Post</a></p>
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
@endpush

