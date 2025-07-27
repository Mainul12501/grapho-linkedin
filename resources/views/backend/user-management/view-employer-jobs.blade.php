@extends('backend.master')

@section('title', '{{ $user->name }} Jobs')

@section('body')
    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">{{ $user->name }} Jobs</h4>
{{--                    @can('create-permission')--}}
                        <a href="{{ route('users.index', ['user_type' => 'employer']) }}" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
{{--                    @endcan--}}
                </div>
                <div class="card-body">
                    <table class="table" id="file-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Basic Info</th>
{{--                                <th>Education</th>--}}
                                <th>Experience</th>
                                <th>Salary</th>
                                <th>Published Date</th>
                                <th>Deadline</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($jobs as $job)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $job->job_title ?? '' }}</td>
                                <td>
                                    <span>Company : {{ $job?->employerCompany?->name ?? '' }}</span> <br>
                                    <span>Type : {{ $job?->jobType?->name ?? '' }}</span> <br>
                                    <span>Location Type : {{ $job?->jobLocationType?->name ?? '' }}</span>
                                </td>
{{--                                <td>--}}
{{--                                    <span>Company : {{ $job?->employerCompany?->name ?? '' }}</span> <br>--}}
{{--                                    <span>Type : {{ $job?->jobType?->name ?? '' }}</span> <br>--}}
{{--                                    <span>Location Type : {{ $job?->jobLocationType?->name ?? '' }}</span>--}}
{{--                                </td>--}}
                                <td>{{ $job->required_experience ?? 0 }}</td>
                                <td>
                                    <span>Type: {{ $job->job_pref_salary_payment_type ?? 'monthly' }}</span> <br>
                                    @if(isset($job->salary_range_start) && isset($job->salary_range_end))
                                        <span>Amount: {{ $job->salary_range_start }} - {{ $job->salary_range_end }}</span> <br>
                                    @else
                                        <span>Amount: {{ $job->salary_amount ?? 'monthly' }}</span> <br>
                                    @endif
                                </td>
                                <td>{!!  $job->created_at->format('D-M, Y') ?? '' !!}</td>
                                <td>{!!  \Illuminate\Support\Carbon::parse($job->deadline)->format('D-M, Y') ?? '' !!}</td>
                                <td>{!!  \Illuminate\Support\Str::words($job->description, 60) ?? '' !!}</td>
                                <td>{{ $job->status == 1 ? 'Published' : 'Unpublished' }}</td>
                                <td class="">
{{--                                    @can('edit-permission')--}}

{{--                                    <form class="d-inline" action="{{ route('change-user-approve-status', ['user' => $job->id, 'status' => 1]) }}" method="post">--}}
{{--                                        @csrf--}}
{{--                                        <button type="submit" class="btn btn-sm btn-warning">--}}
{{--                                            <i class="fa-solid fa-check"></i>--}}
{{--                                        </button>--}}
{{--                                    </form>--}}

{{--                                    @endcan--}}
{{--                                    @can('delete-permission')--}}
{{--                                        <form class="d-inline" action="{{ route('change-user-approve-status', ['user' => $job->id, 'status' => 2]) }}" method="post" >--}}
{{--                                            @csrf--}}
{{--                                            <button type="submit" class="btn btn-sm btn-danger data-delete-form">--}}
{{--                                                <i class="fa-solid fa-trash"></i>--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
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
@endsection

@push('style')
    <!-- DataTables -->
    <link href="{{ asset('/') }}backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/') }}backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endpush

@push('script')
{{--    <!-- Required datatable js -->--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>--}}
{{--    <!-- Buttons examples -->--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/jszip/jszip.min.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/pdfmake/build/pdfmake.min.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/pdfmake/build/vfs_fonts.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>--}}

{{--    <!-- Responsive examples -->--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>--}}

{{--    <!-- Datatable init js -->--}}
{{--    <script src="{{ asset('/') }}backend/assets/js/pages/datatables.init.js"></script>--}}
{{--    <script>--}}
{{--        // $('#datatable-buttons_wrapper').DataTable();--}}
{{--    </script>--}}
    @include('backend.includes.assets.plugin-files.datatable')
@endpush
