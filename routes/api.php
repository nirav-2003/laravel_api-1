<?php

use App\Http\Controllers\HomeController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/sd', [HomeController::class, 'index']);
// Route::post('/home', [HomeController::class, 'saveData']);

Route::get('/home1/{id}', [HomeController::class, 'deletePost']);

Route::put('/home/updatedata/{id}', [HomeController::class, 'updatedata']);

Route::post('/fileupload', [HomeController::class, 'fileupload']);




Route::post('/reg', [HomeController::class, 'registration']);

Route::middleware('auth:api')->group(function () {
    Route::get('/home/{id?}', [HomeController::class, 'getuser']);
});

Route::post('/log', [HomeController::class, 'log']);
