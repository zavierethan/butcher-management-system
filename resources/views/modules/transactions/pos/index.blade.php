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
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Transactions</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Transactions</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Point of Sales</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="#" class="btn btn-sm fw-bold btn-primary" id="fullscreen-control"
                        title="Click untuk mode fullscreen"><i class="fa-solid fa-desktop"></i></a>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
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
                                        <input type="text" data-product-filter="search" class="form-control form-control-solid ps-15" placeholder="Cari Product" id="product-search" />
                                    </div>
                                    <div class="ms-auto">
                                        <select class="form-select form-select-solid" data-placeholder="Pilih Kategori Product" name="product_category">
                                            <option value="0">Pilih Kategori Product</option>
                                            @foreach($productCategories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
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
                                <div class="d-flex">
                                    <div class="d-flex align-items-center position-relative">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <input class="form-control form-control-md form-control-solid" type="text"
                                            placeholder="Nama Customer" name="customer" id="customer"
                                            autocomplete="off" />
                                    </div>
                                    <div class="ms-auto">

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
                                <div class="row overflow-y-auto" style="height: 750px;" id="product-list">

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
                                <div class="d-flex flex-stack bg-success rounded-3 p-6 mb-11">
                                    <!--begin::Content-->
                                    <div class="fs-6 fw-bold text-white">
                                        <span class="d-block lh-1 mb-2">Subtotal</span>
                                        <span class="d-block mb-2">Discounts</span>
                                        <span class="d-block mb-2">Total</span>
                                    </div>
                                    <!--end::Content-->
                                    <!--begin::Content-->
                                    <div class="fs-6 fw-bold text-white text-end">
                                        <span class="d-block lh-1 mb-2" data-kt-pos-element="total" id="subtotal-amount">Rp. 0,00</span>
                                        <span class="d-block mb-2" data-kt-pos-element="discount">Rp. 0</span>
                                        <span class="d-block mb-2" data-kt-pos-element="grand-total" id="total-amount">Rp. 0,00</span>
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Summary-->
                                <!--begin::Payment Method-->
                                <div class="m-0">
                                    <!--begin::Title-->
                                    <h1 class="fw-bold text-gray-800 mb-5">Metode Pembayaran</h1>
                                    <!--end::Title-->
                                    <!--begin::Radio group-->
                                    <div class="d-flex flex-equal gap-5 gap-xxl-9 px-0 mb-12" data-kt-buttons="true"
                                        data-kt-buttons-target="[data-kt-button]" id="payment-method">
                                        <!--begin::Radio-->
                                        <label
                                            class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-100 border-active-primary btn-active-light-primary w-100 px-4"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" name="payment_method" value="1" />
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
                                            <span class="fs-7 fw-bold d-block">COD</span>
                                            <!--end::Title-->
                                        </label>
                                        <!--end::Radio-->
                                        <!--begin::Radio-->
                                        <label
                                            class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-100 border-active-primary btn-active-light-primary w-100 px-4"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" name="payment_method" value="4" />
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
                                    <!--begin::Actions-->
                                    <button class="btn btn-primary fs-1 w-100 py-4" id="process-transaction">Proses
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

<!--begin::Modal - View Users-->
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
                        <label class="form-label fw-bold fs-6 mb-2">Quantity (kg)</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="number"
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
@endsection

@section('script')
<script>
$(document).ready(function() {
    $("#product-loader").show();
    getProductList();

    $('#fullscreen-control').click(function() {
        const elem = document.documentElement;
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        }
    });

    $(document).on('click', '.product', function() {
        var productId = $(this).data('product-id');
        var productName = $(this).data('product-name');
        var productPrice = parseFloat($(this).data('product-price')); // Ensure price is a number
        var productImgUrl = $(this).find('img').attr('src');

        // Check if the product already exists in the cart
        var existingProduct = $(`#product-id-${productId}`);

        if (existingProduct.length > 0) {
            // Update quantity and subtotal for existing product
            const quantityElement = existingProduct.find('.qty');
            const currentQuantity = parseFloat(quantityElement.text()) || 1;
            const newQuantity = currentQuantity + 1;
            quantityElement.text(`${newQuantity} Kg`);

            const priceElement = existingProduct.find('.price');
            const newSubtotal = productPrice * newQuantity;
            priceElement.text(formatCurrency(newSubtotal));
        } else {
            // Add new product to the cart
            var productItem = `<div class="container py-1 cart-item-lists" id="product-id-${productId}">
                            <div class="pb-3 mb-3">
                                <div class="d-flex">
                                    <img src="${productImgUrl}" alt="Item" class="rounded me-3" style="width: 60px; height: 60px;">
                                    <div class="flex-grow-1 mt-3">
                                        <h5 class="mb-1">${productName}</h5>
                                        <div class="d-none product-id">${productId}</div>
                                        <div class="d-none base-price">${productPrice}</div>
                                        <span class="badge bg-warning text-dark qty">1 Kg</span>
                                    </div>
                                    <div class="text-end me-3 mt-3">
                                        <h6 class="mb-1 price">${formatCurrency(productPrice)}</h6>
                                        <span class="badge bg-warning text-dark"></span>
                                    </div>
                                </div>
                                <div class="d-flex flex-row-reverse">
                                    <div class="text-end">
                                        <a href="#" class="btn btn-outline-primary btn-sm me-2 edit-item" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_product_item" data-product-id="${productId}" data-product-name="${productName}" data-product-price="${productPrice}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-outline-danger btn-sm remove-item" data-product-id="${productId}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <div class="separator separator-dashed my-5"></div>
                    </div>`;

            $('#cart-item').append(productItem);
        }

        // Recalculate totals
        calculateTotals();
    });

    $(document).on('keyup', '#product-search', function(e) {
        // if (e.keyCode === 13) {
            var searchQuery = $(this).val();
            getProductList(searchQuery);
        // }

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

        $("#kt_modal_edit_product_item #product_id").val(productId);
        $("#kt_modal_edit_product_item #product_name").val(productName);
        $("#kt_modal_edit_product_item #product_price").val(productPrice);

        $("#kt_modal_edit_product_item #quantity").val("");
    });

    $(document).on('click', '#update-item', function(e) {

        e.preventDefault();

        const productId = $("#kt_modal_edit_product_item #product_id").val();
        const quantity = $("#kt_modal_edit_product_item #quantity").val();
        const productPrice = $("#kt_modal_edit_product_item #product_price").val();

        // Check if the product already exists in the cart
        var existingProduct = $(`#product-id-${productId}`);

        if (existingProduct.length > 0) {
            // Update quantity and subtotal for existing product
            const quantityElement = existingProduct.find('.qty');
            // const currentQuantity = parseFloat(quantityElement.text()) || 1;
            const newQuantity = parseFloat(quantity);
            quantityElement.text(`${newQuantity} Kg`);

            const priceElement = existingProduct.find('.price');
            const newSubtotal = productPrice * newQuantity;
            priceElement.text(formatCurrency(newSubtotal));
        }

        calculateTotals();
        $('#kt_modal_edit_product_item').modal('hide');

    });

    $(document).on('click', '#process-transaction', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Apakah anda yakin untuk memproses transaksi ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Proses Transaksi'
        }).then((result) => {
            if (result.isConfirmed) {
                const products = [];

                $('.cart-item-lists').each(function() {

                    const productId = $(this).find('.product-id').text();
                    const price = $(this).find('.price').text().replace(/[^\d]/g, '');
                    const basePrice = $(this).find('.base-price').text().replace(/[^\d]/g, '');
                    const quantity = $(this).find('.qty').text().replace(/ Kg$/, "");

                    products.push({
                        product_id: productId,
                        base_price: basePrice,
                        price: price,
                        quantity: quantity,
                    });
                });

                const totalAmount = $('#total-amount').text().replace(/[^\d]/g, '');
                const paymentMethod = $('#payment-method').find('input[type="radio"]:checked').val();

                console.log(paymentMethod);

                // Build the JSON payload
                const payload = {
                    header: {
                        transaction_date: new Date().toISOString(),
                        customer_name: 1,
                        total_amount: totalAmount,
                        payment_method: paymentMethod // Example, adjust as needed
                    },
                    details: products
                };

                console.log(payload)

                $.ajax({
                    url: `{{route('transactions.store')}}`,
                    type: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify(payload),
                    success: function (response) {
                        Swal.fire({
                            title: 'Suceess !',
                            text: 'Transaksi berhasil di simpan',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            location.href = `{{route('transactions.index')}}`;
                        });
                    },
                    error: function (xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            error,
                            'error'
                        )
                    }
                });
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
            confirmButtonText: 'Yes, delete it!'
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

    function getProductList(param) {
        $("#product-loader").show();
        $.ajax({
            url: `/api/products`, // Laravel route to fetch products
            type: 'GET',
            data: {
                q: param,
            },
            dataType: 'json',
            success: function(response) {
                // Loop through each product in the JSON response

                var data = response.data;
                $('.product-l').remove();
                data.forEach(function(product) {
                    // Construct HTML for each product
                    const productItem = `<div class="col-md-4 mb-3 product-l"><div class="card p-6 pb-5 mw-100 product" data-product-id="${product.id}" data-product-name="${product.name}" data-product-price="${product.price}">
                                            <div class="card-body text-center">
                                                <img src="${product.url_path}" class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px" alt="" />
                                                <div class="mb-2">
                                                    <div class="text-center">
                                                        <span class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">${product.name}</span>
                                                    </div>
                                                </div>
                                                <span class="text-success text-end fw-bold fs-1">${formatCurrency(parseFloat(product.price))}</span>
                                            </div>
                                        </div></div>`;
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

    function calculateTotals() {
        let subtotal = 0;

        // Iterate through each product in the cart and sum up their subtotals
        $('.cart-item-lists').each(function() {
            const priceText = $(this).find('.price').text().replace(/[^\d]/g,
            ''); // Remove currency symbols
            const price = parseFloat(priceText) || 0; // Ensure numeric value
            subtotal += price; // Add to the subtotal
        });

        // Update subtotal and total amount in the UI
        $('#subtotal-amount').text(formatCurrency(subtotal));
        $('#total-amount').text(formatCurrency(subtotal)); // Add additional charges if needed
    }

    function formatCurrency(amount) {
        const formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR', // IDR is the currency code for Indonesian Rupiah
            minimumFractionDigits: 0, // Optional, remove decimals if not needed
        });
        return formatter.format(amount);
    }
});
</script>

@endsection
