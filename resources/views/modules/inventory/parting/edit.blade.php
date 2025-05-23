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
                        Parting</h1>
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
                            <form class="w-[60%]">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold fs-6 mb-2">Cabang</label>
                                            <input type="hidden" name="branch_id" value="{{ $partingHeader->branch_id }}">
                                            <div class="position-relative mb-3">
                                                <select class="form-select form-select-solid" data-control="select2"
                                                    data-placeholder="-" name="branch_id" id="branch_id" disabled>
                                                    <option value="">-</option>
                                                    @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}" 
                                                            {{ isset($partingHeader->branch_id) && $partingHeader->branch_id == $branch->id ? 'selected' : '' }}>
                                                            {{ $branch->id }} - {{ $branch->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Tanggal</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="date" name="parting_date" id="parting_date" value="{{ $partingHeader->date }}"
                                                        readonly />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Butcherees</label>
                                                <div class="position-relative mb-3">
                                                    <select class="form-select form-select-solid" data-control="select2"
                                                        data-placeholder="-" name="butcher_id" id="butcher_id">
                                                        <option value="">-</option>
                                                        @foreach($butcherees as $b)
                                                            <option value="{{ $b->id }}" 
                                                                {{ isset($partingHeader->butcher_id) && $partingHeader->butcher_id == $b->id ? 'selected' : '' }}>
                                                                {{ $b->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Total Ayam Hidup
                                                    (Ekor)</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="number" name="total_live_chickens"
                                                        id="total_live_chickens" readonly />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Total Ayam Hidup (Kg)</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="number"
                                                        name="total_live_chickens_weight"
                                                        id="total_live_chickens_weight"
                                                        value="{{ $partingHeader->total_live_chickens_weight ?? '' }}"
                                                        step="0.01"
                                                        min="0"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Total Hasil Potong Ayam
                                                    Fresh (Kg)</label>
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="number" name="total_weight_live_to_rancung"
                                                    id="total_weight_live_to_rancung" min="0" max="100" step="0.01"
                                                    readonly />
                                            </div>
                                            <div class="separator my-5"></div>
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Susut Ayam Hidup Ke Rancung
                                                    (%)</label>
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="number" name="total_weight_live_to_rancung_percentage"
                                                    id="total_weight_live_to_rancung_percentage" min="0" max="100"
                                                    step="0.01" readonly />
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                        <div class="fv-row mb-5">
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Total Hasil Parting Produk
                                                    (Kg)</label>
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="number" name="total_weight_rancung_to_parting"
                                                    id="total_weight_rancung_to_parting" min="0" max="100" step="0.01"
                                                    readonly />
                                            </div>
                                            <div class="separator my-5"></div>
                                            <div class="mb-1">
                                                <label class="form-label fw-bold fs-6 mb-2">Susut Rancung Ke Parting
                                                    (%)</label>
                                                <input class="form-control form-control-md form-control-solid"
                                                    type="number" name="total_weight_rancung_to_parting_percentage"
                                                    id="total_weight_rancung_to_parting_percentage" min="0" max="100"
                                                    step="0.01" readonly />
                                            </div>
                                        </div>
                                        <div class="separator my-5"></div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <a href="{{route('stocks.index')}}" class="btn btn-sm btn-danger">Kembali</a>
                                    <button type="button" class="btn btn-sm btn-primary"
                                        id="btn-submit-ar">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card body-->
                        <div class="card-body pt-10 overflow-x-auto">
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <div class="col-md-12 text-start fw-bold fs-4 text-uppercase gs-0">Hasil Potong Ayam
                                        Fresh</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12 text-end"><a class="btn btn-sm btn-primary" id="add-row"><i
                                                class="fa-solid fa-plus"></i>Tambah Hasil Potong</a></div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_items_table">
                                    <thead>
                                        <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-70px">Jumlah Ekor</th>
                                            <th class="min-w-70px">Berat</th>
                                            <th class="min-w-70px">Berat Wadah</th>
                                            <th class="min-w-70px">Berat Bersih</th>
                                            <th class="min-w-70px text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>

                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card body-->
                        <div class="card-body pt-10 overflow-x-auto">
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <div class="col-md-12 text-start fw-bold fs-4 text-uppercase gs-0">Hasil Parting Produk</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12 text-end">
                                        <a class="btn btn-sm btn-primary" id="add-row-weight">
                                            <i class="fa-solid fa-plus"></i>Tambah Baris
                                        </a>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="col-md-12 text-end">
                                        <a class="btn btn-sm btn-primary" id="cek-submit">
                                            <i class="fa-solid fa-plus"></i>Cek submit
                                        </a>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_products_table">
                                    <thead>
                                        <tr id="table-head-row" class="text-start fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-50px text-center">#</th>
                                            <!-- Headers will be dynamically inserted here -->
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
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
// script kebutuhan table fresh cut
$(document).on("click", "#add-row", function(e) {
    e.preventDefault();
    var row = `<tr>
                <td>
                    <input class="form-control form-control-sm me-2 total-chickens" type="number"
                        name="total_chickens" step="1" min="0"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                </td>
                <td>
                    <input class="form-control form-control-sm me-2 weight" type="number"
                        name="weight" step="0.01" min="0"/>
                </td>
                <td>
                    <input class="form-control form-control-sm me-2 container-weight" type="number"
                        name="container_weight" step="0.01" min="0" value="0"/>
                </td>
                <td>
                    <input class="form-control form-control-sm me-2 net_weight" type="number"
                        name="net_weight" step="0.01" min="0" readonly/>
                </td>
                <td class="text-center">
                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary delete"><i class="fa-solid fa-trash-can"></i></a>
                </td>
            </tr>`;

    $("#kt_items_table tbody").append(row);
    updateTotalLiveChickens();
    updateTotalWeightLiveToRancung();
});

// Automatically calculate net_weight
$(document).on("input", ".weight, .container-weight, #total_live_chickens_weight", function() {
    var row = $(this).closest("tr");
    var weight = parseFloat(row.find(".weight").val()) || 0;
    var containerWeight = parseFloat(row.find(".container-weight").val()) || 0;
    var netWeight = (weight - containerWeight).toFixed(2);

    row.find(".net_weight").val(netWeight);
    updateTotalWeightLiveToRancung();
});

// Function to update total_live_chickens field
function updateTotalLiveChickens() {
    var total = 0;
    $(".total-chickens").each(function() {
        total += parseInt($(this).val()) || 0;
    });
    $("#total_live_chickens").val(total);
}

// Function to update total_weight_live_to_rancung (now sum of all net_weight)
function updateTotalWeightLiveToRancung() {
    var totalNetWeight = 0;
    $(".net_weight").each(function() {
        totalNetWeight += parseFloat($(this).val()) || 0;
    });

    $("#total_weight_live_to_rancung").val(totalNetWeight.toFixed(2));
    updatePercentageRancung();
    updateRancungToPartingPercentage();
}

// Update total_live_chickens when total_chickens input changes
$(document).on("input", ".total-chickens", function() {
    updateTotalLiveChickens();
});

// Update total_weight_live_to_rancung when weight or container_weight changes
$(document).on("input", ".weight, .container-weight", function() {
    updateTotalWeightLiveToRancung();
});

// Update total_weight_live_to_rancung when a row is deleted
$(document).on("click", ".delete", function(e) {
    e.preventDefault();
    $(this).closest("tr").remove();
    updateTotalLiveChickens();
    updateTotalWeightLiveToRancung();
});

// Function to update total_weight_live_to_rancung_percentage
function updatePercentageRancung() {
    var totalLiveWeight = parseFloat($("#total_live_chickens_weight").val()) || 0;
    var totalNetWeight = parseFloat($("#total_weight_live_to_rancung").val()) || 0;

    var percentage = totalLiveWeight > 0 ? (((totalLiveWeight - totalNetWeight) / totalLiveWeight) * 100).toFixed(2) : 0;
    $("#total_weight_live_to_rancung_percentage").val(percentage);
}

// fresh cut end here

function updateTotalWeightRancungToParting() {
    let total = 0;
    $(".quantity").each(function() {
        let value = parseFloat($(this).val()) || 0;
        total += value;
    });
    $("#total_weight_rancung_to_parting").val(total.toFixed(2));
    updateRancungToPartingPercentage();
}


function updateRancungToPartingPercentage() {
    let totalRancungToParting = parseFloat($("#total_weight_rancung_to_parting").val()) || 0;
    let totalLiveToRancung = parseFloat($("#total_weight_live_to_rancung").val()) || 0;

    let percentage = totalLiveToRancung > 0
        ? ((totalLiveToRancung - totalRancungToParting) / totalLiveToRancung) * 100 
        : 0;
    
    $("#total_weight_rancung_to_parting_percentage").val(percentage.toFixed(2));
}


// parting end here


// header script
document.addEventListener("DOMContentLoaded", function() {
    var partingHeader = @json($partingHeader);
    console.log("Parting Header:", partingHeader);

    var rancungHeader = @json($rancungHeader);
    console.log("Rancung Header:", rancungHeader);

    var partingCutResultsHeader = @json($partingCutResultsHeader);
    console.log("partingCutResultsHeader:", partingCutResultsHeader);
    
    fetchProducts(partingCutResultsHeader);

    let tableBody = document.querySelector("#kt_items_table tbody");

    // Function to create row with existing data
    function createRow(data = {}) {
        let row = document.createElement("tr");
        row.innerHTML = `
            <td>
                <input class="form-control form-control-sm me-2 total-chickens" type="number"
                    name="total_chickens[]" step="1" min="0"
                    value="${data.total_chickens || ''}"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
            </td>
            <td>
                <input class="form-control form-control-sm me-2 weight" type="number"
                    name="weight[]" step="0.01" min="0"
                    value="${data.weight || ''}"/>
            </td>
            <td>
                <input class="form-control form-control-sm me-2 container-weight" type="number"
                    name="container_weight[]" step="0.01" min="0"
                    value="${data.container_weight || 0}"/>
            </td>
            <td>
                <input class="form-control form-control-sm me-2 net_weight" type="number"
                    name="net_weight[]" step="0.01" min="0"
                    value="${data.net_weight || ''}" readonly/>
            </td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-light btn-active-light-primary delete"><i class="fa-solid fa-trash-can"></i></a>
            </td>
        `;
        tableBody.appendChild(row);
    }

    // Populate table with existing data from rancungHeader
    if (rancungHeader.length > 0) {
        rancungHeader.forEach(item => createRow(item));
    } else {
        createRow(); // If no data, add an empty row
    }

    updateTotalWeightLiveToRancung();
    updateTotalLiveChickens();
});

document.addEventListener("DOMContentLoaded", function() {
    let inputFields = [
        document.getElementById("total_weight_live_to_rancung"),
        document.getElementById("total_weight_rancung_to_parting")
    ];

    inputFields.forEach(function(inputField) {
        if (inputField) { // Ensure the input field exists before adding the event listener
            inputField.addEventListener("input", function() {
                let value = parseFloat(inputField.value);

                if (value < 0) {
                    inputField.value = 0;
                } else if (value > 100) {
                    inputField.value = 100;
                }
            });
        }
    });

        // Log the partingCutResultsHeader to the console
    if (typeof partingCutResultsHeader !== 'undefined') {
        console.log("Parting Cut Result Header:", partingCutResultsHeader);
    } else {
        console.warn("partingCutResultsHeader is not defined.");
    }
});

// header script end here

// submit script start
$(document).ready(function() {
    $("#btn-submit-ar").click(function(e) {
        e.preventDefault(); // Prevent default button behavior

        // SweetAlert confirmation
        Swal.fire({
            title: "Are you sure?",
            text: "You are about to submit the data.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, submit it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Prepare payload
                let branchId = $("#branch_id").val();
                let partingDate = $("#parting_date").val();
                let butcherId = $("#butcher_id").val();
                let totalLiveChickens = $("#total_live_chickens").val();
                let totalLiveChickensWeight = $("#total_live_chickens_weight").val();
                let totalWeightLiveToRancung = $("#total_weight_live_to_rancung").val();
                let totalWeightRancungToParting = $("#total_weight_rancung_to_parting").val();

                // fresh cut data
                let rancungData = [];
                $("#kt_items_table tbody tr").each(function() {
                    let totalChickens = $(this).find(".total-chickens").val();
                    let weight = $(this).find(".weight").val();
                    let containerWeight = $(this).find(".container-weight").val();
                    let netWeight = $(this).find(".net_weight").val();

                    rancungData.push({
                        total_chickens: totalChickens,
                        weight: weight,
                        container_weight: containerWeight,
                        net_weight: netWeight
                    });
                });

                let partingData = [];
                $("#kt_products_table tbody tr").each(function() {
                    let row = $(this);

                    $("#kt_products_table thead th[data-id]").each(function() {
                        let productId = $(this).data("id");
                        let weight = parseFloat(row.find(`td[data-id='${productId}'] input`).val()) || 0;

                        if (weight > 0) {
                            partingData.push({
                                product_id: productId,
                                quantity: weight
                            });
                        }
                    });
                });

                let partingHeader = @json($partingHeader);
                let partingId = partingHeader.id;

                // Final Payload
                let formData = {
                    parting_id: partingId,
                    branch_id: branchId,
                    parting_date: partingDate,
                    butcher_id: butcherId,
                    total_live_chickens: totalLiveChickens,
                    total_live_chickens_weight: totalLiveChickensWeight,
                    total_weight_live_to_rancung: totalWeightLiveToRancung,
                    total_weight_rancung_to_parting: totalWeightRancungToParting,
                    rancung_data: rancungData,
                    parting_data: partingData,
                };

                console.log("Submitting Data:", formData);

                // AJAX request
                $.ajax({
                    url: "/partings/update",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify(formData),
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Success!",
                            text: "Data submitted successfully.",
                            icon: "success"
                        }).then(() => {
                            location.reload(); 
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: "Error!",
                            text: "There was an issue submitting the data.",
                            icon: "error"
                        });
                        console.error("AJAX Error:", xhr.responseText);
                    }
                });
            }
        });
    });
});

// submit script end

function fetchProducts(partingCutResultsHeader) {
    $.ajax({
        url: "/api/allProductsInParting", // Replace with your API URL
        method: "GET",
        dataType: "json",
        success: function (response) {
            console.log("API Response:", response); // Debugging: Check the actual API response

            let headerRow = $("#table-head-row");
            let tableBody = $("#kt_products_table tbody");

            // Preserve the first column (row numbering)
            headerRow.html(`<th class="min-w-50px text-center">#</th>`);

            // Ensure response contains 'data' array
            if (!response.data || response.data.length === 0) {
                console.warn("No products found in response!");
                return;
            }

            // Append dynamic product columns
            let productIds = [];
            response.data.forEach(function (product) {
                if (!product.id || !product.name) {
                    console.warn("Missing product data:", product);
                    return;
                }
                productIds.push(product.id);
                headerRow.append(`<th class="min-w-150px text-center" data-id="${product.id}">${product.name}</th>`);
            });

            console.log("Headers added successfully!");

            // **Fill existing rows first before creating new ones**
            tableBody.html(""); // Clear existing rows
            let rows = [];

            partingCutResultsHeader.forEach((item) => {
                let placed = false;

                // Try to place the item in an existing row first
                for (let row of rows) {
                    if (!row[item.product_id]) {
                        row[item.product_id] = item.quantity;
                        placed = true;
                        break;
                    }
                }

                // If no available row, create a new one
                if (!placed) {
                    let newRow = {};
                    newRow[item.product_id] = item.quantity;
                    rows.push(newRow);
                }
            });

            // Render rows into the table
            rows.forEach((rowData, rowIndex) => {
                let row = `<tr><td class="text-center">${rowIndex + 1}</td>`; // Row number

                productIds.forEach((productId) => {
                    let quantity = rowData[productId] || "";
                    row += `<td data-id="${productId}">
                                <input type="text" class="form-control weight-input text-center" 
                                       placeholder="Enter weight" value="${quantity}">
                            </td>`;
                });

                row += `</tr>`;
                tableBody.append(row);
            });

            updateTotalWeightRancungToParting();
        },
        error: function (xhr, status, error) {
            console.error("Error fetching products:", error);
        }
    });
}

$(document).on("click", "#add-row-weight", function(e) {
    e.preventDefault();

    var rowCount = $("#kt_products_table tbody tr").length + 1; // Get the next row number

    var row = `<tr>
                    <td class="text-center">${rowCount}</td>`; // Numbering column

    // Loop through all headers (excluding the first `#` column) and add empty cells
    $("#table-head-row th:not(:first)").each(function() {
        var productId = $(this).data("id"); // Get product ID from <th> data-id
        row += `<td data-id="${productId}">
                    <input type="text" class="form-control weight-input" placeholder="Enter weight">
                </td>`;
    });

    row += `</tr>`;

    $("#kt_products_table tbody").append(row);
});


$("#kt_products_table tbody").on("input", "td input", function() {
    updateTotalWeightRancungToParting();
});

function updateTotalWeightRancungToParting() {
    let totalWeight = 0;

    // Loop through all product columns in the table body and sum up the values
    $("#kt_products_table tbody tr").each(function() {
        $(this).find("td input").each(function() {
            let weight = parseFloat($(this).val()) || 0;
            totalWeight += weight;
        });
    });

    // Set the total weight
    $("#total_weight_rancung_to_parting").val(totalWeight.toFixed(2));

    // Invoke the existing function
    updateRancungToPartingPercentage();
}

</script>
@endsection
