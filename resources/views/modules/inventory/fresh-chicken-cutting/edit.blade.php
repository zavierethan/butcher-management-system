@extends('layouts.main')

@section('main-content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Edit Fresh Chicken Cutting</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('fresh-chicken-cutting.index') }}" class="text-muted text-hover-primary">Inventory Management</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Fresh Chicken Cutting</li>
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
                                                <label class="form-label fw-bold fs-6 mb-2">Cabang</label>
                                                <div class="position-relative mb-3">
                                                    <select class="form-select form-select-solid" name="branch_id" id="branch_id" disabled>
                                                        <option value="">-</option>
                                                        <option value="{{ $freshChickenCutting['branch_id'] }}" selected>{{ $freshChickenCutting['branch_name'] }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Tanggal</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="date" name="date" id="date" value="{{ $freshChickenCutting['date'] }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>
                                <div class="text-end">
                                    <a href="{{route('fresh-chicken-cutting.index')}}" class="btn btn-sm btn-danger">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                        <div class="card-body pt-10 overflow-x-auto">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="kt_items_table">
                                    <thead style="background-color:rgb(221, 214, 214);">
                                        <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                                            <th class="text-center" colspan="6">HASIL POTONG AYAM FRESH</th>
                                        </tr>
                                        <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                                            <th class="text-center">No.</th>
                                            <th class="min-w-70px">Jumlah Ekor</th>
                                            <th class="min-w-70px">Berat</th>
                                            <th class="min-w-70px">Berat Wadah</th>
                                            <th class="min-w-70px">Berat Bersih</th>
                                            <th class="min-w-70px text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach($freshChickenCutting['items'] as $i => $item)
                                        <tr data-id="{{ $item->id }}">
                                            <td class="text-center">{{ $i+1 }}</td>
                                            <td><input type="number" class="form-control total-chicken" name="total_chicken[]" min="1" value="{{ $item->total_chickens }}" /></td>
                                            <td><input type="number" class="form-control weight" name="weight[]" step="0.01" value="{{ $item->weight }}" /></td>
                                            <td><input type="number" class="form-control container-weight" name="container_weight[]" step="0.01" value="{{ $item->container_weight }}" /></td>
                                            <td><input type="number" class="form-control net-weight" name="net_weight[]" step="0.01" value="{{ $item->net_weight }}" readonly /></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-success btn-update-row"><i class="fa fa-save"></i> Update</button>
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-row"><i class="fa fa-trash"></i> Delete</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    // Update row
    $('#kt_items_table').on('click', '.btn-update-row', function() {
        var tr = $(this).closest('tr');
        var id = tr.data('id');
        var branch_id = $('#branch_id').val();
        var date = $('#date').val();
        var total_chicken = tr.find('.total-chicken').val();
        var weight = tr.find('.weight').val();
        var container_weight = tr.find('.container-weight').val();
        var net_weight = tr.find('.net-weight').val();

        $.ajax({
            url: `/fresh-chicken-cutting/update-row/${id}`,
            method: 'POST',
            data: {
                branch_id: branch_id,
                date: date,
                total_chicken: total_chicken,
                weight: weight,
                container_weight: container_weight,
                net_weight: net_weight,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                if(res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Row berhasil diupdate!'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal mengupdate row!'
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mengupdate row!'
                });
            }
        });
    });

    // Delete row
    $('#kt_items_table').on('click', '.btn-delete-row', function() {
        var tr = $(this).closest('tr');
        var id = tr.data('id');
        Swal.fire({
            title: 'Hapus data?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: `/fresh-chicken-cutting/delete-row/${id}`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if(res.status === 'success') {
                            tr.remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Row berhasil dihapus!'
                            });
                            // Update row numbers
                            $('#kt_items_table tbody tr').each(function(index) {
                                $(this).find('td:first').text(index+1);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal menghapus row!'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menghapus row!'
                        });
                    }
                });
            }
        });
    });

});
</script>
@endsection
