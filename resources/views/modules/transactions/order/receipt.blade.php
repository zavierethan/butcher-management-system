<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Receipt</title>
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
            width: 80mm; /* Width for thermal printer */
            padding: 25px;
            background: #fff;
            border: 2px solid #b4aeae;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 50px;
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
            margin: 10px 0;
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
        <div class="header">
            <h1>Priyadis Butchers</h1>
        </div>

        <div class="line"></div>

        <div class="items">
            <table>
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">No Transaksi</td>
                        <td>: {{$info->code}}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Waktu Pesanan</td>
                        <td>: {{$info->transaction_date}}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Cabang</td>
                        <td>: {{$info->branhces}}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Kasir</td>
                        <td>: {{$info->created_by}}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Nama Konsumen</td>
                        <td>: {{$info->customer_name}}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Pembayaran</td>
                        <td>: {{$info->payment_method}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="line"></div>

        <div class="items">
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty (Kg)</th>
                        <th style="text-align: right;">Harga</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td style="text-align: right;">{{$item->base_price}}</td>
                        <td style="text-align: right;">{{$item->sell_price}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="border-top: 1px dotted #000;">
                        <td style="font-weight: bold;">Subtotal</td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">@php echo number_format($info->total_amount, 0, '.', ',') @endphp</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Discount</td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">0.00</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Total</td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">@php echo number_format($info->total_amount, 0, '.', ',') @endphp</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="line"></div>

        <div class="footer">
            <p>Thank you for shopping!</p>
            <p>Visit Again!</p>
        </div>
    </div>
</body>
</html>
