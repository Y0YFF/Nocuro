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

Route::get('/', 'TopController')->name('top');
Route::get('/trm', 'TrmController')->name('trm');
Route::get('/pvy','PvyController')->name('pvy');

Route::get('/courses', 'CourseController@index')->name('courses.index');
Route::get('/courses/{course}', 'CourseController@show')->name('courses.show');
Route::get('/courses/create', 'CourseController@create')->name('courses.create');
Route::get('/courses/{course}/edit', 'CourseController@edit')->name('courses.edit');
Route::post('/courses', 'CourseController@store')->name('courses.store');
Route::delete('/courses/{course}', 'CourseController@delete')->name('courses.delete');   
Route::post('/courses/{course}/bookmark', 'CourseController@bookmark')->name('courses.bookmark');

Route::post('/lessons/{id}/check', 'LessonController@check')->name('lessons.check');

Route::get('/users/{user}', 'UserController@show')->name('users.show');


Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/login/twitter', 'Auth\SocialAccountController@redirectToProvider')->name('twitter.auth');
Route::get('/login/twitter/callback', 'Auth\SocialAccountController@handleProviderCallback')->name('twitter.oauthCallback');

Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register')->name('register');

Route::get('/admin', 'AdminController@index')->name('admins.index');
Route::post('/admin/popular', 'AdminController@addPopularCourse')->name('admins.addPopularCourse');
Route::get('/admin/login', 'Auth\LoginController@showAdminLoginForm')->name('admins.login');
Route::post('/admin/login', 'Auth\LoginController@adminLogin');
Route::post('/admin/logout', 'Auth\LoginController@adminLogout')->name('admins.logout');

