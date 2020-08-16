<?php

use Illuminate\Support\Facades\Route;

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
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::post('/user/forgot-password', [
    'as'    => 'user-password-forgot-post',
    'uses'  => 'PasswordController@forgotEmail',
]);

Route::get('/user/recover/{code}', [
    'as'    => 'user-recover',
    'uses'  => 'PasswordController@getRecover',
]);

Route::get('/', 'HomeController@index')->name('home');

Route::get('participate/{id}', 'ParticipationController@detail')->name('participate')->middleware('auth');

Route::get('shuffle/{id}', 'ParticipationController@shuffle')->name('shuffle')->middleware('auth');

Route::get('participations','ParticipationController@index')->name('participations')->middleware('auth');

Route::get('logout', 'Auth\LoginController@logout');
