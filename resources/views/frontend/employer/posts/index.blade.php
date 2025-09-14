@extends('frontend.employer.master')

@section('title', 'Employer Posts')

@section('body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="float-start">{{ auth()->user()->name ?? 'Employer Name' }} Posts</h4>
                        <p class="float-end">
                            <a href="{{ route('employer.posts.create') }}" class="btn btn-sm btn-success">Create</a>
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="responsive-datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Images</th>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $key => $post)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if(isset($post->images))
                                                    @foreach(json_decode($post->images) as $image)
                                                        <span class="">
                                                            <img src="{{ asset($image) }}" alt="" class="m-1" style="height: 60px" />
                                                        </span>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>{{ $post->title ?? '' }}</td>
                                            <td>{!! str()->words($post->description, 30) ?? '' !!}</td>
                                            <td>{{ $post->status == 1 ? 'Published' : 'Unpublished' }}</td>
                                            <td class="">
                                                <a href="{{ route('employer.posts.show', $post->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa-solid fa-eye text-white"></i>
                                                </a> <br>
                                                <a href="{{ route('employer.posts.edit', $post->id) }}" class="btn btn-sm btn-warning my-1">
                                                    <i class="fa-solid fa-edit text-white"></i>
                                                </a> <br>
                                                <form class="d-inline" action="{{ route('employer.posts.destroy', $post->id) }}" onsubmit="deletePost($(this))" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger data-delete-form">
                                                        <i class="fa-solid fa-trash text-white"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .dataTables_filter {float: right}
        #responsive-datatable_paginate {float: right}
    </style>
@endpush
@push('script')

    @include('backend.includes.assets.plugin-files.datatable')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function deletePost(formElement) {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Swal.fire({
                    //     title: "Deleted!",
                    //     text: "Your file has been deleted.",
                    //     icon: "success"
                    // });
                    formElement.submit();
                }
            });
        }
    </script>
@endpush
