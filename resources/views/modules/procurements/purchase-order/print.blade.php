<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pryadis Butchers</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        h1, h2, h3 {
            margin: 0;
            padding-bottom: 5px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header img {
            height: 50px;
        }

        .header .company-details {
            text-align: right;
        }

        .content {
            margin-top: 20px;
        }

        .content .details {
            margin-bottom: 20px;
        }

        .details .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
        }

        .footer .signature {
            margin-top: 40px;
            display: flex;
            justify-content: space-around;
        }

        .signature div {
            width: 30%;
            text-align: center;
        }

        .signature div hr {
            margin-top: 60px;
            border: none;
            border-top: 1px solid #000;
        }
    </style>
</head>
<body>
    <div class="a4">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <img src="logo.png" alt="Company Logo">
            </div>
            <div class="company-details">
                <h2>Pryadis Butchers</h2>
                <p>Jl. Ciledug no 273 Kec. Kota kulon Kel. Garut Kota Kab. Garut 44112</p>
                <p>Phone: 082114139759</p>
            </div>
        </div>

        <!-- Purchase Order Details -->
        <div class="content">
            <h1>Purchase Order</h1>
            <div class="details">
                <div class="row">
                    <div>Order Number: <strong>{{$purchaseOrder->purchase_order_number}}</strong></div>
                    <div>Date: <strong>{{$purchaseOrder->order_date}}</strong></div>
                </div>
                <div class="row">
                    <div>Supplier: <strong>{{$purchaseOrder->supplier_name}}</strong></div>
                    <div>Due Date: <strong>14-Jan-2025</strong></div>
                </div>
            </div>

            <!-- Table -->
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Item Description</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach($detailItems as $item)
                    <tr>
                        <td><?php echo $no++; ?>.</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td style="text-align: right">{{$item->price}}</td>
                        <td style="text-align: right">@php echo number_format($item->total, 0, '.', ',') @endphp</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right;"><strong>Total Pembelian</strong></td>
                        <td style="text-align: right"><strong>{{$purchaseOrder->total_amount}}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>
