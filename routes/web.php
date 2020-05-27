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

use function foo\func;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/payments','PaymentController@index')->name('payments.index');
Route::get('/payments/all','PaymentController@showAll')->name('payments.showAll');
Route::get('/payments/editar/{id}','PaymentController@edit')->name('payments.edit');
Route::get('/payments/detalle/{id}','PaymentController@show')->name('payment.show');
Route::apiResource('payments', 'PaymentController');

Route::get('/concepts','ConceptController@index')->name('concepts.index');
Route::get('/concepts/all','ConceptController@showAll')->name('concepts.showAll');
Route::get('/concepts/editar/{id}','ConceptController@edit')->name('concepts.edit');
Route::get('/concepts/detalle/{id}','ConceptController@show')->name('concepts.show');
Route::apiResource('concepts', 'ConceptController');

Route::get('/instructors','InstrutorController@index')->name('instructors.index');
Route::get('/instructors/all','InstructorController@showAll')->name('instructors.showAll');
Route::get('/instructors/editar/{id}','InstructorController@update')->name('instructors.update');
Route::apiResource('instructors', 'InstructorController');

Route::get('/users','UserController@index')->name('users.index');
Route::get('/users/all','UserController@showAll')->name('users.showAll');
Route::get('/users/editar/{id}','UserController@edit')->name('users.edit');
Route::apiResource('users', 'UserController');


Route::get('/roles','RoleController@index')->name('roles.index');
Route::get('/roles/all','RoleController@showAll')->name('roles.showAll');
Route::get('/roles/editar/{id}','UserController@update')->name('roles.update');
Route::apiResource('roles', 'RoleController');

Route::get('/niveles/agregar/','LevelController@create')->name('levels.create');
Route::get('/niveles/{id}','LevelController@show')->name('levels.details');
Route::get('/niveles/editar/{id}','LevelController@edit')->name('levels.edit');
Route::apiResource('/niveles','LevelController');

Route::get('/cursos/agregar/','CourseController@create')->name('courses.create');
Route::get('/cursos/{id}','CourseController@show')->name('courses.details');
Route::get('/cursos/editar/{id}','CourseController@edit')->name('courses.edit');
Route::apiResource('/cursos','CourseController');

Route::get('/horarios/agregar/','ScheduleController@create')->name('schedules.create');
Route::get('/horarios/{id}','ScheduleController@show')->name('schedules.details');
Route::get('/horarios/editar/{id}','ScheduleController@edit')->name('schedules.edit');
Route::apiResource('/horarios','ScheduleController');

Route::resource('/usuarioscdu','UsersCduController');
Route::resource('/areas','AreaController');
Route::resource('/disciplinas','DisciplineController');

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
