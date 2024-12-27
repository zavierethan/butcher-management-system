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

            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <!--begin::Title-->
                        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Product Details</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">List Product in Branches</li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page title-->
                </div>
                <!--end::Toolbar container-->
            </div>
            <!--end::Toolbar-->

            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Row-->
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <!--begin::Table-->
                    <div class="card">
                        <div class="card-header border-0 pt-6">
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    {{-- edit for all here --}}
                                        <!-- Input fields for setting values for all rows -->
                                    <input type="text" id="setAllPrice" class="form-control form-control-sm me-2" placeholder="Set Price for All">
                                    <button id="applyPriceToAll" class="btn btn-primary btn-sm">Apply Price to All</button>
                                    <input type="text" id="setAllDiscount" class="form-control form-control-sm me-2" placeholder="Set Discount for All">
                                    <button id="applyDiscountToAll" class="btn btn-primary btn-sm">Apply Discount to All</button>
                                    <label class="fs-6 fw-semibold mb-2 required">Start Diskon</label>
                                    <input class="form-control form-control-solid" name="calendar_event_start_date" placeholder="Pick a start date" id="kt_calendar_datepicker_start_date"/>
                                    <button id="applyDiscountStartDateToAll" class="btn btn-primary btn-sm">Apply Discount Start to All</button>
                                    <input class="form-control form-control-solid" name="calendar_event_end_date" placeholder="Pick an end date" id="kt_calendar_datepicker_end_date"/>
                                    <button id="applyDiscountEndDateToAll" class="btn btn-primary btn-sm">Apply Discount End to All</button>
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--begin::Card body-->
                        <div class="card-body pt-0 overflow-x-auto">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_product_details_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Cabang</th>
                                        <th class="min-w-125px">Harga</th>
                                        <th class="min-w-125px">Diskon</th>
                                        <th class="min-w-125px">Diskon Start</th>
                                        <th class="min-w-125px">Diskon End</th>
                                        <th class="text-center min-w-70px">Status</th>
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
    $("#kt_product_details_table").DataTable({
        processing: true,
        serverSide: true,
        paging: true, // Enable pagination
        pageLength: 10, // Number of rows per page
        ajax: {
            url: `{{ route('product-details.get-lists', ['id' => $product->id]) }}`,
            type: 'GET',
            dataSrc: function (json) {
                return json.data; // Map the 'data' field
            }
        },
        columns: [
            { data: 'branch_name', name: 'branch_name' },
            {
                data: 'price',
                name: 'price',
                render: function (data, type, row) {
                    const displayValue = data !== null ? data : '-';
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
                    const displayValue = data !== null ? data : '-';
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
            // { data: 'start_period', name: 'start_period' },
            {
                data: 'start_period',
                name: 'start_period',
                render: function (data, type, row) {
                    const displayValue = data !== null ? data : '-';
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
                    const displayValue = data !== null ? data : '-';
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
                data: 'is_active', // Assuming you have this field in your data
                name: 'is_active',
                orderable: false, // Disable ordering for this column
                searchable: false, // Disable searching for this column
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
                data: null, // No direct field from the server
                name: 'action',
                orderable: false, // Disable ordering for this column
                searchable: false, // Disable searching for this column
                render: function (data, type, row) {
                    return `
                        <div class="text-center">
                            <a href="/product-details/update/${row.id}" class="btn btn-sm btn-light btn-active-light-primary">Update</a>
                        <div>
                    `;
                }
            },
        ]
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

    // Inline edit logic
    // $(document).on('change', '.inline-edit-price, .inline-edit-discount', function () {
    //     var inputField = $(this);
    //     var productId = inputField.data('id');
    //     var field = inputField.data('field'); // 'price' or 'discount'
    //     var newValue = inputField.val();

    //     $.ajax({
    //         url: '{{ route('product-details.update-row') }}', // Use a dedicated route to update specific fields
    //         type: 'POST',
    //         data: {
    //             _token: '{{ csrf_token() }}',
    //             id: productId,
    //             field: field,
    //             value: newValue
    //         },
    //         success: function (response) {
    //             if (response.success) {
    //                 Swal.fire({
    //                     icon: 'success',
    //                     title: 'Field updated successfully!',
    //                     text: `${field} has been updated.`,
    //                     showConfirmButton: true
    //                 });
    //             } else {
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Error updating field',
    //                     text: `Failed to update ${field}. Please try again.`,
    //                     showConfirmButton: true
    //                 });
    //                 inputField.val(response.oldValue); // Revert to the old value on error
    //             }
    //         },
    //         error: function () {
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Error processing the request',
    //                 text: 'Unable to process the request. Please try again later.',
    //                 showConfirmButton: true
    //             });
    //             inputField.val(inputField.data('old-value')); // Revert to the old value on error
    //         }
    //     });
    // });

    // // Inline edit logic for start_period and end_period
    // $(document).on('change', '.inline-edit-start-period, .inline-edit-end-period', function () {
    //     var inputField = $(this);
    //     var productId = inputField.data('id');
    //     var field = inputField.data('field'); // 'start_period' or 'end_period'
    //     var newValue = inputField.val();

    //     $.ajax({
    //         url: '{{ route('product-details.update-row') }}',
    //         type: 'POST',
    //         data: {
    //             _token: '{{ csrf_token() }}',
    //             id: productId,
    //             field: field,
    //             value: newValue
    //         },
    //         success: function (response) {
    //             if (response.success) {
    //                 Swal.fire({
    //                     icon: 'success',
    //                     title: 'Field updated successfully!',
    //                     text: `${field} has been updated.`,
    //                     showConfirmButton: true
    //                 });
    //             } else {
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Error updating field',
    //                     text: `Failed to update ${field}. Please try again.`,
    //                     showConfirmButton: true
    //                 });
    //                 inputField.val(response.oldValue); // Revert to the old value on error
    //             }
    //         },
    //         error: function () {
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Error processing the request',
    //                 text: 'Unable to process the request. Please try again later.',
    //                 showConfirmButton: true
    //             });
    //             inputField.val(inputField.data('old-value')); // Revert to the old value on error
    //         }
    //     });
    // });

    // apply price to all
    $(document).on('click', '#applyPriceToAll', function () {
        var newPrice = $('#setAllPrice').val();

        // If the input is empty, set price to null
        if (newPrice === '') {
            newPrice = null;
        }

        // Show confirmation dialog before proceeding
        Swal.fire({
            title: 'Are you sure?',
            text: 'This will apply the new price to all items. Do you want to continue?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, apply it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to update all rows
                $.ajax({
                    url: '{{ route('product-details.update-all-price') }}', // Define a route for updating all rows
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        price: newPrice,
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

        // If the input is empty, set discount to null
        if (newDiscount === '') {
            newDiscount = null;
        }

        // Show confirmation dialog before proceeding
        Swal.fire({
            title: 'Are you sure?',
            text: 'This will apply the discount to all items. Do you want to continue?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, apply it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to update all rows
                $.ajax({
                    url: '{{ route('product-details.update-all-discount') }}', // Define a route for updating all rows
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
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

        // If the input is empty, set discount to null
        if (newDiscountStartDate === '') {
            newDiscountStartDate = null;
        }

        // Show confirmation dialog before proceeding
        Swal.fire({
            title: 'Are you sure?',
            text: 'This will apply the discount start date to all items. Do you want to continue?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, apply it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to update all rows
                $.ajax({
                    url: '{{ route('product-details.update-all-discount-date') }}', // Define a route for updating all rows
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
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

        // If the input is empty, set discount to null
        if (newDiscountEndDate === '') {
            newDiscountEndDate = null;
        }

        // Show confirmation dialog before proceeding
        Swal.fire({
            title: 'Are you sure?',
            text: 'This will apply the discount end date to all items. Do you want to continue?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, apply it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to update all rows
                $.ajax({
                    url: '{{ route('product-details.update-all-discount-date') }}', // Define a route for updating all rows
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
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
