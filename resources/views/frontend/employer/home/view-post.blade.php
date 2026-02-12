@extends('frontend.employer.master')

@section('title', $post->title ?? 'Post Title')

@section('body')
    <main class="dashboardContent p-4">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-md-9 mx-auto" id="appendContentHere">
{{--                    contents appends here--}}
                    <div class="card card-body mt-2">
                        <!-- add back button here -->
                        <div class="back-btn-wrapper d-block d-lg-none mb-3">
                            <button type="button" class="btn btn-light border" onclick="window.history.back()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                </svg>
                                <span class="ms-1">Back</span>
                            </button>
                        </div>
                        <div class="">
                            <span style="" class="mr-2"><img src="{{ asset($post?->employer?->employerCompany?->logo ?? 'frontend/company-vector.jpg') }}" style="height: 60px; border-radius: 50%; width: 60px " alt=""></span>
                            <span class="fw-bolder">{{ $post?->employer?->name ?? 'Employer Name' }}</span>
                            <span class="float-end my-auto mt-3">Posted: {{ $post->created_at->format('d-M-Y') }}</span>
                        </div>
                        <div class="mt-2 row">
                            @if(isset($post->images))
                                @if(count(json_decode($post->images)) > 1)
                                    @foreach(json_decode($post->images) as $image)
                                        <div class="col-md-3 mt-2">
                                            <div mbox-group="jqueryscript" class="zoom-img">
                                                <a href="{{ asset($image) }}" class=""><img src="{{ asset($image) }}" alt="post-img" style="height: 150px;" class="img-fluid" /></a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12">
                                        <img src="{{ asset(json_decode($post->images)[0]) }}" alt="post-img" style="max-height: 600px;" class="mx-auto img-fluid" />
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="mt-2 " style="text-align: justify">
                            <p>
                                {!! $post->description !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection


@push('script')
    <link rel="stylesheet" href="{{ asset('frontend/zoom-plugin/mbox.css') }}">
    <script src="{{ asset('frontend/zoom-plugin/mbox.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.zoom-img').mBox();
        });
    </script>
@endpush

