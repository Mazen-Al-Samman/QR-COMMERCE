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
</head>
<body>
<div class="@if(!isset($pdf_option)) container @else container-fluid @endif mt-5">
    <div class="card">
        <div class="card-header">
            Invoice
            <strong>{{$invoice_data[0]['created_at']}}</strong>
            <div class="float-right"> <strong>Status:</strong> <span class="text-success">Done</span></div>

        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-sm-10">
                    <h2 class="@if(!isset($pdf_option)) mt-2 @else mt-5 @endif">MY BILL</h2>
                    <div>
                        <strong>{{$invoice_data[0]['first_name'] }}</strong>
                    </div>
                    <div>Full Name: {{$invoice_data[0]['first_name'].' '.$invoice_data[0]['last_name']}}</div>
                    <div>Phone: {{$invoice_data[0]['phone']}}</div>
                </div>
                <div class="col-sm-2 float-right">
                    @if(!isset($pdf_option))
                        {!! QrCode::size(150)->generate(route('invoice.show',['invoice_id' => $invoice_data[0]['invoice_id']])) !!}
                    @else
                        <img class="mt-5" src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(150)->generate(route('invoice.show',['invoice_id' => $invoice_data[0]['invoice_id']]))) !!}">
                    @endif
                </div>
            </div>

            <div class="mt-5">
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
                    @foreach($invoice_data as $product)
                        <tr>
                            <td class="center">{{$i}}</td>
                            <td class="left">{{$product['name']}}</td>
                            <td class="left">{{$product['price']}} JOD</td>
                            <td class="left">X{{$product['quantity']}}</td>
                            <td class="left">{{$product['price'] * $product['quantity']}} JOD</td>
                        </tr>
                        <?php $i++; ?>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-5">
                    @if(!isset($pdf_option))
                        <a href="{{route('invoice.pdf',['invoice_id' => $invoice_data[0]['invoice_id']])}}" class="btn btn-danger">Download PDF</a>
                    @endif
                </div>

                <div class="col-lg-4 col-sm-5 ml-auto">
                    <table class="table table-clear">
                        <tbody>
                        <tr>
                            <td class="left">
                                <strong>Total</strong>
                            </td>
                            <td class="right">
                                <strong>{{$invoice_data[0]['total_price']}} JOD</strong>
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
