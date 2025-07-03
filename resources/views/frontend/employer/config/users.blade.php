    @extends('frontend.employer.master')

@section('title', 'User Management')

@section('body')
    <div class="employeeSettings">

{{--        <div class="container-fluid bg-white d-none d-md-none">--}}
{{--            <div class="row align-items-center py-3 border-bottom">--}}
{{--                <div class="col-auto pe-0">--}}
{{--                    <button type="button" class="btn p-0 d-flex align-items-center topSettingButton" aria-label="Back">--}}
{{--                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt="" class="me-2">--}}
{{--                        <span class="">Settings</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="container-fluid bg-white  d-md-block">--}}
{{--            <div class="row align-items-center py-3 border-bottom">--}}
{{--                <div class="col-auto pe-0">--}}
{{--                    <button type="button" class="btn p-0 d-flex align-items-center topSettingButton" aria-label="Back">--}}
{{--                        <img src="{{ asset('/') }}frontend/employer/images/employersHome/leftarrow.png" alt="" class="me-2">--}}
{{--                        <span class="">Users Management</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="container settings">
            <!-- Topbar -->


            <div class="row mt-4">
                <!-- Left menu -->
                @include('frontend.employer.config.side-menu')

                <!-- Right main content -->
                <section class="col-md-9 col-12 settingsRightContent">
                    <h2 class="mb-4 settings-menu d-none d-md-block">Users Management</h2>

                    <div class="card usermanagement-content p-3">

                        <div class="user-count d-flex justify-content-between align-items-center mb-3">
                            <div class="d-none d-md-block">Total 3 users</div>
                            <div class="search-add d-flex gap-2">
                                <input type="search" placeholder="Search users" class="search-users form-control" />
                                <button class="add-user-btn btn" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                    <img src="{{ asset('/') }}frontend/employer/images/employersHome/addUser.png" alt="">
                                    <span class="d-none d-md-block">Add User</span>
                                </button>


                            </div>
                        </div>
                        <div class="d-md-none mb-3">Total 3 users</div>

                        <!-- Desktop Table (visible md and up) -->
                        <table class="users-table table  d-none d-md-table">
                            <thead class="bg-light">
                            <tr>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>md.pranto@gmail.com</td>
                                <td>Md. Pranto</td>
                                <td>Admin</td>
                                <td><span class="status active badge bg-success">Active</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link dropdown-toggle p-0" type="button" id="dropdownMenu1" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User actions">
                                            ...
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu1">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                            <li><a class="dropdown-item" href="#">View Profile</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>bruce.wayne@gmail.com</td>
                                <td>Bruce Wayne</td>
                                <td>User</td>
                                <td><span class="status active badge bg-success">Active</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link dropdown-toggle p-0" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User actions">
                                            ...
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu2">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                            <li><a class="dropdown-item" href="#">View Profile</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>hello.world@gmail.com</td>
                                <td>-</td>
                                <td>User</td>
                                <td><span class="status invited badge bg-secondary">Invited</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link dropdown-toggle p-0" type="button" id="dropdownMenu3" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User actions">
                                            ...
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu3">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                            <li><a class="dropdown-item" href="#">View Profile</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <!-- Mobile cards (visible below md) -->
                        <div class="mobile-user-cards d-md-none">

                            <div class="user-card d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                <div class="user-info">
                                    <div class="email fw-bold">md.pranto@gmail.com</div>
                                    <div class="name text-muted small">Md. Pranto</div>
                                    <div class="role text-muted small d-flex align-items-center gap-1 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-badge" viewBox="0 0 16 16">
                                            <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3z"/>
                                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3z"/>
                                            <path fill-rule="evenodd" d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        </svg>
                                        Admin
                                    </div>
                                </div>
                                <div class="user-actions text-end d-flex flex-column align-items-end gap-2">
                                    <span class="status active badge bg-success px-3 py-2">Active</span>
                                    <div class="dropdown">
                                        <button class="btn btn-link dropdown-toggle p-0 fs-4" type="button" id="mobileDropdown1" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User actions">...</button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="mobileDropdown1">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                            <li><a class="dropdown-item" href="#">View Profile</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="user-card d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                <div class="user-info">
                                    <div class="email fw-bold">bruce.wayne@gmail.com</div>
                                    <div class="name text-muted small">Bruce Wayne</div>
                                    <div class="role text-muted small d-flex align-items-center gap-1 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                            <path d="M2 14s-1 0-1-1 1-4 7-4 7 3 7 4-1 1-1 1H2z"/>
                                        </svg>
                                        User
                                    </div>
                                </div>
                                <div class="user-actions text-end d-flex flex-column align-items-end gap-2">
                                    <span class="status active badge bg-success px-3 py-2">Active</span>
                                    <div class="dropdown">
                                        <button class="btn btn-link dropdown-toggle p-0 fs-4" type="button" id="mobileDropdown2" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User actions">...</button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="mobileDropdown2">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                            <li><a class="dropdown-item" href="#">View Profile</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="user-card d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                <div class="user-info">
                                    <div class="email fw-bold">hello.world@gmail.com</div>
                                    <div class="name text-muted small">-</div>
                                    <div class="role text-muted small d-flex align-items-center gap-1 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                            <path d="M2 14s-1 0-1-1 1-4 7-4 7 3 7 4-1 1-1 1H2z"/>
                                        </svg>
                                        User
                                    </div>
                                </div>
                                <div class="user-actions text-end d-flex flex-column align-items-end gap-2">
                                    <span class="status invited badge bg-secondary px-3 py-2">Invited</span>
                                    <div class="dropdown">
                                        <button class="btn btn-link dropdown-toggle p-0 fs-4" type="button" id="mobileDropdown3" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User actions">...</button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="mobileDropdown3">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                            <li><a class="dropdown-item" href="#">View Profile</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="table-responsive">
                            <table class="table" id="datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($employerUsers as $employerUser)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $employerUser->name ?? 'User Name' }}</td>
                                        <td>{{ $employerUser->email ?? 'User Email' }}</td>
                                        <td>{{ $employerUser->mobile ?? '01500000000' }}</td>
                                        <td>{{ $employerUser->user_type ?? 'User Type' }}</td>
                                        <td><a href=""><span class="status badge {{ $employerUser->employer_agent_active_status == 'active' ? 'active bg-success' : 'invited bg-secondary' }}">{{ $employerUser->employer_agent_active_status == 'active' ? 'Active' : 'Inactive' }}</span></a></td>
                                        <td>
                                            <a href="" class="btn btn-sm btn-success mx-1"><i class="fa fa-eye text-white f-s-11"></i></a>
                                            <a href="" class="btn btn-sm btn-primary mx-1"><i class="fa fa-edit text-white f-s-11"></i></a>
                                            <a href="" class="btn btn-sm btn-danger mx-1"><i class="fa fa-trash text-white f-s-11"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
@endsection

@section('modal')

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content rounded-4 p-4">
                <div class="modal-header border-0 pb-2">
                    <button type="button" class="btn p-0 me-2" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L3.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
                        </svg>
                    </button>
                    <h5 class="modal-title fw-semibold">Add a user</h5>
                </div>
                <div class="modal-body pt-0">
                    <form action="{{ route('employer.create-sub-user') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="userName" class="form-label">User Name</label>
                            <input type="text" class="form-control rounded-3" id="userName" name="name" placeholder="Enter Your Name" required />
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">User email</label>
                            <input type="email" class="form-control rounded-3" id="userEmail" name="email" placeholder="hello.world@gmail.com" >
                        </div>
                        <div class="mb-3">
                            <label for="userMobile" class="form-label">User Mobile</label>
                            <input type="text" class="form-control rounded-3" name="mobile" id="userMobile" placeholder="01500000000" required />
                        </div>
                        <div class="mb-3">
                            <label for="userPassword" class="form-label">User Password</label>
                            <input type="text" class="form-control rounded-3" id="userPassword" name="password" placeholder="00000000" required />
                        </div>
{{--                        <div class="mb-4">--}}
{{--                            <label for="userRole" class="form-label">Role</label>--}}
{{--                            <select class="form-select rounded-3 select2" id="userRole" name="gender" >--}}
{{--                                <option>User</option>--}}
{{--                                <option>Admin</option>--}}
{{--                                <option>Viewer</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn border border-2 rounded-3 px-4 py-2" data-bs-dismiss="modal" style="border-color:#ccc;">Cancel</button>
                            <button type="submit" class="btn rounded-3 px-4 py-2 text-white fw-semibold" style="background-color: #FFD700;">Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

    @push('style')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endpush

    @push('script')
        @include('backend.includes.assets.plugin-files.datatable')
        <script>
            $(document).ready(function() {
                $('#datatable').DataTable({
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }).buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
            });
    @endpush
