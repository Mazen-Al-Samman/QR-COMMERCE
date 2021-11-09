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
                                        <h5>Admin Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <li><span class="font-weight-bold">Username: </span>{{$admin->username}}</li>
                                            <li><span class="font-weight-bold">Email: </span>{{$admin->email}}</li>
                                            <li><span class="font-weight-bold">Phone: </span>{{$admin->phone}}</li>
                                            <li><span class="font-weight-bold">Active: </span>{{$admin->active}}</li>
                                            <li><span class="font-weight-bold">Role: </span>{{$admin->role_id}}</li>
                                        </ul>
                                        <a href="{{route('admin.create')}}" class="btn btn-secondary">Back</a>
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
