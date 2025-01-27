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
                                                <input type="hidden" value="{{$purchaseRequest->id}}" id="id"/>
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
                                                    data-placeholder="-" name="status" id="status" <?php echo ($purchaseRequest->status == 'approve') ? 'disabled' : ''; ?>>
                                                    <option value="">-</option>
                                                    <option value="pending"
                                                        <?php echo($purchaseRequest->status == 'pending') ? 'selected' : ''; ?>>
                                                        PENDING (Waiting Approval)</option>
                                                    <option value="approve"
                                                        <?php echo($purchaseRequest->status == 'approve') ? 'selected' : ''; ?>>
                                                        APPROVE</option>
                                                    <option value="decline"
                                                        <?php echo($purchaseRequest->status == 'decline') ? 'selected' : ''; ?>>
                                                        DECLINE</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="text-end">
                                        <a href="{{route('procurement.purchase-request.index')}}"
                                            class="btn btn-sm btn-danger">Kembali</a>
                                        <a href="#" class="btn btn-sm btn-primary" id="btn-update-request">Update
                                            Request</a>
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
                                        <th class="min-w-125px">Harga Satuan</th>
                                        <th class="min-w-125px">Jumlah</th>
                                        <th class="min-w-125px">Total Harga (Rp)</th>
                                        <th class="min-w-125px text-center">Status Approval</th>
                                        <!-- <th class="min-w-125px text-center">Realisasi</th> -->
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
                                        <td>{{$item->product_name}}</td>
                                        <td>
                                            <input class="form-control form-control-sm me-2 price" type="text" name="price" value="{{$item->price}}" readonly/>
                                            <input class="form-control form-control-sm me-2 id" type="hidden" name="id" value="{{$item->id}}" />
                                        </td>
                                        <td><input class="form-control form-control-sm me-2 quantity" type="text" name="quantity" value="{{$item->quantity}}" <?php echo ($purchaseRequest->status == 'approve') ? 'readonly' : ''; ?>/></td>
                                        <td><input class="form-control form-control-sm me-2 total-price" type="text" name="total_price" value="{{$item->quantity * $item->price}}" <?php echo ($purchaseRequest->status == 'approve') ? 'readonly' : ''; ?>/></td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <label
                                                    class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input toggle-approve-status" name="approve"
                                                        type="checkbox" data-id="{{$item->id}}" <?php echo ($item->approval_status == 1) ? 'checked' : ''; ?> <?php echo ($purchaseRequest->status == 'approve') ? 'disabled' : ''; ?>>
                                                    <span class="form-check-label fw-bold text-muted"></span>
                                                </label>
                                            </div>
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
$(document).on('click', '#btn-update-request', function(e) {
    e.preventDefault();

    if (true) {
        Swal.fire({
            title: 'Apakah anda yakin untuk mengupdate request ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya, Update Request'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $("#id").val();
                let status = $("#status").val();
                let sub_total = 0;

                $('input.toggle-approve-status:checked').each(function () {
                    // Find the corresponding total-price input in the same row
                    const totalPrice = $(this)
                        .closest('tr')
                        .find('input.total-price')
                        .val();

                    // Parse the value as a number and add it to the total
                    sub_total += parseFloat(totalPrice) || 0; // Use 0 if the value is empty or invalid
                });

                $.ajax({
                    url: `{{route('procurement.purchase-request.update')}}`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                        status: status,
                        sub_total: sub_total
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Suceess !',
                            text: `Transaksi berhasil di perbaharui`,
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
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

$(document).on('click', '.toggle-approve-status', function(e) {
    const checkbox = $(this);
    const row = checkbox.closest('tr');

    const itemName = row.find('td:first').text();
    const price = row.find('input[name=price]').val();
    const quantity = row.find('input[name=quantity]').val();
    const totalPrice = row.find('input[name=total_price]').val();
    const isApproved = checkbox.is(':checked');
    const itemId = checkbox.data('id'); // Assuming `data-id` holds the item ID

    // // Send POST request for approval toggle
    $.ajax({
        url: `{{route('procurement.purchase-request.approve-item')}}`,
        type: 'POST',
        data: {
            id: itemId,
            price: price,
            quantity: quantity,
            totalPrice: totalPrice,
            approval_status: isApproved ? 1 : 0,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            Swal.fire({
                title: 'Suceess !',
                text: `Status Item berhasil di perbaharui`,
                icon: 'success'
            });
        },
        error: function(xhr, status, error) {
            alert(`Failed to update approval status for ${itemName}: ${error}`);
            checkbox.prop('checked', !isApproved);
        },
    });
});

$(document).on('click', '.toggle-realisasi-status', function(e) {
    const checkbox = $(this);
    const row = checkbox.closest('tr');

    const productName = row.find('td:first').text();
    const price = row.find('input[name=price]').val();
    const quantity = row.find('input[name=quantity]').val();
    const isApproved = checkbox.is(':checked');
    const itemId = checkbox.data('id'); // Assuming `data-id` holds the item ID

    // Send POST request for approval toggle
    $.ajax({
        url: '/approve-item',
        type: 'POST',
        data: {
            id: itemId,
            product_name: productName,
            price: price,
            quantity: quantity,
            status: isApproved ? 'approved' : 'not_approved',
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            alert(`Approval status updated successfully for ${productName}`);
        },
        error: function(xhr, status, error) {
            alert(`Failed to update approval status for ${productName}: ${error}`);
            checkbox.prop('checked', !isApproved);
        },
    });
});
</script>
@endsection
