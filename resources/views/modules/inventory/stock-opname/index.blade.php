@extends('layouts.main')
@section('css')

@endsection

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
                        Stock Opname</h1>
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
                        <li class="breadcrumb-item text-muted">Stock Opname</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Secondary button-->
                    <a href="{{route('stock-opname.create')}}" class="btn btn-sm fw-bold btn-primary" id="btn-form-export">CREATE</a>
                    <!--end::Secondary button-->
                </div>
                <!--end::Actions-->
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
                    <!--begin::Table-->
                    <div class="card">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-6">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->

                                <!--end::Search-->
                            </div>
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Filters-->
                                <div class="d-flex flex-stack flex-wrap gap-4">
                                    <div class="d-flex align-items-center fw-bold">
                                        <!--begin::Label-->
                                        <div class="text-gray-500 fs-7 me-2">Tanggal</div>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <input type="date" class="form-control form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto" id="date" value="{{ date('Y-m-d') }}"/>
                                        <!--end::Select-->
                                    </div>
                                </div>
                                <!--begin::Filters-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 overflow-x-auto">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_transactions_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">TANGGAL</th>
                                        <th class="min-w-125px">NAMA PRODUK</th>
                                        <th class="min-w-125px">HASIL SO (KG)</th>
                                        <th class="min-w-100px text-center">ACTIONS</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>

<div class="modal fade" id="kt_modal_export_filter" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header pb-0 border-0 justify-content-end">
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('.loader').hide();

    const table = $("#kt_transactions_table").DataTable({
        processing: true,
        order: [
            [0, 'desc']
        ],
        serverSide: true,
        paging: true, // Enable pagination
        pageLength: 50, // Number of rows per page
        ajax: {
            url: `{{route('stock-opname.lists')}}`, // Replace with your route
            type: 'GET',
            data: function (d) {
                d.date = $('#date').val();
            },
            dataSrc: function(json) {
                return json.data; // Map the 'data' field
            }
        },
        columns: [
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'product_name',
                name: 'product_name'
            },
            {
                data: 'quantity',
                name: 'quantity',
                className: 'text-end'
            },
            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    return `
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-sm btn-icon btn-light-primary btn-edit"
                                data-id="${data}"
                                title="Edit">
                                <i class="ki-duotone ki-pencil fs-5">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </button>
                        </div>
                    `;
                }
            }
        ]
    });

    // Event listener untuk tombol Edit
    $(document).on('click', '.btn-edit', function() {
        const id = $(this).data('id');

        // Fetch data untuk menampilkan di modal
        $.ajax({
            url: `{{route('stock-opname.edit', '')}}/${id}`,
            type: 'GET',
            success: function(data) {
                // Tampilkan SweetAlert dengan form edit
                Swal.fire({
                    title: 'Edit Stock Opname',
                    html: `
                        <div class="text-start">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Produk</label>
                                <div class="form-control bg-light" disabled>
                                    ${data.product_name} (${data.product_code})
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal</label>
                                <input type="date" id="edit_date" class="form-control" value="${data.date}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Hasil SO (KG)</label>
                                <input type="number" id="edit_quantity" class="form-control" value="${data.quantity}" step="0.01" min="0">
                            </div>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#009EF7',
                    cancelButtonColor: '#d33',
                    preConfirm: () => {
                        const date = document.getElementById('edit_date').value;
                        const quantity = document.getElementById('edit_quantity').value;

                        if (!date) {
                            Swal.showValidationMessage('Tanggal harus diisi');
                            return false;
                        }
                        if (!quantity) {
                            Swal.showValidationMessage('Hasil SO harus diisi');
                            return false;
                        }

                        return { date, quantity };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan konfirmasi sebelum update
                        Swal.fire({
                            title: 'Konfirmasi Update',
                            text: 'Apakah anda yakin ingin mengupdate data ini?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, Update!',
                            cancelButtonText: 'Batal'
                        }).then((confirmResult) => {
                            if (confirmResult.isConfirmed) {
                                // Proses update
                                $.ajax({
                                    url: `{{route('stock-opname.update', '')}}/${id}`,
                                    type: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: {
                                        date: result.value.date,
                                        quantity: result.value.quantity,
                                        _method: 'POST'
                                    },
                                    success: function(response) {
                                        Swal.fire({
                                            title: 'Berhasil!',
                                            text: response.message,
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(() => {
                                            table.draw(); // Refresh table
                                        });
                                    },
                                    error: function(xhr) {
                                        let errorMsg = 'Terjadi kesalahan';
                                        if (xhr.responseJSON && xhr.responseJSON.error) {
                                            errorMsg = xhr.responseJSON.error;
                                        }
                                        Swal.fire({
                                            title: 'Error!',
                                            text: errorMsg,
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal mengambil data',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    $('#date').on('change', function () {
        table.draw(); // Trigger DataTable redraw with updated filter values
    });
});
</script>
@endsection
