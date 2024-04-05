<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\SystemSettingController;

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

Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    /* System Setting routes */
Route::apiResource('/system-setting', SystemSettingController::class)->only(['index', 'update']);

    /* Category routes */
    Route::get('/all-categories', [CategoryController::class, 'allCategories']);
    Route::get('/categories/status/{id}', [CategoryController::class, 'status']);
    Route::apiResource('/categories', CategoryController::class);

 /* Brand routes */
    Route::get('/all-brands', [BrandController::class, 'allBrands']);
    Route::get('/brands/status/{id}', [BrandController::class, 'status']);
    Route::apiResource('/brands', BrandController::class);

    /* Supplier routes */
    Route::get('/all-suppliers', [SupplierController::class, 'allSupplier']);
    Route::get('/suppliers/status/{id}', [SupplierController::class, 'status']);
    Route::apiResource('/suppliers', SupplierController::class);

    /* Customer routes */
    Route::get('/all-customers', [CustomerController::class, 'allCustomers']);
    Route::get('/customers/status/{id}', [CustomerController::class, 'status']);
    Route::apiResource('/customers', CustomerController::class);

    /* Staff routes */
    Route::get('/all-staffs', [StaffController::class, 'allStaff']);
    Route::get('/staffs/status/{id}', [StaffController::class, 'status']);
    Route::apiResource('/staffs', StaffController::class);

    /* Product routes */
    Route::get('/all-products', [ProductController::class, 'allProduct']);
    Route::get('/products/status/{id}', [ProductController::class, 'status']);
    Route::apiResource('/products', ProductController::class);

});


