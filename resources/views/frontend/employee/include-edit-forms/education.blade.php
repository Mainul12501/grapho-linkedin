<form action="{{ route('employee.employee-educations.update', $data->id) }}" method="post" enctype="multipart/form-data" id="editEducationForm">
    @csrf
    @method('put')
    <div class="modal-body">
        <!-- Form for adding education -->

        <div class="mb-4">
            <label for="degreeInput" class="form-label">{{ trans('employee.program_name') }}</label>
            {{--                            <input type="text" class="form-control" id="degreeInput" placeholder="Type here" />--}}
            <select name="education_degree_name_id" required class="form-control select2" id="">
                @foreach($educationDegreeNames as $educationDegreeName)
                    <option value="{{ $educationDegreeName->id }}" {{ $data->education_degree_name_id == $educationDegreeName->id ? 'selected' : '' }}>{{ $educationDegreeName->degree_name }}</option>
                @endforeach
            </select>
        </div>

        <div id="universityDiv" >
            <div class="mb-4">
                <label for="universityInput" class="form-label">{{ trans('employee.name_of_institution') }}</label>
                                            <input required type="text" class="form-control" id="universityInput" value="{{ $data->institute_name }}" name="institute_name" placeholder="{{ trans('employer.type_here') }}" />
            </div>

            <div class="mb-4">
                <label for="fieldOfStudyInput" class="form-label">{{ trans('employee.background_field_of_study') }}</label>
                            <input required type="text" class="form-control" id="fieldOfStudyInput" value="{{ $data->field_of_study }}" name="field_of_study" placeholder="{{ trans('employer.type_here') }}" />
            </div>
        </div>

        <div class="mb-4">
            <label for="passingYear" class="form-label">{{ trans('employee.passing_year') }}</label>
            <input type="text" required class="form-control" value="{{ $data->passing_year }}" name="passing_year" id="passingYear" placeholder="{{ trans('employer.type_here') }}" />
        </div>

        <div class="mb-4">
            <label for="cgpaInput" class="form-label">{{ trans('employee.cgpa') }}</label>
            <input type="text" name="cgpa" required value="{{ $data->cgpa }}" class="form-control" id="cgpaInput" placeholder="{{ trans('employer.type_here') }}" />
        </div>

    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            {{ trans('common.close') }}
        </button>
        <button type="submit" class="btn btn-primary">
            {{ trans('employee.edit_education') }}
        </button>
    </div>
</form>
