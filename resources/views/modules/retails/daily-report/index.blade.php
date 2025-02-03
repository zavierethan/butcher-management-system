@extends('layouts.main')

@section('main-content')
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
                            id="start-date" value="<?php echo date("Y-m-d"); ?>" /> -
                        <input type="date"
                            class="form-control form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto"
                            id="end-date" value="<?php echo date("Y-m-d"); ?>" />
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
                <!--begin::Row-->
                <div class="row gy-5 g-xl-10">
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
                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="total-revenue">0</span>
                                    <!--end::Number-->
                                </div>
                                <!--end::Section-->
                                <!--begin::Badge-->
                                <span class="badge badge-light-success fs-base">Total Omset</span>
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
                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="total-cash">0</span>
                                    <!--end::Number-->
                                </div>
                                <!--end::Section-->
                                <!--begin::Badge-->
                                <div class="m-0">
                                    <span class="badge badge-light-success fs-base">Pemasukan Tunai</span>
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
                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="total-receivable">0</span>
                                    <!--end::Number-->
                                </div>
                                <!--end::Section-->
                                <!--begin::Badge-->
                                <div class="m-0">
                                    <span class="badge badge-light-success fs-base">Pemasukan Piutang</span>
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
                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="total-transfer">0</span>
                                    <!--end::Number-->
                                </div>
                                <!--end::Section-->
                                <div class="m-0">
                                    <span class="badge badge-light-success fs-base">Pemasukan Transfer</span>
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
                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2"
                                        id="total-expenses">0</span>
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
                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">0</span>
                                    <!--end::Number-->
                                    <!--begin::Follower-->
                                    <div class="m-0">
                                        <span class="fw-semibold fs-6 text-gray-500">Saving</span>
                                    </div>
                                    <!--end::Follower-->
                                </div>
                                <!--end::Section-->
                                <!--begin::Badge-->
                                <span class="badge badge-light-success fs-base">
                                    <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>2.1%</span>
                                <!--end::Badge-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 2-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row gy-5 g-xl-10">
                    <!--begin::Col-->
                    <div class="col-xl-12">
                        <!--begin::Table Widget 5-->
                        <div class="card card-flush h-xl-100">
                            <!--begin::Card header-->
                            <div class="card-header pt-7">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-900">Stock Report</span>
                                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Total 2,356 Items in the
                                        Stock</span>
                                </h3>
                                <!--end::Title-->
                                <!--begin::Actions-->
                                <div class="card-toolbar">
                                    <!--begin::Filters-->
                                    <div class="d-flex flex-stack flex-wrap gap-4">
                                        <!--begin::Destination-->
                                        <div class="d-flex align-items-center fw-bold">
                                            <!--begin::Label-->
                                            <div class="text-muted fs-7 me-2">Category</div>
                                            <!--end::Label-->
                                            <!--begin::Select-->
                                            <select
                                                id="category-filter"
                                                class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto"
                                                data-control="select2" data-hide-search="true"
                                                data-dropdown-css-class="w-150px" data-placeholder="Select a category">
                                                <option value="Show All" selected="selected">Show All</option>
                                            </select>
                                            <!--end::Select-->
                                        </div>
                                        <!--end::Destination-->
                                        <!--begin::Status-->
                                        <div class="d-flex align-items-center fw-bold">
                                            <!--begin::Label-->
                                            <div class="text-muted fs-7 me-2">Status</div>
                                            <!--end::Label-->
                                            <!--begin::Select-->
                                            <select
                                                class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto"
                                                data-control="select2" data-hide-search="true"
                                                data-dropdown-css-class="w-150px" data-placeholder="Select an option"
                                                id="kt_table_widget_5_filter_status">
                                                <option></option>
                                                <option value="Show All" selected="selected">Show All</option>
                                                <option value="In Stock">In Stock</option>
                                                <option value="Out of Stock">Out of Stock</option>
                                                <option value="Low Stock">Low Stock</option>
                                            </select>
                                            <!--end::Select-->
                                        </div>
                                        <!--end::Status-->
                                    </div>
                                    <!--begin::Filters-->
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0 overflow-x-auto">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-3"
                                    id="kt_table_widget_5_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-150px">Item</th>
                                            <th class="min-w-100px">Product ID</th>
                                            <th class="min-w-150px">Date Added</th>
                                            <th class="min-w-100px">Price</th>
                                            <th class="min-w-100px">Status</th>
                                            <th class="min-w-75px">Qty</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Table Widget 5-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
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
<script>
$(document).ready(function() {
    getTransactionSummaryByCategory();
    getCategories();
    getStockReport();

    $('#start-date, #end-date').on('change', function () {
        getTransactionSummaryByCategory(); // Trigger DataTable redraw with updated filter values
        getStockReport();
    });

    $("#kt_table_widget_5_filter_status").on('change', function () {
        getStockReport(); // Trigger DataTable redraw with updated filters
    });

    $('#category-filter').on('change', function () {
        getStockReport(); // Redraw table with updated category filter
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
            responseType: 'blob', // Treat response as binary
        },
        success: function(data, status, xhr) {
            // Create a Blob object from the response

            console.log(data)
            const blob = new Blob([data], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });

            // Create a link element for downloading
            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'daily-report.xlsx'; // Set the filename
            document.body.appendChild(link); // Append link to the body
            link.click(); // Trigger the download
            document.body.removeChild(link); // Clean up the DOM

            Swal.fire({
                title: 'Success!',
                text: 'Daly Report exported successfully.',
                icon: 'success',
                confirmButtonText: 'OK',
            });
        },
        error: function(xhr, status, error) {
            Swal.fire('Error!', 'Failed to export the transaction report.', 'error');
        },
    });

});

function getTransactionSummaryByCategory() {

    const start_date = $("#start-date").val();
    const end_date = $("#end-date").val();
    let branchId = `{{Auth::user()->branch_id}}`;

    $.ajax({
        url: `{{route('retails.daily-report.summary')}}`,
        type: 'GET',
        data: {
            start_date: start_date,
            end_date: end_date,
            branch_id: branchId,
        },
        dataType: 'json',
        success: function(response) {
            $("#total-cash").text(response.total_cash);
            $("#total-receivable").text(response.total_receivable);
            $("#total-transfer").text(response.total_transfer);
            $("#total-revenue").text(response.total_revenue);
            $("#total-expenses").text(response.total_expense);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching products:', error);
        }
    });
}

// Fetch product categories and populate the select dropdown
function getCategories() {
    $.ajax({
        url: `{{ url('api/get-product-categories') }}`,
        type: 'GET',
        success: function(data) {
            const categorySelect = $('#category-filter');
            categorySelect.empty(); // Clear existing options

            // Add the "Show All" option
            categorySelect.append('<option value="Show All" selected="selected">Show All</option>');

            // Loop through categories and append them to the select
            $.each(data, function(id, name) {
                categorySelect.append(`<option value="${id}">${name}</option>`);
            });

            // Re-initialize select2 after populating options
            categorySelect.select2({
                placeholder: 'Select a category',
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching categories:', error);
        }
    });
}

function getStockReport() {
    const start_date = $("#start-date").val();
    const end_date = $("#end-date").val();
    const stock_status = $("#kt_table_widget_5_filter_status").val();
    const category_id = $("#category-filter").val();

    // Destroy the existing DataTable if it's already initialized
    if ($.fn.DataTable.isDataTable("#kt_table_widget_5_table")) {
        $("#kt_table_widget_5_table").DataTable().destroy();
    }

    // Reinitialize DataTable with the filters
    const stockTable = $("#kt_table_widget_5_table").DataTable({
        processing: true,
        serverSide: true,
        paging: true,
        pageLength: 10, // Number of rows per page
        ajax: {
            url: `{{ route('retails.daily-report.get-stock-report') }}`,
            type: 'GET',
            data: {
                start_date: start_date,
                end_date: end_date,
                stock_status: stock_status,
                category_id: category_id
            },
        },
        order: [[0, 'desc']], // Sorting by the first column
        columns: [
            { data: 'product_name', name: 'product_name' },
            { data: 'code', name: 'code' },
            { data: 'date', name: 'date' },
            { data: 'price', name: 'price' },
            { data: 'stock_status', name: 'stock_status' },
            { data: 'quantity', name: 'quantity' },
        ]
    });
}
</script>
@endsection