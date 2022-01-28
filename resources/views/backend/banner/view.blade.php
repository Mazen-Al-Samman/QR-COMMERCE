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
                                        <h5>Banner Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <li><span class="font-weight-bold">Title: </span>{{$banner->title}}</li>
                                            <li><span class="font-weight-bold">Body: </span>{{$banner->body}}</li>
                                            <li><span class="font-weight-bold">Vendor: </span>{{$banner->vendor->name}}</li>
                                            <li><span class="font-weight-bold">Is Published: </span>{{$banner->is_published ? "true" : "false"}}</li>
                                            <li><span class="font-weight-bold">Image: </span></li>
                                        </ul>
                                        <div class="col-auto">
                                            <img src="{{ asset('assets/images/uploads/banners/'.$banner->image)}}" style="box-shadow: 5px 5px 5px darkred; width: 150px; height: 150px" class="rounded" alt="">
                                        </div>
                                        <a href="{{route('banner.create')}}" class="btn btn-secondary mt-4">Back</a>
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
