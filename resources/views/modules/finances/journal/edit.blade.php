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
                        Journal Entries</h1>
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
                        <li class="breadcrumb-item text-muted">Journal Entries</li>
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
                                                <label class="form-label fw-bold fs-6 mb-2">Transaction Date</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="date" name="date" id="date" value="{{$journal->date}}"/>
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="hidden" name="id" id="id" value="{{$journal->id}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Description</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" name="description" id="description" value="{{$journal->description}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Reference</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" name="reference" id="reference" value="{{$journal->reference}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Notes</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" name="remarks" id="remarks" value="{{$journal->remarks}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <a href="{{route('finances.journals.index')}}"
                                        class="btn btn-sm btn-danger">Cancel</a>
                                    <button type="button" class="btn btn-sm btn-primary" id="btn-approve-journal">Approve</button>
                                </div>
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
                            <div class="row mb-5">
                                <div class="col-md-12 text-end"><a class="btn btn-sm btn-primary" id="add-row"><i
                                            class="fa-solid fa-plus"></i></a></div>
                            </div>
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_items_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-250px">Account Code</th>
                                        <th class="min-w-125px">Debit</th>
                                        <th class="min-w-125px">Credit</th>
                                        <th class="min-w-125px text-center">Action</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                    @foreach($journaldetails as $details)
                                    <tr>
                                        <td>
                                            <div class="position-relative">
                                                <select class="form-select me-2 account-id" data-control="select2"
                                                    name="account_id">
                                                    <option value="">-</option>
                                                    @foreach($accounts as $account)
                                                    <option value="{{$account->id}}" <?php echo ($details->account_id == $account->id) ? 'selected' : ''; ?>>
                                                        {{$account->account_code}} - {{$account->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td><input class="form-control form-control-sm me-2 debit" type="text"
                                                name="debit" value="{{$details->debit}}" /></td>
                                        <td><input class="form-control form-control-sm me-2 credit" type="text"
                                                name="credit" value="{{$details->credit}}" /></td>
                                        <td class="text-center">
                                            <a href="#"><i class="fa-solid fa-trash-can"></i></a>
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

    $("#add-row").on("click", function() {
        var row = `<tr>
                    <td>
                        <div class="position-relative">
                            <select class="form-select me-2 account-id" data-control="select2"
                                name="account_id">
                                <option value="">-</option>
                                @foreach($accounts as $account)
                                <option value="{{$account->id}}">
                                    {{$account->account_code}} - {{$account->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td><input class="form-control form-control-sm me-2 debit" type="text"
                            name="debit" value="0" /></td>
                    <td><input class="form-control form-control-sm me-2 credit" type="text"
                            name="credit" value="0" /></td>
                    <td class="text-center">
                        <a href="#"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>`;

        $("#kt_items_table tbody").append(row);

        $("#kt_items_table tbody tr:last").find('select[data-control="select2"]').select2();
    });
});

$(document).on("click", "#kt_items_table tbody a", function(e) {
    e.preventDefault();
    $(this).closest("tr").remove();
});

$(document).on("keyup", "input[name='debit'], input[name='credit']", function() {
    var originalVal = $(this).val();
    var formattedVal = formatNumber(originalVal);
    $(this).val(formattedVal);
});

$(document).on('click', '#btn-approve-journal', function(e) {
    e.preventDefault();

    if (true) {
        Swal.fire({
            title: 'Apakah anda yakin untuk mengupdate jurnal ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya, Update Jurnal'
        }).then((result) => {
            if (result.isConfirmed) {
                const itemLists = [];

                var debitTotal = 0;
                var creditTotal = 0;

                $('#kt_items_table tbody tr').each(function() {
                    var accountId = $(this).find(".account-id").val(); // Get text in the first <td> (trim to remove extra spaces)
                    var debit = $(this).find(".debit").val().replace(/[^\d]/g, '') | 0;
                    var credit = $(this).find(".credit").val().replace(/[^\d]/g, '') | 0;

                    itemLists.push({
                        accountId: accountId,
                        debit: debit,
                        credit: credit,
                    });

                    debitTotal += parseFloat(debit);
                    creditTotal += parseFloat(credit);
                });

                if(debitTotal != creditTotal) {
                    Swal.fire({
                            title: 'Perhatian !',
                            text: `Total Credit dan Debit harus balance !`,
                            icon: 'warning',
                        })
                }

                var id = $('#id').val();
                var date = $('#date').val();
                var description = $('#description').val();
                var reference = $('#reference').val();
                var remarks = $('#remarks').val();

                // Build the JSON payload
                const payload = {
                    header: {
                        id: id,
                        date: date,
                        description: description,
                        reference: reference,
                        remarks: remarks,
                    },
                    details: itemLists
                };

                console.log(payload)

                $.ajax({
                    url: `{{route('finances.journals.update')}}`,
                    type: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify(payload),
                    success: function(response) {
                        Swal.fire({
                            title: 'Suceess !',
                            text: `Jurnal berhasil di perbaharui`,
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        }).then((result) => {
                                location.href =
                                    `{{ route('finances.journals.index') }}`;
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
