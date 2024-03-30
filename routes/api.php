<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;
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

Route::middleware('api.auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login','App\Http\Controllers\Auth\Auth_ApiController@login');
Route::post('register','App\Http\Controllers\Auth\Auth_ApiController@register');

//categories
Route::group(['prefix' => 'category'], function () {
    Route::get('/', 'App\Http\Controllers\CategoryController@index'); // Get all tasks
    Route::get('/{id}', 'App\Http\Controllers\CategoryController@show'); // Get a specific task
    Route::post('/', 'App\Http\Controllers\CategoryController@store'); // Create a new task
    Route::put('/{id}', 'App\Http\Controllers\CategoryController@update'); // Update a task
    Route::delete('/{id}', 'App\Http\Controllers\CategoryController@destroy'); // Delete a task
  });

//tasks
Route::group(['prefix' => 'tasks'], function () {
    Route::get('/', 'App\Http\Controllers\TaskController@index'); // Get all tasks
    Route::get('/{id}', 'App\Http\Controllers\TaskController@show'); // Get a specific task
    Route::post('/', 'App\Http\Controllers\TaskController@store'); // Create a new task
    Route::put('/{id}', 'App\Http\Controllers\TaskController@update'); // Update a task
    Route::delete('/{id}', 'App\Http\Controllers\TaskController@destroy'); // Delete a task
    Route::get('complete/{id}', 'App\Http\Controllers\TaskController@complete'); // Mark as complete
  });

  //places
Route::post('/places', [PlaceController::class, 'store']);
Route::get('/places', [PlaceController::class, 'index']);
Route::get('/places/{id}', [PlaceController::class, 'show']);
Route::put('/places/{id}', [PlaceController::class, 'update']);
Route::delete('/places/{id}', [PlaceController::class, 'destroy']);

//places category
Route::group(['prefix' => 'place_category'], function () {
    Route::get('/', 'App\Http\Controllers\PlaceCategoryController@index'); // Get all tasks
    Route::get('/{id}', 'App\Http\Controllers\PlaceCategoryController@show'); // Get a specific task
    Route::post('/', 'App\Http\Controllers\PlaceCategoryController@store'); // Create a new task
    Route::put('/{id}', 'App\Http\Controllers\PlaceCategoryController@update'); // Update a task
    Route::delete('/{id}', 'App\Http\Controllers\PlaceCategoryController@destroy'); // Delete a task
  });