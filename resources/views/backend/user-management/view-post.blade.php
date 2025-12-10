<div class="">
    <div class="row g-4">
        <div class="col-md-12 mx-auto" id="">
            {{--                    contents appends here--}}
            <div class="card card-body mt-2">
                <div>
                    <span style="" class="mr-2"><img src="{{ asset($post?->employer?->employerCompany?->logo ?? 'frontend/employee/images/authentication images/Compnay logo.png') }}" style="height: 60px; border-radius: 50%; width: 60px " alt=""></span>
                    <span class="fw-bolder">{{ $post?->employer?->name ?? 'Employer Name' }}</span>
                </div>
                <div class="mt-2 row">
                    @if(isset($post->images))
                        @if(count(json_decode($post->images)) > 1)
                            @foreach(json_decode($post->images) as $image)
                                <div class="col-md-3">
                                    <img src="{{ asset($image) }}" alt="post-img" style="height: 150px;" class="img-fluid" />
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
