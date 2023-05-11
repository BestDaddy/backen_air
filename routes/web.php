<?php


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
    return redirect()->route('user.home');
});

Auth::routes();



//Route::post('/register', [App\Http\Controllers\HomeController::class, 'asdf'])->name('register');

Route::group(['prefix' =>'user', 'middleware'=>'auth', 'as' => 'user.'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


});

Route::group(['namespace' => 'Support', 'middleware'=>'auth'], function () {
    Route::get('/lang/{locale}', [App\Http\Controllers\Web\Support\LocalizationController::class, 'index'])->name('lang');
});



Route::group(['prefix' =>'admin', 'middleware'=>'admin', 'as' => 'admin.'], function () {
    Route::resources([
        'users' => App\Http\Controllers\Web\Admin\UserController::class,
    ]);
    Route::resource('arduino', \App\Http\Controllers\Web\Admin\ArduinoController::class)->only('index', 'store', 'edit', 'show', 'destroy');
//    Route::resource('minions', \App\Http\Controllers\Web\Admin\MinionController::class)->only('index', 'store', 'edit', 'destroy');
    Route::resource('arduino-types', \App\Http\Controllers\Web\Admin\ArduinoTypeController::class)->only('index', 'store', 'edit', 'destroy');
    Route::resource('logs', \App\Http\Controllers\Web\Admin\LogController::class)->only('index');
//    Route::get('/parsed-logs/{arduino_id}', [\App\Http\Controllers\Web\Admin\LogController::class, 'parsedIndex'])->name('parsed.logs');
});

