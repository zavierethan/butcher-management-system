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
                    <!--begin::Secondary button-->
                    <a href="#" class="btn btn-sm fw-bold btn-secondary" id="btn-form-export">Export</a>
                    <!--end::Secondary button-->
                    <!--begin::Primary button-->
                    <a href="{{route('stocks.create')}}" class="btn btn-sm fw-bold btn-primary">New</a>
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
                        <div class="card-header border-0 pt-6">
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <!--begin::Filters-->
                                <div class="d-flex flex-stack flex-wrap gap-4">
                                    <div class="d-flex align-items-center fw-bold">
                                        <!--begin::Label-->
                                        <div class="text-gray-500 fs-7 me-2">Tanggal</div>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <input type="date" class="form-control form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto" id="start-date"/> -
                                        <input type="date" class="form-control form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto" id="end-date"/>
                                        <!--end::Select-->
                                    </div>
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
                                        <th class="min-w-125px">Produk</th>
                                        <th class="min-w-125px">Cabang</th>
                                        <th class="min-w-125px">Kuantitas</th>
                                        <th class="min-w-125px">Kuantitas Opname</th>
                                        <th class="min-w-125px">Tanggal</th>
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
                data: null,
                name: 'product_code_name',
                render: function (data, type, row) {
                    return `${row.product_code} - ${row.product_name}`;
                }
            },
            {
                data: null,
                name: 'branch_code_name',
                render: function (data, type, row) {
                    return `${row.branch_code} - ${row.branch_name}`;
                }
            },
            { data: 'quantity', name: 'quantity' },
            { data: 'opname_quantity', name: 'opname_quantity' },
            { data: 'date', name: 'date' },
            {
                data: null, // No direct field from the server
                name: 'action',
                orderable: false, // Disable ordering for this column
                searchable: false, // Disable searching for this column
                render: function (data, type, row) {
                    return `
                        <div class="text-center">
                            <a href="/stock-logs/${row.id}" class="btn btn-sm btn-light btn-active-light-primary">Details</a>
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
        // Show loader during export
        $('.loader').show();

        // Get the filter values
        const start_date = $('#start-date').val();
        const end_date = $('#end-date').val();
        const searchTerm = $('[data-kt-customer-table-filter="search"]').val();

        // Make an AJAX request to export the data
        $.ajax({
            url: `{{url('/stocks/export')}}`, // Adjusted to match your "stocks" route
            type: 'GET',
            data: {
                start_date: start_date,
                end_date: end_date,
                search_term: searchTerm // Include the search term from the input
            },
            xhrFields: {
                responseType: 'blob', // Treat response as binary
            },
            beforeSend: function() {
                $('.loader').show(); // Show loader before the request
            },
            success: function(data, status, xhr) {
                // Hide the loader after successful response
                $('.loader').hide();

                // Create a Blob object from the response
                const blob = new Blob([data], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });

                // Create a link element for downloading the file
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'filtered-stocks-report.xlsx'; // Set a meaningful filename
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                // Show success alert
                Swal.fire({
                    title: 'Success!',
                    text: 'Filtered stocks report exported successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                });
            },
            error: function(xhr, status, error) {
                // Hide the loader on error
                $('.loader').hide();

                // Show error alert
                Swal.fire('Error!', 'Failed to export the filtered stocks report.', 'error');
            },
        });
    });

</script>
@endsection
