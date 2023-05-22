<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductController;
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

//Auth endpoint routes
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('requestValidationKey',[AuthController::class,'requestValidationKey']);
Route::post('resetPassword',[AuthController::class,'resetPassword']);
Route::post('search',[SearchController::class,'search']);
Route::middleware('auth:api')->post('refresh',[AuthController::class,'refresh']);
Route::middleware('auth:api')->post('changePassword',[AuthController::class,'changePassword']);
Route::middleware('auth:api')->post('logout',[AuthController::class,'logout']);
Route::middleware('auth:api')->post('handleFavorite',[FavoriteController::class,'handleFavorite']);
Route::middleware('auth:api')->get('getFavorites',[FavoriteController::class,'getFavorites']);
Route::get('filterProducts',[\App\Http\Controllers\FilterController::class,'filterProducts']);

//User endpoint routes
Route::middleware('auth:api')->get('user/{id}', [UserController::class, 'getUserById']);
Route::group(['middleware'=>'superAdmin'],function() {
    Route::get('users', [UserController::class, 'getUsers']);
    Route::put('updateUser', [UserController::class, 'updateUser']);
    Route::put('updateRole', [UserController::class, 'updateRole']);
    Route::put('banUser/{id}', [UserController::class, 'banUser']);
    Route::delete('deleteUser/{id}', [UserController::class, 'deleteUser']);
});

//Color endpoint routes
Route::get('colors', [ColorController::class, 'getColors']);
Route::middleware('adminSuperAdmin')->post('addColor', [ColorController::class, 'addColor']);
Route::middleware('adminSuperAdmin')->put('updateColor', [ColorController::class, 'updateColor']);
Route::middleware('adminSuperAdmin')->delete('deleteColor/{id}', [ColorController::class, 'deleteColor']);

//Brand endpoint routes
Route::get('brands', [BrandController::class, 'getBrands']);
Route::middleware('adminSuperAdmin')->post('brands', [BrandController::class, 'addBrand']);
Route::middleware('adminSuperAdmin')->put('updateBrand', [BrandController::class, 'updateBrand']);
Route::middleware('adminSuperAdmin')->delete('deleteBrand/{id}', [BrandController::class, 'deleteBrand']);

//Size endpoint routes
Route::get('sizes', [SizeController::class, 'getSizes']);
Route::middleware('adminSuperAdmin')->post('addSize', [SizeController::class, 'addSize']);
Route::middleware('adminSuperAdmin')->put('updateSize', [SizeController::class, 'updateSize']);
Route::middleware('adminSuperAdmin')->delete('deleteSize/{id}', [SizeController::class, 'deleteSize']);

//Category endpoint
Route::get('categories', [CategoryController::class,'getCategories']);
Route::middleware('adminSuperAdmin')->post('addCategory', [CategoryController::class,'addCategory']);
Route::middleware('adminSuperAdmin')->put('updateCategory/{id}', [CategoryController::class,'updateCategory']);
Route::middleware('adminSuperAdmin')->delete('deleteCategory/{id}', [CategoryController::class,'deleteCategory']);

//Product endpoint
Route::get('products', [ProductController::class, 'getProducts']);
Route::get('getProduct/{id}', [ProductController::class, 'getProductById']);
Route::middleware('adminSuperAdmin')->post('addProduct', [ProductController::class, 'addProduct']);
Route::middleware('adminSuperAdmin')->put('updateProduct', [ProductController::class, 'updateProduct']);
Route::middleware('adminSuperAdmin')->delete('deleteProduct/{id}', [ProductController::class, 'deleteProduct']);

//Rating endpoint
Route::post('rateProduct', [RatingController::class, 'rateProduct']);
