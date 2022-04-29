<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfferController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//protected methods
Route::group(['middleware' => ['api', 'auth.jwt']], function(){
    Route::put('offer_detail/{id}', [OfferController::class,'update']);
    Route::delete('offer_detail/{id}', [OfferController::class,'delete']);
    Route::post('auth/logout', [AuthController::class,'logout']);
});

//auth
Route::post('auth/login', [AuthController::class,'login']);
Route::get('offers',[OfferController::class,'index']);
Route::get('offer_detail', [OfferController::class,'index']);
