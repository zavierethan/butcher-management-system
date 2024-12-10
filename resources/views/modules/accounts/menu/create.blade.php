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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Menus</h1>
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
                        <li class="breadcrumb-item text-muted">Menus</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Create</li>
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
                            <form class="w-[60%]" method="POST" action="{{route('menus.save')}}">
                                @csrf
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Name</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-md form-control-solid" type="text" name="name" id="name" />
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Parent ID</label>
                                        <div class="position-relative mb-3">
                                            <select class="form-select form-select-solid" data-control="select2" data-placeholder="-" name="parent_id">
                                                <option value="">-</option>
                                                @foreach($parentIds as $parent)
                                                <option value="{{ $parent->id }}">{{ $parent->id }} - {{ $parent->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">URL</label>
                                        <div class="position-relative mb-3">
                                            <select class="form-select form-select-solid" data-control="select2" data-placeholder="-" name="url">
                                                <option value="">-</option>
                                                @foreach($urls as $url)
                                                <option value="{{ $url['uri'] }}">{{ $url['url'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Icon</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-md form-control-solid" type="text" name="icon" id="icon" />
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Order Sequence</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-md form-control-solid" type="text" name="order" id="order" />
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Is Active</label>
                                        <div class="position-relative mb-3">
                                            <select class="form-select form-select-solid" data-control="select2" data-placeholder="-" name="is_active">
                                                <option value=""></option>
                                                <option value="1" selected>Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="flex justify-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{route('menus.index')}}" class="btn btn-danger">Cancel</a>
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
