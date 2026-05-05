@extends('frontend.employer.master')

@section('title', 'Employer Home')

@section('body')
    <main class="eh-feed">
        {{-- ===== TOP BAR: Greeting + Search ===== --}}
        <div class="eh-topbar-row">
            <div>
                <h1 class="eh-greeting">{{ trans('employer.home') }}</h1>
                <p class="eh-greeting-sub">Discover talent and stay connected</p>
            </div>
            <form action="" method="get" class="eh-search-form">
                <div class="eh-search-wrap">
                    <i class="fa-solid fa-magnifying-glass eh-search-icon"></i>
                    <input type="text" name="search_text" class="eh-search-input" placeholder="{{ trans('employer.search_company') }}" value="{{ request('search_text') }}">
                    <button type="submit" class="eh-search-btn">{{ trans('common.search') }}</button>
                </div>
            </form>
        </div>

        <div class="eh-layout">
            {{-- ===== MAIN COLUMN ===== --}}
            <div class="eh-main" id="appendContentHere">

                {{-- Create Post CTA --}}
                @if(!\App\Helpers\ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
                    <div class="eh-create-post-card">
                        <div class="eh-create-post-inner">
                            <div class="eh-create-post-icon">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </div>
                            <div class="eh-create-post-text">
                                <span class="eh-create-post-label">{{ trans('employer.have_something_new_on_mind') }}</span>
                                <span class="eh-create-post-hint">Share updates, news or articles</span>
                            </div>
                            <a href="{{ route('employer.posts.create') }}" class="eh-create-post-btn">
                                <i class="fa-solid fa-plus"></i> {{ trans('employer.post') }}
                            </a>
                        </div>
                    </div>
                @endif

                {{-- ===== Suggested Profiles Carousel ===== --}}
                @if(count($employees) > 0)
                <div class="eh-section-card">
                    <div class="eh-section-header">
                        <h2 class="eh-section-title">
                            <i class="fa-solid fa-user-group eh-section-icon"></i>
                            Suggested Profiles
                        </h2>
                        <a href="{{ route('employer.employee-suggestions') }}" class="eh-view-all-link">
                            View All <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="employee-suggestions">
                        <div class="owl-carousel owl-theme">
                            @foreach($employees as $employee)
                                <div class="item pb-2">
                                    <a href="{{ route('employee-profile', $employee->id) }}" class="eh-talent-link">
                                        <article class="eh-talent-card">
                                            <div class="eh-talent-avatar-wrap">
                                                <img src="{{ asset($employee->profile_image ?? '/frontend/user-vector-img.jpg') }}"
                                                     alt="{{ $employee->name }}" class="eh-talent-avatar" />
                                                <span class="eh-talent-badge"><i class="fa-solid fa-briefcase"></i></span>
                                            </div>
                                            <div class="eh-talent-info">
                                                <h6 class="eh-talent-name">{{ $employee->name ?? trans('common.employee_name') }}</h6>
                                                <p class="eh-talent-title">{{ $employee->profile_title ?? trans('employee.profile_title') }}</p>
                                                <span class="eh-talent-location">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                    {!! str()->words($employee->address, 6) ?? trans('common.user_address') !!}
                                                </span>
                                            </div>
                                            <div class="eh-talent-stats">
                                                <span class="eh-stat-pill">
                                                    <i class="fa-solid fa-clock"></i>
                                                    {{ $employee?->employeeWorkExperiences[0]?->duration ?? 0 }}+ {{ trans('common.yrs') }}
                                                </span>
                                                <span class="eh-stat-pill">
                                                    <i class="fa-solid fa-graduation-cap"></i>
                                                    {{ $employee?->employeeEducations[$employee->employeeEducations()->count() - 1]?->cgpa ?? 0.0 }} {{ trans('common.cgpa') }}
                                                </span>
                                            </div>
                                        </article>
                                    </a>
                                </div>
                            @endforeach
                            <div class="item" id="viewMore">
                                <a href="{{ route('employer.employee-suggestions') }}" class="eh-talent-link">
                                    <article class="eh-talent-card eh-view-more-card">
                                        <div class="eh-view-more-icon">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </div>
                                        <h6 class="eh-view-more-title">View more profiles</h6>
                                        <p class="eh-view-more-sub">Discover more talent on LikewiseBD</p>
                                    </article>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Posts are appended here via AJAX --}}
            </div>

            {{-- ===== SIDEBAR: Advertisements ===== --}}
            @if(count($advertisements) > 0)
                <aside class="eh-sidebar" id="advertisementContainer">
                    <div class="eh-sidebar-sticky">
                        <div class="eh-ad-header">
                            <span class="eh-ad-label"><i class="fa-solid fa-bullhorn"></i> Sponsored</span>
                        </div>
                        @foreach($advertisements as $advertisement)
                            <div class="eh-ad-card">
                                <a href="{{ url('/'.$advertisement->redirect_url) }}" target="_blank" rel="noopener">
                                    <img src="{{ asset($advertisement->banner) }}" alt="{{ $advertisement->title ?? 'Ad' }}" class="eh-ad-img" />
                                </a>
                            </div>
                        @endforeach
                    </div>
                </aside>
            @endif
        </div>
    </main>
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('frontend/page-custom-codes/employer/home/style.css') }}">

@endpush

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('frontend/page-custom-codes/employer/home/script.js') }}"></script>
@endpush
