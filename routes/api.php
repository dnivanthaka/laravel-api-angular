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
    Route::get('logout', 'Api\UserController@logout');
    Route::get('refresh', 'Api\UserController@refresh');
    Route::get('user/{id}', 'Api\UserController@getUser');
    Route::delete('user/{id}', 'Api\UserController@delete');
    Route::put('user/{id}', 'Api\UserController@update');
    Route::put('user/{id}/password', 'Api\UserController@changePassword');
});

