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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Product Details</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Master Data</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Product Details</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Edit</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
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
                    <div class="card">
                        <div class="card-body pt-10">
                            <form class="w-[60%]" method="POST" action="{{route('product-details.update')}}" >
                                @csrf
                                <input class="form-control form-control-md form-control-solid" type="hidden" name="id" id="id" value="{{$productDetails->id}}" />
                                <input class="form-control form-control-md form-control-solid" type="hidden" name="product_id" id="product_id" value="{{$productDetails->product_id}}" />

                                <!--  -->
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Harga</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-md form-control-solid" type="text" name="price" id="price" value="{{ $productDetails->price }}" />
                                            <input type="hidden" name="branch_id" value="{{ $productDetails->branch_id }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Diskon</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-md form-control-solid" type="text" name="discount" id="discount" value="{{ $productDetails->discount }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <!--begin::Input group-->
                                <div class="row row-cols-lg-2 g-10">
                                    <div class="col">
                                        <div class="fv-row mb-9">
                                            <label class="fs-6 fw-semibold mb-2 required">Start Diskon</label>
                                            <input class="form-control form-control-solid" name="calendar_event_start_date" placeholder="Pick a start date" id="kt_calendar_datepicker_start_date" value="{{ $productDetails->start_period }}" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="fv-row mb-9">
                                            <label class="fs-6 fw-semibold mb-2 required">End Diskon</label>
                                            <input class="form-control form-control-solid" name="calendar_event_end_date" placeholder="Pick an end date" id="kt_calendar_datepicker_end_date" value="{{ $productDetails->end_period }}"/>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <div class="separator my-5"></div>
                                <div class="flex justify-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{route('products.edit', ['id' => $productDetails->product_id])}}" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
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
<!-- Include Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr('#kt_calendar_datepicker_start_date', {
            dateFormat: "Y-m-d",
            enableTime: false
        });
        flatpickr('#kt_calendar_datepicker_end_date', {
            dateFormat: "Y-m-d",
            enableTime: false
        });
    });
</script>

@endsection
