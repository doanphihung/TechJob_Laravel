<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;
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
Route::post('company/{id}/post', [CompanyController::class, 'postJob']);
Route::get('company/{id}/list-job', [CompanyController::class, 'listJob']);

//Category
Route::get('categories',[CategoryController::class, 'index']);

//Job
Route::get('job/{id}/details',[JobController::class, 'findById']);
Route::post('job/{id}/update',[JobController::class, 'update']);


//Get Current user
Route::get('current-user/{id}/details', [UserController::class, 'details']);





//Test
Route::get('test',[CategoryController::class, 'test'])->middleware('auth:api');










