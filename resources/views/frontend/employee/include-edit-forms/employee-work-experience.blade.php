<form action="{{ route('employee.employee-work-experiences.update', $data->id) }}" id="" method="post" enctype="multipart/form-data">
    <div class="modal-body">
        <!-- Form for adding work experience -->
        @method('put')
        @csrf
        <div class="mb-4">
            <label for="editJobTitleInput" class="form-label">Job title</label>
            <input type="text" class="form-control" value="{{ $data->title ?? '' }}" name="title" id="editJobTitleInput" placeholder="Type here" />
        </div>

        <div class="mb-4">
            <label for="editJobTypeInput" class="form-label">Job type</label>
            <select class="form-control" id="editJobTypeInput" name="job_type">
                <option value="">Select</option>
                <option value="full_time" {{ $data->job_type == 'full_time' ? 'selected' : '' }}>Full-time</option>
                <option value="part_time" {{ $data->job_type == 'part_time' ? 'selected' : '' }}>Part-time</option>
                <option value="contractual" {{ $data->job_type == 'contractual' ? 'selected' : '' }}>Contractual</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="ediCompanyInput" class="form-label">Company/Organization</label>
            <input type="text" class="form-control" name="company_name" value="{{ $data->company_name }}" id="ediCompanyInput" placeholder="Type here" />

            <div class="mt-3 row">
                <div class="col-8">
                    <label for="editCompanyLogo" class="form-label">Company/Organization Logo</label>
                    <input type="file" class="form-control" name="company_logo" id="editCompanyLogo" accept="image/*" />

                </div>
                <div class="col-4 mt-2">
                    <span id="printCompanyLogo">
                <img src="{{ asset($data->company_logo) }}" alt="" style="width: 80px">
            </span>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label for="startDateInput" class="form-label">Start date</label>
            <div class="d-flex">
                {{--                                <select class="form-control me-2" id="startMonthInput" name="">--}}
                {{--                                    <option value="">Month</option>--}}
                {{--                                    <option value="jan">January</option>--}}
                {{--                                    <option value="feb">February</option>--}}
                {{--                                    <!-- Add other months -->--}}
                {{--                                </select>--}}
                <input type="date" id="editStartDate" value="{{ $data->start_date ?? '' }}" name="start_date" class="form-control m-1" />
                {{--                                <select class="form-control" id="startYearInput" name="">--}}
                {{--                                    <option value="">Year</option>--}}
                {{--                                    <option value="2021">2021</option>--}}
                {{--                                    <option value="2020">2020</option>--}}
                {{--                                    <!-- Add more years -->--}}
                {{--                                </select>--}}
                <input type="date" id="editEndDate" value="{{ $data->end_date ?? '' }}" name="end_date" class="form-control m-1" />
            </div>
        </div>

        <div class="mb-4">
            <div class="form-check">
                <input type="checkbox" {{ $data->is_working_currently == 1 ? 'checked' : '' }} class="form-check-input" id="editCurrentJobCheck" name="is_working_currently" />
                <label class="form-check-label" for="editCurrentJobCheck">I currently work here</label>
            </div>
        </div>

        <div class="mb-4">
            <label for="editLocationInput" class="form-label">Location</label>
            <input type="text" class="form-control" value="{{ $data->office_address ?? '' }}" name="office_address"  id="editLocationInput" placeholder="Type here" />
        </div>

        <div class="mb-4">
            <label for="editWorkSummaryInput" class="form-label">Job summary</label>
            <textarea class="form-control summernote" name="job_responsibilities" id="editWorkSummaryInput" rows="4" placeholder="Type here">{!! $data->job_responsibilities ?? '' !!}</textarea>
        </div>

    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
        </button>
        <button type="submit" class="btn btn-primary">
            Update Experience
        </button>
    </div>
</form>
