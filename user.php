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

Route::post('user/register',[AuthController::class,'userRegister']);
Route::post('user/login',[AuthController::class, 'userLogin']);
Route::group( ['prefix' => 'user','middleware' => ['auth:user-api','scopes:user'] ],function(){
    // authenticated staff routes here
    Route::post('bookdate',[AuthController::class, 'bookDate']);
    Route::post( 'allExperts',[AuthController::class, 'getAllExperts']);
    Route::post('ExpertDetails',[AuthController::class, 'getExpertDetails']);
    Route::post('SearchExpert',[AuthController::class, 'searchExperts']);
    Route::post('SearchSkill',[AuthController::class, 'searchSkills']);
    Route::post('allSkill',[AuthController::class, 'getAllSkills']);
    Route::post('setFavorite',[AuthController::class, 'setFavorite']);
    Route::post('deleteFavorite',[AuthController::class, 'deleteFavorite']);
    Route::get('getFavorite',[AuthController::class, 'getFavorite']);
    Route::post('logout',[AuthController::class, 'userLogout']);

});

