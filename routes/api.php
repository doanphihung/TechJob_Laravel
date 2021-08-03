<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\SeekerController;
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
                // CONTROLLER FRONTEND!!!

//Auth
Route::post('employer/register', [AuthController::class, 'employerRegister']);
Route::post('seeker/register', [AuthController::class, 'seekerRegister']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

//City
Route::resource('cities',CityController::class);
//Company
Route::get('company/{id}/details', [CompanyController::class, 'details']);
Route::post('company/{id}/update', [CompanyController::class, 'update']);
Route::post('company/{id}/post', [CompanyController::class, 'postJob']);
Route::get('company/{id}/list-job', [CompanyController::class, 'listJob']);
Route::get('companies', [CompanyController::class, 'index']);

//Seeker
Route::get('seeker/{id}/details', [SeekerController::class, 'details']);
Route::post('seeker/{id}/update', [SeekerController::class, 'update']);

//Category
Route::get('categories',[CategoryController::class, 'index']);

//Job
Route::get('job/{id}/details',[JobController::class, 'findById']);
Route::post('job/{id}/update',[JobController::class, 'update']);

//Get all jobs desc
Route::get('jobs',[JobController::class, 'index']);

//Search
Route::get('jobs/search-by-keyword',[JobController::class,'searchByKeyWord']);
Route::get('jobs/{id}/search-by-city',[JobController::class,'searchByCity']);
Route::get('jobs/{id}/search-by-category',[JobController::class,'searchByCategory']);

//Get Current user
Route::get('current-user/{id}/details', [UserController::class, 'details']);

                         //END CONTROLLER FRONTEND
Route::get('admin/companies', [\App\Http\Controllers\Admin\CompanyController::class, 'index']);
Route::get('admin/companies/{id}/change-active', [\App\Http\Controllers\Admin\CompanyController::class, 'changeActive']);
Route::get('admin/companies/{id}/change-unActive', [\App\Http\Controllers\Admin\CompanyController::class, 'changeUnActive']);

                        //CONTROLLER ADMIN


                        //END CONTROLLER ADMIN







//Test
Route::get('test',[CategoryController::class, 'test'])->middleware('auth:api');










