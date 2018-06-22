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
        // Route::get('create', 'RegisterController@showRegisterForm')->name('user.regform');
        // Route::post('create', 'RegisterController@register')->name('user.create');
        Route::get('forgot-password', 'ForgotPasswordController@showForgotForm')->name('user.forgot.password');
        Route::post('forgot-password', 'ForgotPasswordController@checkEmail')->name('user.checkreset.email');
        Route::PUT('forgot-password/{id}', 'ResetPasswordController@resetPassword')->name('user.reset.password');
        Route::post('login', 'LoginController@login')->name('user.login');
        Route::post('logout', 'LoginController@logout')->name('user.logout');
    });
    //-- User
    Route::get('dashboard', 'UserDashboardController@dashboard')->name('user.dashboard');
    Route::get('profile', 'UserDashboardController@profile')->name('user.profile');
    Route::get('contactadmin', 'UserDashboardController@contactAdminForm')->name('admin.contact.create');
    Route::post('contactadmin', 'UserDashboardController@contactAdmin')->name('admin.contact.store');
 });

Route::get('/department', 'DepartmentsController@userIndex')->name('user.department.index');
Route::get('/department/{id}', 'DepartmentsController@userShow')->name('user.department.show');
Route::get('/department/{id}/courses', 'DepartmentsController@userGetCourses')->name('user.department.courses');
Route::get('/department/{id}/specializations', 'DepartmentsController@userGetSpecializations')->name('user.department.specializations');

Route::get('/specialization', 'SpecializationController@userIndex')->name('user.specialization.index');
Route::get('/specialization/{id}', 'SpecializationController@userShow')->name('user.specialization.show');
Route::get('/specialization/{id}/courses', 'SpecializationController@userGetCourses')->name('user.specialization.courses');
Route::get('/specialization/{id}/departments', 'SpecializationController@userGetDepartments')->name('user.specialization.departments');
// Route::resource('specialization', 'SpecializationController');


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

     Route::group(['middleware' => ['checkUserEnrollmentInCourse', 'checkCourseActivation']], function(){

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

         Route::middleware('checkRole:instructor')->get('{course}/modules/{module}/addNewFile',[
             'uses' => '\App\Http\Controllers\Courses\lessons_CRUD_Controller@getNewFileForm',
             'as' => 'course.addNewFile'
         ]);

         Route::middleware('checkRole:instructor')->post('{course}/modules/{module}/addNewFile',[
             'uses' => '\App\Http\Controllers\Courses\lessons_CRUD_Controller@uploadFile',
             'as' => 'course.uploadFile'
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

         Route::resource('{course}/gradesBook', 'GradesBookController',['names'=>[

             'index'=>'course.gradeBook.index',
             'create'=>'course.gradeBook.create',
             'store'=>'course.gradeBook.store',
             'edit'=>'course.gradeBook.edit',
             'update'=>'course.gradeBook.update'
         ]]);

         //student grades

         Route::resource('{course}/studentGrades', 'studentGradesController',['names'=>[

             'index'=>'course.studentGrades.index',
             'edit'=>'course.studentGrades.edit',
             'update'=>'course.studentGrades.update',
             'show' =>'course.studentGrades.show',
         ]]);

         Route::get('/{course}/studentGrades/student/{student}', 'studentGradesController@create')->name('course.studentGrades.create');
         Route::post('/{course}/studentGrades/student/{student}', 'studentGradesController@store')->name('course.studentGrades.store');


     });

 });


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
    'update' => 'assignments.update',
    'show'   =>'assignments.show'
], 'middleware' => ['checkUserEnrollmentInCourse', 'checkCourseActivation']]);


Route::group(['prefix' => 'messages'], function () {

  Route::get('/', 'MessagesController@index')->name('messages.index');
  Route::get('/read', 'MessagesController@allRead')->name('messages.read');
  Route::get('/{id}', 'MessagesController@selectMessage')->name('messages.show');

});

Route::group(['middleware' => ['checkUserEnrollmentInCourse', 'checkCourseActivation']], function(){

    Route::get('Courses/{course}/Modules/{module}/assignment/{assignment}/deliver', 'AssignmentsController@deliver')->name('assignment.deliver');
    Route::post('Courses/{course}/Modules/{module}/AssignmentDeliver/', 'AssignmentsController@deliverstore')->name('assignment.deliverstore');
    Route::get('Courses/{course}/Modules/{module}/assignmentDelivered/', 'AssignmentsController@delivered')->name('assignment.delivered');
    Route::get('Courses/{course}/Modules/{module}/assignments/{assignment}/student/{student}/delivered/{assdel}', 'AssignmentsController@deliveredEdit')->name('assignmentdelivered.edit');
    Route::patch('Courses/{course}/Modules/{module}/assignmentDelivered/update/{assdeliver}', array( "as" => "assdelivered.update", "uses" => "AssignmentsController@deliveredUpdate"));

});


Route::get('/error', function(){ return "404"; })->name('error.web');

Route::group(['prefix' => 'discussions'], function () {

  Route::get('/', 'DiscussionController@index')->name('discussion.index');
  Route::get('/{id}', 'DiscussionController@show')->name('discussion.show');
  Route::get('/{id}/search', 'DiscussionController@searchPosts')->name('discussion.search');

});


/**
 * --------------------------------------------------------------------------
 * Quiz Module Routes
 * --------------------------------------------------------------------------
 */

Route::middleware('checkRole:instructor')->post('Quizzes/{quiz}/updateActivation',[
    'uses' => '\App\Http\Controllers\Quizes\Quizes_CRUD_Controller@updateQuizActivation',
    'as' => 'quiz.updateQuizActivation'
]);

Route::group(['prefix' => 'Courses', 'middleware' => ['checkUserEnrollmentInCourse', 'checkCourseActivation']], function(){

    Route::middleware('checkRole:instructor' )->get('{course}/Modules/{module}/addNewQuiz',[
        'uses' => '\App\Http\Controllers\Quizes\Quizes_CRUD_Controller@getNewQuizForm',
        'as' => 'quiz.getNewQuizForm'
    ]);

    Route::middleware('checkRole:instructor')->post('{course}/Modules/{module}/addNewQuiz',[
        'uses' => '\App\Http\Controllers\Quizes\Quizes_CRUD_Controller@addNewQuiz',
        'as' => 'quiz.addNewQuiz'
    ]);

    Route::middleware('checkQuizActivation')->get('{course}/Modules/{module}/Quizzes/{quiz}',[
        'uses' => '\App\Http\Controllers\Quizes\Quizes_CRUD_Controller@getSubmitQuizForm',
        'as' => 'quiz.getSubmitQuizForm'
    ]);

    Route::middleware(['checkQuizActivation', 'checkRole:student'])->post('{course}/Modules/{module}/Quizzes/{quiz}',[
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
      Route::get('messages', 'DashboardController@readMessages')->name('admin.messages');
      Route::get('messages/{id}', 'DashboardController@showMessage')->name('admin.messages.show');
      Route::group(['prefix' => 'users'], function ()
      {
          Route::get('/', 'UserController@index')->name('admin.user.index');
          Route::get('/profile', 'UserController@profile')->name('admin.user.profile');
          Route::get('/edit', 'UserController@edit')->name('admin.user.edit');
          Route::post('/edit', 'UserController@update')->name('admin.user.update');
          Route::get('/create', 'UserController@create')->name('admin.user.create');
          Route::post('/create', 'UserController@store')->name('admin.user.store');
          Route::get('/show', 'UserController@previewAction')->name('admin.user.action');
      });
      Route::get('/create', 'UserController@createAdmin')->name('admin.create');
      Route::post('/create', 'UserController@adminStore')->name('admin.store');
      Route::group(['prefix' => 'courses'], function ()
      {
          Route::get('/', 'courseController@index')->name('admin.course.index');
          Route::get('{course}/assignStudents', 'courseController@assignStudents')->name('admin.course.assignStudents');
          Route::post('{course}/assignStudents', 'courseController@submitAssignStudents')->name('admin.course.submitAssignStudents');
          Route::get('{course}/courseStudents', 'courseController@courseStudents')->name('admin.course.courseStudents');
          Route::delete('{course}/assigns/{assign}', 'courseController@unAssignStudent')->name('admin.course.unAssignStudent');

      });

  });

  Route::resource('department', 'DepartmentsController');
  Route::get('/department/{id}/addspec', 'DepartmentsController@addSpecCreate')->name('department.spec.add');
  Route::post('/department/{id}/addspec', 'DepartmentsController@addSpecStore')->name('department.spec.store');
  Route::get('/department/{id}/courses', 'DepartmentsController@getCourses')->name('department.courses');
  Route::get('/department/{id}/specializations', 'DepartmentsController@getSpecializations')->name('department.specializations');

  Route::get('/specialization/{id}/courses', 'SpecializationController@getCourses')->name('specialization.courses');
  Route::get('/specialization/{id}/departments', 'SpecializationController@getDepartments')->name('specialization.departments');
  Route::resource('specialization', 'SpecializationController');

  Route::resource('/pindex', 'PIndexController', [
      'only' => ['edit', 'update', 'index']
  ]);
  Route::get('/prole/user', 'PermissionRoleController@viewUserPermission')->name('prole.user.view');
  Route::post('/prole/user', 'PermissionRoleController@setUserPermission')->name('prole.user.store');
  Route::resource('/prole', 'PermissionRoleController')->except([
      'destroy'
  ]);

});
use App\User;
Route::get('/insertt', function () {
    $names = ['ahmed', 'mohamed', 'ali', 'abdelrahman', 'mostafa', 'mohab', 'gamal', 'hussein',
              'waref', 'hossam', 'krara', 'mohsen'];
    for ($i=0; $i < 100 ; $i++) {
        $user = new User;
        $user->fname = $names[mt_rand(0,11)];
        $user->lname = $names[mt_rand(0,11)];
        $user->username = $user->fname.'_'.$user->lname.'_'.time();
        $user->email = 'b'.$i.'@a.com';
        $user->dep_id = mt_rand(1,2);
        $user->role_id = mt_rand(1,2);
        $user->password = bcrypt('123456');
        $user->gender = 1;
        $user->location = 'Egypt';
        $user->api_token = str_random(50) . time();
        if($user->role_id == 2){
            $user->level = mt_rand(1,5);
            $user->gpa = mt_rand(2*10,4*10)/10;
        }
        $user->save();
    }
});
