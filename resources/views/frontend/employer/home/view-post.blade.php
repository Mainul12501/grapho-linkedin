@extends('frontend.employer.master')

@section('title', $post->title ?? 'Post Title')

@section('body')
    <main class="dashboardContent p-4">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-md-6 mx-auto" id="appendContentHere">
{{--                    contents appends here--}}
                    <div class="card card-body mt-2">
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

