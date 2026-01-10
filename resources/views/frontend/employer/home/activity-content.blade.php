@forelse($paginatedData as $singleData)
    <div class="col-12">
        @if($singleData->type == 'job')
            <article class="job-card">
                <div class="job-details <!--flex-grow-1-->">
                    <h6 class="job-title" onclick="showJobDetails({{ $singleData->id }}, `{{ $singleData->job_title }}`)" style="cursor: pointer;">{{ $singleData->job_title ?? trans('common.job_title') }}</h6>
                    <div class="job-badges d-flex flex-wrap gap-2">
                        <span class="badge bg-light text-secondary">{{ $singleData?->jobType?->name ?? trans('common.full_time') }}</span>
                        <span class="badge bg-light text-secondary">{{ $singleData?->jobLocationType?->name ?? trans('common.on_site') }}</span>
                        {{--                                            <span class="badge bg-light text-secondary">Day Shift</span>--}}
                    </div>
                </div>

                <div class="job-info">
                    <div class="mb-2"><img src="{{ asset('/') }}frontend/employer/images/employersHome/postdOn.png" alt="" class="me-2">{{ trans('employer.posted_on') }} {{ $singleData->created_at->format('d M, Y') ?? '16 Feb, 2025' }}</div>
                    <div class="mb-2"><img src="{{ asset('/') }}frontend/employer/images/employersHome/Dedline.png" alt="" class="me-2">{{ trans('employer.deadline') }} {{ \Illuminate\Support\Carbon::parse($singleData->deadline)->format('d M, Y') ?? '16 Feb, 2025' }}</div>
                    @if(isset($_GET['view']) && $_GET['view'] != 'employee')
                        <div><img src="{{ asset('/') }}frontend/employer/images/employersHome/24application.png" alt="" class="me-2"><a href="{{ route('employer.my-job-applicants', $singleData->id) }}" class="text-decoration-underline">{{ $singleData->employeeAppliedJobs->count() ?? 0 }} {{ trans('employer.applicants') }}</a></div>
                    @endif
                </div>

                @if(isset($_GET['view']) && $_GET['view'] != 'employee')
                    <div class="job-actions dropdown">
                        <button class="btn btn-link p-0 text-secondary" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('/') }}frontend/employer/images/employersHome/three dot.png" alt="">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            {{--                                            <li><a class="dropdown-item" href="{{ route('employer.job-tasks.edit', $singleData->id) }}">{{ trans('common.edit') }}</a></li>--}}
                            <li>
                                <form action="{{ route('employer.job-tasks.destroy', $singleData->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="dropdown-item data-delete-form" type="submit">{{ trans('common.delete') }}</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endif

            </article>
        @elseif($singleData->type == 'post')
            <div class="card card-body p-0 post-card-container">
                <div class="row g-0">
                    <div class="col-12 col-md-4">

                        @php
                            $images = isset($singleData->images) ? json_decode($singleData->images, true) : [];
                            $totalImages = count($images);
                        @endphp

                        <div class="post-image-wrapper">
                            @if($totalImages > 1)
                                <div class="image-grid">
                                    @foreach(array_slice($images, 0, 4) as $index => $img)
                                        <a href="javascript:void(0)"
                                           onclick="showPostDetails({{ $singleData->id }},  @json($singleData->title))"
                                           class="grid-image-wrapper">

                                            <img src="{{ asset($img) }}" alt="post img" style="max-height: 200px">

                                            {{-- +N overlay on 4th image --}}
                                            @if($index === 3 && $totalImages > 4)
                                                <span class="more-overlay">
                            +{{ $totalImages - 4 }}
                        </span>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>

                            @elseif($totalImages === 1)
                                <a href="javascript:void(0)"
                                   onclick='showPostDetails({{ $singleData->id }}, @json($singleData->title))'>
                                    <img src="{{ asset($images[0]) }}" class="single-post-image" alt="post img">
                                </a>

                            @else
                                <img src="{{ asset('frontend/photo.png') }}" class="single-post-image" alt="post img">
                            @endif
                        </div>



                    </div>
                    <div class="col-12 col-md-8 py-3">
                        <div class="ps-2">
                            <div class="row">
                                <div class="col-11">
                                    <a href="javascript:void(0)" onclick='showPostDetails({{ $singleData->id }}, @json($singleData->title))' class="" style="text-decoration: none;"><h6>{{ $singleData->title ?? '' }}</h6></a>
                                </div>
                                <div class="col-1">
                                    @if(isset($_GET['is_own']) && $_GET['is_own'] == 'true')
                                        <div class="dropdown">
                                            <span class="dropdown-toggle" style="cursor:pointer;" data-bs-toggle="dropdown"><img src="{{ asset('frontend/employer/images/employersHome/three dot.png') }}" alt="dot"></span>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('employer.posts.edit', $singleData->id) }}">Edit</a></li>
                                                <li>
                                                    <form action="{{ route('employer.posts.destroy', $singleData->id) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="dropdown-item data-delete-form" href="#">Delete</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="pt-3">

{{--                                {!! str()->words($singleData->description, 20, '<a style="text-decoration: none; color: #FFCB11" href="javascript:void(0)" onclick=showPostDetails({{ $singleData->id }}, "{{ $singleData->title }}")">.....View Full Post</a>') ?? '' !!}--}}

                                {!! str()->words(
    $singleData->description,
    20,
    '<a style="text-decoration:none;color:#FFCB11"
        href="javascript:void(0)"
        onclick=\'showPostDetails(' . $singleData->id . ', ' . json_encode($singleData->title) . ')\'>
        ...View Full Post
     </a>'
) !!}



                            </div>
{{--                            <p class="position-absolute" style="bottom: 0px; right: 30px">--}}
{{--                                <span class="float-right" >Posted on: {{ $singleData->created_at->diffForHumans() }}</span>--}}
{{--                            </p>--}}
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
@empty
    <div class="col-12 text-center ">
        <p style="font-size: 36px;" class="no-activity">No Published Activity Yet</p>
    </div>
@endforelse

