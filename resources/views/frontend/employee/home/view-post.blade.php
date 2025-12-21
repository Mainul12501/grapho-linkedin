@extends('frontend.employee.master')

@section('title', $post->title ?? 'Post Title')

@section('body')
    <main class="dashboardContent p-4">
        <!-- Back button for mobile view -->
        <div class="d-md-none mb-3">
            <a href="javascript:history.back()" class="btn btn-link text-dark p-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                <span class="ms-1">Back</span>
            </a>
        </div>
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-md-8 mx-auto" id="appendContentHere">
                    {{--                    contents appends here--}}
                    <div class="card card-body mt-2">
                        <div class="">
                            <span style="" class="mr-2"><img src="{{ asset($post?->employer?->employerCompany?->logo ?? 'frontend/employee/images/authentication images/Compnay logo.png') }}" style="height: 60px; border-radius: 50%; width: 60px " alt=""></span>
                            <span class="fw-bolder">{{ $post?->employer?->name ?? 'Employer Name' }}</span>
                            <span class="float-end my-auto mt-3">Posted: {{ $post->created_at->format('d-M-Y') }}</span>
                        </div>
                        <div class="mt-2 row">
                            @if(isset($post->images))
                                @if(count(json_decode($post->images)) > 1)
                                    @foreach(json_decode($post->images) as $image)
                                        <div class="col-md-3">
                                            <img src="{{ asset($image) }}" alt="post-img" style="height: 150px;" class="img-fluid " />
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12">
                                        <img src="{{ asset(json_decode($post->images)[0]) }}" alt="post-img" style="max-height: 600px;" class="mx-auto img-fluid w-100" />
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
    <div class="modal" tabindex="-1" id="viewJobModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewJobModalTitle">View Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewJobModalBody">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('common.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')

@endpush

