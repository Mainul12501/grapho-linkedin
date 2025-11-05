<nav class="topbar d-flex justify-content-between align-items-center p-3 sticky-lg-top bg-light">

{{--        <input type="search" class="form-control searchInput w-50 me-3" placeholder="Search jobs or talents" />--}}
        <span class="search-input"></span>


    <div class="d-flex align-items-center gap-3">
        <a href="#"><img src="{{ asset('/') }}frontend/employer/images/employersHome/notification.png" alt="" class="me-3" /></a>
        <a href="{{ route('employer.settings') }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/gearIcon.png" alt="" class="me-3" /></a>

        <div class="dropdown d-flex align-items-center" style="cursor: pointer">
            @if(auth()->user()->user_type == 'employer')
                @if(file_exists(auth()->user()?->employerCompanies[0]?->logo))
                    <img src="{{ auth()->user()?->employerCompanies[0]?->logo ?  asset(auth()->user()?->employerCompanies[0]?->logo) : asset('/frontend/user-vector-img.jpg') }}" alt="Profile" class="rounded-circle"
                         style="width: 36px; height: 36px; object-fit: contain" />
                @endif
            @endif

            @if(auth()->user()->user_type == 'sub_employer')
                    @if(file_exists(auth()->user()?->user?->employerCompanies[0]?->logo))
                        <img src="{{ auth()->user()?->user?->employerCompanies[0]?->logo ?  asset(auth()->user()?->user?->employerCompanies[0]?->logo) : asset('/frontend/user-vector-img.jpg') }}" alt="Profile" class="rounded-circle"
                             style="width: 36px; height: 36px; object-fit: contain" />
                    @endif
            @endif


            <div class="ms-2 dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="d-flex align-items-center gap-1">
                    <span>{{ auth()->user()->user_type == 'employer' ? (auth()->user()->employerCompanies[0]?->name ?? trans('common.company_name')) : (auth()->user()->user_type == 'sub_employer' ? (auth()->user()?->user?->employerCompanies[0]?->name ?? trans('common.company_name')) :auth()->user()->name ?? trans('common.user_name')) }}</span>
                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/chevron-down 1.png" alt="" />
                </div>
                <small class="d-block text-muted" style="font-size: 10px">{{ auth()->user()->user_type == 'employer' ? (auth()->user()?->employerCompanies[0]?->name ?? trans('common.company_name')) : (auth()->user()->user_type == 'sub_employer' ? auth()->user()?->user?->employerCompanies[0]?->name : trans('common.company_name')) }}.</small>
            </div>

            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('employer.company-profile') }}">{{ trans('employer.profile') }}</a></li>
                <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">{{ trans('employee.log_out') }}</a></li>
                <form action="{{ route('logout') }}" method="post" id="logoutForm">
                    @csrf
                </form>
            </ul>
        </div>
    </div>
</nav>
