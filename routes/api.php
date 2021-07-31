<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
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

//City
Route::resource('cities',CityController::class);

//Company
Route::get('company/{id}/details', [CompanyController::class, 'details']);
Route::post('company/{id}/update', [CompanyController::class, 'update']);

//User
Route::get('user-current/{id}/details', [UserController::class, 'getUserCurrent']);







