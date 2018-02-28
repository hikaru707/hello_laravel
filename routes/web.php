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

Route::get('/', ['as' => 'home','uses' => 'StaticPagesController@home']);
Route::get('help',['as' => 'help','uses' =>'StaticPagesController@help']);
Route::get('about',['as' => 'about','uses' =>'StaticPagesController@about']);


Route::resource('users', 'UsersController');

Route::get('login',['as' => 'login', 'uses' => 'SessionsController@create']);
Route::post('login',['as' => 'login', 'uses' => 'SessionsController@store']);
Route::delete('logout',['as' => 'logout', 'uses' => 'SessionsController@destory']);

Route::get('signup',['as' => 'signup','uses' =>'UsersController@create']);
Route::get('signup/confirm/{token}',['as' => 'confirm_email', 'uses' => 'UsersController@confirmEmail']);

Route::get('pasword/reset',['as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/email',['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset/{token}',['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
Route::post('password/reset',['as' => 'password.update', 'uses' => 'Auth\ResetPasswordController@reset']);