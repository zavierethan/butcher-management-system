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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Stock Logs</h1>
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
                    <a href="{{route('stock-logs.create', ['stockId' => $stockId])}}" class="btn btn-sm fw-bold btn-primary">Input New Log</a>
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search" />
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--begin::Card body-->
                        <div class="card-body pt-0 overflow-x-auto">
                            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Header</h1>
                            
                                <div class="card">
                                    <div class="card-body pt-10">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <div class="mb-1">
                                                        <label class="form-label fw-bold fs-6 mb-2">Nama Produk</label>
                                                        <div class="position-relative mb-3">
                                                            <input class="form-control form-control-md form-control-solid"
                                                                type="text" value="{{ $stockHeader->product_code }} - {{ $stockHeader->product_name }}" readonly />
                                                            <input class="form-control form-control-md form-control-solid"
                                                                type="hidden" value="{{ $stockHeader->id }}" id="stock-id"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="separator my-5"></div>
                                                <div class="fv-row mb-5">
                                                    <div class="mb-1">
                                                        <label class="form-label fw-bold fs-6 mb-2">Cabang</label>
                                                        <div class="position-relative mb-3">
                                                            <input class="form-control form-control-md form-control-solid"
                                                                value="{{ $stockHeader->branch_code }} - {{ $stockHeader->branch_name }}" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="separator my-5"></div>
                                                <div class="fv-row mb-5">
                                                    <div class="mb-1">
                                                        <label class="form-label fw-bold fs-6 mb-2">Tanggal</label>
                                                        <div class="position-relative mb-3">
                                                            <input class="form-control form-control-md form-control-solid"
                                                                type="text" value="{{ $stockHeader->date }}" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <div class="mb-1">
                                                        <label class="form-label fw-bold fs-6 mb-2">Kuantitas Awal</label>
                                                        <div class="position-relative mb-3">
                                                            <input class="form-control form-control-md form-control-solid"
                                                                value="{{ $stockHeader->quantity }}" readonly />
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
                                                <div class="fv-row mb-5">
                                                    <div class="mb-1">
                                                        <label class="form-label fw-bold fs-6 mb-2">Kuantitas Opname</label>
                                                        <div class="position-relative mb-3">
                                                            <input class="form-control form-control-md form-control-solid"
                                                                value="{{ $stockHeader->opname_quantity }}" id="opname-quantity" />
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="separator my-5"></div>
                                                <div class="text-end">
                                                    <a href="{{ route('stocks.index') }}" class="btn btn-danger">Back</a>
                                                    <a href="#" class="btn btn-primary" id="btn-update"
                                                        data-branch-id="{{ $stockHeader->branch_id }}"
                                                        data-product-id="{{ $stockHeader->product_id }}"
                                                        data-date="{{ $stockHeader->date }}">Update</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <!--end::Card body-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 overflow-x-auto">
                            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Logs</h1>
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_products_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Referensi</th>
                                        <th class="min-w-125px">Masuk</th>
                                        <th class="min-w-125px">Keluar</th>
                                        <th class="min-w-125px">Waktu</th>
                                        {{-- <th class="text-center min-w-70px">Actions</th> --}}
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
    const stockId = "{{ $stockId }}"; // Pass the rowId from the Blade template

    $("#kt_products_table").DataTable({
        processing: true,
        serverSide: true,
        paging: true, // Enable pagination
        pageLength: 10, // Number of rows per page
        ajax: {
            url: `{{route('stock-logs.get-lists', ['stockId' => $stockId])}}`, // Replace with your route
            type: 'GET',
            data: function (d) {
                d.stockId = stockId; // Add rowId to the request payload
            },
            dataSrc: function (json) {
                return json.data; // Map the 'data' field
            }
        },
        columns: [
            { data: 'reference', name: 'reference' },
            { data: 'in_quantity', name: 'in_quantity' },
            { data: 'out_quantity', name: 'out_quantity' },
            { data: 'date', name: 'date' },
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
        columns: [
            { data: 'product_name', name: 'product_name' },
            { data: 'branch_name', name: 'branch_name' },
            { data: 'quantity', name: 'quantity' },
            {
                data: 'opname_quantity',
                name: 'opname_quantity',
                render: function (data, type, row) {
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
            { data: 'date', name: 'date' },
        ],
    });

    $(document).ready(function() {
        $('#btn-update').on('click', function(e) {
            e.preventDefault();
            let branchId = this.getAttribute('data-branch-id');
            let productId = this.getAttribute('data-product-id');
            let date = this.getAttribute('data-date');

            let opname_quantity = $("#opname-quantity").val();
            let id = $("#stock-id").val();

            Swal.fire({
                title: 'Apakah anda yakin untuk memperbaharui kuantitas opname?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update Opname'
            }).then((result) => {
                if (result.isConfirmed) {

                    const payload = {
                        id: id,
                        opname_quantity: opname_quantity,
                        branch_id: branchId,
                        product_id: productId,
                        date: date
                    };

                    console.log(payload)

                    $.ajax({
                        url: `{{route('stocks.update-opname')}}`,
                        type: 'POST',
                        contentType: 'application/json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: JSON.stringify(payload),
                        success: function(response) {
                            Swal.fire({
                                title: 'Suceess !',
                                text: 'Data berhasil di perbaharui',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        },
                        error: function(xhr, status, error) {
                            let errorMessage = "An unexpected error occurred"; // Default fallback message

                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message; // Get the Laravel error message
                            }

                            Swal.fire(
                                'Error!',
                                errorMessage,
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
