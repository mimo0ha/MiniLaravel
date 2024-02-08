<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::post('expert/register',[AuthController::class,'expertRegister']);

Route::post('expert/login',[AuthController::class, 'expertLogin']);
Route::group( ['prefix' => 'expert','middleware' => ['auth:expert-api','scopes:expert'] ],function(){
    // authenticated staff routes here
    Route::post('availableDay',[AuthController::class,'availableDay']);
    Route::post ('allBookeds',[AuthController::class,'getAllBooked']);
    Route::post('logout',[AuthController::class, 'expertLogout']);
});

