@include ('backend.layouts.header')
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
                                        <form action="{{route('rolePermission.update',['id' => $role->id])}}" method="post">
                                            @method('put')
                                            @csrf
                                            <input type="hidden" value="{{$role->id}}" name="role_id">
                                            <div class="row">
                                                @foreach($permissions as $permission)
                                                    <div class="col-auto m-1">
                                                        <input type="checkbox" value="{{$permission->permission_id}}" name="permissions[]" @if($role->id == $permission->role_id) checked @endif> <span class="font-weight-bold ml-1" style="font-size: 18px">{{$permission->permission}}</span>
                                                    </div>
                                                @endforeach
                                                <div class="col-md-12 mt-3">
                                                    <button type="submit" class="btn btn-warning">Update</button>
                                                    <a href="{{route('rolePermission.index')}}" class="btn btn-primary">Back to home</a>
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
