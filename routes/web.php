<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// INDEX
Route::get('/', 'ProjectController@index')->name('index');

// PROJECT TASKS
Route::get('/project/{id}/tasks', 'ProjectController@manage_tasks')->name('manage_tasks');
Route::post('/project/{id}/tasks/arrange', 'ProjectController@arrange_tasks')->name('arrange_tasks');