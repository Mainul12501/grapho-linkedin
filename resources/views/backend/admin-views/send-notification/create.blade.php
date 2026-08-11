@extends('backend.master')

@section('title', 'Notification')

@section('body')
    <div class="row py-5">
        <div class="col-md-9 mx-auto">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="text-white">Notification Message</h4>
                    <a href="{{ route('send-notifications.index') }}" class="btn rounded-circle position-absolute end-0 me-3">
                        <i class="fa-regular fa-file-lines fa-2x text-white"></i>
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ isset($notification) ? route('send-notifications.update', $notification->id) : route('send-notifications.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if(isset($notification))
                            @method('put')
                        @endif
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <label for="userType">User Type</label>
                                <select name="send_user_type" class="select2 form-control"  id="userType">
                                    <option value="" selected disabled>Select a User type</option>
                                    <option value="admin" {{ isset($notification) && $notification->send_user_type == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="employee" {{ isset($notification) && $notification->send_user_type == 'employee' ? 'selected' : '' }}>Employee</option>
                                    <option value="employer" {{ isset($notification) && $notification->send_user_type == 'employer' ? 'selected' : '' }}>Employer</option>
                                    <option value="user" {{ isset($notification) && $notification->send_user_type == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="all" {{ isset($notification) && $notification->send_user_type == 'all' ? 'selected' : '' }}>All</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="method">Method</label>
                                <select name="method" class="select2 form-control"  id="method">
                                    <option value="" selected disabled>Select a User type</option>
                                    <option value="mobile" {{ isset($notification) && $notification->method == 'mobile' ? 'selected' : '' }}>Mobile</option>
                                    <option value="email" {{ isset($notification) && $notification->method == 'email' ? 'selected' : '' }}>Email</option>
                                    <option value="all" {{ isset($notification) && $notification->method == 'all' ? 'selected' : '' }}>All</option>
                                </select>
                            </div>
                            <div class="col-12 mt-2">
                                <label for="">Message</label>
                                <textarea name="msg" class="form-control summernote" {{ $isShown ? 'disabled' : '' }} id="elm1" cols="30" rows="10">{!! isset($notification) ? $notification->msg : '' !!}</textarea>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="">Is Published</label>
                                <div>
                                    <div class="material-switch">
                                        <input id="someSwitchOptionInfo" {{ $isShown ? 'disabled' : '' }} name="status" type="checkbox" {{ isset($notification) && $notification->status == 0 ? '' : 'checked' }} />
                                        <label for="someSwitchOptionInfo" class="label-info"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!$isShown)
                            <div>
                                <input type="submit" class="btn btn-success btn-sm float-end" value="{{ isset($notification) ? 'Update' : 'Create' }} Notification Message" />
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('script')

    @include('common-resource-files.summernote')



@endpush
