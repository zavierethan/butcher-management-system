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
                                                    type="date" name="request_date" value="<?php echo date('Y-m-d'); ?>" id="request-date" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Alokasi</label>
                                            <div class="position-relative mb-3">
                                                <select class="form-select form-select-solid" data-control="select2"
                                                    data-placeholder="-" name="alocation" id="alocation">
                                                    <option value="">-</option>
                                                    @foreach($branches as $branch)
                                                    <option value="{{$branch->id}}">{{$branch->code}}</option>
                                                    @endforeach
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
                                                    type="text" name="pic" id="pic"/>
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
                                    <div class="text-end">
                                        <a href="{{route('procurement.purchase-request.index')}}"
                                            class="btn btn-sm btn-danger">Cancel</a>
                                        <a href="#" class="btn btn-sm btn-primary" id="btn-submit-request">Submit
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
                            <div class="row mb-5">
                                <div class="col-md-12 text-end"><a href="javascript(0)" class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_add_item">Tambah Item</a></div>
                            </div>
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_items_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Item</th>
                                        <th class="min-w-125px">Tipe Item</th>
                                        <th class="min-w-125px">Jumlah</th>
                                        <th class="min-w-125px">Harga</th>
                                        <th class="min-w-125px">Total Harga</th>
                                        <th class="text-center min-w-70px">Actions</th>
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
                        <label class="form-label fw-bold fs-6 mb-2">Item</label>
                        <div class="position-relative mb-3">
                            <select class="form-select form-select-solid" data-control="select2" data-placeholder="-"
                                name="item" id="item">
                                <option value="">-</option>
                                <option value="1">Jhon</option>
                                <option value="2">Due</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Jumlah</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="number"
                                id="quantity" />
                        </div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-bold fs-6 mb-2">Harga</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-md form-control-solid" type="number" id="price" />
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="flex justify-content-center">
                    <button type="button" class="btn btn-primary" id="btn-form-add-item">Simpan</button>
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
$("#btn-form-add-item").on("click", function() {

    // Retrieve values from input fields
    var selectedOption = $("#item option:selected");

    var itemCategory = $("#item-categories").val();
    var itemId = selectedOption.val();
    var itemName = selectedOption.text();
    var quantity = $("#quantity").val();
    var price = $("#price").val();

    // Check if all fields are filled
    // if (!itemId || !itemName || !quantity || !price) {
    //     alert("Please fill out all fields!");
    //     return;
    // }

    // Create a new row with the data
    var row = `
        <tr>
            <td>
                ${itemName}
                <input type="hidden" value="${itemId}" class="item-id" />
            </td>
            <td class="item-category">${itemCategory}</td>
            <td class="item-quantity">${quantity}</td>
            <td class="item-price">${price}</td>
            <td class="item-total-price">${price * quantity}</td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-danger" onclick="deleteRow(this)">Hapus</i></a>
            </td>
        </tr>
    `;

    // Append the new row to the table body
    $("#kt_items_table tbody").append(row);

    // Hide the modal
    $('#kt_modal_add_item').modal('hide');

    // Clear input fields after adding the row
    $("#item_id").val('');
    $("#item_name").val('');
    $("#quantity").val('');
    $("#price").val('');
});

$("#category").on("change", function() {
    $("#item-categories").val($(this).val());
});

$(document).on('click', '#btn-submit-request', function(e) {
    e.preventDefault();

    if (!validate()) {
        Swal.fire({
            title: 'Apakah anda yakin untuk memproses request ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya, Proses Request'
        }).then((result) => {
            if (result.isConfirmed) {
                const itemLists = [];

                $('#kt_items_table tbody tr').each(function() {
                    var itemId = $(this).find("td:first-child input[type='hidden']").val();

                    // Get the text content of specific cells in the current row
                    var itemName = $(this).find("td:first-child").text().trim(); // Get text in the first <td> (trim to remove extra spaces)
                    var itemCategory = $(this).find(".item-category").text().trim();
                    var itemQuantity = $(this).find(".item-quantity").text().trim();
                    var itemPrice = $(this).find(".item-price").text().trim();
                    var itemTotalPrice = $(this).find(".item-total-price").text().trim();

                    itemLists.push({
                        item_id: itemId,
                        category: itemCategory,
                        quantity: itemQuantity,
                        price: itemPrice,
                        total_price: itemTotalPrice,
                    });
                });

                var requestDate = $('#request-date').val();
                var alocation = $('#alocation').val();
                var pic = $('#pic').val();
                var category = $('#category').val();

                // Build the JSON payload
                const payload = {
                    header: {
                        date: requestDate,
                        alocation: alocation,
                        pic: pic,
                        category: category,
                    },
                    details: itemLists
                };

                console.log(payload)

                $.ajax({
                    url: `{{route('procurement.purchase-request.save')}}`,
                    type: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify(payload),
                    success: function(response) {
                        Swal.fire({
                            title: 'Suceess !',
                            text: `Transaksi berhasil di simpan dengan Nomor Request ${response.request_number}`,
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
