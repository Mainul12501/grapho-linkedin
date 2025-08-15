@extends('backend.master')

@section('title', 'Common Pages')

@section('body')

    <div class="row py-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="float-start text-white">Common Pages</h4>
{{--                    @can('create-permission-category')--}}
                        <a href="{{ route('common-pages.create') }}" class="rounded-circle text-white border-5 text-light f-s-22 btn position-absolute end-0 me-4">
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
                                <th>Type</th>
                                <th>Image</th>
                                <th>Content</th>
{{--                                <th>SEO Header</th>--}}
{{--                                <th>SEO Footer</th>--}}
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($commonPages as $commonPage)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $commonPage->title ?? '' }}</td>
                                <td>{{ $commonPage->type ?? '0' }}</td>
                                <td>
                                    <img src="{{ asset($commonPage->main_image) }}" alt="" style="height: 60px;" />
                                </td>
                                <td>{!! \Illuminate\Support\Str::words($commonPage->content, 30, '...') ?? '' !!}</td>
                                <td>{{ $commonPage->status == 1 ? 'Published' : 'Unpublished' }}</td>
                                <td class="">
{{--                                    @can('edit-permission-category')--}}
                                    <a href="{{ route('common-pages.edit', $commonPage->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
{{--                                    @endcan--}}
{{--                                    @can('delete-permission-category')--}}
                                        <form class="d-inline" action="{{ route('common-pages.destroy', $commonPage->id) }}" method="post">
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
