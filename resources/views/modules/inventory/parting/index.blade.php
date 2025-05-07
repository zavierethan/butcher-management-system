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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Parting</h1>
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
                        <li class="breadcrumb-item text-muted">Parting</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Secondary button-->
                    <a href="#" class="btn btn-sm fw-bold btn-secondary" id="btn-form-export">Export</a>
                    <!--end::Secondary button-->
                    <!--begin::Primary button-->
                    <a href="{{route('partings.create')}}" class="btn btn-sm fw-bold btn-primary">New</a>
                    <!--end::Primary button-->
                </div>
                <!--end::Actions-->
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
                        <div class="card-header border-0 pt-6">
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <!--begin::Filters-->
                                <div class="d-flex flex-stack flex-wrap gap-4">
                                    <div class="d-flex align-items-center fw-bold">
                                        <!--begin::Label-->
                                        <div class="text-gray-500 fs-7 me-2">Tanggal</div>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <input type="date" class="form-control form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto" id="start-date" value="<?php echo date("Y-m-d"); ?>"/> -
                                        <input type="date" class="form-control form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto" id="end-date" value="<?php echo date("Y-m-d"); ?>"/>
                                        <!--end::Select-->
                                    </div>
                                    <!--begin::Search-->
                                    <div class="position-relative my-1">
                                        <i
                                            class="ki-duotone ki-magnifier fs-2 position-absolute top-50 translate-middle-y ms-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="text" data-kt-customer-table-filter="search"
                                            class="form-control form-control-solid w-250px ps-15"
                                            placeholder="Nama Produk" />
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--begin::Card body-->
                        <div class="card-body pt-0 overflow-x-auto">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_partings_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Tanggal</th>
                                        <th class="min-w-125px">Cabang</th>
                                        <th class="min-w-125px">Ayam Hidup (Ekor)</th>
                                        <th class="min-w-125px">Ayam Hidup (Kg)</th>
                                        <th class="min-w-125px">Susut Ayam Hidup Ke Rancung</th>
                                        <th class="min-w-125px">Susut Rancung Ke Parting</th>
                                        <th class="min-w-125px">Hasil Parting (Kg)</th>
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
    // Utility function to sanitize input values
    const sanitizeValue = (value) => {
        return value === '-' || value === '' ? null : value;
    };

    // Initialize DataTable
    const table = $("#kt_partings_table").DataTable({
        processing: true,
        serverSide: true,
        paging: true, // Enable pagination
        pageLength: 10, // Number of rows per page
        ajax: {
            url: `{{ route('partings.get-lists') }}`, // Replace with your route
            type: 'GET',
            data: function (d) {
                // Send filter values to the server along with the pagination params
                d.searchTerm = $('[data-kt-customer-table-filter="search"]').val();
                d.startDate = $('#start-date').val();
                d.endDate = $('#end-date').val();
            },
            dataSrc: function (json) {
                // Modify data before passing it to DataTables
                json.data.forEach(item => {
                    if (item.total_live_chickens_weight && item.total_weight_live_to_rancung) {
                        item.susut_live_to_rancung = ((item.total_weight_live_to_rancung / item.total_live_chickens_weight ) * 100) - 100;
                    } else {
                        item.susut_live_to_rancung = null; // Handle cases where values are missing
                    }

                    if (item.total_weight_live_to_rancung && item.total_weight_rancung_to_parting) {
                        item.susut_rancung_to_parting = ((item.total_weight_rancung_to_parting / item.total_weight_live_to_rancung ) * 100) - 100;
                    } else {
                        item.susut_rancung_to_parting = null; // Handle cases where values are missing
                    }
                });
                return json.data;
            }
        },
        columns: [
            { data: 'date', name: 'date' },
            { data: 'branch_name', name: 'branch_name' },
            { data: 'total_live_chickens_number', name: 'total_live_chickens_number' },
            { data: 'total_live_chickens_weight', name: 'total_live_chickens_weight' },
            { data: 'total_weight_live_to_rancung', name: 'total_weight_live_to_rancung' },
            { data: 'total_weight_rancung_to_parting', name: 'total_weight_rancung_to_parting' },
            // {
            //     data: 'susut_live_to_rancung',
            //     name: 'susut_live_to_rancung',
            //     render: function (data, type, row) {
            //         return data !== null ? data.toFixed(2) + "%" : "N/A"; // Format to 2 decimal places
            //     }
            // },
            // {
            //     data: 'susut_rancung_to_parting',
            //     name: 'susut_rancung_to_parting',
            //     render: function (data, type, row) {
            //         return data !== null ? data.toFixed(2) + "%" : "N/A"; // Format to 2 decimal places
            //     }
            // },
            { data: null, name: 'branch_name' },
            {
                data: null, // No direct field from the server
                name: 'action',
                orderable: false, // Disable ordering for this column
                searchable: false, // Disable searching for this column
                render: function (data, type, row) {
                    let actionButtons = `
                        <div class="text-center">
                            <a href="/partings/edit/${row.id}" class="btn btn-sm btn-light btn-active-light-primary">Details</a>
                        </div>
                    `;
                    return actionButtons;
                }
            }
        ]
    });

    // Search input filter
    $('[data-kt-customer-table-filter="search"]').on('keyup', function () {
        table.draw(); // Trigger table redraw with updated search value
    });

    const sanitizeDate = (value) => (value === '' || value === '-' ? null : value);

    $('#start-date, #end-date').on('change', function () {
        const startDate = sanitizeDate($('#start-date').val());
        const endDate = sanitizeDate($('#end-date').val());
        table.draw();
    });

</script>
@endsection
