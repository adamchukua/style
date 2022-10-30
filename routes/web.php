<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'verified'], function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);

    Route::get('/work/create', [App\Http\Controllers\WorkController::class, 'create']);
    Route::post('/work/create', [App\Http\Controllers\WorkController::class, 'store']);
    Route::get('/work/{work}', [App\Http\Controllers\WorkController::class, 'show']);
});
