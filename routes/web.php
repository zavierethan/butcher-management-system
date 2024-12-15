<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');
// Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('register');

Route::group(['middleware' => ['auth']], function() {
    Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Account
    Route::prefix('users')->group(function () {
        Route::name('users.')->group(function () {
            Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('index');
            Route::get('/lists', [App\Http\Controllers\UserController::class, 'getLists'])->name('get-lists');
            Route::get('/create', [App\Http\Controllers\UserController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\UserController::class, 'save'])->name('save');
            Route::get('/edit/{userId}', [App\Http\Controllers\UserController::class, 'edit'])->name('edit');
            Route::post('/update', [App\Http\Controllers\UserController::class, 'update'])->name('update');

            Route::get('/change-password/{userId}', [App\Http\Controllers\UserController::class, 'changePassword'])->name('change-password');
            Route::post('/update-password', [App\Http\Controllers\UserController::class, 'updatePassword'])->name('update-password');
        });
    });

    Route::prefix('groups')->group(function () {
        Route::name('groups.')->group(function () {
            Route::get('/', [App\Http\Controllers\GroupController::class, 'index'])->name('index');
            Route::get('/lists', [App\Http\Controllers\GroupController::class, 'getLists'])->name('get-lists');
            Route::get('/create', [App\Http\Controllers\GroupController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\GroupController::class, 'save'])->name('save');
            Route::get('/edit/{groupId}', [App\Http\Controllers\GroupController::class, 'edit'])->name('edit');
            Route::get('/menu-access/{groupId}', [App\Http\Controllers\GroupController::class, 'menuAccess'])->name('menu-access');
            Route::post('/update', [App\Http\Controllers\GroupController::class, 'update'])->name('update');
            Route::post('/update-menu-access', [App\Http\Controllers\GroupController::class, 'updateMenuAccess'])->name('update-menu-access');
        });
    });

    Route::prefix('menus')->group(function () {
        Route::name('menus.')->group(function () {
            Route::get('/', [App\Http\Controllers\MenuController::class, 'index'])->name('index');
            Route::get('/lists', [App\Http\Controllers\MenuController::class, 'getLists'])->name('get-lists');
            Route::get('/create', [App\Http\Controllers\MenuController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\MenuController::class, 'save'])->name('save');
            Route::get('/edit/{menuId}', [App\Http\Controllers\MenuController::class, 'edit'])->name('edit');
            Route::post('/update', [App\Http\Controllers\MenuController::class, 'update'])->name('update');
        });
    });

    //Master Data
    Route::prefix('products')->group(function () {
        Route::name('products.')->group(function () {
            Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('index');
            Route::get('/lists', [App\Http\Controllers\ProductController::class, 'getLists'])->name('get-lists');
            Route::get('/create', [App\Http\Controllers\ProductController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\ProductController::class, 'save'])->name('save');
            Route::get('/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('edit');
            Route::post('/update', [App\Http\Controllers\ProductController::class, 'update'])->name('update');
        });
    });

    Route::prefix('branches')->group(function () {
        Route::name('branches.')->group(function () {
            Route::get('/', [App\Http\Controllers\BranchController::class, 'index'])->name('index');
            Route::get('/lists', [App\Http\Controllers\BranchController::class, 'getLists'])->name('get-lists');
            Route::get('/create', [App\Http\Controllers\BranchController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\BranchController::class, 'save'])->name('save');
            Route::get('/edit/{id}', [App\Http\Controllers\BranchController::class, 'edit'])->name('edit');
            Route::post('/update', [App\Http\Controllers\BranchController::class, 'update'])->name('update');
        });
    });

    Route::prefix('product-categories')->group(function () {
        Route::name('product-categories.')->group(function () {
            Route::get('/', [App\Http\Controllers\ProductCategoryController::class, 'index'])->name('index');
            Route::get('/lists', [App\Http\Controllers\ProductCategoryController::class, 'getLists'])->name('get-lists');
            Route::get('/create', [App\Http\Controllers\ProductCategoryController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\ProductCategoryController::class, 'save'])->name('save');
            Route::get('/edit/{id}', [App\Http\Controllers\ProductCategoryController::class, 'edit'])->name('edit');
            Route::post('/update', [App\Http\Controllers\ProductCategoryController::class, 'update'])->name('update');
        });
    });

    Route::prefix('customers')->group(function () {
        Route::name('customers.')->group(function () {
            Route::get('/', [App\Http\Controllers\CustomerController::class, 'index'])->name('index');
            Route::get('/lists', [App\Http\Controllers\CustomerController::class, 'getLists'])->name('get-lists');
            Route::get('/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\CustomerController::class, 'save'])->name('save');
            Route::get('/edit/{id}', [App\Http\Controllers\CustomerController::class, 'edit'])->name('edit');
            Route::post('/update', [App\Http\Controllers\CustomerController::class, 'update'])->name('update');
        });
    });

    Route::prefix('suppliers')->group(function () {
        Route::name('suppliers.')->group(function () {
            Route::get('/', [App\Http\Controllers\SupplierController::class, 'index'])->name('index');
            Route::get('/lists', [App\Http\Controllers\SupplierController::class, 'getLists'])->name('get-lists');
            Route::get('/create', [App\Http\Controllers\SupplierController::class, 'create'])->name('create');
        });
    });

    //Transaction

    // Point of Sales
    Route::prefix('transactions')->group(function () {
        Route::name('transactions.')->group(function () {
            Route::get('/', [App\Http\Controllers\TransactionController::class, 'index'])->name('index');
            Route::post('/store', [App\Http\Controllers\TransactionController::class, 'store'])->name('store');
        });
    });

    // Point of Sales
    Route::prefix('orders')->group(function () {
        Route::name('orders.')->group(function () {
            Route::get('/', [App\Http\Controllers\OrderController::class, 'index'])->name('index');
            Route::get('/lists', [App\Http\Controllers\OrderController::class, 'getLists'])->name('get-lists');
            Route::get('/edit/{id}', [App\Http\Controllers\OrderController::class, 'edit'])->name('edit');
            Route::get('/export', [App\Http\Controllers\OrderController::class, 'export'])->name('export');
        });
    });
});
