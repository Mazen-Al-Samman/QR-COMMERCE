@include ('backend.layouts.header', ['userAuthPermission' => $userAuthPermission])
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
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="product-box border bx-border-radius p-2">
                                                            <input type="number" min="1" value="1" max="10" class="form-control mb-1 quantity_{{$product->id}}">
                                                            <button id="addToCart" class="btn btn-warning btn-block addToCart" data-id="{{$product->id}}">{{$product->name}}</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4 col-xl-4 col-12 d-flex align-items-center ">
                                                    <form action="{{route('invoice.store')}}" method="get">
                                                        <input name="phone" type="hidden" id="hidden-phone">
                                                        <button type="submit" id="generate" data-method="POST" class="btn btn-secondary btn-block">Generate QR</button>

                                                    </form>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="phone" class="col-form-label">User phone number</label>
                        <input type="text" class="form-control" id="phone">
                        <span class="text-danger mt-1" id="not-found"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="check-btn" data-method="POST" class="btn btn-secondary btn-block">Check user</button>
            </div>
        </div>
    </div>
</div>

@include ('backend.layouts.footer')
