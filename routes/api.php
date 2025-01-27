<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('products/', [App\Http\Controllers\ProductController::class, 'getListProducts']);

Route::get('customers/', [App\Http\Controllers\CustomerController::class, 'getListFiltered']);
Route::post('customers/save', [App\Http\Controllers\CustomerController::class, 'saveNewCustomerFromPOS']);

Route::get('get-purchase-request/', [App\Http\Controllers\Procurements\PurchaseRequestController::class, 'getPurchaseRequest']);
Route::get('get-purchase-request-items/', [App\Http\Controllers\Procurements\PurchaseRequestController::class, 'getPurchaseRequestItem'])->name('get-purchase-request-item');

Route::get('get-purchase-order-items/', [App\Http\Controllers\Procurements\PurchaseOrderController::class, 'getPurchaseOrderItem'])->name('get-purchase-order-item');

Route::get('inventories/', [App\Http\Controllers\InventoryController::class, 'getListInventories']);


// Dashboards Summary
Route::get('dashboard/store/get-data-summary/', [App\Http\Controllers\Dashboards\StoreDashboardController::class, 'getTransactionSummary']);
