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
                        Account Receivables</h1>
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
                        <li class="breadcrumb-item text-muted">Account Receivables</li>
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
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" name="customer" id="customer" value="{{$receivable->customer_name}}" readonly/>
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="hidden" name="receivable_id" id="receivable-id" value="{{$receivable->id}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Nomor Transaksi</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid" type="text" name="transaction_no" id="transaction-no" value="{{$receivable->transaction_no}}" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Tanggal Transaksi</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="date" name="invoice_date" id="transaction-date" value="{{$receivable->transaction_date}}" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Tanggal Jatuh Tempo</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="date" name="due_date" id="due-date" value="{{$receivable->due_date}}" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Total Transaksi</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" name="total_amount" id="total-amount" value="{{$receivable->total_amount}}" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Sisa Piutang</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" name="total_amount" id="total-amount" value="{{$receivable->remaining_balance}}" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Status</label>
                                                <div class="position-relative mb-3">
                                                    <select class="form-select form-select-solid" data-control="select2"
                                                        data-placeholder="-" name="status" id="status" disabled>
                                                        <option value="">-</option>
                                                        <option value="paid" <?php echo ($receivable->status == 'paid') ? 'selected' : '';?>>PAID</option>
                                                        <option value="unpaid" <?php echo ($receivable->status == 'unpaid') ? 'selected' : '';?>>UNPAID</option>
                                                        <option value="partial" <?php echo ($receivable->status == 'partial') ? 'selected' : '';?>>PARTIAL / TERM</option>
                                                    </select>
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
                                        id="btn-submit-ar">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card body-->
                        <div class="card-body pt-10 overflow-x-auto">
                            <div class="row mb-5">
                                <div class="col-md-12 text-end"><a class="btn btn-sm btn-primary" id="add-row"><i class="fa-solid fa-plus"></i>Tambah Pembayaran</a></div>
                            </div>
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_items_table">
                                    <thead>
                                        <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-70px">Tanggal Pembayaran</th>
                                            <th class="min-w-70px">Ref.</th>
                                            <th class="min-w-70px">Nominal</th>
                                            <th class="min-w-70px">Bukti Pembayaran</th>
                                            <th class="min-w-70px text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach($payments as $py)
                                        <tr>
                                            <td>
                                                <input class="form-control form-control-sm me-2 date" type="date"
                                                    name="date" value="{{$py->payment_date}}"/>
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm me-2 reference" type="text"
                                                    name="reference" value="{{$py->reference}}"/>
                                            </td>
                                            <td><input class="form-control form-control-sm me-2 amount-paid" type="text"
                                                    name="amount_paid" value="{{$py->amount_paid}}"/>
                                            </td>
                                            <td><a href="#" class="view-attachment" data-base64="{{$py->attachment}}" data-filename="attachment.pdf">Lihat Attachment</a></td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary save"><i class="fas fa-edit"></i></a>
                                            </td>
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

$(document).on("keyup", "#total-amount", function() {
    var originalVal = $(this).val();
    var formattedVal = formatNumber(originalVal);
    $(this).val(formattedVal);
});

$(document).on("keyup", "input[name='amount_paid']", function() {
    var originalVal = $(this).val();
    var formattedVal = formatNumber(originalVal);
    $(this).val(formattedVal);
});

$(document).on("click", "#add-row", function(e) {
    e.preventDefault();
    var row = `<tr>
                <td>
                    <input class="form-control form-control-sm me-2 date" type="date"
                        name="date"/>
                </td>
                <td>
                    <input class="form-control form-control-sm me-2 reference" type="text"
                        name="reference"/>
                </td>
                <td><input class="form-control form-control-sm me-2 amount-paid" type="text"
                        name="amount_paid" value="0" /></td>
                <td><input class="form-control form-control-sm me-2 attachment" type="file"
                        name="attachment"/></td>
                <td class="text-center">
                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary save"><i class="fas fa-save"></i></a>
                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary delete"><i class="fa-solid fa-trash-can"></i></a>
                </td>
            </tr>`;

    $("#kt_items_table tbody").append(row);
});

$(document).on("click", ".delete", function(e) {
    e.preventDefault();
    $(this).closest("tr").remove();
});

$(document).on("click", ".view-attachment", function (e) {
    e.preventDefault();

    let base64Data = $(this).data("base64"); // Get Base64 string
    let fileType = "image/png"; // Adjust MIME type if needed

    if (!base64Data) {
        alert("No attachment found.");
        return;
    }

    let fileUrl = `data:${fileType};base64,${base64Data}`;

    // Create a temporary <a> element using jQuery
    let $a = $("<a>", {
        href: fileUrl,
        target: "_blank"
    }).appendTo("body");

    // Trigger a click event to open in a new tab
    $a[0].click();

    // Remove the element after opening
    $a.remove();
});



$(document).on("click", ".save", function(e) {
    e.preventDefault();

    var row = $(this).closest('tr');

    var receivableId = $('#receivable-id').val();
    var date = row.find('input[name="date"]').val();
    var reference = row.find('input[name="reference"]').val();
    var amountPaid = row.find('input[name="amount_paid"]').val().replace(/[^\d.]/g, '') | 0;
    var attachment = row.find('input[name="attachment"]')[0].files[0];

    if (attachment) {
        console.log("Attachment Name:", attachment.name);
    } else {
        console.log("No attachment uploaded.");
    }

    if (true) {
        Swal.fire({
            title: 'Simpan Data ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.isConfirmed) {
                let formData = new FormData();

                formData.append("receivable_id", receivableId);
                formData.append("date", date);
                formData.append("reference", reference);
                formData.append("amount_paid", amountPaid);

                if (attachment) {
                    formData.append("attachment", attachment);
                }


                console.log(formData)

                $.ajax({
                    url: `{{route('finances.account-receivable.save-payments')}}`,
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

function formatNumber(numStr) {
    let cleaned = numStr.replace(/[^\d.]/g, '');
    const parts = cleaned.split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join('.');
}
</script>
@endsection
