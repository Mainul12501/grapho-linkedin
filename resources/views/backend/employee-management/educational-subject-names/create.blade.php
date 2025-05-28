@extends('backend.master')

@section('title', 'Educational Subject ')

@section('body')
    <div class="row py-5">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="text-white">Educational Subject Create</h4>
                    <a href="{{ route('educational-subject-names.index') }}" class="btn rounded-circle position-absolute end-0 me-3">
                        <i class="fa-regular fa-file-lines fa-2x text-white"></i>
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ isset($educationalSubjectName) ? route('educational-subject-names.update', $educationalSubjectName->id) : route('educational-subject-names.store') }}" method="post">
                        @csrf
                        @if(isset($educationalSubjectName))
                            @method('put')
                        @endif
                        <div >
                            <label for="">Field of Study</label>
                            <select name="field_of_study_id" id="" class="form-control select2" {{ $isShown ? 'disabled' : '' }} required>
                                @foreach($fieldOfStudies as $fieldOfStudy)
                                    <option value="{{ $fieldOfStudy->id }}" {{ isset($educationalSubjectName) && $educationalSubjectName->field_of_study_id == $fieldOfStudy->id ? 'selected' : '' }} >{{ $fieldOfStudy->field_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="">Subject Name</label>
                            <input type="text" name="subject_name" {{ $isShown ? 'disabled' : '' }} class="form-control" value="{{ isset($educationalSubjectName) ? $educationalSubjectName->subject_name : '' }}" />
                        </div>
                        <div class="mt-2">
                            <label for="">Note</label>
                            <textarea name="note" class="form-control" {{ $isShown ? 'disabled' : '' }} id="" cols="30" rows="2">{{ isset($educationalSubjectName) ? $educationalSubjectName->note : '' }}</textarea>
                        </div>
                        <div class="mt-2 row">
{{--                            <div class="col-md-3">--}}
{{--                                <label for="">Is Approved University</label>--}}
{{--                                <div>--}}
{{--                                    <div class="material-switch">--}}
{{--                                        <input id="someSwitchOptionInfo" {{ $isShown ? 'disabled' : '' }} name="status" type="checkbox" {{ isset($educationalSubjectName) && $educationalSubjectName->status == 0 ? '' : 'checked' }} />--}}
{{--                                        <label for="someSwitchOptionInfo" class="label-info"></label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-md-3">
                                <label for="">Is Published</label>
                                <div>
                                    <div class="material-switch">
                                        <input id="someSwitchOptionInfo" {{ $isShown ? 'disabled' : '' }} name="status" type="checkbox" {{ isset($educationalSubjectName) && $educationalSubjectName->status == 0 ? '' : 'checked' }} />
                                        <label for="someSwitchOptionInfo" class="label-info"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!$isShown)
                            <div>
                                <input type="submit" class="btn btn-success btn-sm float-end" value="{{ isset($educationalSubjectName) ? 'Update' : 'Create' }} Educational Subject" />
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.3.2/tinymce.min.js" integrity="sha512-9w/jRiVYhkTCGR//GeGsRss1BJdvxVj544etEHGG1ZPB9qxwF7m6VAeEQb1DzlVvjEZ8Qv4v8YGU8xVPPgovqg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{--    <script src="{{ asset('/') }}backend/assets/libs/tinymce/tinymce.min.js"></script>--}}

    <!-- init js -->
{{--    <script src="{{ asset('/') }}backend/assets/js/pages/form-editor.init.js"></script>--}}

{{--    <script src="//cdn.ckeditor.com/4.19.1/full/ckeditor.js"></script>--}}
    <script>
        // CKEDITOR.replace( 'elm1', {

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
