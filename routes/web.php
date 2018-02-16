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


/**
 * --------------------------------------------------------------------------
 * Public Pages
 * --------------------------------------------------------------------------
 */
Route::get('/', 'PagesController@index')->name('index');
Route::get('about', 'PagesController@about')->name('about');
Route::get('contact-us', 'PagesController@contact_us')->name('contact_us');

/**
 * --------------------------------------------------------------------------
 * User Authentication System
 * --------------------------------------------------------------------------
 */

 Route::group(['prefix' => 'user'], function () {
    Route::get('create', '_Auth\RegisterController@showRegisterForm')->name('user.regform');
    Route::post('create', '_Auth\RegisterController@register')->name('user.create');
    Route::post('login', '_Auth\LoginController@login')->name('user.login');
    Route::post('logout', '_Auth\LoginController@logout')->name('user.logout');
    Route::get('dashboard', 'UserDashboardController@dashboard')->name('user.dashboard');
 });


