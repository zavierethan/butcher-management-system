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
                                                        @foreach ($customers as $customer)
                                                        <option value="{{$customer->id}}" {{$customer->id == $invoice->customer_id ? 'selected' : ''}}>{{$customer->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Nomor Invoice</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" name="invoice_no" id="invoice-no" value="{{$invoice->invoice_no}}" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Periode Transaksi</label>
                                                <div class="d-flex gap-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="date" name="transaction_period_start" id="transaction-period-start" value="{{ $invoice->start_periode }}" />
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="date" name="transaction_period_end" id="transaction-period-end" value="{{ $invoice->end_periode }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Tanggal Invoice</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="date" name="invoice_date" id="invoice-date" value="{{$invoice->invoice_date}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Total Tagihan</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" name="total_billed" id="total-billed" value="{{$invoice->total_billed}}" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Sisa Tagihan</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" name="remaining_billed" id="remaining-billed" value="{{$invoice->remaining_billed}}" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Status</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" name="status" id="status" value="{{$invoice->status}}" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <a href="{{route('finances.invoices.index')}}"
                                        class="btn btn-sm btn-danger">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                        <div class="card-header pt-5">
                            <h3 class="card-title fw-bold">Detail
                                Transaksi
                            </h3>
                        </div>
                        <!--begin::Card body-->
                        <div class="card-body pt-10 overflow-x-auto">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_items_table">
                                    <thead>
                                        <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                                            <th class="">No.</th>
                                            <th class="">Nomor Transaksi</th>
                                            <th class="">Tanggal</th>
                                            <th class="text-end">Total Tagihan</th>
                                            <th class="text-end">Sisa Tagihan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @php $counting = 1; @endphp
                                        @foreach ($invoiceItems as $item)
                                        <tr>
                                            <td class="">
                                                {{ $counting++ }}</a>
                                            </td>
                                            <td>{{ $item->transaction_no }}</td>
                                            <td>{{ $item->transaction_date }}</td>
                                            <td class="text-end">{{ number_format($item->total_amount, 0, '.', ',') }}</td>
                                            <td class="text-end">{{ number_format($item->remaining_amount, 0, '.', ',') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>

                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                        <div class="card-header pt-5">
                            <h3 class="card-title fw-bold">History Pembayaran
                            </h3>
                        </div>
                        <!--begin::Card body-->
                        <div class="card-body pt-10 overflow-x-auto">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_payment_histories_table">
                                    <thead>
                                        <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                                            <th class="">No.</th>
                                            <th class="">Store</th>
                                            <th class="">Tanggal Pembayaran</th>
                                            <th class="text-center">Metode Pembayaran</th>
                                            <th class="text-end">Total Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                         @php $counting = 1; @endphp
                                        @foreach ($paymentHistories as $history)
                                        <tr>
                                            <td class="">
                                                {{ $counting++ }}
                                            </td>
                                            <td>{{ $history->branch_name }}</td>
                                            <td>{{ $history->date }}</td>
                                            <td class="text-center">{{ $history->payment_method }}</td>
                                            <td class="text-end">{{ $history->amount }}</td>
                                        </tr>
                                        @endforeach
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
<script>
$(document).on("change", "#customer", function() {
    let customerId = $(this).val();
    getReceivable(customerId);
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

                // Build the JSON payload
                const payload = {
                    header: {
                        customer: customer,
                        date: date,
                        total_billed: total_billed,
                        status: status,
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
                                `{{ route('finances.account-receivable.index') }}`;
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
