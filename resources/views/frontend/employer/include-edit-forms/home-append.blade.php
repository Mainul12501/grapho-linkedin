@foreach($posts as $key => $post )
    <div class="card card-body mt-2">
        <div>
            <a href="{{ route('employer.company-profile', ['view' => 'employer', 'company_id' => $post?->employer?->employerCompany?->id ]) }}" style="text-decoration: none">
                <span style="" class="mr-2"><img src="{{ asset($post?->employer?->employerCompany?->logo ?? 'frontend/employee/images/authentication images/Compnay logo.png') }}" style="height: 60px; border-radius: 50%; width: 60px " alt=""></span>
                <span class="fw-bolder">{{ $post?->employer?->name ?? 'Employer Name' }}</span>
            </a>
            <span class="float-end">
                    <button type="button" data-employer-id="{{ $post->user_id }}" data-follow-history-status="{{ $post->follow_history_status == 1 ? 1 : 0 }}" data-post-id="{{ $post->id }}" id="followBtn{{ $post->id }}" class="btn btn-primary btn-sm follow-btn">{{ $post->follow_history_status == 1 ? 'Unfollow' : 'Follow' }}</button>
            </span>
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
                        <img src="{{ asset(json_decode($post->images)[0]) }}" alt="post-img" style="max-height: 600px;" class="mx-auto img-fluid w-100" />
                    </div>
                @endif
            @endif
        </div>
        <div class="mt-2 " style="text-align: justify">
            <p>
                {!! str()->words($post->description, 40, ' <a href="'. route('employer.view-post', $post->id)  .'">See More...</a>') !!}
            </p>
        </div>
    </div>
@endforeach
