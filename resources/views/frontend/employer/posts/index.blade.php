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
                            <table class="table">
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
                                                        <span class="mx-1">
                                                            <img src="{{ asset($image) }}" alt="" style="height: 60px" />
                                                        </span>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>{{ $post->title ?? '' }}</td>
                                            <td>{!! str()->words($post->description, 30) ?? '' !!}</td>
                                            <td>{{ $post->status == 1 ? 'Published' : 'Unpublished' }}</td>
                                            <td>
                                                <a href="{{ route('employer.posts.show', $post->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa-solid fa-hand-paper"></i>
                                                </a>
                                                <a href="{{ route('employer.posts.edit', $post->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>
                                                <form class="d-inline" action="{{ route('employer.posts.destroy', $post->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger data-delete-form">
                                                        <i class="fa-solid fa-trash"></i>
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

@endpush
@push('script')

    @include('backend.includes.assets.plugin-files.datatable')
@endpush
