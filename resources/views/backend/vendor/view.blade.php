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
                                        <h5>Vendor Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <li><span class="font-weight-bold">Name: </span>{{$vendor->name}}</li>
                                            <li><span class="font-weight-bold">Phone: </span>{{$vendor->phone}}</li>
                                            <li><span class="font-weight-bold">Country: </span>{{$vendor->country}}</li>
                                            <li><span class="font-weight-bold">City: </span>{{$vendor->city}}</li>
                                            <li><span class="font-weight-bold">Is Featured: </span>@if($vendor->is_featured == 1) true @else false @endif</li>
                                            <li><span class="font-weight-bold">End of subscription: </span>{{$vendor->end_subscription}}</li>
                                        </ul>
                                        <a href="{{route('vendor.create')}}" class="btn btn-secondary">Back</a>
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
