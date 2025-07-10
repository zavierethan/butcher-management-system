@extends('layouts.main')

@section('main-content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Stock Limit
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Inventory</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Stock Limit</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <div class="card">
                        <div class="card-header border-0 pt-6">
                            <div class="card-toolbar"></div>
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
                                        <div class="col-md-6">
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
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Limit Stock</label>
                                                <div class="position-relative mb-3">
                                                    <!-- Make the input field inline editable -->
                                                    <input class="form-control form-control-md form-control-solid"
                                                           value="{{ $stockHeader->max_quantity }}" id="stock-limit"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="separator my-5"></div>
                            <div class="text-end">
                                <a href="{{ route('stocks.index') }}" class="btn btn-danger">Back</a>
                                <button id="save-limit" class="btn btn-primary">Save Limit</button>
                            </div>
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
    // Handle the save limit logic
    document.getElementById('save-limit').addEventListener('click', function() {
        const stockId = document.getElementById('stock-id').value;
        const limit = document.getElementById('stock-limit').value;

        // Send the updated limit to the backend using fetch API
        fetch("{{ route('stocks.save-limit') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                stock_id: stockId,
                limit: limit
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Stock limit updated successfully!");
            } else {
                alert("Failed to update stock limit.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("There was an error updating the stock limit.");
        });
    });
</script>
@endsection
