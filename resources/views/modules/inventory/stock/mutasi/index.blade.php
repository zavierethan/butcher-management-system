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
                        Mutasi</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Inventories</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Stocks</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Mutasi</li>
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
                            <form class="w-[60%]">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Store</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" value="{{$branch->name}}" readonly />
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="hidden" value="{{$branch->id}}" readonly />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Tanggal Mutasi</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="date" name="date" id="date" value="<?php echo date("Y-m-d"); ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <a href="{{route('stocks.index')}}"
                                        class="btn btn-sm btn-danger">Cancel</a>
                                    <button type="button" class="btn btn-sm btn-primary"
                                        id="btn-submit-mutasi">Submit</button>
                                </div>
                            </form>
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
                                <div class="col-md-12 text-end"><a class="btn btn-sm btn-primary" id="add-row"><i
                                            class="fa-solid fa-plus"></i></a></div>
                            </div>
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_items_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-250px">NAMA PRODUK</th>
                                        <th class="min-w-125px">JENIS MUTASI</th>
                                        <th class="min-w-125px">MUTASI KE / DARI</th>
                                        <th class="min-w-125px">KUANTITAS (KG)</th>
                                        <th class="min-w-125px text-center">ACTION</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600" id="product-table">
                                    <tr>
                                        <td>
                                            <div class="position-relative">
                                                <select class="form-select me-2 stock-id" data-control="select2"
                                                    name="stock_id">
                                                    <option value="">-</option>
                                                    @foreach($stocks as $stock)
                                                    <option value="{{$stock->stock_id}}">
                                                        {{$stock->product_name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="position-relative">
                                                <select class="form-select me-2 type" data-control="select2"
                                                    name="type">
                                                    <option value="">-</option>
                                                    <option value="IN">IN</option>
                                                    <option value="OUT">OUT</option>
                                                    <option value="PRIVE">PRIVE</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="position-relative">
                                                <select class="form-select me-2 destination" data-control="select2"
                                                    name="destination">
                                                    <option value="">-</option>
                                                    @foreach($branches as $b)
                                                    <option value="{{$b->id}}">
                                                        {{$b->name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td><input class="form-control form-control-md me-2 quantity" type="text"
                                            name="quantity" value="0" /></td>
                                        <td class="text-center">
                                            <a href="#"><i class="fa-solid fa-trash-can"></i></a>
                                        </td>
                                    </tr>
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

    $("#add-row").on("click", function() {
        var row = `<tr>
                    <td>
                        <div class="position-relative">
                            <select class="form-select me-2 stock-id" data-control="select2"
                                name="stock">
                                <option value="">-</option>
                                @foreach($stocks as $stock)
                                <option value="{{$stock->stock_id}}">
                                    {{$stock->product_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="position-relative">
                            <select class="form-select me-2 type" data-control="select2" name="type">
                                <option value="">-</option>
                                <option value="IN">IN</option>
                                <option value="OUT">OUT</option>
                                <option value="PRIVE">PRIVE</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="position-relative">
                            <select class="form-select me-2 destination" data-control="select2"
                                name="destination">
                                <option value="">-</option>
                                @foreach($branches as $b)
                                    <option value="{{$b->id}}">
                                        {{$b->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td><input class="form-control form-control-md me-2 quantity" type="text"
                            name="quantity" value="0" /></td>
                    <td class="text-center">
                        <a href="#"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>`;

        $("#kt_items_table tbody").append(row);

        $("#kt_items_table tbody tr:last").find('select[data-control="select2"]').select2();
    });
});

$(document).on("click", "#kt_items_table tbody a", function(e) {
    e.preventDefault();
    $(this).closest("tr").remove();
});

$(document).on("keyup", "input[name='quantity']", function() {
    var originalVal = $(this).val();
    var formattedVal = formatNumber(originalVal);
    $(this).val(formattedVal);
});

$(document).on('click', '#btn-submit-mutasi', function(e) {
    e.preventDefault();

    if (true) {
        Swal.fire({
            title: 'Apakah anda yakin melakukan submit hasi Mutasi ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya, Submit Data'
        }).then((result) => {
            if (result.isConfirmed) {
                let products = [];

                let date = $("#date").val();

                $("#product-table tr").each(function() {
                    let product = {
                        stock_id: $(this).find(".stock-id").val(),
                        type: $(this).find(".type").val(),
                        quantity: $(this).find(".quantity").val(),
                        destination: $(this).find(".destination").val(),
                        date: date,
                    };
                    products.push(product);
                });

                $.ajax({
                    url: `{{route('stocks.mutasi-save')}}`,
                    type: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify({
                        products: products
                    }),
                    success: function(response) {
                        Swal.fire({
                            title: 'Suceess !',
                            text: `Data Mutasi berhasil di submit.`,
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        }).then((result) => {
                            // Redirect the current page to the transaction index
                            location.href = `{{ route('stocks.index') }}`;
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
