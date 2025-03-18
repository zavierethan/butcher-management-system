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
                        Purchase Requests</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Procurement</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Purchase Requests</li>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Request Number</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="text" name="pic" value="{{$purchaseRequest->request_number}}" id="request-number"
                                                    readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Tanggal</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="date" name="request_date"
                                                    value="{{$purchaseRequest->request_date}}" id="request-date"
                                                    readonly />
                                                <input type="hidden" value="{{$purchaseRequest->id}}" id="purchase-request-id"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Alokasi</label>
                                            <div class="position-relative mb-3">
                                                <select class="form-select form-select-solid" data-control="select2"
                                                    data-placeholder="-" name="alocation" id="alocation" disabled>
                                                    <option value="">-</option>
                                                    @foreach($branches as $branch)
                                                    <option value="{{$branch->id}}"
                                                        <?php echo($purchaseRequest->alocation == $branch->id) ? 'selected' : ''; ?>>
                                                        {{$branch->code}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">PIC</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="text" name="pic" value="{{$purchaseRequest->pic}}" id="pic"
                                                    readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Kategori</label>
                                            <div class="position-relative mb-3">
                                                <select class="form-select form-select-solid" data-control="select2"
                                                    data-placeholder="-" name="category" id="category" disabled>
                                                    <option value="">-</option>
                                                    <option value="OP"
                                                        <?php echo($purchaseRequest->category == 'OP') ? 'selected' : ''; ?>>
                                                        Operational (OP)</option>
                                                    <option value="PR"
                                                        <?php echo($purchaseRequest->category == 'PR') ? 'selected' : ''; ?>>
                                                        Product (PR)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Nominal Pengajuan</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="text" name="remarks"
                                                    value="@php echo number_format($purchaseRequest->nominal_application, 0, '.', ',') @endphp"
                                                    id="nominal-application" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Nominal Realisasi</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="text" name="remarks" value="@php echo number_format($purchaseRequest->nominal_realization, 0, '.', ',') @endphp" id="nominal-realization"
                                                    readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Status Approval</label>
                                            <div class="position-relative mb-3">
                                                <select class="form-select form-select-solid" data-control="select2"
                                                    data-placeholder="-" name="status" id="status" <?php echo ($purchaseRequest->status == 3 || $purchaseRequest->status == 2) ? 'disabled' : ''; ?>>
                                                    <option value="">-</option>
                                                    <option value="1" <?php echo($purchaseRequest->status == 1) ? 'selected' : ''; ?>>Pending Approval</option>
                                                    <option value="2" <?php echo($purchaseRequest->status == 2) ? 'selected' : ''; ?>>Partially Approved</option>
                                                    <option value="3" <?php echo($purchaseRequest->status == 3) ? 'selected' : ''; ?>>Full Approved</option>
                                                    <option value="4" <?php echo($purchaseRequest->status == 4) ? 'selected' : ''; ?>>Full Rejected</option>
                                                    <option value="5" <?php echo($purchaseRequest->status == 5) ? 'selected' : ''; ?>>Closed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="text-end">
                                        <a href="{{route('procurement.purchase-request.index')}}"
                                            class="btn btn-sm btn-danger">Kembali</a>
                                        <a href="#" class="btn btn-sm btn-primary" id="btn-update-request">Proses Approval</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Row-->

                <!--begin::Row-->
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <div class="card">
                        <div class="card-body pt-10 overflow-x-auto">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_items_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-20px">No.</th>
                                        <th class="min-w-125px">Item</th>
                                        <th class="min-w-120px">Jumlah</th>
                                        <th class="min-w-125px">Harga Satuan</th>
                                        <th class="min-w-125px">Total Harga (Rp)</th>
                                        <th class="min-w-125px">Status Approval</th>
                                        <th class="min-w-125px text-center">Catatan</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                    <?php $no = 1; ?>
                                    @foreach($purchaseRequestItems as $item)
                                    <tr>
                                        <td><?php echo $no++; ?>.</td>
                                        <td>{{$item->product_name}} ({{$item->item_notes}})</td>
                                        <td><input class="form-control form-control-sm me-2 quantity" type="text" name="quantity" value="{{$item->quantity}}" <?php echo ($purchaseRequest->status == 'approve') ? 'readonly' : ''; ?> style="width: 100px;"/></td>
                                        <td>
                                            <input class="form-control form-control-sm me-2 price" type="text" name="price" value="{{$item->price}}" style="width: 200px;"/>
                                            <input class="form-control form-control-sm me-2 item-id" type="hidden" name="item_id" value="{{$item->id}}" />
                                        </td>
                                        <td><input class="form-control form-control-sm me-2 total-price" type="text" name="total_price" value="{{$item->quantity * $item->price}}"  style="width: 200px;" readonly/></td>
                                        <td class="text-center">
                                            <div class="position-relative mb-3" style="width: 200px;">
                                                <select class="form-select form-select-sm mt-3 approval-status" data-control="select2"
                                                    data-placeholder="-" name="approval_status">
                                                    <option value="">-</option>
                                                    <option value="1" <?php echo($item->approval_status == 1) ? 'selected' : ''; ?>>Pending Approval</option>
                                                    <option value="2" <?php echo($item->approval_status == 2) ? 'selected' : ''; ?>>Approve</option>
                                                    <option value="3" <?php echo($item->approval_status == 3) ? 'selected' : ''; ?>>Reject</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td><textarea class="form-control form-control-sm me-2 approval-notes" type="text" name="approval_notes">{{$item->approval_notes}}</textarea></td>
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
$(document).on('click', '#btn-update-request', function(e) {
    e.preventDefault();

    if (true) {
        Swal.fire({
            title: 'Apakah anda yakin untuk melakukan approval ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya, Update Request'
        }).then((result) => {
            if (result.isConfirmed) {
                const itemLists = [];

                var nominalRealization = 0;

                $('#kt_items_table tbody tr').each(function() {
                    var itemId = $(this).find(".item-id").val();
                    var quantity = $(this).find(".quantity").val();
                    var price = $(this).find(".price").val();
                    var totalPrice = $(this).find(".total-price").val();
                    var approvalStatus = $(this).find(".approval-status").val();
                    var approvalNotes = $(this).find(".approval-notes").val();

                    itemLists.push({
                        purchase_request_item_id: itemId,
                        quantity: quantity,
                        price: price,
                        total_price: totalPrice,
                        approval_status: approvalStatus,
                        approval_notes: approvalNotes,
                    });

                    if(approvalStatus === 2 || approvalStatus === '2') {
                        nominalRealization += parseFloat(totalPrice);
                    }
                });

                if (itemLists.length <= 0) {
                    Swal.fire({
                        title: 'Warning !',
                        text: 'Item Purchase Request tidak boleh kosong.',
                        icon: 'warning',
                        confirmButtonText: 'Ok',
                        allowOutsideClick: false
                    });

                    return;
                }

                var purchaseRequestId = $('#purchase-request-id').val();
                var status = $('#status').val();

                // Build the JSON payload
                const payload = {
                    header: {
                        purchase_request_id: purchaseRequestId,
                        status: status,
                        nominal_realization: nominalRealization,
                    },
                    details: itemLists
                };

                console.log(payload)
                $.ajax({
                    url: `{{route('procurement.purchase-request.update')}}`,
                    type: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify(payload),
                    success: function(response) {
                        Swal.fire({
                            title: 'Suceess !',
                            text: `Transaksi berhasil di perbaharui`,
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        }).then((result) => {
                            location.href =
                                `{{ route('procurement.purchase-request.index') }}`;
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

$(document).on('input', '.quantity, .price', function () {
    let row = $(this).closest('tr');
    calculateTotalPrice(row);
});

function calculateTotalPrice(row) {
    let quantity = parseFloat($(row).find('.quantity').val()) || 0;
    let price = parseFloat($(row).find('.price').val()) || 0;
    let total = quantity * price;
    $(row).find('.total-price').val(total.toFixed(0));
}

</script>
@endsection
