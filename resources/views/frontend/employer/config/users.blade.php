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
    <style>
        /* =============================================
           Shared Layout Styles (same as settings page)
           ============================================= */

        .st-page-header { margin-bottom: 24px; padding-top: 4px; }
        .st-page-title { font-size: 24px; font-weight: 700; color: #0F172A; margin: 0; line-height: 1.2; }
        .st-page-subtitle { font-size: 13px; color: #64748B; margin: 4px 0 0; }

        .st-sidenav {
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 8px;
            position: static;
            top: 80px;
        }
        .st-sidenav .active i, .st-sidenav .active span { color: white!important; }

        .st-nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            border-radius: 10px;
            text-decoration: none;
            color: #475569;
            font-size: 14px;
            font-weight: 500;
            transition: all .2s;
        }
        .st-nav-item:hover { background: #F8FAFC; color: #0F172A; }
        .st-nav-item.active { background: #141C25; color: #fff; font-weight: 600; }

        .st-nav-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #64748B;
            flex-shrink: 0;
            transition: all .2s;
        }
        .st-nav-item.active .st-nav-icon { background: rgba(255,203,17,.2); color: #FFCB11; }
        .st-nav-item:hover .st-nav-icon { background: #E2E8F0; color: #0F172A; }
        .st-nav-item.active:hover .st-nav-icon { background: rgba(255,203,17,.2); color: #FFCB11; }


        /* =============================================
           User Management — Content Styles
           ============================================= */

        /* --- Top Bar --- */
        .um-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .um-stat-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 13px;
            color: #475569;
        }

        .um-stat-chip i { color: #94A3B8; font-size: 13px; }
        .um-stat-chip strong { color: #0F172A; font-weight: 700; }

        .um-add-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            /*background: #141C25;*/
            background: lightgreen;
            color: #FFCB11;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            font-family: 'Geist', sans-serif;
        }
        .um-add-btn:hover {
            background: #0F172A;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(20,28,37,.18);
        }
        .um-add-btn i { font-size: 13px; }
        /*.um-add-btn:hover i,span { color: white!important; }*/


        /* --- Empty State --- */
        .um-empty-state {
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 48px 32px;
            text-align: center;
        }

        .um-empty-visual { margin-bottom: 24px; }

        .um-empty-img {
            width: 180px;
            height: auto;
            opacity: .75;
        }

        .um-empty-title {
            font-size: 18px;
            font-weight: 700;
            color: #0F172A;
            margin: 0 0 8px;
        }

        .um-empty-desc {
            font-size: 13px;
            color: #64748B;
            max-width: 400px;
            margin: 0 auto 24px;
            line-height: 1.6;
        }

        .um-empty-cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #141C25;
            color: #FFCB11;
            border: none;
            border-radius: 10px;
            padding: 11px 24px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            font-family: 'Geist', sans-serif;
        }
        .um-empty-cta:hover {
            background: #0F172A;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(20,28,37,.18);
        }


        /* --- Desktop Table --- */
        .um-table-card {
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            overflow: hidden;
        }

        .um-table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .um-table {
            width: 100%;
            border-collapse: collapse;
        }

        .um-table thead th {
            background: #F8FAFC;
            padding: 13px 18px;
            font-size: 11px;
            font-weight: 600;
            color: #94A3B8;
            text-transform: uppercase;
            letter-spacing: .6px;
            border-bottom: 1px solid #E2E8F0;
            white-space: nowrap;
        }

        .um-th-user { min-width: 200px; }
        .um-th-actions { text-align: right; }

        .um-row {
            border-bottom: 1px solid #F1F5F9;
            transition: background .15s;
        }
        .um-row:last-child { border-bottom: none; }
        .um-row:hover { background: #FAFBFD; }

        .um-row td {
            padding: 16px 18px;
            font-size: 13px;
            color: #475569;
            vertical-align: middle;
        }


        /* --- User Cell (avatar + name) --- */
        .um-user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .um-avatar {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #141C25 0%, #1e293b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: visible;
        }

        .um-avatar-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .um-avatar-letter {
            font-size: 15px;
            font-weight: 700;
            color: #FFCB11;
            line-height: 1;
        }

        .um-avatar-dot {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 11px;
            height: 11px;
            border-radius: 50%;
            border: 2px solid #fff;
            z-index: 1;
        }

        .um-dot-online { background: #22C55E; }
        .um-dot-offline { background: #CBD5E1; }

        .um-avatar-sm {
            width: 36px;
            height: 36px;
        }
        .um-avatar-sm .um-avatar-img {
            width: 36px;
            height: 36px;
        }
        .um-avatar-sm .um-avatar-letter { font-size: 13px; }
        .um-avatar-sm .um-avatar-dot { width: 10px; height: 10px; }

        .um-user-meta {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .um-name {
            font-size: 13.5px;
            font-weight: 600;
            color: #0F172A;
            line-height: 1.3;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .um-role {
            font-size: 11px;
            color: #94A3B8;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 1px;
        }
        .um-role i { font-size: 9px; color: #CBD5E1; }


        /* --- Cell with icon --- */
        .um-cell-text {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #475569;
        }
        .um-cell-icon { font-size: 11px; color: #CBD5E1; }


        /* --- Status Badge --- */
        .um-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
            white-space: nowrap;
        }

        .um-status-indicator {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .um-status-active { background: #F0FDF4; color: #15803D; }
        .um-status-active .um-status-indicator { background: #22C55E; }
        .um-status-active:hover { background: #DCFCE7; color: #15803D; }

        .um-status-inactive { background: #F8FAFC; color: #64748B; border: 1px solid #E2E8F0; }
        .um-status-inactive .um-status-indicator { background: #94A3B8; }
        .um-status-inactive:hover { background: #F1F5F9; color: #475569; }

        .um-status-sm { padding: 4px 10px; font-size: 11px; }


        /* --- Action Buttons --- */
        .um-actions {
            display: flex;
            gap: 6px;
            justify-content: flex-end;
        }

        .um-act-btn {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid #E2E8F0;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
            transition: all .2s;
        }

        .um-act-edit { color: #64748B; }
        .um-act-edit:hover { background: #141C25; border-color: #141C25; color: #FFCB11; }

        .um-act-delete { color: #CBD5E1; }
        .um-act-delete:hover { background: #FEF2F2; border-color: #FECACA; color: #EF4444; }


        /* --- Mobile Cards --- */
        .um-mobile-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .um-m-card {
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            overflow: hidden;
        }

        .um-m-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 14px 16px;
        }

        .um-m-user {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .um-m-body {
            padding: 0 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .um-m-field {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12.5px;
            color: #64748B;
            padding-left: 46px;
        }
        .um-m-field i { font-size: 11px; color: #94A3B8; width: 14px; text-align: center; }
        .um-m-field span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .um-m-footer {
            display: flex;
            gap: 0;
            border-top: 1px solid #F1F5F9;
        }

        .um-m-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 11px 12px;
            background: transparent;
            border: none;
            border-right: 1px solid #F1F5F9;
            font-size: 12.5px;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            transition: background .15s;
            font-family: 'Geist', sans-serif;
        }
        .um-m-btn:last-child { border-right: none; }
        .um-m-btn:hover { background: #F8FAFC; }
        .um-m-btn i { font-size: 11px; }

        .um-m-btn-danger { color: #EF4444; }
        .um-m-btn-danger:hover { background: #FEF2F2; }


        /* --- Modal Styles --- */
        .um-modal {
            border: none;
            border-radius: 16px;
            overflow: hidden;
        }

        .um-modal-header {
            border-bottom: 1px solid #F1F5F9;
            padding: 20px 24px;
        }

        .um-modal-title {
            font-size: 17px;
            font-weight: 700;
            color: #0F172A;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .um-modal-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #141C25;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #FFCB11;
            flex-shrink: 0;
        }

        .um-modal-body { padding: 24px; }

        .um-form-group { margin-bottom: 18px; }
        .um-form-group:last-child { margin-bottom: 0; }

        .um-form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #0F172A;
            margin-bottom: 6px;
        }

        .um-input-wrap {
            position: relative;
        }

        .um-input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 13px;
            color: #94A3B8;
            pointer-events: none;
            z-index: 2;
        }

        .um-input {
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            color: #0F172A;
            transition: border-color .2s, box-shadow .2s;
            font-family: 'Geist', sans-serif;
            width: 100%;
        }
        .um-input-icon-pad { padding-left: 38px; }

        .um-input:focus {
            border-color: #FFCB11;
            box-shadow: 0 0 0 3px rgba(255,203,17,.12);
            outline: none;
        }
        .um-input::placeholder { color: #CBD5E1; }

        .um-modal-footer {
            border-top: 1px solid #F1F5F9;
            padding: 16px 24px;
            gap: 8px;
        }

        .um-btn-cancel {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 9px 20px;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            transition: all .2s;
            font-family: 'Geist', sans-serif;
        }
        .um-btn-cancel:hover { background: #F1F5F9; color: #0F172A; }

        .um-btn-save {
            background: #141C25;
            border: none;
            border-radius: 10px;
            padding: 9px 22px;
            font-size: 13px;
            font-weight: 700;
            color: #FFCB11;
            transition: all .2s;
            font-family: 'Geist', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .um-btn-save:hover { background: #0F172A; color: #FFCB11; }
        .um-btn-save i { font-size: 11px; }


        /* =============================================
           Responsive
           ============================================= */

        @media (max-width: 991px) {
            .um-row td { font-size: 12.5px; padding: 14px 14px; }
            .um-table thead th { padding: 12px 14px; }
        }

        @media (max-width: 767px) {
            .st-page-header { margin-bottom: 16px; }
            .st-page-title { font-size: 20px; }

            .um-topbar { margin-bottom: 14px; }

            .um-add-btn { padding: 9px 16px; font-size: 12px; }

            .um-empty-state { padding: 36px 20px; }
            .um-empty-img { width: 140px; }
            .um-empty-title { font-size: 16px; }
            .um-empty-desc { font-size: 12px; }
            .um-empty-cta { padding: 10px 20px; font-size: 12px; }

            .um-modal-header { padding: 16px 18px; }
            .um-modal-body { padding: 18px; }
            .um-modal-footer { padding: 14px 18px; }
        }

        @media (max-width: 575px) {
            .um-stat-chip { padding: 6px 12px; font-size: 12px; }
            .um-add-btn { padding: 8px 14px; font-size: 11px; gap: 6px; }

            .um-m-header { padding: 12px 14px; }
            .um-m-body { padding: 0 14px 10px; }
            .um-m-field { padding-left: 0; font-size: 12px; }
            .um-m-btn { padding: 10px 8px; font-size: 11.5px; }

            .um-avatar-sm { width: 32px; height: 32px; }
            .um-avatar-sm .um-avatar-img { width: 32px; height: 32px; }
            .um-avatar-sm .um-avatar-letter { font-size: 12px; }
            .um-avatar-sm .um-avatar-dot { width: 9px; height: 9px; }

            .um-empty-state { padding: 28px 16px; border-radius: 12px; }
            .um-empty-img { width: 120px; }
        }
    </style>
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
