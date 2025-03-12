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
                            <div class="row mb-5">
                                <div class="col-md-12 text-end">

                                </div>
                            </div>
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_items_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">HARGA AYAM HIDUP</th>
                                        <th class="min-w-125px">PRM KKS</th>
                                        <th class="min-w-125px">PRM KKS TG</th>
                                        <th class="min-w-125px">PRM FDK</th>
                                        <th class="min-w-125px">PRM FDB</th>
                                        <th class="min-w-125px">PRM FPK</th>
                                        <th class="min-w-125px">PRM FPB</th>
                                        <th class="min-w-125px">PRM DGL</th>
                                        <th class="min-w-125px">MARGIN (%)</th>
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
                                                    class="form-control form-control-sm inline-edit-end-period me-2" id="raw-material-price"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2" id="prm-kks" value="1.4"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2" id="prm-kks-tg" value="4000"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2" id="prm-fdk" value="1.2"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2" id="prm-fdb" value="1.3"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2" id="prm-fpk" value="1.2"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2" id="prm-fpb" value="1.3"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2" id="prm-dgl" value="1.3"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="number"
                                                    class="form-control form-control-sm inline-edit-end-period me-2" id="margin" value="10"/>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                            <div class="text-end">
                                <a href="{{route('branches.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="btn-generate-price">Generate Price</a>
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
                                        <th class="">No.</th>
                                        <th class="min-w-125px">Product Name</th>
                                        <th class="min-w-125px">COGS</th>
                                        <th class="min-w-125px">Sale Price</th>
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
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <td>@php echo $num++ @endphp.</td>
                                        <td>{{$product->name}} ({{$product->code}})
                                            <input type="hidden" class="form-control form-control-sm inline-edit-end-period me-2 product_id" value="{{$product->id}}" />
                                            <input type="hidden" class="form-control form-control-sm inline-edit-end-period me-2 branch_id" value="{{$product->branch_id}}" />
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 COGS-{{$product->code}} cogs" value="{{$product->base_price}}" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 SALE-PRICE-{{$product->code}} sale-price" value="{{$product->price}}" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 discount" value="{{$product->discount}}" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="date"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 disc-start-period" value="{{$product->start_period}}" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="date"
                                                    class="form-control form-control-sm inline-edit-end-period me-2 disc-end-period" value="{{$product->end_period}}" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <label
                                                    class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input toggle-status" type="checkbox" data-id="{{$product->code}}" <?php echo ($product->is_active == 1) ? "checked" : ""; ?> />
                                                    <span class="form-check-label fw-bold text-muted"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
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
$('#kt_modal_add_item').on('shown.bs.modal', function() {
    $('#purhcase-request').select2({
        dropdownParent: $('#kt_modal_add_item') // Ensure dropdown stays inside modal
    });
});

$(document).on('click', '#btn-generate-price', function() {
    var rawMaterialPrice = parseFloat($("#raw-material-price").val());

    var prmKks = parseFloat($("#prm-kks").val());
    var prmKksTg = parseFloat($("#prm-kks-tg").val());

    var prmFdk = parseFloat($("#prm-fdk").val());
    var prmFdb = parseFloat($("#prm-fdb").val());
    var prmFpk = parseFloat($("#prm-fpk").val());
    var prmFpb = parseFloat($("#prm-fpb").val());
    var prmDgl = parseFloat($("#prm-dgl").val());

    var margin = parseFloat($("#margin").val()) / 100;

    var karkasPrice = Math.round(rawMaterialPrice*prmKks);

    var cogsKksTg = karkasPrice + prmKksTg;

    var cogsFdk = karkasPrice*prmFdk;
    var cogsFdb = karkasPrice*prmFdb;
    var cogsFpk = karkasPrice*prmFpk;
    var cogsFpb = karkasPrice*prmFpb;

    var cogsDgl = (karkasPrice*prmDgl) + 3000;

    $(".COGS-KKS").val(karkasPrice);
    $(".COGS-TG").val(cogsKksTg);
    $(".COGS-DD").val(karkasPrice);
    $(".COGS-PH").val(karkasPrice);
    $(".COGS-PHA").val(karkasPrice);
    $(".COGS-PHP").val(karkasPrice);
    $(".COGS-SY").val(karkasPrice);

    $(".COGS-FDK").val(cogsFdk);
    $(".COGS-FDB").val(cogsFdb);
    $(".COGS-FPK").val(cogsFpk);
    $(".COGS-FPB").val(cogsFpb);

    $(".COGS-DGL").val(cogsDgl);


    // KARKAS
    $(".SALE-PRICE-KKS").val(karkasPrice + (karkasPrice * margin));
    $(".SALE-PRICE-TG").val(cogsKksTg + (cogsKksTg * margin));
    $(".SALE-PRICE-DD").val(karkasPrice + (karkasPrice * margin));
    $(".SALE-PRICE-PH").val(karkasPrice + (karkasPrice * margin));
    $(".SALE-PRICE-PHA").val(karkasPrice + (karkasPrice * margin));
    $(".SALE-PRICE-PHP").val(karkasPrice + (karkasPrice * margin));
    $(".SALE-PRICE-SY").val(karkasPrice + (karkasPrice * margin));

    $(".SALE-PRICE-FDK").val(cogsFdk + (cogsFdk * margin));
    $(".SALE-PRICE-FDB").val(cogsFdb + (cogsFdb * margin));
    $(".SALE-PRICE-FPK").val(cogsFpk + (cogsFpk * margin));
    $(".SALE-PRICE-FPB").val(cogsFpb + (cogsFpb * margin));
    $(".SALE-PRICE-DGL").val(cogsDgl + (cogsDgl * margin));

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

                $("#product-table tr").each(function () {
                    let product = {
                        id: $(this).find(".product_id").val(),
                        branch_id: $(this).find(".branch_id").val(),
                        cogs: $(this).find(".cogs").val(),
                        sale_price: $(this).find(".sale-price").val(),
                        discount: $(this).find(".discount").val(),
                        disc_start: $(this).find(".disc-start-period").val(),
                        disc_end: $(this).find(".disc-end-period").val(),
                        active_status: $(this).find(".toggle-status").is(":checked") ? 1 : 0
                    };
                    products.push(product);
                });

                console.log(products);

                $.ajax({
                    url: `{{route('branches.product-setting-bulk-update')}}`,
                    type: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify({ products: products }),
                    success: function(response) {
                        Swal.fire({
                            title: 'Suceess !',
                            text: `Data product berhasil di perbaharui`,
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        }).then((result) => {
                           // Redirect the current page to the transaction index
                            location.href = `{{ route('branches.index') }}`;
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

function formatNumber(numStr) {
    let cleaned = numStr.replace(/[^\d.]/g, '');
    const parts = cleaned.split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join('.');
}
</script>
@endsection
