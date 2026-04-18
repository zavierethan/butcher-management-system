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
                        <!--begin::Select-->
                        <input type="date"
                            class="form-control form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto"
                            id="date" value="<?php echo date("Y-m-d"); ?>" />
                        <!--end::Select-->
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
                                    <span class="text-gray-600 fs-8" id="total-transactions">0 Transaksi</span>
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
                                <h3 class="card-title fw-bold">RINGKASAN PEMASUKAN</h3>
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
                                <h3 class="card-title fw-bold">KOMPOSISI PEMASUKAN</h3>
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
                                                    <span class="fs-8 fw-bold text-end" id="legend-tunai">Rp 0 (0%)</span>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <span class="badge"
                                                        style="background-color: #34D399; width: 14px; height: 14px; border-radius: 2px;"></span>
                                                    <span class="fs-8 text-gray-700 me-auto">Transfer</span>
                                                    <span class="fs-8 fw-bold text-end" id="legend-transfer">Rp 0 (0%)</span>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <span class="badge"
                                                        style="background-color: #6EE7B7; width: 14px; height: 14px; border-radius: 2px;"></span>
                                                    <span class="fs-8 text-gray-700 me-auto">Piutang</span>
                                                    <span class="fs-8 fw-bold text-end" id="legend-piutang">Rp 0 (0%)</span>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <span class="badge badge-warning me-2"
                                                        style="width: 14px; height: 14px; border-radius: 2px;"></span>
                                                    <span class="fs-8 text-gray-700 me-auto">Pengeluaran Tunai</span>
                                                    <span class="fs-8 fw-bold text-end" id="legend-pengeluaran-tunai">Rp 0 (0%)</span>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <span class="badge"
                                                        style="background-color: #FCA5A5; width: 14px; height: 14px; border-radius: 2px;"></span>
                                                    <span class="fs-8 text-gray-700 me-auto">Pembayaran Piutang</span>
                                                    <span class="fs-8 fw-bold text-end" id="legend-pembayaran-piutang">Rp 0 (0%)</span>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge badge-danger me-2"
                                                        style="width: 14px; height: 14px; border-radius: 2px;"></span>
                                                    <span class="fs-8 text-gray-700 me-auto">Pembayaran Piutang
                                                        Transfer</span>
                                                    <span class="fs-8 fw-bold text-end" id="legend-pembayaran-transfer">Rp 0 (0%)</span>
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

                <!-- Pie Chart Row -->
                <div class="row gy-5 g-xl-10 mb-5">

                </div>
                <!-- End Pie Chart Row -->
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

$(document).ready(function() {
    // Get initial date from input
    var initialDate = $('#date').val();
    fetchSummary(initialDate);
    fetchIncomeComposition(initialDate);
    // Initialize charts with dummy data
    initializePieChart();

    $('#date').on('change', function() {
        var param = $(this).val();

        fetchSummary(param);
        fetchIncomeComposition(param);
    });
});

$("#btn-form-export").on("click", function() {
    const start_date = $("#start-date").val();
    const end_date = $("#end-date").val();
    const branch_id = `{{Auth::user()->branch_id}}`;

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
            labels: ['Tunai', 'Transfer', 'Piutang', 'Pengeluaran Tunai', 'Pembayaran Piutang',
                'Pembayaran Piutang Transfer'
            ],
            datasets: [{
                data: [57.4, 24.9, 17.7, 8.2, 0.0, 77.7],
                backgroundColor: [
                    '#10B981', // Tunai - Green
                    '#34D399', // Transfer - Light Green
                    '#6EE7B7', // Piutang - Lighter Green
                    '#FBBF24', // Pengeluaran Tunai - Yellow
                    '#FCA5A5', // Pembayaran Piutang - Light Red
                    '#EF4444' // Pembayaran Piutang Transfer - Red
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
    const total = parseFloat(data.total_cash) +
                  parseFloat(data.total_transfer) +
                  parseFloat(data.total_receivable) +
                  parseFloat(data.total_cash_expanse) +
                  parseFloat(data.total_transfer_expanse) +
                  parseFloat(data.total_cash_payment_of_receivable) +
                  parseFloat(data.total_transfer_payment_of_receivable);

    // Avoid division by zero
    if (total === 0) {
        pieChart.data.datasets[0].data = [0, 0, 0, 0, 0, 0];
        pieChart.update();
        updateLegend({total_cash: 0, total_transfer: 0, total_receivable: 0, total_cash_expanse: 0, total_transfer_expanse: 0, total_cash_payment_of_receivable: 0, total_transfer_payment_of_receivable: 0}, 0);
        updateIncomeTable({total_cash: 0, total_transfer: 0, total_receivable: 0, total_cash_expanse: 0, total_transfer_expanse: 0, total_cash_payment_of_receivable: 0, total_transfer_payment_of_receivable: 0});
        return;
    }

    // Calculate percentages
    const percentages = [
        (parseFloat(data.total_cash) / total) * 100,           // Tunai
        (parseFloat(data.total_transfer) / total) * 100,       // Transfer
        (parseFloat(data.total_receivable) / total) * 100,     // Piutang
        (parseFloat(data.total_cash_expanse) / total) * 100,   // Pengeluaran Tunai
        (parseFloat(data.total_cash_payment_of_receivable) / total) * 100,    // Pembayaran Piutang
        (parseFloat(data.total_transfer_payment_of_receivable) / total) * 100 // Pembayaran Piutang Transfer
    ];

    pieChart.data.datasets[0].data = percentages;
    pieChart.update();

    // Update legend and table with actual values
    updateLegend(data, total);
    updateIncomeTable(data);
}

function updateLegend(data, total) {
    const legendItems = [
        { id: 'legend-tunai', value: parseFloat(data.total_cash), percentage: total > 0 ? (parseFloat(data.total_cash) / total) * 100 : 0 },
        { id: 'legend-transfer', value: parseFloat(data.total_transfer), percentage: total > 0 ? (parseFloat(data.total_transfer) / total) * 100 : 0 },
        { id: 'legend-piutang', value: parseFloat(data.total_receivable), percentage: total > 0 ? (parseFloat(data.total_receivable) / total) * 100 : 0 },
        { id: 'legend-pengeluaran-tunai', value: parseFloat(data.total_cash_expanse), percentage: total > 0 ? (parseFloat(data.total_cash_expanse) / total) * 100 : 0 },
        { id: 'legend-pembayaran-piutang', value: parseFloat(data.total_cash_payment_of_receivable), percentage: total > 0 ? (parseFloat(data.total_cash_payment_of_receivable) / total) * 100 : 0 },
        { id: 'legend-pembayaran-transfer', value: parseFloat(data.total_transfer_payment_of_receivable), percentage: total > 0 ? (parseFloat(data.total_transfer_payment_of_receivable) / total) * 100 : 0 }
    ];

    legendItems.forEach(item => {
        const element = $(`#${item.id}`);
        const formatted = formatRupiah(item.value) + ` (${item.percentage.toFixed(1)}%)`;
        element.text(formatted);
    });
}

function updateIncomeTable(data) {
    const tableItems = [
        { id: 'table-tunai', value: parseFloat(data.total_cash) },
        { id: 'table-transfer', value: parseFloat(data.total_transfer) },
        { id: 'table-piutang', value: parseFloat(data.total_receivable) },
        { id: 'table-pengeluaran-tunai', value: parseFloat(data.total_cash_expanse) },
        { id: 'table-pengeluaran-transfer', value: parseFloat(data.total_transfer_expanse) },
        { id: 'table-pembayaran-piutang', value: parseFloat(data.total_cash_payment_of_receivable) },
        { id: 'table-pembayaran-transfer', value: parseFloat(data.total_transfer_payment_of_receivable) }
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
        data: {date: params},
        beforeSend: function () {
            console.log('Fetching summary...');
        },

        success: function (response) {
            console.log('Response:', response);

            // Example mapping (adjust based on your JSON structure)
            $('#total-revenue').text(formatRupiah(response.total_revenue));
            $('#total-transactions').text(response.total_transactions + ' Transaksi');
            $("#total-discount").text(formatRupiah(response.total_discount));
            $('#total-cash').text(formatRupiah(response.total_cash));
            $('#total-kasir').text(formatRupiah(response.total_cash_in_casheer));
        },
        error: function (xhr) {
            console.error('Error:', xhr.responseText);
            alert('Gagal mengambil data summary');
        },
        complete: function () {
            console.log('Done');
            // hide loader
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
        data: {date: params},
        beforeSend: function () {
            console.log('Fetching income composition...');
        },
        success: function (response) {
            console.log('Income Composition Response:', response);
            // Update pie chart with new data
            updatePieChart(response);
        },
        error: function (xhr) {
            console.error('Error:', xhr.responseText);
            alert('Gagal mengambil data komposisi pemasukan');
        },
        complete: function () {
            console.log('Done fetching income composition');
            // hide loader
        }
    });
}

</script>
@endsection
