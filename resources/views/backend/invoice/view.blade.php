@include ('backend.layouts.header')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <div class="col-12">
                                @if(session()->has('alert-delete'))
                                    <div class="alert alert-warning">
                                        {{ session()->get('alert-delete') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Invoice</h5>
                                        <span class="d-block m-t-5">Invoice Detail</span>
                                    </div>
                                    <div class="card-body table-border-style">
                                        {!! QrCode::size(150)->generate(route('invoice.show',['invoice_id' => $invoice_data->id])) !!}
                                        <h4>Total Price: {{$invoice_data->total_price}} JOD</h4>
                                        <h4>Total Price: {{$invoice_data->user->first_name}}</h4>
                                        <h4>Total Price: {{$invoice_data->vendor->name}}</h4>
                                        <div class="table-responsive">
                                            <table class="table table-hover text-center">
                                                <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Category</th>
                                                    <th>quantity</th>
                                                </tr>
                                                </thead>
                                                <tbody id="cart-content">
                                                    @foreach($invoice_products as $product)
                                                        <tr>
                                                            <td><img src="{{ asset('storage/uploads/products/'.$product->main_image)}}" class="rounded" width="75" height="75" alt=""></td>
                                                            <td>{{$product->name}}</td>
                                                            <td>{{$product->category_name}}</td>
                                                            <td>2</td>
                                                        </tr>
                                                    @endforeach
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
