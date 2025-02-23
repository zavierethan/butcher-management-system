@extends('layouts.main')
@section('css')

@endsection

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
                        Transaction Lists</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Transactions</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Transaction Lists</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Secondary button-->
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
                                    <div class="d-flex align-items-center fw-bold">
                                        <!--begin::Label-->
                                        <div class="text-gray-500 fs-7 me-2">Customer</div>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <select
                                            class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto"
                                            data-control="select2" data-hide-search="true"
                                            data-dropdown-css-class="w-150px" data-placeholder="Select an option" id="customer">
                                            <option value=" " selected="selected">Show All</option>
                                            @foreach($customers as $customer)
                                            <option value="{{$customer->id}}"> {{$customer->name}}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                    <!--begin::Destination-->
                                    <div class="d-flex align-items-center fw-bold">
                                        <!--begin::Label-->
                                        <div class="text-gray-500 fs-7 me-2">Pembayaran</div>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <select
                                            class="form-select form-select-transparent text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto"
                                            data-control="select2" data-hide-search="true"
                                            data-dropdown-css-class="w-150px" data-placeholder="Select an option" id="payment-method">
                                            <option value=" " selected="selected">Show All</option>
                                            <option value="1">Tunai</option>
                                            <option value="2">Piutang</option>
                                            <option value="3">Transfer</option>
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                    <!--end::Destination-->
                                    <!--begin::Status-->
                                    <div class="d-flex align-items-center fw-bold">
                                        <!--begin::Label-->
                                        <div class="text-gray-500 fs-7 me-2">Status</div>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <select
                                            class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto"
                                            data-control="select2" data-hide-search="true"
                                            data-dropdown-css-class="w-150px" data-placeholder="Select an option" id="status">
                                            <option></option>
                                            <option value=" " selected="selected">Show All</option>
                                            <option value="1">Lunas</option>
                                            <option value="2">Pending</option>
                                            <option value="3">Return</option>
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                    <!--end::Status-->
                                    <!--begin::Store-->
                                    <div class="d-flex align-items-center fw-bold">
                                        <!--begin::Label-->
                                        <div class="text-gray-500 fs-7 me-2">Store</div>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <select
                                            class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto"
                                            data-control="select2" data-hide-search="true"
                                            data-dropdown-css-class="w-150px" data-placeholder="Select an option" id="branch-id" <?php echo (Auth::user()->group_id == 10) ? "disabled" : ""; ?>>
                                            <option value=" " selected="selected">Show All</option>
                                            @foreach($branches as $branch)
                                            <option value="{{$branch->id}}" <?php echo ($branch->id == Auth::user()->branch_id) ? "selected" : ""; ?>> {{$branch->name}}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                    <!--end::Status-->
                                    <!--begin::Search-->
                                    <div class="position-relative my-1">
                                        <i
                                            class="ki-duotone ki-magnifier fs-2 position-absolute top-50 translate-middle-y ms-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="text" data-kt-customer-table-filter="search"
                                            class="form-control form-control-solid w-250px ps-15"
                                            placeholder="kode Transaksi" />
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <!--begin::Filters-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 overflow-x-auto">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_transactions_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">KODE TRANSAKSI</th>
                                        <th class="min-w-125px">TANGGAL</th>
                                        <th class="min-w-125px">CUSTOMER</th>
                                        <th class="min-w-125px">JENIS PEMBAYARAN</th>
                                        <th class="min-w-125px">TOTAL TRANSAKSI</th>
                                        <th class="min-w-125px">STATUS</th>
                                        <th class="min-w-125px">DIBUAT OLEH</th>
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

<div class="modal fade" id="kt_modal_export_filter" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header pb-0 border-0 justify-content-end">
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                <!--begin::Heading-->
                <div class="text-center mb-13">
                    <!--begin::Title-->
                    <h1 class="mb-3">Export Filters</h1>
                    <!--end::Title-->
                </div>
                <div class="fv-row mb-5">
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Tanggal Mulai</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="date"
                                id="start-date" />
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="fv-row mb-5">
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Tanggal Akhir</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="date" id="end-date" />
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="fv-row mb-5">
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Store / Cabang</label>
                        <div class="position-relative mb-3">
                            <select class="form-select form-select-solid" data-control="select2"
                                data-placeholder="Pilih Store" id="branc-id">
                                @foreach($branches as $branch)
                                <option value="{{$branch->id}}"
                                    <?php echo ($branch->id == Auth::user()->branch_id) ? "selected" : ""; ?>>
                                    {{$branch->code}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="flex justify-content-center">
                    <button type="button" class="btn btn-primary" id="btn-form-export">Submit</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        id="btn-form-close">Batal</button>
                </div>
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
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
                d.start_date = $('#start-date').val();
                d.end_date = $('#end-date').val();
                d.customer = $('#customer').val();
                d.payment_method = $('#payment-method').val();
                d.status = $('#status').val();
                d.branch_id = $('#branch-id').val();
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
                data: 'payment_method',
                name: 'payment_method',
                render: function(data, type, row) {
                    var paymentMethod = "";

                    if (row.payment_method == 1) {
                        paymentMethod = "Tunai"
                    }

                    if (row.payment_method == 2) {
                        paymentMethod = "Piutang"
                    }

                    if (row.payment_method == 3) {
                        paymentMethod = "Transfer"
                    }

                    return paymentMethod;
                }
            },
            {
                data: 'total_amount',
                name: 'total_amount'
            },
            {
                data: 'status',
                name: 'status',
                render: function(data, type, row) {
                    var status = "";

                    if (row.status == 1) {
                        status = `<span class="badge bg-success text-dark">Lunas</span>`
                    }

                    if (row.status == 2) {
                        status = `<span class="badge bg-warning text-dark">Pending</span>`
                    }

                    if (row.status == 3) {
                        status = `<span class="badge bg-danger text-dark">Batal</span>`
                    }

                    return status;
                }
            },
            {
                data: 'created_by',
                name: 'created_by'
            },
            {
                data: null, // No direct field from the server
                name: 'action',
                orderable: false, // Disable ordering for this column
                searchable: false, // Disable searching for this column
                render: function(data, type, row) {
                    return `
                        <div class="text-center">
                            <a href="/orders/print-thermal/${row.id}" class="btn btn-sm btn-light btn-active-light-primary" target="_blank" title="Cetak Faktur">Test Print</a>
                            <a href="/orders/receipt/${row.id}" class="btn btn-sm btn-light btn-active-light-primary" target="_blank" title="Cetak Faktur">Cetak PDF</a>
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

    $("#btn-form-export").on("click", function() {
        const start_date = $("#start-date").val() || "";
        const end_date = $("#end-date").val() || "";
        const payment_method = $("#payment-method").val() || "";
        const status = $("#status").val() || "";
        const branch_id = $("#branch-id").val() || "";

        $.ajax({
            url: `{{url('/orders/export')}}`,
            type: 'GET',
            data: {
                start_date: start_date,
                end_date: end_date,
                payment_method: payment_method,
                status: status,
                branch_id: branch_id
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
                link.download = 'transaction-reports.xlsx'; // Set the filename
                document.body.appendChild(link); // Append link to the body
                link.click(); // Trigger the download
                document.body.removeChild(link); // Clean up the DOM

                Swal.fire({
                    title: 'Success!',
                    text: 'Transaction report exported successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                });
            },
            error: function(xhr, status, error) {
                Swal.fire('Error!', 'Failed to export the transaction report.', 'error');
            },
        });

    });
});
</script>
@endsection
