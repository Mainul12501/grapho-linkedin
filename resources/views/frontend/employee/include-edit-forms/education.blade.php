<form action="{{ route('employee.employee-educations.update', $data->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="modal-body">
        <!-- Form for adding education -->

        <div class="mb-4">
            <label for="degreeInput" class="form-label">Program Name</label>
            {{--                            <input type="text" class="form-control" id="degreeInput" placeholder="Type here" />--}}
            <select name="education_degree_name_id" class="form-control select2" id="">
                @foreach($educationDegreeNames as $educationDegreeName)
                    <option value="{{ $educationDegreeName->id }}" {{ $data->education_degree_name_id == $educationDegreeName->id ? 'selected' : '' }}>{{ $educationDegreeName->degree_name }}</option>
                @endforeach
            </select>
        </div>

        <div id="universityDiv" >
            <div class="mb-4">
                <label for="universityInput" class="form-label">Name of Institution</label>
                                            <input type="text" class="form-control" id="universityInput" value="{{ $data->institute_name }}" name="institute_name" placeholder="Type here" />
            </div>

            <div class="mb-4">
                <label for="fieldOfStudyInput" class="form-label">Background / Field of study</label>
                            <input type="text" class="form-control" id="fieldOfStudyInput" value="{{ $data->field_of_study }}" name="field_of_study" placeholder="Type here" />
            </div>
        </div>

        <div class="mb-4">
            <label for="passingYear" class="form-label">Passing Year</label>
            <input type="text" class="form-control" value="{{ $data->passing_year }}" name="passing_year" id="passingYear" placeholder="Type here" />
        </div>

        <div class="mb-4">
            <label for="cgpaInput" class="form-label">CGPA</label>
            <input type="text" name="cgpa" value="{{ $data->cgpa }}" class="form-control" id="cgpaInput" placeholder="Type here" />
        </div>

    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
        </button>
        <button type="submit" class="btn btn-primary">
            Update Education
        </button>
    </div>
</form>
