@include ('backend.layouts.header', ['userAuthPermission' => $userAuthPermission])
<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <!-- [ form-element ] start -->
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Manage Role</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5>Edit Role</h5>
                                        @if(session()->has('alert-update'))
                                            <div class="alert alert-success">
                                                {{ session()->get('alert-update') }}
                                            </div>
                                        @endif
                                        <hr>
                                        <form action="{{route('role-permission.update',['role_id' => $role->id])}}" method="post">
                                            @method('put')
                                            @csrf
                                            <input type="hidden" value="{{$role->id}}" name="role_id">
                                            <div class="row d-flex justify-content-center">
                                                @if(count($permissions) > 0)
                                                @foreach($permissions as $permission)
                                                    <div class="col-3 m-1">
                                                        <input type="checkbox" value="{{$permission->permission_id}}" name="permissions[]" @if($role->id == $permission->role_id) checked @endif> <span class="font-weight-bold ml-1" style="font-size: 18px">{{$permission->permission}}</span>
                                                    </div>
                                                @endforeach
                                                @else
                                                    <div class="col-12 alert alert-danger">
                                                        There is No Permissions
                                                    </div>
                                                @endif
                                                <div class="col-md-12 mt-3">
                                                    <button type="submit" class="btn btn-primary">Save Permissions</button>
                                                    <a href="{{route('role-permission.index')}}" class="btn btn-secondary">Back to home</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include ('backend.layouts.footer')
