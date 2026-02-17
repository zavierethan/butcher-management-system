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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Product Settings</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Branches</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Product Settings</li>
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
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_items_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">PRM KKS</th>
                                        <th class="min-w-125px">PRM KKS TG</th>
                                        <th class="min-w-125px">PRM FDK</th>
                                        <th class="min-w-125px">PRM FDB</th>
                                        <th class="min-w-125px">PRM FPK</th>
                                        <th class="min-w-125px">PRM FPB</th>
                                        <th class="min-w-125px">PRM DGL</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2"
                                                    id="prm-kks" value="1.4" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2"
                                                    id="prm-kks-tg" value="4000" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2"
                                                    id="prm-fdk" value="1.2" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2"
                                                    id="prm-fdb" value="1.3" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2"
                                                    id="prm-fpk" value="1.2" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2"
                                                    id="prm-fpb" value="1.3" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2"
                                                    id="prm-dgl" value="1.3" />
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <!--end::Table body-->
                            </table>

                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_items_table_margin">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">MARGIN 1</th>
                                        <th class="min-w-125px">MARGIN 2</th>
                                        <th class="min-w-125px">MARGIN 3</th>
                                        <th class="min-w-125px">MARGIN 4</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2"
                                                    id="group-flag-1"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2"
                                                    id="group-flag-2"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2"
                                                    id="group-flag-3"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2"
                                                    id="group-flag-4"/>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                            <div class="fv-row mb-5">
                                <div class="mb-1">
                                    <label class="form-label fw-bold fs-6 mb-2">Harga Ayam Hidup ({{$latestPrice->received_date}})</label>
                                    <div class="position-relative mb-3">
                                        <input class="form-control form-control-md form-control-solid" type="text"
                                            id="raw-material-price" value="{{$latestPrice->avg_price}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="separator my-5"></div>
                            <div class="fv-row mb-5">
                                <div class="mb-1">
                                    <label class="form-label fw-bold fs-6 mb-2">COGS (KKS)</label>
                                    <div class="position-relative mb-3">
                                        <input class="form-control form-control-md form-control-solid" type="text"
                                            id="cogs-price" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="separator my-5"></div>
                            <div class="row mb-8">
                                <!--begin::Col-->
                                <div class="col-xl-2">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">Branch (Store)</div>
                                </div>
                                <!--end::Col-->
                                <div class="col-xl-9">
                                    <div class="d-flex fw-semibold h-100">
                                        @foreach($branches as $b)
                                        <div class="form-check form-check-custom form-check-solid me-9">
                                            <input class="form-check-input branch-checkbox" type="checkbox" value="{{$b->id}}" id="branch_{{$b->id}}" />
                                            <label class="form-check-label ms-3" for="branch_{{$b->id}}">{{$b->name}}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <a href="{{route('branches.index')}}" class="btn btn-sm btn-danger">Kembali</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-primary"
                                    id="btn-generate-price">Generate Price</a>
                                <a href="#" class="btn btn-sm btn-success" id="btn-bulk-update">Bulk update</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Row-->

                <!--begin::Row-->
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <div class="card">
                        <div class="card-body pt-10 overflow-x-auto">
                            <!--begin::Table-->
                            <div class="row mb-5">
                                <div class="col-md-12 text-end">

                                </div>
                            </div>
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_items_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Product Name</th>
                                        <th class="min-w-125px">COGS</th>
                                        <th class="min-w-125px">MARGIN (%)</th>
                                        <th class="min-w-125px">MARGIN (RP)</th>
                                        <th class="min-w-125px">RECOMMEND PRICE</th>
                                        <th class="min-w-125px">FINAL SALE PRICE</th>
                                        <th class="min-w-125px">Discount</th>
                                        <th class="min-w-125px">Disc. Start Period</th>
                                        <th class="min-w-125px">Disc. End Period</th>
                                        <th class="min-w-125px text-center">Active</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600" id="product-table">
                                    @php $num = 1; @endphp
                                    @foreach($products as $product)
                                    @if($product->group_flag == 1)
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0" data-group-flag="1">
                                        <td>{{$product->name}} ({{$product->code}})
                                            <input type="hidden"
                                                class="form-control form-control-sm inline-edit-end-period me-2 product_id"
                                                value="{{$product->id}}" />
                                            <input type="hidden"
                                                class="form-control form-control-sm inline-edit-end-period me-2 product_code"
                                                value="{{$product->code}}" />
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 COGS-{{$product->code}} cogs"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 MARGIN-{{$product->code}} margin"
                                                    value="10" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 MARGIN-{{$product->code}} margin-price"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 SALE-PRICE-{{$product->code}} cogs-plus-margin"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 FINAL-PRICE-{{$product->code}} final-sale-price"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 discount"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="date"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 disc-start-period"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="date"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 disc-end-period"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <label
                                                    class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input toggle-status" type="checkbox" data-id="{{$product->code}}" checked/>
                                                    <span class="form-check-label fw-bold text-muted"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach

                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0 skip-row">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    @foreach($products as $product)
                                    @if($product->group_flag == 2)
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0" data-group-flag="2">
                                        <td>{{$product->name}} ({{$product->code}})
                                            <input type="hidden"
                                                class="form-control form-control-sm inline-edit-end-period me-2 product_id"
                                                value="{{$product->id}}" />
                                            <input type="hidden"
                                                class="form-control form-control-sm inline-edit-end-period me-2 product_code"
                                                value="{{$product->code}}" />
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 COGS-{{$product->code}} cogs"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 MARGIN-{{$product->code}} margin"
                                                    value="5" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 MARGIN-{{$product->code}} margin-price"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 SALE-PRICE-{{$product->code}} cogs-plus-margin"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 FINAL-PRICE-{{$product->code}} final-sale-price"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 discount"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="date"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 disc-start-period"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="date"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 disc-end-period"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <label
                                                    class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input toggle-status" type="checkbox" data-id="{{$product->code}}" checked/>
                                                    <span class="form-check-label fw-bold text-muted"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach

                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0 skip-row">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    @foreach($products as $product)
                                    @if($product->group_flag == 3)
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0" data-group-flag="3">
                                        <td>{{$product->name}} ({{$product->code}})
                                            <input type="hidden"
                                                class="form-control form-control-sm inline-edit-end-period me-2 product_id"
                                                value="{{$product->id}}" />
                                            <input type="hidden"
                                                class="form-control form-control-sm inline-edit-end-period me-2 product_code"
                                                value="{{$product->code}}" />
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 COGS-{{$product->code}} cogs"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 MARGIN-{{$product->code}} margin"
                                                    value="5" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 MARGIN-{{$product->code}} margin-price"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 SALE-PRICE-{{$product->code}} cogs-plus-margin"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 FINAL-PRICE-{{$product->code}} final-sale-price"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 discount"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="date"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 disc-start-period"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="date"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 disc-end-period"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <label
                                                    class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input toggle-status" type="checkbox" data-id="{{$product->code}}" checked/>
                                                    <span class="form-check-label fw-bold text-muted"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach

                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0 skip-row">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    @foreach($products as $product)
                                    @if($product->group_flag == 4)
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0" data-group-flag="4">
                                        <td>{{$product->name}} ({{$product->code}})
                                            <input type="hidden"
                                                class="form-control form-control-sm inline-edit-end-period me-2 product_id"
                                                value="{{$product->id}}" />
                                            <input type="hidden"
                                                class="form-control form-control-sm inline-edit-end-period me-2 product_code"
                                                value="{{$product->code}}" />
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 COGS-{{$product->code}} cogs"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 MARGIN-{{$product->code}} margin"
                                                    value="5" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 MARGIN-{{$product->code}} margin-price"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 SALE-PRICE-{{$product->code}} cogs-plus-margin"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 FINAL-PRICE-{{$product->code}} final-sale-price"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 discount"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="date"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 disc-start-period"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="date"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 disc-end-period"
                                                    value="0" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <label
                                                    class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input toggle-status" type="checkbox" data-id="{{$product->code}}" checked/>
                                                    <span class="form-check-label fw-bold text-muted"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
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
<script>
$(document).ready(function() {
    calculateCogs($("#raw-material-price").val(), $("#prm-kks").val());
});

// Event listener untuk margin group flags
$(document).on('keyup', '#group-flag-1, #group-flag-2, #group-flag-3, #group-flag-4', function() {
    let groupFlag = $(this).attr('id').replace('group-flag-', '');
    let marginValue = $(this).val();

    // Update semua margin untuk group_flag yang sesuai
    $('#product-table tr[data-group-flag="' + groupFlag + '"]').each(function() {
        $(this).find('.margin').val(marginValue).trigger('change');
    });
});

$(document).on("keyup", "input", function() {
    var originalVal = $(this).val();
    var formattedVal = formatNumber(originalVal);
    $(this).val(formattedVal);
});

$(document).on('keyup', '#raw-material-price', function() {
    let val = parseFloat($(this).val().replace(/,/g, ""));
    let prmKks = parseFloat($("#prm-kks").val());
    calculateCogs($(this).val(), prmKks);
});

// Auto-calculate when margin changes
$(document).on('change keyup', '.margin', function() {
    let row = $(this).closest('tr');
    let productCode = row.find('.product_code').val();

    // Get values
    let cogsStr = row.find('.cogs').val();
    let cogs = parseFloat(cogsStr.replace(/,/g, "")) || 0;
    let marginPercent = parseFloat($(this).val()) || 0;

    // Calculate margin price
    let marginPrice = Math.round(cogs * (marginPercent / 100));

    // Add special amounts for certain products
    var productKarkasArr = ["KKS", "DD", "PH", "PHA", "PHP", "SY", "TG", "FDK", "FDB", "FPK", "FPB", "DGL"];

    if (productKarkasArr.includes(productCode)) {
        if (productCode === "PHP") marginPrice += 2000;
        if (productCode === "SY") marginPrice += 1000;
    }

    // Calculate recommended and final prices
    let recommendedPrice = cogs + marginPrice;
    let finalSalePrice = roundUp(recommendedPrice);

    // Update the row values
    setRowValues(row, cogs, marginPrice, recommendedPrice, finalSalePrice);
});

$(document).on('click', '#btn-generate-price', function() {
    var productKarkasArr = ["KKS", "DD", "PH", "PHA", "PHP", "SY", "TG", "FDK", "FDB", "FPK", "FPB", "DGL"];
    var productFixPriceArr = ["KL", "TRO", "TPH", "TTLN", "TRW", "KPL", "CKR", "AA", "US", "TLR", "SYR", "DLV"];

    var prmKks = parseFloat($("#prm-kks").val());
    var prmFdk = parseFloat($("#prm-fdk").val());
    var prmFdb = parseFloat($("#prm-fdb").val());
    var prmFpk = parseFloat($("#prm-fpk").val());
    var prmFpb = parseFloat($("#prm-fpb").val());
    var prmDgl = parseFloat($("#prm-dgl").val());

    var rawMaterialPrice = parseFloat($("#raw-material-price").val().replace(/,/g, ""));
    var baseCogs = Math.round(rawMaterialPrice * prmKks);

    $('#product-table tr').each(function() {
        if ($(this).hasClass('skip-row')) return; // Skip this row

        let productCode = $(this).find('.product_code').val();

        if (productKarkasArr.includes(productCode)) {
            let cogs = baseCogs;

            if (productCode === "TG") cogs += 4000;
            if (productCode === "FDK") cogs = Math.round(cogs * prmFdk);
            if (productCode === "FDB") cogs = Math.round(cogs * prmFdb);
            if (productCode === "FPK") cogs = Math.round(cogs * prmFpk);
            if (productCode === "FPB") cogs = Math.round(cogs * prmFpb);
            if (productCode === "DGL") cogs = Math.round(cogs * prmDgl) + 3000;

            let margin = parseFloat($(this).find('.margin').val()) / 100;
            let marginPrice = Math.round(cogs * margin);

            if (productCode === "PHP") marginPrice += 2000;
            if (productCode === "SY") marginPrice += 1000;

            let recommendedPrice = cogs + marginPrice;
            let finalSalePrice = roundUp(recommendedPrice);

            setRowValues($(this), cogs, marginPrice, recommendedPrice, finalSalePrice);
        }

        if (productFixPriceArr.includes(productCode)) {
            let cogs = parseFloat($(this).find('.cogs').val().replace(/,/g, ""));

            let margin = parseFloat($(this).find('.margin').val()) / 100;
            let marginPrice = Math.round(cogs * margin);

            let recommendedPrice = cogs + marginPrice;
            let finalSalePrice = roundUp(recommendedPrice);

            setRowValues($(this), cogs, marginPrice, recommendedPrice, finalSalePrice);
        }
    });

});

$(document).on('click', '#btn-bulk-update', function(e) {
    e.preventDefault();

    if (true) {
        Swal.fire({
            title: 'Apakah anda yakin melakukan Bulk Update ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya, Bulk Update'
        }).then((result) => {
            if (result.isConfirmed) {
                let products = [];

                let selectedBranches = [];

                $(".branch-checkbox:checked").each(function () {
                    selectedBranches.push($(this).val());
                });

                $("#product-table tr").each(function() {
                    if ($(this).hasClass('skip-row')) return;
                    let product = {
                        id: $(this).find(".product_id").val(),
                        cogs: $(this).find(".cogs").val().replace(/,/g, ""),
                        margin: $(this).find(".margin").val().replace(/,/g, ""),
                        margin_price: $(this).find(".margin-price").val().replace(/,/g, ""),
                        cogs_plus_margin: $(this).find(".cogs-plus-margin").val().replace(
                            /,/g, ""),
                        final_sale_price: $(this).find(".final-sale-price").val().replace(
                            /,/g, ""),
                        discount: $(this).find(".discount").val().replace(/,/g, ""),
                        disc_start: $(this).find(".disc-start-period").val(),
                        disc_end: $(this).find(".disc-end-period").val(),
                        active_status: $(this).find(".toggle-status").is(":checked") ? 1 : 0
                    };
                    products.push(product);
                });

                $.ajax({
                    url: `{{route('products.product-setting-bulk-update')}}`,
                    type: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify({
                        products: products,
                        branches: selectedBranches
                    }),
                    success: function(response) {
                        Swal.fire({
                            title: 'Suceess !',
                            text: `Data product berhasil di perbaharui`,
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        }).then((result) => {
                            // Redirect the current page to the transaction index
                            location.href = `{{ route('products.index') }}`;
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
            }
        });
    }
});

// Function to set formatted values in table row
function setRowValues(row, cogs, marginPrice, recommendedPrice, finalSalePrice) {
    row.find('.cogs').val(format(cogs));
    row.find('.margin-price').val(format(marginPrice));
    row.find('.cogs-plus-margin').val(format(recommendedPrice));
    row.find('.final-sale-price').val(format(finalSalePrice));
}


function format(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function roundUp(num) {
    return Math.ceil(num / 1000) * 1000;
}

function formatNumber(numStr) {
    let cleaned = numStr.replace(/[^\d.]/g, '');
    const parts = cleaned.split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join('.');
}

function calculateCogs(rawMaterialPrice, prmKks) {
    let val = parseFloat(rawMaterialPrice.replace(/,/g, ""));
    let kks = parseFloat(prmKks);

    let cogsKks = Math.round(val * kks) || 0;

    let formatedKks = formatNumber(cogsKks.toString());

    $("#cogs-price").val(formatedKks);
}
</script>
@endsection
