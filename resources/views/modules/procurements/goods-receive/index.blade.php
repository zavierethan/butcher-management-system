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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Goods Receive</h1>
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
                        <li class="breadcrumb-item text-muted">Goods Receive</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Primary button-->
                    <a href="#" class="btn btn-sm fw-bold btn-secondary" data-bs-toggle="modal" data-bs-target="#kt_modal_export_filter">Export ke Excel</a>
                    <a href="{{route('procurement.goods-receive.create')}}" class="btn btn-sm fw-bold btn-primary">New</a>
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
                                        <div class="text-gray-500 fs-7 me-2">Supplier</div>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <select
                                            class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto"
                                            data-control="select2" data-hide-search="true"
                                            data-dropdown-css-class="w-150px" data-placeholder="Select an option" id="supplier">
                                            <option value=" " selected="selected">Show All</option>
                                            @foreach($suppliers as $supplier)
                                            <option value="{{$supplier->id}}"> {{$supplier->name}}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                    <div class="d-flex align-items-center fw-bold">
                                        <!--begin::Label-->
                                        <div class="text-gray-500 fs-7 me-2">Kategori</div>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <select
                                            class="form-select form-select-transparent text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto"
                                            data-control="select2" data-hide-search="true"
                                            data-dropdown-css-class="w-150px" data-placeholder="Select an option"
                                            id="category">
                                            <option></option>
                                            <option value=" " selected="selected">Show All</option>
                                            <option value="PR">PR</option>
                                            <option value="OP">OP</option>
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                    <!--begin::Search-->
                                    <div class="position-relative my-1">
                                        <i
                                            class="ki-duotone ki-magnifier fs-2 position-absolute top-50 translate-middle-y ms-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="text" data-kt-purchase-order-table-filter="search"
                                            class="form-control form-control-solid w-250px ps-15"
                                            placeholder="Nomor Pembelian" />
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <!--begin::Filters-->
                            </div>
                        </div>
                        <!--begin::Card body-->
                        <div class="card-body pt-0 overflow-x-auto">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_goods_received_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Nomor Pembelian</th>
                                        <th class="min-w-125px">Tanggal Penerimaan</th>
                                        <th class="min-w-125px">Supplier</th>
                                        <th class="min-w-125px">Category</th>
                                        <th class="min-w-125px">Diterima Oleh</th>
                                        <th class="min-w-125px">Status</th>
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
    let table = $("#kt_goods_received_table").DataTable({
        order: [[0, 'desc']],
        processing: true,
        serverSide: true,
        paging: true, // Enable pagination
        pageLength: 10, // Number of rows per page
        ajax: {
            url: `{{route('procurement.goods-receive.get-lists')}}`, // Replace with your route
            type: 'GET',
            data: function (d) {
                // Add filter data to the request
                d.start_date = $('#start-date').val();
                d.end_date = $('#end-date').val();
                d.supplier = $('#supplier').val();
                d.category = $('#category').val();
            },
            dataSrc: function (json) {
                return json.data; // Map the 'data' field
            }
        },
        columns: [
            { data: 'purchase_order_number', name: 'purchase_order_number' },
            { data: 'received_date', name: 'received_date' },
            { data: 'name', name: 'name' },
            { data: 'category', name: 'category' },
            { data: 'received_by', name: 'received_by' },
            {
                data: 'status',
                name: 'status',
                render: function(data, type, row) {
                    var status = "";

                    if (row.status == "pending") {
                        status = `<span class="badge bg-warning text-white">PENDING</span>`
                    }

                    if (row.status == "goods_received") {
                        status = `<span class="badge bg-success text-white">Goods Received</span>`
                    }

                    return status;
                }
            },
            {
                data: null, // No direct field from the server
                name: 'action',
                orderable: false, // Disable ordering for this column
                searchable: false, // Disable searching for this column
                render: function (data, type, row) {
                    return `
                        <div class="text-center">
                            <a href="/procurement/goods-receive/edit/${row.id}" class="btn btn-sm btn-light btn-active-light-primary">Lihat</a>
                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary" title="Sync Jurnal"><i class="fa-solid fa-arrow-right-arrow-left"></i></a>
                        <div>
                    `;
                }
            }
        ]
    });

    $('[data-kt-purchase-order-table-filter="search"]').on('keyup', function() {
        const searchTerm = $(this).val(); // Get the value from the search input
        table.search(searchTerm).draw(); // Trigger the search and refresh the DataTable
    });

    $('#start-date, #end-date, #supplier, #category').on('change', function() {
        table.draw();
    });
</script>
@endsection

