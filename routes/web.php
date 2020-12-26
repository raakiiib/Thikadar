<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\SupplierController;
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
Route::get('products', [PurchasesController::class, 'index'])
    ->name('products')
    ->middleware('auth');
Route::get('products/create', [PurchasesController::class, 'create'])
    ->name('products.create')
    ->middleware('auth');
Route::post('products', [PurchasesController::class, 'store'])
    ->name('products.store')
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

// Route::get('reports/{product}/show', [VehiclesController::class, 'showProductReport'])
    // ->name('repor.edit')
    // ->middleware('auth');

######## SUPPLIERS ########
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

######## SUPPLIERS ########
Route::get('expenses', [ExpensesController::class, 'index'])
    ->name('expenses')
    ->middleware('remember', 'auth');
Route::get('expenses/create', [ExpensesController::class, 'create'])
    ->name('expenses.create')
    ->middleware('auth');
Route::post('expenses', [ExpensesController::class, 'store'])
    ->name('expenses.store')
    ->middleware('auth');
Route::get('expenses/{service}/edit', [ExpensesController::class, 'edit'])
    ->name('expenses.edit')
    ->middleware('auth');
Route::put('expenses/{service}', [ExpensesController::class, 'update'])
    ->name('expenses.update')
    ->middleware('auth');
Route::delete('expenses/{service}', [ExpensesController::class, 'destroy'])
    ->name('expenses.destroy')
    ->middleware('auth');
Route::put('expenses/{service}/restore', [ExpensesController::class, 'restore'])
    ->name('expenses.restore')
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
