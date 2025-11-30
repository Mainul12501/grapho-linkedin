@extends('frontend.employer.master')

@section('title', 'Create Posts')

@section('body')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="float-start">{{ isset($post) ? trans('common.update') : trans('common.add') }} {{ trans('employer.post') }}</h4>
                        <p class="float-end">
                            <a href="{{ route('employer.posts.index') }}" class="btn btn-sm btn-success">{{ trans('common.previous') }}</a>
                        </p>
                    </div>
                    <div class="card-body">
                        <div>
                            <form action="{{ isset($post) ? route('employer.posts.update', $post->id) : route('employer.posts.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @if(isset($post))
                                    @method('put')
                                @endif
                                <div>
                                    <label for="">{{ trans('employer.post') }} {{ trans('common.title') }}</label>
                                    <input type="text" name="title" {{ $isShown ? 'disabled' : '' }} class="form-control" value="{{ isset($post) ? $post->title : '' }}" />
                                </div>
                                <div class="mt-2">
                                    <label for="">{{ trans('employer.post') }} {{ trans('content') }}</label>
                                    <textarea name="description" class="form-control summernote" {{ $isShown ? 'disabled' : '' }} id="summernote" cols="30" rows="2">{!! isset($post) ? $post->description : '' !!}</textarea>
                                </div>
                                <div class="mt-2">
                                    <label for="">{{ trans('employer.post') }} {{ trans('common.images') }}</label> <br>
                                    @if(!$isShown)
                                        <input type="file" name="images[]" accept="images/*" multiple />
                                    @endif
                                    @if(isset($post) && isset($post->images))
                                        <div class="mt-1">
                                            @foreach(json_decode($post->images) as $image)
                                                <span class="p-1">
                                                <img src="{{ asset($image) }}" alt="" style="height: 60px">
                                            </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-2 row">
                                    <div class="col-md-3">

                                        <div>
{{--                                            <div class="material-switch">--}}
{{--                                                <input id="someSwitchOptionInfo" {{ $isShown ? 'disabled' : '' }} name="status" type="checkbox" {{ isset($post) && $post->status == 0 ? '' : 'checked' }} />--}}
{{--                                                <label for="someSwitchOptionInfo" class="label-info"></label>--}}
{{--                                            </div>--}}

                                            <label for="flexSwitchCheckChecked" class="d-inline-flex" id="form-check-label">{{ trans('common.status') }}</label>
                                            <br>
                                            <div class="form-check form-switch d-inline-flex">
                                                <input class="form-check-input" name="status" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ isset($post) && $post->status == 0 ? '' : 'checked' }}>
{{--                                                <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label>--}}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @if(!$isShown)
                                    <div>
                                        <input type="submit" class="btn btn-success btn-sm float-end" value="{{ isset($post) ? trans('common.update') : trans('common.add') }} {{ trans('employer.post') }}" />
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')

@endpush
@push('script')
{{--    @include('common-resource-files.summernote')--}}
    <script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            CKEDITOR.replace( 'summernote', {
                versionCheck: false,
                // extraPlugins: 'uploadimage',
                // removePlugins: 'image',
                // filebrowserUploadUrl: '',
                // filebrowserImageUploadUrl: '',
            } );
        })
    </script>
@endpush
