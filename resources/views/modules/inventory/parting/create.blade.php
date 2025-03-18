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
                        <li class="breadcrumb-item text-muted">Create</li>
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
                                                <div class="position-relative mb-3">
                                                    <select class="form-select form-select-solid" data-control="select2"
                                                        data-placeholder="-" name="branch_id" id="branch_id">
                                                        <option value="">-</option>
                                                        @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}">{{ $branch->id }} -
                                                            {{ $branch->name }}</option>
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
                                                        type="date" name="parting_date" id="parting_date" value=""
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
                                                        <option value="{{ $b->id }}">
                                                            {{ $b->name }}</option>
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
                                                <label class="form-label fw-bold fs-6 mb-2">Total Ayam Hidup
                                                    (Kg)</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-md form-control-solid"
                                                        type="number" name="total_live_chickens_weight"
                                                        id="total_live_chickens_weight" />
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

// parting script
// $(document).on("click", "#add-row-parting", function(e) {
//     e.preventDefault();

//     var productOptions = `@foreach($products as $product)
//                             <option value="{{ $product->id }}" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}">{{ $product->name }}</option>
//                           @endforeach`;

//     var row = `<tr data-product-id="">
//                     <td>
//                         <select class="form-select form-select-sm product-select">
//                             <option value="">Pilih Produk</option>
//                             ${productOptions}
//                         </select>
//                     </td>
//                     <td>
//                         <input class="form-control form-control-sm me-2 quantity" type="number"
//                             name="quantity" step="0.01" min="0"/>
//                     </td>
//                     <td class="text-center">
//                         <a href="#" class="btn btn-sm btn-light btn-active-light-primary delete-parting-row">
//                             <i class="fa-solid fa-trash-can"></i>
//                         </a>
//                     </td>
//                 </tr>`;

//     var $row = $(row);

//     $("#kt_parting_table tbody").append($row);
// });

// Parting script - Assign product ID when selecting a product
// $(document).on("change", ".product-select", function() {
//     var selectedOption = $(this).find("option:selected");
//     var productId = selectedOption.data("product-id");
//     console.log(selectedOption);
//     console.log(productId);
    
    
//     // Assign the data-product-id to the row
//     $(this).closest("tr").attr("data-product-id", productId);
// });



function updateTotalWeightRancungToParting() {
    let total = 0;
    $(".quantity").each(function() {
        let value = parseFloat($(this).val()) || 0;
        total += value;
    });
    $("#total_weight_rancung_to_parting").val(total.toFixed(2));
    updateRancungToPartingPercentage();
}

// Trigger update when quantity inputs change
// $(document).on("input", ".quantity", function() {
//     updateTotalWeightRancungToParting();
// });

// Ensure the total is recalculated if new rows are added dynamically
// $(document).on("DOMNodeInserted", "#kt_parting_table tbody", function() {
//     updateTotalWeightRancungToParting();
// });

function updateRancungToPartingPercentage() {
    let totalRancungToParting = parseFloat($("#total_weight_rancung_to_parting").val()) || 0;
    let totalLiveToRancung = parseFloat($("#total_weight_live_to_rancung").val()) || 0;

    let percentage = totalLiveToRancung > 0
        ? ((totalLiveToRancung - totalRancungToParting) / totalLiveToRancung) * 100 
        : 0;
    
    $("#total_weight_rancung_to_parting_percentage").val(percentage.toFixed(2));
}


// Update total_weight_live_to_rancung when a row is deleted
// $(document).on("click", ".delete-parting-row", function(e) {
//     e.preventDefault();
//     $(this).closest("tr").remove();
//     updateTotalWeightRancungToParting();
// });

// parting end here


// header script
document.addEventListener("DOMContentLoaded", function() {
    let now = new Date();

    // Convert to Jakarta timezone and extract the date components
    let options = {
        timeZone: "Asia/Jakarta",
        year: "numeric",
        month: "2-digit",
        day: "2-digit"
    };
    let jakartaDate = new Intl.DateTimeFormat("en-CA", options).format(
    now); // 'en-CA' ensures YYYY-MM-DD format

    // Set the value in the input field
    document.getElementById("parting_date").value = jakartaDate;
    fetchProducts();
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
});

// header script end here

// submit script start
// $(document).ready(function() {
//     $("#btn-submit-ar").click(function(e) {
//         e.preventDefault(); // Prevent default button behavior

//         // SweetAlert confirmation
//         Swal.fire({
//             title: "Are you sure?",
//             text: "You are about to submit the data.",
//             icon: "warning",
//             showCancelButton: true,
//             confirmButtonColor: "#3085d6",
//             cancelButtonColor: "#d33",
//             confirmButtonText: "Yes, submit it!"
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 // Prepare payload
//                 // header data
//                 let branchId = $("#branch_id").val();
//                 let partingDate = $("#parting_date").val();
//                 let butcherId = $("#butcher_id").val();
//                 let totalLiveChickens = $("#total_live_chickens").val();
//                 let totalLiveChickensWeight = $("#total_live_chickens_weight").val();
//                 let totalWeightLiveToRancung = $("#total_weight_live_to_rancung").val();
//                 let totalWeightRancungToParting = $("#total_weight_rancung_to_parting").val();

//                 // fresh cut data
//                 let rancungData = [];
//                 $("#kt_items_table tbody tr").each(function() {
//                     let totalChickens = $(this).find(".total-chickens").val();
//                     let weight = $(this).find(".weight").val();
//                     let containerWeight = $(this).find(".container-weight").val();
//                     let netWeight = $(this).find(".net_weight").val();

//                     // Push as an object into the array
//                     rancungData.push({
//                         total_chickens: totalChickens,
//                         weight: weight,
//                         container_weight: containerWeight,
//                         net_weight: netWeight
//                     });
//                 });

//                 // parting data
//                 let partingData = [];
//                 $("#kt_parting_table tbody tr").each(function() {
//                     let productId = $(this).find(".product-select").val();
//                     let quantity = $(this).find(".quantity").val();

//                     // Ensure the productId is not empty
//                     if (productId && quantity && quantity !== "0") {
//                         partingData.push({
//                             product_id: productId,
//                             quantity: quantity
//                         });
//                     }
//                 });

//                 // Add your payload data here
//                 let formData = {
//                     branch_id: branchId,
//                     parting_date: partingDate,
//                     butcher_id: butcherId,
//                     total_live_chickens: totalLiveChickens,
//                     total_live_chickens_weight: totalLiveChickensWeight,
//                     total_weight_live_to_rancung: totalWeightLiveToRancung,
//                     total_weight_rancung_to_parting: totalWeightRancungToParting,
//                     rancung_data: rancungData,
//                     parting_data: partingData,
//                 };

//                 // Console log instead of AJAX for testing
//                 console.log("Submitting Data:", formData);

//                 // AJAX request
//                 $.ajax({
//                     url: "/stock-logs/parting/save", // Update with your actual API endpoint
//                     type: "POST",
//                     contentType: "application/json",
//                     data: JSON.stringify(formData),
//                     headers: {
//                         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
//                     },
//                     success: function(response) {
//                         Swal.fire({
//                             title: "Success!",
//                             text: "Data submitted successfully.",
//                             icon: "success"
//                         }).then(() => {
//                             location.reload(); // Reload after success
//                         });
//                     },
//                     error: function(xhr, status, error) {
//                         Swal.fire({
//                             title: "Error!",
//                             text: "There was an issue submitting the data.",
//                             icon: "error"
//                         });
//                         console.error("AJAX Error:", xhr.responseText);
//                     }
//                 });
//             }
//         });
//     });
// });

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

                // Parting Data dari product
                let partingData = [];
                $("#kt_products_table thead th[data-id]").each(function() {
                    let productId = $(this).data("id");
                    let sumWeight = 0;

                    $("#kt_products_table tbody tr").each(function() {
                        let weight = parseFloat($(this).find(`td[data-id='${productId}'] input`).val()) || 0;
                        sumWeight += weight;
                    });

                    if (sumWeight > 0) {
                        partingData.push({ product_id: productId, quantity: sumWeight });
                    }
                });

                // Final Payload
                let formData = {
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
                    url: "/partings/save",
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

function fetchProducts() {
    $.ajax({
        url: "/api/allProductsInAllBranches", // Replace with your API URL
        method: "GET",
        dataType: "json",
        success: function (response) {
            console.log("API Response:", response); // Debugging: Check the actual API response

            let headerRow = $("#table-head-row");

            // Preserve the first column (row numbering)
            headerRow.html(`<th class="min-w-50px text-center">#</th>`);

            // Ensure response contains 'data' array
            if (!response.data || response.data.length === 0) {
                console.warn("No products found in response!");
                return;
            }

            // Append dynamic product columns
            response.data.forEach(function (product) {
                if (!product.id || !product.name) {
                    console.warn("Missing product data:", product);
                    return;
                }
                headerRow.append(`<th class="min-w-150px" data-id="${product.id}">${product.name}</th>`);
            });

            console.log("Headers added successfully!");
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

// $(document).on("click", "#cek-submit", function (e) {
//     e.preventDefault();

//     let productSums = {}; // Store sum of weights for each product

//     // Get product IDs from table headers
//     $("#table-head-row th:not(:first)").each(function () {
//         let productId = $(this).attr("data-id"); // Get product ID
//         if (productId) {
//             productSums[productId] = 0; // Initialize sum
//         }
//     });

//     // Loop through each row and sum the weights for each product
//     $("#kt_products_table tbody tr").each(function () {
//         $(this).find("td:not(:first)").each(function () {
//             let productId = $(this).attr("data-id"); // Get product ID
//             let inputValue = parseFloat($(this).find("input").val()) || 0; // Get input value

//             if (productId && inputValue > 0) {
//                 productSums[productId] += inputValue; // Sum the weight
//             }
//         });
//     });

//     // Convert to an array of objects, removing products with sum_weight = 0
//     let payload = Object.keys(productSums)
//         .filter(productId => productSums[productId] > 0)
//         .map(productId => ({
//             product_id: parseInt(productId),
//             sum_weight: productSums[productId]
//         }));

//     console.log("Payload to send:", payload); // Debugging: Check output in console
// });

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
