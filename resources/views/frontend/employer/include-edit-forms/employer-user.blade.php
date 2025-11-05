<form action="{{ route('employer.update-sub-user', $user->id) }}" method="post" enctype="multipart/form-data">
    @method('put')
    @csrf
    <div class="mb-3">
        <label for="userName" class="form-label">User Name</label>
        <input type="text" class="form-control rounded-3" id="userName" name="name" value="{{ $user->name ?? '' }}" placeholder="Enter Your Name" required />
    </div>
    <div class="mb-3">
        <label for="userEmail" class="form-label">User email</label>
        <input type="email" class="form-control rounded-3" id="userEmail" name="email" value="{{ $user->email ?? '' }}" placeholder="hello.world@gmail.com" >
    </div>
    <div class="mb-3">
        <label for="userMobile" class="form-label">User Mobile</label>
        <input type="text" class="form-control rounded-3" name="mobile" id="userMobile" value="{{ $user->mobile ?? '' }}" placeholder="01500000000" required />
    </div>
    <div class="mb-3">
        <label for="userPassword" class="form-label">User New Password</label>
        <input type="text" class="form-control rounded-3" id="userPassword" name="password" placeholder="00000000"  />
    </div>
                            <div class="mb-4">
                                <label for="userRole" class="form-label">Active Status</label>
                                <select class="form-select rounded-3 select2" id="userRole" name="active_status" >
                                    <option value="active" {{ $user->employer_agent_active_status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $user->employer_agent_active_status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
    <div class="d-flex justify-content-between">
        <button type="button" class="btn border border-2 rounded-3 px-4 py-2" data-bs-dismiss="modal" style="border-color:#ccc;">Cancel</button>
        <button type="submit" class="btn rounded-3 px-4 py-2 text-white fw-semibold btn-success" style="">Update User</button>
    </div>
</form>
