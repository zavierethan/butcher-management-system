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
                        Expenses</h1>
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
                        <li class="breadcrumb-item text-muted">Expenses</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Secondary button-->
                    <a href="{{route('finances.expenses.create')}}" class="btn btn-sm fw-bold btn-secondary">New</a>
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
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Row-->
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <!--begin::Table-->
                    <div class="card">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-6">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->

                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                                rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                            <path
                                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-kt-customer-table-filter="search"
                                        class="form-control form-control-solid w-250px ps-15" placeholder="Search" />
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 overflow-x-auto">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_daily_expenses_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">TANGGAL</th>
                                        <th class="min-w-125px">DESKRIPSI</th>
                                        <th class="min-w-125px">TOTAL</th>
                                        <th class="min-w-125px">REF.</th>
                                        <th class="min-w-125px">JENIS PEMBAYARAN</th>
                                        <th class="text-center min-w-70px">ACTIONS</th>
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
$(document).ready(function() {
    const table = $("#kt_expenses_table").DataTable({
        processing: true,
        serverSide: true,
        paging: true, // Enable pagination
        pageLength: 10, // Number of rows per page
        ajax: {
            url: `{{route('finances.expenses.get-lists')}}`, // Replace with your route
            type: 'GET',
            data: function (d) {
                // Add filter data to the request
                d.start_date = $('#start-date').val();
                d.end_date = $('#end-date').val();
            },
            dataSrc: function(json) {
                return json.data; // Map the 'data' field
            }
        },
        columns: [{
                data: 'title',
                name: 'title'
            },
            {
                data: 'description',
                name: 'description',
            },
            {
                data: 'amount',
                name: 'amount'
            },
            {
                data: 'reference',
                name: 'reference'
            },
            {
                data: 'payment_method',
                name: 'payment_method',
                render: function(data, type, row) {
                    var payment_method = "";

                    if (row.payment_method == 1) {
                        payment_method = `<span class="badge bg-success text-dark">Tunai</span>`
                    }

                    if (row.payment_method == 2) {
                        payment_method = `<span class="badge bg-success text-dark">Piutang</span>`
                    }

                    return payment_method;
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
                            <a href="/finances/expenses/edit/${row.id}" class="btn btn-sm btn-light btn-active-light-primary" title="Edit"><i class="fa-solid fa-edit"></i>Edit</a>
                        <div>
                    `;
                }
            }
        ]
    });

    $('#start-date, #end-date').on('change', function () {
        table.draw(); // Trigger DataTable redraw with updated filter values
    });
});
</script>
@endsection
