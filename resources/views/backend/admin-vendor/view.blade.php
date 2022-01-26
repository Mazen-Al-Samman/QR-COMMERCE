@include ('backend.layouts.header')
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
                                            <li><span class="font-weight-bold">Admin name: </span>{{$admin->name}}</li>
                                            <li><span class="font-weight-bold">Email: </span>{{$admin->email}}</li>
                                            <li><span class="font-weight-bold">Phone: </span>{{$admin->phone}}</li>
                                            <li><span class="font-weight-bold">Role: </span>{{$admin->role->role_title}}</li>
                                            <li><span class="font-weight-bold">Vendor: </span>{{$admin->vendor->name}}</li>
                                            <li><span class="font-weight-bold">Country: </span>{{$admin->vendor->country}}</li>
                                            <li><span class="font-weight-bold">Ciry: </span>{{$admin->vendor->city}}</li>
                                            <li><span class="font-weight-bold">Start Subscription: </span>{{$admin->vendor->start_subscription}}</li>
                                            <li><span class="font-weight-bold">End Subscription: </span>{{$admin->vendor->end_subscription}}</li>
                                            <li><span class="font-weight-bold">Status: </span>{{$admin->vendor->start_subscription > date('Y-m-d') ? "Active" : "Inactive"}}</li>
                                        </ul>
                                        <a href="{{route('admin-vendor.create')}}" class="btn btn-secondary">Back</a>
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
