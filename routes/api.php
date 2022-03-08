<?php
use App\Http\Controllers\Productcontroller;
use App\Http\Controllers\Authcontroller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LotteryTypeController; // add this at top in the file


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//combine route aesa define krty hai
//Route::resource('products', ProductController::class);

//public routes
Route::post('/register', [Authcontroller::class,'register']);
Route::post('/login', [Authcontroller::class,'login']);
Route::get('/products', [ProductController::class,'index']);
Route::get('/products/search/{name}', [ProductController::class,'search']);
Route::get('/products/{id}', [ProductController::class,'show']);
Route::post('/products', [ProductController::class,'store']);


Route::post('lottery-type-dsr', [LotteryTypeController::class,'dsr']); // delete Selected record
Route::resource('lotterytype', LotteryTypeController::class);


//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

Route::put('/products/{id}', [ProductController::class,'update']);
Route::delete('/products/{id}', [ProductController::class,'destroy']);
Route::post('/logout', [AuthController::class,'logout']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});