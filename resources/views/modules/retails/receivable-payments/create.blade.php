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
                        Receivable Payments</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Retails</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Receivable Payments</li>
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
                                                <label class="form-label fw-bold fs-6 mb-2">Tanggal</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="date" name="date" value="<?php echo date('Y-m-d'); ?>" id="date"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Nomor Invoice</label>
                                                <div class="position-relative mb-3">
                                                    <select class="form-select form-select-solid" data-control="select2"
                                                        data-placeholder="-" name="invoice_id" id="invoice-id">
                                                        <option value="">-</option>
                                                        @foreach($invoices as $invoice)
                                                        <option value="{{$invoice->id}}">{{$invoice->invoice_no}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Jenis Pembayaran</label>
                                                <div class="position-relative mb-3">
                                                    <select class="form-select form-select-solid" data-control="select2"
                                                        data-placeholder="-" name="payment_method" id="payment-method">
                                                        <option value="">-</option>
                                                        <option value="1">TUNAI</option>
                                                        <option value="2">TRANSFER</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Referensi</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" name="reference" id="reference"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Lampiran</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="file" name="attachment" id="attachment"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Total Bayar</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid format-number"
                                                        type="text" name="total_amount" id="total-amount"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <a href="{{route('retails.receivable-payments.index')}}" class="btn btn-danger">Kembali</a>
                                    <button type="button" class="btn btn-primary" id="btn-submit">Submit</button>
                                </div>
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
// $(document).on("keyup", "#total-amount", function() {
//     var originalVal = $(this).val();
//     var formattedVal = formatNumber(originalVal);
//     $(this).val(formattedVal);
// });

$(document).on('keyup', '.format-number', function () {

    let value = $(this).val().replace(/\D/g, '');

    $(this).val(new Intl.NumberFormat('en-US').format(value));
});

$(document).on('click', '#btn-submit', function(e) {
    e.preventDefault();

    // Validasi field wajib diisi
    let invoiceId = $('#invoice-id').val();
    let paymentMethod = $('#payment-method').val();
    let totalAmount = $('#total-amount').val().replace(/,/g, '');

    if (!invoiceId) {
        Swal.fire({
            title: 'Nomor Invoice wajib diisi',
            icon: 'warning',
            confirmButtonText: 'Ok'
        });
        return;
    }

    if (!paymentMethod) {
        Swal.fire({
            title: 'Jenis Pembayaran wajib diisi',
            icon: 'warning',
            confirmButtonText: 'Ok'
        });
        return;
    }

    if (!totalAmount || parseFloat(totalAmount) <= 0) {
        Swal.fire({
            title: 'Total Bayar wajib diisi dan harus lebih besar dari 0',
            icon: 'warning',
            confirmButtonText: 'Ok'
        });
        return;
    }

    if (true) {
        Swal.fire({
            title: 'Apakah anda yakin untuk memproses data ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();

                let amount = parseFloat($('#total-amount').val().replace(/,/g, '')) || 0;

                formData.append('date', $('#date').val());
                formData.append('invoice_id', $('#invoice-id').val());
                formData.append('payment_method', $('#payment-method').val());
                formData.append('amount', amount);

                $.ajax({
                    url: `{{route('retails.receivable-payments.save')}}`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire({
                            title: 'Suceess !',
                            text: `Data berhasil di simpan`,
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        }).then((result) => {
                            location.href =
                                `{{ route('retails.receivable-payments.index') }}`;
                        });
                    },
                    error: function(xhr, status, error) {
                        let message = 'Terjadi kesalahan';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            try {
                                let res = JSON.parse(xhr.responseText);
                                message = res.message || message;
                            } catch (e) {
                                message = xhr.responseText;
                            }
                        }

                        console.log("ERROR:", xhr);

                        Swal.fire('Error!', message, 'error');
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
