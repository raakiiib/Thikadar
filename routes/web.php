<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StaffsController;
use App\Http\Controllers\RawMaterialsController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth

Route::get('login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [LoginController::class, 'login'])
    ->name('login.attempt')
    ->middleware('guest');

Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout');

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Users

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

// Organizations

// Route::get('organizations', [OrganizationsController::class, 'index'])
//     ->name('organizations')
//     ->middleware('remember', 'auth');

// Route::get('organizations/create', [OrganizationsController::class, 'create'])
//     ->name('organizations.create')
//     ->middleware('auth');

// Route::post('organizations', [OrganizationsController::class, 'store'])
//     ->name('organizations.store')
//     ->middleware('auth');

// Route::get('organizations/{organization}/edit', [OrganizationsController::class, 'edit'])
//     ->name('organizations.edit')
//     ->middleware('auth');

// Route::put('organizations/{organization}', [OrganizationsController::class, 'update'])
//     ->name('organizations.update')
//     ->middleware('auth');

// Route::delete('organizations/{organization}', [OrganizationsController::class, 'destroy'])
//     ->name('organizations.destroy')
//     ->middleware('auth');

// Route::put('organizations/{organization}/restore', [OrganizationsController::class, 'restore'])
//     ->name('organizations.restore')
//     ->middleware('auth');



## Suppliers
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


// Contacts

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

// Starffs
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



// Raw Materials
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



// Vehicles
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






// Reports

Route::get('reports', [ReportsController::class, 'index'])
    ->name('reports')
    ->middleware('auth');

// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])->where('path', '.*');

// 500 error

Route::get('500', function () {
    // Force debug mode for this endpoint in the demo environment
    if (App::environment('demo')) {
        Config::set('app.debug', true);
    }

    echo $fail;
});
