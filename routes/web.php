<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DetailProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
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

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('show.login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    //Categories 
    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function() {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/datatable', [CategoryController::class, 'datatable'])->name('datatable');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    //Products 
    Route::group(['prefix' => 'products', 'as' => 'products.'], function() {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/datatable', [ProductController::class, 'datatable'])->name('datatable');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::post('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });

    //Detail products
    Route::group(['prefix' => 'detail-products', 'as' => 'detail-products.'], function() {
        Route::get('/', [DetailProductController::class, 'index'])->name('index');
        Route::get('/datatable', [DetailProductController::class, 'datatable'])->name('datatable');
        Route::post('/store', [DetailProductController::class, 'store'])->name('store');
        Route::get('/{id}/create', [DetailProductController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [DetailProductController::class, 'edit'])->name('edit');
        Route::post('/{id}', [DetailProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [DetailProductController::class, 'destroy'])->name('destroy');
    });
});