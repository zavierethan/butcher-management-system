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
                        Mutasi Product</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Inventory Management</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Mutasi Product</li>
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Store</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" value="{{ isset($branch_id) ? (optional(\DB::table('branches')->find($branch_id))->name) : '' }}" readonly />
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="hidden" value="{{ $branch_id ?? '' }}" readonly />
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
                                                        type="date" name="date" id="date" value="{{ isset($mutation_date) ? date('Y-m-d', strtotime($mutation_date)) : date('Y-m-d') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <a href="{{route('mutasi.index')}}"
                                        class="btn btn-sm btn-danger">Kembali</a>
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
                            <!-- <div class="row mb-5">
                                <div class="col-md-12 text-end"><a class="btn btn-sm btn-primary" id="add-row"><i
                                            class="fa-solid fa-plus"></i></a></div>
                            </div> -->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_items_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-250px">NAMA PRODUK</th>
                                        <th class="min-w-125px">TIPE</th>
                                        <th class="min-w-125px">KATEGORI</th>
                                        <th class="min-w-125px">KUANTITAS (KG)</th>
                                        <th class="min-w-125px">KETERANGAN</th>
                                        <th class="min-w-125px text-center">ACTION</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600" id="product-table">
                                    @if(isset($mutasi) && count($mutasi) > 0)
                                        @foreach($mutasi as $row)
                                        <tr>
                                            <td>
                                                <div class="position-relative">
                                                    <select class="form-select me-2 stock-id" data-control="select2" name="stock_id">
                                                        <option value="">-</option>
                                                        @foreach($stocks as $stock)
                                                        <option value="{{$stock->stock_id}}" {{ $row->stock_id == $stock->stock_id ? 'selected' : '' }}>
                                                            {{$stock->product_name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="position-relative">
                                                    <select class="form-select me-2 type" data-control="select2" name="type">
                                                        <option value="">-</option>
                                                        <option value="IN" {{ $row->mutation_type == 'IN' ? 'selected' : '' }}>IN</option>
                                                        <option value="OUT" {{ $row->mutation_type == 'OUT' ? 'selected' : '' }}>OUT</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                            <div class="position-relative">
                                                <select class="form-select me-2 category" data-control="select2"
                                                    name="category">
                                                    <option value="">-</option>
                                                    <option value="MUTASI" {{ $row->category == 'MUTASI' ? 'selected' : '' }}>MUTASI</option>
                                                    <option value="PRIVE" {{ $row->category == 'PRIVE' ? 'selected' : '' }}>PRIVE</option>
                                                    <option value="MASUK" {{ $row->category == 'MASUK' ? 'selected' : '' }}>MASUK</option>
                                                    <option value="RETURN" {{ $row->category == 'RETURN' ? 'selected' : '' }}>RETURN</option>
                                                    <option value="SEDEKAH" {{ $row->category == 'SEDEKAH' ? 'selected' : '' }}>SEDEKAH</option>
                                                    <option value="BONUS" {{ $row->category == 'BONUS' ? 'selected' : '' }}>BONUS</option>
                                                </select>
                                            </div>
                                        </td>
                                            <td><input class="form-control form-control-md me-2 quantity" type="text" name="quantity" value="{{ $row->quantity }}" /></td>
                                            <td>
                                                <textarea type="text" class="form-control form-control-sm remarks">{{ $row->remarks }}</textarea>
                                            </td>
                                            <td class="text-center">
                                                <input type="hidden" name="id" value="{{ $row->id }}" />
                                                <a href="#" class="btn-update-row me-6" title="Update"><i class="fa-solid fa-save text-primary"></i></a>
                                                <a href="#" class="btn-delete-row" title="Delete"><i class="fa-solid fa-trash-can text-danger"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No data found.</td>
                                        </tr>
                                    @endif
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
$(document).on('click', '.btn-update-row', function(e) {
    e.preventDefault();

    const row = $(this).closest('tr');
    const mutationId = row.find('input[name="id"]').val();
    const productName = row.find('.stock-id').find('option:selected').text();
    const mutationType = row.find('.type').find('option:selected').text();
    const quantity = row.find('.quantity').val();

    if (!row.find('.stock-id').val()) {
        Swal.fire({
            title: 'Perhatian!',
            text: 'Silahkan pilih produk terlebih dahulu',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return;
    }

    if (!row.find('.type').val()) {
        Swal.fire({
            title: 'Perhatian!',
            text: 'Silahkan pilih tipe mutasi terlebih dahulu',
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
        html: `Apakah Anda yakin akan mengupdate data mutasi?<br><br>
                <b>Produk:</b> ${productName}<br>
                <b>Tipe Mutasi:</b> ${mutationType}<br>
                <b>Kuantitas:</b> ${quantity}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Update!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ route('mutasi.update', ['id' => 0]) }}`.replace('/0', '/' + mutationId),
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: mutationId,
                    stock_id: row.find('.stock-id').val(),
                    type: row.find('.type').val(),
                    quantity: quantity.replace(/,/g, ''),
                    remarks: row.find('.remarks').val()
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
    const mutationId = row.find('input[name="id"]').val();
    const productName = row.find('.stock-id').find('option:selected').text();
    const mutationType = row.find('.type').find('option:selected').text();
    const quantity = row.find('.quantity').val();

    Swal.fire({
        title: 'Konfirmasi Hapus',
        html: `Apakah Anda yakin akan menghapus data mutasi?<br><br>
                <b>Produk:</b> ${productName}<br>
                <b>Tipe Mutasi:</b> ${mutationType}<br>
                <b>Kuantitas:</b> ${quantity}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/mutasi/${mutationId}`,
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
                        remarks: $(this).find(".remarks").val(),
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
                            location.href = `{{ route('mutasi.index') }}`;
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
