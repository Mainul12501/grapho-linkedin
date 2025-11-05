<form action="{{ route('employee.employee-work-experiences.update', $data->id) }}" id="" method="post" enctype="multipart/form-data">
    <div class="modal-body">
        <!-- Form for adding work experience -->
        @method('put')
        @csrf
        <div class="mb-4">
            <label for="editJobTitleInput" class="form-label">{{ trans('employer.job_title') }}</label>
            <input type="text" class="form-control" value="{{ $data->title ?? '' }}" name="title" id="editJobTitleInput" placeholder="{{ trans('employer.type_here') }}" />
        </div>

        <div class="mb-4">
            <label for="editJobTypeInput" class="form-label">{{ trans('employer.job_type') }}</label>
            <select class="form-control" id="editJobTypeInput" name="job_type">
                <option value="">{{ trans('common.search') }}</option>
                <option value="full_time" {{ $data->job_type == 'full_time' ? 'selected' : '' }}>Full-time</option>
                <option value="part_time" {{ $data->job_type == 'part_time' ? 'selected' : '' }}>Part-time</option>
                <option value="contractual" {{ $data->job_type == 'contractual' ? 'selected' : '' }}>Contractual</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="ediCompanyInput" class="form-label">{{ trans('employee.company_organization') }}</label>
            <input type="text" class="form-control" list="companyDatalist" name="company_name" value="{{ $data->company_name }}" id="ediCompanyInput" placeholder="{{ trans('employer.type_here') }}" />

{{--            <div class="mt-3 row">--}}
{{--                <div class="col-8">--}}
{{--                    <label for="editCompanyLogo" class="form-label">Company/Organization Logo</label>--}}
{{--                    <input type="file" class="form-control" name="company_logo" id="editCompanyLogo" accept="image/*" />--}}

{{--                </div>--}}
{{--                <div class="col-4 mt-2">--}}
{{--                    <span id="printCompanyLogo">--}}
{{--                        <img src="{{ asset($data->company_logo) }}" alt="" style="width: 80px">--}}
{{--                    </span>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>

        <div class="mb-4">
{{--            <label for="startDateInput" class="form-label">Start date</label>--}}
            <div class="d-flex">
                {{--                                <select class="form-control me-2" id="startMonthInput" name="">--}}
                {{--                                    <option value="">Month</option>--}}
                {{--                                    <option value="jan">January</option>--}}
                {{--                                    <option value="feb">February</option>--}}
                {{--                                    <!-- Add other months -->--}}
                {{--                                </select>--}}
                <span style="width: 100%; margin-right: 5px;">
                                        <label for="startDateInput" class="form-label">{{ trans('employee.from') }}</label>
                                        <input type="date" name="start_date" value="{{ $data->start_date ?? '' }}" class="form-control m-1" />
                                    </span>
{{--                <input type="date" id="editStartDate" value="{{ $data->start_date ?? '' }}" name="start_date" class="form-control m-1" />--}}
                {{--                                <select class="form-control" id="startYearInput" name="">--}}
                {{--                                    <option value="">Year</option>--}}
                {{--                                    <option value="2021">2021</option>--}}
                {{--                                    <option value="2020">2020</option>--}}
                {{--                                    <!-- Add more years -->--}}
                {{--                                </select>--}}
                <span style="width: 100%; margin-left: 5px;">
                                        <label for="startDateInput" class="form-label">{{ trans('employee.to') }}</label>
                                        <input type="date" name="end_date" value="{{ $data->end_date ?? '' }}" class="form-control m-1" />
                                    </span>
{{--                <input type="date" id="editEndDate" value="{{ $data->end_date ?? '' }}" name="end_date" class="form-control m-1" />--}}
            </div>
        </div>

        <div class="mb-4">
            <div class="form-check">
                <input type="checkbox" {{ $data->is_working_currently == 1 ? 'checked' : '' }} class="form-check-input" id="editCurrentJobCheck" name="is_working_currently" />
                <label class="form-check-label" for="editCurrentJobCheck">{{ trans('employee.i_currently_work_here') }}</label>
            </div>
        </div>

        <div class="mb-4">
            <label for="editLocationInput" class="form-label">{{ trans('common.location') }}</label>
            <input type="text" class="form-control" value="{{ $data->office_address ?? '' }}" name="office_address"  id="editLocationInput" placeholder="{{ trans('employer.type_here') }}" />
        </div>

        <div class="mb-4">
            <label for="editWorkSummaryInput" class="form-label">{{ trans('employee.responsibilities') }}</label>
            <textarea class="form-control summernote" name="job_responsibilities" id="editWorkSummaryInput" rows="4" placeholder="{{ trans('employer.type_here') }}">{!! $data->job_responsibilities ?? '' !!}</textarea>
        </div>

    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            {{ trans('common.close') }}
        </button>
        <button type="submit" class="btn btn-primary">
            {{ trans('employee.update_work_experience') }}
        </button>
    </div>
</form>
