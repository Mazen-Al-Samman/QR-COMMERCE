<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>A simple, clean, and responsive HTML invoice template</title>

    <style>
        .title {
            margin: 10px 5px;
        }
        table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            padding: 10px;
        }

        table td {
            padding: 5px;
            vertical-align: top;
        }

        table tr td:nth-child(2) {
            text-align: right;
        }

        table tr.top table td {
            /*padding-bottom: 20px;*/
        }

        table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        table tr.information table td {
            padding-bottom: 25px;
            width: 1000%;
        }

        table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        table tr.details td {
            padding-bottom: 20px;
        }

        table tr.item td {
            border-bottom: 1px solid #eee;
        }

        table tr.item.last td {
            border-bottom: none;
        }

        table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
        .title {
            font-size: 20px;
            text-decoration: underline;
        }
        @page {
            footer: page-footer;
            margin-footer: 15mm;
        }
        table tr.top table td.img {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .image {
            width: 100%;
            max-width: 70px;
        }
        .title-total {
            font-weight: bold;
        }
        .total {
            color: #1c7430;
            font-weight: bold;
        }
        .go-play {
            width: 100%;
            max-width: 135px !important;
        }
        .app-store {
            width: 100%;
            max-width: 120px !important;
        }
    </style>
</head>

<body>
{{--<div class="invoice-box" style="height:10.6cm; vertical-align: text-top;">--}}
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="6">
                <table>
                    <tr>
                        <td colspan="2">
                            <span class="title" style=" color: #0a58ca">Invoice #: {{$invoice_data['id']}}</span><br />
                            <span style="text-decoration: underline; color: #0a58ca"><span class="title">Created: </span>{{date($invoice_data['created_at'])}}</span><br /><br />
                            @if($invoice_data['is_manual'])
                                <span class="title-total">Total: </span><span class="total">  {{$invoice_data['total_price']}} JOD </span><br/>
                            @endif
                        </td>
                        <td colspan="2" class="img">
                            <img class="image" src="http://mybill-sa.com/assets/frontend/assets/img/my_bill_logo.jpg" alt="My Bill" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="6">
                <table>
                    @if($invoice_data['is_manual'])
                        <tr>
                            <td colspan="6">
                                <span class="title">Title:</span> <br />{{$invoice_data['title']}} <br />
                            </td>
                        </tr>

                    @endif
                    <tr>
                        @if(!$invoice_data['is_manual'])
                            <td colspan="3">
                                <span class="title">Vendor:</span> <br /> {{$invoice_data['vendor']['name']}} <br />
                            </td>
                            <td colspan="3">
                                <span class="title">Phone:</span> <br /> {{$invoice_data['vendor']['phone']}}
                            </td>
                        @endif
                    </tr>
                    <tr>
                        @if($user = $invoice_data['user'])
                            <td colspan="3">
                                <span class="title">Name:</span> <br /> {{$user['first_name'].' '.$user['last_name']}}<br />
                            </td>
                            <td colspan="3">
                                <span class="title">Phone:</span> <br /> {{$user['phone']}}<br />
                            </td>
                        @endif
                    </tr>
                </table>
            </td>
        </tr>

        @if(!$invoice_data['is_manual'])
            <tr class="heading">
                <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Item&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Unit Cost&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;Qty&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;Total&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
            <?php $i=1; ?>
            @foreach($invoice_data['invoice_product'] as $product)
                <tr class="item">
                    <td colspan="2">{{$product['product']['name']}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;{{$product['product']['price']}} JOD&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;X{{$product['quantity']}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$product['product']['price'] * $product['quantity']}} JOD&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <?php $i++; ?>
            @endforeach
                <tr class="total">
                    <td></td>

                    <td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;{{$invoice_data['total_price']}} JOD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
            @endif

            @if($invoice_data['is_manual'])
                <table>
                    <tr>
                        <td colspan="6">
                            <span class="title">Note: </span><br /><br />
                            {{$invoice_data['note']}} <br />
                        </td>
                    </tr>
                </table>
            @endif

            <table>
                <tr style="text-align: center">
                    <td colspan="3" style="text-decoration: underline; font-size: 15px; color: darkred"></td>
                </tr>
            </table>
    </table>
{{--</div>--}}
<htmlpagefooter name="page-footer">

        <table>
            <tr>
                <td colspan="4" style="font-width: bold; font-size: 20px; color: gray;">
                    Produced by mybill
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="2">
                    <img class="app-store" src="http://mybill-sa.com/assets/frontend/assets/img/appStore.jpg" alt="My Bill" />
                </td>
                <td colspan="2">
                    <img class="go-play" src="http://mybill-sa.com/assets/frontend/assets/img/googlePlay.jpg" alt="My Bill" />
                </td>
            </tr>
        </table>

</htmlpagefooter>
</body>
</html>
