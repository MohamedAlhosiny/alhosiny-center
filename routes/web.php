<?php

use App\Http\Controllers\DriveController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


route::prefix('/drive')->name('drives.')->group(function () {
    route::get('/index' , [DriveController::class , 'index'])->name('index');

    route::get('/{drive}/edit' , [DriveController::class , 'edit'])->name('edit');

    route::get('/create' , [DriveController::class , 'create'])->name('create');
    route::post('/store' , [DriveController::class , 'store'])->name('store');
    route::delete('/destroy/{drive}' , [DriveController::class , 'destroy'])->name('destroy');
    route::post('/update/{drive}' , [DriveController::class , 'update'])->name('update');
    route::get('/myfiles' , [DriveController::class , 'myfiles'])->name('myfiles')->middleware('auth');
    route::get('/status/{drive}' , [DriveController::class , 'changeStatus'])->name('status');
    route::get('/download/{drive}' , [DriveController::class , 'download'])->name('download');
});

