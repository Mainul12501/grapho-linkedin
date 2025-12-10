<form action="{{ route('employee.employee-documents.update', $data->id) }}" id="editEmployeeDocuments" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="modal-body">
        <!-- Form for adding document -->

        <div class="mb-3">
            <label for="documentFileTitleInput" class="form-label">{{ trans('employee.document_title') }}</label>
            <div class="d-flex align-items-center">
{{--                <input type="text" name="title" value="{{ $data->title ?? '' }}" class="form-control" id="documentFileTitleInput" />--}}
                <select name="title" required class="form-control select2" id="">
                    <option value="CV" {{ $data->title == 'CV' ? 'selected' : '' }}>CV</option>
                    <option value="NID" {{ $data->title == 'NID' ? 'selected' : '' }}>NID</option>
                    <option value="Certificate" {{ $data->title == 'Certificate' ? 'selected' : '' }}>Certificate</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label for="documentFileInput" class="form-label">{{ trans('employee.document_file') }}</label>
            <div class="d-flex align-items-center">
                <input type="file" required name="file" class="form-control" id="documentFileInput" />
                {{--                                    <span class="ms-2">cv.pdf <small>(PDF - 325 KB)</small></span>--}}
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                @if( explode('/', $data->file_type)[1] == 'image' )
                    <img style="max-width: 105px; max-height: 105px;" src="{{ isset($data->file_thumb) ? asset($data->file_thumb) : 'https://icons.iconarchive.com/icons/icons8/windows-8/512/Very-Basic-Image-File-icon.png' }}" alt="Company Logo" class="companyLogo" />
                    <img style="width: 40px; height: 42px" src="{{ isset($data->file_thumb) ? asset($data->file_thumb) : 'https://icons.iconarchive.com/icons/icons8/windows-8/512/Very-Basic-Image-File-icon.png'}}" alt="Company Logo" class="mobileLogo" />
                @elseif( explode('/', $data->file_type)[1] == 'pdf' )
                    <img style="max-width: 105px; max-height: 105px;" src="https://www.iconpacks.net/icons/2/free-pdf-icon-3375-thumb.png" alt="Company Logo" class="companyLogo" />
                    <img style="width: 40px; height: 42px" src="https://www.iconpacks.net/icons/2/free-pdf-icon-3375-thumb.png" alt="Company Logo" class="mobileLogo" />
                @elseif( explode('/', $data->file_type)[1] == 'vnd.openxmlformats-officedocument.wordprocessingml.document' )
                    <img style="max-width: 105px; max-height: 105px;" src="https://files.softicons.com/download/toolbar-icons/mono-general-icons-2-by-custom-icon-design/ico/document.ico" alt="Company Logo" class="companyLogo" />
                    <img style="width: 40px; height: 42px" src="https://files.softicons.com/download/toolbar-icons/mono-general-icons-2-by-custom-icon-design/ico/document.ico" alt="Company Logo" class="mobileLogo" />
                @else
                    <img style="max-width: 105px; max-height: 105px;" src="{{ asset('/') }}frontend/employee/images/profile/CV.png" alt="Company Logo" class="companyLogo" />
                    <img style="width: 40px; height: 42px" src="{{ asset('/') }}frontend/employee/images/profile/CV.png" alt="Company Logo" class="mobileLogo" />
                @endif

            </div>
        </div>

    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            {{ trans('common.close') }}
        </button>
        <button type="submit" class="btn btn-primary">
            {{ trans('employee.upload_document') }}
        </button>
    </div>
</form>
