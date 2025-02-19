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

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/', function () {
    return view('auth.login');
});

// Auth::routes();

Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');
// Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('register');

Route::group(['middleware' => ['auth']], function() {
    Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');

    Route::prefix('dashboards')->group(function () {
        Route::name('dashboards.')->group(function () {
            Route::get('/store', [App\Http\Controllers\HomeController::class, 'index'])->name('store');
        });
    });

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
            Route::get('/carcass-items', [App\Http\Controllers\ProductController::class, 'getListProductsForCarcass'])->name('get-lists-carcass');
            Route::post('/update-formula', [App\Http\Controllers\ProductController::class, 'updateFormula'])->name('update-formula');
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

    Route::prefix('product-details')->group(function () {
        Route::name('product-details.')->group(function () {
            Route::get('/', [App\Http\Controllers\ProductDetailController::class, 'index'])->name('index');
            Route::get('/lists/{id}', [App\Http\Controllers\ProductDetailController::class, 'getLists'])->name('get-lists');
            Route::get('/create/{product_id}', [App\Http\Controllers\ProductDetailController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\ProductDetailController::class, 'save'])->name('save');
            Route::get('/edit/{id}', [App\Http\Controllers\ProductDetailController::class, 'edit'])->name('edit');
            Route::post('/update', [App\Http\Controllers\ProductDetailController::class, 'update'])->name('update');
            Route::post('/update-status', [App\Http\Controllers\ProductDetailController::class, 'updateStatus'])->name('update-status');
            Route::post('/update-all-price', [App\Http\Controllers\ProductDetailController::class, 'updateAllPrice'])->name('update-all-price');
            Route::post('/update-all-discount', [App\Http\Controllers\ProductDetailController::class, 'updateAllDiscount'])->name('update-all-discount');
            Route::post('/update-all-discount-date', [App\Http\Controllers\ProductDetailController::class, 'updateAllDiscountDate'])->name('update-all-discount-date');
        });
    });

    Route::prefix('customers')->group(function () {
        Route::name('customers.')->group(function () {
            Route::get('/', [App\Http\Controllers\CustomerController::class, 'index'])->name('index');
            Route::get('/lists', [App\Http\Controllers\CustomerController::class, 'getLists'])->name('get-lists');
            Route::get('/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\CustomerController::class, 'save'])->name('save');
            Route::get('/edit/{id}', [App\Http\Controllers\CustomerController::class, 'edit'])->name('edit');
            Route::get('/credit-policies/{id}', [App\Http\Controllers\CustomerController::class, 'creditPolicies'])->name('credit-policies');
            Route::post('/credit-policies/save', [App\Http\Controllers\CustomerController::class, 'creditPoliciesSave'])->name('credit-policies-save');
            Route::post('/update', [App\Http\Controllers\CustomerController::class, 'update'])->name('update');
        });
    });

    Route::prefix('suppliers')->group(function () {
        Route::name('suppliers.')->group(function () {
            Route::get('/', [App\Http\Controllers\SupplierController::class, 'index'])->name('index');
            Route::get('/lists', [App\Http\Controllers\SupplierController::class, 'getLists'])->name('get-lists');
            Route::get('/create', [App\Http\Controllers\SupplierController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\SupplierController::class, 'save'])->name('save');
            Route::get('/edit/{id}', [App\Http\Controllers\SupplierController::class, 'edit'])->name('edit');
            Route::post('/update', [App\Http\Controllers\SupplierController::class, 'update'])->name('update');
        });
    });

    Route::prefix('inventories')->group(function () {
        Route::name('inventories.')->group(function () {
            Route::get('/', [App\Http\Controllers\InventoryController::class, 'index'])->name('index');
            Route::get('/lists', [App\Http\Controllers\InventoryController::class, 'getLists'])->name('get-lists');
            Route::get('/create', [App\Http\Controllers\InventoryController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\InventoryController::class, 'save'])->name('save');
            Route::get('/edit/{id}', [App\Http\Controllers\InventoryController::class, 'edit'])->name('edit');
            Route::post('/update', [App\Http\Controllers\InventoryController::class, 'update'])->name('update');
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
            Route::post('/update', [App\Http\Controllers\OrderController::class, 'update'])->name('update');
            Route::get('/export', [App\Http\Controllers\OrderController::class, 'export'])->name('export');
            Route::get('/receipt/{id}', [App\Http\Controllers\OrderController::class, 'printReceipt'])->name('print-receipt');

            Route::get('/print-thermal/{id}', [App\Http\Controllers\OrderController::class, 'printThermal'])->name('print-thermal');
        });
    });

    Route::prefix('retails')->group(function () {
        Route::name('retails.')->group(function () {

            Route::prefix('daily-expenses')->group(function () {
                Route::name('daily-expenses.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Retails\DailyExpensesController::class, 'index'])->name('index');
                    Route::get('/lists', [App\Http\Controllers\Retails\DailyExpensesController::class, 'getLists'])->name('get-lists');
                    Route::get('/create', [App\Http\Controllers\Retails\DailyExpensesController::class, 'create'])->name('create');
                    Route::post('/save', [App\Http\Controllers\Retails\DailyExpensesController::class, 'save'])->name('save');
                    Route::get('/edit/{id}', [App\Http\Controllers\Retails\DailyExpensesController::class, 'edit'])->name('edit');
                    Route::post('/update', [App\Http\Controllers\Retails\DailyExpensesController::class, 'update'])->name('update');
                });
            });

            Route::prefix('daily-report')->group(function () {
                Route::name('daily-report.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Retails\DailyReportController::class, 'index'])->name('index');
                    Route::get('/get-data-summary', [App\Http\Controllers\Retails\DailyReportController::class, 'getDataSummary'])->name('summary');
                    Route::get('/export', [App\Http\Controllers\Retails\DailyReportController::class, 'export'])->name('export');
                    Route::get('/get-stock-report', [App\Http\Controllers\Retails\DailyReportController::class, 'getStockReport'])->name('get-stock-report');
                });
            });

        });
    });

    // Productions
    Route::prefix('productions')->group(function () {
        Route::name('productions.')->group(function () {
            Route::get('/', [App\Http\Controllers\ProductionController::class, 'index'])->name('index');
        });
    });

    // Procurement
    Route::prefix('procurement')->group(function () {
        Route::name('procurement.')->group(function () {

            Route::prefix('purchase-request')->group(function () {
                Route::name('purchase-request.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Procurements\PurchaseRequestController::class, 'index'])->name('index');
                    Route::get('/lists', [App\Http\Controllers\Procurements\PurchaseRequestController::class, 'getLists'])->name('get-lists');
                    Route::get('/create', [App\Http\Controllers\Procurements\PurchaseRequestController::class, 'create'])->name('create');
                    Route::post('/save', [App\Http\Controllers\Procurements\PurchaseRequestController::class, 'save'])->name('save');
                    Route::get('/edit/{id}', [App\Http\Controllers\Procurements\PurchaseRequestController::class, 'edit'])->name('edit');
                    Route::get('/approval/{id}', [App\Http\Controllers\Procurements\PurchaseRequestController::class, 'approval'])->name('approval');
                    Route::post('/update', [App\Http\Controllers\Procurements\PurchaseRequestController::class, 'update'])->name('update');
                    Route::get('/export', [App\Http\Controllers\Procurements\PurchaseRequestController::class, 'export'])->name('export');

                    Route::post('/approve-item', [App\Http\Controllers\Procurements\PurchaseRequestController::class, 'approveItem'])->name('approve-item');
                });
            });

            Route::prefix('purchase-order')->group(function () {
                Route::name('purchase-order.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Procurements\PurchaseOrderController::class, 'index'])->name('index');
                    Route::get('/lists', [App\Http\Controllers\Procurements\PurchaseOrderController::class, 'getLists'])->name('get-lists');
                    Route::get('/create', [App\Http\Controllers\Procurements\PurchaseOrderController::class, 'create'])->name('create');
                    Route::post('/save', [App\Http\Controllers\Procurements\PurchaseOrderController::class, 'save'])->name('save');
                    Route::get('/edit/{id}', [App\Http\Controllers\Procurements\PurchaseOrderController::class, 'edit'])->name('edit');
                    Route::post('/update', [App\Http\Controllers\Procurements\PurchaseOrderController::class, 'update'])->name('update');

                    Route::get('/export', [App\Http\Controllers\Procurements\PurchaseOrderController::class, 'export'])->name('export');

                    Route::get('/print/{id}', [App\Http\Controllers\Procurements\PurchaseOrderController::class, 'print'])->name('print-po');
                });
            });

            Route::prefix('goods-receive')->group(function () {
                Route::name('goods-receive.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Procurements\GoodsReceiveController::class, 'index'])->name('index');
                    Route::get('/lists', [App\Http\Controllers\Procurements\GoodsReceiveController::class, 'getLists'])->name('get-lists');
                    Route::get('/create', [App\Http\Controllers\Procurements\GoodsReceiveController::class, 'create'])->name('create');
                    Route::post('/save', [App\Http\Controllers\Procurements\GoodsReceiveController::class, 'save'])->name('save');
                    Route::get('/edit/{id}', [App\Http\Controllers\Procurements\GoodsReceiveController::class, 'edit'])->name('edit');
                });
            });

        });
    });

    // Finances
    Route::prefix('finances')->group(function () {
        Route::name('finances.')->group(function () {

            Route::prefix('chart-of-accounts')->group(function () {
                Route::name('chart-of-accounts.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Finances\ChartOfAccountController::class, 'index'])->name('index');
                    Route::get('/lists', [App\Http\Controllers\Finances\ChartOfAccountController::class, 'getLists'])->name('get-lists');
                    Route::get('/create', [App\Http\Controllers\Finances\ChartOfAccountController::class, 'create'])->name('create');
                    Route::post('/save', [App\Http\Controllers\Finances\ChartOfAccountController::class, 'save'])->name('save');
                    Route::get('/edit/{id}', [App\Http\Controllers\Finances\ChartOfAccountController::class, 'edit'])->name('edit');
                    Route::post('/update', [App\Http\Controllers\Finances\ChartOfAccountController::class, 'update'])->name('update');
                });
            });

            Route::prefix('journals')->group(function () {
                Route::name('journals.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Finances\JournalController::class, 'index'])->name('index');
                    Route::get('/lists', [App\Http\Controllers\Finances\JournalController::class, 'getLists'])->name('get-lists');
                    Route::get('/create', [App\Http\Controllers\Finances\JournalController::class, 'create'])->name('create');
                    Route::post('/save', [App\Http\Controllers\Finances\JournalController::class, 'save'])->name('save');
                    Route::get('/edit/{id}', [App\Http\Controllers\Finances\JournalController::class, 'edit'])->name('edit');
                    Route::post('/update', [App\Http\Controllers\Finances\JournalController::class, 'update'])->name('update');

                    Route::post('/post-to-general-ledger', [App\Http\Controllers\Finances\JournalController::class, 'postToGl'])->name('post-to-general-ledger');
                });
            });

            Route::prefix('general-ledgers')->group(function () {
                Route::name('general-ledgers.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Finances\GeneralLedgerController::class, 'index'])->name('index');
                    Route::get('/lists', [App\Http\Controllers\Finances\GeneralLedgerController::class, 'getLists'])->name('get-lists');
                });
            });

            Route::prefix('account-receivable')->group(function () {
                Route::name('account-receivable.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Finances\AccountReceivableController::class, 'index'])->name('index');
                    Route::get('/lists', [App\Http\Controllers\Finances\AccountReceivableController::class, 'getLists'])->name('get-lists');
                    Route::get('/create', [App\Http\Controllers\Finances\AccountReceivableController::class, 'create'])->name('create');
                    Route::post('/save', [App\Http\Controllers\Finances\AccountReceivableController::class, 'save'])->name('save');
                    Route::get('/edit/{id}', [App\Http\Controllers\Finances\AccountReceivableController::class, 'edit'])->name('edit');
                    Route::post('/update', [App\Http\Controllers\Finances\AccountReceivableController::class, 'update'])->name('update');

                    Route::post('/save-payments', [App\Http\Controllers\Finances\AccountReceivableController::class, 'savePayments'])->name('save-payments');
                });
            });

            Route::prefix('invoices')->group(function () {
                Route::name('invoices.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Finances\InvoiceController::class, 'index'])->name('index');
                    Route::get('/lists', [App\Http\Controllers\Finances\InvoiceController::class, 'getLists'])->name('get-lists');
                    Route::get('/create', [App\Http\Controllers\Finances\InvoiceController::class, 'create'])->name('create');
                    Route::post('/save', [App\Http\Controllers\Finances\InvoiceController::class, 'save'])->name('save');
                    Route::get('/edit/{id}', [App\Http\Controllers\Finances\InvoiceController::class, 'edit'])->name('edit');
                    Route::post('/update', [App\Http\Controllers\Finances\InvoiceController::class, 'update'])->name('update');

                    Route::get('/print-invoice/{id}', [App\Http\Controllers\Finances\InvoiceController::class, 'printInvoice'])->name('print-invoice');

                    Route::get('/get-receivable', [App\Http\Controllers\Finances\InvoiceController::class, 'getReceivable'])->name('get-receivable');
                    Route::post('/get-receivable-items', [App\Http\Controllers\Finances\InvoiceController::class, 'getReceivableItems'])->name('get-receivable-items');
                });
            });

            Route::prefix('account-payable')->group(function () {
                Route::name('account-payable.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Finances\AccountPayableController::class, 'index'])->name('index');
                });
            });

            Route::prefix('expenses')->group(function () {
                Route::name('expenses.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Finances\ExpenseController::class, 'index'])->name('index');
                    Route::get('/lists', [App\Http\Controllers\Finances\ExpenseController::class, 'getLists'])->name('get-lists');
                    Route::get('/create', [App\Http\Controllers\Finances\ExpenseController::class, 'create'])->name('create');
                    Route::post('/save', [App\Http\Controllers\Finances\ExpenseController::class, 'save'])->name('save');
                    Route::get('/edit/{id}', [App\Http\Controllers\Finances\ExpenseController::class, 'edit'])->name('edit');
                    Route::post('/update', [App\Http\Controllers\Finances\ExpenseController::class, 'update'])->name('update');
                });
            });

            Route::prefix('reports')->group(function () {
                Route::name('reports.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Finances\ReportController::class, 'index'])->name('index');
                });
            });
        });
    });

    // Inventory Management

    Route::prefix('stocks')->group(function () {
        Route::name('stocks.')->group(function () {
            Route::get('/', [App\Http\Controllers\StockController::class, 'index'])->name('index');
            Route::get('/lists', [App\Http\Controllers\StockController::class, 'getLists'])->name('get-lists');
            Route::get('/create', [App\Http\Controllers\StockController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\StockController::class, 'save'])->name('save');
            Route::post('/update-opname', [App\Http\Controllers\StockController::class, 'updateOpname'])->name('update-opname');
            Route::get('/export', [App\Http\Controllers\StockController::class, 'export'])->name('export');
            // Route::get('/edit/{id}', [App\Http\Controllers\StockController::class, 'edit'])->name('edit');
            // Route::post('/update', [App\Http\Controllers\StockController::class, 'update'])->name('update');
        });
    });

    Route::prefix('stock-logs')->group(function () {
        Route::name('stock-logs.')->group(function () {
            Route::get('/{stockId}', [App\Http\Controllers\StockLogController::class, 'index'])->name('index');
            Route::get('/lists/{stockId}', [App\Http\Controllers\StockLogController::class, 'getLists'])->name('get-lists');
            // Route::get('/create', [App\Http\Controllers\StockController::class, 'create'])->name('create');
            // Route::post('/save', [App\Http\Controllers\StockController::class, 'save'])->name('save');
            // Route::get('/edit/{id}', [App\Http\Controllers\StockController::class, 'edit'])->name('edit');
            // Route::post('/update', [App\Http\Controllers\StockController::class, 'update'])->name('update');
        });
    });

    Route::prefix('inventory-details')->group(function () {
        Route::name('inventory-details.')->group(function () {
            Route::get('/', [App\Http\Controllers\InventoryDetailController::class, 'index'])->name('index');
            Route::get('/lists', [App\Http\Controllers\InventoryDetailController::class, 'getLists'])->name('get-lists');
            Route::get('/create', [App\Http\Controllers\InventoryDetailController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\InventoryDetailController::class, 'save'])->name('save');
            // Route::get('/edit/{id}', [App\Http\Controllers\InventoryDetailController::class, 'edit'])->name('edit');
            // Route::post('/update', [App\Http\Controllers\InventoryDetailController::class, 'update'])->name('update');
        });
    });

    Route::prefix('inventory-detail-logs')->group(function () {
        Route::name('inventory-detail-logs.')->group(function () {
            Route::get('/{inventoryDetailId}', [App\Http\Controllers\InventoryDetailLogController::class, 'index'])->name('index');
            Route::get('/lists/{inventoryDetailId}', [App\Http\Controllers\InventoryDetailLogController::class, 'getLists'])->name('get-lists');
            Route::get('/{inventoryDetailId}/create', [App\Http\Controllers\InventoryDetailLogController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\InventoryDetailLogController::class, 'save'])->name('save');
            // Route::get('/edit/{id}', [App\Http\Controllers\InventoryDetailLogController::class, 'edit'])->name('edit');
            // Route::post('/update', [App\Http\Controllers\InventoryDetailLogController::class, 'update'])->name('update');
        });
    });
});
