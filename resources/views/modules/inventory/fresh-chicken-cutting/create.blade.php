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
                        Fresh Chicken Cutting</h1>
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
                        <li class="breadcrumb-item text-muted">Fresh Chicken Cutting</li>
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
                            <form class="w-[60%]">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Cabang</label>
                                                <div class="position-relative mb-3">
                                                    <select class="form-select form-select-solid" data-control="select2"
                                                        data-placeholder="-" name="branch_id" id="branch_id" disabled>
                                                        <option value="">-</option>
                                                        @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}" <?php echo (Auth::user()->branch_id == $branch->id) ? "selected" : ""; ?>>{{ $branch->name }}</option>
                                                        @endforeach
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
                                                        type="date" name="date" id="date" value="{{ date('Y-m-d') }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                    <div class="col-md-6">

                                    </div>
                                </div>
                                <div class="text-end">
                                    <a href="{{route('fresh-chicken-cutting.index')}}" class="btn btn-sm btn-danger">Kembali</a>
                                    <button type="button" class="btn btn-sm btn-primary"
                                        id="btn-submit-ar">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card body-->
                        <div class="card-body pt-10 overflow-x-auto">
                            <div class="row mb-5">
                                <div class="col-md-6">

                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12 text-end"><a class="btn btn-sm btn-primary" id="add-row"><i
                                                class="fa-solid fa-plus"></i>Tambah Hasil Potong</a></div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <!--begin::Table-->
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
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
        $('#btn-submit-ar').on('click', function() {
            var branch_id = $('#branch_id').val();
            var date = $('#date').val();
            var items = [];
            $('#kt_items_table tbody tr').each(function() {
                var total_chicken = $(this).find('.total-chicken').val();
                var weight = $(this).find('.weight').val();
                var container_weight = $(this).find('.container-weight').val();
                var net_weight = $(this).find('.net-weight').val();
                items.push({
                    total_chicken: total_chicken,
                    weight: weight,
                    container_weight: container_weight,
                    net_weight: net_weight
                });
            });

            if(items.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Silakan tambahkan minimal satu hasil potong!'
                });
                return;
            }

            $.ajax({
                url: "{{ route('fresh-chicken-cutting.save') }}",
                method: 'POST',
                data: {
                    branch_id: branch_id,
                    date: date,
                    items: items,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if(res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil disimpan!'
                        }).then(() => {
                            window.location.href = "{{ route('fresh-chicken-cutting.index') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal menyimpan data!'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menyimpan data!'
                    });
                }
            });
        });
    var rowCount = 0;
    $('#add-row').on('click', function() {
        rowCount++;
        var row = `<tr>
            <td class="text-center">${rowCount}</td>
            <td><input type="number" class="form-control total-chicken" name="total_chicken[]" min="1" value="" /></td>
            <td><input type="number" class="form-control weight" name="weight[]" step="0.01" value="" /></td>
            <td><input type="number" class="form-control container-weight" name="container_weight[]" step="0.01" value="" /></td>
            <td><input type="number" class="form-control net-weight" name="net_weight[]" step="0.01" value="" readonly /></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-delete-row"><i class="fa fa-trash"></i> Delete</button></td>
        </tr>`;
        $('#kt_items_table tbody').append(row);
    });

    // Hitung net_weight otomatis saat weight/container_weight berubah
    $('#kt_items_table').on('input', '.weight, .container-weight', function() {
        var tr = $(this).closest('tr');
        var weight = parseFloat(tr.find('.weight').val()) || 0;
        var containerWeight = parseFloat(tr.find('.container-weight').val()) || 0;
        var netWeight = weight - containerWeight;
        tr.find('.net-weight').val(netWeight > 0 ? netWeight : 0);
    });

    // Delete row
    $('#kt_items_table').on('click', '.btn-delete-row', function() {
        $(this).closest('tr').remove();
        // Update row numbers
        rowCount = 0;
        $('#kt_items_table tbody tr').each(function() {
            rowCount++;
            $(this).find('td:first').text(rowCount);
        });
    });
});
</script>
@endsection

