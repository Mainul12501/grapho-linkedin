@extends('frontend.employer.master')

@section('title', 'User Management')

@section('body')
    <main class="dashboardContent p-3 p-md-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-11 mx-auto">

                    <!-- Page Header -->
                    <div class="st-page-header">
                        <h1 class="st-page-title">{{ trans('home.users_management') }}</h1>
                        <p class="st-page-subtitle">Manage team members and their access</p>
                    </div>

                    <div class="row g-4">

                        <!-- Side Menu (same as settings page) -->
                        <nav class="col-lg-3 col-md-4 d-none d-md-block">
                            <div class="st-sidenav">
                                <a href="{{ route('employer.settings') }}" class="st-nav-item {{ request()->is('employer/settings') ? 'active' : '' }}">
                                    <div class="st-nav-icon">
                                        <i class="fa-solid fa-gear"></i>
                                    </div>
                                    <span>{{ trans('employer.my_account') }}</span>
                                </a>
                                <a href="{{ route('employer.employer-user-management') }}" class="st-nav-item {{ request()->is('employer/employer-user-management') ? 'active' : '' }}">
                                    <div class="st-nav-icon">
                                        <i class="fa-solid fa-users-gear"></i>
                                    </div>
                                    <span>{{ trans('home.users_management') }}</span>
                                </a>
                            </div>
                        </nav>

                        <!-- Main Content -->
                        <section class="col-lg-9 col-md-8 col-12">

                            <!-- Top Bar: Stats + Add User -->
                            <div class="um-topbar">
                                <div class="um-topbar-left">
                                    <div class="um-stat-chip">
                                        <i class="fa-solid fa-users"></i>
                                        <span><strong>{{ count($employerUsers) }}</strong> {{ count($employerUsers) == 1 ? 'member' : 'members' }}</span>
                                    </div>
                                </div>
                                @if(auth()->user()->user_type == 'employer')
                                    <button class="um-add-btn" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                        <i class="fa-solid fa-user-plus"></i>
                                        <span>{{ trans('common.add') }} {{ trans('common.user') }}</span>
                                    </button>
                                @endif
                            </div>

                            @if(count($employerUsers) == 0)
                                <!-- Empty State -->
                                <div class="um-empty-state">
                                    <div class="um-empty-visual">
                                        <svg class="um-empty-img" viewBox="0 0 280 220" fill="none" xmlns="http://www.w3.org/2000/svg" style="max-width:260px;margin:0 auto;display:block;">
                                            <ellipse cx="140" cy="200" rx="120" ry="14" fill="#f0f0f0"/>
                                            <circle cx="140" cy="80" r="28" fill="#e0e0e0" stroke="#bbb" stroke-width="2"/>
                                            <circle cx="132" cy="74" r="2.5" fill="#999"/><circle cx="148" cy="74" r="2.5" fill="#999"/>
                                            <path d="M134 84a8 8 0 0012 0" stroke="#999" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                                            <path d="M140 108c-28 0-50 14-50 32v12h100v-12c0-18-22-32-50-32z" fill="#e0e0e0" stroke="#bbb" stroke-width="2"/>
                                            <circle cx="56" cy="96" r="22" fill="#ebebeb" stroke="#ccc" stroke-width="1.5"/>
                                            <circle cx="49" cy="91" r="2" fill="#aaa"/><circle cx="63" cy="91" r="2" fill="#aaa"/>
                                            <path d="M50 99a7 7 0 0010 0" stroke="#aaa" stroke-width="1.2" fill="none" stroke-linecap="round"/>
                                            <path d="M56 118c-22 0-40 11-40 26v8h80v-8c0-15-18-26-40-26z" fill="#ebebeb" stroke="#ccc" stroke-width="1.5"/>
                                            <circle cx="224" cy="96" r="22" fill="#ebebeb" stroke="#ccc" stroke-width="1.5"/>
                                            <circle cx="217" cy="91" r="2" fill="#aaa"/><circle cx="231" cy="91" r="2" fill="#aaa"/>
                                            <path d="M218 99a7 7 0 0010 0" stroke="#aaa" stroke-width="1.2" fill="none" stroke-linecap="round"/>
                                            <path d="M224 118c-22 0-40 11-40 26v8h80v-8c0-15-18-26-40-26z" fill="#ebebeb" stroke="#ccc" stroke-width="1.5"/>
                                            <path d="M92 140c14-10 30-14 48-14s34 4 48 14" stroke="#ccc" stroke-width="1.5" stroke-dasharray="5 3" fill="none" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <h5 class="um-empty-title">No team members yet</h5>
                                    <p class="um-empty-desc">Start building your team by adding sub-users who can help manage your company profile, job postings, and candidate communications.</p>
                                    @if(auth()->user()->user_type == 'employer')
                                        <button class="um-empty-cta" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                            <i class="fa-solid fa-user-plus"></i>
                                            Add Your First Team Member
                                        </button>
                                    @endif
                                </div>
                            @else

                                <!-- Desktop Table View (md+) -->
                                <div class="um-table-card d-none d-md-block">
                                    <div class="um-table-responsive">
                                    <table class="um-table">
                                        <thead>
                                            <tr>
                                                <th class="um-th-user">{{ trans('common.user') }}</th>
                                                <th>{{ trans('common.email') }}</th>
                                                <th>{{ trans('employer.mobile') }}</th>
                                                <th>{{ trans('common.status') }}</th>
                                                <th class="um-th-actions">{{ trans('common.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($employerUsers as $key => $employerUser)
                                                <tr class="um-row">
                                                    <td>
                                                        <div class="um-user-cell">
                                                            <div class="um-avatar">
                                                                @if($employerUser->profile_image)
                                                                    <img src="{{ asset($employerUser->profile_image) }}" alt="{{ $employerUser->name }}" class="um-avatar-img" />
                                                                @else
                                                                    <span class="um-avatar-letter">{{ strtoupper(substr($employerUser->name ?? 'U', 0, 1)) }}</span>
                                                                @endif
                                                                <span class="um-avatar-dot {{ $employerUser->employer_agent_active_status == 'active' ? 'um-dot-online' : 'um-dot-offline' }}"></span>
                                                            </div>
                                                            <div class="um-user-meta">
                                                                <span class="um-name">{{ $employerUser->name ?? 'User Name' }}</span>
                                                                <span class="um-role">
                                                                    <i class="fa-solid fa-shield-halved"></i>
                                                                    {{ ucfirst(str_replace('_', ' ', $employerUser->user_type ?? 'Sub Employer')) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="um-cell-text">
                                                            <i class="fa-regular fa-envelope um-cell-icon"></i>
                                                            {{ $employerUser->email ?? '—' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="um-cell-text">
                                                            <i class="fa-solid fa-phone um-cell-icon"></i>
                                                            {{ $employerUser->mobile ?? '—' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('employer.change-sub-employer-status', ['user' => $employerUser->id, 'status' => $employerUser->employer_agent_active_status == 'active' ? 'inactive' : 'active']) }}"
                                                           class="um-status {{ $employerUser->employer_agent_active_status == 'active' ? 'um-status-active' : 'um-status-inactive' }}">
                                                            <span class="um-status-indicator"></span>
                                                            {{ $employerUser->employer_agent_active_status == 'active' ? trans('admin.active') : trans('admin.inactive') }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div class="um-actions">
                                                            <button class="um-act-btn um-act-edit user-edit" data-user-id="{{ $employerUser->id }}" title="Edit user">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </button>
                                                            @if(auth()->user()->user_type == 'employer')
                                                                <button class="um-act-btn um-act-delete" title="Delete user" onclick="event.preventDefault(); document.getElementById('delSubEmployer{{ $employerUser->id }}').submit()">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </button>
                                                                <form action="{{ route('employer.delete-sub-employer', $employerUser->id) }}" onsubmit="return confirm('Are you sure to delete this user?')" method="post" id="delSubEmployer{{ $employerUser->id }}">
                                                                    @csrf
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>

                                <!-- Mobile Card View (below md) -->
                                <div class="um-mobile-list d-md-none">
                                    @foreach($employerUsers as $key => $employerUser)
                                        <div class="um-m-card">
                                            <div class="um-m-header">
                                                <div class="um-m-user">
                                                    <div class="um-avatar um-avatar-sm">
                                                        @if($employerUser->profile_image)
                                                            <img src="{{ asset($employerUser->profile_image) }}" alt="{{ $employerUser->name }}" class="um-avatar-img" />
                                                        @else
                                                            <span class="um-avatar-letter">{{ strtoupper(substr($employerUser->name ?? 'U', 0, 1)) }}</span>
                                                        @endif
                                                        <span class="um-avatar-dot {{ $employerUser->employer_agent_active_status == 'active' ? 'um-dot-online' : 'um-dot-offline' }}"></span>
                                                    </div>
                                                    <div>
                                                        <div class="um-name">{{ $employerUser->name ?? 'User Name' }}</div>
                                                        <div class="um-role">
                                                            <i class="fa-solid fa-shield-halved"></i>
                                                            {{ ucfirst(str_replace('_', ' ', $employerUser->user_type ?? 'Sub Employer')) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="{{ route('employer.change-sub-employer-status', ['user' => $employerUser->id, 'status' => $employerUser->employer_agent_active_status == 'active' ? 'inactive' : 'active']) }}"
                                                   class="um-status um-status-sm {{ $employerUser->employer_agent_active_status == 'active' ? 'um-status-active' : 'um-status-inactive' }}">
                                                    <span class="um-status-indicator"></span>
                                                    {{ $employerUser->employer_agent_active_status == 'active' ? trans('admin.active') : trans('admin.inactive') }}
                                                </a>
                                            </div>
                                            <div class="um-m-body">
                                                <div class="um-m-field">
                                                    <i class="fa-regular fa-envelope"></i>
                                                    <span>{{ $employerUser->email ?? '—' }}</span>
                                                </div>
                                                <div class="um-m-field">
                                                    <i class="fa-solid fa-phone"></i>
                                                    <span>{{ $employerUser->mobile ?? '—' }}</span>
                                                </div>
                                            </div>
                                            <div class="um-m-footer">
                                                <button class="um-m-btn user-edit" data-user-id="{{ $employerUser->id }}">
                                                    <i class="fa-solid fa-pen"></i> Edit
                                                </button>
                                                @if(auth()->user()->user_type == 'employer')
                                                    <button class="um-m-btn um-m-btn-danger" onclick="event.preventDefault(); document.getElementById('delSubEmployerM{{ $employerUser->id }}').submit()">
                                                        <i class="fa-solid fa-trash-can"></i> Remove
                                                    </button>
                                                    <form action="{{ route('employer.delete-sub-employer', $employerUser->id) }}" onsubmit="return confirm('Are you sure to delete this user?')" method="post" id="delSubEmployerM{{ $employerUser->id }}">
                                                        @csrf
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            @endif

                        </section>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('modal')

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content um-modal">
                <div class="modal-header um-modal-header">
                    <h5 class="modal-title um-modal-title">
                        <div class="um-modal-icon">
                            <i class="fa-solid fa-user-plus text-white"></i>
                        </div>
                        {{ trans('common.add') }} {{ trans('common.user') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('employer.create-sub-user') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body um-modal-body">
                        <div class="um-form-group">
                            <label class="um-form-label">{{ trans('common.name') }}</label>
                            <div class="um-input-wrap">
                                <i class="fa-solid fa-user um-input-icon"></i>
                                <input type="text" class="form-control um-input um-input-icon-pad" name="name" placeholder="{{ trans('employer.enter_your_full_name') }}" required>
                            </div>
                        </div>
                        <div class="um-form-group">
                            <label class="um-form-label">{{ trans('common.email') }}</label>
                            <div class="um-input-wrap">
                                <i class="fa-regular fa-envelope um-input-icon"></i>
                                <input type="email" class="form-control um-input um-input-icon-pad" name="email" placeholder="{{ trans('employer.enter_your_email') }}">
                            </div>
                        </div>
                        <div class="um-form-group">
                            <label class="um-form-label">{{ trans('employer.mobile') }}</label>
                            <div class="um-input-wrap">
                                <i class="fa-solid fa-phone um-input-icon"></i>
                                <input type="text" class="form-control um-input um-input-icon-pad" name="mobile" placeholder="{{ trans('employer.mobile') }}" required>
                            </div>
                        </div>
                        <div class="um-form-group">
                            <label class="um-form-label">{{ trans('employer.new_password') }}</label>
                            <div class="um-input-wrap">
                                <i class="fa-solid fa-lock um-input-icon"></i>
                                <input type="text" class="form-control um-input um-input-icon-pad" name="password" placeholder="{{ trans('employer.new_password') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer um-modal-footer">
                        <button type="button" class="btn um-btn-cancel" data-bs-dismiss="modal">{{ trans('common.cancel') }}</button>
                        <button type="submit" class="btn um-btn-save">
                            <i class="fa-solid fa-plus"></i> {{ trans('common.add') }} {{ trans('common.user') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content um-modal">
                <div class="modal-header um-modal-header">
                    <h5 class="modal-title um-modal-title">
                        <div class="um-modal-icon">
                            <i class="fa-solid fa-user-pen"></i>
                        </div>
                        {{ trans('common.edit') }} {{ trans('common.user') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body um-modal-body" id="employerUserEditForm">
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('frontend/page-custom-codes/employer/sub-users/style.css') }}" />
@endpush

@push('script')
    <script>
        $(document).on('click', '.user-edit', function () {
            event.preventDefault();
            var userId = $(this).attr('data-user-id');
            sendAjaxRequest('employer/get-employer-user-info/'+userId, 'GET').then(function (data) {
                $('#employerUserEditForm').empty().append(data);
                $('#editUserModal').modal('show');
            })
        });
    </script>
@endpush
