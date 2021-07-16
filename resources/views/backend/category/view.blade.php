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
                                            <li><span class="font-weight-bold">Title: </span>{{$category->title}}</li>
                                            <li><span class="font-weight-bold">Vendor: </span>{{$category->vendor->name}}</li>
                                            <li><span class="font-weight-bold">Image: </span>
                                                <img src="{{ asset('storage/uploads/categories/'.$category->image)}}" class="rounded" width="75" height="75" alt="">
                                            </li>
                                        </ul>
                                        <a href="{{route('role.create')}}" class="btn btn-secondary">Back</a>
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
