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
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row">
                                                        @foreach($products as $product)
                                                            <div class="col-4">
                                                                <span>{{$product->name}}</span>
                                                            </div>
                                                            <div class="col-4">
                                                                <input type="number" min="1" value="1" max="10" class="form-control quantity_{{$product->id}}">
                                                            </div>
                                                            <div class="col-4">
                                                                <button id="addToCart" class="btn btn-warning addToCart float-right" data-id="{{$product->id}}"><i class="fa fa-plus"></i></button>
                                                            </div>
                                                        @endforeach
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
    </div>
</div>
@include ('backend.layouts.footer')
