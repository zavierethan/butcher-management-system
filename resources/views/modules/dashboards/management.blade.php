@extends('layouts.main')

@section('css')
<style>
.highcharts-data-table table {
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

.highcharts-description {
    margin: 0.3rem 10px;
}
</style>
@endsection

@section('main-content')
<!--begin::Main-->
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
                        Dashboards</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Dashboards</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Managements</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Secondary button-->
                    <div class="d-flex align-items-center fw-bold">
                        <!--begin::Label-->
                        <div class="text-gray-500 fs-7 me-2">Periode</div>
                        <!--end::Label-->
                        <!--begin::Select-->
                        <input type="date"
                            class="form-control form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto"
                            id="start-date" value="<?php echo date('Y-m-01'); ?>" /> -
                        <input type="date"
                            class="form-control form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto"
                            id="end-date" value="<?php echo date('Y-m-t'); ?>" />
                        <!--end::Select-->
                    </div>
                    <a href="#" class="btn btn-sm fw-bold btn-secondary" id="btn-form-export">Export ke Excel</a>
                    <!--end::Secondary button-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container">
                <!--begin::Row-->
                <!-- Stat Cards Row -->
                <div class="row gy-5 g-xl-10 mb-5">
                    <!-- Total Omzet Card -->
                    <div class="col-sm-6 col-md-3">
                        <div class="card bg-light-success">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="bg-success rounded-1 p-3"
                                        style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="ki-duotone ki-wallet fs-2 text-white">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-gray-700 fs-7 fw-semibold mb-2">TOTAL OMZET</span>
                                    <span class="fw-bold fs-2 text-gray-900" id="total-omzet">Rp.0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Uang Tunai Card -->
                    <div class="col-sm-6 col-md-3">
                        <div class="card bg-light-success">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="bg-success rounded-1 p-3"
                                        style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="ki-duotone ki-wallet fs-2 text-white">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-gray-700 fs-7 fw-semibold mb-2">TOTAL PRODUK TERJUAL</span>
                                    <span class="fw-bold fs-2 text-gray-900" id="total-cash">Rp.0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Uang di Kasir Card -->
                    <div class="col-sm-6 col-md-3">
                        <div class="card bg-light-success">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="bg-success rounded-1 p-3"
                                        style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="ki-duotone ki-wallet fs-2 text-white">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-gray-700 fs-7 fw-semibold mb-2">TOTAL PENGELUARAN</span>
                                    <span class="fw-bold fs-2 text-gray-900" id="total-expenses">Rp.0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Diskon Card -->
                    <div class="col-sm-6 col-md-3">
                        <div class="card bg-light-success">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="bg-success rounded-1 p-3"
                                        style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="ki-duotone ki-wallet fs-2 text-white">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-gray-700 fs-7 fw-semibold mb-2">TOTAL PIUTANG CUSTOMER</span>
                                    <span class="fw-bold fs-2 text-gray-900" id="total-discount">Rp.0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Stat Cards Row -->

                <div class="row g-5 g-xl-10 mb-xl-10">
                    <!--begin::Col-->
                    <div class="col-lg-6 col-xl-6 col-xxl-6 mb-5 mb-xl-0">
                        <!--begin::Chart widget 3-->
                        <div class="card card-flush overflow-hidden h-md-100">
                            <!--begin::Card body-->
                            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
                                <!--begin::Statistics-->
                                <figure class="highcharts-figure">
                                    <div id="container-1"></div>
                                </figure>
                                <!--end::Chart-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Chart widget 3-->
                    </div>
                    <div class="col-lg-6 col-xl-6 col-xxl-6 mb-5 mb-xl-0">
                        <!--begin::Chart widget 3-->
                        <div class="card card-flush overflow-hidden h-md-100">
                            <!--begin::Card body-->
                            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
                                <!--begin::Statistics-->
                                <figure class="highcharts-figure">
                                    <div id="container-2"></div>
                                </figure>
                                <!--end::Chart-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Chart widget 3-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Row Processing Order-->
                <div class="row mt-10">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Monitoring Session Store</h3>
                                <div class="d-flex align-items-center fw-bold gap-2">
                                    <div class="text-gray-500 fs-7">Periode</div>
                                    <input type="date"
                                        class="form-control form-control-sm form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto"
                                        id="session-start-date" value="<?php echo date('Y-m-d'); ?>" /> -
                                    <input type="date"
                                        class="form-control form-control-sm form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto"
                                        id="session-end-date" value="<?php echo date('Y-m-d'); ?>" />
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover align-middle table-row-dashed fs-6 gy-5"
                                    id="kt_sessions_table">
                                    <thead>
                                        <tr class="fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Store</th>
                                            <th class="min-w-125px">User</th>
                                            <th class="min-w-125px">Jam Buka</th>
                                            <th class="min-w-125px">Jam Tutup</th>
                                            <th class="min-w-125px">Opening Cash</th>
                                            <th class="min-w-125px">Closing Cash</th>
                                            <th class="min-w-125px">Actual Cash</th>
                                            <th class="min-w-125px text-center">Status</th>
                                            <th class="min-w-125px text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Row Processing Order-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>
<!--end:::Main-->

<!-- Edit Session Modal -->
<div class="modal fade" id="editSessionModal" tabindex="-1" aria-labelledby="editSessionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSessionModalLabel">Edit Session</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSessionForm">
                <div class="modal-body">
                    <input type="hidden" id="sessionId" name="session_id">

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Store</label>
                            <input type="text" class="form-control" id="sessionBranch" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">User</label>
                            <input type="text" class="form-control" id="sessionUser" readonly>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Jam Buka</label>
                            <input type="datetime-local" class="form-control" id="sessionOpenedAt" name="opened_at">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jam Tutup</label>
                            <input type="datetime-local" class="form-control" id="sessionClosedAt" name="closed_at">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Opening Cash</label>
                            <input type="number" class="form-control" id="sessionOpeningCash" name="opening_cash" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Closing Cash</label>
                            <input type="number" class="form-control" id="sessionClosingCash" name="closing_cash" step="0.01">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Expected Cash</label>
                            <input type="number" class="form-control" id="sessionExpectedCash" name="expected_cash" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-control" id="sessionStatus" name="status">
                                <option value="OPEN">OPEN</option>
                                <option value="CLOSE">CLOSE</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" id="sessionNotes" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
$(document).ready(function() {
    // AJAX untuk tabel Processing Order
    $('.loader').hide();

    $('[data-kt-customer-table-filter="search"]').on('keyup', function() {
        const searchTerm = $(this).val(); // Get the value from the search input
        sessionsTable.search(searchTerm).draw(); // Trigger the search and refresh the DataTable
    });

    const sessionsTable = $("#kt_sessions_table").DataTable({
        processing: true,
        serverSide: true,
        paging: true, // Enable pagination
        pageLength: 5, // Number of rows per page
        ajax: {
            url: `{{route('dashboards.session-monitoring')}}`, // Replace with your route
            type: 'GET',
            data: function(d) {
                // Add filter data to the request - use session filter dates if available, otherwise use main filters
                d.start_date = $('#session-start-date').val();
                d.end_date = $('#session-end-date').val();
            },
            dataSrc: function(json) {
                return json.data; // Map the 'data' field
            }
        },
        columns: [{
                data: 'branch_name',
                name: 'branch_name',
            },
            {
                data: 'username',
                name: 'username',
            },
            {
                data: 'opened_at',
                name: 'opened_at',
            },
            {
                data: 'closed_at',
                name: 'closed_at',
            },
            {
                data: 'opening_cash',
                name: 'opening_cash',
                className: 'text-end',
                render: function(data) {
                    return formatCurrency(data);
                }
            },
            {
                data: 'closing_cash',
                name: 'closing_cash',
                className: 'text-end',
                render: function(data) {
                    return formatCurrency(data);
                }
            },
            {
                data: 'expected_cash',
                name: 'expected_cash',
                className: 'text-end',
                render: function(data) {
                    return formatCurrency(data);
                }
            },
            {
                data: 'status',
                name: 'status',
                className: 'text-center',
                render: function(data, type, row) {
                    if (data === 'OPEN') {
                        return '<span class="badge badge-light-success">Open</span>';
                    } else if (data === 'CLOSE') {
                        return '<span class="badge badge-light-danger">Closed</span>';
                    } else {
                        return data; // Return the raw status if it doesn't match known values
                    }
                }
            },
            {
                data: null, // No direct field from the server
                name: 'action',
                orderable: false, // Disable ordering for this column
                searchable: false, // Disable searching for this column
                render: function(data, type, row) {
                    return `
                        <div class="text-center">
                            <button class="btn btn-sm btn-light btn-active-light-primary btn-edit-session" data-session-id="${row.id}" title="Edit"><i class="fa-solid fa-edit"></i>Edit</button>
                        </div>
                    `;
                }
            }
        ]
    });

    $('#session-start-date, #session-end-date').on('change', function() {
        sessionsTable.draw(); // Trigger DataTable redraw with updated filter values
    });

    // Handle edit session button click
    $(document).on('click', '.btn-edit-session', function(e) {
        e.preventDefault();
        const sessionId = $(this).data('session-id');

        // Fetch session data
        $.ajax({
            url: `/pos-session/${sessionId}`, // Get session by id endpoint
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const sessionData = response.data;

                    // Find the full row data from DataTable
                    const rowData = sessionsTable.row((idx, data) => data.id === sessionId).data();

                    // Populate modal
                    $('#sessionId').val(sessionId);
                    $('#sessionBranch').val(rowData.branch_name || '');
                    $('#sessionUser').val(rowData.username || '');
                    $('#sessionOpenedAt').val(formatDateTimeForInput(rowData.opened_at));
                    $('#sessionClosedAt').val(formatDateTimeForInput(rowData.closed_at));
                    $('#sessionOpeningCash').val(rowData.opening_cash || 0);
                    $('#sessionClosingCash').val(rowData.closing_cash || 0);
                    $('#sessionExpectedCash').val(rowData.expected_cash || 0);
                    $('#sessionStatus').val(rowData.status || 'OPEN');
                    $('#sessionNotes').val(rowData.notes || '');

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('editSessionModal'));
                    modal.show();
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching session data:", error);
                alert('Failed to load session data');
            }
        });
    });

    // Handle edit session form submit
    $('#editSessionForm').on('submit', function(e) {
        e.preventDefault();

        const sessionId = $('#sessionId').val();
        const formData = {
            session_id: sessionId,
            opened_at: $('#sessionOpenedAt').val(),
            closed_at: $('#sessionClosedAt').val(),
            opening_cash: $('#sessionOpeningCash').val(),
            closing_cash: $('#sessionClosingCash').val(),
            expected_cash: $('#sessionExpectedCash').val(),
            status: $('#sessionStatus').val(),
            notes: $('#sessionNotes').val()
        };

        $.ajax({
            url: `/pos-session/${sessionId}`,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json'
            },
            data: JSON.stringify(formData),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Session updated successfully');
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editSessionModal'));
                    modal.hide();
                    // Refresh table
                    sessionsTable.draw();
                } else {
                    alert('Failed to update session: ' + (response.message || 'Unknown error'));
                }
            },
            error: function(xhr, status, error) {
                console.error("Error updating session:", error);
                alert('Failed to update session');
            }
        });
    });

    // Helper function to format datetime for input field
    function formatDateTimeForInput(dateString) {
        if (!dateString) return '';

        // If it's already in the right format, return it
        if (dateString && dateString.includes('T')) {
            return dateString.split('.')[0]; // Remove milliseconds if present
        }

        // Parse and format
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return '';

        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');

        return `${year}-${month}-${day}T${hours}:${minutes}`;
    }

    // Helper function to format currency as Rupiah
    function formatCurrency(value) {
        if (!value || value === null || value === '') return 'Rp. 0';

        const numValue = parseFloat(value);
        if (isNaN(numValue)) return 'Rp. 0';

        return numValue.toLocaleString('US', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
    }

    $.ajax({
        url: '/dashboards/transaction-summary', // API Laravel
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            $('#total-transactions').text('Rp. ' + response.total_transactions);
            $('#total-omzet').text('Rp. ' + response.total_omzet);
        },
        error: function(xhr, status, error) {
            console.error("Error fetching data:", error);
        }
    });

    $.ajax({
        url: '/dashboards/sales-trend', // API Laravel
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            Highcharts.chart('container-1', {
                title: {
                    text: 'Tren Penjualan Store (Bulan Ini)'
                },
                subtitle: {
                    text: 'Data penjualan per minggu untuk bulan ini'
                },
                yAxis: {
                    title: {
                        text: 'Jumlah Penjualan'
                    }
                },
                xAxis: {
                    categories: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                    title: {
                        text: 'Minggu'
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },
                plotOptions: {
                    series: {
                        label: {
                            connectorAllowed: false
                        }
                    }
                },
                series: response, // Langsung pakai response dari API!
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }
            });
        },
        error: function(xhr, status, error) {
            console.error("Error fetching data:", error);
        }
    });


    $.ajax({
        url: '/dashboards/top-selling-products', // API Laravel
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            Highcharts.chart('container-2', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: '10 Produk Terlaris'
                },
                subtitle: {
                    text: 'Data penjualan berdasarkan jumlah produk terjual'
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Jumlah Produk Terjual'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y} Kg'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: ' +
                        '<b>{point.y}</b> unit terjual<br/>'
                },
                series: response // Data dari API langsung dipakai di Highcharts!
            });
        },
        error: function(xhr, status, error) {
            console.error("Error fetching data:", error);
        }
    });
});
</script>
@endsection
