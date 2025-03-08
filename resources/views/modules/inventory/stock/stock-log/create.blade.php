@extends('layouts.main')

@section('main-content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Stock Logs</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Inventory Management</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Stock Logs</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Create</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <div class="card">
                        <div class="card-body pt-10">

                            <!-- Display Errors --> <!-- ADDED -->
                            @if ($errors->any()) <!-- ADDED -->
                                <div class="alert alert-danger"> <!-- ADDED -->
                                    <ul> <!-- ADDED -->
                                        @foreach ($errors->all() as $error) <!-- ADDED -->
                                            <li>{{ $error }}</li> <!-- ADDED -->
                                        @endforeach <!-- ADDED -->
                                    </ul> <!-- ADDED -->
                                </div> <!-- ADDED -->
                            @endif <!-- ADDED -->

                            <form class="w-[60%]" method="POST" action="{{route('stock-logs.save')}}" enctype="multipart/form-data">
                                @csrf
                                <input class="form-control form-control-md form-control-solid" type="hidden" name="stock_id" id="stock_id" value="{{$stockId}}" />
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Referensi</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-md form-control-solid"
                                                        type="text" name="reference" id="reference" value=""/>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Masuk</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-md form-control-solid"
                                                        type="number" name="in_quantity" id="in_quantity" step="0.01" value="" placeholder="0.00"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Keluar</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-md form-control-solid"
                                                        type="number" name="out_quantity" id="out_quantity" step="0.01" value="" placeholder="0.00"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="flex justify-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('stock-logs.index', ['stockId' => $stockId]) }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
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
    document.addEventListener("DOMContentLoaded", function () {
        const inQuantity = document.getElementById("in_quantity");
        const outQuantity = document.getElementById("out_quantity");

        function toggleInputs() {
            let inValue = parseFloat(inQuantity.value.trim()) || 0;
            let outValue = parseFloat(outQuantity.value.trim()) || 0;

            if (inValue > 0) {
                outQuantity.disabled = true;
            } else {
                outQuantity.disabled = false;
            }

            if (outValue > 0) {
                inQuantity.disabled = true;
            } else {
                inQuantity.disabled = false;
            }
        }

        inQuantity.addEventListener("input", toggleInputs);
        outQuantity.addEventListener("input", toggleInputs);
    });

</script>
@endsection
