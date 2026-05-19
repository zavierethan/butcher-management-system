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
                                                <label class="form-label fw-bold fs-6 mb-2">Store</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" value="{{$branch->name}}" readonly />
                                                    <input class="form-control form-control-md form-control-solid" id="branch-id"
                                                        type="hidden" value="{{$branch->id}}" readonly />
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
                                                        type="date" name="date" id="date" value="{{ date('Y-m-d') }}" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
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
                                                class="fa-solid fa-plus"></i></a></div>
                                </div>
                            </div>
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
        $('#btn-submit-ar').on('click', function() {
            var branch_id = $('#branch-id').val();
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

    function updateRowNumbers() {
        $('#kt_items_table tbody tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
        });
    }

    $('#add-row').on('click', function() {
        rowCount++;
        var row = `<tr>
            <td>${rowCount}</td>
            <td><input type="number" class="form-control form-control-md total-chicken" name="total_chicken[]" min="1" value="" /></td>
            <td><input type="number" class="form-control form-control-md weight" name="weight[]" step="0.01" value="" /></td>
            <td><input type="number" class="form-control form-control-md container-weight" name="container_weight[]" step="0.01" value="" /></td>
            <td><input type="number" class="form-control form-control-md net-weight" name="net_weight[]" step="0.01" value="" readonly /></td>
            <td class="text-center">
                <a href="#" class="btn-delete-row" title="Delete"><i class="fa-solid fa-trash-can"></i></a>
            </td>
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
    $('#kt_items_table').on('click', '.btn-delete-row', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        updateRowNumbers();
        rowCount--;
    });
});
</script>
@endsection

