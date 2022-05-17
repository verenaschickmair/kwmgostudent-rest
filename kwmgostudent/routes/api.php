<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CommentController;

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

Route::get('subjects',[SubjectController::class,'index']);
Route::get('subjects/{id}', [SubjectController::class, 'findById']);
Route::get('subjects/{id}/offers', [OfferController::class, 'getAllBySubjectId']);

Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'findById']);

Route::get('offers',[OfferController::class,'index']);
Route::get('offers/{id}',[OfferController::class,'findById']);
Route::get('offers/{id}/appointments',[AppointmentController::class,'getAllByOfferId']);
Route::get('offers/{id}/comments',[CommentController::class,'getAllByOfferId']);
Route::put('offers/{id}',[OfferController::class,'update']);
Route::post('offers/{id}',[OfferController::class,'save']);
