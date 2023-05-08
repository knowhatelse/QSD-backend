<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SizeController;
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

Route::post('register',[AuthController::class,'register']);

//Color endpoint routes
Route::get('color', [ColorController::class, 'getColors']);
Route::post('color', [ColorController::class, 'addColor']);
Route::put('color', [ColorController::class, 'updateColor']);
Route::delete('color/{id}', [ColorController::class, 'deleteColor']);

//Brand endpoint routes
Route::get('brand', [BrandController::class, 'getBrands']);
Route::post('brand', [BrandController::class, 'addBrand']);
Route::put('brand/{id}', [BrandController::class, 'updateBrand']);
Route::delete('brand/{id}', [BrandController::class, 'deleteBrand']);

//Size endpoint routes
Route::get('size', [SizeController::class, 'getSizes']);
Route::post('size', [SizeController::class, 'addSize']);
Route::put('size/{id}', [SizeController::class, 'updateSize']);
Route::delete('size/{id}', [SizeController::class, 'deleteSize']);
