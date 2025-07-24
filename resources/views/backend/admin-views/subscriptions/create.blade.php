@extends('backend.master')

@section('title', 'Subscription')

@section('body')
    <div class="row py-5">
        <div class="col-md-9 mx-auto">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="text-white">Subscription Create</h4>
                    <a href="{{ route('subscriptions.index') }}" class="btn rounded-circle position-absolute end-0 me-3">
                        <i class="fa-regular fa-file-lines fa-2x text-white"></i>
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ isset($subscription) ? route('subscriptions.update', $subscription->id) : route('subscriptions.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if(isset($subscription))
                            @method('put')
                        @endif
                        <div class="row">
                            <div class="col-12">
                                <label for="">Title</label>
                                <input type="text" name="title" {{ $isShown ? 'disabled' : '' }} class="form-control" value="{{ isset($subscription) ? $subscription->title : '' }}" />
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Price</label>
                                <input type="number" name="price" {{ $isShown ? 'disabled' : '' }} class="form-control" value="{{ isset($subscription) ? $subscription->price : '' }}" />
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Duration (In days)</label>
                                <input type="number" name="duration_in_days" {{ $isShown ? 'disabled' : '' }} class="form-control" value="{{ isset($subscription) ? $subscription->duration_in_days : '' }}" />
                            </div>
                            <div class="col-12 mt-2">
                                <label for="">Features</label>
                                <textarea name="plan_features" class="form-control summernote" {{ $isShown ? 'disabled' : '' }} id="elm1" cols="30" rows="10">{!! isset($subscription) ? $subscription->plan_features : '' !!}</textarea>
                            </div>
                            <div class="col-12 mt-2">
                                <label for="">Extra Note</label>
                                <textarea name="note" class="form-control" {{ $isShown ? 'disabled' : '' }} id="elm1" cols="30" rows="5">{!! isset($subscription) ? $subscription->note : '' !!}</textarea>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="">Is Published</label>
                                <div>
                                    <div class="material-switch">
                                        <input id="someSwitchOptionInfo" {{ $isShown ? 'disabled' : '' }} name="status" type="checkbox" {{ isset($subscription) && $subscription->status == 0 ? '' : 'checked' }} />
                                        <label for="someSwitchOptionInfo" class="label-info"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!$isShown)
                            <div>
                                <input type="submit" class="btn btn-success btn-sm float-end" value="{{ isset($subscription) ? 'Update' : 'Create' }} Subscription" />
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('script')
    <!--tinymce js-->
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.3.2/tinymce.min.js" integrity="sha512-9w/jRiVYhkTCGR//GeGsRss1BJdvxVj544etEHGG1ZPB9qxwF7m6VAeEQb1DzlVvjEZ8Qv4v8YGU8xVPPgovqg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
{{--    <script src="{{ asset('/') }}backend/assets/libs/tinymce/tinymce.min.js"></script>--}}

    <!-- init js -->
{{--    <script src="{{ asset('/') }}backend/assets/js/pages/form-editor.init.js"></script>--}}

{{--    <script src="//cdn.ckeditor.com/4.19.1/full/ckeditor.js"></script>--}}
    @include('common-resource-files.summernote')
    <script>
        // CKEDITOR.replace( 'elm1', {
        //     versionCheck: false
            // enable these options to upload image after installing ckfinder in the project.. use npm or cdn brother

            // filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
            // filebrowserImageBrowseUrl: '/ckfinder/ckfinder.html?type=Images',
            // filebrowserFlashBrowseUrl: '/ckfinder/ckfinder.html?type=Flash',
            // filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            // filebrowserImageUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            // filebrowserFlashUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        // } );
        // tinymce.init({
        //     selector: 'textarea#elm1',
        //     height: 200,
        //     menubar: false,
        //     plugins: [
        //         'advlist autolink lists link image charmap print preview anchor',
        //         'searchreplace visualblocks code fullscreen',
        //         'insertdatetime media table paste code help wordcount'
        //     ],
        //     toolbar: 'undo redo | formatselect | ' +
        //         'bold italic backcolor | alignleft aligncenter ' +
        //         'alignright alignjustify | bullist numlist outdent indent | ' +
        //         'removeformat | help',
        //     content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        // });


    </script>


@endpush
