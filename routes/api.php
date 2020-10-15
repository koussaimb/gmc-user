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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('users', 'UserController@index');
Route::get('users/{id}', 'UserController@show');
Route::post('users', 'UserController@store');
Route::put('users/{id}', 'UserController@update');
Route::delete('users/{id}', 'UserController@destroy');

Route::get('tasks', 'TaskController@index');
Route::get('tasks/{id}', 'TaskController@show');
Route::get('tasksByUser/{user_id}', 'TaskController@tasksByUser');
Route::post('tasks', 'TaskController@store');
Route::put('tasks/{id}', 'TaskController@update');
Route::delete('tasks/{id}', 'TaskController@destroy');
