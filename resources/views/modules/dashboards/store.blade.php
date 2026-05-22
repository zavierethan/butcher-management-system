@extends('layouts.main')
@section('css')
<style>
    /* Loader Backdrop Styles */
    .loader-backdrop {
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
    }

    .loader-backdrop.show {
        display: flex;
    }

    .loader-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }

    .loader-spinner {
        border: 4px solid rgba(255, 255, 255, 0.3);
        border-top: 4px solid #ffffff;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }

    .loader-text {
        color: #ffffff;
        font-size: 16px;
        font-weight: 500;
    }

    /* Spinner Animation */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>
@endsection

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
                            id="date" value="{{ date('Y-m-d') }}">
                        <div class="text-gray-500 fs-7 me-2">Store</div>
                        <select
                            class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto"
                            data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px"
                            data-placeholder="Select an option" id="branch"
                            {{ Auth::user()->group_id != 1 ? 'disabled' : '' }}>
                            <option value="" selected="selected">Show All</option>
                            @foreach($branches as $branch)
                            <option value="{{$branch->id}}"
                                {{ Auth::user()->branch_id == $branch->id ? 'selected' : '' }}>
                                {{$branch->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <a href="#" class="btn btn-sm fw-bold btn-secondary" id="btn-form-export">Export ke Excel</a>
                </div>
            </div>
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Loader Backdrop-->
            <div id="loader-backdrop" class="loader-backdrop">
                <div class="loader-content">
                    <div class="loader-spinner"></div>
                    <span class="loader-text">Loading...</span>
                </div>
            </div>
            <!--end::Loader Backdrop-->
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container mt-5">
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
                                    <small id="total-transactions"></small>
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
                                        <i class="ki-duotone ki-wallet fs-2 text-white">
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
                                    <span class="text-gray-700 fs-7 fw-semibold mb-2">UANG DI KASIR</span>
                                    <span class="fw-bold fs-2 text-gray-900" id="total-kasir">Rp.0</span>
                                    <small class="text-danger italics" id="difference-kasir"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Diskon Card -->
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
                                    <span class="text-gray-700 fs-7 fw-semibold mb-2">TOTAL DISKON</span>
                                    <span class="fw-bold fs-2 text-gray-900" id="total-discount">Rp.0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Stat Cards Row -->

                <div class="row mt-10">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Transaksi Processing Order</h3>
                            </div>
                            <div class="card-body">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_transactions_table">
                                    <thead>
                                        <tr>
                                            <th>Nomor Transaksi</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Customer</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data akan diisi via AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
<!--end:::Main-->
@endsection

@section('script')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
$(document).ready(function() {
    // AJAX untuk tabel Processing Order
    $('.loader').hide();

    const table = $("#kt_transactions_table").DataTable({
        processing: true,
        order: [
            [0, 'desc']
        ],
        serverSide: true,
        paging: true, // Enable pagination
        pageLength: 10, // Number of rows per page
        ajax: {
            url: `{{route('orders.get-lists')}}`, // Replace with your route
            type: 'GET',
            data: function (d) {
                // Add filter data to the request
                d.branch_id = $('#branch-id').val();
                d.working_method = 2; // Processing Order
                d.status = 5;
            },
            dataSrc: function(json) {
                return json.data; // Map the 'data' field
            }
        },
        columns: [
            {
                data: 'code',
                name: 'code'
            },
            {
                data: 'transaction_date',
                name: 'transaction_date',
            },
            {
                data: 'customer_name',
                name: 'customer_name'
            },
            {
                data: 'status',
                name: 'status',
                className: 'text-center',
                render: function(data, type, row) {
                    var status = "";

                    if (row.status == 1) {
                        status = `<span class="badge bg-success text-dark">Lunas</span>`
                    }

                    if (row.status == 2) {
                        status = `<span class="badge bg-warning text-dark">Piutang</span>`
                    }

                    if (row.status == 3) {
                        status = `<span class="badge bg-warning text-dark">Pending (Transfer)</span>`
                    }

                    if (row.status == 4) {
                        status = `<span class="badge bg-danger text-dark">Batal</span>`
                    }

                    return status;
                }
            },
            {
                data: null, // No direct field from the server
                name: 'action',
                orderable: false, // Disable ordering for this column
                searchable: false, // Disable searching for this column
                render: function(data, type, row) {
                    return `
                        <div class="text-center">
                            <a href="/orders/edit/${row.id}" class="btn btn-sm btn-light btn-active-light-primary" title="Detail Transaksi"><i class="fa-solid fa-magnifying-glass"></i></a>
                        <div>
                    `;
                }
            }
        ]
    });

    $('[data-kt-customer-table-filter="search"]').on('keyup', function() {
        const searchTerm = $(this).val(); // Get the value from the search input
        table.search(searchTerm).draw(); // Trigger the search and refresh the DataTable
    });

    $('#start-date, #end-date, #customer, #payment-method, #status, #branch-id').on('change', function () {
        table.draw(); // Trigger DataTable redraw with updated filter values
    });
});
</script>
@endsection
