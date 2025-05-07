@extends('layouts.main')

@section('main-content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Order Details</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Order Lists</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <div class="card">
                        <div class="card-body pt-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Kode Transaksi</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="text" value="{{$detailTransaction->code}}" readonly />
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="hidden" value="{{$detailTransaction->id}}" id="transaction-id"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Tanggal</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    value="{{$detailTransaction->transaction_date}}" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Customer</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    value="{{$detailTransaction->customer_name}}" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Nama Butcher</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    value="{{$detailTransaction->butcher_name}}" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Kasir</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="text" value="{{$detailTransaction->created_by}}" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Metode Pembayaran</label>
                                            <div class="position-relative mb-3">
                                                <select class="form-select form-select-solid" data-control="select2"
                                                    data-placeholder="-" name="payment-method" id="payment-method" disabled>
                                                    <option value="1"
                                                        <?php echo ($detailTransaction->payment_method == 1) ? "selected" : ""; ?>>
                                                        Tunai</option>
                                                    <option value="2"
                                                        <?php echo ($detailTransaction->payment_method == 2) ? "selected" : ""; ?>>
                                                        Piutang</option>
                                                    <option value="3"
                                                        <?php echo ($detailTransaction->payment_method == 3) ? "selected" : ""; ?>>
                                                        Transfer</option>
                                                    <option value="4"
                                                        <?php echo ($detailTransaction->payment_method == 4) ? "selected" : ""; ?>>
                                                        COD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5 payment-method-form"></div>
                                    <div class="fv-row mb-5 payment-method-form">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Ref. Bukti Transfer</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    value="{{$detailTransaction->transfer_ref}}" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5 payment-method-form"></div>
                                    <div class="fv-row mb-5 payment-method-form">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Lampiran</label>
                                            <a href="javascript(0);" data-bs-toggle="modal" data-bs-target="#kt_img_viewer" class="previewImageBtn" data-file="data:image/png;base64,{{$detailTransaction->transfer_attch}}"><i class="fa-solid fa-eye"></i></a>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid" type="file" value=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                    <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Total Transaksi (Rp)</label>
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="text" value="@php echo number_format($detailTransaction->total_amount, 0, '.', ',') @endphp" readonly />
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
                                                    <option value="1"
                                                        <?php echo ($detailTransaction->status == 1) ? "selected" : ""; ?>>
                                                        Lunas</option>
                                                    <option value="2"
                                                        <?php echo ($detailTransaction->status == 2) ? "selected" : ""; ?>>
                                                        Pending (Piutang)</option>
                                                    <option value="3"
                                                        <?php echo ($detailTransaction->status == 3) ? "selected" : ""; ?>>
                                                        Pending (Transfer)</option>
                                                    <option value="4"
                                                        <?php echo ($detailTransaction->status == 4) ? "selected" : ""; ?>>
                                                        Batal (Return)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-5"></div>
                                </div>
                                <div class="text-end">
                                    <a href="{{route('orders.index')}}" class="btn btn-danger">Cancel</a>
                                    <a href="#" class="btn btn-primary" id="btn-update">Update</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--begin::Product List-->
                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                    <thead>
                                        <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-175px">Nama Product</th>
                                            <th class="min-w-70px text-end">Jumlah (Kg)</th>
                                            <th class="min-w-100px text-end">Harga (Per Kg)</th>
                                            <th class="min-w-100px text-end">Diskon</th>
                                            <th class="min-w-100px text-end">Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach($detailItems as $detail)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Title-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fw-bold text-gray-600 text-hover-primary">{{$detail->code}}</a>
                                                        <div class="fs-7 text-muted">{{$detail->name}}</div>
                                                    </div>
                                                    <!--end::Title-->
                                                </div>
                                            </td>
                                            <td class="text-end">{{$detail->quantity}}</td>
                                            <td class="text-end">@php echo number_format($detail->base_price, 0, '.', ',') @endphp</td>
                                            <td class="text-end">{{$detail->discount}}</td>
                                            <td class="text-end">@php echo number_format($detail->sell_price, 0, '.', ',') @endphp</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="4" class="text-end">Subtotal</td>
                                            <td class="text-end">@php echo number_format($detailTransaction->total_amount, 0, '.', ',') @endphp</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">Biaya Pengiriman</td>
                                            <td class="text-end">@php echo number_format($detailTransaction->shipping_cost, 0, '.', ',') @endphp</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="fs-3 text-gray-900 text-end">Grand Total</td>
                                            <td class="text-gray-900 fs-3 fw-bolder text-end">
                                                @php
                                                    $grand_total = ($detailTransaction->total_amount - $detailTransaction->discount) + $detailTransaction->shipping_cost;
                                                    echo number_format($grand_total, 0, '.', ',');
                                                @endphp
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Product List-->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="kt_img_viewer" tabindex="-1" aria-hidden="true">
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
                <img id="previewImage" src="" alt="Preview" class="max-h-96 mx-auto" />
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
$(document).ready(function() {

    var paymentMethod = $("#payment-method").val();

    if(paymentMethod != 3) {
        $(".payment-method-form").hide();
    }

    $('.previewImageBtn').on('click', function(e) {
        e.preventDefault();

        var base64Image = $(this).data('file');

        console.log(base64Image)

        if (!base64Image) {
            alert('No image available.');
            return;
        }

        $('#previewImage').attr('src', base64Image);
    });

    $('#btn-update').on('click', function(e) {
        e.preventDefault();

        let transaction_id = $("#transaction-id").val();
        let status = $("#status").val();

        Swal.fire({
            title: 'Apakah anda yakin untuk memperbaharui status transaksi ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Update Transaksi'
        }).then((result) => {
            if (result.isConfirmed) {

                const payload = {
                    transaction_id: transaction_id,
                    status: status
                };

                console.log(payload)

                $.ajax({
                    url: `{{route('orders.update')}}`,
                    type: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify(payload),
                    success: function(response) {
                        Swal.fire({
                            title: 'Suceess !',
                            text: 'Transaksi berhasil di perbaharui',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            location.href = `{{route('orders.index')}}`;
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
    });
});
</script>

@endsection
