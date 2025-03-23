@extends('layouts.main')

@section('main-content')

<?php date_default_timezone_set("Asia/Jakarta"); ?>
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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Stocks</h1>
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
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{route('stocks.stock-opnames')}}" class="btn btn-sm fw-bold btn-primary" id="btn-form-stock-opname">Stock Opname</a>
                    <a href="{{route('stocks.mutasi')}}" class="btn btn-sm fw-bold btn-primary" id="btn-form-stock-opname">Mutasi</a>
                    <a href="#" class="btn btn-sm fw-bold btn-secondary" id="btn-form-export">Export</a>
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
                        <div class="card-header border-0 pt-6">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->

                                <!--end::Search-->
                            </div>
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex flex-stack flex-wrap gap-4">
                                    <!--begin::Search-->
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
                                    <!--end::Search-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--begin::Card body-->
                        <div class="card-body pt-0 overflow-x-auto">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_products_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Kode Produk</th>
                                        <th class="min-w-125px">Nama Produk</th>
                                        <th class="min-w-125px">Cabang</th>
                                        <th class="min-w-125px">Kuantitas Stock (Kg)</th>
                                        <th class="text-center min-w-70px">Actions</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Table-->
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
    // Utility function to sanitize input values
    const sanitizeValue = (value) => {
        return value === '-' || value === '' ? null : value;
    };

    // Initialize DataTable
    const table = $("#kt_products_table").DataTable({
        processing: true,
        serverSide: true,
        paging: true, // Enable pagination
        pageLength: 10, // Number of rows per page
        ajax: {
            url: `{{ route('stocks.get-lists') }}`, // Replace with your route
            type: 'GET',
            data: function (d) {
                // Send filter values to the server along with the pagination params
                d.searchTerm = $('[data-kt-customer-table-filter="search"]').val();
                d.startDate = $('#start-date').val();
                d.endDate = $('#end-date').val();
            },
            dataSrc: function (json) {
                return json.data; // Map the 'data' field
            }
        },
        columns: [
            {
                data: 'product_code', name: 'product_code',
            },
            {
                data: 'product_name', name: 'product_name',
            },
            {
                data: 'branch_name', name: 'branch_name',
            },
            { data: 'realtime_quantity', name: 'realtime_quantity', className: 'text-center' },
            {
                data: null, // No direct field from the server
                name: 'action',
                orderable: false, // Disable ordering for this column
                searchable: false, // Disable searching for this column
                render: function (data, type, row) {
                    return `
                        <div class="text-center">
                            <a href="/stock-logs/${row.id}" class="btn btn-sm btn-light btn-active-light-primary">Details</a>
                            <a href="/stocks/opnames/${row.id}" class="btn btn-sm btn-light btn-active-light-primary">Stock Opname</a>
                        <div>
                    `;
                }
            }
        ]
    });

    // Search input filter
    $('[data-kt-customer-table-filter="search"]').on('keyup', function () {
        table.draw(); // Trigger table redraw with updated search value
    });

    const sanitizeDate = (value) => (value === '' || value === '-' ? null : value);

    $('#start-date, #end-date').on('change', function () {
        const startDate = sanitizeDate($('#start-date').val());
        const endDate = sanitizeDate($('#end-date').val());
        table.draw();
    });

    $("#btn-form-export").on("click", function() {
        const searchTerm = $('[data-kt-customer-table-filter="search"]').val();
        const startDate = $('#start-date').val();
        const endDate = $('#end-date').val();

        $.ajax({
            url: `{{url('/stocks/export')}}`,
            type: 'GET',
            data: {
                search_term: searchTerm,
                start_date: startDate,
                end_date: endDate,
            },
            xhrFields: {
                responseType: 'blob', // Treat response as binary
            },
            success: function(data, status, xhr) {
                $("#kt_modal_export_filter").modal('hide');
                // Create a Blob object from the response
                const blob = new Blob([data], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });

                // Create a link element for downloading
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'stock-reports.xlsx'; // Set the filename
                document.body.appendChild(link); // Append link to the body
                link.click(); // Trigger the download
                document.body.removeChild(link); // Clean up the DOM

                Swal.fire({
                    title: 'Success!',
                    text: 'Stock report exported successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                });
            },
            error: function(xhr, status, error) {
                Swal.fire('Error!', 'Failed to export the stock report.', 'error');
            },
        });

    });

</script>
@endsection
