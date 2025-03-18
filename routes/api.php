<?php

use App\Http\Controllers\Api\DriveApiContoller;
use App\Http\Controllers\Api\UserApiController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

route::post('/register' , [UserApiController::class , 'register']);
route::post('/registerSecond' , [UserApiController::class , 'registerSecond']);
route::post('/loginUser' , [UserApiController::class , 'loginUser']);
route::post('/loginAdmin' , [UserApiController::class , 'loginAdmin']);
Route::post('/login' , [UserApiController::class , 'login']);


route::middleware('auth:sanctum')->group(function(){
    route::prefix('drive')->group(function () {
        route::get('' , [DriveApiContoller::class , 'index']);
        route::post('' , [DriveApiContoller::class , 'store']);
        route::get('/{id}' , [DriveApiContoller::class , 'show']);
        route::post('/{drive}' , [DriveApiContoller::class , 'update']);
        route::delete('/{id}' , [DriveApiContoller::class , 'destroy']);


    });

    Route::get('/logout', [UserApiController::class , 'logout']);


});
