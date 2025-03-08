@extends('layouts.main')

@section('main-content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Stocks</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Inventory Management</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Stocks</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Create</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <div class="card">
                        <div class="card-body pt-10">
                            <form id="stock-form" class="w-[60%]" enctype="multipart/form-data">
                                @csrf
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Produk</label>
                                        <div class="position-relative mb-3">
                                            <select class="form-select form-select-solid" data-control="select2" data-placeholder="-" name="product_id">
                                                <option value="">-</option>
                                                @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->code }} - {{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Cabang</label>
                                        <div class="position-relative mb-3">
                                            <select class="form-select form-select-solid" data-control="select2" data-placeholder="-" name="branch_id">
                                                <option value="">-</option>
                                                @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->code }} - {{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="row row-cols-lg-2 g-10">
                                    <div class="col">
                                        <div class="fv-row mb-9">
                                            <label class="fs-6 fw-semibold mb-2 required">Tanggal</label>
                                            <input class="form-control form-control-solid" name="calendar_event_date" placeholder="Pick a date" id="kt_calendar_datepicker_date" />
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="row row-cols-lg-2 g-10">
                                    <div class="col">
                                        <div class="fv-row mb-9">
                                            <label class="fs-6 fw-semibold mb-2 required">Base Price</label>
                                            <input class="form-control form-control-solid" name="base_price" placeholder="Harga dasar" id="base_price" />
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="row row-cols-lg-2 g-10">
                                    <div class="col">
                                        <div class="fv-row mb-9">
                                            <label class="fs-6 fw-semibold mb-2 required">Sale Price</label>
                                            <input class="form-control form-control-solid" name="sale_price" placeholder="Harga jual" id="sale_price" />
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="flex justify-end">
                                    <button type="submit" id="submit-btn" class="btn btn-primary">Submit</button>
                                    <a href="{{route('stocks.index')}}" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- Include Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        // Initialize Flatpickr for date input
        flatpickr('#kt_calendar_datepicker_date', {
            dateFormat: "Y-m-d",
            enableTime: false
        });

        $('#stock-form').submit(function (event) {
            event.preventDefault(); // Prevent default form submission

            let form = $(this);
            let formData = new FormData(this);
            let submitButton = $('#submit-btn');

            submitButton.prop('disabled', true); // Disable button to prevent multiple submissions

            $.ajax({
                url: "{{ route('stocks.save') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val()
                },
                success: function (response) {
                    if (response.success) {
                        window.location.href = response.redirect; // Redirect only on success
                    }
                },
                error: function (xhr) {
                    submitButton.prop('disabled', false);

                    let response = xhr.responseJSON;
                    if (xhr.status === 422) {
                        $('.text-danger').remove();
                        if (response && response.message) {
                            alert(response.message); // Show error message
                        } else {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, messages) {
                                let inputField = $('[name="' + key + '"]');
                                inputField.after('<div class="text-danger">' + messages[0] + '</div>');
                            });
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON.message || 'Terjadi kesalahan, coba lagi.'
                        });
                    }
                }
            });
        });
    });


</script>
@endsection
