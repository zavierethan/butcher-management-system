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

        .items th, .items td {
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
                    @php $no = 1 @endphp
                    @foreach($items as $item)
                    <tr>
                        <td>{{$no++}}.</td>
                        <td>{{$item->name}}</td>
                        <td style="text-align: center;">{{$item->quantity}}</td>
                        <td style="text-align: right;">{{$item->base_price}}</td>
                        <td style="text-align: right;">{{$item->sell_price}}</td>
                    </tr>
                    @if($item->discount > 0)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">- {{$item->discount}}</td>
                        <td style="text-align: right;"></td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="border-top: 1px dotted #000;">
                        <td style="font-weight: bold;" colspan="2">Subtotal</td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">@php echo number_format($info->total_amount, 0, '.', ',') @endphp</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;" colspan="2">Ongkos Kirim</td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">@php echo number_format($info->shipping_cost, 0, '.', ',') @endphp</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Total</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">
                            @php
                                $grand_total = ($info->total_amount - $info->discount) + $info->shipping_cost;
                                echo number_format($grand_total, 0, '.', ',');
                            @endphp
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
