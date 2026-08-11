@extends('backend.master')

@section('title', 'Page')

@section('body')
    <div class="row py-5">
        <div class="col-md-9 mx-auto">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="text-white">Page {{ isset($page) ? 'Create' : 'Update' }}</h4>
                    <a href="{{ route('common-pages.index') }}" class="btn rounded-circle position-absolute end-0 me-3">
                        <i class="fa-regular fa-file-lines fa-2x text-white"></i>
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ isset($page) ? route('common-pages.update', $page->id) : route('common-pages.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if(isset($page))
                            @method('put')
                        @endif
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <label for="userType">Page Type</label>
                                <select name="type" class="select2 form-control"  id="userType">
                                    <option value="" selected disabled>Select a User type</option>
                                    <option value="about-us" {{ isset($page) && $page->type == 'about-us' ? 'selected' : '' }}>About Us</option>
                                    <option value="contact-us" {{ isset($page) && $page->type == 'contact-us' ? 'selected' : '' }}>Contact Us</option>
                                    <option value="terms-conditions" {{ isset($page) && $page->type == 'terms-conditions' ? 'selected' : '' }}>Terms & Conditions</option>
                                    <option value="privacy-policy" {{ isset($page) && $page->type == 'privacy-policy' ? 'selected' : '' }}>Privacy Policy</option>
                                    <option value="other" {{ isset($page) && $page->type == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Title</label>
                                <input type="text" name="title" {{ $isShown ? 'disabled' : '' }} class="form-control" value="{{ isset($page) ? $page->title : '' }}" />
                            </div>
                            <div class="col-12 mt-2">
                                <label for="">Content</label>
                                <textarea name="content" class="form-control" {{ $isShown ? 'disabled' : '' }} id="elm1" cols="30" rows="5">{!! isset($page) ? $page->content : '' !!}</textarea>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Main Image</label>
                                <input type="file" name="main_image" {{ $isShown ? 'disabled' : '' }} class="form-control"  />
                                @if(isset($page) && file_exists($page->main_image))
                                    <img src="{{ asset($page->main_image) }}" alt="" style="height: 60px" />
                                @endif
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="">Is Published</label>
                                <div>
                                    <div class="material-switch">
                                        <input id="someSwitchOptionInfo" {{ $isShown ? 'disabled' : '' }} name="status" type="checkbox" {{ isset($page) && $page->status == 0 ? '' : 'checked' }} />
                                        <label for="someSwitchOptionInfo" class="label-info"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!$isShown)
                            <div>
                                <input type="submit" class="btn btn-success btn-sm float-end" value="{{ isset($page) ? 'Update' : 'Create' }} Page" />
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

    <script src="//cdn.ckeditor.com/4.19.1/full/ckeditor.js"></script>
{{--    @include('common-resource-files.summernote')--}}
    <script>
        CKEDITOR.replace( 'elm1', {
            versionCheck: false
        } );
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
