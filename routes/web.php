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

Route::post('login',"user_controller@login");
Route::post('register', "user_controller@registerUser");
Route::get('user/search', "user_controller@searchUser");
Route::post('user', "user_controller@getUser");
Route::post('user/follow', "user_controller@followResponder");
Route::post('content/contentbaseresponder', "content_controller@getContentBaseResponder");
Route::post('content/contentuser', "content_controller@getContentBaseUserFollow");
Route::post('content/insertcontent', "content_controller@insertContent");