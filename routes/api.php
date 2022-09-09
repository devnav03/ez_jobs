<?php

use Illuminate\Http\Request;

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

Route::any('v1/login', ['as' => 'login','uses' => 'App\Http\Controllers\API\V1\UserController@login']);
Route::any('v1/country', ['as' => 'country','uses' => 'App\Http\Controllers\API\V1\UserController@country']);
Route::any('v1/states', ['as' => 'states','uses' => 'App\Http\Controllers\API\V1\UserController@states']);
Route::any('v1/cities', ['as' => 'cities','uses' => 'App\Http\Controllers\API\V1\UserController@cities']);
Route::any('v1/register', ['as' => 'register','uses' => 'App\Http\Controllers\API\V1\UserController@register']);
Route::any('v1/category', ['as' => 'category','uses' => 'App\Http\Controllers\API\V1\JobController@category']);
Route::any('v1/popular', ['as' => 'popular','uses' => 'App\Http\Controllers\API\V1\JobController@popular']);
Route::any('v1/functional-areas', ['as' => 'functional-areas','uses' => 'App\Http\Controllers\API\V1\JobController@functional_areas']);
Route::any('v1/jobs-by-functional-areas', ['as' => 'jobs-by-functional-areas','uses' => 'App\Http\Controllers\API\V1\JobController@jobs_by_functional_areas']);

Route::any('v1/job-details', ['as' => 'job-details','uses' => 'App\Http\Controllers\API\V1\JobController@job_details']);



Route::any('v1/update-profile', ['as' => 'update-profile','uses' => 'App\Http\Controllers\API\V1\UserController@updateProfile']);

Route::any('v1/update-password', ['as' => 'update-password','uses' => 'App\Http\Controllers\API\V1\UserController@changePassword']);


















