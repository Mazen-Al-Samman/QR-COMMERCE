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
                                            <li><span class="font-weight-bold">Title: </span>{{$category->title}}</li>
                                            <li><span class="font-weight-bold">Vendor: </span>{{$category->vendor->name}}</li>
                                            <li><span class="font-weight-bold">Image: </span></li>
                                        </ul>
                                        <div class="col-auto">
                                            {{--                                                        <a href="{{ route('product_image.delete',['id' => $image->id]) }}" class="bg-danger text-light rounded p-2" onclick="return confirm('Are you sure ?')" style="position: absolute; right: 20px; top: 5px;"><i class="fa fa-trash fa-lg"></i></a>--}}
                                            <img src="{{ asset('assets/images/uploads/categories/'.$category->image)}}" style="box-shadow: 5px 5px 5px darkred; width: 150px; height: 150px" class="rounded" alt="">
                                        </div>
                                        <a href="{{route('category.create')}}" class="btn btn-secondary mt-4">Back</a>
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
