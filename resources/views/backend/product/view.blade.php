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
                                        @foreach($images as $image)
                                            <img src="{{ asset('storage/uploads/products/'.$image->image)}}" width="100" height="100" alt="">
                                        @endforeach
                                        <a href="{{route('product.create')}}" class="btn btn-secondary">Back</a>
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
