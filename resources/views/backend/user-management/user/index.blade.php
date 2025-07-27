@extends('backend.master')

@section('title', 'Permission')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Manage Users</h4>
{{--                    @can('create-user')--}}
{{--                        <a href="{{ route('users.create') }}" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4">--}}
{{--                            <i class="fa-solid fa-circle-plus"></i>--}}
{{--                        </a>--}}
{{--                    @endcan--}}
                </div>
                <div class="card-body">
{{--                    {!! $dataTable->table() !!}--}}

                    <table class="table" id="file-datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>{{ $userType == 'employer' ? 'Company Name' : 'name' }}</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Subscription Plan</th>
                            @if($userType == 'employer')
                                <th>Jobs</th>
                                <th>Sub Employers</th>
                            @endif
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($userType == 'employer')
                                        <img src="{{ asset($user?->employerCompany?->logo ?? '') }}" alt="" style="max-height: 60px">
                                    @else
                                        <img src="{{ asset($user->profile_image) }}" alt="" style="max-height: 60px" />
                                    @endif
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user?->subscriptionPlan?->title?? '' }}</td>
                                @if($userType == 'employer')
                                    <td><a href="{{ route('view-employer-jobs', $user->id) }}" title="Total Jobs" class="btn btn-sm btn-primary">{{ $user?->jobs()->count() ?? 0 }}</a></td>
                                    <td><a href="{{ route('users.index', ['user_type' => 'employer', 'employer_id' => $user->id, 'show_sub_employer' => 1]) }}" title="Total Sub Employers" class="btn btn-sm btn-primary">{{ $user?->users()->count() ?? 0 }}</a></td>
                                @endif
                                <td class="">
{{--                                    @can('edit-permission')--}}
{{--                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">--}}
{{--                                            <i class="fa-solid fa-edit"></i>--}}
{{--                                        </a>--}}
{{--                                    @endcan--}}
                                    @can('delete-permission')
                                        <form class="d-inline" action="{{ route('users.destroy', $user->id) }}" method="post" >
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger data-delete-form">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <!-- DataTables -->
    <link href="{{ asset('/') }}backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/') }}backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endpush

@push('script')

{{--    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}--}}
    <!-- yo -->
    @include('backend.includes.assets.plugin-files.datatable')
@endpush
