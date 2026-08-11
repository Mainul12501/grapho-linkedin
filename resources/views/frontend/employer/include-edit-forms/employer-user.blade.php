<form action="{{ route('employer.update-sub-user', $user->id) }}" method="post" enctype="multipart/form-data">
    @method('put')
    @csrf
    <div class="um-form-group">
        <label class="um-form-label">{{ trans('common.name') }}</label>
        <input type="text" class="form-control um-input" name="name" value="{{ $user->name ?? '' }}" placeholder="{{ trans('employer.enter_your_full_name') }}" required>
    </div>
    <div class="um-form-group">
        <label class="um-form-label">{{ trans('common.email') }}</label>
        <input type="email" class="form-control um-input" name="email" value="{{ $user->email ?? '' }}" placeholder="{{ trans('employer.enter_your_email') }}">
    </div>
    <div class="um-form-group">
        <label class="um-form-label">{{ trans('employer.mobile') }}</label>
        <input type="text" class="form-control um-input" name="mobile" value="{{ $user->mobile ?? '' }}" placeholder="01500000000" required>
    </div>
    <div class="um-form-group">
        <label class="um-form-label">{{ trans('employer.new_password') }}</label>
        <input type="text" class="form-control um-input" name="password" placeholder="00000000">
    </div>
    <div class="um-form-group">
        <label class="um-form-label">{{ trans('common.status') }}</label>
        <select class="form-select um-input" name="active_status">
            <option value="active" {{ $user->employer_agent_active_status == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $user->employer_agent_active_status == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
    <div class="d-flex justify-content-end gap-2 mt-3 pt-3" style="border-top: 1px solid #F1F5F9;">
        <button type="button" class="btn um-btn-cancel" data-bs-dismiss="modal">{{ trans('common.cancel') }}</button>
        <button type="submit" class="btn um-btn-save">{{ trans('common.update') }}</button>
    </div>
</form>
