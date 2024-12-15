<?php

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


Route::get('/products', function () {
    $path = storage_path('app/products.json'); // Adjust the path if stored elsewhere

    $products = DB::table('products')->get();
    file_put_contents($path, $products->toJson());

    if (file_exists($path)) {
        return response()->json(json_decode(file_get_contents($path)));
    } else {
        return response()->json(['error' => 'Products not found'], 404);
    }
});

Route::get('/customers', function () {
    $path = storage_path('app/customers.json');

    $customers = DB::table('customers')->get();
    file_put_contents($path, $customers->toJson());

    if (file_exists($path)) {
        return response()->json(json_decode(file_get_contents($path)));
    } else {
        return response()->json(['error' => 'Customers not found'], 404);
    }
});
