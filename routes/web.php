<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\DailyExpensesController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\StaffsController;
use App\Http\Controllers\RawMaterialsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------|
*/

######## AUTH ########
Route::get('login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');
Route::post('login', [LoginController::class, 'login'])
    ->name('login.attempt')
    ->middleware('guest');
Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout');

######## DASHBOARD ########
Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

######## USERS ########
Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('remember', 'auth');
Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');
Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');
Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');
Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');
Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');
Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');

######## SUPPLIERS ########
Route::get('suppliers', [SupplierController::class, 'index'])
    ->name('suppliers')
    ->middleware('remember', 'auth');
Route::get('suppliers/create', [SupplierController::class, 'create'])
    ->name('suppliers.create')
    ->middleware('auth');
Route::post('suppliers', [SupplierController::class, 'store'])
    ->name('suppliers.store')
    ->middleware('auth');
Route::get('suppliers/{supplier}/edit', [SupplierController::class, 'edit'])
    ->name('suppliers.edit')
    ->middleware('auth');
Route::put('suppliers/{supplier}', [SupplierController::class, 'update'])
    ->name('suppliers.update')
    ->middleware('auth');
Route::delete('suppliers/{supplier}', [uppliersController::class, 'destroy'])
    ->name('suppliers.destroy')
    ->middleware('auth');
Route::put('suppliers/{supplier}/restore', [suppliersController::class, 'restore'])
    ->name('suppliers.restore')
    ->middleware('auth');

######## CONTACTS ########
Route::get('contacts', [ContactsController::class, 'index'])
    ->name('contacts')
    ->middleware('remember', 'auth');
Route::get('contacts/create', [ContactsController::class, 'create'])
    ->name('contacts.create')
    ->middleware('auth');
Route::post('contacts', [ContactsController::class, 'store'])
    ->name('contacts.store')
    ->middleware('auth');
Route::get('contacts/{contact}/edit', [ContactsController::class, 'edit'])
    ->name('contacts.edit')
    ->middleware('auth');
Route::put('contacts/{contact}', [ContactsController::class, 'update'])
    ->name('contacts.update')
    ->middleware('auth');
Route::delete('contacts/{contact}', [ContactsController::class, 'destroy'])
    ->name('contacts.destroy')
    ->middleware('auth');
Route::put('contacts/{contact}/restore', [ContactsController::class, 'restore'])
    ->name('contacts.restore')
    ->middleware('auth');

######## STAFFS ########
Route::get('staffs', [StaffsController::class, 'index'])
    ->name('staffs')
    ->middleware('remember', 'auth');
Route::get('staffs/create', [StaffsController::class, 'create'])
    ->name('staffs.create')
    ->middleware('auth');
Route::post('staffs', [StaffsController::class, 'store'])
    ->name('staffs.store')
    ->middleware('auth');
Route::get('staffs/{staff}/edit', [StaffsController::class, 'edit'])
    ->name('staffs.edit')
    ->middleware('auth');
Route::put('staffs/{staff}', [StaffsController::class, 'update'])
    ->name('staffs.update')
    ->middleware('auth');
Route::delete('staffs/{staff}', [StaffsController::class, 'destroy'])
    ->name('staffs.destroy')
    ->middleware('auth');
Route::put('staffs/{staff}/restore', [StaffsController::class, 'restore'])
    ->name('staffs.restore')
    ->middleware('auth');

######## MATERIALS ########
Route::get('materials', [RawMaterialsController::class, 'index'])
    ->name('materials')
    ->middleware('remember', 'auth');
Route::get('materials/create', [RawMaterialsController::class, 'create'])
    ->name('materials.create')
    ->middleware('auth');
Route::post('materials', [RawMaterialsController::class, 'store'])
    ->name('materials.store')
    ->middleware('auth');
Route::get('materials/{material}/edit', [RawMaterialsController::class, 'edit'])
    ->name('materials.edit')
    ->middleware('auth');
Route::put('materials/{material}', [RawMaterialsController::class, 'update'])
    ->name('materials.update')
    ->middleware('auth');
Route::delete('materials/{material}', [RawMaterialsController::class, 'destroy'])
    ->name('materials.destroy')
    ->middleware('auth');
Route::put('materials/{material}/restore', [RawMaterialsController::class, 'restore'])
    ->name('materials.restore')
    ->middleware('auth');

######## VEHICLES ########
Route::get('vehicles', [VehiclesController::class, 'index'])
    ->name('vehicles')
    ->middleware('remember', 'auth');
Route::get('vehicles/create', [VehiclesController::class, 'create'])
    ->name('vehicles.create')
    ->middleware('auth');
Route::post('vehicles', [VehiclesController::class, 'store'])
    ->name('vehicles.store')
    ->middleware('auth');
Route::get('vehicles/{vehicle}/edit', [VehiclesController::class, 'edit'])
    ->name('vehicles.edit')
    ->middleware('auth');
Route::put('vehicles/{vehicle}', [VehiclesController::class, 'update'])
    ->name('vehicles.update')
    ->middleware('auth');
Route::delete('vehicles/{vehicle}', [VehiclesController::class, 'destroy'])
    ->name('vehicles.destroy')
    ->middleware('auth');
Route::put('vehicles/{vehicle}/restore', [VehiclesController::class, 'restore'])
    ->name('vehicles.restore')
    ->middleware('auth');

######## PURCHASE ########
Route::get('purchases', [PurchasesController::class, 'index'])
    ->name('purchases')
    ->middleware('auth');

// Create Services Expense
Route::get('purchases/service', [PurchasesController::class, 'createServices'])
    ->name('purchase.service')
    ->middleware('auth');

/**
 * DAILY EXPENSES MODULE
 */
// index
Route::get('expenses', [DailyExpensesController::class, 'index'])
    ->name('expenses.dailyexpense')
    ->middleware('auth');
// Create 
Route::get('expenses/create', [DailyExpensesController::class, 'create'])
    ->name('dailyexpense.create')
    ->middleware('auth');
// Store
Route::post('expenses', [DailyExpensesController::class, 'store'])
    ->name('dailyexpense.store')
    ->middleware('auth');
// Edit 
Route::get('expenses/{expense}/edit', [DailyExpensesController::class, 'edit'])
    ->name('dailyexpense.edit')
    ->middleware('auth');
// Update
Route::put('expenses/{expense}', [DailyExpensesController::class, 'update'])
    ->name('expenses.update')
    ->middleware('auth');
// Destroy
Route::delete('expenses/{expense}', [DailyExpensesController::class, 'destroy'])
    ->name('expenses.destroy')
    ->middleware('auth');
// Restore
Route::put('expenses/{expense}/restore', [DailyExpensesController::class, 'restore'])
    ->name('expenses.restore')
    ->middleware('auth');


/**
 * PRODUCT PURCHASE MODULE
 */
// Product Index
Route::get('products', [ProductsController::class, 'index'])
    ->name('expenses.products')
    ->middleware('auth');
// Product Create
Route::get('products/create', [ProductsController::class, 'create'])
    ->name('purchase.product')
    ->middleware('auth');
// Product Store
Route::post('purchases', [ProductsController::class, 'store'])
    ->name('product.store')
    ->middleware('auth');
// Product Edit 
Route::get('products/{product}/edit', [ProductsController::class, 'edit'])
    ->name('product.edit')
    ->middleware('auth');
// Product Update
Route::put('products/{product}', [ProductsController::class, 'update'])
    ->name('product.update')
    ->middleware('auth');
// Product Destroy
Route::delete('product/{expense}', [ProductsController::class, 'destroy'])
    ->name('product.destroy')
    ->middleware('auth');
// Product Restore
Route::put('product/{expense}/restore', [ProductsController::class, 'restore'])
    ->name('product.restore')
    ->middleware('auth');

Route::post('purchase_services', [PurchasesController::class, 'storeService'])
    ->name('purchases.storeService')
    ->middleware('auth');

######## INVOICES ########
Route::get('invoices', [InvoicesController::class, 'index'])
    ->name('invoices')
    ->middleware('auth');
Route::get('invoices/create', [InvoicesController::class, 'create'])
    ->name('invoices.create')
    ->middleware('auth');

######## REPORTS ########
Route::get('reports', [ReportsController::class, 'index'])
    ->name('reports')
    ->middleware('auth');

Route::get('reports/products', [ReportsController::class, 'products'])
    ->name('reports.products')
    ->middleware('auth');

######## SERVICES ########
Route::get('services', [ServicesController::class, 'index'])
    ->name('services')
    ->middleware('remember', 'auth');
Route::get('services/create', [ServicesController::class, 'create'])
    ->name('services.create')
    ->middleware('auth');
Route::post('services', [ServicesController::class, 'store'])
    ->name('services.store')
    ->middleware('auth');
Route::get('services/{service}/edit', [ServicesController::class, 'edit'])
    ->name('services.edit')
    ->middleware('auth');
Route::put('services/{service}', [ServicesController::class, 'update'])
    ->name('services.update')
    ->middleware('auth');
Route::delete('services/{service}', [ServicesController::class, 'destroy'])
    ->name('services.destroy')
    ->middleware('auth');
Route::put('services/{service}/restore', [ServicesController::class, 'restore'])
    ->name('services.restore')
    ->middleware('auth');


// SERVICE_EXPENSE INDEX
Route::get('expenses/services', [ExpensesController::class, 'services'])
    ->name('expenses.services')
    ->middleware('auth');
    

// Expense Types
Route::get('exptypes', [ExpenseTypeController::class, 'index'])
    ->name('exptypes')
    ->middleware('auth');

Route::get('exptypes/create', [ExpenseTypeController::class, 'create'])
    ->name('exptypes.create')
    ->middleware('auth');

Route::post('exptypes', [ExpenseTypeController::class, 'store'])
    ->name('exptypes.store')
    ->middleware('auth');
    
Route::get('exptypes/{expense}/edit', [ExpenseTypeController::class, 'edit'])
    ->name('exptypes.edit')
    ->middleware('auth');

Route::put('exptypes/{type}', [ExpenseTypeController::class, 'update'])
    ->name('exptypes.update')
    ->middleware('auth');

Route::delete('exptypes/{type}', [ExpenseTypeController::class, 'destroy'])
    ->name('exptypes.destroy')
    ->middleware('auth');

Route::put('exptypes/{type}/restore', [ExpenseTypeController::class, 'restore'])
    ->name('exptypes.restore')
    ->middleware('auth');

######## IMAGE ########
Route::get('/img/{path}', [ImagesController::class, 'show'])->where('path', '.*');

// 500 error

Route::get('500', function () {
    // Force debug mode for this endpoint in the demo environment
    if (App::environment('demo')) {
        Config::set('app.debug', true);
    }

    echo $fail;
});
