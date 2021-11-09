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
                                        <h5>Permission Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <li><span class="font-weight-bold">Permission: </span>{{$permission->permission}}</li>
                                            <li><span class="font-weight-bold">Description: </span>{{$permission->description}}</li>
                                        </ul>
                                        <a href="{{route('permission.create')}}" class="btn btn-secondary">Back</a>
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
