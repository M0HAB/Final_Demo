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

/**
 * --------------------------------------------------------------------------
 * Course Module Routes
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

     Route::middleware('checkRole:instructor')->get('{course}/update',[
         'uses' => '\App\Http\Controllers\Courses\Courses_CRUD_Controller@getUpdateCourseForm',
         'as' => 'course.getUpdateCourseForm'
     ]);

     Route::middleware('checkRole:instructor')->post('{course}/update',[
         'uses' => '\App\Http\Controllers\Courses\Courses_CRUD_Controller@updateCourse',
         'as' => 'course.updateCourse'
     ]);

     Route::get('{course}',[
         'uses' => '\App\Http\Controllers\Courses\Modules_CRUD_Controller@viewCourseModules',
         'as' => 'course.viewCourseModules'
     ]);

     Route::post('{course}/Modules/{module}/lessons',[
         'uses' => '\App\Http\Controllers\Courses\Lessons_CRUD_Controller@loadLessons',
         'as' => 'course.loadLessons'
     ]);

     Route::get('{course}/Modules/{module}',[
         'uses' => '\App\Http\Controllers\Courses\Lessons_CRUD_Controller@displayLessonsOfModules',
         'as' => 'course.displayLessonsOfModules'
     ]);


     Route::middleware('checkRole:instructor')->get('{course}/addNewModule',[
         'uses' => '\App\Http\Controllers\Courses\Modules_CRUD_Controller@getNewModuleForm',
         'as' => 'course.getNewModuleForm'
     ]);

     Route::middleware('checkRole:instructor')->post('{course}/addNewModule',[
         'uses' => '\App\Http\Controllers\Courses\Modules_CRUD_Controller@addNewModule',
         'as' => 'course.addNewModule'
     ]);

     Route::middleware('checkRole:instructor')->get('{course}/modules/{module}/addNewVideo',[
         'uses' => '\App\Http\Controllers\Courses\lessons_CRUD_Controller@getNewVideoForm',
         'as' => 'course.addNewVideo'
     ]);

     Route::middleware('checkRole:instructor')->post('{course}/modules/{module}/addNewVideo',[
         'uses' => '\App\Http\Controllers\Courses\lessons_CRUD_Controller@uploadVideo',
         'as' => 'course.uploadVideo'
     ]);

     Route::middleware('checkRole:instructor')->get('{course}/Modules/{module}/update',[
         'uses' => '\App\Http\Controllers\Courses\Modules_CRUD_Controller@getUpdateModuleForm',
         'as' => 'course.getUpdateModuleForm'
     ]);

     Route::middleware('checkRole:instructor')->post('{course}/Modules/{module}/update',[
         'uses' => '\App\Http\Controllers\Courses\Modules_CRUD_Controller@updateModule',
         'as' => 'course.updateModule'
     ]);
     Route::middleware('checkRole:instructor')->post('{course}/updateActivation',[
         'uses' => '\App\Http\Controllers\Courses\Courses_CRUD_Controller@updateCourseActivation',
         'as' => 'course.updateCourseActivation'
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


/**
 * --------------------------------------------------------------------------
 * Assignment Module Routes
 * --------------------------------------------------------------------------
 */

Route::resource('Courses/{course}/Modules/{module}/assignments', 'AssignmentsController',['names'=>[

    'index'=>'assignments.index',
    'create'=>'assignments.create',
    'store'=>'assignments.store',
    'edit'=>'assignments.edit',
    'destroy' => 'assignments.destroy',
    'update' => 'assignments.update'
]]);

Route::get('/assignment/{id}', 'AssignmentsController@deliver')->name('assignment.deliver');
Route::post('/AssignmentDeliver/', 'AssignmentsController@deliverstore')->name('assignment.deliverstore');
Route::get('/assignmentDelivered/', 'AssignmentsController@delivered')->name('assignment.delivered');


Route::group(['prefix' => 'messages'], function () {

  Route::get('/', 'MessagesController@index')->name('messages.index');
  Route::get('/read', 'MessagesController@allRead')->name('messages.read');
  Route::get('/{id}', 'MessagesController@selectMessage')->name('messages.show');

});
Route::get('/error', function(){ return "404"; })->name('error.web');

Route::group(['prefix' => 'discussions'], function () {

  Route::get('/', 'DiscussionController@index')->name('discussion.index');
  Route::get('/{id}', 'DiscussionController@show')->name('discussion.show');
  Route::get('/{id}/search', 'DiscussionController@searchPosts')->name('discussion.search');

});

Route::get('Courses/{course}/Modules/{module}/assignment/{assignment}/deliver', 'AssignmentsController@deliver')->name('assignment.deliver');
Route::post('Courses/{course}/Modules/{module}/AssignmentDeliver/', 'AssignmentsController@deliverstore')->name('assignment.deliverstore');
Route::get('Courses/{course}/Modules/{module}/assignmentDelivered/', 'AssignmentsController@delivered')->name('assignment.delivered');

Route::get('assginment/{assginment_id}/student/{std_id}/delivered/{assdel_id}', 'AssignmentsController@deliveredEdit')->name('assignmentdelivered.edit');
Route::patch('assignmentDelivered/update/{id}', array( "as" => "assdelivered.update", "uses" => "AssignmentsController@deliveredUpdate"));


/**
 * --------------------------------------------------------------------------
 * Quiz Module Routes
 * --------------------------------------------------------------------------
 */
Route::group(['prefix' => 'Courses'], function(){
    Route::middleware('checkRole:instructor')->get('{course}/Modules/{module}/addNewQuiz',[
        'uses' => '\App\Http\Controllers\Quizes\Quizes_CRUD_Controller@getNewQuizForm',
        'as' => 'quiz.getNewQuizForm'
    ]);

    Route::middleware('checkRole:instructor')->post('{course}/Modules/{module}/addNewQuiz',[
        'uses' => '\App\Http\Controllers\Quizes\Quizes_CRUD_Controller@addNewQuiz',
        'as' => 'quiz.addNewQuiz'
    ]);

    Route::middleware('checkRole:student')->get('{course}/Modules/{module}/Quizzes/{quiz}',[
        'uses' => '\App\Http\Controllers\Quizes\Quizes_CRUD_Controller@getSubmitQuizForm',
        'as' => 'quiz.getSubmitQuizForm'
    ]);

    Route::middleware('checkRole:student')->post('{course}/Modules/{module}/Quizzes/{quiz}',[
        'uses' => '\App\Http\Controllers\Quizes\Quizes_CRUD_Controller@submitQuizAnswer',
        'as' => 'quiz.submitQuizAnswer'
    ]);
});

Route::group(['prefix' => 'admin'], function () {
  //-- Authentications
  Route::namespace('Admin')->group(function() {
      Route::get('/', 'LoginController@index')->name('admin.index');
      Route::post('login', 'LoginController@login')->name('admin.login');
      Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');
      Route::post('logout', 'LoginController@logout')->name('admin.logout');
      Route::get('logout', 'LoginController@logout')->name('admin.logout.web');
      Route::get('profile', 'DashboardController@profile')->name('admin.profile');
      Route::resource('/pindex', 'PIndexController', [
          'only' => ['edit', 'update', 'index']
      ]);
      Route::resource('/prole', 'PermissionRoleController')->except([
          'destroy'
      ]);
  });


});
