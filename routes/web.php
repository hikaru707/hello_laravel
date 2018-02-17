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
Route::get('/help',['as' => 'help','uses' =>'StaticPagesController@help']);
Route::get('/about',['as' => 'about','uses' =>'StaticPagesController@about']);
Route::get('/signup',['as' => 'signup','uses' =>'UsersController@create']);
Route::resource('users', 'UsersController');

Route::get('login',['as' => 'login', 'uses' => 'SessionsController@create']);
Route::post('login',['as' => 'login', 'uses' => 'SessionsController@store']);
Route::delete('logout',['as' => 'logout', 'uses' => 'SessionsController@destory']);