@extends('backend.master')

@section('title', 'Subscription Plan')

@section('body')
    <div class="card card-body mt-4">
        <div class="row ">
            <div class="col-6">
                <div>
                    <h3>Set Free Subscription to Users</h3>
                </div>
            </div>
            <div class="col-6 text-end">
                <div>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#FreeSubscriptionModal" class="btn btn-sm- btn-success" >Set Free Subscription</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Subscription Plan</h4>
{{--                    @can('create-permission-category')--}}
                        <a href="{{ route('subscriptions.create') }}" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4">
                            <i class="fa-solid fa-circle-plus"></i>
                        </a>
{{--                    @endcan--}}
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Price</th>
                                <th>For</th>
                                <th>Duration (in days)</th>
                                <th>Features</th>
                                <th>Note</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($subscriptions as $subscription)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('show-subscription-users', $subscription->id) }}">{{ $subscription->title ?? '' }}</a></td>
                                <td>{{ $subscription->price ?? '0' }}</td>
                                <td>{{ $subscription->subscription_for ?? '0' }}</td>
                                <td>{{ $subscription->duration_in_days ?? '0' }}</td>
                                <td>{!! \Illuminate\Support\Str::words($subscription->plan_features, 30, '...') ?? '' !!}</td>
                                <td>{!! \Illuminate\Support\Str::words($subscription->note, 30, '...') ?? '' !!}</td>
                                <td>{{ $subscription->status == 1 ? 'Published' : 'Unpublished' }}</td>
                                <td class="">
{{--                                    @can('edit-permission-category')--}}
                                    <a href="{{ route('subscriptions.edit', $subscription->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
{{--                                    @endcan--}}
{{--                                    @can('delete-permission-category')--}}
                                        <form class="d-inline" action="{{ route('subscriptions.destroy', $subscription->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
{{--                                    @endcan--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="FreeSubscriptionModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Set Free Subscription</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('set-subs-to-all-user') }}" method="post">
                        @csrf
                        {{--                        <div class="mb-3">--}}
                        {{--                            <label for="">Select User</label>--}}
                        {{--                            <select name="user_id" class="form-select selectize" required>--}}
                        {{--                                <option value="">Select User</option>--}}
                        {{--                                @foreach($users as $user)--}}
                        {{--                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>--}}
                        {{--                                @endforeach--}}
                        {{--                            </select>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="mb-3">--}}
                        {{--                            <label for="">Subscription Duration (in days)</label>--}}
                        {{--                            <input type="number" name="duration" class="form-control" required />--}}
                        {{--                        </div>--}}
                        <div class="mt-2">
                            <label for="subsUserType">Select User Type</label>
                            <select name="user_type" id="subsUserType" class="select2">
                                <option value="" disabled selected>Select a User Type</option>
                                <option value="employee">Employee</option>
                                <option value="employer">Employer</option>
                                <option value="all">All</option>
                            </select>
                        </div>
                        <div class="mt-2">
                            <label for="subscriptionPlanSelect">Select Subscription Plan</label>
                            <select name="subscription_plan_id" id="subscriptionPlanSelect" class="select2">
                                <option value="" disabled selected>Select a Subscription Plan</option>
                                @foreach($subscriptions as $plan)

                                    <option value="{{ $plan->id }}" >{{ $plan->title ?? '' }} - ({{ $plan->duration_in_days ?? 0 }} days)</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-success">Set Free Subscription</button>
                        </div>
                    </form>
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
