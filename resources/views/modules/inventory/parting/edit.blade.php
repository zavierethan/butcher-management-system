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
                        Hasil Parting</h1>
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
                        <li class="breadcrumb-item text-muted">Hasil Parting</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Edit</li>
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
                                <input type="hidden" id="parting-date" value="{{$parting['date']}}" />
                                <input type="hidden" id="branch-id-val" value="{{$parting['branch_id']}}" />
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Store</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" value="{{$parting['branch_name']}}" readonly />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Tanggal</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="date" name="parting_date" id="parting_date"
                                                        value="{{$parting['date']}}" readonly />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <a href="{{route('partings.index')}}" class="btn btn-sm btn-danger">Kembali</a>
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
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_items_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="">NO.</th>
                                            <th class="min-w-250px">NAMA PRODUK</th>
                                            <th class="min-w-125px">KUANTITAS (KG)</th>
                                            <th class="min-w-125px text-center">ACTION</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table body-->
                                    <tbody class="fw-bold text-gray-600" id="product-table">
                                        @php $counting = 1; @endphp
                                        @foreach($parting['items'] as $item)
                                        <tr>
                                            <td>{{$counting++}}</td>
                                            <td>
                                                <div class="position-relative">
                                                    <select class="form-select me-2 product-id" data-control="select2"
                                                        name="product_id">
                                                        <option value="">-</option>
                                                        @foreach($products as $p)
                                                        <option value="{{$p->id}}"
                                                            {{$item->product_id == $p->id ? 'selected' : ''}}>
                                                            {{$p->name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="id" value="{{$item->id}}" />
                                                </div>
                                            </td>
                                            <td>
                                                <input class="form-control form-control-md me-2 quantity" type="text" name="quantity" value="{{$item->quantity}}" />
                                            </td>
                                            <td class="text-center">
                                                <a href="#" class="btn-update-row me-6" title="Update"><i class="fa-solid fa-save text-primary"></i></a>
                                                <a href="#" class="btn-delete-row" title="Delete"><i class="fa-solid fa-trash-can text-danger"></i></a>
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

$(document).on("keyup", "input[name='quantity']", function() {
    var originalVal = $(this).val();
    var formattedVal = formatNumber(originalVal);
    $(this).val(formattedVal);
});

$(document).on('click', '.btn-update-row', function(e) {
    e.preventDefault();

    const row = $(this).closest('tr');
    const itemId = row.find('input[name="id"]').val();
    const productId = row.find('.product-id').val();
    const productName = row.find('.product-id').find('option:selected').text();
    const quantity = row.find('input[name="quantity"]').val();

    if (!productId) {
        Swal.fire({
            title: 'Perhatian!',
            text: 'Silahkan pilih produk terlebih dahulu',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return;
    }

    if (!quantity || parseFloat(quantity.replace(/,/g, '')) <= 0) {
        Swal.fire({
            title: 'Perhatian!',
            text: 'Kuantitas tidak boleh kosong atau 0',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return;
    }

    Swal.fire({
        title: 'Konfirmasi Update',
        html: `Apakah Anda yakin akan mengupdate produk <b>${productName}</b> dengan kuantitas <b>${quantity}</b>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Update!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ route('partings.update') }}`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: itemId,
                    product_id: productId,
                    quantity: quantity.replace(/,/g, '')
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success'
                    });
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'Terjadi kesalahan saat mengupdate data';
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error'
                    });
                }
            });
        }
    });
});

$(document).on('click', '.btn-delete-row', function(e) {
    e.preventDefault();

    const row = $(this).closest('tr');
    const itemId = row.find('input[name="id"]').val();
    const productName = row.find('.product-id').find('option:selected').text();

    Swal.fire({
        title: 'Konfirmasi Hapus',
        html: `Apakah Anda yakin akan menghapus produk <b>${productName}</b>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/partings/${itemId}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success'
                    }).then(() => {
                        row.remove();
                    });
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'Terjadi kesalahan saat menghapus data';
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error'
                    });
                }
            });
        }
    });
});

function formatNumber(numStr) {
    let cleaned = numStr.replace(/[^\d.]/g, '');
    const parts = cleaned.split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join('.');
}
</script>
@endsection
