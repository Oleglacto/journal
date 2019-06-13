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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/lessons', 'LessonsController');

Route::get('/schedule', 'ScheduleController@index')->name('schedule.index');
Route::get('/schedule/by/{user}', 'ScheduleController@getSchedule')->name('schedule.user.schedule');
Route::post('/schedule', 'ScheduleController@store')->name('schedule.store');

Route::get('/users', 'UsersController@index')->name('users.index');
Route::post('/user', 'UsersController@store')->name('users.store');

Route::get('/users/{user}', 'StudentsController@show')->name('users.show');
Route::get('/service-info', 'IndexController@getServiceInformation');

Route::get('/teachers', 'UsersController@getTeachers')->name('teachers.get');
Route::get('/schedule-by-day', 'ScheduleController@getLessonByTeacherAndDay')->name('getSchedule.byDay');
