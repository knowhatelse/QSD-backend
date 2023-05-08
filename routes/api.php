<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
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
Route::post('login',[AuthController::class,'login']);
Route::post('changePassword',[AuthController::class,'changePassword']);
Route::post('logout',[AuthController::class,'logout']);

//Color endpoint routes
Route::get('color', [ColorController::class, 'getColors']);
Route::post('color', [ColorController::class, 'addColor']);
Route::put('color', [ColorController::class, 'updateColor']);
Route::delete('color/{id}', [ColorController::class, 'deleteColor']);

//Brand endpoint routes
Route::get('brand', [BrandController::class, 'getBrands']);
Route::post('brand', [BrandController::class, 'addBrand']);
Route::put('brand', [BrandController::class, 'updateBrand']);
Route::delete('brand/{id}', [BrandController::class, 'deleteBrand']);

//Size endpoint routes
Route::get('size', [SizeController::class, 'getSizes']);
Route::post('size', [SizeController::class, 'addSize']);
Route::put('size', [SizeController::class, 'updateSize']);
Route::delete('size/{id}', [SizeController::class, 'deleteSize']);

//User endpoint routes
Route::get('user', [UserController::class, 'getUsers']);
Route::get('user/{id}', [UserController::class, 'getUserById']);
Route::put('user/{id}/update_user', [UserController::class, 'updateUser']);
Route::put('user/{user_id}/update_role/{role_id}', [UserController::class, 'updateRole']);
Route::put('user/{id}/ban_user', [UserController::class, 'banUser']);
Route::delete('user/{id}', [UserController::class, 'deleteUser']);

//Category endpoint
Route::get('category', [CategoryController::class,'getCategories']);
Route::post('category', [CategoryController::class,'addCategory']);
Route::put('category/{id}', [CategoryController::class,'updateCategory']);
Route::delete('category/{id}', [CategoryController::class,'deleteCategory']);


