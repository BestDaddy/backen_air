<?php

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['prefix' =>'arduino', 'middleware' => 'auth.arduino', 'as' => 'arduino.'], function () {
    Route::post('/auth', [\App\Http\Controllers\Api\ArduinoController::class, 'auth'])->name('auth')->withoutMiddleware(['auth.arduino']);
    Route::get('/me', [\App\Http\Controllers\Api\ArduinoController::class, 'me']);
    Route::post('/send', [\App\Http\Controllers\Api\ArduinoController::class, 'send']);
});
