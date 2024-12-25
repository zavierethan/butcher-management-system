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
                            <form method="POST" action="{{ route('groups.update') }}">
                                @csrf
                                <div class="row">
                                    <!-- Kolom Kiri -->
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bold fs-6 mb-2 fw-bolder">Group Code</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid" type="text" name="code" id="code" value="{{$group->code}}" />
                                                <input class="form-control form-control-md form-control-solid" type="hidden" name="group_id" id="group_id" value="{{$group->id}}" />
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
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-2">Update</button>
                                            <a href="{{ route('groups.index') }}" class="btn btn-danger">Cancel</a>
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

                                                    <!--begin::Items-->
                                                    <div class="py-2">
                                                        @foreach($parent as $p)
                                                        <!-- Begin::Item -->
                                                        <div class="d-flex flex-stack">
                                                            <div class="d-flex">
                                                                <div class="d-flex flex-column">
                                                                    <a href="#"
                                                                        class="fs-5 text-dark text-hover-primary fw-bolder">{{ $p->name }}</a>
                                                                    <div class="fs-6 fw-bold text-muted">{{ $p->url }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <!-- Begin::Switch -->
                                                                <label
                                                                    class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                    <!-- Begin::Input -->
                                                                    <input class="form-check-input"
                                                                        name="menu_access_id" type="checkbox"
                                                                        value="{{ $p->id }}"
                                                                        id="menu_access_{{ $p->id }}"
                                                                        onChange="addMenuAccess(this)"
                                                                        {{ in_array($p->id, $menuAssigned) ? 'checked' : '' }}>
                                                                    <!-- End::Input -->
                                                                    <!-- Begin::Label -->
                                                                    <span
                                                                        class="form-check-label fw-bold text-muted"></span>
                                                                    <!-- End::Label -->
                                                                </label>
                                                                <!-- End::Switch -->
                                                            </div>
                                                        </div>
                                                        <!-- End::Item -->
                                                        <div class="separator separator-dashed my-5"></div>

                                                        @foreach($child as $c)
                                                        @if($c->parent_id == $p->id)
                                                        <!-- Begin::Item -->
                                                        <div class="d-flex flex-stack" style="margin-left: 20px;">
                                                            <div class="d-flex">
                                                                <div class="d-flex flex-column">
                                                                    <a href="#"
                                                                        class="fs-5 text-dark text-hover-primary fw-bolder">{{ $c->name }}</a>
                                                                    <div class="fs-6 fw-bold text-muted">{{ url($c->url) }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <!-- Begin::Switch -->
                                                                <label
                                                                    class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                    <!-- Begin::Input -->
                                                                    <input class="form-check-input"
                                                                        name="menu_access_id" type="checkbox"
                                                                        value="{{ $c->id }}"
                                                                        id="menu_access_{{ $c->id }}"
                                                                        onChange="addMenuAccess(this)"
                                                                        {{ in_array($c->id, $menuAssigned) ? 'checked' : '' }}>
                                                                    <!-- End::Input -->
                                                                    <!-- Begin::Label -->
                                                                    <span
                                                                        class="form-check-label fw-bold text-muted"></span>
                                                                    <!-- End::Label -->
                                                                </label>
                                                                <!-- End::Switch -->
                                                            </div>
                                                        </div>
                                                        <!-- End::Item -->
                                                        <div class="separator separator-dashed my-5"></div>
                                                        @endif
                                                        @endforeach
                                                        @endforeach
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
<script>
$(document).ready(function() {

});

function addMenuAccess(checkbox) {

    let groupId = $("#group_id").val();
    let menuId = checkbox.value;
    let isChecked = 0;

    if (checkbox.checked == true) {
        isChecked = 1;
    }

    const requestData = {
        group_id: groupId,
        menu_id: menuId,
        is_checked: isChecked
    };

    $.ajax({
        url: `{{route('groups.update-menu-access')}}`,
        method: 'POST',
        data: requestData,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            Swal.fire(
                'Berhasil!',
                'Data berhasil di update',
                'success'
            )
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
</script>

@endsection
