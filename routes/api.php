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
Route::any('v1/latest', ['as' => 'latest','uses' => 'App\Http\Controllers\API\V1\JobController@latest']);


Route::any('v1/functional-areas', ['as' => 'functional-areas','uses' => 'App\Http\Controllers\API\V1\JobController@functional_areas']);
Route::any('v1/jobs-by-functional-areas', ['as' => 'jobs-by-functional-areas','uses' => 'App\Http\Controllers\API\V1\JobController@jobs_by_functional_areas']);
Route::any('v1/job-details', ['as' => 'job-details','uses' => 'App\Http\Controllers\API\V1\JobController@job_details']);
Route::any('v1/job-apply', ['as' => 'job-apply','uses' => 'App\Http\Controllers\API\V1\JobController@job_apply']);
Route::any('v1/save-job', ['as' => 'save-job','uses' => 'App\Http\Controllers\API\V1\JobController@save_job']);
Route::any('v1/applied-job-list', ['as' => 'applied-job-list','uses' => 'App\Http\Controllers\API\V1\JobController@applied_job_list']);
Route::any('v1/saved-job-list', ['as' => 'saved-job-list','uses' => 'App\Http\Controllers\API\V1\JobController@saved_job_list']);
Route::any('v1/candidate-profile-update', ['as' => 'candidate-profile-update','uses' => 'App\Http\Controllers\API\V1\UserController@candidate_profile_update']);
Route::any('v1/employer-profile-update', ['as' => 'employer-profile-update','uses' => 'App\Http\Controllers\API\V1\UserController@employer_profile_update']);
Route::any('v1/live-job-search', ['as' => 'live-job-search','uses' => 'App\Http\Controllers\API\V1\JobController@live_job_search']);
Route::any('v1/job-filter', ['as' => 'job-filter','uses' => 'App\Http\Controllers\API\V1\JobController@job_filter']);
Route::any('v1/update-password', ['as' => 'update-password','uses' => 'App\Http\Controllers\API\V1\UserController@changePassword']);
Route::any('v1/testimonials', ['as' => 'testimonials','uses' => 'App\Http\Controllers\API\V1\UserController@testimonials']);

Route::any('v1/top-companies', ['as' => 'top-companies','uses' => 'App\Http\Controllers\API\V1\UserController@top_companies']);


// Employers API
Route::any('v1/plans', ['as' => 'plans','uses' => 'App\Http\Controllers\API\V1\UserController@plans']);
Route::any('v1/job-posts', ['as' => 'job-posts','uses' => 'App\Http\Controllers\API\V1\UserController@job_posts']);
Route::any('v1/candidates', ['as' => 'candidates','uses' => 'App\Http\Controllers\API\V1\CandidateController@candidates']);
Route::any('v1/candidate-details', ['as' => 'candidate-details','uses' => 'App\Http\Controllers\API\V1\CandidateController@candidate_details']);

Route::any('v1/candidate-filter', ['as' => 'candidate-filter','uses' => 'App\Http\Controllers\API\V1\CandidateController@candidate_filter']);

Route::any('v1/education', ['as' => 'education','uses' => 'App\Http\Controllers\API\V1\UserController@education']);
Route::any('v1/candidate-profile', ['as' => 'candidate-profile','uses' => 'App\Http\Controllers\API\V1\UserController@candidate_profile']);






















