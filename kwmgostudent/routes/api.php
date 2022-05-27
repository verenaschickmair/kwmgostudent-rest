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

//PROTECTED
Route::group(['middleware' => ['api', 'auth.jwt']], function(){
    //AUTH
    Route::post('auth/logout', [AuthController::class,'logout']);

    //OFFERS
    Route::put('offers/{id}',[OfferController::class,'update']);
    Route::post('offers',[OfferController::class,'save']);
    Route::delete('offers/{id}', [OfferController::class,'delete']);

    //COMMENTS
    Route::post('offers/{id}', [CommentController::class,'save']);
    Route::delete('comments/{id}', [CommentController::class,'delete']);
    Route::put('comments/{id}', [CommentController::class,'update']);

    //APPOINTMENTS
    Route::put('appointments/{id}', [AppointmentController::class,'book']);
    Route::get('appointments/user/{id}', [AppointmentController::class,'getAllByUserId']);

});

//AUTH
Route::post('auth/login', [AuthController::class,'login']);

//SUBJECTS
Route::get('subjects',[SubjectController::class,'index']);
Route::get('subjects/{id}', [SubjectController::class, 'findById']);
Route::get('subjects/{id}/offers', [OfferController::class, 'getAllBySubjectId']);

//USERS
Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'findById']);

//OFFERS
Route::get('offers',[OfferController::class,'index']);
Route::get('offers/{id}',[OfferController::class,'findById']);
Route::get('offers/{id}/appointments',[AppointmentController::class,'getAllByOfferId']);

//COMMENTS
Route::get('offers/{id}/comments',[CommentController::class,'getAllByOfferId']);
Route::get('comments', [CommentController::class,'index']);
Route::get('comments/{id}', [CommentController::class,'findById']);

//PROFILE
Route::get('profile/{id}/comments',[OfferController::class,'findByUserId']);

