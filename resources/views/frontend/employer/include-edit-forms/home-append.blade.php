
@foreach($posts as $key => $post)
    <div class="eh-post-card">
        {{-- Post Header: Company info + Follow --}}
        <div class="eh-post-header">
            <a href="{{ route('employer.company-profile', ['view' => 'employer', 'company_id' => $post?->employer?->employerCompany?->id, 'is_own' => auth()->id() == $post->user_id ? 'true' : 'false' ]) }}"
               class="eh-post-company-link">
                <img src="{{ isset($post?->employer?->employerCompanies[0]?->logo) && file_exists($post?->employer?->employerCompanies[0]?->logo) ? asset($post?->employer?->employerCompanies[0]?->logo) : asset('frontend/company-vector.jpg') }}"
                     alt="Company Logo" class="eh-post-company-logo">
                <div class="eh-post-company-info">
                    <h6 class="eh-post-company-name">{{ $post?->employer?->employerCompany?->name ?? 'Company Name' }}</h6>
                    <span class="eh-post-time">
                        <i class="fa-regular fa-clock"></i>
                        {{ $post->created_at->diffForHumans() }}
                    </span>
                </div>
            </a>

            @if(!\App\Helpers\ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
                <button type="button"
                        data-employer-id="{{ $post->user_id }}"
                        data-employer-company-name="{{ $post?->employer?->employerCompany?->name ?? 'Company' }}"
                        data-follow-history-status="{{ $post->follow_history_status == 1 ? 1 : 0 }}"
                        data-post-id="{{ $post->id }}"
                        id="followBtn{{ $post->id }}"
                        class="eh-follow-btn follow-btn">
                    {{ $post->follow_history_status == 1 ? trans('employer.unfollow') : trans('employer.follow') }}
                </button>
            @endif
        </div>

        {{-- Post Body --}}
        <div class="eh-post-body">
            @if($post->title)
                <h4 class="eh-post-title-text">
                    <a href="{{ route('employer.view-post', $post->id) }}">{{ $post->title }}</a>
                </h4>
            @endif

            @if($post->description)
                <p class="eh-post-desc">
                    {!! \Illuminate\Support\Str::limit(strip_tags($post->description), 250, '... <a href="'. route('employer.view-post', $post->id) .'">See More</a>') !!}
                </p>
            @endif
        </div>

        {{-- Post Images --}}
        @if(isset($post->images))
            @php
                $images = json_decode($post->images);
                $count = count($images);
                $gridClass = $count == 1 ? 'eh-grid-1' : ($count == 2 ? 'eh-grid-2' : ($count == 3 ? 'eh-grid-3' : 'eh-grid-multi'));
            @endphp
            <div class="eh-post-images {{ $gridClass }}">
                @foreach($images as $index => $image)
                    @if($index < 4)
                        <div class="eh-post-img-wrap">
                            <a href="{{ route('employer.view-post', $post->id) }}">
                                <img src="{{ asset($image) }}" alt="Post image" class="eh-post-img" />
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endforeach
