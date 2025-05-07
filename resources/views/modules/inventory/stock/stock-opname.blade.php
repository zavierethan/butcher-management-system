@extends('layouts.main')

@section('main-content')

<?php date_default_timezone_set("Asia/Jakarta"); ?>
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
                        Stock Opnames</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Inventory Management</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Stocks</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Stock Opnames</li>
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
                    <!--begin::Table-->
                    <div class="card">
                        <div class="card-body pt-10">
                            <form class="w-[60%]">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Store</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="text" value="{{$branch->name}}" readonly />
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="hidden" value="{{$branch->id}}" readonly />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Tanggal Stock Opname</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md" type="date"
                                                        value="<?php echo date("Y-m-d"); ?>" id="date" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <a href="{{route('stocks.index')}}"
                                        class="btn btn-sm btn-danger">Cancel</a>
                                    <button type="button" class="btn btn-sm btn-primary"
                                        id="btn-submit-so">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <!--begin::Table-->
                    <div class="card">
                        <div class="card-header border-0 pt-6">

                        </div>
                        <!--begin::Card body-->
                        <div class="card-body pt-0 overflow-x-auto">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_products_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="">No.</th>
                                        <th class="min-w-125px">Kode Produk</th>
                                        <th class="min-w-125px">Nama Produk</th>
                                        <th class="min-w-125px text-center">Stock Akhir (Kg)</th>
                                        <th class="min-w-125px">Hasil SO</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600" id="product-table">
                                    @php $counter = 1 @endphp
                                    @foreach($stocks as $stock)
                                    <tr>
                                        <td>
                                            @php echo $counter++ @endphp
                                        </td>
                                        <td>
                                            {{$stock->product_code}}
                                            <input type="hidden" value="{{$stock->id}}" class="stock-id" />
                                        </td>
                                        <td>{{$stock->product_name}}</td>
                                        <td class="text-center">{{$stock->stock_akhir}}</td>
                                        <td>
                                            <input type="number"
                                                class="form-control form-control-sm closing-stock-quantity" value="0" />
                                        </td>
                                        @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Table-->
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
// Utility function to sanitize input values
const sanitizeValue = (value) => {
    return value === '-' || value === '' ? null : value;
};

$(document).on('click', '#btn-submit-so', function(e) {
    e.preventDefault();

    if (true) {
        Swal.fire({
            title: 'Apakah anda yakin melakukan submit hasi SO ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya, Submit Data'
        }).then((result) => {
            if (result.isConfirmed) {
                let products = [];

                let soDate = $("#date").val();

                $("#product-table tr").each(function() {
                    let product = {
                        stock_id: $(this).find(".stock-id").val(),
                        quantity: $(this).find(".closing-stock-quantity").val(),
                        date: soDate,
                    };
                    products.push(product);
                });

                $.ajax({
                    url: `{{route('stocks.stock-opname-save')}}`,
                    type: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify({
                        products: products
                    }),
                    success: function(response) {
                        Swal.fire({
                            title: 'Suceess !',
                            text: `Data SO berhasil di submit.`,
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        }).then((result) => {
                            // Redirect the current page to the transaction index
                            location.href = `{{ route('stocks.index') }}`;
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

$("#btn-form-export").on("click", function() {
    const searchTerm = $('[data-kt-customer-table-filter="search"]').val();
    const startDate = $('#start-date').val();
    const endDate = $('#end-date').val();

    $.ajax({
        url: `{{url('/stocks/export')}}`,
        type: 'GET',
        data: {
            search_term: searchTerm,
            start_date: startDate,
            end_date: endDate,
        },
        xhrFields: {
            responseType: 'blob', // Treat response as binary
        },
        success: function(data, status, xhr) {
            $("#kt_modal_export_filter").modal('hide');
            // Create a Blob object from the response
            const blob = new Blob([data], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });

            // Create a link element for downloading
            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'stock-reports.xlsx'; // Set the filename
            document.body.appendChild(link); // Append link to the body
            link.click(); // Trigger the download
            document.body.removeChild(link); // Clean up the DOM

            Swal.fire({
                title: 'Success!',
                text: 'Stock report exported successfully.',
                icon: 'success',
                confirmButtonText: 'OK',
            });
        },
        error: function(xhr, status, error) {
            Swal.fire('Error!', 'Failed to export the stock report.', 'error');
        },
    });

});
</script>
@endsection
