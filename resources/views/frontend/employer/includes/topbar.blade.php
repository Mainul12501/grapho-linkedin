<nav class="topbar d-flex justify-content-between align-items-center p-3">
    <input type="search" class="form-control searchInput w-50 me-3" placeholder="Search jobs or talents" />

    <div class="d-flex align-items-center gap-3">
        <a href="#"><img src="{{ asset('/') }}frontend/employer/images/employersHome/notification.png" alt="" class="me-3" /></a>
        <a href="{{ route('employer.settings') }}"><img src="{{ asset('/') }}frontend/employer/images/employersHome/gearIcon.png" alt="" class="me-3" /></a>

        <div class="dropdown d-flex align-items-center" style="cursor: pointer">
            <img src="{{ asset('/') }}frontend/employer/images/employersHome/companyLogo.png" alt="Profile" class="rounded-circle"
                 style="width: 36px; height: 36px; object-fit: contain" />

            <div class="ms-2 dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="d-flex align-items-center gap-1">
                    <span>Md. Pranto</span>
                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/chevron-down 1.png" alt="" />
                </div>
                <small class="d-block text-muted" style="font-size: 10px">Grameenphone Ltd.</small>
            </div>

            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">Logout</a></li>
                <form action="{{ route('logout') }}" method="post" id="logoutForm">
                    @csrf
                </form>
            </ul>
        </div>
    </div>
</nav>
