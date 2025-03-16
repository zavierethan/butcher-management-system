@extends('layouts.main')

@section('main-content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Stock Opnames
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Inventory</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Stock Opnames</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('stocks.create-opname', ['stockId' => $stockId]) }}" class="btn btn-sm fw-bold btn-primary">
                        New
                    </a>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <div class="card">
                        <div class="card-header border-0 pt-6">
                            <div class="card-title"></div>
                            <div class="card-toolbar">
                                <div class="d-flex align-items-center position-relative my-1">
                                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
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
                                            </div>
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <!--end::Card body-->
                        <div class="card-body pt-0 overflow-x-auto">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_opnames_table">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Tanggal</th>
                                        <th class="min-w-125px">Kuantitas Opname</th>
                                        <th class="min-w-125px">Tanggal Pembaruan</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    const stockId = "{{ $stockId }}";

    if (stockId) {
        const table = $("#kt_opnames_table").DataTable({
            processing: true,
            order: [[0, 'desc']],
            serverSide: true,
            paging: true,
            pageLength: 10,
            ajax: {
                url: `{{ route('stocks.get-opname-list', ['stockId' => $stockId]) }}`,
                type: 'GET',
                data: function(d) {
                    d.searchTerm = $('[data-kt-customer-table-filter="search"]').val();
                }
            },
            columns: [
                { data: 'date', name: 'date' },
                { 
                    data: 'quantity', 
                    name: 'quantity',
                    render: function(data, type, row) {
                        return `<input type="number" class="form-control editable-quantity" 
                                data-id="${row.id}" value="${parseFloat(data).toFixed(2)}" 
                                min="0" step="0.01">`;
                    }
                },
                { data: 'updated_at', name: 'updated_at' },
            ]
        });

        // Handle quantity update
        $('#kt_opnames_table').on('change', '.editable-quantity', function() {
            let opnameId = $(this).data('id');
            let newQuantity = parseFloat($(this).val()).toFixed(2);

            if (isNaN(newQuantity) || newQuantity < 0) {
                Swal.fire("Error", "Invalid quantity value.", "error");
                return;
            }

            $.ajax({
                url: `{{ route('stocks.update-opname') }}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: opnameId,
                    quantity: newQuantity
                },
                success: function(response) {
                    Swal.fire("Success", "Quantity updated successfully!", "success");
                    table.ajax.reload(null, false); 
                },
                error: function(xhr) {
                    Swal.fire("Error", "Failed to update quantity.", "error");
                }
            });
        });

        // Trigger search on keyup
        $('[data-kt-customer-table-filter="search"]').on('keyup', function() {
            table.draw();
        });
    } else {
        console.error("Stock ID is missing.");
    }
</script>

@endsection
