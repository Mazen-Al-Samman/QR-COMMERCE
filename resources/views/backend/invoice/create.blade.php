@include ('backend.layouts.header')
<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <!-- [ form-element ] start -->
                            <div class="col-sm-12">
                                @if(session()->has('alert-empty-cart'))
                                <div class="alert alert-danger">
                                    {{ session()->get('alert-empty-cart') }}
                                </div>
                                @endif
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Manage Invoice</h5>
                                    </div>
                                    <div class="card-body">
                                        @if(session()->has('alert-success'))
                                            <div class="alert alert-success">
                                                {{ session()->get('alert-success') }}
                                            </div>
                                        @endif
                                            <div class="row mb-4">
                                                @foreach($products as $product)
                                                    <div class="col-lg-6 col-sm-12 col-md-12 border-right">
                                                        <div class="row mb-3">
                                                            <div class="col-6 mt-3">
                                                                <span class="font-weight-bold" style="font-size: 18px">{{$product->name}}</span>
                                                            </div>
                                                            <div class="col-auto">
                                                                <input type="number" min="1" value="1" max="10" class="form-control quantity_{{$product->id}}">
                                                            </div>
                                                            <div class="col-auto">
                                                                <button id="addToCart" class="btn btn-warning addToCart float-right" data-id="{{$product->id}}"><i class="fa fa-plus"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row">
                                                <div class="col-4 d-flex align-items-center ">
                                                        <a href="{{route('invoice.store')}}" data-method="POST" class="btn btn-secondary btn-block">Generate QR</a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                @if(session()->has('alert-delete'))alert-empty-cart
                                    <div class="alert alert-warning">
                                        {{ session()->get('alert-delete') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Product Cart</h5>
                                        <span class="d-block m-t-5">All Products Inside Cart</span>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover text-center">
                                                <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Category</th>
                                                    <th>Price</th>
                                                    <th style="width: 120px">quantity</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody id="cart-content">
                                                    <tr>
                                                        <td colspan="6">
                                                            <div class="alert alert-warning">
                                                               There is no products
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
</div>
@include ('backend.layouts.footer')