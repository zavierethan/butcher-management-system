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
                        Invoices</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Finances</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Invoices</li>
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
                                                <label class="form-label fw-bold fs-6 mb-2">Nama Customer</label>
                                                <div class="position-relative mb-3">
                                                    <select class="form-select form-select-solid" data-control="select2"
                                                        data-placeholder="-" name="customer" id="customer">
                                                        <option value="">-</option>
                                                        @foreach($customers as $customer)
                                                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Tanggal Invoice</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="date" name="invoice_date" id="invoice-date" value="<?php echo date('Y-m-d'); ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Periode Transaksi</label>
                                                <div class="d-flex gap-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="date" name="transaction_period_start" id="transaction-period-start" value="{{ date('Y-m-01') }}" />
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="date" name="transaction_period_end" id="transaction-period-end" value="{{ date('Y-m-d') }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Total Tagihan</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" name="total_billed" id="total-billed" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <a href="{{route('finances.account-receivable.index')}}"
                                        class="btn btn-sm btn-danger">Kembali</a>
                                    <button type="button" class="btn btn-sm btn-primary"
                                        id="btn-submit">Submit & Cetak Invoice</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card body-->
                        <div class="card-body pt-10 overflow-x-auto">
                            <div class="row mb-5">
                                <div class="col-md-12 text-end"><a class="btn btn-sm btn-primary" id="btn-open-receivable-modal"><i class="fa-solid fa-plus"></i>Pilih
                                        Transaksi</a></div>
                            </div>
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_items_table">
                                    <thead>
                                        <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                                            <th class="text-center">Action</th>
                                            <th class="">Tanggal</th>
                                            <th class="">Nomor Transaksi</th>
                                            <th class="text-end">Total Amount</th>
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

<div class="modal fade" id="kt_modal_add_item" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-800px">
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
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                <!--begin::Heading-->
                <div class="text-center mb-13">
                    <!--begin::Title-->
                    <h1 class="mb-3">Tambah Transaksi</h1>
                    <!--end::Title-->
                </div>
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_receivable_items_modal">
                        <thead>
                            <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-70px">Tanggal Transaksi</th>
                                <th class="min-w-70px">Nomor Transaksi</th>
                                <th class="min-w-70px">Total Transaksi</th>
                                <th class="min-w-70px text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">

                        </tbody>
                    </table>
                    <!--end::Table-->
                </div>
                <div class="separator my-5"></div>
                <div class="text-end">
                    <button type="button" class="btn btn-primary" id="btn-form-add-receivable-item">Tambahkan</button>
                </div>
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
@endsection

@section('script')
<script>
// Store previous date values
let previousStartDate = $('#transaction-period-start').val();
let previousEndDate = $('#transaction-period-end').val();

$(document).on("change", "#customer, #transaction-period-start, #transaction-period-end", function() {
    let customerId = $('#customer').val();

    if (!customerId) {
        $("#kt_receivable_items_modal tbody").empty();
        return;
    }

    let startDate = $('#transaction-period-start').val();
    let endDate = $('#transaction-period-end').val();

    // Validasi start date tidak boleh lebih dari end date
    if (startDate && endDate && startDate > endDate) {
        Swal.fire({
            title: 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai',
            icon: 'warning',
            confirmButtonText: 'Ok'
        });
        // Reset ke nilai sebelumnya
        $('#transaction-period-start').val(previousStartDate);
        $('#transaction-period-end').val(previousEndDate);
        $("#kt_receivable_items_modal tbody").empty();
        return;
    }

    // Validasi end date tidak boleh kurang dari start date
    if (startDate && endDate && endDate < startDate) {
        Swal.fire({
            title: 'Tanggal selesai tidak boleh kurang dari tanggal mulai',
            icon: 'warning',
            confirmButtonText: 'Ok'
        });
        // Reset ke nilai sebelumnya
        $('#transaction-period-start').val(previousStartDate);
        $('#transaction-period-end').val(previousEndDate);
        $("#kt_receivable_items_modal tbody").empty();
        return;
    }

    // Update previous values jika validasi berhasil
    previousStartDate = startDate;
    previousEndDate = endDate;

    getReceivable(customerId, startDate, endDate);
});

$(document).on("click", "#btn-open-receivable-modal", function(e) {
    let customerId = $('#customer').val();
    let startDate = $('#transaction-period-start').val();
    let endDate = $('#transaction-period-end').val();

    if (!customerId) {
        e.preventDefault();
        Swal.fire({
            title: 'Pilih customer terlebih dahulu',
            icon: 'warning',
            confirmButtonText: 'Ok'
        });
        return;
    }

    if (!startDate) {
        e.preventDefault();
        Swal.fire({
            title: 'Pilih tanggal mulai terlebih dahulu',
            icon: 'warning',
            confirmButtonText: 'Ok'
        });
        return;
    }

    if (!endDate) {
        e.preventDefault();
        Swal.fire({
            title: 'Pilih tanggal selesai terlebih dahulu',
            icon: 'warning',
            confirmButtonText: 'Ok'
        });
        return;
    }

    if (startDate > endDate) {
        e.preventDefault();
        Swal.fire({
            title: 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai',
            icon: 'warning',
            confirmButtonText: 'Ok'
        });
        return;
    }

    getReceivable(customerId, startDate, endDate, function(data) {
        if (data.length > 0) {
            $('#kt_modal_add_item').modal('show');
        } else {
            Swal.fire({
                title: 'Tidak ada transaksi',
                text: 'Tidak ada transaksi untuk customer dan periode yang dipilih',
                icon: 'info',
                confirmButtonText: 'Ok'
            });
        }
    });
});

$(document).on("click", "#btn-form-add-receivable-item", function() {
    let checkedIds = [];

    $("#kt_receivable_items_modal tbody tr").each(function () {
        let checkbox = $(this).find(".form-check-input");

        if (checkbox.is(":checked")) {
            let transactionId = $(this).find(".transaction-id").val();
            checkedIds.push(transactionId);
        }
    });

    getReceivableItems(checkedIds);
});

$(document).on("click", "#kt_items_table tbody a", function(e) {
    e.preventDefault();
    $(this).closest("tr").remove();
});

function getReceivable(customerId, startDate = null, endDate = null, callback = null) {
    $.ajax({
        url: `{{route('finances.invoices.getTransactions')}}`,
        type: 'GET',
        data: {
            customer: customerId,
            start_date: startDate,
            end_date: endDate,
        },
        dataType: 'json',
        beforeSend: function() {
            // Clear existing options before the request

        },
        success: function(response) {
            var data = response;

            $("#kt_receivable_items_modal tbody").empty();

            data.forEach(function(items) {
                var row = `
                        <tr>
                            <td class="">
                                ${items.date}
                                <input class="transaction-id" type="hidden" value="${items.transaction_id}" />
                            </td>
                            <td>${items.transaction_no}</td>
                            <td class="text-end">${items.total_amount}</td>
                            <td class="text-center">
                                <input class="form-check-input" type="checkbox" value="1">
                            </td>
                        </tr>
                    `;
                // Append the product to the product list container
                $("#kt_receivable_items_modal tbody").append(row);
            });

            if (callback) {
                callback(data);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
            if (callback) {
                callback([]);
            }
        }
    });
}

function getReceivableItems(params) {

    if (params.length === 0) {
        alert("No transactions selected!");
        return;
    }

    $.ajax({
        url: `{{route('finances.invoices.getTransactionItems')}}`, // Laravel route to fetch products
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: JSON.stringify({ transaction_ids: params }),
        contentType: "application/json",
        success: function(response) {
            var data = response;
            var total_billed = 0;
            data.forEach(function(items) {
                var row = `
                        <tr>
                            <td class="text-center">
                                <a href="#"><i class="fa-solid fa-trash-can"></i></a>
                                <input class="transaction-id" type="hidden" value="${items.transaction_id}" />
                            </td>
                            <td class="">${items.date}</td>
                            <td>${items.transaction_no}</td>
                            <td class="text-end">${formatNumber(items.total_amount)}</td>
                        </tr>
                    `;

                    total_billed += parseFloat(items.total_amount);
                // Append the product to the product list container
                $("#kt_items_table tbody").append(row);

                $('#kt_modal_add_item').modal('hide');
            });

            console.log("Total Billed : " + total_billed);

            $("#total-billed").val(formatNumber(total_billed.toString()));
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
        }
    });
}

function formatNumber(numStr) {
    let cleaned = numStr.replace(/[^\d.]/g, '');
    const parts = cleaned.split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join('.');
}

$(document).on('click', '#btn-submit', function(e) {
    e.preventDefault();

    if (true) {
        Swal.fire({
            title: 'Apakah anda yakin ?',
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                const itemLists = [];

                $('#kt_items_table tbody tr').each(function() {
                    var itemId = $(this).find(".transaction-id").val();
                    itemLists.push(itemId);
                });

                var customer = $('#customer').val();
                var date = $('#invoice-date').val();
                var total_billed = $('#total-billed').val().replace(/[^\d]/g, '') | 0;
                var status = $('#status').val();
                let start_date = $('#transaction-period-start').val();
                let end_date = $('#transaction-period-end').val();

                // Build the JSON payload
                const payload = {
                    header: {
                        customer: customer,
                        date: date,
                        total_billed: total_billed,
                        status: status,
                        start_date: start_date,
                        end_date: end_date
                    },
                    details: itemLists
                };

                console.log(payload)

                $.ajax({
                    url: `{{route('finances.invoices.save')}}`,
                    type: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify(payload),
                    success: function(response) {
                        Swal.fire({
                            title: 'Suceess !',
                            text: `Invoice berhasil disimpan dengan nomor invoice ${response.invoice_number}`,
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        }).then((result) => {
                            let invoiceUrl =
                                `{{ route('finances.invoices.print-invoice', ['id' => '__invoice_id__']) }}`;
                                invoiceUrl = invoiceUrl.replace(
                                '__invoice_id__', response
                                .invoice_id);

                            // Open the receipt in a new tab
                            window.open(invoiceUrl, '_blank');

                            // Redirect the current page to the transaction index
                            location.href =
                                `{{ route('finances.invoices.index') }}`;
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

</script>
@endsection
