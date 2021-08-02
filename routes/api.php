<?php

use App\Http\Controllers\API as API;
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


    Route::post('/login' , [API\AuthController::class, 'login'])->name('login');
    Route::get('/user/store' , [API\UserController::class, 'store'])->name('user.store');
    Route::post('/user/search' , [API\UserController::class, 'search'])->name('user.search');
    Route::get('/user/downloadpdf' , [API\UserController::class, 'downloadpdf'] )->name('user.downloadpdf');




