<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
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

//Auth
Route::post('employer/register', [AuthController::class, 'employerRegister']);
Route::post('login', [AuthController::class, 'login']);

Route::resource('cities',CityController::class);


Route::get('test', [AuthController::class, 'test'])->middleware('auth:api');
Route::get('test1', [AuthController::class, 'test1'])->name('login');



