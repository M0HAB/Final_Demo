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
Route::get('mohab', 'TestController@index')->name('test');

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

/**
 * --------------------------------------------------------------------------
 * Course Pages View System
 * --------------------------------------------------------------------------
 */
 Route::group(['prefix' => 'Courses'], function(){

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

         //grades book

     Route::resource('{course_id}/gradesBook', 'GradesBookController',['names'=>[

         'index'=>'course.gradeBook.index',
         'create'=>'course.gradeBook.create',
         'store'=>'course.gradeBook.store',
         'edit'=>'course.gradeBook.edit',
         'update'=>'course.gradeBook.update'
     ]]);

     //student grades

     Route::resource('{course_id}/studentGrades', 'studentGradesController',['names'=>[

         'index'=>'course.studentGrades.index',
         'edit'=>'course.studentGrades.edit',
         'update'=>'course.studentGrades.update',
         'show' =>'course.studentGrades.show'
     ]]);




 });

Route::resource('department', 'DepartmentsController');


Route::resource('Courses/{course_id}/Modules/{module_id}/assignments', 'AssignmentsController',['names'=>[

    'index'=>'assignments.index',
    'create'=>'assignments.create',
    'store'=>'assignments.store',
    'edit'=>'assignments.edit',
    'destroy' => 'assignments.destroy',
    'update' => 'assignments.update'
]]);

Route::get('Courses/{course_id}/Modules/{module_id}/assignment/{id}/deliver', 'AssignmentsController@deliver')->name('assignment.deliver');
Route::post('Courses/{course_id}/Modules/{module_id}/AssignmentDeliver/', 'AssignmentsController@deliverstore')->name('assignment.deliverstore');
Route::get('Courses/{course_id}/Modules/{module_id}/assignmentDelivered/', 'AssignmentsController@delivered')->name('assignment.delivered');

Route::get('assginment/{assginment_id}/student/{std_id}/delivered/{assdel_id}', 'AssignmentsController@deliveredEdit')->name('assignmentdelivered.edit');
Route::patch('assignmentDelivered/update/{id}', array( "as" => "assdelivered.update", "uses" => "AssignmentsController@deliveredUpdate"));


