@extends('layouts.main')

@section('css')
<style>
    .dataTables_wrapper td.text-end {
        text-align: right !important;
    }
</style>
@endsection

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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">General Ledgers
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Finances</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">General Ledgers</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Secondary button-->
                    <a href="{{route('finances.journals.create')}}" class="btn btn-sm fw-bold btn-secondary">Exports</a>
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
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Row-->
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <!--begin::Table-->
                    <div class="card">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-6">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->

                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Filters-->
                                <div class="d-flex flex-stack flex-wrap gap-4">
                                    <div class="d-flex align-items-center fw-bold">
                                        <!--begin::Label-->
                                        <div class="text-gray-500 fs-7 me-2">Tanggal</div>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <input type="date"
                                            class="form-control form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto"
                                            id="start-date" /> -
                                        <input type="date"
                                            class="form-control form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto"
                                            id="end-date" />
                                        <!--end::Select-->
                                    </div>
                                    <!--begin::Status-->
                                    <div class="d-flex align-items-center fw-bold">
                                        <!--begin::Label-->
                                        <div class="text-gray-500 fs-7 me-auto">Account</div>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <select
                                            class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto"
                                            data-control="select2" data-hide-search="true"
                                            data-dropdown-css-class="w-150px" data-placeholder="Select an option"
                                            id="account-id">
                                            <option></option>
                                            <option value=" " selected="selected">Show All</option>
                                            @foreach($accounts as $acc)
                                            <option value="{{$acc->id}}">{{$acc->name}}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                    <!--end::Status-->
                                </div>
                                <!--begin::Filters-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 overflow-x-auto">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_journals_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">TANGGAL</th>
                                        <th class="min-w-125px">DESCRIPTION</th>
                                        <th class="min-w-125px">ACCOUNT</th>
                                        <th class="min-w-125px">DEBIT</th>
                                        <th class="min-w-125px">KREDIT</th>
                                        <th class="min-w-125px">BALANCE</th>
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
$(document).ready(function() {

    const table = $("#kt_journals_table").DataTable({
        processing: true,
        order: [
            [0, 'desc']
        ],
        serverSide: true,
        paging: true, // Enable pagination
        pageLength: 10, // Number of rows per page
        ajax: {
            url: `{{route('finances.general-ledgers.get-lists')}}`, // Replace with your route
            type: 'GET',
            data: function (d) {
                // Add filter data to the request
                d.start_date = $('#start-date').val();
                d.end_date = $('#end-date').val();
                d.account_id = $('#account-id').val();
            },
            dataSrc: function(json) {
                return json.data; // Map the 'data' field
            }
        },
        columns: [
            {
                data: 'date',
                name: 'date',
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: 'account_name',
                name: 'account_name'
            },
            {
                data: 'debit_formated',
                name: 'debit_formated',
                className: 'text-end'
            },
            {
                data: 'credit_formated',
                name: 'credit_formated',
                className: 'text-end'
            },
            {
                data: 'running_balance',
                name: 'running_balance',
                className: 'text-end'
            }
        ]
    });

    $('#start-date, #end-date, #account-id').on('change', function () {
        table.draw(); // Trigger DataTable redraw with updated filter values
    });
});

$(document).on('click', '#btn-post-to-journal', function(e) {
    e.preventDefault();

    if (true) {
        Swal.fire({
            title: 'Apakah anda yakin untuk memposting jurnal ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya, Posting Jurnal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Build the JSON payload
                const payload = {
                    header: {
                        start_period: $('#start-date').val(),
                        end_period: $('#end-date').val(),
                        account_id: $('#account-id').val(),
                    }
                };

                $.ajax({
                    url: `{{route('finances.journals.post-to-general-ledger')}}`,
                    type: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify(payload),
                    success: function(response) {
                        Swal.fire({
                            title: 'Suceess !',
                            text: `Jurnal berhasil di posting ke General Ledger`,
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        }).then((result) => {

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
</script>
@endsection
