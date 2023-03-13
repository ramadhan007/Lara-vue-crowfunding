<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group([
    'prefix'=>'auth',
], function(){
    Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login']);
    Route::post('generate-otp-code',[AuthController::class,'generateOTP']);
    Route::post('verification-email',[AuthController::class,'verifikasiEmail']);
    Route::post('update-password',[AuthController::class,'updatePassword'])->middleware('auth');
    Route::post('logout',[AuthController::class,'logout'])->middleware('auth');
    Route::post('update-profile',[AuthController::class,'updateProfile'])->middleware('auth');
   
});

Route::get('profile',[AuthController::class,'me'])->middleware('auth','email_verified');