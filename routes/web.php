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

Route::get('/', 'PagesController@index')->middleware(['guest', 'revalidate'])->name('index');
Route::get('about', 'PagesController@about')->name('about');
Route::get('contact-us', 'PagesController@contact_us')->name('contact_us');
Route::get('test', function() {return view('design.test');});
Route::get('test/result', function() {return view('design.result');});
Route::get('replies', function() {return view('design.discussion_replies');});
Route::get('/test2', function(){
  echo URL::to('/');
});

/**
 * --------------------------------------------------------------------------
 * User Authentication System & Related Views <-> Controller
 * --------------------------------------------------------------------------
 */

 Route::group(['prefix' => 'user'], function () {
    //-- Authentications
    Route::namespace('_Auth')->group(function() {
        Route::get('create', 'RegisterController@showRegisterForm')->name('user.regform');
        Route::post('create', 'RegisterController@register')->name('user.create');
        Route::get('forgot-password', 'ForgotPasswordController@showForgotForm')->name('user.forgot.password');
        Route::post('forgot-password', 'ForgotPasswordController@checkEmail')->name('user.checkreset.email');
        Route::PUT('forgot-password/{id}', 'ResetPasswordController@resetPassword')->name('user.reset.password');
        Route::post('login', 'LoginController@login')->name('user.login');
        Route::post('logout', 'LoginController@logout')->name('user.logout');
    });
    //-- User
    Route::get('dashboard', 'UserDashboardController@dashboard')->name('user.dashboard');
    Route::get('profile', 'UserDashboardController@profile')->name('user.profile');
 });

Route::resource('departments', 'DepartmentsController');


Route::resource('assignments', 'AssignmentsController',['names'=>[

    'index'=>'assignments.index',
    'create'=>'assignments.create',
    'store'=>'assignments.store',
    'edit'=>'assignments.edit',
]]);
Route::get('/assignment/{id}', 'AssignmentsController@deliver')->name('assignment.deliver');
Route::post('/AssignmentDeliver/', 'AssignmentsController@deliverstore')->name('assignment.deliverstore');
Route::get('/assignmentDelivered/', 'AssignmentsController@delivered')->name('assignment.delivered');
Route::resource('/pindex', 'PIndexController', [
    'only' => ['edit', 'update', 'index']
]);
Route::resource('/prole', 'PermissionRoleController')->except([
    'destroy'
]);

Route::group(['prefix' => 'messages'], function () {

  Route::get('/', 'MessagesController@index')->name('messages.index');
  Route::get('/read', 'MessagesController@allRead')->name('messages.read');
  Route::get('/{id}', 'MessagesController@selectMessage')->name('messages.show');

});
Route::get('/error', function(){ return "error"; })->name('error.web');

Route::group(['prefix' => 'discussions'], function () {

  Route::get('/', 'DiscussionController@index')->name('discussion.index');
  Route::get('/{id}', 'DiscussionController@show')->name('discussion.show');
  Route::get('/{id}/search', 'DiscussionController@searchPosts')->name('discussion.search');

});
Route::get('/test3', function () {
  echo ('App\Post')::find(123);
});
