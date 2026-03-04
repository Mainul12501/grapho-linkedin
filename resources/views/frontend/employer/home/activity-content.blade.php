@forelse($paginatedData as $singleData)
    <div class="col-12">
        @if($singleData->type == 'job')
            {{-- ===== JOB CARD ===== --}}
            <article class="ed-job-card">
                <div class="ed-job-type-bar"></div>
                <div class="ed-job-icon-wrap">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <div class="ed-job-body">
                    <h6 class="ed-job-title" onclick="showJobDetails({{ $singleData->id }}, `{{ $singleData->job_title }}`)" >
                        {{ $singleData->job_title ?? trans('common.job_title') }}
                    </h6>
                    <div class="ed-job-badges">
                        <span class="ed-badge">
                            <i class="fa-solid fa-clock" style="font-size:10px;color:#94A3B8;"></i>
                            {{ $singleData?->jobType?->name ?? trans('common.full_time') }}
                        </span>
                        <span class="ed-badge">
                            <i class="fa-solid fa-location-dot" style="font-size:10px;color:#94A3B8;"></i>
                            {{ $singleData?->jobLocationType?->name ?? trans('common.on_site') }}
                        </span>
                    </div>
                    <div class="ed-job-meta">
                        <span class="ed-job-meta-item">
                            <i class="fa-regular fa-calendar"></i>
                            {{ trans('employer.posted_on') }} {{ $singleData->created_at->format('d M, Y') }}
                        </span>
                        <span class="ed-job-meta-item">
                            <i class="fa-solid fa-hourglass-half"></i>
                            {{ trans('employer.deadline') }} {{ \Illuminate\Support\Carbon::parse($singleData->deadline)->format('d M, Y') }}
                        </span>
                        @if(isset($_GET['is_own']) && $_GET['is_own'] == 'true')
                            <span class="ed-job-meta-item">
                                <i class="fa-solid fa-users"></i>
                                <a href="{{ route('employer.my-job-applicants', $singleData->id) }}">{{ $singleData->employeeAppliedJobs->count() ?? 0 }} {{ trans('employer.applicants') }}</a>
                            </span>
                        @endif
                    </div>
                </div>

                @if(isset($_GET['is_own']) && $_GET['is_own'] == 'true')
                    <div class="ed-job-actions dropdown">
                        <button class="ed-dots-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('employer.job-tasks.destroy', $singleData->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="dropdown-item data-delete-form" type="submit">
                                        <i class="fa-solid fa-trash-can me-2" style="color:#EF4444;font-size:12px;"></i> {{ trans('common.delete') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endif
            </article>

        @elseif($singleData->type == 'post')
            {{-- ===== POST CARD ===== --}}
            <div class="ed-post-card">
                <div class="ed-post-inner">
                    {{-- Thumbnail --}}
                    <div class="ed-post-thumb">
                        @php
                            $images = isset($singleData->images) ? json_decode($singleData->images, true) : [];
                            $totalImages = count($images);
                        @endphp

                        @if($totalImages > 1)
                            <div class="ed-post-grid">
                                @foreach(array_slice($images, 0, 4) as $index => $img)
                                    <a href="javascript:void(0)"
                                       data-post-id="{{ $singleData->id }}" data-post-title="{{ e($singleData->title) }}" class="ed-post-click">
                                        <img src="{{ asset($img) }}" alt="post img">
                                        @if($index === 3 && $totalImages > 4)
                                            <span class="ed-more-overlay">+{{ $totalImages - 4 }}</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        @elseif($totalImages === 1)
                            <a href="javascript:void(0)"
                               data-post-id="{{ $singleData->id }}" data-post-title="{{ e($singleData->title) }}" class="ed-post-click">
                                <img src="{{ asset($images[0]) }}" class="ed-post-thumb-img" alt="post img">
                            </a>
                        @else
                            <img src="{{ asset('frontend/photo.png') }}" class="ed-post-thumb-img" alt="post img" style="object-fit:contain;padding:30px;opacity:.4;">
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="ed-post-content">
                        <div class="ed-post-top-row">
                            <span class="ed-post-label">
                                <i class="fa-solid fa-newspaper"></i> Post
                            </span>

                            @if(isset($_GET['is_own']) && $_GET['is_own'] == 'true')
                                <div class="dropdown">
                                    <button class="ed-dots-btn" type="button" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('employer.posts.edit', $singleData->id) }}">
                                            <i class="fa-solid fa-pen me-2" style="font-size:12px;color:#3B82F6;"></i> Edit
                                        </a></li>
                                        <li>
                                            <form action="{{ route('employer.posts.destroy', $singleData->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="dropdown-item data-delete-form">
                                                    <i class="fa-solid fa-trash-can me-2" style="font-size:12px;color:#EF4444;"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <h6 class="ed-post-title">
                            <a href="javascript:void(0)" data-post-id="{{ $singleData->id }}" data-post-title="{{ e($singleData->title) }}" class="ed-post-click">
                                {{ $singleData->title ?? '' }}
                            </a>
                        </h6>

                        <p class="ed-post-excerpt">
                            {!! str()->words(
                                $singleData->description,
                                20,
                                '<a href="javascript:void(0)" data-post-id="' . $singleData->id . '" data-post-title="' . e($singleData->title) . '" class="ed-post-click">...View Full Post</a>'
                            ) !!}
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
@empty
    <div class="col-12">
        <div class="ed-empty-state">
            <div class="ed-empty-icon"><i class="fa-solid fa-folder-open"></i></div>
            <p class="ed-empty-text">No Published Activity Yet</p>
            <p class="ed-empty-sub">Post a job or create content to see your activity here</p>
        </div>
    </div>
@endforelse
