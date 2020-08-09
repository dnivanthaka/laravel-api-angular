<?php

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

Route::post('register', 'Api\UserController@register');
Route::post('login', 'Api\UserController@login');

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('logout', 'Api\UserController@logout');
    Route::post('refresh', 'Api\UserController@refresh');
    Route::get('users', 'Api\UserController@getUsers');
    Route::get('user', 'Api\UserController@getCurrentUser');
    Route::get('user/{id}', 'Api\UserController@getUser');
    Route::delete('user/{id}', 'Api\UserController@delete');
    Route::put('user/{id}', 'Api\UserController@update');
    Route::post('user/{id}/password', 'Api\UserController@changePassword');
});

