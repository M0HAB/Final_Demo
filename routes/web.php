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

Route::resource('department', 'DepartmentsController');


Route::resource('assignments', 'AssignmentsController',['names'=>[

    'index'=>'assignments.index',
    'create'=>'assignments.create',
    'store'=>'assignments.store',
    'edit'=>'assignments.edit',
]]);
Route::get('/assignment/{id}', 'AssignmentsController@deliver')->name('assignment.deliver');
Route::post('/AssignmentDeliver/', 'AssignmentsController@deliverstore')->name('assignment.deliverstore');
Route::get('/assignmentDelivered/', 'AssignmentsController@delivered')->name('assignment.delivered');
Route::resource('/permission', 'PermissionController', [
    'only' => ['edit', 'update', 'index']
]);
Route::resource('/prole', 'PermissionRoleController');
// Route::get('/test2', 'MessagesController@latestMessages');
// Route::get('/test/{id}', function($id){
//   // $message = ('App\Message')::find($id);
//   // $a = $message->user_id;
//   // $b = $message->friend_id;
//   // $channel = array($a,$b);
//   // sort($channel);
//   // return $channel[0].$channel[1];
//   return Auth::user()->latestWithFriend($id);
// });
// Route::get('test1', function(){
//   $message = ('App\Message')::find(9);
//   broadcast(new MessageEvent($message));
// });
Route::group(['prefix' => 'messages'], function () {

  Route::get('/', 'MessagesController@index')->name('messages.index');
  Route::get('/read', 'MessagesController@allRead')->name('messages.read');
  Route::get('/{id}', 'MessagesController@selectMessage')->name('messages.show');

});
