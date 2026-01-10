
@foreach($posts as $key => $post )
    <div class="card card-body mt-2">
        <div class="header-div">
            <a href="{{ route('employer.company-profile', ['view' => 'employer', 'company_id' => $post?->employer?->employerCompany?->id, 'is_own' => auth()->id() == $post->user_id ? 'true' : 'false' ]) }}"
               style="text-decoration: none; flex-direction: inherit"
               class="company-info" >
                <span class="company-img">
                    <img src="{{ asset($post?->employer?->employerCompany?->logo ?? 'frontend/company-vector.jpg') }}"
                         alt="Company Logo">
                </span>
                <span class="company-name ms-2">{{ $post?->employer?->employerCompany?->name ?? 'Company Name' }}</span>
            </a>

            @if(!\App\Helpers\ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
                <span class="follow-unfollow-btn ms-auto">
                    <button type="button"
                            data-employer-id="{{ $post->user_id }}"
                            data-employer-company-name="{{ $post?->employer?->employerCompany?->name ?? 'Company' }}"
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
                            <a href="{{ route('employer.view-post', $post->id) }}"><img src="{{ asset($image) }}" alt="post-img" style="height: 150px; object-fit: cover;" class="img-fluid w-100" /></a>

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
            <h4 class="post-title"><a href="{{ route('employer.view-post', $post->id) }}" style="text-decoration: none;">{{ $post->title ?? '' }}</a></h4>
            <p>
                {!! \Illuminate\Support\Str::limit(strip_tags($post->description), 250, '... <a href="'. route('employer.view-post', $post->id) .'">See More</a>') !!}
            </p>
        </div>
        <div class=" py-2">
            <span class="float-end">Posted: {{ $post->created_at->diffForHumans() }}</span>
        </div>
    </div>
@endforeach
