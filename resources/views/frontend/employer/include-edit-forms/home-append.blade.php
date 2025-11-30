{{--@foreach($posts as $key => $post )--}}
{{--    <div class="card card-body mt-2">--}}
{{--        <div class="header-div">--}}
{{--            <a href="{{ route('employer.company-profile', ['view' => 'employer', 'company_id' => $post?->employer?->employerCompany?->id ]) }}" style="text-decoration: none">--}}
{{--                <span style="" class="company-img mr-2"><img src="{{ asset($post?->employer?->employerCompany?->logo ?? 'frontend/employee/images/authentication images/Compnay logo.png') }}" style="height: 60px; width: 60px " alt=""></span>--}}
{{--                <span class="fw-bolder company-name">{{ $post?->employer?->employerCompany?->name ?? 'Employer Name' }}</span>--}}
{{--            </a>--}}
{{--            @if(!\App\Helpers\ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))--}}
{{--                <span class="float-end follow-unfollow-btn">--}}
{{--                    <button type="button" data-employer-id="{{ $post->user_id }}" data-follow-history-status="{{ $post->follow_history_status == 1 ? 1 : 0 }}" data-post-id="{{ $post->id }}" id="followBtn{{ $post->id }}" class="btn btn-primary btn-sm follow-btn text-dark border-0" style="background-color: #FFD600">{{ $post->follow_history_status == 1 ? trans('employer.unfollow') : trans('employer.follow') }}</button>--}}
{{--                </span>--}}
{{--            @endif--}}

{{--        </div>--}}
{{--        <div class="mt-2 row">--}}
{{--            @if(isset($post->images))--}}
{{--                @if(count(json_decode($post->images)) > 1)--}}
{{--                    @foreach(json_decode($post->images) as $image)--}}
{{--                        <div class="col-md-3">--}}
{{--                            <img src="{{ asset($image) }}" alt="post-img" style="height: 150px;" class="img-fluid" />--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                @else--}}
{{--                    <div class="col-12">--}}
{{--                        <img src="{{ asset(json_decode($post->images)[0]) }}" alt="post-img" style="max-height: 600px;" class="mx-auto img-fluid w-100" />--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        <div class="mt-2 " style="text-align: justify">--}}
{{--            <h4>{{ $post->title ?? '' }}</h4>--}}
{{--            <p>--}}
{{--                {!! str()->words($post->description, 40, ' <a href="'. route('employer.view-post', $post->id)  .'">See More...</a>') !!}--}}
{{--                {!! \Illuminate\Support\Str::limit(strip_tags($post->description), 250, '... <a href="'. route('employer.view-post', $post->id) .'">See More</a>') !!}--}}

{{--            </p>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endforeach--}}








@foreach($posts as $key => $post )
    <div class="card card-body mt-2">
        <div class="header-div">
            <a href="{{ route('employer.company-profile', ['view' => 'employer', 'company_id' => $post?->employer?->employerCompany?->id ]) }}"
               style="text-decoration: none"
               class="company-info">
                <span class="company-img">
                    <img src="{{ asset($post?->employer?->employerCompany?->logo ?? 'frontend/employee/images/authentication images/Compnay logo.png') }}"
                         alt="Company Logo">
                </span>
                <span class="company-name">{{ $post?->employer?->employerCompany?->name ?? 'Employer Name' }}</span>
            </a>

            <h4 class="post-title">{{ $post->title ?? '' }}</h4>

            @if(!\App\Helpers\ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
                <span class="follow-unfollow-btn">
                    <button type="button"
                            data-employer-id="{{ $post->user_id }}"
                            data-follow-history-status="{{ $post->follow_history_status == 1 ? 1 : 0 }}"
                            data-post-id="{{ $post->id }}"
                            id="followBtn{{ $post->id }}"
                            class="btn btn-primary btn-sm follow-btn text-dark border-0"
                            style="background-color: #FFD600">
                        {{ $post->follow_history_status == 1 ? trans('employer.unfollow') : trans('employer.follow') }}
                    </button>
                </span>
            @endif
        </div>

        <div class="mt-2 row">
            @if(isset($post->images))
                @if(count(json_decode($post->images)) > 1)
                    @foreach(json_decode($post->images) as $image)
                        <div class="col-md-3 col-sm-6 col-6 mb-2">
                            <img src="{{ asset($image) }}" alt="post-img" style="height: 150px; object-fit: cover;" class="img-fluid w-100" />
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <img src="{{ asset(json_decode($post->images)[0]) }}" alt="post-img" style="max-height: 400px; object-fit: cover;" class="mx-auto img-fluid w-100" />
                    </div>
                @endif
            @endif
        </div>


        <div class="mt-2" style="text-align: justify">
            <p>
                {!! \Illuminate\Support\Str::limit(strip_tags($post->description), 250, '... <a href="'. route('employer.view-post', $post->id) .'">See More</a>') !!}
            </p>
        </div>
        <div class=" py-2">
            <span class="float-end">Posted: {{ $post->created_at->diffForHumans() }}</span>
        </div>
    </div>
@endforeach
