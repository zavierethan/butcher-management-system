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
                        Stock Logs</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Inventory Management</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Stocks</li>
                        <!--end::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Stock Logs</li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Secondary button-->
                    <a href="#" class="btn btn-sm fw-bold btn-secondary" id="btn-form-export">Export</a>
                    <!--end::Secondary button-->
                    <!--begin::Primary button-->
                    <a href="{{route('stock-logs.create', ['stockId' => $stockId])}}"
                        class="btn btn-sm fw-bold btn-primary">Input New Log</a>
                    <!--end::Primary button-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Row-->
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <!--begin::Table-->
                    <div class="card">
                        <div class="card-body pt-10">
                            <div class="row">
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Nama Produk</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-md form-control-solid" type="text"
                                                value="{{ $stockHeader->product_code }} - {{ $stockHeader->product_name }}"
                                                readonly />
                                            <input class="form-control form-control-md form-control-solid" type="hidden"
                                                value="{{ $stockHeader->id }}" id="stock-id" />
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Cabang</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-md form-control-solid"
                                                value="{{ $stockHeader->branch_code }} - {{ $stockHeader->branch_name }}"
                                                readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Kuantitas Realtime</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-md form-control-solid"
                                                value="{{ $stockHeader->total_quantity }}" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="text-end">
                                    <a href="{{ route('stocks.index') }}" class="btn btn-danger">Back</a>
                                    <a href="#" class="btn btn-primary" id="btn-update"
                                        data-branch-id="{{ $stockHeader->branch_id }}"
                                        data-product-id="{{ $stockHeader->product_id }}">Update</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Table-->

                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <div class="card">
                        <div class="card-body pt-10">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_products_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Referensi</th>
                                        <th class="min-w-125px">Masuk</th>
                                        <th class="min-w-125px">Keluar</th>
                                        <th class="min-w-125px">Waktu</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                </tbody>
                                <!--end::Table body-->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
<!--end::Content wrapper-->
</div>
@endsection

@section('script')
<script>
const stockId = "{{ $stockId }}"; // Pass the rowId from the Blade template

$("#kt_products_table").DataTable({
    processing: true,
    serverSide: true,
    paging: true, // Enable pagination
    pageLength: 10, // Number of rows per page
    ajax: {
        url: `{{route('stock-logs.get-lists', ['stockId' => $stockId])}}`, // Replace with your route
        type: 'GET',
        data: function(d) {
            d.stockId = stockId; // Add rowId to the request payload
        },
        dataSrc: function(json) {
            return json.data; // Map the 'data' field
        }
    },
    columns: [{
            data: 'reference',
            name: 'reference'
        },
        {
            data: 'in_quantity',
            name: 'in_quantity'
        },
        {
            data: 'out_quantity',
            name: 'out_quantity'
        },
        {
            data: 'date',
            name: 'date'
        },
    ]
});

// Initialize DataTable for "stock_header"
const stockHeaderTable = $("#stock_header").DataTable({
    processing: true,
    serverSide: true,
    paging: true,
    pageLength: 10,
    ajax: {
        url: `/api/stock-header/${stockId}`,
        type: 'GET',
    },
    columns: [{
            data: 'product_name',
            name: 'product_name'
        },
        {
            data: 'branch_name',
            name: 'branch_name'
        },
        {
            data: 'quantity',
            name: 'quantity'
        },
        {
            data: 'opname_quantity',
            name: 'opname_quantity',
            render: function(data, type, row) {
                const displayValue = data !== null ? data : '';
                return `
                        <div class="d-flex align-items-center">
                            <input type="text"
                                class="form-control form-control-sm inline-edit-opname_quantity me-2"
                                value="${displayValue}"
                                data-id="${row.id}" />
                            <button type="button"
                                class="btn btn-sm btn-light btn-active-light-primary btn-update-opname"
                                data-id="${row.id}">Update</button>
                        </div>
                    `;
            },
        },
        {
            data: 'date',
            name: 'date'
        },
    ],
});


$("#btn-form-export").on("click", function() {
    const stockId = "{{ $stockId }}";
    const branchCode = "{{ $stockHeader->branch_code }}"
    const branchName = "{{ $stockHeader->branch_name }}"

    $.ajax({
        url: `{{route('stock-logs.export')}}`,
        type: 'GET',
        data: {
            stock_id: stockId,
            branch_code: branchCode,
            branch_name: branchName
        },
        xhrFields: {
            responseType: 'blob', // Treat response as binary
        },
        success: function(data, status, xhr) {
            // Extract filename from Content-Disposition header
            let disposition = xhr.getResponseHeader('Content-Disposition');
            let filename = 'stock-log.xlsx'; // Default filename

            if (disposition && disposition.indexOf('attachment') !== -1) {
                let matches = /filename="([^"]+)"/.exec(disposition);
                if (matches && matches[1]) filename = matches[1];
            }

            // Create a Blob object from the response
            const blob = new Blob([data], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });

            // Create a link element for downloading
            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = filename; // Set the extracted filename
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link); // Clean up the DOM

            Swal.fire({
                title: 'Success!',
                text: 'Stock Log Report exported successfully.',
                icon: 'success',
                confirmButtonText: 'OK',
            });
        },
        error: function(xhr, status, error) {
            Swal.fire('Error!', 'Failed to export the stock log report.', 'error');
        },
    });

});
</script>
@endsection
