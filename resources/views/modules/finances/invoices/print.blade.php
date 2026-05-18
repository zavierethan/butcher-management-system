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
        font-size: 12px;
    }

    h1,
    h2,
    h3 {
        margin: 0;
        padding-bottom: 5px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        /* Aligns children to the left and right */
        align-items: center;
        /* Vertically aligns items */
        padding: 10px 20px;
    }

    .company-details {
        text-align: left;
    }

    .logo img {
        text-align: right;
        max-width: 150px;
        /* Adjust as needed */
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

    table th,
    table td {
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

    .page-break {
        page-break-before: always;
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

        <!-- Detail Transaksi -->
        <div class="content" style="margin-top: 30px;">
            <h2 style="margin-bottom: 15px;"><b>DETAIL TRANSAKSI</b></h2>
            <table>
                <thead>
                    <tr style="background-color:rgb(168, 15, 15); color: black;">
                        <th style="text-align: center;">NO.</th>
                        <th style="text-align: center;">NO. TRANSAKSI</th>
                        <th style="text-align: center;">TANGGAL</th>
                        <th style="text-align: right;">TOTAL TAGIHAN</th>
                        <th style="text-align: right;">SISA TAGIHAN</th>
                    </tr>
                </thead>
                <tbody>
                    @php $counting = 1; @endphp
                    @foreach ($invoiceItems as $item)
                    <tr>
                        <td style="text-align: center;">{{ $counting++ }}</td>
                        <td style="text-align: center;">{{ $item->transaction_no }}</td>
                        <td style="text-align: center;">{{ $item->date }}</td>
                        <td style="text-align: right;">{{ number_format($item->amount, 0, '.', ',') }}</td>
                        <td style="text-align: right;">{{ number_format($item->remaining_amount, 0, '.', ',') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="font-weight: bold;">
                        <td colspan="3" style="text-align: right; padding-top: 10px;"><strong>TOTAL TAGIHAN</strong></td>
                        <td style="text-align: right; padding-top: 10px;"><strong>{{ number_format($invoice->total_billed, 0, '.', ',') }}</strong></td>
                        <td style="text-align: right; padding-top: 10px;"><strong>{{ number_format($invoice->remaining_billed, 0, '.', ',') }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Informasi Pembayaran Summary -->
        <table width="100%" style="border-collapse: collapse; border: none; margin-top: 30px;">
            <tr style="border: none;">
                <td style="text-align: left; border: none; padding: 0; width: 50%;">
                    <strong>
                        <p>STATUS : {{$invoice->status}}</p>
                    </strong>
                </td>
                <td style="text-align: right; border: none; padding: 0; width: 50%;">
                    <strong>
                        <p>SISA TAGIHAN : Rp. {{ number_format($invoice->remaining_billed, 0, '.', ',') }}</p>
                    </strong>
                </td>
            </tr>
        </table>

        <div style="margin-top: 30px;">
            <table width="100%" style="border-collapse: collapse; border: none; margin-top: 40px;">
                <tr style="border: none;">
                    <!-- Center-aligned content -->
                    <td style="text-align: center; border: none; padding: 0;">
                        <strong>
                            <p style="margin-bottom: 60px;">{{$invoice->customer_name}}</p>
                        </strong>
                        <strong>
                            <p>(---------------------------)</p>
                        </strong>
                    </td>

                    <!-- Center-aligned logo -->
                    <td style="text-align: center; border: none; padding: 0;">
                        <strong>
                            <p style="margin-bottom: 60px;">Priyadis Butchers</p>
                        </strong>
                        <strong>
                            <p>(---------------------------)</p>
                        </strong>
                    </td>
                </tr>
            </table>

            <table width="100%" style="border-collapse: collapse; border: none; margin-top: 60px;">
                <tr style="border: none;">
                    <td style="border: none; padding: 0;">
                        <strong>
                            <p>INFORMASI PEMBAYARAN :</p>
                        </strong>
                        <div>No. Rekening : 1480802205</div>
                        <div>Atas Nama : Zia Hasan</div>
                        <div>Bank : BCA</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="page-break"></div>

        <!-- History Pembayaran -->
        <div style="margin-top: 30px;">
            <h2 style="margin-bottom: 15px;"><b>HISTORY PEMBAYARAN</b></h2>
            <table>
                <thead>
                    <tr style="background-color:rgb(168, 15, 15); color: black;">
                        <th style="text-align: center;">NO.</th>
                        <th style="text-align: center;">CABANG</th>
                        <th style="text-align: center;">TANGGAL PEMBAYARAN</th>
                        <th style="text-align: center;">METODE PEMBAYARAN</th>
                        <th style="text-align: right;">TOTAL PEMBAYARAN</th>
                    </tr>
                </thead>
                <tbody>
                    @php $counting = 1; @endphp
                    @if (isset($paymentHistories) && count($paymentHistories) > 0)
                        @foreach ($paymentHistories as $history)
                        <tr>
                            <td style="text-align: center;">{{ $counting++ }}</td>
                            <td style="text-align: center;">{{ $history->branch_name }}</td>
                            <td style="text-align: center;">{{ $history->date }}</td>
                            <td style="text-align: center;">{{ $history->payment_method }}</td>
                            <td style="text-align: right;">{{ number_format($history->amount, 0, '.', ',') }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px;">Belum ada riwayat pembayaran</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
