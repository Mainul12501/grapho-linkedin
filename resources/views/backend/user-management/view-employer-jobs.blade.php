@extends('backend.master')

@section('title', "$user->name Jobs")

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
                                <td><a href="javascript:void(0)" class="nav-link text-success view-job" data-job-id="{{ $job->id }}">{{ $job->job_title ?? '' }}</a></td>
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
                                    @if($job->is_softly_deleted == 1)
                                        <form class="d-inline" action="{{ route('job-soft-delete-status', ['jobTask' => $job->id, 'status' => 0]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Unblock the Job">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                    @endif

{{--                                    @endcan--}}
{{--                                    @can('delete-permission')--}}
                                    @if($job->is_softly_deleted == 0)
                                        <form class="d-inline" action="{{ route('job-soft-delete-status', ['jobTask' => $job->id, 'status' => 1]) }}" method="post" >
                                            @csrf
                                            <button type="submit" title="Soft Delete Job" class="btn btn-sm btn-danger data-delete-form">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif

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

    <div class="modal fade" id="showJob">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Job</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body" id="appendJobHere">
                    <p>Modal body text goes here.</p>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('style')
    <!-- DataTables -->
    <link href="{{ asset('/') }}backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/') }}backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <style>
        .p-t-5 .nav-link {
            color: green!important;
            font-size: 18px!important;
            padding: 0px 3px 5px 0px !important;
        }
        .job-type .badge {background-color: gray}

        /* Job details modal styles */
        .sj-detail-company-row {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
        }
        .sj-detail-logo {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid #eee;
        }
        .sj-detail-logo-link {
            flex-shrink: 0;
        }
        .sj-detail-company-info {
            min-width: 0;
        }
        .sj-detail-company-name {
            font-size: 15px;
            font-weight: 650;
            color: #484f5b;
            margin: 0;
        }
        .sj-detail-company-name a {
            color: inherit;
            text-decoration: none;
        }
        .sj-detail-company-name a:hover {
            color: #141c25;
        }
        .sj-detail-company-addr {
            font-size: 13px;
            color: #8c919d;
            margin: 2px 0 0;
        }
        .sj-detail-job-title {
            font-size: 24px;
            font-weight: 800;
            color: #141c25;
            margin: 0 0 10px;
            letter-spacing: -0.3px;
            line-height: 1.25;
        }
        .sj-tag {
            display: inline-block;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 600;
            color: #556070;
            background: #f0f1f4;
            border-radius: 6px;
        }
        .sj-detail-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 16px;
        }
        .sj-detail-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f1f3;
        }
        .sj-apply-btn {
            display: inline-flex !important;
            align-items: center;
            gap: 7px;
            padding: 10px 24px !important;
            font-size: 14px !important;
            font-weight: 700;
            color: #141c25 !important;
            background: #FFCB11 !important;
            border: none !important;
            border-radius: 12px !important;
            cursor: pointer;
            transition: all .2s ease;
            width: auto !important;
            margin: 0 !important;
        }
        .sj-apply-btn:hover {
            background: #f0be00 !important;
            box-shadow: 0 4px 14px rgba(255,203,17,.3);
            color: #141c25 !important;
        }
        .sj-applied-btn {
            display: inline-flex !important;
            align-items: center;
            gap: 7px;
            padding: 10px 24px !important;
            font-size: 14px !important;
            font-weight: 600;
            color: #22c55e !important;
            background: #F0FDF4 !important;
            border: 1px solid #BBF7D0 !important;
            border-radius: 12px !important;
            cursor: default;
            width: auto !important;
            margin: 0 !important;
        }
        .sj-save-btn {
            display: inline-flex !important;
            align-items: center;
            gap: 6px;
            padding: 10px 20px !important;
            font-size: 14px !important;
            font-weight: 600;
            color: #484f5b !important;
            background: #f3f4f6 !important;
            border: 1px solid #e4e5e9 !important;
            border-radius: 12px !important;
            cursor: pointer;
            transition: all .2s ease;
            width: auto !important;
            margin: 0 !important;
        }
        .sj-save-btn:hover {
            background: #e8e9ec !important;
            color: #484f5b !important;
        }
        .sj-detail-meta-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
            padding: 16px;
            background: #f8f9fb;
            border-radius: 12px;
        }
        .sj-meta-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .sj-meta-label {
            font-size: 12px;
            font-weight: 600;
            color: #8c919d;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .sj-meta-value {
            font-size: 14px;
            font-weight: 700;
            color: #141c25;
        }
        .sj-detail-section {
            margin-bottom: 20px;
        }
        .sj-detail-heading {
            font-size: 16px;
            font-weight: 700;
            color: #141c25;
            margin: 0 0 8px;
        }
        .sj-detail-subheading {
            font-size: 14px;
            font-weight: 650;
            color: #141c25;
            margin: 0 0 8px;
        }
        .sj-detail-text {
            font-size: 14px;
            color: #556070;
            line-height: 1.7;
        }
        .sj-detail-text p {
            color: #556070;
        }
        .sj-detail-list {
            padding-left: 20px;
            margin: 0;
        }
        .sj-detail-list li {
            font-size: 14px;
            color: #556070;
            margin-bottom: 4px;
        }
        .sj-skills-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .sj-skill-pill {
            padding: 5px 14px;
            font-size: 12px;
            font-weight: 600;
            color: #484f5b;
            background: #f0f1f4;
            border-radius: 20px;
        }
        .about-company-name {
            margin-top: 10px;
        }
        @media (max-width: 768px) {
            .sj-detail-meta-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
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

<script>
    $(document).on('click', '.view-job', function () {
        var jobId = $(this).attr('data-job-id');
        $.ajax({
            url: "/get-job-details/"+jobId+"?render=1",
            method: "GET",
            success: function (response) {
                $('#appendJobHere').empty().append(response);
                $('#showJob').modal('show');
            }
        })
    })
</script>
@endpush
