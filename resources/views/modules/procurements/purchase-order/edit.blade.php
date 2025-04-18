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
                        Purchase Orders</h1>
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
                        <li class="breadcrumb-item text-muted">Purchase Orders</li>
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
                                            <label class="form-label fw-bold fs-6 mb-2">Tanggal</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="date" name="request_date"
                                                    value="{{$purchaseOrder->order_date}}" id="order-date" readonly />
                                                <input type="hidden" name="id" value="{{$purchaseOrder->id}}" id="id" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Supplier</label>
                                            <div class="position-relative mb-3">
                                                <select class="form-select form-select-solid" data-control="select2"
                                                    data-placeholder="-" name="alocation" id="supplier" disabled>
                                                    <option value="">-</option>
                                                    @foreach($suppliers as $supplier)
                                                    <option value="{{$supplier->id}}"
                                                        <?php echo ($purchaseOrder->supplier_id == $supplier->id) ? 'selected' : ''; ?>>
                                                        {{$supplier->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <!-- <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Kategori</label>
                                            <div class="position-relative mb-3">
                                                <select class="form-select form-select-solid" data-control="select2"
                                                    data-placeholder="-" name="category" id="category" disabled>
                                                    <option value="">-</option>
                                                    <option value="OP" <?php echo ($purchaseOrder->category == 'OP') ? 'selected' : ''; ?>>OPERATIONAL (OP)</option>
                                                    <option value="PR" <?php echo ($purchaseOrder->category == 'PR') ? 'selected' : ''; ?>>PRODUCT (PR)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div> -->
                                </div>
                                <div class="col-md-6">
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Total Pembelian</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="text" name="total_amount" id="total-amount"
                                                    value="@php echo number_format($purchaseOrder->total_amount, 0, '.', ',') @endphp"
                                                    readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Status</label>
                                            <div class="position-relative mb-3">
                                                <select class="form-select form-select-solid" data-control="select2"
                                                    data-placeholder="-" name="status" id="status">
                                                    <option value="">-</option>
                                                    <option value="pending"
                                                        <?php echo ($purchaseOrder->status == 1) ? 'selected' : ''; ?>>
                                                        Pending Supplier</option>
                                                    <option value="completed"
                                                        <?php echo ($purchaseOrder->status == 2) ? 'selected' : ''; ?>>
                                                        Goods Received</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="text-end">
                                        <a href="{{route('procurement.purchase-order.index')}}"
                                            class="btn btn-sm btn-danger">Cancel</a>
                                        <a href="{{route('procurement.purchase-order.print-po', ['id' => $purchaseOrder->id])}}"
                                            target="_blank" class="btn btn-sm btn-primary" id="btn-print-po">Cetak
                                            PO</a>
                                        <a href="#" class="btn btn-sm btn-primary" id="btn-update-order">Update PO</a>
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
                                        <th class="min-w-125px text-center">Jumlah</th>
                                        <th class="min-w-125px text-end">Harga</th>
                                        <th class="min-w-125px text-end">Total Harga</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                    <?php $no = 1; ?>
                                    @foreach($items as $item)
                                    <tr>
                                        <td><?php echo $no++; ?>.</td>
                                        <td>{{$item->name}} ({{$item->item_notes}})</td>
                                        <td class="text-center">{{$item->quantity}}</td>
                                        <td class="text-end">{{$item->price}}</td>
                                        <td class="text-end item-total-price">@php echo number_format($item->total, 0,
                                            '.', ',') @endphp</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4" class="fs-3 text-gray-900 text-end">Grand Total</td>
                                        <td class="text-gray-900 fs-3 fw-bolder text-end">
                                            @php echo number_format($purchaseOrder->total_amount, 0, '.', ',') @endphp
                                        </td>
                                    </tr>
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
$("#btn-form-add-item").on("click", function() {

    // Retrieve values from input fields
    var selectedOption = $("#purhcase-request option:selected");
    var purchaseRequestId = selectedOption.val();

    $.ajax({
        url: `/api/get-purchase-request-items`, // Laravel route to fetch products
        type: 'GET',
        data: {
            purchase_request_id: purchaseRequestId,
        },
        dataType: 'json',
        success: function(response) {
            // Loop through each product in the JSON response
            var data = response;
            console.log(data)
            data.forEach(function(items) {
                // Construct HTML for each product
                var row = `
                        <tr>
                            <td class="item-request-number">
                                ${items.request_number}
                                <input type="hidden" value="${items.purchase_request_item_id}" class="purchase-request-item-id" />
                            </td>
                            <td>
                                ${items.name}
                                <input type="hidden" value="${items.item_id}" class="item-id" />
                            </td>
                            <td class="item-category">${items.category}</td>
                            <td class="item-quantity">${items.quantity}</td>
                            <td class="item-unit">Kilogram</td>
                            <td class="item-price text-end">${items.price}</td>
                            <td class="item-total-price text-end">${items.price * items.quantity}</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-danger" onclick="deleteRow(this)">Hapus</i></a>
                            </td>
                        </tr>
                    `;
                // Append the product to the product list container
                $("#kt_items_table tbody").append(row);
            });

            // Hide the modal
            $('#kt_modal_add_item').modal('hide');
        },
        error: function(xhr, status, error) {
            console.error('Error fetching products:', error);
        }
    });
});

$("#category").on("change", function() {
    $("#item-categories").val($(this).val());
});

$(document).on('click', '#btn-update-order', function(e) {
    e.preventDefault();

    if (!validate()) {
        Swal.fire({
            title: 'Apakah anda yakin untuk memperbaharui purchase order ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya, Perbaharui Order'
        }).then((result) => {
            if (result.isConfirmed) {

                let id = $("#id").val();
                let status = $("#status").val();
                let sub_total = 0;

                const itemLists = [];

                $('#kt_items_table tbody tr').each(function() {

                    var itemId = $(this).find(".item-id").val();
                    var purchaseRequestItemId = $(this).find(".purchase-request-item-id").val();
                    var itemCategory = $(this).find(".item-category").text().trim();
                    var itemQuantity = $(this).find(".item-quantity").text().trim();
                    var itemPrice = $(this).find(".item-price").text().trim();
                    var itemTotalPrice = $(this).find(".item-total-price").text().replace(/,/g,
                        '');

                    itemLists.push({
                        item_id: itemId,
                        purchase_request_item_id: purchaseRequestItemId,
                        category: itemCategory,
                        quantity: itemQuantity,
                        price: itemPrice,
                        total_price: itemTotalPrice,
                    });

                    sub_total += parseFloat(itemTotalPrice) || 0;
                });

                // Build the JSON payload
                const payload = {
                    header: {
                        id: id,
                        status: status,
                        sub_total: sub_total,
                    },
                    details: itemLists
                };

                console.log(payload)

                $.ajax({
                    url: `{{route('procurement.purchase-order.update')}}`,
                    type: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify(payload),
                    success: function(response) {
                        Swal.fire({
                            title: 'Suceess !',
                            text: `Purchase Order berhasil diperbaharui.`,
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

// Function to delete a row
function deleteRow(button) {
    $(button).closest('tr').remove();
}

function validate() {
    var toReturn = true;
    const paymentMethod = $('#payment-method').find('input[type="radio"]:checked').val();
    const customerId = $('#customer').val();
    const butcherName = $('#butcher-name').val();
    const branchId = $('#branch-id').val();

    if (!paymentMethod) {
        Swal.fire({
            title: 'Warning !',
            text: 'Metode Pembayaran tidak boleh kosong',
            icon: 'warning',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        });

        toReturn = false;
    }

    if (!customerId) {
        Swal.fire({
            title: 'Warning !',
            text: 'Nama customer harus di pilih',
            icon: 'warning',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        });

        toReturn = false;
    }

    if (!butcherName) {
        Swal.fire({
            title: 'Warning !',
            text: 'Nama Butcherees tidak boleh kosong',
            icon: 'warning',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        });

        toReturn = false;
    }

    if (!branchId) {
        Swal.fire({
            title: 'Warning !',
            text: 'Branch / Store harus di pilih',
            icon: 'warning',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        });

        toReturn = false;
    }

    return toReturn;
}
</script>
@endsection
