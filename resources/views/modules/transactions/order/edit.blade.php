@extends('layouts.main')

@section('main-content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Order Details</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Order Lists</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <div class="card">
                        <div class="card-body pt-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Kode Transaksi</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid" type="text" name="email" id="email" value="{{$detailTransaction->code}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Tanggal</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid" type="text" name="email" id="email" value="{{$detailTransaction->transaction_date}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Customer</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid" type="text" name="email" id="email" value="{{$detailTransaction->customer_name}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Metode Pembayaran</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid" type="text" name="email" id="email" value="{{$detailTransaction->payment_method}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Total Transaksi (Rp)</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid" type="text" name="email" id="email" value="{{$detailTransaction->total_amount}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Status</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid" type="text" name="email" id="email" value="{{$detailTransaction->status}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--begin::Product List-->
                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                    <thead>
                                        <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-175px">Nama Product</th>
                                            <th class="min-w-100px text-end">Harga (Per Kg)</th>
                                            <th class="min-w-70px text-end">Jumlah (Kg)</th>
                                            <th class="min-w-100px text-end">Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach($detailItems as $detail)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Thumbnail-->
                                                    <a href="apps/ecommerce/catalog/edit-product.html"
                                                        class="symbol symbol-50px">
                                                        <span class="symbol-label"
                                                            style="background-image:url(assets/media//stock/ecommerce/1.png);"></span>
                                                    </a>
                                                    <!--end::Thumbnail-->
                                                    <!--begin::Title-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fw-bold text-gray-600 text-hover-primary">{{$detail->code}}</a>
                                                        <div class="fs-7 text-muted">{{$detail->name}}</div>
                                                    </div>
                                                    <!--end::Title-->
                                                </div>
                                            </td>
                                            <td class="text-end">{{$detail->base_price}}</td>
                                            <td class="text-end">{{$detail->quantity}}</td>
                                            <td class="text-end">{{$detail->sell_price}}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3" class="text-end">Subtotal</td>
                                            <td class="text-end">{{$detailTransaction->total_amount}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end">Biaya Pengiriman</td>
                                            <td class="text-end">0.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="fs-3 text-gray-900 text-end">Grand Total</td>
                                            <td class="text-gray-900 fs-3 fw-bolder text-end">{{$detailTransaction->total_amount}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Product List-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection
