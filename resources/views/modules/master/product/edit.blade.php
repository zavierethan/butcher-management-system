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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Products</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Master Data</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Products</li>
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
                            <form class="w-[60%]" method="POST" action="{{route('products.update')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Kode</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-md form-control-solid" type="text" name="code" id="code" value="{{$product->code}}" />
                                            <input class="form-control form-control-md form-control-solid" type="hidden" name="id" id="id" value="{{$product->id}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Nama</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-md form-control-solid" type="text" name="name" id="name" value="{{$product->name}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Kategori</label>
                                        <div class="position-relative mb-3">
                                            <select class="form-select form-select-solid" data-control="select2" data-placeholder="-" name="category_id">
                                                <option value="">-</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}" <?php echo ($category->id == $selectedCategoryId) ? "selected" : ""; ?>>{{ $category->id }} - {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <!-- Media Section -->
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Media</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="fv-row mb-2">
                                            <label for="media" class="form-label fw-bold fs-6 mb-2">Current Image</label>
                                            <img src="{{ asset('storage/' . $product->url_path) }}" class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px" alt="" />
                                        </div>
                                        <div class="fv-row mb-2">
                                            <label for="media" class="form-label fw-bold fs-6 mb-2">Upload Image</label>
                                            <input type="file" name="media" id="media" class="form-control" accept="image/*" onchange="previewImage(event)" />
                                        </div>
                                        <div class="text-muted fs-7">Upload an image for the product.</div>
                                        <!-- Image Preview -->
                                        <div id="image-preview" class="mt-3" style="display: none;">
                                            <h5>Image Preview:</h5>
                                            <img id="preview-img" src="" alt="Image Preview" class="img-fluid" style="max-width: 300px; border-radius: 8px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Is Active</label>
                                        <div class="position-relative mb-3">
                                            <select class="form-select form-select-solid" data-control="select2" data-placeholder="-" name="is_active">
                                                <option value=""></option>
                                                <option value="1" <?php echo ($product->is_active == 1) ? "selected" : ""; ?>>Yes</option>
                                                <option value="0" <?php echo ($product->is_active == 0) ? "selected" : ""; ?>>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="flex justify-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{route('products.index')}}" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
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
    // Utility function to sanitize input values
    const sanitizeValue = (value) => {
        return value === '-' || value === '' ? null : value;
    };

    $("#kt_byproduct_details_table").DataTable({
        processing: true,
        serverSide: true,
        paging: true,
        pageLength: 10,
        ajax: {
            url: `{{ route('products.get-lists-carcass') }}`,
            type: 'GET',
            dataSrc: function (json) {
                return json.data;
            }
        },
        columns: [
            { data: 'code', name: 'code' },
            { data: 'name', name: 'name' },
            {
                data: 'formula',
                name: 'formula',
                render: function (data, type, row) {
                    const displayValue = data !== null ? data : '';
                    return `
                        <div class="d-flex align-items-center">
                            <input type="text"
                                class="form-control form-control-sm inline-edit-formula me-2"
                                value="${displayValue}"
                                data-id="${row.id}"
                                data-field="formula" />
                        </div>
                    `;
                }
            },
            {
                data: null,
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <div class="text-center">
                            <button type="button" class="btn btn-sm btn-light btn-active-light-primary btn-update-formula" data-id="${row.id}">Update</button>
                        <div>
                    `;
                }
            },
        ]
    });

    // Initialize the DataTable
    $("#kt_product_details_table").DataTable({
        processing: true,
        serverSide: true,
        paging: true,
        pageLength: 10,
        ajax: {
            url: `{{ route('product-details.get-lists', ['id' => $product->id]) }}`,
            type: 'GET',
            dataSrc: function (json) {
                return json.data;
            }
        },
        columns: [
            { data: 'branch_name', name: 'branch_name' },
            {
                data: 'price',
                name: 'price',
                render: function (data, type, row) {
                    const displayValue = data !== null ? data : '';
                    return `
                        <div class="d-flex align-items-center">
                            <input type="text"
                                class="form-control form-control-sm inline-edit-price me-2"
                                value="${displayValue}"
                                data-id="${row.id}"
                                data-field="price" />
                        </div>
                    `;
                }
            },
            {
                data: 'discount',
                name: 'discount',
                render: function (data, type, row) {
                    const displayValue = data !== null ? data : '';
                    return `
                        <div class="d-flex align-items-center">
                            <input type="text"
                                class="form-control form-control-sm inline-edit-discount me-2"
                                value="${displayValue}"
                                data-id="${row.id}"
                                data-field="discount" />
                        </div>
                    `;
                }
            },
            {
                data: 'start_period',
                name: 'start_period',
                render: function (data, type, row) {
                    const displayValue = data !== null ? data : '';
                    return `
                        <div class="d-flex align-items-center">
                            <input type="date"
                                class="form-control form-control-sm inline-edit-start-period me-2"
                                value="${displayValue}"
                                data-id="${row.id}"
                                data-field="start_period" />
                        </div>
                    `;
                }
            },
            {
                data: 'end_period',
                name: 'end_period',
                render: function (data, type, row) {
                    const displayValue = data !== null ? data : '';
                    return `
                        <div class="d-flex align-items-center">
                            <input type="date"
                                class="form-control form-control-sm inline-edit-end-period me-2"
                                value="${displayValue}"
                                data-id="${row.id}"
                                data-field="end_period" />
                        </div>
                    `;
                }
            },
            {
                data: 'is_active',
                name: 'is_active',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <div class="d-flex justify-content-center">
                            <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                <input class="form-check-input toggle-status"
                                    type="checkbox"
                                    data-id="${row.id}"
                                    ${data ? 'checked' : ''}>
                                <span class="form-check-label fw-bold text-muted"></span>
                            </label>
                        </div>
                    `;
                }
            },
            {
                data: null,
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <div class="text-center">
                            <button type="button" class="btn btn-sm btn-light btn-active-light-primary btn-update-product-details" data-id="${row.id}">Update</button>
                        <div>
                    `;
                }
            },
        ]
    });

    // Handle the Update button click with SweetAlert for formula
    $(document).on('click', '.btn-update-formula', function (e) {
        e.preventDefault();

        const row = $(this).closest('tr');
        const id = $(this).data('id');
        const formula = sanitizeValue(row.find('.inline-edit-formula').val());

        const data = {
            _token: '{{ csrf_token() }}',
            id: id,
            formula: formula
        };

        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to update this row?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                // Send the AJAX request
                $.ajax({
                    url: '{{ route("products.update-formula") }}',
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Updated!', 'The row has been updated successfullys.', 'success');
                        } else {
                            Swal.fire('Error!', 'Failed to update the rowff.', 'error');
                        }
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMsg = '';
                        for (const key in errors) {
                            errorMsg += `${errors[key]}<br>`;
                        }
                        Swal.fire('Error!', errorMsg, 'error');
                    },
                });
            }
        });
    });

    // Handle the Update button click with SweetAlert
    $(document).on('click', '.btn-update-product-details', function (e) {
        e.preventDefault();

        const row = $(this).closest('tr');
        const id = $(this).data('id');
        const price = sanitizeValue(row.find('.inline-edit-price').val());
        const discount = sanitizeValue(row.find('.inline-edit-discount').val());
        const startPeriod = row.find('.inline-edit-start-period').val();
        const endPeriod = row.find('.inline-edit-end-period').val();

        const productName = $('#product_name').val();

        const data = {
            _token: '{{ csrf_token() }}',
            id: id,
            price: price,
            discount: discount,
            start_period: startPeriod,
            end_period: endPeriod,
            product_name: productName
        };

        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to update this row?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                // Send the AJAX request
                $.ajax({
                    url: '{{ route("product-details.update") }}',
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Updated!', 'The row has been updated successfully.', 'success');
                        } else {
                            Swal.fire('Error!', 'Failed to update the row.', 'error');
                        }
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMsg = '';
                        for (const key in errors) {
                            errorMsg += `${errors[key]}<br>`;
                        }
                        Swal.fire('Error!', errorMsg, 'error');
                    },
                });
            }
        });
    });

    $(document).on('change', '.toggle-status', function() {
        var productId = $(this).data('id');
        var isActive = $(this).prop('checked') ? 1 : 0;

        $.ajax({
            url: '{{ route('product-details.update-status') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: productId,
                is_active: isActive
            },
            success: function(response) {
                if (response.success) {
                    // Show success SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Status updated successfully!',
                        text: 'The product status has been updated.',
                        showConfirmButton: true
                    });
                } else {
                    // Show error SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error updating status',
                        text: 'There was an issue updating the status. Please try again.',
                        showConfirmButton: true
                    });

                    // Optionally revert the toggle switch if there's an error
                    $(this).prop('checked', !isActive);
                }
            },
            error: function() {
                // Show error SweetAlert on AJAX failure
                Swal.fire({
                    icon: 'error',
                    title: 'Error processing the request',
                    text: 'Unable to process the request. Please try again later.',
                    showConfirmButton: true
                });

                // Optionally revert the toggle switch if there's an error
                $(this).prop('checked', !isActive);
            }
        });
    });

    // apply price to all
    $(document).on('click', '#applyPriceToAll', function () {
        var newPrice = $('#setAllPrice').val();
        var productId = $('#id').val();
        var productName = $('#product_name').val();

        // If the input is empty, set price to null
        if (newPrice === '') {
            newPrice = null;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: 'This will apply the new price to all items. Do you want to continue?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, apply it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('product-details.update-all-price') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        price: newPrice,
                        product_name: productName
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated Successfully!',
                                text: 'All rows have been updated.',
                                showConfirmButton: true
                            });

                            // Optionally, reload the DataTable to reflect the changes
                            $('#kt_product_details_table').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error Updating Rows',
                                text: 'Failed to update all rows. Please try again.',
                                showConfirmButton: true
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error Processing Request',
                            text: 'Unable to process the request. Please try again later.',
                            showConfirmButton: true
                        });
                    }
                });
            }
        });
    });


    // apply discount to all
    $(document).on('click', '#applyDiscountToAll', function () {
        var newDiscount = $('#setAllDiscount').val();
        var productId = $('#id').val();

        // If the input is empty, set discount to null
        if (newDiscount === '') {
            newDiscount = null;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: 'This will apply the discount to all items. Do you want to continue?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, apply it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('product-details.update-all-discount') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        discount: newDiscount,
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated Successfully!',
                                text: 'All rows have been updated.',
                                showConfirmButton: true
                            });

                            // Optionally, reload the DataTable to reflect the changes
                            $('#kt_product_details_table').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error Updating Rows',
                                text: 'Failed to update all rows. Please try again.',
                                showConfirmButton: true
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error Processing Request',
                            text: 'Unable to process the request. Please try again later.',
                            showConfirmButton: true
                        });
                    }
                });
            }
        });
    });


    // apply discount start date to all
    $(document).on('click', '#applyDiscountStartDateToAll', function () {
        var newDiscountStartDate = $('#kt_calendar_datepicker_start_date').val();
        var productId = $('#id').val();

        // If the input is empty, set discount to null
        if (newDiscountStartDate === '') {
            newDiscountStartDate = null;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: 'This will apply the discount start date to all items. Do you want to continue?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, apply it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('product-details.update-all-discount-date') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        discountStartDate: newDiscountStartDate,
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated Successfully!',
                                text: 'All rows have been updated.',
                                showConfirmButton: true
                            });

                            // Optionally, reload the DataTable to reflect the changes
                            $('#kt_product_details_table').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error Updating Rows',
                                text: 'Failed to update all rows. Please try again.',
                                showConfirmButton: true
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error Processing Request',
                            text: 'Unable to process the request. Please try again later.',
                            showConfirmButton: true
                        });
                    }
                });
            }
        });
    });


    // apply discount end date to all
    $(document).on('click', '#applyDiscountEndDateToAll', function () {
        var newDiscountEndDate = $('#kt_calendar_datepicker_end_date').val();
        var productId = $('#id').val();

        // If the input is empty, set discount to null
        if (newDiscountEndDate === '') {
            newDiscountEndDate = null;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: 'This will apply the discount end date to all items. Do you want to continue?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, apply it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('product-details.update-all-discount-date') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        discountEndDate: newDiscountEndDate,
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated Successfully!',
                                text: 'All rows have been updated.',
                                showConfirmButton: true
                            });

                            // Optionally, reload the DataTable to reflect the changes
                            $('#kt_product_details_table').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error Updating Rows',
                                text: 'Failed to update all rows. Please try again.',
                                showConfirmButton: true
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error Processing Request',
                            text: 'Unable to process the request. Please try again later.',
                            showConfirmButton: true
                        });
                    }
                });
            }
        });
    });

</script>

<script>
    // Function to preview the uploaded image
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview-img');
                const previewContainer = document.getElementById('image-preview');
                preview.src = reader.result;
                previewContainer.style.display = 'block'; // Show image preview
            };
            reader.readAsDataURL(file);
        }
    }
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr('#kt_calendar_datepicker_start_date', {
            dateFormat: "Y-m-d",
            enableTime: false
        });
        flatpickr('#kt_calendar_datepicker_end_date', {
            dateFormat: "Y-m-d",
            enableTime: false
        });
    });
</script>

@endsection
