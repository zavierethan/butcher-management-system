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
                        Goods Received</h1>
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
                        <li class="breadcrumb-item text-muted">Goods Received</li>
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
                                            <label class="form-label fw-bold fs-6 mb-2">Nomor Purchase Order</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="text" name="total_amount" id="received-by" value="{{$purchaseOrder->purchase_order_number}}" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Tanggal Terima</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="date" name="request_date" value="{{$purchaseOrder->received_date}}" id="received-date" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Diterima Oleh</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="text" name="total_amount" id="received-by" value="{{$purchaseOrder->received_by}}" readonly/>
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
                                                    <option value="pending" <?php echo ($purchaseOrder->status == 1) ? 'selected' : ''; ?>>Pending Supplier</option>
                                                    <option value="goods_received" <?php echo ($purchaseOrder->status == 2) ? 'selected' : ''; ?>>Goods Received</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="text-end">
                                        <a href="{{route('procurement.goods-receive.index')}}"
                                            class="btn btn-sm btn-danger">Cancel</a>
                                        <a href="#" class="btn btn-sm btn-primary"
                                            id="btn-submit-goods-received">Transfer ke Store</a>
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
                                        <th class="min-w-125px">Item</th>
                                        <th class="min-w-100px text-end">Jumlah PO (KG)</th>
                                        <th class="min-w-125px text-end">Harga PO (RP)</th>
                                        <th class="min-w-100px text-end">Jumlah TERIMA (KG)</th>
                                        <th class="min-w-100px text-end">Jumlah TERIMA (EKOR)</th>
                                        <th class="min-w-125px text-end">Harga Terima (RP)</th>
                                        <th class="min-w-100px text-center">Realisasi</th>
                                        <th class="min-w-100px">Catatan</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                    @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->name}} ({{$item->item_notes}})</td>
                                        <td class="item-quantity text-end">{{$item->quantity}}</td>
                                        <td class="item-price text-end">{{$item->price}}</td>
                                        <td class="text-end">{{$item->received_quantity}}</td>
                                        <td class="text-end">{{$item->received_unit}}</td>
                                        <td class="text-end">{{$item->received_price}}</td>
                                        <td class="text-center">{{$item->realisation}}</td>
                                        <td class="">{{$item->remarks}}</td>
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
$("#purchase-order-id").on("change", function() {

    // Retrieve values from input fields
    var selectedOption = $("#purchase-order-id option:selected");
    var purchaseOrderId = selectedOption.val();

    $.ajax({
        url: `/api/get-purchase-order-items`, // Laravel route to fetch products
        type: 'GET',
        data: {
            purchase_order_id: purchaseOrderId,
        },
        dataType: 'json',
        success: function(response) {
            // Loop through each product in the JSON response
            $("#kt_items_table tbody").empty();
            var data = response;
            console.log(data)
            var no = 1;
            data.forEach(function(items) {
                // Construct HTML for each product
                var row = `
                        <tr>
                            <td class="">${no++}.</td>
                            <td>
                                ${items.name}
                                <input type="hidden" value="${items.purchase_order_item_id}" class="purchase-order-item-id" />
                            </td>
                            <td class="item-price text-center">${items.price}</td>
                            <td class="item-quantity text-center">${items.quantity}</td>
                            <td class="text-center"><input class="form-control form-control-sm me-2 item-received-price" type="text" name="received_price" value="" /></td>
                            <td class="text-center"><input class="form-control form-control-sm me-2 item-received-quantity" type="text" name="received_quantity" value="" /></td>
                            <td class="text-center"><input class="form-control form-control-sm me-2 item-remarks" type="text" name="remarks" value="" /></td>
                        </tr>
                    `;
                // Append the product to the product list container
                $("#kt_items_table tbody").append(row);
            });

            // Hide the modal
        },
        error: function(xhr, status, error) {
            console.error('Error fetching products:', error);
        }
    });
});


$(document).on('click', '#btn-submit-goods-received', function(e) {
    e.preventDefault();

    if (true) {
        Swal.fire({
            title: 'Apakah anda yakin untuk memproses penerimaan ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya, Proses Penerimaan'
        }).then((result) => {
            if (result.isConfirmed) {
                const itemLists = [];

                $('#kt_items_table tbody tr').each(function() {

                    var purchaseOrderItemId = $(this).find(".purchase-order-item-id").val();
                    var itemReceivedQuantity = $(this).find(".item-received-quantity").val()
                        .trim();
                    var itemReceivedPrice = $(this).find(".item-received-price").val().trim();
                    var itemRemarks = $(this).find(".item-remarks").val().trim();

                    itemLists.push({
                        purchase_order_item_id: purchaseOrderItemId,
                        received_quantity: itemReceivedQuantity,
                        received_price: itemReceivedPrice,
                        remarks: itemRemarks,
                    });
                });

                var purchaseOrderId = $('#purchase-order-id').val();
                var receivedDate = $('#received-date').val();
                var receivedBy = $('#received-by').val();
                var status = $('#status').val();

                // Build the JSON payload
                const payload = {
                    header: {
                        purchase_order_id: purchaseOrderId,
                        received_date: receivedDate,
                        received_by: receivedBy,
                        status: status
                    },
                    details: itemLists
                };

                console.log(payload)

                $.ajax({
                    url: `{{route('procurement.goods-receive.save')}}`,
                    type: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify(payload),
                    success: function(response) {
                        Swal.fire({
                            title: 'Suceess !',
                            text: `Goods Received berhasil di simpan`,
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        }).then((result) => {

                            // Redirect the current page to the transaction index
                            location.href =
                                `{{ route('procurement.goods-receive.index') }}`;
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
