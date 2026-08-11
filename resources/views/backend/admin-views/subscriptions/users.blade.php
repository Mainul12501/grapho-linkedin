@extends('backend.master')

@section('title', 'Subscription Plan')

@section('body')


    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">{{ $userPlan ?? '' }} Users</h4>
{{--                    @can('create-permission-category')--}}
                        <a href="{{ route('subscriptions.index') }}" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4">
                            <i class="fa-solid fa-circle-arrow-left"></i>
                        </a>
{{--                    @endcan--}}
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>profile Image</th>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($user->user_type == 'employer')
                                        <img src="{{ asset($user?->employerCompany?->logo) }}" alt="" style="height: 35px">
                                    @elseif($user->user_type == 'employee')
                                        <img src="{{ asset($user?->profile_image) }}" alt="" style="height: 35px">
                                    @endif
                                </td>
                                <td>{{ $user->user_type ?? '' }}</td>
                                <td>{{ $user->name ?? '' }}</td>
                                <td>{{ $user->mobile ?? '' }}</td>
                                <td>{{ $user->email ?? '' }}</td>
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
{{--    <link href="{{ asset('/') }}backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{{ asset('/') }}backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />--}}
@endpush

@push('script')
    <!-- Required datatable js -->

@include('backend.includes.assets.plugin-files.datatable')
{{--@include('common-resource-files.selectize')--}}




@endpush
