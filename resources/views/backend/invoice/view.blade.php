<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Invoice</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Invoice <strong>{{$invoice_data['created_at']}}</strong>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-12 @if (!$invoice_data['is_manual'])col-xl-10 @else col-xl-8 @endif col-lg-10 col-md-8 col-sm-8">
                    <h2 class="mt-2">MY BILL</h2>
                    <div class="row mt-4">
                        @if (!$invoice_data['is_manual'])
                            <div class="col-12 col-lg-4 mb-1">
                                <div><span class="font-weight-bold m-0">Vendor:</span> {{$invoice_data['vendor']['name']}}</div>
                                <div><span class="font-weight-bold m-0">Phone:</span> {{$invoice_data['vendor']['phone']}}</div>
                            </div>
                        @endif
                        <div class="mb-1 @if (!$invoice_data['is_manual']) col-12 col-lg-4 @else col-12 @endif">
                            @if ($invoice_data['is_manual'])
                                <div class="mb-3"><span class="font-weight-bold m-0">Title:</span> {{$invoice_data['title']}}</div>
                            @endif
                            @if($user = $invoice_data['user'])
                                <div><span class="font-weight-bold m-0">Full Name:</span> {{$user['first_name'].' '.$user['last_name']}}</div>
                                <div><span class="font-weight-bold m-0">Phone:</span> {{$user['phone']}}</div>
                            @else
                                <div><span class="font-weight-bold m-0">&nbsp;</span></div>
                                <div><span class="font-weight-bold m-0">&nbsp;</span></div>
                                <div><span class="font-weight-bold m-0">&nbsp;</span></div>
                            @endif
                        </div>
                    </div>
                    @if ($invoice_data['is_manual'] && $invoice_data['note'])
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="note">
                                    <span class="font-weight-bold m-0">Note:</span>
                                </div>
                                <p>{{$invoice_data['note']}}</p>
                            </div>
                        </div>
                    @endif

                </div>
                <div class="col-4 mb-2 @if (!$invoice_data['is_manual']) col-xl-2 @else col-xl-4 @endif d-flex justify-content-center align-items-center col-lg-2 col-md-4 col-sm-4 float-right">
                    @if($invoice_data['is_manual'])
                        <img src="{{asset('assets/images/uploads/manual_invoices/'.$invoice_data['file'])}}" width="100%" height="auto" style="min-height: 50px; min-width: 50px;" alt="">
                    @else
                        <img src="{{asset('assets/images/uploads/qr/'.$invoice_data['qr_code'])}}" width="100%" style="min-height: 50px; min-width: 50px;" alt="">
                    @endif

                    {{--                        {!! QrCode::size(200)->generate(route('invoice.show',['invoice_id' => $invoice_data[0]['invoice_id']])) !!}--}}
                </div>
                <div class="col-12 mt-3">
                    <a href="{{route('invoice.streamPdf',['invoice_id' => $invoice_data['id']])}}" target="_blank" class="btn btn-danger">View as PDF</a>
                </div>
            </div>

            @if (!$invoice_data['is_manual'])
                <div class="mt-5 table-responsive">
                    <table class="table table-striped" style="">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th class="right">Unit Cost</th>
                            <th class="center">Qty</th>
                            <th class="right">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; ?>
                        @foreach($invoice_data['invoice_product'] as $product)
                            <tr>
                                <td class="center">{{$i}}</td>
                                <td class="left" >{{$product['product']['name']}}</td>
                                <td class="left">{{$product['product']['price']}} JOD</td>
                                <td class="left">X{{$product['quantity']}}</td>
                                <td class="left">{{$product['product']['price'] * $product['quantity']}} JOD</td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12 col-sm-12 ml-auto">
                    <table class="table table-clear">
                        <tbody>
                        <tr>
                            <td class="left">
                                <strong>Total: {{$invoice_data['total_price']}} JOD</strong>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div>
</div>
<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
-->
</body>
</html>
