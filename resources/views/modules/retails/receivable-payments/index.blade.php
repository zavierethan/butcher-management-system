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
                        Receivable Payments</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Retails</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Receivable Payments</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Secondary button-->
                    <a href="{{route('retails.receivable-payments.create')}}" class="btn btn-sm fw-bold btn-secondary">New</a>
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
                            <div class="card-toolbar">
                                <!--begin::Filters-->
                                <div class="d-flex flex-stack flex-wrap gap-4">
                                    <div class="d-flex align-items-center fw-bold gap-2">
                                        <!--begin::Label-->
                                        <div class="text-gray-500 fs-7">Customer</div>
                                        <!--end::Label-->
                                        <select class="form-select form-select-solid text-gray-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto" id="filter-customer">
                                            <option value="">- Semua -</option>
                                            @foreach($customers as $customer)
                                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="d-flex align-items-center fw-bold gap-2">
                                        <!--begin::Label-->
                                        <div class="text-gray-500 fs-7">Nomor Invoice</div>
                                        <!--end::Label-->
                                        <input type="text" class="form-control form-control-solid text-gray-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto" id="filter-invoice" placeholder="Invoice No" />
                                    </div>
                                    <div class="d-flex align-items-center fw-bold gap-2">
                                        <!--begin::Label-->
                                        <div class="text-gray-500 fs-7">Metode Pembayaran</div>
                                        <!--end::Label-->
                                        <select class="form-select form-select-solid text-gray-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto" id="filter-payment-method">
                                            <option value="">- Semua -</option>
                                            <option value="1">TUNAI</option>
                                            <option value="2">TRANSFER</option>
                                        </select>
                                    </div>
                                    <div class="d-flex align-items-center fw-bold gap-2">
                                        <!--begin::Label-->
                                        <div class="text-gray-500 fs-7">Tanggal</div>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <input type="date"
                                            class="form-control form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto"
                                            id="start-date" /> -
                                        <input type="date"
                                            class="form-control form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto"
                                            id="end-date" />
                                        <!--end::Select-->
                                    </div>
                                </div>
                                <!--begin::Filters-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 overflow-x-auto">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_receivable_payments_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">CUSTOMER</th>
                                        <th class="min-w-125px">TANGGAL</th>
                                        <th class="min-w-125px">NOMOR INVOICE</th>
                                        <th class="min-w-125px">METHODE PEMBAYARAN</th>
                                        <th class="min-w-125px text-end">TOTAL BAYAR</th>
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

    const table = $("#kt_receivable_payments_table").DataTable({
        processing: true,
        serverSide: true,
        paging: true, // Enable pagination
        pageLength: 10, // Number of rows per page
        ajax: {
            url: `{{route('retails.receivable-payments.get-lists')}}`, // Replace with your route
            type: 'GET',
            data: function (d) {
                // Add filter data to the request
                d.start_date = $('#start-date').val();
                d.end_date = $('#end-date').val();
                d.customer = $('#filter-customer').val();
                d.invoice_number = $('#filter-invoice').val();
                d.payment_method = $('#filter-payment-method').val();
            },
            dataSrc: function(json) {
                return json.data; // Map the 'data' field
            }
        },
        columns: [
            {
                data: 'customer_name',
                name: 'customer_name'
            },
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'invoice_number',
                name: 'invoice_number'
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
                        payment_method = `<span class="badge bg-success text-dark">TRANSFER</span>`
                    }

                    return payment_method;
                }
            },
            {
                data: 'amount',
                name: 'amount',
                className: 'text-end'
            },
            {
                data: null, // No direct field from the server
                name: 'action',
                orderable: false, // Disable ordering for this column
                searchable: false, // Disable searching for this column
                render: function(data, type, row) {
                    return `
                        <div class="text-center">
                            <a href="/retails/receivable-payments/edit/${row.id}" class="btn btn-sm btn-light btn-active-light-primary" title="Edit"><i class="fa-solid fa-edit"></i>Edit</a>
                        </div>
                    `;
                }
            }
        ]
    });

    $('#start-date, #end-date, #filter-customer, #filter-invoice, #filter-payment-method').on('change', function () {
        table.draw(); // Trigger DataTable redraw with updated filter values
    });
});
</script>
@endsection
