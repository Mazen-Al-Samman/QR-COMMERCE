@include ('backend.layouts.header', ['userAuthPermission' => $userAuthPermission])
<!-- [ Main Content ] start -->
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
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Invoices List</h5>
                                        <span class="d-block m-t-5">All Invoices list information</span>
                                        <a href="{{ route('invoice.create') }}" class="btn btn-primary mt-5">Create Invoice</a>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover text-center">
                                                <thead>
                                                <tr>
                                                    <th>QR CODE</th>
                                                    <th>Total Price</th>
                                                    <th>User</th>
                                                    <th>Vendor</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($invoice_data as $invoice)
                                                    <tr>
                                                        <td><img src="{{ asset('assets/images/uploads/qr/'.$invoice->qr_code)}}" class="rounded" width="75" height="75" alt=""></td>
                                                        <td>{{$invoice->total_price}}</td>
                                                        <td>@if($invoice->user_id) {{$invoice->user->first_name}} @else <span class="text-danger">Un-Assign</span> @endif</td>
                                                        <td>{{$invoice->vendor->name}}</td>
                                                        <td class="d-flex align-items-center justify-content-center">
                                                            <a href="{{route('invoice.show' , $invoice->id )}}" class="btn btn-info">View</a>
                                                            <a href="{{route('invoice.streamPdf' , $invoice->id )}}" target="_blank" class="btn btn-warning">View as PDF</a>
                                                            <a href="{{route('invoice.pdf' , $invoice->id )}}" class="btn btn-danger">Download PDF</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <div class="container">
                                            <!-- for Paginate -->
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
