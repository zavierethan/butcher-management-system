<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Priyadis Butchers</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        /* background-color: #f4f4f4; */
    }

    .receipt {
        background: #fff;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
        margin-top: 20px;
    }

    .header h1 {
        font-size: 23px;
        font-weight: bold;
        margin: 5px 0;
    }

    .header p {
        font-size: 12px;
        margin: 3px 0;
    }

    .line {
        border-top: 1px dashed #000;
        margin-bottom: 2px;
    }

    .info {
        font-size: 12px;
    }

    .info p {
        margin: 3px 0;
        margin-bottom: 20px;
    }

    .info strong {
        display: inline-block;
        width: 120px;
    }

    .items {
        font-size: 12px;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .items table {
        width: 100%;
        border-collapse: collapse;
    }

    .items th,
    .items td {
        text-align: left;
        padding: 10px 0;
    }

    .items th {
        font-weight: bold;
    }

    .total {
        font-size: 12px;
        font-weight: bold;
        text-align: right;
        margin-top: 10px;
    }

    .footer {
        text-align: center;
        font-size: 10px;
        margin-top: 10px;
    }

    @media print {
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: auto;
            margin: 0;
            padding: 0;
        }

        .receipt {
            width: 48mm;
            /* Set to 48mm for content width */
            max-width: 48mm;
            height: auto;
            padding: 2mm;
            margin: 0;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 0;
            padding: 0;
            height: 1px;
        }

        /* Force the exact paper size */
        @page {
            size: 58mm 210mm;
            /* Set the correct paper size */
            margin-bottom: 0;
            /* Remove any default browser margins */
        }
    }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="line"></div>
        <div class="line"></div>

        <div class="header">
            <h1>Priyadis Butchers</h1>
            <p>{{$info->address}}</p>
            <p>Telp: {{$info->phone_number}}</p>
        </div>

        <div class="line"></div>
        <div class="line"></div>

        <div class="items">
            <table>
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">No Transaksi</td>
                        <td>: {{$info->code}}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Tanggal</td>
                        <td>: {{$info->transaction_date}}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Kasir</td>
                        <td>: {{$info->created_by}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="items">
            <table>
                <thead style="border-top: 1px dashed black; border-bottom: 1px dashed black;">
                    <tr>
                        <th style="width:10%;">No.</th>
                        <th>Item</th>
                        <th style="text-align: center;">Qty (Kg)</th>
                        <th style="text-align: right;">Harga</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $counter = 1;
                        $subTotal = 0;
                        $discountTotal = 0;
                        $deliveryFee = 0;
                        $totalPay = 0;
                    @endphp

                    @foreach($items as $item)
                        @php
                        $roundedTotalPrice = round($item->quantity * $item->base_price / 100) * 100;
                        $productDiscount = $item->discount * floor($item->quantity);
                        $totalPrice = $roundedTotalPrice - $productDiscount;

                        $subTotal += $roundedTotalPrice;
                        $discountTotal += $productDiscount;
                    @endphp
                    <tr>
                        <td>{{$counter++}}.</td>
                        <td>{{$item->name}}</td>
                        <td style="text-align: center;">{{$item->quantity}}</td>
                        <td style="text-align: right;">@php echo number_format($item->base_price, 0, '.', ',') @endphp</td>
                        <td style="text-align: right;">@php echo number_format($roundedTotalPrice, 0, '.', ',') @endphp</td>
                    </tr>
                    @if($item->discount > 0)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">- @php echo number_format($item->discount, 0, '.', ',') @endphp</td>
                        <td style="text-align: right;">@php echo number_format($totalPrice, 0, '.', ',') @endphp</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
                @php
                    $deliveryFee = $info->shipping_cost;
                    $totalPay = $subTotal - $discountTotal + $deliveryFee;
                @endphp
                <tfoot>
                    <tr style="border-top: 1px dotted #000;">
                        <td style="font-weight: bold;" colspan="2">Subtotal</td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">Rp. @php echo number_format($subTotal, 0, '.', ',') @endphp
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;" colspan="2">Total Discount</td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">Rp. @php echo number_format($discountTotal, 0, '.', ',') @endphp
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;" colspan="2">Ongkos Kirim</td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">Rp. @php echo number_format($deliveryFee, 0, '.', ',')
                            @endphp</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Total</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">
                            Rp. @php echo number_format($totalPay, 0, '.', ',');@endphp
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="line"></div>
        <div class="line"></div>

        <div class="footer">
        </div>
    </div>
</body>


</html>
