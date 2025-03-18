@extends('layouts.main')

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
                            <a href="index.html" class="text-muted text-hover-primary">Ritels</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Daily Reports</li>
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
                        <div class="text-gray-500 fs-7 me-2">Tanggal</div>
                        <!--end::Label-->
                        <!--begin::Select-->
                        <input type="date"
                            class="form-control form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto"
                            id="start-date" value="<?php echo date("Y-m-d"); ?>" /> -
                        <input type="date"
                            class="form-control form-control-solid text-graY-800 fs-base lh-1 fw-bold py-0 ps-3 w-auto"
                            id="end-date" value="<?php echo date("Y-m-d"); ?>" />
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
                <div class="row gy-5 g-xl-10">
                    <!--begin::Col-->
                    <div class="col-sm-6 col-xl-2 mb-5 mb-xl-10">
                        <!--begin::Card widget 2-->
                        <div class="card h-lg-100">
                            <!--begin::Body-->
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <!--begin::Icon-->
                                <div class="m-0">
                                    <i class="ki-duotone ki-chart-simple fs-2hx text-gray-600">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </div>
                                <!--end::Icon-->
                                <div class="d-flex flex-column my-7">
                                    <!--begin::Number-->
                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="total-transactions">0</span>
                                    <!--end::Number-->
                                </div>
                                <!--begin::Badge-->
                                <span class="badge badge-light-success fs-base">Total Transaksi</span>
                                <!--end::Badge-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 2-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-sm-6 col-xl-2 mb-xl-10">
                        <!--begin::Card widget 2-->
                        <div class="card h-lg-100">
                            <!--begin::Body-->
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <!--begin::Icon-->
                                <div class="m-0">
                                    <i class="ki-duotone ki-chart-simple fs-2hx text-gray-600">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex flex-column my-7">
                                    <!--begin::Number-->
                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="total-revenue">0</span>
                                    <!--end::Number-->
                                </div>
                                <!--end::Section-->
                                <!--begin::Badge-->
                                <span class="badge badge-light-success fs-base">Total Omset</span>
                                <!--end::Badge-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 2-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-sm-6 col-xl-2 mb-xl-10">
                        <!--begin::Card widget 2-->
                        <div class="card h-lg-100">
                            <!--begin::Body-->
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <!--begin::Icon-->
                                <div class="m-0">
                                    <i class="ki-duotone ki-chart-simple fs-2hx text-gray-600">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex flex-column my-7">
                                    <!--begin::Number-->
                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="total-cash">0</span>
                                    <!--end::Number-->
                                </div>
                                <!--end::Section-->
                                <!--begin::Badge-->
                                <div class="m-0">
                                    <span class="badge badge-light-success fs-base">Total Laba Kotor</span>
                                </div>
                                <!--end::Badge-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 2-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-sm-6 col-xl-2 mb-xl-10">
                        <!--begin::Card widget 2-->
                        <div class="card h-lg-100">
                            <!--begin::Body-->
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <!--begin::Icon-->
                                <div class="m-0">
                                    <i class="ki-duotone ki-chart-simple fs-2hx text-gray-600">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex flex-column my-7">
                                    <!--begin::Number-->
                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="total-receivable">0</span>
                                    <!--end::Number-->
                                </div>
                                <!--end::Section-->
                                <!--begin::Badge-->
                                <div class="m-0">
                                    <span class="badge badge-light-success fs-base">Total Laba Bersih</span>
                                </div>
                                <!--end::Badge-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 2-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-sm-6 col-xl-2 mb-xl-10">
                        <!--begin::Card widget 2-->
                        <div class="card h-lg-100">
                            <!--begin::Body-->
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <!--begin::Icon-->
                                <div class="m-0">
                                    <i class="ki-duotone ki-chart-simple fs-2hx text-gray-600">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex flex-column my-7">
                                    <!--begin::Number-->
                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="total-transfer">0</span>
                                    <!--end::Number-->
                                </div>
                                <!--end::Section-->
                                <div class="m-0">
                                    <span class="badge badge-light-success fs-base">Pengeluaran Operasional</span>
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 2-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-sm-6 col-xl-2 mb-5 mb-xl-10">
                        <!--begin::Card widget 2-->
                        <div class="card h-lg-100">
                            <!--begin::Body-->
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <!--begin::Icon-->
                                <div class="m-0">
                                    <i class="ki-duotone ki-chart-simple fs-2hx text-gray-600">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Section-->
                                <div class="d-flex flex-column my-7">
                                    <!--begin::Number-->
                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2"
                                        id="total-expenses">0</span>
                                    <!--end::Number-->
                                </div>
                                <!--end::Section-->
                                <!--begin::Badge-->
                                <span class="badge badge-light-success fs-base">Pengeluaran Operasional</span>
                                <!--end::Badge-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 2-->
                    </div>
                    <!--end::Col-->
                </div>
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
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>
<!--end:::Main-->
@endsection

@section('script')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
$(document).ready(function() {
    Highcharts.chart('container-1', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Corn vs wheat estimated production for 2023'
    },
    subtitle: {
        text:
            'Source: <a target="_blank" ' +
            'href="https://www.indexmundi.com/agriculture/?commodity=corn">indexmundi</a>'
    },
    xAxis: {
        categories: ['USA', 'China', 'Brazil', 'EU', 'Argentina', 'India'],
        crosshair: true,
        accessibility: {
            description: 'Countries'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: '1000 metric tons (MT)'
        }
    },
    tooltip: {
        valueSuffix: ' (1000 MT)'
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
        {
            name: 'Corn',
            data: [387749, 280000, 129000, 64300, 54000, 34300]
        },
        {
            name: 'Wheat',
            data: [45321, 140000, 10000, 140500, 19500, 113500]
        }
    ]
});

Highcharts.chart('container-2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Corn vs wheat estimated production for 2023'
    },
    subtitle: {
        text:
            'Source: <a target="_blank" ' +
            'href="https://www.indexmundi.com/agriculture/?commodity=corn">indexmundi</a>'
    },
    xAxis: {
        categories: ['USA', 'China', 'Brazil', 'EU', 'Argentina', 'India'],
        crosshair: true,
        accessibility: {
            description: 'Countries'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: '1000 metric tons (MT)'
        }
    },
    tooltip: {
        valueSuffix: ' (1000 MT)'
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
        {
            name: 'Corn',
            data: [387749, 280000, 129000, 64300, 54000, 34300]
        },
        {
            name: 'Wheat',
            data: [45321, 140000, 10000, 140500, 19500, 113500]
        }
    ]
});
});

</script>
@endsection
