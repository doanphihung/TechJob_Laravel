<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MailController;
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
//Auth
Route::post('employer/register', [AuthController::class, 'employerRegister']);
Route::post('seeker/register', [AuthController::class, 'seekerRegister']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::post('verify-email/{confirmationCode}', [AuthController::class, 'verifyEmail']);

//City
Route::resource('cities',CityController::class);

//Language
Route::get('languages',[LanguageController::class, 'getAllLanguage']);

//Company
Route::get('company/{id}/details', [CompanyController::class, 'details']);
Route::post('company/{id}/update', [CompanyController::class, 'update']);
Route::post('company/{id}/post', [CompanyController::class, 'postJob']);
Route::get('company/{id}/list-job', [CompanyController::class, 'listJob']);
Route::get('companies', [CompanyController::class, 'index']);

//Seeker
Route::get('seeker/{id}/details', [SeekerController::class, 'details']);
Route::post('seeker/{id}/update', [SeekerController::class, 'update']);
Route::get('seeker/{id}/jobs-applied', [SeekerController::class, 'getAllJobsApplied']);
Route::get('{id_seeker}/seeker/{id_job}/job', [SeekerController::class, 'apply']);

//Category
Route::get('categories',[CategoryController::class, 'getAll']);

//Job
Route::get('job/{id}/details',[JobController::class, 'findById']);
Route::post('job/{id}/update',[JobController::class, 'update']);

//Get all jobs desc
Route::get('jobs',[JobController::class, 'index']);
Route::get('jobs/5',[JobController::class, 'getFirstFiveJob']);


//search
Route::post('jobs/search-without-city',[JobController::class, 'searchWithoutCity']);
Route::post('jobs/search-with-city',[JobController::class, 'searchWithCity']);
Route::get('jobs/{id}/search-by-category',[JobController::class,'searchByCategory']);
Route::post('jobs/search-by-company',[JobController::class,'searchByCompany']);

Route::post('jobs/search-by-salary',[JobController::class,'searchBySalary']);

//Get Current user
Route::get('current-user/{id}/details', [UserController::class, 'details']);
//Mail
Route::post('forward/{id}/job', [MailController::class, 'forwardJob']);
Route::get('admin/companies', [\App\Http\Controllers\Admin\CompanyController::class, 'index']);
Route::get('admin/companies/{id}/change-active', [\App\Http\Controllers\Admin\CompanyController::class, 'changeActive']);
Route::get('admin/companies/{id}/change-unActive', [\App\Http\Controllers\Admin\CompanyController::class, 'changeUnActive']);
Route::post('admin/create',[CityController::class,'create']);
Route::post('admin/add',[CategoryController::class,'add']);



//Test
Route::get('test',[CategoryController::class, 'test'])->middleware('auth:api');










