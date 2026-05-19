@extends('layouts.main')

@section('main-content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Hasil Potong Ayam Fresh</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('fresh-chicken-cutting.index') }}" class="text-muted text-hover-primary">Inventory Management</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Hasil Potong Ayam Fresh</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
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
                                                    <select class="form-select form-select-solid" name="branch_id" id="branch_id" disabled>
                                                        <option value="">-</option>
                                                        <option value="{{ $freshChickenCutting['branch_id'] }}" selected>{{ $freshChickenCutting['branch_name'] }}</option>
                                                    </select>
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
                                                        type="date" name="date" id="date" value="{{ $freshChickenCutting['date'] }}" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <a href="{{route('fresh-chicken-cutting.index')}}" class="btn btn-sm btn-danger">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                        <div class="card-body pt-10 overflow-x-auto">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_items_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <th>NO.</th>
                                        <th class="min-w-125px text-center">Jumlah Ekor</th>
                                        <th class="min-w-125px">Berat (Kg)</th>
                                        <th class="min-w-125px">Berat Wadah (Kg)</th>
                                        <th class="min-w-125px">Berat Bersih (Kg)</th>
                                        <th class="min-w-125px text-center">ACTION</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table body-->
                                <tbody class="fw-bold text-gray-600" id="product-table">
                                    @php $counting = 1; @endphp
                                    @foreach($freshChickenCutting['items'] as $item)
                                    <tr data-id="{{ $item->id }}">
                                        <td>{{$counting++}}</td>
                                        <td>
                                            <input type="number" class="form-control form-control-md total-chicken" name="total_chicken" min="1" value="{{ $item->total_chickens }}" />
                                            <input type="hidden" name="id" value="{{ $item->id }}" />
                                        </td>
                                        <td><input type="number" class="form-control form-control-md weight" name="weight" step="0.01" value="{{ $item->weight }}" /></td>
                                        <td><input type="number" class="form-control form-control-md container-weight" name="container_weight" step="0.01" value="{{ $item->container_weight }}" /></td>
                                        <td><input type="number" class="form-control form-control-md net-weight" name="net_weight" step="0.01" value="{{ $item->net_weight }}" readonly /></td>
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
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
$(document).ready(function() {
    // Perhitungan otomatis net_weight
    $('#kt_items_table').on('input', '.weight, .container-weight', function() {
        var tr = $(this).closest('tr');
        var weight = parseFloat(tr.find('.weight').val()) || 0;
        var containerWeight = parseFloat(tr.find('.container-weight').val()) || 0;
        var netWeight = weight - containerWeight;
        tr.find('.net-weight').val(netWeight > 0 ? netWeight : 0);
    });
});

$(document).on('click', '.btn-update-row', function(e) {
    e.preventDefault();

    const row = $(this).closest('tr');
    const itemId = row.find('input[name="id"]').val();
    const totalChicken = row.find('input[name="total_chicken"]').val();
    const weight = row.find('input[name="weight"]').val();
    const containerWeight = row.find('input[name="container_weight"]').val();
    const netWeight = row.find('input[name="net_weight"]').val();

    if (!totalChicken || totalChicken <= 0) {
        Swal.fire({
            title: 'Perhatian!',
            text: 'Jumlah ekor tidak boleh kosong atau 0',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return;
    }

    if (!weight || weight <= 0) {
        Swal.fire({
            title: 'Perhatian!',
            text: 'Berat tidak boleh kosong atau 0',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return;
    }

    Swal.fire({
        title: 'Konfirmasi Update',
        html: `Apakah Anda yakin akan mengupdate data dengan:<br><br>
                <b>Jumlah Ekor:</b> ${totalChicken}<br>
                <b>Berat:</b> ${weight} Kg<br>
                <b>Berat Wadah:</b> ${containerWeight} Kg<br>
                <b>Berat Bersih:</b> ${netWeight} Kg`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Update!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ route('fresh-chicken-cutting.update') }}`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: itemId,
                    total_chicken: totalChicken,
                    weight: weight,
                    container_weight: containerWeight,
                    net_weight: netWeight
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
    const totalChicken = row.find('input[name="total_chicken"]').val();
    const weight = row.find('input[name="weight"]').val();

    Swal.fire({
        title: 'Konfirmasi Hapus',
        html: `Apakah Anda yakin akan menghapus data dengan jumlah ekor <b>${totalChicken}</b> dan berat <b>${weight} Kg</b>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/fresh-chicken-cutting/${itemId}`,
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
</script>
@endsection
