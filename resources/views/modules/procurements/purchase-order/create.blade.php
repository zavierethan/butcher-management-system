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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Tanggal</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="date" name="request_date" value="<?php echo date('Y-m-d'); ?>"
                                                    id="request-date" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Supplier</label>
                                            <div class="position-relative mb-3">
                                                <select class="form-select form-select-solid" data-control="select2"
                                                    data-placeholder="-" name="alocation" id="supplier">
                                                    <option value="">-</option>
                                                    @foreach($suppliers as $supplier)
                                                    <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Kategori</label>
                                            <div class="position-relative mb-3">
                                                <select class="form-select form-select-solid" data-control="select2"
                                                    data-placeholder="-" name="category" id="category">
                                                    <option value="">-</option>
                                                    <option value="OP">Operational (OP)</option>
                                                    <option value="PR">Product (PR)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">PIC</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="text" name="pic" id="pic" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Methode Pembayaran</label>
                                            <div class="position-relative mb-3">
                                                <select class="form-select form-select-solid" data-control="select2" data-placeholder="-" name="payment_method" id="payment-method">
                                                    <option value="">-</option>
                                                    <option value="1">Tunai</option>
                                                    <option value="2">Transfer</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Status Pembayaran</label>
                                            <div class="position-relative mb-3">
                                                <select class="form-select form-select-solid" data-control="select2" data-placeholder="-" name="payment_status" id="payment-status">
                                                    <option value="">-</option>
                                                    <option value="1">Lunas</option>
                                                    <option value="2">Term</option>
                                                    <option value="3">Utang</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                </div>
                            </div>
                            <div class="text-end">
                                <a href="{{route('procurement.purchase-order.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                                <a href="#" class="btn btn-sm btn-primary" id="btn-submit-request">Submit PO</a>
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
                            <div class="row mb-5">
                                <div class="col-md-12 text-end"><a href="javascript(0)" class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_add_item">Tambah Item</a></div>
                            </div>
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_items_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Nomor request</th>
                                        <th class="min-w-125px">Item</th>
                                        <th class="min-w-125px">Tipe Item</th>
                                        <th class="min-w-125px text-center">Jumlah</th>
                                        <th class="min-w-125px text-end">Harga</th>
                                        <th class="min-w-125px text-end">Total Harga</th>
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

<!--begin::Modal - Add Customer-->
<div class="modal fade" id="kt_modal_add_item" tabindex="-1" aria-hidden="true">
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
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                <!--begin::Heading-->
                <div class="text-center mb-13">
                    <!--begin::Title-->
                    <h1 class="mb-3">Tambah Item</h1>
                    <!--end::Title-->
                </div>
                <div class="fv-row mb-5">
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">kategori Item</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="text"
                                id="item-categories" readonly />
                        </div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Nomor Purchase Request</label>
                        <div class="position-relative mb-3">
                            <select class="form-select form-select-solid" data-control="select2" data-placeholder="-" name="purhcase_request" id="purchase-request">
                                <option value="">-</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="flex justify-content-center">
                    <button type="button" class="btn btn-primary" id="btn-form-add-item">Tambahkan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        id="btn-form-close">Batal</button>
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
$('#kt_modal_add_item').on('shown.bs.modal', function() {
    $('#purhcase-request').select2({
        dropdownParent: $('#kt_modal_add_item') // Ensure dropdown stays inside modal
    });
});

$("#btn-form-add-item").on("click", function() {

    // Retrieve values from input fields
    var selectedOption = $("#purchase-request option:selected");
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
            $("#grand-total").remove();

            var nominalGrandTotal = 0;
            data.forEach(function(items) {
                // Construct HTML for each product
                var row = `
                        <tr>
                            <td class="item-request-number">
                                ${items.request_number}
                            </td>
                            <td>
                                ${items.name} (${items.item_notes})
                                <input type="hidden" value="${items.item_id}" class="item-id" />
                                <input type="hidden" value="${items.purchase_request_item_id}" class="purchase-request-item-id" />
                            </td>
                            <td class="item-category">${items.category}</td>
                            <td class="text-center item-quantity">${items.quantity}</td>
                            <td class="text-end item-price">${items.price}</td>
                            <td class="text-end item-total-price">${items.total_price}</td>
                        </tr>
                    `;
                    nominalGrandTotal += parseFloat(items.total_price.replace(/[^\d]/g, ''));
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

    getPurchaseRequest($(this).val());
});

function getPurchaseRequest(param) {
    $.ajax({
        url: '/api/get-purchase-request/', // Laravel route to fetch products
        type: 'GET',
        data: {
            category: param,
        },
        dataType: 'json',
        beforeSend: function() {
            // Clear existing options before the request
            $('#purchase-request').html('<option value="">-</option>');
        },
        success: function(response) {
            const selectBox = $('#purchase-request');

            // Loop through the array and add each item as an option
            response.forEach(item => {
                selectBox.append(new Option(item.request_number, item.id));
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching products:', error);
        }
    });
}

$(document).on('click', '#btn-submit-request', function(e) {
    e.preventDefault();

    if (!validate()) {
        Swal.fire({
            title: 'Apakah anda yakin untuk memproses PO ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya, Proses PO'
        }).then((result) => {
            if (result.isConfirmed) {
                const itemLists = [];
                let sub_total = 0;

                $('#kt_items_table tbody tr').each(function() {

                    var itemId = $(this).find(".item-id").val();
                    var itemReqNumber = $(this).find(".item-request-number").text().trim();
                    var purchaseRequestItemId = $(this).find(".purchase-request-item-id").val();
                    var itemCategory = $(this).find(".item-category").text().trim();
                    var itemQuantity = $(this).find(".item-quantity").text().trim();
                    var itemPrice = $(this).find(".item-price").text().trim().replace(/,/g, "");
                    var itemTotalPrice = $(this).find(".item-total-price").text().trim().replace(/,/g, "");

                    itemLists.push({
                        item_id: itemId,
                        item_req_number: itemReqNumber,
                        purchase_request_item_id: purchaseRequestItemId,
                        category: itemCategory,
                        quantity: itemQuantity,
                        price: itemPrice,
                        total_price: itemTotalPrice,
                    });

                    sub_total += parseFloat(itemTotalPrice) || 0;
                });

                var requestDate = $('#request-date').val();
                var supplier = $('#supplier').val();
                var pic = $('#pic').val();
                var category = $('#category').val();

                // Build the JSON payload
                const payload = {
                    header: {
                        date: requestDate,
                        supplier: supplier,
                        pic: pic,
                        category: category,
                        total_amount: sub_total || 0,
                    },
                    details: itemLists
                };

                console.log(payload)

                $.ajax({
                    url: `{{route('procurement.purchase-order.save')}}`,
                    type: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify(payload),
                    success: function(response) {
                        Swal.fire({
                            title: 'Suceess !',
                            text: `Transaksi berhasil di simpan dengan Nomor Order ${response.order_number}`,
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        }).then((result) => {
                            let receiptUrl =
                                `{{ route('procurement.purchase-order.print-po', ['id' => '__order_id__']) }}`;
                            receiptUrl = receiptUrl.replace(
                                '__order_id__', response
                                .order_id);

                            // Open the receipt in a new tab
                            window.open(receiptUrl, '_blank');

                            // Redirect the current page to the transaction index
                            location.href =
                                `{{ route('procurement.purchase-order.index') }}`;
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

function formatNumber(numStr) {
    let cleaned = numStr.toString().replace(/[^\d.]/g, '');
    const parts = cleaned.split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join('.');
}
</script>
@endsection
