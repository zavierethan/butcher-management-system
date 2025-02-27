@extends('layouts.main')

@section('main-content')
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
                        Financial Reports</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Finances</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Financial Reports</li>
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
                        <div class="text-gray-500 fs-7 me-2">Periode</div>
                        <!--end::Label-->
                        <!--begin::Select-->
                        <input type="date"
                            class="form-control form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto"
                            id="start-date" value="<?php echo date("Y-m-d"); ?>" /> -
                        <input type="date"
                            class="form-control form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto"
                            id="end-date" value="<?php echo date("Y-m-d"); ?>" />
                        <!--end::Select-->
                    </div>
                    <!--end::Secondary button-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="row gy-5 g-xl-10">
                    <!--begin::Col-->
                    <div class="col-sm-6 col-xl-2 mb-5 mb-xl-10">
                        <!--begin::Card widget 2-->
                        <div class="card h-lg-100">
                            <!--begin::Body-->
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <!--begin::Icon-->
                                <div class="m-0">
                                    <i class="ki-duotone ki-chart-simple fs-2hx text-gray-600">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </div>
                                <!--end::Icon-->
                                <div class="d-flex flex-column my-7">
                                    <!--begin::Number-->
                                    <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2" id="total-incomes">0</span>
                                    <!--end::Number-->
                                </div>
                                <!--begin::Badge-->
                                <span class="badge badge-light-success fs-base">Total Pendapatan</span>
                                <!--end::Badge-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 2-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-sm-6 col-xl-2 mb-xl-10">
                        <!--begin::Card widget 2-->
                        <div class="card h-lg-100">
                            <!--begin::Body-->
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <!--begin::Icon-->
                                <div class="m-0">
                                    <i class="ki-duotone ki-chart-simple fs-2hx text-gray-600">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex flex-column my-7">
                                    <!--begin::Number-->
                                    <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2" id="total-expenses">0</span>
                                    <!--end::Number-->
                                </div>
                                <!--end::Section-->
                                <!--begin::Badge-->
                                <span class="badge badge-light-success fs-base">Total Pengeluaran</span>
                                <!--end::Badge-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 2-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-sm-6 col-xl-2 mb-xl-10">
                        <!--begin::Card widget 2-->
                        <div class="card h-lg-100">
                            <!--begin::Body-->
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <!--begin::Icon-->
                                <div class="m-0">
                                    <i class="ki-duotone ki-chart-simple fs-2hx text-gray-600">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex flex-column my-7">
                                    <!--begin::Number-->
                                    <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2" id="total-net-profit">0</span>
                                    <!--end::Number-->
                                </div>
                                <!--end::Section-->
                                <!--begin::Badge-->
                                <div class="m-0">
                                    <span class="badge badge-light-success fs-base">Laba / Rugi Bersih</span>
                                </div>
                                <!--end::Badge-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 2-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-sm-6 col-xl-2 mb-xl-10">
                        <!--begin::Card widget 2-->
                        <div class="card h-lg-100">
                            <!--begin::Body-->
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <!--begin::Icon-->
                                <div class="m-0">
                                    <i class="ki-duotone ki-chart-simple fs-2hx text-gray-600">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex flex-column my-7">
                                    <!--begin::Number-->
                                    <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2" id="total-assets">0</span>
                                    <!--end::Number-->
                                </div>
                                <!--end::Section-->
                                <!--begin::Badge-->
                                <div class="m-0">
                                    <span class="badge badge-light-success fs-base">Saldo Kas dan Bank</span>
                                </div>
                                <!--end::Badge-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 2-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-sm-6 col-xl-2 mb-xl-10">
                        <!--begin::Card widget 2-->
                        <div class="card h-lg-100">
                            <!--begin::Body-->
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <!--begin::Icon-->
                                <div class="m-0">
                                    <i class="ki-duotone ki-chart-simple fs-2hx text-gray-600">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex flex-column my-7">
                                    <!--begin::Number-->
                                    <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2" id="total-receivables">0</span>
                                    <!--end::Number-->
                                </div>
                                <!--end::Section-->
                                <div class="m-0">
                                    <span class="badge badge-light-success fs-base">Total Piutang Usaha</span>
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 2-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-sm-6 col-xl-2 mb-5 mb-xl-10">
                        <!--begin::Card widget 2-->
                        <div class="card h-lg-100">
                            <!--begin::Body-->
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <!--begin::Icon-->
                                <div class="m-0">
                                    <i class="ki-duotone ki-chart-simple fs-2hx text-gray-600">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex flex-column my-7">
                                    <!--begin::Number-->
                                    <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2" id="total-payables">0</span>
                                    <!--end::Number-->
                                </div>
                                <!--end::Section-->
                                <!--begin::Badge-->
                                <span class="badge badge-light-success fs-base">Total Hutang (Supplier)</span>
                                <!--end::Badge-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 2-->
                    </div>
                    <!--end::Col-->
                </div>

                <div class="row g-5 g-xl-10 mt-3">
                    <!--begin::Table-->
                    <div class="card">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-6">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                Neraca (Balance Sheet)
                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->
                            <div class="card-toolbar">
                                <!--begin::Filters-->
                                <div class="d-flex flex-stack flex-wrap gap-4">

                                </div>
                                <!--begin::Filters-->
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 overflow-x-auto">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_balance_sheet_table">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-300px">Keterangan</th>
                                        <th class="min-w-125px text-end">Debit (Rp)</th>
                                        <th class="min-w-125px text-end">Kredit (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600">

                                </tbody>
                            </table>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Table-->
                </div>

                <div class="row g-5 g-xl-10 mt-3">
                    <!--begin::Table-->
                    <div class="card">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-6">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                Laba Rugi (Income Statements)
                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->
                            <div class="card-toolbar">
                                <!--begin::Filters-->
                                <div class="d-flex flex-stack flex-wrap gap-4">

                                </div>
                                <!--begin::Filters-->
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 overflow-x-auto">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_income_statements_table">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-300px">Keterangan</th>
                                        <th class="min-w-125px text-end">Jumlah</th>
                                        <th class="min-w-125px text-end">SALDO</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600">

                                </tbody>
                            </table>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Table-->
                </div>

                <div class="row g-5 g-xl-10 mt-3">
                    <!--begin::Table-->
                    <div class="card">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-6">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                Arus Kas (Cashflow Statement)
                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->
                            <div class="card-toolbar">
                                <!--begin::Filters-->
                                <div class="d-flex flex-stack flex-wrap gap-4">

                                </div>
                                <!--begin::Filters-->
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 overflow-x-auto">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_cashflow_statements_table">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-300px">Jenis Cash Flow</th>
                                        <th class="min-w-125px">Kategori Cash Flow</th>
                                        <th class="min-w-300px">Deskripsi Transaksi</th>
                                        <th class="min-w-125px text-end">Kas Masuk</th>
                                        <th class="min-w-300px text-end">Kas Keluar</th>
                                        <th class="min-w-125px text-end">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600">

                                </tbody>
                            </table>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Table-->
                </div>
            </div>
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    fetchBalanceSheets();
    fetchIncomeStatement();
    fetchCashflowStatement();
    fetchReportSummary();
});

function fetchBalanceSheets() {
    $.ajax({
        url: "/finances/reports/get-balance-sheets", // Sesuaikan dengan endpoint Laravel Anda
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            populateBalanceSheet("#kt_balance_sheet_table tbody", response.data);
        },
        error: function () {
            console.error("Failed to fetch financial reports.");
        }
    });
}

function fetchIncomeStatement() {
    $.ajax({
        url: "/finances/reports/get-income-statements", // Sesuaikan dengan endpoint API-mu
        method: "GET",
        dataType: "json",
        success: function (response) {
            populateIncomeStatement("#kt_income_statements_table tbody", response.data);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching income statement data:", error);
        }
    });
}

function fetchCashflowStatement() {
    $.ajax({
        url: "/finances/reports/get-cashflow-statements", // Endpoint API Laravel
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.statusCode === 200) {
                populateCashflowStatement("#kt_cashflow_statements_table tbody", response.data);
            } else {
                console.error("Error: Unexpected response format", response);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching cash flow statement data:", error);
        }
    });
}

function fetchReportSummary() {
    $.ajax({
        url: "/finances/reports/get-report-summaries", // Sesuaikan dengan endpoint API-mu
        method: "GET",
        dataType: "json",
        success: function (response) {
            var data = response.data;

            $("#total-incomes").text(formatNumber(data.totalIncomes));
            $("#total-expenses").text(formatNumber(data.totalExpenses));
            $("#total-net-profit").text(formatNumber(data.totalNetProfit));
            $("#total-assets").text(formatNumber(data.totalAssets));
            $("#total-receivables").text(formatNumber(data.totalReceivables));
            $("#total-payables").text(formatNumber(data.totalPayables));
        },
        error: function (xhr, status, error) {
            console.error("Error fetching income statement data:", error);
        }
    });
}

function populateBalanceSheet(tableSelector, data) {
    let tableBody = $(tableSelector);
    tableBody.empty(); // Kosongkan tabel sebelum diisi ulang

    let totalAssets = 0;
    let totalLiabilities = 0;
    let totalEquity = 0;

    function addRow(name, amount) {
        let formattedAmount = formatNumber(amount);
        let debit = amount > 0 ? formattedAmount : "-";
        let credit = amount < 0 ? formattedAmount : "-";
        tableBody.append(`
            <tr>
                <td>&nbsp;&nbsp;&nbsp;${name}</td>
                <td class="text-end">${debit}</td>
                <td class="text-end">${credit}</td>
            </tr>
        `);
    }

    // Tambahkan Header Assets
    tableBody.append('<tr class="fw-bolder"><td>Assets</td><td></td><td></td></tr>');
    data.assets.forEach(asset => {
        let amount = parseFloat(asset.amount) || 0;
        totalAssets += amount;
        addRow(asset.name, amount);
    });

    // Tambahkan Header Liabilities
    tableBody.append('<tr class="fw-bolder"><td>Liabilities</td><td></td><td></td></tr>');
    data.liabilities.forEach(liability => {
        let amount = parseFloat(liability.amount) || 0;
        totalLiabilities += amount;
        addRow(liability.name, amount);
    });

    // Tambahkan Header Equity
    tableBody.append('<tr class="fw-bolder"><td>Equity</td><td></td><td></td></tr>');
    data.equity.forEach(equity => {
        let amount = parseFloat(equity.amount) || 0;
        totalEquity += amount;
        addRow(equity.name, amount);
    });

    // Tambahkan Total Row
    tableBody.append(`
        <tr class="fw-bolder">
            <td>Total</td>
            <td class="text-end">${formatNumber(totalAssets)}</td>
            <td class="text-end">${formatNumber(totalLiabilities + totalEquity)}</td>
        </tr>
    `);
}

function populateIncomeStatement(tableSelector, data) {
    let tableBody = $(tableSelector);
    tableBody.empty();

    let totalRevenue = 0;
    let totalExpense = 0;

    function addRow(name, amount, isExpense = false) {
        let formattedAmount = formatNumber(amount);
        let debit = isExpense ? formattedAmount : "-";
        let credit = isExpense ? "-" : formattedAmount;

        tableBody.append(`
            <tr>
                <td>&nbsp;&nbsp;&nbsp;${name}</td>
                <td class="text-end">${debit}</td>
                <td class="text-end">${credit}</td>
            </tr>
        `);
    }

    // Tambahkan Header Pendapatan
    tableBody.append('<tr class="fw-bolder"><td>Pendapatan</td><td></td><td></td></tr>');
    data.revenues.forEach(revenue => {
        totalRevenue += parseFloat(revenue.amount) || 0;
        addRow(revenue.name, revenue.amount, false);
    });

    // Tambahkan Header Beban
    tableBody.append('<tr class="fw-bolder"><td>Beban</td><td></td><td></td></tr>');
    data.expenses.forEach(expense => {
        totalExpense += parseFloat(expense.amount) || 0;
        addRow(expense.name, expense.amount, true);
    });

    // Tambahkan Laba Bersih
    let netProfit = totalRevenue - totalExpense;
    tableBody.append(`
        <tr class="fw-bolder">
            <td>Laba Bersih</td>
            <td class="text-end"></td>
            <td class="text-end">${formatNumber(netProfit)}</td>
        </tr>
    `);
}

function populateCashflowStatement(selector, data) {
    let tableBody = $(selector);
    tableBody.empty(); // Hapus isi tabel sebelum menampilkan data baru

    if (!Array.isArray(data) || data.length === 0) {
        tableBody.append('<tr><td colspan="6" class="text-center">No data available</td></tr>');
        return;
    }

    let totals = {};
    let totalKeseluruhan = { kas_masuk: 0, kas_keluar: 0, saldo: 0 };
    let lastCategory = null;

    data.forEach((item, index) => {
        if (!item || !item.category_type || !item.kategori_cash_flow || !item.kas_masuk || !item.kas_keluar) {
            console.warn("Skipping invalid item at index", index, item);
            return;
        }

        if (!totals[item.category_type]) {
            totals[item.category_type] = { kas_masuk: 0, kas_keluar: 0, saldo: 0 };
        }

        totals[item.category_type].kas_masuk += parseFloat(item.kas_masuk);
        totals[item.category_type].kas_keluar += parseFloat(item.kas_keluar);
        totals[item.category_type].saldo += parseFloat(item.saldo);

        totalKeseluruhan.kas_masuk += parseFloat(item.kas_masuk);
        totalKeseluruhan.kas_keluar += parseFloat(item.kas_keluar);
        totalKeseluruhan.saldo += parseFloat(item.saldo);

        let row = `
            <tr>
                <td>${item.category_type}</td>
                <td>${item.kategori_cash_flow}</td>
                <td>${item.nama_akun}</td>
                <td class="text-end">${formatNumber(item.kas_masuk)}</td>
                <td class="text-end">${formatNumber(item.kas_keluar)}</td>
                <td class="text-end"><strong>${formatNumber(item.saldo)}</strong></td>
            </tr>
        `;
        tableBody.append(row);
    });

    // Menambahkan total untuk masing-masing kategori cash flow
    Object.keys(totals).forEach(category => {
        tableBody.append(`
            <tr class="fw-bold bg-light">
                <td>Total ${category}</td>
                <td>-</td>
                <td>-</td>
                <td class="text-end">${formatNumber(totals[category].kas_masuk)}</td>
                <td class="text-end">${formatNumber(totals[category].kas_keluar)}</td>
                <td class="text-end"><strong>${formatNumber(totals[category].saldo)}</strong></td>
            </tr>
        `);
    });

    // Menambahkan total keseluruhan
    tableBody.append(`
        <tr>
            <td>Total Keseluruhan</td>
            <td>-</td>
            <td>-</td>
            <td class="text-end">${formatNumber(totalKeseluruhan.kas_masuk)}</td>
            <td class="text-end">${formatNumber(totalKeseluruhan.kas_keluar)}</td>
            <td class="text-end"><strong>${formatNumber(totalKeseluruhan.saldo)}</strong></td>
        </tr>
    `);
}


function formatCurrency(amount) {
    return new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(amount);
}

function formatNumber(num) {
    if (num == null) return "0"; // Handle null or undefined values
    let numStr = String(num); // Ensure it's a string

    let cleaned = numStr.replace(/[^\d.-]/g, ''); // Allow only digits, dot, and minus
    let isNegative = cleaned.startsWith('-'); // Check if it's negative
    cleaned = cleaned.replace(/^-/, ''); // Remove minus sign temporarily

    const parts = cleaned.split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    let formatted = parts.join('.');

    return isNegative ? '-' + formatted : formatted; // Add back minus sign if necessary
}
</script>
@endsection
