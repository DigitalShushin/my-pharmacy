<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;

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


// Supplier
Route::get('/admin/supplier/list', [SupplierController::class, 'index'])->name('supplier');
Route::get('/admin/supplier/add', [SupplierController::class, 'add'])->name('add');
// Route::get('/apps-category/{id}', [CategoryController::class, 'add'])->name('add');


Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
