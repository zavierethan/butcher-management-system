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
                        <div class="card card-p-0 bg-transparent border-0">
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Nav-->

                                <!--end::Nav-->
                                <!--begin::Tab Content-->
                                <div class="tab-content">
                                    <!--begin::Tap pane-->
                                    <div class="tab-pane fade show active" id="kt_pos_food_content_1">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-wrap d-grid gap-5 gap-xxl-9">
                                            <!--begin::Card-->
                                            <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                <!--begin::Body-->
                                                <div class="card-body text-center">
                                                    <!--begin::Food img-->
                                                    <img src="assets/media/stock/food/ayam.jpeg"
                                                        class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                        alt="" />
                                                    <!--end::Food img-->
                                                    <!--begin::Info-->
                                                    <div class="mb-2">
                                                        <!--begin::Title-->
                                                        <div class="text-center">
                                                            <span
                                                                class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">T-Bone
                                                                Stake</span>
                                                            <span
                                                                class="text-gray-500 fw-semibold d-block fs-6 mt-n1">16
                                                                mins to cook</span>
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Info-->
                                                    <!--begin::Total-->
                                                    <span class="text-success text-end fw-bold fs-1">$16.50$</span>
                                                    <!--end::Total-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card-->
                                            <!--begin::Card-->
                                            <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                <!--begin::Body-->
                                                <div class="card-body text-center">
                                                    <!--begin::Food img-->
                                                    <img src="assets/media/stock/food/ayam.jpeg"
                                                        class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                        alt="" />
                                                    <!--end::Food img-->
                                                    <!--begin::Info-->
                                                    <div class="mb-2">
                                                        <!--begin::Title-->
                                                        <div class="text-center">
                                                            <span
                                                                class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Chef’s
                                                                Salmon</span>
                                                            <span
                                                                class="text-gray-500 fw-semibold d-block fs-6 mt-n1">16
                                                                mins to cook</span>
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Info-->
                                                    <!--begin::Total-->
                                                    <span class="text-success text-end fw-bold fs-1">$12.40$</span>
                                                    <!--end::Total-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card-->
                                            <!--begin::Card-->
                                            <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                <!--begin::Body-->
                                                <div class="card-body text-center">
                                                    <!--begin::Food img-->
                                                    <img src="assets/media/stock/food/ayam.jpeg"
                                                        class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                        alt="" />
                                                    <!--end::Food img-->
                                                    <!--begin::Info-->
                                                    <div class="mb-2">
                                                        <!--begin::Title-->
                                                        <div class="text-center">
                                                            <span
                                                                class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Ramen</span>
                                                            <span
                                                                class="text-gray-500 fw-semibold d-block fs-6 mt-n1">16
                                                                mins to cook</span>
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Info-->
                                                    <!--begin::Total-->
                                                    <span class="text-success text-end fw-bold fs-1">$14.90$</span>
                                                    <!--end::Total-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card-->
                                            <!--begin::Card-->
                                            <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                <!--begin::Body-->
                                                <div class="card-body text-center">
                                                    <!--begin::Food img-->
                                                    <img src="assets/media/stock/food/ayam.jpeg"
                                                        class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                        alt="" />
                                                    <!--end::Food img-->
                                                    <!--begin::Info-->
                                                    <div class="mb-2">
                                                        <!--begin::Title-->
                                                        <div class="text-center">
                                                            <span
                                                                class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Chicken
                                                                Breast</span>
                                                            <span
                                                                class="text-gray-500 fw-semibold d-block fs-6 mt-n1">16
                                                                mins to cook</span>
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Info-->
                                                    <!--begin::Total-->
                                                    <span class="text-success text-end fw-bold fs-1">$9.00$</span>
                                                    <!--end::Total-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card-->
                                            <!--begin::Card-->
                                            <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                <!--begin::Body-->
                                                <div class="card-body text-center">
                                                    <!--begin::Food img-->
                                                    <img src="assets/media/stock/food/ayam.jpeg"
                                                        class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                        alt="" />
                                                    <!--end::Food img-->
                                                    <!--begin::Info-->
                                                    <div class="mb-2">
                                                        <!--begin::Title-->
                                                        <div class="text-center">
                                                            <span
                                                                class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Tenderlion
                                                                Steak</span>
                                                            <span
                                                                class="text-gray-500 fw-semibold d-block fs-6 mt-n1">16
                                                                mins to cook</span>
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Info-->
                                                    <!--begin::Total-->
                                                    <span class="text-success text-end fw-bold fs-1">$19.00$</span>
                                                    <!--end::Total-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card-->
                                            <!--begin::Card-->
                                            <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                <!--begin::Body-->
                                                <div class="card-body text-center">
                                                    <!--begin::Food img-->
                                                    <img src="assets/media/stock/food/ayam.jpeg"
                                                        class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                        alt="" />
                                                    <!--end::Food img-->
                                                    <!--begin::Info-->
                                                    <div class="mb-2">
                                                        <!--begin::Title-->
                                                        <div class="text-center">
                                                            <span
                                                                class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Soup
                                                                of the Day</span>
                                                            <span
                                                                class="text-gray-500 fw-semibold d-block fs-6 mt-n1">16
                                                                mins to cook</span>
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Info-->
                                                    <!--begin::Total-->
                                                    <span class="text-success text-end fw-bold fs-1">$7.50$</span>
                                                    <!--end::Total-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card-->
                                            <!--begin::Card-->
                                            <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                <!--begin::Body-->
                                                <div class="card-body text-center">
                                                    <!--begin::Food img-->
                                                    <img src="assets/media/stock/food/ayam.jpeg"
                                                        class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                        alt="" />
                                                    <!--end::Food img-->
                                                    <!--begin::Info-->
                                                    <div class="mb-2">
                                                        <!--begin::Title-->
                                                        <div class="text-center">
                                                            <span
                                                                class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Pancakes</span>
                                                            <span
                                                                class="text-gray-500 fw-semibold d-block fs-6 mt-n1">16
                                                                mins to cook</span>
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Info-->
                                                    <!--begin::Total-->
                                                    <span class="text-success text-end fw-bold fs-1">$6.50$</span>
                                                    <!--end::Total-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card-->
                                            <!--begin::Card-->
                                            <div class="card card-flush flex-row-fluid p-6 pb-5 mw-100">
                                                <!--begin::Body-->
                                                <div class="card-body text-center">
                                                    <!--begin::Food img-->
                                                    <img src="assets/media/stock/food/ayam.jpeg"
                                                        class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                        alt="" />
                                                    <!--end::Food img-->
                                                    <!--begin::Info-->
                                                    <div class="mb-2">
                                                        <!--begin::Title-->
                                                        <div class="text-center">
                                                            <span
                                                                class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1">Breakfast</span>
                                                            <span
                                                                class="text-gray-500 fw-semibold d-block fs-6 mt-n1">16
                                                                mins to cook</span>
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Info-->
                                                    <!--begin::Total-->
                                                    <span class="text-success text-end fw-bold fs-1">$8.20$</span>
                                                    <!--end::Total-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Tap pane-->
                                </div>
                                <!--end::Tab Content-->
                            </div>
                            <!--end: Card Body-->
                        </div>
                        <!--end::Pos food-->
                    </div>
                    <!--end::Content-->
                    <!--begin::Sidebar-->
                    <div class="flex-row-auto w-xl-450px">
                        <!--begin::Pos order-->
                        <div class="card card-flush bg-body" id="kt_pos_form">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <h3 class="card-title fw-bold text-gray-800 fs-2qx">Current Order</h3>
                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <a href="#" class="btn btn-light-primary fs-4 fw-bold py-4">Clear All</a>
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-0">
                                <!--begin::Table container-->
                                <div class="table-responsive mb-8">
                                    <!--begin::Table-->
                                    <table class="table align-middle gs-0 gy-4 my-0">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="min-w-175px"></th>
                                                <th class="w-125px"></th>
                                                <th class="w-60px"></th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <tr data-kt-pos-element="item" data-kt-pos-item-price="33">
                                                <td class="pe-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/media/stock/food/ayam.jpeg"
                                                            class="w-50px h-50px rounded-3 me-3" alt="" />
                                                        <span
                                                            class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-6 me-1">T-Bone
                                                            Stake</span>
                                                    </div>
                                                </td>
                                                <td class="pe-0">
                                                    <!--begin::Dialer-->
                                                    <div class="position-relative d-flex align-items-center"
                                                        data-kt-dialer="true" data-kt-dialer-min="1"
                                                        data-kt-dialer-max="10" data-kt-dialer-step="1"
                                                        data-kt-dialer-decimals="0">
                                                        <!--begin::Decrease control-->
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-light btn-icon-gray-500"
                                                            data-kt-dialer-control="decrease">
                                                            <i class="ki-duotone ki-minus fs-3x"></i>
                                                        </button>
                                                        <!--end::Decrease control-->
                                                        <!--begin::Input control-->
                                                        <input type="text"
                                                            class="form-control border-0 text-center px-0 fs-3 fw-bold text-gray-800 w-30px"
                                                            data-kt-dialer-control="input" placeholder="Amount"
                                                            name="manageBudget" readonly="readonly" value="2" />
                                                        <!--end::Input control-->
                                                        <!--begin::Increase control-->
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-light btn-icon-gray-500"
                                                            data-kt-dialer-control="increase">
                                                            <i class="ki-duotone ki-plus fs-3x"></i>
                                                        </button>
                                                        <!--end::Increase control-->
                                                    </div>
                                                    <!--end::Dialer-->
                                                </td>
                                                <td class="text-end">
                                                    <span class="fw-bold text-primary fs-2"
                                                        data-kt-pos-element="item-total">$66.00</span>
                                                </td>
                                            </tr>
                                            <tr data-kt-pos-element="item" data-kt-pos-item-price="7.5">
                                                <td class="pe-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/media/stock/food/ayam.jpeg"
                                                            class="w-50px h-50px rounded-3 me-3" alt="" />
                                                        <span
                                                            class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-6 me-1">Soup
                                                            of the Day</span>
                                                    </div>
                                                </td>
                                                <td class="pe-0">
                                                    <!--begin::Dialer-->
                                                    <div class="position-relative d-flex align-items-center"
                                                        data-kt-dialer="true" data-kt-dialer-min="1"
                                                        data-kt-dialer-max="10" data-kt-dialer-step="1"
                                                        data-kt-dialer-decimals="0">
                                                        <!--begin::Decrease control-->
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-light btn-icon-gray-500"
                                                            data-kt-dialer-control="decrease">
                                                            <i class="ki-duotone ki-minus fs-3x"></i>
                                                        </button>
                                                        <!--end::Decrease control-->
                                                        <!--begin::Input control-->
                                                        <input type="text"
                                                            class="form-control border-0 text-center px-0 fs-3 fw-bold text-gray-800 w-30px"
                                                            data-kt-dialer-control="input" placeholder="Amount"
                                                            name="manageBudget" readonly="readonly" value="1" />
                                                        <!--end::Input control-->
                                                        <!--begin::Increase control-->
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-light btn-icon-gray-500"
                                                            data-kt-dialer-control="increase">
                                                            <i class="ki-duotone ki-plus fs-3x"></i>
                                                        </button>
                                                        <!--end::Increase control-->
                                                    </div>
                                                    <!--end::Dialer-->
                                                </td>
                                                <td class="text-end">
                                                    <span class="fw-bold text-primary fs-2"
                                                        data-kt-pos-element="item-total">$7.50</span>
                                                </td>
                                            </tr>
                                            <tr data-kt-pos-element="item" data-kt-pos-item-price="13.5">
                                                <td class="pe-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/media/stock/food/ayam.jpeg"
                                                            class="w-50px h-50px rounded-3 me-3" alt="" />
                                                        <span
                                                            class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-6 me-1">Pancakes</span>
                                                    </div>
                                                </td>
                                                <td class="pe-0">
                                                    <!--begin::Dialer-->
                                                    <div class="position-relative d-flex align-items-center"
                                                        data-kt-dialer="true" data-kt-dialer-min="1"
                                                        data-kt-dialer-max="10" data-kt-dialer-step="1"
                                                        data-kt-dialer-decimals="0">
                                                        <!--begin::Decrease control-->
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-light btn-icon-gray-500"
                                                            data-kt-dialer-control="decrease">
                                                            <i class="ki-duotone ki-minus fs-3x"></i>
                                                        </button>
                                                        <!--end::Decrease control-->
                                                        <!--begin::Input control-->
                                                        <input type="text"
                                                            class="form-control border-0 text-center px-0 fs-3 fw-bold text-gray-800 w-30px"
                                                            data-kt-dialer-control="input" placeholder="Amount"
                                                            name="manageBudget" readonly="readonly" value="2" />
                                                        <!--end::Input control-->
                                                        <!--begin::Increase control-->
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-light btn-icon-gray-500"
                                                            data-kt-dialer-control="increase">
                                                            <i class="ki-duotone ki-plus fs-3x"></i>
                                                        </button>
                                                        <!--end::Increase control-->
                                                    </div>
                                                    <!--end::Dialer-->
                                                </td>
                                                <td class="text-end">
                                                    <span class="fw-bold text-primary fs-2"
                                                        data-kt-pos-element="item-total">$27.00</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
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
                                        <span class="d-block lh-1 mb-2" data-kt-pos-element="total">$100.50</span>
                                        <span class="d-block mb-2" data-kt-pos-element="discount">-$8.00</span>
                                        <span class="d-block mb-9" data-kt-pos-element="tax">$11.20</span>
                                        <span class="d-block fs-2qx lh-1"
                                            data-kt-pos-element="grant-total">$93.46</span>
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
                                            <span class="fs-7 fw-bold d-block">Card</span>
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
                                            <span class="fs-7 fw-bold d-block">E-Wallet</span>
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

@endsection
