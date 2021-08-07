@include ('backend.layouts.header', ['userAuthPermission' => $userAuthPermission])
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{$role->role_title}}</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><span class="font-weight-bold">Description: </span>{{$role->role_description}}</p>
                                        @if(empty($permissions[0]))
                                            <div class="alert alert-danger" role="alert">
                                                There is no Permissions
                                            </div>
                                        @endif
                                        <ul>
                                            @foreach($permissions as $permission)
                                                <li><span class="font-weight-bold"></span>{{$permission->permission->permission}}</li>
                                            @endforeach
                                        </ul>
                                        <a href="{{route('role-permission.index')}}" class="btn btn-secondary">Back</a>
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
