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

/**
 * --------------------------------------------------------------------------
 * Course Pages View System
 * --------------------------------------------------------------------------
 */
 Route::group(['prefix' => 'user/courses'], function(){

     Route::get('', '\App\Http\Controllers\Courses\Courses_CRUD_Controller@listUserCourses')
         ->name('course.listUserCourses');

     Route::middleware('checkRole:instructor')->get('addNewCourse', '\App\Http\Controllers\Courses\Courses_CRUD_Controller@getNewCourseForm')
         ->name('course.getNewCourseForm');

     Route::middleware('checkRole:instructor')->post('addNewCourse',[
         'uses' => '\App\Http\Controllers\Courses\Courses_CRUD_Controller@addNewCourse',
         'as' => 'course.addNewCourse'
     ]);

     Route::middleware('checkRole:instructor')->get('{id}/update',[
         'uses' => '\App\Http\Controllers\Courses\Courses_CRUD_Controller@getUpdateCourseForm',
         'as' => 'course.getUpdateCourseForm'
     ]);

     Route::middleware('checkRole:instructor')->post('{courseTitle}/update',[
         'uses' => '\App\Http\Controllers\Courses\Courses_CRUD_Controller@updateCourse',
         'as' => 'course.updateCourse'
     ]);

     Route::get('{id}',[
         'uses' => '\App\Http\Controllers\Courses\Modules_CRUD_Controller@viewCourseModules',
         'as' => 'course.viewCourseModules'
     ]);

     Route::post('{course_id}/Modules/{module_id}/lessons',[
         'uses' => '\App\Http\Controllers\Courses\Lessons_CRUD_Controller@loadLessons',
         'as' => 'course.loadLessons'
     ]);

     Route::get('{course_id}/Modules/{module_id}',[
         'uses' => '\App\Http\Controllers\Courses\Lessons_CRUD_Controller@displayLessonsOfModules',
         'as' => 'course.displayLessonsOfModules'
     ]);


     Route::middleware('checkRole:instructor')->get('{id}/addNewModule',[
         'uses' => '\App\Http\Controllers\Courses\Modules_CRUD_Controller@getNewModuleForm',
         'as' => 'course.getNewModuleForm'
     ]);

     Route::middleware('checkRole:instructor')->post('{id}/addNewModule',[
         'uses' => '\App\Http\Controllers\Courses\Modules_CRUD_Controller@addNewModule',
         'as' => 'course.addNewModule'
     ]);

     Route::middleware('checkRole:instructor')->get('{course_id}/modules/{module_id}/addNewVideo',[
         'uses' => '\App\Http\Controllers\Courses\lessons_CRUD_Controller@getNewVideoForm',
         'as' => 'course.addNewVideo'
     ]);

     Route::middleware('checkRole:instructor')->post('{course_id}/modules/{module_id}/addNewVideo',[
         'uses' => '\App\Http\Controllers\Courses\lessons_CRUD_Controller@uploadVideo',
         'as' => 'course.uploadVideo'
     ]);

     Route::middleware('checkRole:instructor')->get('{course_id}/Modules/{module_id}/update',[
         'uses' => '\App\Http\Controllers\Courses\Modules_CRUD_Controller@getUpdateModuleForm',
         'as' => 'course.getUpdateModuleForm'
     ]);

     Route::middleware('checkRole:instructor')->post('{course_id}/Modules/{module_id}/update',[
         'uses' => '\App\Http\Controllers\Courses\Modules_CRUD_Controller@updateModule',
         'as' => 'course.updateModule'
     ]);

 });


