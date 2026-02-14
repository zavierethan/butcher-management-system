@extends('layouts.main')

@section('css')
<style>
/* From Uiverse.io by SouravBandyopadhyay */
.hourglassBackground {
    position: relative;
    background-color: rgb(69, 201, 9);
    height: 130px;
    width: 130px;
    border-radius: 50%;
    margin: 30px auto;
    top: 190px;
    z-index: 999999;
}

.hourglassContainer {
    position: absolute;
    top: 30px;
    left: 40px;
    width: 50px;
    height: 70px;
    -webkit-animation: hourglassRotate 2s ease-in 0s infinite;
    animation: hourglassRotate 2s ease-in 0s infinite;
    transform-style: preserve-3d;
    perspective: 1000px;
    z-index: 999999;
}

.hourglassContainer div,
.hourglassContainer div:before,
.hourglassContainer div:after {
    transform-style: preserve-3d;
}

@-webkit-keyframes hourglassRotate {
    0% {
        transform: rotateX(0deg);
    }

    50% {
        transform: rotateX(180deg);
    }

    100% {
        transform: rotateX(180deg);
    }
}

@keyframes hourglassRotate {
    0% {
        transform: rotateX(0deg);
    }

    50% {
        transform: rotateX(180deg);
    }

    100% {
        transform: rotateX(180deg);
    }
}

.hourglassCapTop {
    top: 0;
}

.hourglassCapTop:before {
    top: -25px;
}

.hourglassCapTop:after {
    top: -20px;
}

.hourglassCapBottom {
    bottom: 0;
}

.hourglassCapBottom:before {
    bottom: -25px;
}

.hourglassCapBottom:after {
    bottom: -20px;
}

.hourglassGlassTop {
    transform: rotateX(90deg);
    position: absolute;
    top: -16px;
    left: 3px;
    border-radius: 50%;
    width: 44px;
    height: 44px;
    background-color: #999999;
}

.hourglassGlass {
    perspective: 100px;
    position: absolute;
    top: 32px;
    left: 20px;
    width: 10px;
    height: 6px;
    background-color: #999999;
    opacity: 0.5;
}

.hourglassGlass:before,
.hourglassGlass:after {
    content: '';
    display: block;
    position: absolute;
    background-color: #999999;
    left: -17px;
    width: 44px;
    height: 28px;
}

.hourglassGlass:before {
    top: -27px;
    border-radius: 0 0 25px 25px;
}

.hourglassGlass:after {
    bottom: -27px;
    border-radius: 25px 25px 0 0;
}

.hourglassCurves:before,
.hourglassCurves:after {
    content: '';
    display: block;
    position: absolute;
    top: 32px;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background-color: #333;
    animation: hideCurves 2s ease-in 0s infinite;
}

.hourglassCurves:before {
    left: 15px;
}

.hourglassCurves:after {
    left: 29px;
}

@-webkit-keyframes hideCurves {
    0% {
        opacity: 1;
    }

    25% {
        opacity: 0;
    }

    30% {
        opacity: 0;
    }

    40% {
        opacity: 1;
    }

    100% {
        opacity: 1;
    }
}

@keyframes hideCurves {
    0% {
        opacity: 1;
    }

    25% {
        opacity: 0;
    }

    30% {
        opacity: 0;
    }

    40% {
        opacity: 1;
    }

    100% {
        opacity: 1;
    }
}

.hourglassSandStream:before {
    content: '';
    display: block;
    position: absolute;
    left: 24px;
    width: 3px;
    background-color: white;
    -webkit-animation: sandStream1 2s ease-in 0s infinite;
    animation: sandStream1 2s ease-in 0s infinite;
}

.hourglassSandStream:after {
    content: '';
    display: block;
    position: absolute;
    top: 36px;
    left: 19px;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-bottom: 6px solid #fff;
    animation: sandStream2 2s ease-in 0s infinite;
}

@-webkit-keyframes sandStream1 {
    0% {
        height: 0;
        top: 35px;
    }

    50% {
        height: 0;
        top: 45px;
    }

    60% {
        height: 35px;
        top: 8px;
    }

    85% {
        height: 35px;
        top: 8px;
    }

    100% {
        height: 0;
        top: 8px;
    }
}

@keyframes sandStream1 {
    0% {
        height: 0;
        top: 35px;
    }

    50% {
        height: 0;
        top: 45px;
    }

    60% {
        height: 35px;
        top: 8px;
    }

    85% {
        height: 35px;
        top: 8px;
    }

    100% {
        height: 0;
        top: 8px;
    }
}

@-webkit-keyframes sandStream2 {
    0% {
        opacity: 0;
    }

    50% {
        opacity: 0;
    }

    51% {
        opacity: 1;
    }

    90% {
        opacity: 1;
    }

    91% {
        opacity: 0;
    }

    100% {
        opacity: 0;
    }
}

@keyframes sandStream2 {
    0% {
        opacity: 0;
    }

    50% {
        opacity: 0;
    }

    51% {
        opacity: 1;
    }

    90% {
        opacity: 1;
    }

    91% {
        opacity: 0;
    }

    100% {
        opacity: 0;
    }
}

.hourglassSand:before,
.hourglassSand:after {
    content: '';
    display: block;
    position: absolute;
    left: 6px;
    background-color: white;
    perspective: 500px;
}

.hourglassSand:before {
    top: 8px;
    width: 39px;
    border-radius: 3px 3px 30px 30px;
    animation: sandFillup 2s ease-in 0s infinite;
}

.hourglassSand:after {
    border-radius: 30px 30px 3px 3px;
    animation: sandDeplete 2s ease-in 0s infinite;
}

@-webkit-keyframes sandFillup {
    0% {
        opacity: 0;
        height: 0;
    }

    60% {
        opacity: 1;
        height: 0;
    }

    100% {
        opacity: 1;
        height: 17px;
    }
}

@keyframes sandFillup {
    0% {
        opacity: 0;
        height: 0;
    }

    60% {
        opacity: 1;
        height: 0;
    }

    100% {
        opacity: 1;
        height: 17px;
    }
}

@-webkit-keyframes sandDeplete {
    0% {
        opacity: 0;
        top: 45px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    1% {
        opacity: 1;
        top: 45px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    24% {
        opacity: 1;
        top: 45px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    25% {
        opacity: 1;
        top: 41px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    50% {
        opacity: 1;
        top: 41px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    90% {
        opacity: 1;
        top: 41px;
        height: 0;
        width: 10px;
        left: 20px;
    }
}

@keyframes sandDeplete {
    0% {
        opacity: 0;
        top: 45px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    1% {
        opacity: 1;
        top: 45px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    24% {
        opacity: 1;
        top: 45px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    25% {
        opacity: 1;
        top: 41px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    50% {
        opacity: 1;
        top: 41px;
        height: 17px;
        width: 38px;
        left: 6px;
    }

    90% {
        opacity: 1;
        top: 41px;
        height: 0;
        width: 10px;
        left: 20px;
    }
}
</style>
@endsection

@section('main-content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid mt-5">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container">
                <!--begin::Layout-->
                <div class="row mb-3">
                    <!--begin::Content-->
                    <div class="col-md-8">
                        <!--begin::Pos food-->
                        <div class="card card-p-0 border-0">
                            <!--begin::Body-->
                            <div class="card-body p-3">
                                <div class="d-flex">
                                    <div class="d-flex align-items-center position-relative">
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
                                        <input type="text" data-product-filter="search"
                                            class="form-control form-control-solid ps-15" placeholder="Cari Product"
                                            id="product-search" />
                                    </div>
                                    <div class="ms-auto">
                                        <!-- <input type="text" class="form-control form-control-solid"
                                            placeholder="Nama Butcherees" id="butcher-name" /> -->

                                        <select class="form-select form-select-solid" data-control="select2"
                                            data-placeholder="Pilih Butcherees" id="butcher-name">
                                            @foreach($butcherees as $butcher)
                                            <option value="{{$butcher->name}}">{{$butcher->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--end: Card Body-->
                        </div>
                        <!--end::Pos food-->
                    </div>
                    <!--end::Content-->
                    <!--begin::Sidebar-->
                    <div class="col-md-4">
                        <!--begin::Pos order-->
                        <div class="card card-p-0 border-0" id="kt_pos_form">
                            <!--begin::Body-->
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-md-1">
                                        <button class="btn btn-md" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_add_customer"><i
                                                class="fa-solid fa-user-plus"></i></button>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-select form-select-solid" data-control="select2"
                                            data-placeholder="Pilih Customer" name="customer" id="customer">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select form-select-solid" data-control="select2"
                                            data-placeholder="Pilih Store" id="branch-id" disabled>
                                            @foreach($branches as $branch)
                                            <option value="{{$branch->id}}"
                                                <?php echo ($branch->id == Auth::user()->branch_id) ? "selected" : ""; ?>>
                                                {{$branch->code}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--end: Card Body-->
                        </div>
                        <!--end::Pos order-->
                    </div>
                    <!--end::Sidebar-->
                </div>
                <div class="row">
                    <!--begin::Content-->
                    <div class="col-md-8">
                        <!--begin::Pos food-->
                        <div class="card card-p-0 border-0">
                            <!--begin::Body-->
                            <div class="card-body p-5">
                                <div class="hourglassBackground" id="product-loader">
                                    <div class="hourglassContainer">
                                        <div class="hourglassCurves"></div>
                                        <div class="hourglassCapTop"></div>
                                        <div class="hourglassGlassTop"></div>
                                        <div class="hourglassSand"></div>
                                        <div class="hourglassSandStream"></div>
                                        <div class="hourglassCapBottom"></div>
                                        <div class="hourglassGlass"></div>
                                    </div>
                                </div>
                                <div class="row overflow-y-auto" style="height: 745px;" id="product-list">

                                </div>
                            </div>
                            <!--end: Card Body-->
                        </div>
                        <!--end::Pos food-->
                    </div>
                    <!--end::Content-->
                    <!--begin::Sidebar-->
                    <div class="col-md-4">
                        <!--begin::Pos order-->
                        <div class="card card-flush bg-body" id="kt_pos_form">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <div class="d-flex mb-3">
                                    <button class="btn btn-link text-danger text-decoration-none" id="btn-clear-all"><i
                                            class="fas fa-trash text-red"></i> Bersihkan Semua</button>
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-0">
                                <!--begin::Table container-->
                                <div class="overflow-y-auto" style="height: 300px;" id="cart-item">

                                </div>
                                <!--end::Table container-->
                                <!--begin::Summary-->
                                <div class="bg-success rounded-3 p-6 mb-11">
                                    <!--begin::Summary Grid-->
                                    <div class="fs-6 fw-bold text-white">
                                        <!-- Subtotal Row -->
                                        <div class="row align-items-center pb-3 mb-3" style="border-bottom: 2px dotted rgba(255,255,255,0.5);">
                                            <div class="col-8">Subtotal</div>
                                            <div class="col-4 text-end" id="subtotal-amount">Rp. 0</div>
                                        </div>
                                        <!-- Total Discounts Row -->
                                        <div class="row align-items-center pb-3 mb-3" style="border-bottom: 2px dotted rgba(255,255,255,0.5);">
                                            <div class="col-8">Total Discounts</div>
                                            <div class="col-4 text-end" id="total-discount">Rp. 0</div>
                                        </div>
                                        <!-- Shipping Cost Row -->
                                        <div class="row align-items-center pb-3 mb-3" style="border-bottom: 2px dotted rgba(255,255,255,0.5);">
                                            <div class="col-8">
                                                Ongkos Kirim
                                                <a href="javascript(0);" data-bs-toggle="modal" data-bs-target="#kt_modal_add_shipping_cost">
                                                    <i class="fas fa-edit text-white ms-2"></i>
                                                </a>
                                            </div>
                                            <div class="col-4 text-end" id="shipping-cost">Rp. 0</div>
                                        </div>
                                        <!-- Total Bayar Row -->
                                        <div class="row align-items-center">
                                            <div class="col-8">Total Bayar</div>
                                            <div class="col-4 text-end" id="total-amount">Rp. 0</div>
                                        </div>
                                    </div>
                                    <!--end::Summary Grid-->
                                </div>
                                <!--end::Summary-->
                                <!--begin::Payment Method-->
                                <div class="m-0">
                                    <h5 class="fw-bold text-gray-800 mb-5">Metode Pemesanan</h5>
                                    <div class="d-flex flex-equal gap-2 gap-xxl-9 px-0 mb-3" id="ordering-method">
                                        <div class="form-check form-check-custom form-check-solid mb-2">
                                            <input class="form-check-input" type="radio" value="2"
                                                name="ordering_method" checked>
                                            <label class="form-check-label">Offline</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-2">
                                            <input class="form-check-input" type="radio" value="1"
                                                name="ordering_method">
                                            <label class="form-check-label">Online</label>
                                        </div>
                                    </div>

                                    <h5 class="fw-bold text-gray-800 mb-5">Metode Pengerjaan</h5>
                                    <div class="d-flex flex-equal gap-2 gap-xxl-9 px-0 mb-3" id="working-method">
                                        <div class="form-check form-check-custom form-check-solid mb-2">
                                            <input class="form-check-input" type="radio" value="1"
                                                name="working_method" checked>
                                            <label class="form-check-label">Direct</label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-2">
                                            <input class="form-check-input" type="radio" value="2"
                                                name="working_method">
                                            <label class="form-check-label">Processing Order</label>
                                        </div>
                                    </div>

                                    <h5 class="fw-bold text-gray-800 mb-5">Catatan</h5>
                                    <div class="d-flex flex-equal gap-2 gap-xxl-9 px-0 mb-3" id="customer-notes">
                                        <textarea class="form-control" id="notes"></textarea>
                                    </div>
                                    <!--begin::Title-->
                                    <h5 class="fw-bold text-gray-800 mb-5">Metode Pembayaran</h5>
                                    <!--end::Title-->
                                    <!--begin::Radio group-->
                                    <div class="d-flex flex-equal gap-5 gap-xxl-9 px-0 mb-12" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]" id="payment-method">
                                        <!--begin::Radio-->
                                        <label
                                            class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-100 border-active-primary btn-active-light-primary w-100 px-4"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" name="payment_method" value="1"
                                                id="payment-method-cash" />
                                            <!--end::Input-->
                                            <!--begin::Icon-->
                                            <i class="ki-duotone ki-dollar fs-2hx mb-2 pe-0">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            <!--end::Icon-->
                                            <!--begin::Title-->
                                            <span class="fs-7 fw-bold d-block">Tunai</span>
                                            <!--end::Title-->
                                        </label>
                                        <!--end::Radio-->
                                        <!--begin::Radio-->
                                        <label
                                            class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-100 border-active-primary btn-active-light-primary w-100 px-4"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" name="payment_method" value="2" />
                                            <!--end::Input-->
                                            <!--begin::Icon-->
                                            <i class="ki-duotone ki-credit-cart fs-2hx mb-2 pe-0">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <!--end::Icon-->
                                            <!--begin::Title-->
                                            <span class="fs-7 fw-bold d-block">Piutang</span>
                                            <!--end::Title-->
                                        </label>
                                        <!--end::Radio-->
                                        <!--begin::Radio-->
                                        <label
                                            class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-100 border-active-primary btn-active-light-primary w-100 px-4"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" name="payment_method" value="3" />
                                            <!--end::Input-->
                                            <!--begin::Icon-->
                                            <i class="ki-duotone ki-delivery fs-2hx mb-2 pe-0">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <!--end::Icon-->
                                            <!--begin::Title-->
                                            <span class="fs-7 fw-bold d-block">Transfer</span>
                                            <!--end::Title-->
                                        </label>
                                        <!--end::Radio-->
                                    </div>
                                    <!--end::Radio group-->
                                    <div id="form-nominal">
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Masukan Nominal
                                                    Bayar</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" id="nominal-cash" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Nominal Kembali</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" id="nominal-return" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="form-ref-transfer">
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <div class="position-relative mb-3">
                                                    <div class="fv-row">
                                                        <label class="form-label fw-bold fs-6 mb-2">Direct
                                                            Transfer</label>
                                                        <div class="d-flex flex-equal gap-2 gap-xxl-9 px-0">
                                                            <div
                                                                class="form-check form-check-custom form-check-solid mb-2">
                                                                <input class="form-check-input" type="radio" value="1"
                                                                    name="is_direct_transfer" checked>
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div
                                                                class="form-check form-check-custom form-check-solid mb-2">
                                                                <input class="form-check-input" type="radio" value="0"
                                                                    name="is_direct_transfer">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Ref. Bukti Transfer</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" id="transfer-ref" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Lampiran</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="file" id="transfer-attch" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--begin::Actions-->
                                    <button class="btn btn-success fs-1 w-100 py-4" id="process-transaction">Proses
                                        Transaksi</button>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Payment Method-->
                            </div>
                            <!--end: Card Body-->
                        </div>
                        <!--end::Pos order-->
                    </div>
                    <!--end::Sidebar-->
                </div>
                <!--end::Layout-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>

<!--begin::Modal - Edit Product-->
<div class="modal fade" id="kt_modal_edit_product_item" tabindex="-1" aria-hidden="true">
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
                    <h1 class="mb-3">Edit Product</h1>
                    <!--end::Title-->
                </div>
                <div class="fv-row mb-5">
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Nama Product</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="text" id="product_name"
                                readonly />
                            <input class="form-control form-control-md form-control-solid" type="hidden"
                                id="product_id" />
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="fv-row mb-5">
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Harga Product</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="text"
                                id="product_price" />
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="fv-row mb-5">
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Diskon</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="number" id="diskon" />
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="fv-row mb-5">
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Quantity (kg)</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="text"
                                id="quantity" />
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="flex justify-content-center">
                    <button type="button" class="btn btn-primary" id="update-item">Update</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn-close">Cancel</button>
                </div>
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

<!--begin::Modal - Edit Product-->
<div class="modal fade" id="kt_modal_add_product_item" tabindex="-1" aria-hidden="true">
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
                    <h1 class="mb-3">Add to Cart</h1>
                    <!--end::Title-->
                </div>
                <div class="fv-row mb-5">
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Nama Product</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="text" id="product_name"
                                readonly />
                            <input class="form-control form-control-md form-control-solid" type="hidden"
                                id="product_id" />
                            <input class="form-control form-control-md form-control-solid" type="hidden"
                                id="stock_id" />
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="fv-row mb-5">
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Harga Product</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="text"
                                id="product_price" />
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="fv-row mb-5">
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Diskon</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="number" id="diskon" />
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="fv-row mb-5">
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Quantity (kg)</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="text"
                                id="quantity" />
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="flex justify-content-center">
                    <button type="button" class="btn btn-primary" id="add-item">Tambahkan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn-close">Cancel</button>
                </div>
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

<!--begin::Modal - Add Customer-->
<div class="modal fade" id="kt_modal_add_customer" tabindex="-1" aria-hidden="true">
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
                    <h1 class="mb-3">Tambah Customer</h1>
                    <!--end::Title-->
                </div>
                <div class="fv-row mb-5">
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Nama Customer</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="text"
                                id="customer-name" />
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="fv-row mb-5">
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">No. Hp</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="text"
                                id="customer-phone-number" />
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="fv-row mb-5">
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Catatan</label>
                        <div class="position-relative mb-3">
                            <textarea class="form-control form-control-md form-control-solid" type="text"
                                id="transaction-notes" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="flex justify-content-center">
                    <button type="button" class="btn btn-primary" id="btn-form-customer">Simpan</button>
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

<!--begin::Modal - Add Customer-->
<div class="modal fade" id="kt_modal_add_discount" tabindex="-1" aria-hidden="true">
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
                    <h1 class="mb-3">Discount</h1>
                    <!--end::Title-->
                </div>
                <div class="fv-row mb-5">
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Masukan Nominal Discount</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="number"
                                id="discount-value" />
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="flex justify-content-center">
                    <button type="button" class="btn btn-primary" id="btn-form-discount">Simpan</button>
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

<!--begin::Modal - Add Customer-->
<div class="modal fade" id="kt_modal_add_shipping_cost" tabindex="-1" aria-hidden="true">
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
                    <h1 class="mb-3">Ongkos Kirim</h1>
                    <!--end::Title-->
                </div>
                <div class="fv-row mb-5">
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Masukan Nominal Ongkos Kirim</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="number"
                                id="shipment-cost-value" />
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="flex justify-content-center">
                    <button type="button" class="btn btn-primary" id="btn-form-shipping-cost">Simpan</button>
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
    $("#product-loader").show();
    $("#form-nominal").hide();
    $("#form-ref-transfer").hide();
    getProductList();
    getCustomers();

    $(document).on('click', '.product', function() {
        var productId = $(this).data('product-id');
        var stockId = $(this).data('stock-id');
        var productName = $(this).data('product-name');
        var productPrice = parseFloat($(this).data('product-price')); // Ensure price is a number
        var productDiscount = parseFloat($(this).data('product-discount')) | 0;

        $("#kt_modal_add_product_item #product_id").val(productId);
        $("#kt_modal_add_product_item #stock_id").val(stockId);
        $("#kt_modal_add_product_item #product_name").val(productName);
        $("#kt_modal_add_product_item #product_price").val(productPrice);
        $("#kt_modal_add_product_item #diskon").val(productDiscount == 0 ? '' : productDiscount);

    });

    $(document).on('keyup', '#product-search', function(e) {
        var searchQuery = $(this).val();
        getProductList(searchQuery);
    });

    $(document).on('click', '.remove-item', function(e) {

        e.preventDefault();
        // Get the product ID from the button's data attribute
        const productId = $(this).data('product-id');

        Swal.fire({
            title: 'Apakah anda yakin ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Remove the product item from the cart
                $(`#product-id-${productId}`).remove();
                calculateTotals();
            }
        });
    });

    $(document).on('click', '.edit-item', function(e) {

        e.preventDefault();

        const productId = $(this).data('product-id');
        const productName = $(this).data('product-name');
        const productPrice = $(this).data('product-price');
        const productDiscount = $(this).data('product-discount');
        const productQuantity = $(this).data('product-quantity');

        $("#kt_modal_edit_product_item #product_id").val(formatThausand(productId));
        $("#kt_modal_edit_product_item #product_name").val(productName);
        $("#kt_modal_edit_product_item #product_price").val(productPrice);
        $("#kt_modal_edit_product_item #diskon").val(productDiscount);
        $("#kt_modal_edit_product_item #quantity").val(productQuantity);
    });

    $(document).on('click', '#add-item', function(e) {

        e.preventDefault();

        var productId = $("#kt_modal_add_product_item #product_id").val();
        var stockId = $("#kt_modal_add_product_item #stock_id").val();
        var productName = $("#kt_modal_add_product_item #product_name").val();
        var productQuantity = parseFloat($("#kt_modal_add_product_item #quantity").val());
        var productPrice = parseFloat($("#kt_modal_add_product_item #product_price").val()); // Ensure price is a number
        var productDiscount = parseFloat($("#kt_modal_add_product_item #diskon").val()) | 0;
        var productImgUrl = $(this).find('img').attr('src');

        // Validation for productPrice and quantity
        if (!productPrice || productPrice <= 0) {
            Swal.fire({
                title: 'Warning!',
                text: 'Harga Product tidak boleh kosong atau 0',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            });
            return;
        }

        if (!productQuantity || productQuantity <= 0) {
            Swal.fire({
                title: 'Warning!',
                text: 'Quantity tidak boleh kosong atau 0',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            });
            return;
        }

        // Check if the product already exists in the cart
        var existingProduct = $(`#product-id-${productId}`);

        if (existingProduct.length > 0) {
            // Update quantity and subtotal for existing product
            const quantityElement = existingProduct.find('.qty');
            const currentQuantity = parseFloat($(existingProduct).find('.quantity-value').text()) || parseFloat(productQuantity) || 1;
            const newQuantity = currentQuantity + parseFloat(productQuantity);
            quantityElement.text(`${newQuantity}`);

            // Update stored quantity value
            existingProduct.find('.quantity-value').text(newQuantity);

            // Update discount per unit storage
            existingProduct.find('.discount-per-unit').text(productDiscount);

            // Update base price storage
            existingProduct.find('.base-price').text(productPrice);

            // Recalculate totals
            const grossTotal = productPrice * newQuantity;
            const totalDiscount = productDiscount * newQuantity;
            const netTotal = grossTotal - totalDiscount;

            // Update the gross total display
            const quantityDisplay = existingProduct.find('.d-flex.justify-content-between.mb-2.pb-2');
            quantityDisplay.find('small:last-child').text(formatThausand(grossTotal));

            // Update or recreate discount section
            const discountSection = existingProduct.find('.discount-section');

            if (productDiscount > 0) {
                if (discountSection.length > 0) {
                    // Update existing discount section
                    discountSection.find('.discount-total').text(newQuantity);
                    discountSection.find('small.fw-bold').text(formatThausand(totalDiscount));
                } else {
                    // Create discount section if it doesn't exist
                    const discountHTML = `<div class="mb-2 pb-2 discount-section" style="border-bottom: 1px solid #dee2e6;">
                        <small class="text-muted">Discount: <span class="discount-total">${newQuantity}</span> kg x ${formatThausand(productDiscount)} = </small>
                        <small class="fw-bold text-danger">${formatThausand(totalDiscount)}</small>
                    </div>`;
                    quantityDisplay.after(discountHTML);
                }
            } else {
                // Remove discount section if discount is 0
                discountSection.remove();
            }

            const priceElement = existingProduct.find('.price');
            priceElement.text(formatThausand(mround(netTotal)));
        } else {
            // Add new product to the cart

            var grossPrice = mround(productPrice * productQuantity);
            var totalDiscount = productDiscount * Math.floor(productQuantity);
            var nettPrice = grossPrice - totalDiscount;

            var productItem = `<div class="cart-item-lists p-3 mb-2" id="product-id-${productId}" style="border: 1px solid #e9ecef; border-radius: 0.375rem; background-color: #f8f9fa;">
                <!-- Hidden data fields -->
                <div class="d-none product-id">${productId}</div>
                <div class="d-none stock-id">${stockId}</div>
                <div class="d-none base-price">${productPrice}</div>
                <div class="d-none discount-per-unit">${totalDiscount}</div>
                <div class="d-none quantity-value">${productQuantity}</div>
                <div class="d-none gross-price">${grossPrice}</div>

                <!-- Row 1: Product Name + Edit & Delete Icons -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 fw-bold text-gray-800">${productName}</h6>
                    <div class="d-flex gap-1">
                        <a href="#" class="btn btn-sm btn-link edit-item p-1 me-1" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_product_item" data-product-id="${productId}" data-product-name="${productName}" data-product-price="${productPrice}" data-product-discount="${productDiscount}" data-product-quantity="${productQuantity}">
                            <i class="fas fa-edit text-success" style="font-size: 14px;"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-link remove-item p-1" data-product-id="${productId}">
                            <i class="fas fa-trash text-danger" style="font-size: 14px;"></i>
                        </a>
                    </div>
                </div>

                <!-- Row 2: Price Calculation (Quantity × Base Price) - ALWAYS SHOWN -->
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2" style="border-bottom: 1px dotted #dee2e6;">
                    <small class="text-muted"><span class="qty">${productQuantity}</span> x ${formatThausand(productPrice)}</small>
                    <small class="fw-bold text-dark">Gross: ${formatThausand(grossPrice)}</small>
                </div>

                <!-- Row 3: Discount Badge (CONDITIONAL - Only if discount > 0) -->
                ${productDiscount > 0 ? `<div class="mb-2 pb-2 discount-section" style="border-bottom: 1px solid #dee2e6;">
                    <small class="text-muted">Discount: <span class="discount-total">${productQuantity}</span> kg x ${formatThausand(productDiscount)} = </small>
                    <small class="fw-bold text-danger">${formatThausand(totalDiscount)}</small>
                </div>` : ''}

                <!-- Row 4: Final Total Price -->
                <div class="d-flex justify-content-between align-items-center pt-2">
                    <span class="fw-bold text-dark">Net Total:</span>
                    <span class="fw-bold price" style="color: #198754; font-size: 1.05rem;">${formatThausand(nettPrice)}</span>
                </div>
            </div>`;

            $('#cart-item').append(productItem);
        }

        // Recalculate totals
        calculateTotals();

        $('#kt_modal_add_product_item').modal('hide');

        $("#kt_modal_add_product_item #product_id").val("");
        $("#kt_modal_add_product_item #product_name").val("");
        $("#kt_modal_add_product_item #quantity").val("");
        $("#kt_modal_add_product_item #product_price").val("");
        $("#kt_modal_add_product_item #diskon").val("");

    });

    $(document).on('click', '#update-item', function(e) {

        e.preventDefault();

        const productId = $("#kt_modal_edit_product_item #product_id").val();
        const quantity = $("#kt_modal_edit_product_item #quantity").val();
        const productPrice = $("#kt_modal_edit_product_item #product_price").val();
        const discountPerUnit = $("#kt_modal_edit_product_item #diskon").val();

        // Validation for productPrice and quantity
        if (!productPrice || productPrice <= 0) {
            Swal.fire({
                title: 'Warning!',
                text: 'Harga Product tidak boleh kosong atau 0',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            });
            return;
        }

        if (!quantity || quantity <= 0) {
            Swal.fire({
                title: 'Warning!',
                text: 'Quantity tidak boleh kosong atau 0',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            });
            return;
        }

        // Check if the product already exists in the cart
        var existingProduct = $(`#product-id-${productId}`);

        if (existingProduct.length > 0) {
            const newQuantity = parseFloat(quantity);
            const newDiscountPerUnit = parseFloat(discountPerUnit) || 0;
            const basePrice = parseFloat(productPrice);

            // Update quantity display and storage
            const quantityElement = existingProduct.find('.qty');
            quantityElement.text(`${newQuantity}`);
            existingProduct.find('.quantity-value').text(newQuantity);

            // Update discount per unit storage
            existingProduct.find('.discount-per-unit').text(newDiscountPerUnit);

            // Update base price storage
            existingProduct.find('.base-price').text(basePrice);

            // Recalculate totals
            const grossTotal = basePrice * newQuantity;
            const totalDiscount = newDiscountPerUnit * newQuantity;
            const netTotal = grossTotal - totalDiscount;

            // Update the gross total display (Quantity x Price)
            const quantityDisplay = existingProduct.find('.d-flex.justify-content-between.mb-2.pb-2');
            quantityDisplay.find('small:last-child').text(formatThausand(grossTotal));

            // Update or recreate discount section
            const discountSection = existingProduct.find('.discount-section');

            if (newDiscountPerUnit > 0) {

                console.log('Updating discount section =>' + newDiscountPerUnit);
                if (discountSection.length > 0) {
                    // Update existing discount section
                    discountSection.find('.discount-total').text(newQuantity);
                    discountSection.find('small.fw-bold').text(formatThausand(totalDiscount));
                } else {
                    // Create discount section if it doesn't exist
                    const discountHTML = `<div class="mb-2 pb-2 discount-section" style="border-bottom: 1px solid #dee2e6;">
                        <small class="text-muted">Discount: <span class="discount-total">${newQuantity}</span> kg x ${formatThausand(newDiscountPerUnit)} = </small>
                        <small class="fw-bold text-danger">${formatThausand(totalDiscount)}</small>
                    </div>`;
                    quantityDisplay.after(discountHTML);
                }
            } else {
                // Remove discount section if discount is 0
                discountSection.remove();
            }

            // Update the final price display
            const priceElement = existingProduct.find('.price');
            priceElement.text(formatThausand(mround(netTotal)));
        }

        calculateTotals();
        $('#kt_modal_edit_product_item').modal('hide');

    });

    $(document).on('click', '#btn-form-discount', function(e) {
        let value = $("#discount-value").val();
        $('#discount').text(formatThausand(value));
        calculateTotals();
        $('#kt_modal_add_discount').modal('hide');
        $("#discount-value").val(0);
    });

    $(document).on('click', '#btn-form-shipping-cost', function(e) {
        let value = $("#shipment-cost-value").val();
        $('#shipping-cost').text(formatThausand(value));
        calculateTotals();
        $('#kt_modal_add_shipping_cost').modal('hide');
        $("#shipment-cost-value").val(0);
    });

    $(document).on('keyup', '#nominal-cash', function () {

        // Ambil nominal cash (hanya digit)
        let nominalCash = parseInt($(this).val().replace(/[^\d]/g, ''), 10) || 0;

        // Ambil total
        let totalAmount = parseInt(
            $('#total-amount').text().replace(/[^\d]/g, ''),
            10
        ) || 0;

        // Format ulang cash input
        $(this).val(formatThausand(nominalCash));

        // Hitung return (boleh negatif)
        let nominalReturn = nominalCash - totalAmount;

        // Tampilkan hasil (support minus)
        $("#nominal-return").val(formatThausand(nominalReturn));
    });


    $(document).on('click', '#process-transaction', function(e) {
        e.preventDefault();

        if (validate()) {
            Swal.fire({
                title: 'Apakah anda yakin untuk memproses transaksi ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Proses Transaksi'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();

                    const products = [];

                    $('.cart-item-lists').each(function() {
                        const productId = $(this).find('.product-id').text();
                        const stockId = $(this).find('.stock-id').text();
                        const price = $(this).find('.price').text().replace(/[^\d]/g, '');
                        const basePrice = $(this).find('.base-price').text().replace(/[^\d]/g, '');
                        const discountPerUnit = $(this).find('.discount-per-unit').text().replace(/[^\d]/g, '') | 0;
                        const quantity = $(this).find('.quantity-value').text().replace(/[^\d]/g, '');

                        // Calculate total discount for this item
                        const totalItemDiscount = parseFloat(discountPerUnit) * parseFloat(quantity);

                        products.push({
                            product_id: productId,
                            stock_id: stockId,
                            base_price: basePrice,
                            price: price,
                            discount: totalItemDiscount,
                            quantity: quantity,
                        });
                    });

                    const discount = $('#discount').text().replace(/[^\d]/g, '') | 0;
                    const shippingCost = $('#shipping-cost').text().replace(/[^\d]/g, '') | 0;
                    const totalAmount = $('#subtotal-amount').text().replace(/[^\d]/g, '');
                    const paymentMethod = $('#payment-method').find('input[type="radio"]:checked').val();
                    const customerId = $('#customer').val();
                    const butcherName = $('#butcher-name').val();
                    const branchId = $('#branch-id').val();
                    const nominalCash = $('#nominal-cash').val().replace(/[^\d]/g, '') | 0;
                    const nominalReturn = $('#nominal-return').val().replace(/[^\d]/g, '') | 0;
                    const transferType = $('#form-ref-transfer').find('input[type="radio"]:checked').val();
                    const transferRef = $('#transfer-ref').val();
                    const transferAttch = $('#transfer-attch')[0]?.files[0]; // Get file from input

                    const orderingMethod = $('#ordering-method').find('input[type="radio"]:checked').val();
                    const workingMethod = $('#working-method').find('input[type="radio"]:checked').val();

                    const notes = $('#notes').val();

                    // Append form fields
                    formData.append('transaction_date', new Date().toISOString());
                    formData.append('customer_name', customerId);
                    formData.append('total_amount', totalAmount);
                    formData.append('payment_method', paymentMethod);
                    formData.append('customer_id', customerId);
                    formData.append('butcher_name', butcherName);
                    formData.append('discount', discount);
                    formData.append('shipping_cost', shippingCost);
                    formData.append('branch_id', branchId);
                    formData.append('nominal_cash', nominalCash);
                    formData.append('nominal_return', nominalReturn);
                    formData.append('transfer_type', transferType);
                    formData.append('transfer_ref', transferRef);
                    formData.append('ordering_method', orderingMethod);
                    formData.append('working_method', workingMethod);
                    formData.append('notes', notes);

                    if (transferAttch) {
                        formData.append('transfer_attch', transferAttch);
                    }

                    // Append products array as JSON string
                    formData.append('details', JSON.stringify(products));

                    console.log(formData)

                    $.ajax({
                        url: `{{route('transactions.store')}}`,
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: formData,
                        success: function(response) {
                            Swal.fire({
                                title: 'Success!',
                                text: `Transaksi berhasil di simpan dengan Nomor ${response.transaction_code}`,
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'Cetak Nota',
                                cancelButtonText: 'Tidak',
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: `/orders/print-thermal/${response.transaction_id}`,
                                        type: "GET",
                                        dataType: "json",
                                        success: function(
                                        response) {
                                            if (response.code ==
                                                200) {
                                                var printerName =
                                                    "{{ ($settings) ? $settings->printer_name : '' }}";

                                                if (printerName ===
                                                    '') {
                                                    Swal.fire({
                                                        title: 'Gagal mencetak nota',
                                                        text: 'Nama Printer tidak ditemukan. harap periksa pengaturan pada sistem.',
                                                        icon: 'warning',
                                                        timer: 5000,
                                                        showConfirmButton: false
                                                    });

                                                    $(".cart-item-lists")
                                                        .remove();
                                                    calculateTotals
                                                        ();
                                                    return;
                                                }

                                                printReceipt(
                                                    printerName,
                                                    response
                                                    );

                                                Swal.fire({
                                                    title: 'Nota Berhasil Dicetak!',
                                                    icon: 'success',
                                                    timer: 5000,
                                                    showConfirmButton: false
                                                });

                                                $(".cart-item-lists")
                                                    .remove();
                                                calculateTotals
                                                ();
                                            } else {
                                                Swal.fire({
                                                    title: 'Gagal Mencetak Nota',
                                                    text: response
                                                        .message ||
                                                        'Terjadi kesalahan saat mencetak nota.',
                                                    icon: 'error'
                                                });

                                                $(".cart-item-lists")
                                                    .remove();
                                                calculateTotals
                                                ();
                                            }
                                        },
                                        error: function(xhr, status,
                                            error) {
                                            Swal.fire({
                                                title: 'Error!',
                                                text: xhr
                                                    .responseJSON
                                                    .message,
                                                icon: 'error'
                                            });
                                        }
                                    });
                                } else if (result.dismiss === Swal
                                    .DismissReason.cancel) {
                                    $(".cart-item-lists").remove();
                                    calculateTotals();
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            if (xhr.status === 400) {
                                Swal.fire({
                                    title: 'Warning !',
                                    text: xhr.responseJSON.message,
                                    icon: 'warning',
                                    allowOutsideClick: false
                                });
                            } else {
                                Swal.fire('Error!', error, 'error');
                            }
                        }
                    });
                }

            });
        }
    });

    $(document).on('click', '#btn-form-customer', function(e) {
        e.preventDefault();

        let customer_name = $("#customer-name").val();
        let customer_phone_number = $("#customer-phone-number").val();
        let transaction_notes = $("#transaction-notes").val();

        // Validation for productPrice and quantity
        if (!customer_name) {
            Swal.fire({
                title: 'Warning!',
                text: 'Nama Customer tidak boleh kosong',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            });
            return;
        }

        if (!customer_phone_number) {
            Swal.fire({
                title: 'Warning!',
                text: 'Nomor Telepon Customer tidak boleh kosong ',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            });
            return;
        }

        const payload = {
            name: customer_name,
            phone_number: customer_phone_number,
            transaction_notes: transaction_notes
        };

        $.ajax({
            url: `{{url('/api/customers/save')}}`,
            type: 'POST',
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify(payload),
            success: function(response) {
                Swal.fire({
                    title: 'Suceess !',
                    text: 'Customer berhasil di tambahkan',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $('#kt_modal_add_customer').modal('hide');
                    $("#customer-name").val("");
                    $("#customer-phone-number").val("");

                    getCustomers();
                });
            },
            error: function(xhr, status, error) {
                Swal.fire(
                    'Error!',
                    error,
                    'error'
                )
            }
        });
    });

    $("#btn-clear-all").on('click', function() {
        Swal.fire({
            title: 'Apakah anda yakin ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya bersihakan semua item'
        }).then((result) => {
            if (result.isConfirmed) {
                // Remove the product item from the cart
                $(".cart-item-lists").remove();
                calculateTotals();
            }
        });
    });

    $('#btn-close').on('click', function() {
        $("#kt_modal_edit_product_item #product_id").val("");
        $("#kt_modal_edit_product_item #product_name").val("");
        $("#kt_modal_edit_product_item #product_price").val("");
        $('#kt_modal_edit_product_item').modal('hide');
    });

    $('#payment-method .btn-check').on('change', function() {

        if ($(this).val() === '1' && $(this).is(':checked')) {
            $("#form-nominal").show();
        } else {
            $("#form-nominal").hide();
        }

        if ($(this).val() === '3' && $(this).is(':checked')) {
            $("#form-ref-transfer").show();
        } else {
            $("#form-ref-transfer").hide();
        }
    });

    $("#kt_modal_add_product_item #quantity, #kt_modal_edit_product_item #quantity").on("keyup", function () {
        let value = $(this).val();

        console.log("Original Input: " + value);

        value = value
            .replace(/[^0-9.]/g, "")
            .replace(/(\..*)\./g, "$1")
            .replace(/^(\d+)(\.\d{0,2})?.*$/, "$1$2");

        $(this).val(value);
    });

    function getProductList(param) {
        $("#product-loader").show();
        $.ajax({
            url: `/api/products`, // Laravel route to fetch products
            type: 'GET',
            data: {
                q: param,
                branch_id: `{{Auth::user()->branch_id}}`
            },
            dataType: 'json',
            success: function(response) {
                // Loop through each product in the JSON response

                var data = response.data;
                $('.product-l').remove();
                data.forEach(function(product) {

                    console.log(product.url_path)

                    let productImg = product.url_path ?
                        "storage/" + product.url_path :
                        "{{ asset('assets/media/products/product-default.png') }}";

                    // Construct HTML for each product
                    const discountHTML = product.discount !== 0 && !isNaN(parseFloat(product
                            .discount)) ?
                        `<span>Diskon</span> <span class="fs-6 text-muted">${formatThausand(parseFloat(product.discount))}</span>` :
                        '';

                    const productItem = `<div class="col-md-3 mb-3 product-l"><div class="card p-6 pb-5 product" data-stock-id="${product.stock_id}" data-product-id="${product.id}" data-product-name="${product.name}" data-product-price="${product.price}" data-product-discount="${product.discount}" data-bs-toggle="modal" data-bs-target="#kt_modal_add_product_item">
                                            <div class="card-body text-center">
                                                <div class="mb-2">
                                                    <div class="text-center">
                                                        <span class="fw-bold text-gray-800 cursor-pointer">${product.name}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="text-success text-end fw-bold">${formatThausand(parseFloat(product.price))}</span>
                                                </div>
                                                ${discountHTML}
                                            </div>
                                        </div>`;
                    // Append the product to the product list container
                    $('#product-list').append(productItem);
                });

                $("#product-loader").hide();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching products:', error);
            }
        });
    }

    $('#customer').on('change', function() {
        let customerId = $(this).val();
        $.ajax({
            url: `/api/customer-notes/`+customerId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var notes = response.data;

                $('#notes').text(notes || '');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching products:', error);
            }
        });
    });

    function getCustomers() {
        $.ajax({
            url: `/api/customers`,
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#customer').html('<option value="">Pilih Customer</option>');
            },
            success: function(response) {
                var data = response.data;
                const selectBox = $('#customer');

                data.forEach(item => {
                    const option = new Option(item.name, item.id);
                    if (item.id === 1) {
                        option.selected = true; // Select the option with id 8
                    }
                    selectBox.append(option);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching products:', error);
            }
        });
    }

    function getCustomerNotes(customerId) {
        $.ajax({
            url: `/customer-notes/`+customerId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var data = response.data;
            },
            error: function(xhr, status, error) {
                console.error('Error fetching products:', error);
            }
        });
    }

    function calculateTotals() {
        let subtotal = 0;
        let totalProductDiscount = 0;

        // Iterate through each product in the cart and sum up their subtotals and discounts
        $('.cart-item-lists').each(function() {
            const priceText = $(this).find('.gross-price').text().replace(/[^\d]/g, '');
            const price = parseFloat(priceText) || 0;
            subtotal += price;

            // Extract discount per unit and quantity, then calculate total discount
            const discountPerUnit = parseFloat($(this).find('.discount-per-unit').text()) || 0;
            const quantity = parseFloat($(this).find('.quantity-value').text()) || 0;

            // Total discount for this item = discount_per_unit × quantity
            const itemTotalDiscount = discountPerUnit * quantity;
            totalProductDiscount += discountPerUnit;
        });

        // Update subtotal in the UI
        $('#subtotal-amount').text(formatThausand(subtotal));

        // Add global discount to product discounts
        const globalDiscount = $('#discount').text().replace(/[^\d]/g, '') | 0;
        const totalDiscount = totalProductDiscount + parseFloat(globalDiscount);

        // Display total discount
        $('#total-discount').text(formatThausand(totalDiscount));

        const shippingCost = $('#shipping-cost').text().replace(/[^\d]/g, '') | 0;
        console.log("Total Product Discount: " + totalProductDiscount);
        console.log("Global Discount: " + globalDiscount);
        console.log("Total Discount: " + totalDiscount);

        const totalAmount = (subtotal - totalDiscount) + parseFloat(shippingCost);
        $('#total-amount').text(formatThausand(totalAmount));

        $("#nominal-cash").val("");
        $("#nominal-return").val("");
    }

    function formatCurrency(amount) {
        const formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD', // USD is the currency code for US Dollar
            minimumFractionDigits: 0, // Optional, remove decimals if not needed
        });
        return formatter.format(amount);
    }

    function formatThausand(value, decimalLength) {
        if (value === null || value === undefined || value === '') return '';

        // Ensure numeric
        let number = parseFloat(value.toString().replace(/[^0-9,-]/g, '').replace(',', ','));
        if (isNaN(number)) return '';

        return number.toLocaleString('en-US', {
            minimumFractionDigits: decimalLength,
            maximumFractionDigits: decimalLength
        });
    }

    function unformatThausand(value) {
        if (value === null || value === undefined || value === '') return 0;

        // Ensure numeric
        let number = parseFloat(value.toString().replace(/[^0-9,-]/g, '').replace(',', '.'));
        if (isNaN(number)) return 0;

        return number;
    }

    function mround(value) {
        let number = parseInt(value.toString().replace(/[^\d-]/g, ''), 10) || 0;

        let base = Math.floor(number / 1000) * 1000;
        let remainder = number % 1000;

        if (remainder > 500) {
            return base + 1000;
        } else if (remainder < 500) {
            return base;
        } else {
            // tepat 500
            return base + 500;
        }
    }

    function formatNumber(numStr) {
        let cleaned = numStr.toString().replace(/[^\d.]/g, '');
        const parts = cleaned.split('.');
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join('.');
    }

    function validate() {

        const paymentMethod = $('#payment-method').find('input[type="radio"]:checked').val();
        const customerId = $('#customer').val();
        const butcherName = $('#butcher-name').val();
        const branchId = $('#branch-id').val();
        const transferRef = $('#transfer-ref').val();
        const cartItems = $('#cart-item .cart-item-lists');

        let toReturn = true;

        console.log("Cart Item Length:", cartItems.length);

        // === Validation rules ===

        // Cart must not be empty
        if (cartItems.length === 0) {
            Swal.fire({
                title: 'Warning!',
                text: 'Cart tidak boleh kosong',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            });
            toReturn = false;
        }

        // Payment method must be selected
        if (!paymentMethod) {
            Swal.fire({
                title: 'Warning!',
                text: 'Metode Pembayaran tidak boleh kosong',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            });
            toReturn = false;
        }

        // Customer must be selected
        if (!customerId) {
            Swal.fire({
                title: 'Warning!',
                text: 'Nama customer harus dipilih',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            });
            toReturn = false;
        }

        // Butcher name must not be empty
        if (!butcherName) {
            Swal.fire({
                title: 'Warning!',
                text: 'Nama Butcherees tidak boleh kosong',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            });
            toReturn = false;
        }

        // Branch/store must be selected
        if (!branchId) {
            Swal.fire({
                title: 'Warning!',
                text: 'Branch / Store harus dipilih',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            });
            toReturn = false;
        }

        // If payment method is transfer, reference number must be filled
        if (paymentMethod === '3' && transferRef.trim() === '') {
            Swal.fire({
                title: 'Warning!',
                text: 'Nomor Bukti Transfer harus diisi',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            });
            toReturn = false;
        }

        return toReturn;
    }

    function listPrinters() {
        if (!qz.websocket.isActive()) {
            qz.websocket.connect()
                .then(() => getPrinters())
                .catch(err => console.error("QZ Tray connection failed:", err));
        } else {
            getPrinters();
        }
    }

    function getPrinters() {
        qz.printers.find()
            .then(printers => {
                let printerList = document.getElementById("printerList");
                printerList.innerHTML = ""; // Clear previous list

                printers.forEach(printer => {
                    let li = document.createElement("li");
                    li.textContent = printer;
                    printerList.appendChild(li);
                });
            })
            .catch(err => console.error("Error listing printers:", err));
    }

    function printReceipt(printerName, jsonData) {
        if (!qz.websocket.isActive()) {
            qz.websocket.connect()
                .then(() => sendPrintCommand(printerName, jsonData)) // Adjust printer name
                .catch(err => console.error("QZ Tray connection failed:", err));
        } else {
            sendPrintCommand(printerName, jsonData);
        }
    }

    function sendPrintCommand(printerName, jsonData) {
        qz.printers.find(printerName)
            .then(printer => {
                console.log(jsonData)
                let config = qz.configs.create(printer);
                let header = jsonData.data.header;
                let details = jsonData.data.details;

                let data = [
                    '\x1B\x40', // Initialize printer
                    '\x1B\x61\x31', // Center align
                    '\x1B\x21\x10', // Double height
                    'Priyadis Butchers\n',
                    '\x1B\x21\x00', // Reset to normal text
                    `${header.address}\n`,
                    `Telp: ${header.phone_number}\n`,
                    '\n',
                    '\x1B\x61\x30', // Left align
                    '--------------------------------\n',
                    `No Transaksi  : ${header.code}\n`,
                    `Tanggal       : ${header.transaction_date.split(' ')[0]}\n`, // Extract date only
                    `Pembayaran    : ${header.payment_method}\n`,
                    `Kasir         : ${header.created_by}\n`,
                    '--------------------------------\n',
                ];

                // **Loop through items**
                details.forEach(item => {
                    data.push(`${item.name}\n`);
                    data.push(
                    `${item.quantity} X ${item.base_price} (Discount ${item.discount})\n`);
                    data.push('\x1B\x61\x32'); // Right align
                    data.push(`${item.sell_price}\n`);
                    data.push('\x1B\x61\x30'); // Back to left align
                });

                data.push('--------------------------------\n');
                data.push('\x1B\x61\x32'); // Right align
                data.push(`Total  ${header.total_amount}\n`);
                data.push(`Bayar (${header.payment_method})  ${header.nominal_cash}\n`);
                data.push(`Kembali  ${header.nominal_return}\n`);
                data.push('--------------------------------\n');
                data.push('\n\n\n');
                data.push('\x1D\x56\x41'); // Cut paper

                return qz.print(config, data);
            })
            .then(() => console.log("Print successful"))
            .catch(err => console.error("Print failed:", err));
    }
    // Auto-connect QZ Tray
    qz.websocket.connect().catch(err => console.error("QZ Tray not running:", err));
});
</script>

@endsection
