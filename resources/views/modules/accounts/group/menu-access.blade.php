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
                        Groups</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Accounts</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Groups</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Menu Access & Permissions</li>
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
                            <form method="POST" action="{{ route('groups.save') }}">
                                @csrf
                                <div class="row">
                                    <!-- Kolom Kiri -->
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bold fs-6 mb-2 fw-bolder">Group Code</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="text" name="code" id="code" value="{{$group->code}}" />
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bold fs-6 mb-2 fw-bolder">Group Name</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="text" name="name" id="name" value="{{$group->name}}" />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Kolom Kanan -->
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <div class="card mb-5 mb-xl-8">
                                                <!--begin::Card header-->
                                                <div class="card-header border-0">
                                                    <div class="card-title">
                                                        <h3 class="fw-bolder m-0">Menu Access</h3>
                                                    </div>
                                                </div>
                                                <!--end::Card header-->
                                                <!--begin::Card body-->
                                                <div class="card-body pt-2">
                                                    <!--begin::Notice-->
                                                    <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                                                        <!--begin::Icon-->
                                                        <!--begin::Svg Icon | path: icons/duotune/art/art006.svg-->
                                                        <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <path opacity="0.3"
                                                                    d="M22 19V17C22 16.4 21.6 16 21 16H8V3C8 2.4 7.6 2 7 2H5C4.4 2 4 2.4 4 3V19C4 19.6 4.4 20 5 20H21C21.6 20 22 19.6 22 19Z"
                                                                    fill="black"></path>
                                                                <path
                                                                    d="M20 5V21C20 21.6 19.6 22 19 22H17C16.4 22 16 21.6 16 21V8H8V4H19C19.6 4 20 4.4 20 5ZM3 8H4V4H3C2.4 4 2 4.4 2 5V7C2 7.6 2.4 8 3 8Z"
                                                                    fill="black"></path>
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                        <!--end::Icon-->
                                                        <!--begin::Wrapper-->
                                                        <div class="d-flex flex-stack flex-grow-1">
                                                            <!--begin::Content-->
                                                            <div class="fw-bold">
                                                                <div class="fs-6 text-gray-700">By connecting an
                                                                    account, you hereby agree to our
                                                                    <a href="#" class="me-1">privacy policy</a>and
                                                                    <a href="#">terms of use</a>.
                                                                </div>
                                                            </div>
                                                            <!--end::Content-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                    <!--end::Notice-->
                                                    <!--begin::Items-->
                                                    <div class="py-2">
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-stack">
                                                            <div class="d-flex">
                                                                <div class="d-flex flex-column">
                                                                    <a href="#" class="fs-5 text-dark text-hover-primary fw-bolder">Dashboard</a>
                                                                    <div class="fs-6 fw-bold text-muted">Plan properly your workflow</div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <!--begin::Switch-->
                                                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                    <!--begin::Input-->
                                                                    <input class="form-check-input" name="google" type="checkbox" value="1" id="kt_modal_connected_accounts_google">
                                                                    <!--end::Input-->
                                                                    <!--begin::Label-->
                                                                    <span class="form-check-label fw-bold text-muted" for="kt_modal_connected_accounts_google"></span>
                                                                    <!--end::Label-->
                                                                </label>
                                                                <!--end::Switch-->
                                                            </div>
                                                        </div>
                                                        <!--end::Item-->
                                                        <div class="separator separator-dashed my-5"></div>
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-stack">
                                                            <div class="d-flex">
                                                                <div class="d-flex flex-column">
                                                                    <a href="#" class="fs-5 text-dark text-hover-primary fw-bolder">Point of Sales</a>
                                                                    <div class="fs-6 fw-bold text-muted">Keep eye on on your Repositories</div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <!--begin::Switch-->
                                                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                    <!--begin::Input-->
                                                                    <input class="form-check-input" name="github" type="checkbox" value="1" id="kt_modal_connected_accounts_github">
                                                                    <!--end::Input-->
                                                                    <!--begin::Label-->
                                                                    <span class="form-check-label fw-bold text-muted" for="kt_modal_connected_accounts_github"></span>
                                                                    <!--end::Label-->
                                                                </label>
                                                                <!--end::Switch-->
                                                            </div>
                                                        </div>
                                                        <!--end::Item-->
                                                        <div class="separator separator-dashed my-5"></div>
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-stack">
                                                            <div class="d-flex">
                                                                <div class="d-flex flex-column">
                                                                    <a href="#" class="fs-5 text-dark text-hover-primary fw-bolder">Productions</a>
                                                                    <div class="fs-6 fw-bold text-muted">Keep eye on on your Repositories</div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <!--begin::Switch-->
                                                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                    <!--begin::Input-->
                                                                    <input class="form-check-input" name="github" type="checkbox" value="1" id="kt_modal_connected_accounts_github">
                                                                    <!--end::Input-->
                                                                    <!--begin::Label-->
                                                                    <span class="form-check-label fw-bold text-muted" for="kt_modal_connected_accounts_github"></span>
                                                                    <!--end::Label-->
                                                                </label>
                                                                <!--end::Switch-->
                                                            </div>
                                                        </div>
                                                        <!--end::Item-->
                                                        <div class="separator separator-dashed my-5"></div>
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-stack">
                                                            <div class="d-flex">
                                                                <div class="d-flex flex-column">
                                                                    <a href="#" class="fs-5 text-dark text-hover-primary fw-bolder">Inventory</a>
                                                                    <div class="fs-6 fw-bold text-muted">Keep eye on on your Repositories</div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <!--begin::Switch-->
                                                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                    <!--begin::Input-->
                                                                    <input class="form-check-input" name="github" type="checkbox" value="1" id="kt_modal_connected_accounts_github">
                                                                    <!--end::Input-->
                                                                    <!--begin::Label-->
                                                                    <span class="form-check-label fw-bold text-muted" for="kt_modal_connected_accounts_github"></span>
                                                                    <!--end::Label-->
                                                                </label>
                                                                <!--end::Switch-->
                                                            </div>
                                                        </div>
                                                        <!--end::Item-->
                                                        <div class="separator separator-dashed my-5"></div>
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-stack">
                                                            <div class="d-flex">
                                                                <div class="d-flex flex-column">
                                                                    <a href="#" class="fs-5 text-dark text-hover-primary fw-bolder">Finances</a>
                                                                    <div class="fs-6 fw-bold text-muted">Keep eye on on your Repositories</div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <!--begin::Switch-->
                                                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                    <!--begin::Input-->
                                                                    <input class="form-check-input" name="github" type="checkbox" value="1" id="kt_modal_connected_accounts_github">
                                                                    <!--end::Input-->
                                                                    <!--begin::Label-->
                                                                    <span class="form-check-label fw-bold text-muted" for="kt_modal_connected_accounts_github"></span>
                                                                    <!--end::Label-->
                                                                </label>
                                                                <!--end::Switch-->
                                                            </div>
                                                        </div>
                                                        <!--end::Item-->
                                                        <div class="separator separator-dashed my-5"></div>
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-stack">
                                                            <div class="d-flex">
                                                                <div class="d-flex flex-column">
                                                                    <a href="#" class="fs-5 text-dark text-hover-primary fw-bolder">Accounts</a>
                                                                    <div class="fs-6 fw-bold text-muted">Keep eye on on your Repositories</div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <!--begin::Switch-->
                                                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                    <!--begin::Input-->
                                                                    <input class="form-check-input" name="github" type="checkbox" value="1" id="kt_modal_connected_accounts_github">
                                                                    <!--end::Input-->
                                                                    <!--begin::Label-->
                                                                    <span class="form-check-label fw-bold text-muted" for="kt_modal_connected_accounts_github"></span>
                                                                    <!--end::Label-->
                                                                </label>
                                                                <!--end::Switch-->
                                                            </div>
                                                        </div>
                                                        <!--end::Item-->
                                                        <div class="separator separator-dashed my-5"></div>
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-stack">
                                                            <div class="d-flex">
                                                                <div class="d-flex flex-column">
                                                                    <a href="#" class="fs-5 text-dark text-hover-primary fw-bolder">Master Data</a>
                                                                    <div class="fs-6 fw-bold text-muted">Keep eye on on your Repositories</div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <!--begin::Switch-->
                                                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                    <!--begin::Input-->
                                                                    <input class="form-check-input" name="github" type="checkbox" value="1" id="kt_modal_connected_accounts_github">
                                                                    <!--end::Input-->
                                                                    <!--begin::Label-->
                                                                    <span class="form-check-label fw-bold text-muted" for="kt_modal_connected_accounts_github"></span>
                                                                    <!--end::Label-->
                                                                </label>
                                                                <!--end::Switch-->
                                                            </div>
                                                        </div>
                                                        <!--end::Item-->
                                                    </div>
                                                    <!--end::Items-->
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <!-- Tombol Submit -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                    <a href="{{ route('groups.index') }}" class="btn btn-danger">Cancel</a>
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

@endsection
