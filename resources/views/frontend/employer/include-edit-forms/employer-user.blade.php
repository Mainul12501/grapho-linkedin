<form action="{{ route('employer.update-sub-user', $user->id) }}" method="post" enctype="multipart/form-data">
    @method('PUT')
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
        <input type="text" class="form-control rounded-3" id="userPassword" name="password" placeholder="00000000" required />
    </div>
    {{--                        <div class="mb-4">--}}
    {{--                            <label for="userRole" class="form-label">Role</label>--}}
    {{--                            <select class="form-select rounded-3 select2" id="userRole" name="gender" >--}}
    {{--                                <option>User</option>--}}
    {{--                                <option>Admin</option>--}}
    {{--                                <option>Viewer</option>--}}
    {{--                            </select>--}}
    {{--                        </div>--}}
    <div class="d-flex justify-content-between">
        <button type="button" class="btn border border-2 rounded-3 px-4 py-2" data-bs-dismiss="modal" style="border-color:#ccc;">Cancel</button>
        <button type="submit" class="btn rounded-3 px-4 py-2 text-white fw-semibold btn-success" style="">Update User</button>
    </div>
</form>
