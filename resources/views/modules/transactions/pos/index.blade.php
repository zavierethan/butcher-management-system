@extends('layouts.main')

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
                <div class="d-flex flex-column flex-xl-row">
                    <!--begin::Content-->
                    <div class="d-flex flex-row-fluid me-xl-9 mb-10 mb-xl-0">
                        <!--begin::Pos food-->
                        <div class="card card-p-0 border-0">
                            <!--begin::Body-->
                            <div class="card-body p-5">
                                <div class="d-flex flex-wrap d-grid gap-5 gap-xxl-9 overflow-y-auto" style="height: 760px;" id="product-list">

                                </div>
                            </div>
                            <!--end: Card Body-->
                        </div>
                        <!--end::Pos food-->
                    </div>
                    <!--end::Content-->
                    <!--begin::Sidebar-->
                    <div class="flex-row-auto w-xl-500px">
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
                                        <span class="d-block mb-9">Tax(12%)</span>
                                        <span class="d-block fs-2qx lh-1">Total</span>
                                    </div>
                                    <!--end::Content-->
                                    <!--begin::Content-->
                                    <div class="fs-6 fw-bold text-white text-end">
                                        <span class="d-block lh-1 mb-2" data-kt-pos-element="total">Rp. 100.50</span>
                                        <span class="d-block mb-2" data-kt-pos-element="discount">Rp. 0,00</span>
                                        <span class="d-block mb-9" data-kt-pos-element="tax">Rp. 0,00</span>
                                        <span class="d-block fs-2qx lh-1" data-kt-pos-element="grant-total">Rp. 93.46</span>
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Summary-->
                                <!--begin::Payment Method-->
                                <div class="m-0">
                                    <!--begin::Title-->
                                    <h1 class="fw-bold text-gray-800 mb-5">Payment Method</h1>
                                    <!--end::Title-->
                                    <!--begin::Radio group-->
                                    <div class="d-flex flex-equal gap-5 gap-xxl-9 px-0 mb-12" data-kt-buttons="true"
                                        data-kt-buttons-target="[data-kt-button]">
                                        <!--begin::Radio-->
                                        <label
                                            class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-100 border-active-primary btn-active-light-primary w-100 px-4"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" name="method" value="0" />
                                            <!--end::Input-->
                                            <!--begin::Icon-->
                                            <i class="ki-duotone ki-dollar fs-2hx mb-2 pe-0">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            <!--end::Icon-->
                                            <!--begin::Title-->
                                            <span class="fs-7 fw-bold d-block">Cash</span>
                                            <!--end::Title-->
                                        </label>
                                        <!--end::Radio-->
                                        <!--begin::Radio-->
                                        <label
                                            class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-100 border-active-primary btn-active-light-primary w-100 px-4 active"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" name="method" value="1" />
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
                                            <input class="btn-check" type="radio" name="method" value="2" />
                                            <!--end::Input-->
                                            <!--begin::Icon-->
                                            <i class="ki-duotone ki-paypal fs-2hx mb-2 pe-0">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <!--end::Icon-->
                                            <!--begin::Title-->
                                            <span class="fs-7 fw-bold d-block">COD</span>
                                            <!--end::Title-->
                                        </label>
                                        <!--end::Radio-->
                                    </div>
                                    <!--end::Radio group-->
                                    <!--begin::Actions-->
                                    <button class="btn btn-primary fs-1 w-100 py-4">Bayar</button>
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
@endsection

@section('script')
<script>
$(document).ready(function() {
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
        var productPrice = $(this).data('product-price');
        var productImgUrl = $(this).find('img').attr('src');

        console.log($(this).data('product-id'));

        // Check if the product already exists in the cart
        var existingProduct = $(`#product-id-${productId}`);

        if (existingProduct.length > 0) {
            // Update the quantity if the product exists
            const quantityBadge = existingProduct.find('.badge');
            const currentQuantity = parseInt(quantityBadge.text()) || 1;
            quantityBadge.text(`${currentQuantity + 1} Gram`);
        } else {
            var productItem = `<div class="container py-1 cart-item-lists" id="product-id-${productId}">
                            <div class="pb-3 mb-3">
                                <div class="d-flex">
                                    <img src="${productImgUrl}" alt="Item" class="rounded me-3" style="width: 60px; height: 60px;">
                                    <div class="flex-grow-1 mt-3">
                                        <h5 class="mb-1">${productName}</h5>
                                        <span class="badge bg-warning text-dark">1,98 Gram</span>
                                    </div>
                                    <div class="text-end me-3 mt-3">
                                        <h6 class="mb-0">Rp ${productPrice}</h6>
                                    </div>
                                </div>
                                <div class="d-flex flex-row-reverse">
                                    <div class="text-end">
                                        <button class="btn btn-outline-primary btn-sm me-2">
                                            <i class="fas fa-edit"></i>
                                        </button>
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

        console.log(`Processed Product - ID: ${productId}, Name: ${productName}`);
    });


    $(document).on('click', '.remove-item', function(e) {

        e.preventDefault();
        // Get the product ID from the button's data attribute
        const productId = $(this).data('product-id');

        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Remove the product item from the cart
                $(`#product-id-${productId}`).remove();

                // Show success notification
                // Swal.fire(
                //     'Deleted!',
                //     'Your item has been removed.',
                //     'success'
                // );
            }
        });
        console.log(`Removed Product ID: ${productId}`);
    });

    $("#btn-clear-all").on('click', function() {
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Remove the product item from the cart
                $(".cart-item-lists").remove();
            }
        });
    });

    function getProductList(params = '') {
        $.ajax({
            url: '/api/products', // Laravel route to fetch products
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // Loop through each product in the JSON response
                data.forEach(function(product) {
                    // Construct HTML for each product
                    const productItem = `<div class="card card-flush flex-row-fluid p-6 pb-5 mw-100 product" data-product-id="${product.id}" data-product-name="${product.name}" data-product-price="${product.price}">
                                            <div class="card-body text-center">
                                                <img src="${product.imgUrl}" class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px" alt="" />
                                                <div class="mb-2">
                                                    <div class="text-center">
                                                        <span class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">${product.name}</span>
                                                    </div>
                                                </div>
                                                <span class="text-success text-end fw-bold fs-1">${formatCurrency(parseFloat(product.price))}</span>
                                            </div>
                                        </div>`;
                    // Append the product to the product list container
                    $('#product-list').append(productItem);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching products:', error);
            }
        });
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
