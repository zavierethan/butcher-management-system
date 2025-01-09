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
                        Purchase Requests</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Procurements</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Purchase Requests</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Primary button-->
                    <a href="javascript(0);" class="btn btn-sm fw-bold btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_export_filter">Export ke Excel</a>
                    <a href="{{route('procurement.purchase-request.create')}}"
                        class="btn btn-sm fw-bold btn-primary">New</a>
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
                                    <input type="text" data-kt-purchase-request-table-filter="search"
                                        class="form-control form-control-solid w-250px ps-15" placeholder="Search" />
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--begin::Card body-->
                        <div class="card-body pt-0 overflow-x-auto">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_purchase_request_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Nomor Request</th>
                                        <th class="min-w-125px">Tanggal</th>
                                        <th class="min-w-125px">Alokasi</th>
                                        <th class="min-w-125px">PIC</th>
                                        <th class="min-w-125px">Kategori</th>
                                        <th class="min-w-125px">Nominal Pengajuan</th>
                                        <th class="min-w-125px">Nominal Realisasi</th>
                                        <th class="min-w-125px">Status Approval</th>
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
let table = $("#kt_purchase_request_table").DataTable({
    order: [
        [0, 'desc']
    ],
    processing: true,
    serverSide: true,
    paging: true, // Enable pagination
    pageLength: 10, // Number of rows per page
    ajax: {
        url: `{{route('procurement.purchase-request.get-lists')}}`, // Replace with your route
        type: 'GET',
        dataSrc: function(json) {
            return json.data; // Map the 'data' field
        }
    },
    columns: [{
            data: 'request_number',
            name: 'request_number'
        },
        {
            data: 'request_date',
            name: 'request_date'
        },
        {
            data: 'alocation',
            name: 'alocation'
        },
        {
            data: 'pic',
            name: 'pic'
        },
        {
            data: 'category',
            name: 'category'
        },
        {
            data: 'nominal_application',
            name: 'nominal_application'
        },
        {
            data: 'nominal_realization',
            name: 'nominal_realization'
        },
        {
            data: 'status',
            name: 'status',
            render: function(data, type, row) {
                var status = "";

                if (row.status == "pending") {
                    status = `<span class="badge bg-warning text-white">PENDING</span>`
                }

                if (row.status == "approve") {
                    status = `<span class="badge bg-success text-white">APPROVE</span>`
                }

                if (row.status == "decline") {
                    status = `<span class="badge bg-danger text-white">DECLINE</span>`
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
                            <a href="/procurement/purchase-request/edit/${row.id}" class="btn btn-sm btn-light btn-active-light-primary">Approval</a>
                        <div>
                    `;
            }
        }
    ]
});

$('[data-kt-purchase-request-table-filter="search"]').on('keyup', function() {
    const searchTerm = $(this).val(); // Get the value from the search input
    table.search(searchTerm).draw(); // Trigger the search and refresh the DataTable
});

$("#btn-form-export").on("click", function() {

    const start_date = $("#start-date").val();
    const end_date = $("#end-date").val();
    const branch_id = $("#branch-id").val();

    $.ajax({
        url: `{{url('procurement/purchase-request/export')}}`,
        type: 'GET',
        data: {
            start_date: start_date,
            end_date: end_date,
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
</script>
@endsection
