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
            justify-content: space-between; /* Aligns children to the left and right */
            align-items: center; /* Vertically aligns items */
            padding: 10px 20px;
        }

        .company-details {
            text-align: left;
        }

        .logo img {
            text-align: right;
            max-width: 150px; /* Adjust as needed */
            height: auto;
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
        <table width="100%" style="border-collapse: collapse; border: none;">
            <tr style="border: none;">
                <!-- Left-aligned content -->
                <td style="text-align: left; border: none; padding: 0;">
                    <h1><b>INVOICE</b></h1>
                </td>

                <!-- Right-aligned logo -->
                <td style="text-align: right; border: none; padding: 0;">
                    <img src="{{ $base64Image }}" alt="Company Logo" style="max-width: 150px;">
                </td>
            </tr>
        </table>

        <table width="100%" style="border-collapse: collapse; border: none;">
            <tr style="border: none;">
                <!-- Left-aligned content -->
                <td style="text-align: left; border: none; padding: 0; width: 60%; vertical-align: top;">
                    <div class="row">
                        <div><strong>KEPADA: </strong></div>
                        <div>{{$invoice->customer_name}}</div>
                        <div>{{$invoice->phone_number}}</div>
                        <div>{{$invoice->address}}</div>
                    </div>
                </td>

                <!-- Right-aligned logo -->
                <td style="text-align: right; border: none; padding: 0; vertical-align: top;">
                    <div><strong>TANGGAL: </strong></div>
                    <div>{{$invoice->invoice_date}}</div>
                    <div><strong>NO. INVOICE : </strong></div>
                    <div>{{$invoice->invoice_no}}</div>
                </td>
            </tr>
        </table>

        <!-- Purchase Order Details -->
        <div class="content">
            <!-- Table -->
            <table>
                <thead>
                    <tr style="background-color:rgb(168, 15, 15); color: black;">
                        <th>NO.</th>
                        <th>NO. TRANSAKSI</th>
                        <th>TANGGAL</th>
                        <th>DESKIPSI BARANG</th>
                        <th>JUMLAH</th>
                        <th>HARGA</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach($invoiceItems as $items)
                    <tr>
                        <td style="text-align: center"><?php echo $no++; ?>.</td>
                        <td>{{$items->transaction_no}}</td>
                        <td>{{$items->date}}</td>
                        <td>{{$items->name}}</td>
                        <td>{{$items->quantity}}</td>
                        <td style="text-align: right">{{$items->base_price}}</td>
                        <td style="text-align: right">{{$items->sell_price}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" style="text-align: right;"><strong>TOTAL</strong></td>
                        <td style="text-align: right"><strong>{{$totalSellPrice}}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <table width="100%" style="border-collapse: collapse; border: none;">
            <tr style="border: none;">
                <!-- Left-aligned content -->
                <td style="text-align: left; border: none; padding: 0;">
                    <strong><p>INFORMASI PEMBAYARAN :</p></strong>
                    <div>No. Rekening : 1480802205</div>
                    <div>Atas Nama : Zia Hasan</div>
                    <div>Bank : BCA</div>
                </td>

                <!-- Right-aligned logo -->
                <td style="text-align: right; border: none; padding: 0;">
                </td>
            </tr>
        </table>

        <table width="100%" style="border-collapse: collapse; border: none;">
            <tr style="border: none;">
                <!-- Left-aligned content -->
                <td style="text-align: left; border: none; padding: 0;">
                    <strong><p style="margin-left: 20px; margin-bottom: 60px;">{{$invoice->customer_name}}</p></strong>
                    <strong><p>(---------------------------)</p></strong>
                </td>

                <!-- Right-aligned logo -->
                <td style="text-align: right; border: none; padding: 0;">
                    <strong><p style="margin-right: 10px; margin-bottom: 60px;">Priyadis Butchers</p></strong>
                    <strong><p>(---------------------------)</p></strong>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
