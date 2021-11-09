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
                                        <h5>Product Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <li><span class="font-weight-bold">Product: </span>{{$product->name}}</li>
                                            <li><span class="font-weight-bold">Category: </span>{{$product->category->title}}</li>
                                            <li><span class="font-weight-bold">Old Price: </span>{{$product->old_price}}</li>
                                            <li><span class="font-weight-bold">Price: </span>{{$product->price}}</li>
                                            <li><span class="font-weight-bold">Vendor: </span>{{$product->vendor->name}}</li>
                                            <li><span class="font-weight-bold">Barcode: </span>{{$product->barcode}}</li>
                                            <li><span class="font-weight-bold">Description: </span>{{$product->description}}</li>
                                        </ul>
                                        <div class="row">
                                            <div class="col-12 border-bottom">
                                                <h5>Main Image</h5>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <img src="{{ asset('assets/images/uploads/products/'.$product->main_image)}}" style="width: 100%; height: auto" class="rounded shadow" alt="">
                                            </div>
                                            <div class="col-12 mt-4 mb-2 border-bottom">
                                                <h5>Other Images</h5>
                                            </div>
                                            @foreach($images as $image)
                                                <div class="col-auto">
                                                    <img src="{{ asset('assets/images/uploads/products/'.$image->image)}}" style="width: 175px; height: 175px" class="rounded" alt="">
                                                </div>
                                            @endforeach
                                        </div>
                                        <a href="{{route('product.create')}}" class="btn btn-secondary mt-5">Back</a>
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
