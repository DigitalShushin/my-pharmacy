<?php
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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



Auth::routes();
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

// Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

Route::get('/', [FrontendController::class, 'frontend'])->name('frontend');

Route::get('/admin', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');



// Category
Route::get('/admin/category/list-all', [CategoryController::class, 'index'])->name('category');
Route::get('/admin/category/add', [CategoryController::class, 'add'])->name('add');
// Route::get('/apps-category/{id}', [CategoryController::class, 'add'])->name('add');


// Supplier
// Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
// Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
// Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
Route::resource('suppliers', SupplierController::class);



// Company
Route::resource('admin/company', CompanyController::class);
Route::post('/admin/company/add_process/', [CompanyController::class, 'store'])->name('company.store');
Route::get('/admin/company/edit/{id}', [CompanyController::class, 'edit']);
Route::put('/admin/company/update/{id}', [CompanyController::class, 'update']);
Route::delete('/admin/company/delete/{id}', [CompanyController::class, 'destroy'])->name('company.destroy');

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');


// Product
Route::resource('products', ProductController::class);

// Purchase
Route::resource('purchases', PurchaseController::class);
Route::get('/purchase/{id}/edit', [PurchaseController::class, 'edit'])->name('purchase.edit');
