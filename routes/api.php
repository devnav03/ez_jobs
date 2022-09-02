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
Route::any('v1/punch', ['as' => 'punch','uses' => 'App\Http\Controllers\API\V1\UserController@punch']);
Route::any('v1/punch-list', ['as' => 'punch-list','uses' => 'App\Http\Controllers\API\V1\UserController@punch_list']);

Route::any('v1/update-profile', ['as' => 'update-profile','uses' => 'App\Http\Controllers\API\V1\UserController@updateProfile']);

Route::any('v1/update-password', ['as' => 'update-password','uses' => 'App\Http\Controllers\API\V1\UserController@changePassword']);

Route::any('v1/reports', ['as' => 'reports','uses' => 'App\Http\Controllers\API\V1\UserController@reports']);
















