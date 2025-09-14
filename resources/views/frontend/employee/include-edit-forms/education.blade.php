<form action="{{ route('employee.employee-educations.update', $data->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="modal-body">
        <!-- Form for adding education -->

        <div class="mb-4">
            <label for="degreeInput" class="form-label">Education Program</label>
            {{--                            <input type="text" class="form-control" id="degreeInput" placeholder="Type here" />--}}
            <select name="education_degree_name_id" class="form-control select2" id="">
                <option selected disabled>Select Education Program</option>
                @foreach($educationDegreeNames as $educationDegreeName)
                    <option value="{{ $educationDegreeName->id }}" {{ $data->education_degree_name_id == $educationDegreeName->id ? 'selected' : '' }}>{{ $educationDegreeName->degree_name }}</option>
                @endforeach
            </select>
        </div>

        <div id="universityDiv" class="{{ $data?->educationDegreeName?->need_institute_field == 1 ? 'd-none' : '' }}">
            <div class="mb-4">
                <label for="universityInput" class="form-label">University name</label>
                {{--                            <input type="text" class="form-control" id="universityInput" placeholder="Type here" />--}}
                <select name="university_name_id" class="form-control select2" id="">
                    <option selected disabled>Select University</option>
                    @foreach($universityNames as $universityName)
                        <option value="{{ $universityName->id }}" {{ $data->university_name_id == $universityName->id ? 'selected' : '' }}>{{ $universityName->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="fieldOfStudyInput" class="form-label">Field of study</label>
                {{--            <input type="text" class="form-control" id="fieldOfStudyInput" placeholder="Type here" />--}}
                <select name="field_of_study_id" class="form-control select2" id="">
                    <option selected disabled>Select Field of Study</option>
                    @foreach($fieldOfStudies as $fieldOfStudy)
                        <option value="{{ $fieldOfStudy->id }}" {{ $data->field_of_study_id == $fieldOfStudy->id ? 'selected' : '' }}>{{ $fieldOfStudy->field_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div id="instituteNameDiv" class="{{ $data?->educationDegreeName?->need_institute_field == 0 ? 'd-none' : '' }}">
            <div class="mb-4 " >
                <label for="instituteName" class="form-label">Institute Name</label>
                <input type="text" class="form-control" name="institute_name" id="instituteName" placeholder="Type here" />
            </div>
            <div class="mb-4 " >
                <label for="groupName" class="form-label">Group Name</label>
                <select name="group_name" class="form-control" id="">
                    <option value="science">Science</option>
                    <option value="commerce">Commerce</option>
                    <option value="arts">Arts</option>
                    <option value="technical">Technical</option>
                    <option value="others">Others</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label for="passingYear" class="form-label">Passing Year</label>
            <input type="text" class="form-control" value="{{ $data->passing_year }}" name="passing_year" id="passingYear" placeholder="Type here" />
        </div>
        {{--                        <div class="mb-4">--}}
        {{--                            <label for="majorSubjectInput" class="form-label">Major subject</label>--}}
        {{--                            <input type="text" class="form-control" id="majorSubjectInput" placeholder="Type here" />--}}
        {{--                        </div>--}}

        {{--                        <div class="mb-4">--}}
        {{--                            <label for="startDateInput" class="form-label">Start date</label>--}}
        {{--                            <div class="d-flex">--}}
        {{--                                <select class="form-control me-2" id="startMonthInput">--}}
        {{--                                    <option value="">Month</option>--}}
        {{--                                    <option value="jan">January</option>--}}
        {{--                                    <option value="feb">February</option>--}}
        {{--                                    <!-- Add other months -->--}}
        {{--                                </select>--}}
        {{--                                <select class="form-control" id="startYearInput">--}}
        {{--                                    <option value="">Year</option>--}}
        {{--                                    <option value="2021">2021</option>--}}
        {{--                                    <option value="2020">2020</option>--}}
        {{--                                    <!-- Add more years -->--}}
        {{--                                </select>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}

        {{--                        <div class="mb-4">--}}
        {{--                            <label for="endDateInput" class="form-label">End date</label>--}}
        {{--                            <div class="d-flex">--}}
        {{--                                <select class="form-control me-2" id="endMonthInput">--}}
        {{--                                    <option value="">Month</option>--}}
        {{--                                    <option value="jan">January</option>--}}
        {{--                                    <option value="feb">February</option>--}}
        {{--                                    <!-- Add other months -->--}}
        {{--                                </select>--}}
        {{--                                <select class="form-control" id="endYearInput">--}}
        {{--                                    <option value="">Year</option>--}}
        {{--                                    <option value="2023">2023</option>--}}
        {{--                                    <option value="2022">2022</option>--}}
        {{--                                    <!-- Add more years -->--}}
        {{--                                </select>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}

        <div class="mb-4">
            <label for="cgpaInput" class="form-label">CGPA</label>
            <input type="text" name="cgpa" value="{{ $data->cgpa }}" class="form-control" id="cgpaInput" placeholder="Type here" />
        </div>

        <div class="mb-4">
            <label for="locationInput" class="form-label">Location</label>
            <input type="text" name="address" value="{{ $data->address }}" class="form-control" id="locationInput" placeholder="Type here" />
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
