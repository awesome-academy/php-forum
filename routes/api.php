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

Route::post('login', 'Admin\Api\AuthController@login');
Route::get('profile', 'Admin\Api\AuthController@me');
Route::resource('users', 'Admin\Api\UserController')->except(['edit', 'create']);
Route::resource('tags', 'Admin\Api\TagController')->except(['edit', 'create']);
