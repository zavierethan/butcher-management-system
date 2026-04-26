@extends('layouts.main')

@section('main-content')
<?php date_default_timezone_set("Asia/Jakarta"); ?>
<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Daily Reports</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Ritels</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Daily Reports</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Secondary button-->
                    <div class="d-flex align-items-center fw-bold">
                        <!--begin::Label-->
                        <div class="text-gray-500 fs-7 me-2">Tanggal</div>
                        <!--end::Label-->
                        <input type="date"
                            class="form-control form-control-solid text-gray-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto"
                            id="date" value="{{ date('Y-m-d') }}" {{ Auth::user()->group_id != 1 ? 'readonly' : '' }}>
                        @if(Auth::user()->group_id == 1)
                        <div class="text-gray-500 fs-7 me-2">Store</div>
                        <select
                            class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto"
                            data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px"
                            data-placeholder="Select an option" id="branch">
                            <option value=" " selected="selected">Show All</option>
                            @foreach($branches as $branch)
                            <option value="{{$branch->id}}">
                                {{$branch->name}}
                            </option>
                            @endforeach
                        </select>
                        @endif
                    </div>
                    <a href="#" class="btn btn-sm fw-bold btn-secondary" id="btn-form-export">Export ke Excel</a>
                    <!--end::Secondary button-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Loader Backdrop-->
            <div id="loader-backdrop" style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                display: none;
                z-index: 9999;
                justify-content: center;
                align-items: center;
            ">
                <div style="
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    gap: 15px;
                ">
                    <div style="
                        border: 4px solid rgba(255, 255, 255, 0.3);
                        border-top: 4px solid #ffffff;
                        border-radius: 50%;
                        width: 50px;
                        height: 50px;
                        animation: spin 1s linear infinite;
                    "></div>
                    <span style="color: #ffffff; font-size: 16px; font-weight: 500;">Loading...</span>
                </div>
            </div>
            <!--end::Loader Backdrop-->
            <style>
            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
            </style>
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container">
                <!-- Stat Cards Row -->
                <div class="row gy-5 g-xl-10 mb-5">
                    <!-- Total Omzet Card -->
                    <div class="col-sm-6 col-md-3">
                        <div class="card bg-light-success">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="bg-success rounded-1 p-3"
                                        style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="ki-duotone ki-wallet fs-2 text-white">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-gray-700 fs-7 fw-semibold mb-2">TOTAL OMZET</span>
                                    <span class="fw-bold fs-2 text-gray-900" id="total-revenue">Rp.0</span>
                                    <span class="text-gray-600 fs-8" id="total-transactions"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Uang Tunai Card -->
                    <div class="col-sm-6 col-md-3">
                        <div class="card bg-light-success">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="bg-success rounded-1 p-3"
                                        style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="ki-duotone ki-money fs-2 text-white">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-gray-700 fs-7 fw-semibold mb-2">TOTAL UANG TUNAI</span>
                                    <span class="fw-bold fs-2 text-gray-900" id="total-cash">Rp.0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Uang di Kasir Card -->
                    <div class="col-sm-6 col-md-3">
                        <div class="card bg-light-warning">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="bg-warning rounded-1 p-3"
                                        style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="ki-duotone ki-home-2 fs-2 text-white">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-gray-700 fs-7 fw-semibold mb-2">UANG DI KASIR</span>
                                    <span class="fw-bold fs-2 text-gray-900" id="total-kasir">Rp.0</span>
                                    <span class="text-gray-600 fs-8" id="total-selisih"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Diskon Card -->
                    <div class="col-sm-6 col-md-3">
                        <div class="card bg-light-danger">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="bg-danger rounded-1 p-3"
                                        style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="ki-duotone ki-percent fs-2 text-white">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-gray-700 fs-7 fw-semibold mb-2">TOTAL DISKON</span>
                                    <span class="fw-bold fs-2 text-gray-900" id="total-discount">Rp.0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Stat Cards Row -->

                <!-- Main Content Row -->
                <div class="row gy-5 g-xl-10 mb-5">
                    <!-- Left Column: Table -->
                    <div class="col-lg-6">
                        <!-- Revenue Summary Table -->
                        <div class="card card-flush">
                            <div class="card-header pt-5">
                                <h3 class="card-title fw-bold">Ringkasan Transaksi</h3>
                            </div>
                            <div class="card-body pt-3 overflow-x-auto">
                                <table class="table table-striped fs-7 align-middle">
                                    <thead>
                                        <tr class="text-gray-500 fw-bold fs-7 text-uppercase">
                                            <th>NO</th>
                                            <th>JENIS PEMASUKAN</th>
                                            <th class="text-end">NOMINAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>TUNAI</td>
                                            <td class="text-end fw-bold" id="table-tunai">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>TRANSFER</td>
                                            <td class="text-end fw-bold" id="table-transfer">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>PIUTANG</td>
                                            <td class="text-end fw-bold" id="table-piutang">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>PENGELUARAN TUNAI</td>
                                            <td class="text-end fw-bold" id="table-pengeluaran-tunai">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>PENGELUARAN TRANSFER</td>
                                            <td class="text-end fw-bold" id="table-pengeluaran-transfer">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>PEMBAYARAN PIUTANG TUNAI</td>
                                            <td class="text-end fw-bold" id="table-pembayaran-piutang">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>PEMBAYARAN PIUTANG TRANSFER</td>
                                            <td class="text-end fw-bold" id="table-pembayaran-transfer">Rp 0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Bar/Line Chart -->
                    <div class="col-lg-6">
                        <div class="card card-flush">
                            <div class="card-header pt-5">
                                <h3 class="card-title fw-bold">Komposisi Transaksi</h3>
                            </div>
                            <div class="card-body pt-5 pb-5">
                                <div class="row align-items-center">
                                    <!-- Pie Chart -->
                                    <div class="col-md-6 d-flex justify-content-center">
                                        <div style="width: 100%; max-width: 320px;">
                                            <canvas id="pieChart" style="max-width: 100%;"></canvas>
                                        </div>
                                    </div>
                                    <!-- Legend -->
                                    <div class="col-md-6">
                                        <div class="ps-4">
                                            <div class="mb-4">
                                                <div class="d-flex align-items-center mb-3">
                                                    <span class="badge badge-success me-2"
                                                        style="width: 14px; height: 14px; border-radius: 2px;"></span>
                                                    <span class="fs-8 text-gray-700 me-auto">Tunai</span>
                                                    <span class="fs-8 fw-bold text-end" id="legend-tunai">Rp 0
                                                        (0%)</span>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <span class="badge"
                                                        style="background-color: #34D399; width: 14px; height: 14px; border-radius: 2px;"></span>
                                                    <span class="fs-8 text-gray-700 me-auto">Transfer</span>
                                                    <span class="fs-8 fw-bold text-end" id="legend-transfer">Rp 0
                                                        (0%)</span>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <span class="badge"
                                                        style="background-color: #6EE7B7; width: 14px; height: 14px; border-radius: 2px;"></span>
                                                    <span class="fs-8 text-gray-700 me-auto">Piutang</span>
                                                    <span class="fs-8 fw-bold text-end" id="legend-piutang">Rp 0
                                                        (0%)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Main Content Row -->

                <!-- Main Content Row -->
                <div class="row gy-5 g-xl-10 mb-5">
                    <!-- Left Column: Table -->
                    <div class="col-lg-6">
                        <!-- Revenue Summary Table -->
                        <div class="card card-flush">
                            <div class="card-header pt-5">
                                <h3 class="card-title fw-bold">Detail Pengeluaran</h3>
                            </div>
                            <div class="card-body pt-3 overflow-x-auto">
                                <table class="table table-hover align-middle table-row-dashed fs-6 gy-5" id="kt_expenses_table">
                                    <thead>
                                        <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Deskripsi</th>
                                            <th class="min-w-125px">Qty</th>
                                            <th class="min-w-125px">Harga / PCS</th>
                                            <th class="min-w-125px">Tunai / Tansfer</th>
                                            <th class="min-w-125px">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Bar/Line Chart -->
                    <div class="col-lg-6">
                        <div class="card card-flush">
                            <div class="card-header pt-5">
                                <h3 class="card-title fw-bold">Detail Pembayaran Piutang</h3>
                            </div>
                            <div class="card-body pt-3 overflow-x-auto">
                                <table class="table table-hover align-middle table-row-dashed fs-6 gy-5" id="kt_receive_table">
                                    <thead>
                                        <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Customer</th>
                                            <th class="min-w-125px">Nomor Transaksi</th>
                                            <th class="min-w-125px">Tanggal Transaksi</th>
                                            <th class="min-w-125px">Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Main Content Row -->

                <div class="row gy-5 g-xl-10 mb-5">
                    <div class="card card-flush">
                        <div class="card-header border-0 pt-6">
                            <div class="card-title">
                                <h3 class="card-title fw-bold">SVC PFMN</h3>
                            </div>
                            <div class="card-toolbar">
                                <div class="d-flex flex-stack flex-wrap gap-4">
                                    <div class="position-relative my-1">
                                        <i
                                            class="ki-duotone ki-magnifier fs-2 position-absolute top-50 translate-middle-y ms-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="text" data-kt-customer-table-filter="search"
                                            class="form-control form-control-solid w-250px ps-15"
                                            placeholder="Nama Produk" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0 overflow-x-auto">
                            <table class="table table-hover align-middle table-row-dashed fs-6 gy-5" id="kt_svc_table">
                                <thead>
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Kode Produk</th>
                                        <th class="min-w-125px">Nama Produk</th>
                                        <th class="min-w-125px">Tanggal Opname</th>
                                        <th class="min-w-125px">Stock Awal</th>
                                        <th class="min-w-125px">Stock Masuk</th>
                                        <th class="min-w-125px">Stock Keluar</th>
                                        <th class="min-w-125px">Stock Akhir</th>
                                        <th class="min-w-125px">Hasil Opname</th>
                                        <th class="min-w-125px">Selisih</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
<!--end::Content wrapper-->
</div>
<!--end:::Main-->
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
<script>
let pieChart = null;
let mixedChart = null;

// Loader functions
function showLoader() {
    $('#loader-backdrop').css('display', 'flex');
}

function hideLoader() {
    $('#loader-backdrop').css('display', 'none');
}

$(document).ready(function() {
    // Get initial date from input
    var initialDate = $('#date').val();
    fetchSummary(initialDate);
    fetchIncomeComposition(initialDate);
    // Initialize charts with dummy data
    initializePieChart();

    const table = $("#kt_products_table").DataTable({
        processing: true,
        serverSide: true,
        paging: true, // Enable pagination
        pageLength: 10, // Number of rows per page
        ajax: {
            url: `{{ route('stocks.get-lists') }}`, // Replace with your route
            type: 'GET',
            data: function(d) {
                // Send filter values to the server along with the pagination params
                d.searchTerm = $('[data-kt-customer-table-filter="search"]').val();
                d.startDate = $('#date').val();
                d.endDate = $('#date').val();
            },
            dataSrc: function(json) {
                return json.data; // Map the 'data' field
            }
        },
        columns: [{
                data: 'code',
                name: 'code'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'tanggal_stock_awal',
                name: 'tanggal_stock_awal',
                className: 'text-center'
            },
            {
                data: 'stock_awal',
                name: 'stock_awal',
                className: 'text-center'
            },
            {
                data: 'stok_masuk',
                name: 'stok_masuk',
                className: 'text-center'
            },
            {
                data: 'stok_keluar',
                name: 'stok_keluar',
                className: 'text-center'
            },
            {
                data: 'stock_akhir',
                name: 'stock_akhir',
                className: 'text-center'
            },
            {
                data: 'hasil_stock_opname',
                name: 'hasil_stock_opname',
                className: 'text-center'
            },
            {
                data: 'selisih',
                name: 'selisih',
                className: 'text-center'
            }
        ]
    });

    const expenesTable = $("#kt_expenses_table").DataTable({
        processing: true,
        serverSide: true,
        paging: true, // Enable pagination
        pageLength: 5, // Number of rows per page
        ajax: {
            url: `{{route('retails.daily-report.get-daily-expenses')}}`, // Replace with your route
            type: 'GET',
            data: function (d) {
                // Add filter data to the request
                d.date = $('#date').val();
            },
            dataSrc: function(json) {
                return json.data; // Map the 'data' field
            }
        },
        columns: [
            {
                data: 'description',
                name: 'description',
            },
            {
                data: 'quantity',
                name: 'quantity',
                className: 'text-end'
            },
            {
                data: 'price',
                name: 'price',
                className: 'text-end'
            },
            {
                data: 'payment_method',
                name: 'payment_method',
                className: 'text-center',
                render: function(data, type, row) {
                    var payment_method = "";

                    if (row.payment_method == 1) {
                        payment_method = `<span class="badge bg-success text-dark">TUNAI</span>`
                    }

                    if (row.payment_method == 2) {
                        payment_method = `<span class="badge bg-warning text-dark">TRANSFER</span>`
                    }

                    return payment_method;
                }
            },
            {
                data: 'amount',
                name: 'amount',
                className: 'text-end'
            }
        ]
    });

    $('#date').on('change', function() {
        var param = $(this).val();

        fetchSummary(param);
        fetchIncomeComposition(param);

        table.draw();
        expenesTable.draw();
    });
});

$("#btn-form-export").on("click", function() {
    const start_date = $("#date").val();
    const end_date = $("#date").val();
    const branch_id = `{{Auth::user()->branch_id}}`;

    showLoader();

    $.ajax({
        url: `{{route('retails.daily-report.export')}}`,
        type: 'GET',
        data: {
            start_date: start_date,
            end_date: end_date,
            branch_id: branch_id,
        },
        xhrFields: {
            responseType: 'blob',
        },
        success: function(data, status, xhr) {
            let disposition = xhr.getResponseHeader('Content-Disposition');
            let filename = 'daily-report.xlsx';

            if (disposition && disposition.indexOf('attachment') !== -1) {
                let matches = /filename="([^"]+)"/.exec(disposition);
                if (matches && matches[1]) filename = matches[1];
            }

            const blob = new Blob([data], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });

            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            Swal.fire({
                title: 'Success!',
                text: 'Daily Report exported successfully.',
                icon: 'success',
                confirmButtonText: 'OK',
            });
        },
        error: function(xhr, status, error) {
            Swal.fire('Error!', 'Failed to export the transaction report.', 'error');
        },
        complete: function() {
            hideLoader();
        }
    });
});

// Plugin untuk menampilkan teks di tengah doughnut chart
const centerTextPlugin = {
    id: 'centerText',
    beforeDatasetsDraw(chart) {
        if (chart.config._config.type !== 'doughnut') return;

        const {
            ctx,
            chartArea: {
                left,
                top,
                width,
                height
            }
        } = chart;
        ctx.save();

        // Get the total revenue from the element
        const totalRevenueText = $('#total-revenue').text();

        // Draw text
        ctx.font = 'bold 14px Arial';
        ctx.fillStyle = '#10B981';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';

        const centerX = left + width / 2;
        const centerY = top + height / 2;

        ctx.fillText('TOTAL OMZET', centerX, centerY - 18);

        ctx.font = 'bold 22px Arial';
        ctx.fillStyle = '#1E3A8A';
        ctx.fillText(totalRevenueText, centerX, centerY + 15);

        ctx.restore();
    }
};

function initializePieChart() {
    const ctx = document.getElementById('pieChart');
    if (!ctx) return;

    Chart.register(centerTextPlugin);

    pieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Tunai', 'Transfer', 'Piutang'],
            datasets: [{
                data: [57.4, 24.9, 17.7],
                backgroundColor: [
                    '#104bb9', // Tunai - Green
                    '#a3d334', // Transfer - Light Green
                    '#6EE7B7', // Piutang - Lighter Green
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + '%';
                        }
                    }
                }
            }
        },
        plugins: [centerTextPlugin]
    });
}

function updatePieChart(data) {
    if (!pieChart || !data) return;

    // Calculate total
    const total =
        parseFloat(data.total_cash) +
        parseFloat(data.total_transfer) +
        parseFloat(data.total_receivable) +
        parseFloat(data.total_cash_expanse) +
        parseFloat(data.total_transfer_expanse);

    // Avoid division by zero
    if (total === 0) {
        pieChart.data.datasets[0].data = [0, 0, 0];
        pieChart.update();
        updateLegend({
            total_cash: 0,
            total_transfer: 0,
            total_receivable: 0
        }, 0);
        updateIncomeTable({
            total_cash: 0,
            total_transfer: 0,
            total_receivable: 0,
            total_cash_expanse: 0,
            total_transfer_expanse: 0
        });
        return;
    }

    // Calculate percentages
    const percentages = [
        ((parseFloat(data.total_cash) / total) * 100).toFixed(1), // Tunai
        ((parseFloat(data.total_transfer) / total) * 100).toFixed(1), // Transfer
        ((parseFloat(data.total_receivable) / total) * 100).toFixed(1), // Piutang
    ];

    pieChart.data.datasets[0].data = percentages;
    pieChart.update();

    // Update legend and table with actual values
    updateLegend(data, total);
    updateIncomeTable(data);
}

function updateLegend(data, total) {
    const legendItems = [{
            id: 'legend-tunai',
            value: parseFloat(data.total_cash),
            percentage: total > 0 ? (parseFloat(data.total_cash) / total) * 100 : 0
        },
        {
            id: 'legend-transfer',
            value: parseFloat(data.total_transfer),
            percentage: total > 0 ? (parseFloat(data.total_transfer) / total) * 100 : 0
        },
        {
            id: 'legend-piutang',
            value: parseFloat(data.total_receivable),
            percentage: total > 0 ? (parseFloat(data.total_receivable) / total) * 100 : 0
        }
    ];

    legendItems.forEach(item => {
        const element = $(`#${item.id}`);
        const formatted = formatRupiah(item.value) + ` (${item.percentage.toFixed(1)}%)`;
        element.text(formatted);
    });
}

function updateIncomeTable(data) {
    const tableItems = [{
            id: 'table-tunai',
            value: parseFloat(data.total_cash)
        },
        {
            id: 'table-transfer',
            value: parseFloat(data.total_transfer)
        },
        {
            id: 'table-piutang',
            value: parseFloat(data.total_receivable)
        },
        {
            id: 'table-pengeluaran-tunai',
            value: parseFloat(data.total_cash_expanse)
        },
        {
            id: 'table-pengeluaran-transfer',
            value: parseFloat(data.total_transfer_expanse)
        }
    ];

    tableItems.forEach(item => {
        const element = $(`#${item.id}`);
        element.text(formatRupiah(item.value));
    });
}

function formatRupiah(num) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(num);
}


function fetchSummary(params) {
    $.ajax({
        url: `/retails/daily-report/get-data-summary`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            date: params
        },
        beforeSend: function() {
            console.log('Fetching summary...');
            showLoader();
        },

        success: function(response) {
            console.log('Response:', response);

            // Example mapping (adjust based on your JSON structure)
            $('#total-revenue').text(formatRupiah(response.total_revenue));
            $('#total-transactions').text('Total Transaksi: ' + response.total_transactions);
            $("#total-discount").text(formatRupiah(response.total_discount));
            $('#total-cash').text(formatRupiah(response.total_cash));
            $('#total-kasir').text(formatRupiah(response.total_cash_in_casheer));
            $('#total-selisih').text('Selisih antara Uang di kasir dan total uang tunai adalah : ' + formatRupiah(response.total_cash - response.total_cash_expanse + response.total_cash_receive));
        },
        error: function(xhr) {
            console.error('Error:', xhr.responseText);
            alert('Gagal mengambil data summary');
        },
        complete: function() {
            console.log('Done');
            hideLoader();
        }
    });
}

function fetchIncomeComposition(params) {
    $.ajax({
        url: `/retails/daily-report/get-income-composition`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            date: params
        },
        beforeSend: function() {
            console.log('Fetching income composition...');
            showLoader();
        },
        success: function(response) {
            console.log('Income Composition Response:', response);
            // Update pie chart with new data
            updatePieChart(response);
        },
        error: function(xhr) {
            console.error('Error:', xhr.responseText);
            alert('Gagal mengambil data komposisi pemasukan');
        },
        complete: function() {
            console.log('Done fetching income composition');
            hideLoader();
        }
    });
}
</script>
@endsection
