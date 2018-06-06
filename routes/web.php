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

Route::group(['prefix' => 'discussions'], function () {

  Route::get('/', 'DiscussionController@index')->name('discussion.index');
  Route::get('/read', 'DiscussionController@allRead')->name('discussion.read');
  Route::get('/{id}', 'DiscussionController@show')->name('discussion.show');

});
use Illuminate\Http\Request;
Route::post('/testquil',function (Request $request)
{
  $details = $request->body;
  $doms = new \domdocument();
  $doms->loadHtml($details, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
  $images = $doms->getelementsbytagname('img');
  //to prevent duplicate images from being stored
  $arr = array();
  foreach ($images as $k => $img) {
    $data = $img->getattribute('src');
    list($type, $data) = explode(';', $data);
    list(, $data) = explode(',', $data);

    $decode_data = base64_decode($data);
    // return $decode_data;
    // return ();
    $size = (strlen($decode_data)/1024);
    if($size > 1024 ){
      return 0;
    }
    return $size;
    $image_name= time().$k.'.png';
    $path = public_path() . '\images\\' . $image_name;
    file_put_contents($path, $decode_data);
    return $image_name;

  }
});
Route::get('/test/{id1}', function($id1){
  echo ('App\Module')::find($_GET['module']);
  echo $id1."    ,".$_GET['type'];
  // echo ('App\Department')::find(1)->getStudents()->get();
  // $Instructors = ('App\User')::getInstructors()->get();
  // foreach ($Instructors as $inst) {
  //   echo $inst->fname;
  // }


  //
  // if (('App\User')::find(2)->isInstructor()){
  //   echo "true";
  // }else{
  //   echo "false";
  // }
  // $discussion = ('App\Discussion')::find(1);
  // $course = $discussion->course;
  // $modules = $course->modules;
  // $id =  $modules->where('module_order', 1)->first();
  // $posts = $id->posts->where('id', 1)->first();
  // echo $posts->replies;


  // $module = ('App\Module')::find($id)->posts;
  // foreach ($module as $post) {
  //   echo $post->replies;
  // }
  // echo $module->posts();


  // echo ('App\Role')::where('name', 'instructor')->first()->id;
  // $votes =  ('App\Reply')::find(1)->whoVerified;
  // foreach ($votes as $vote) {
  //   if($vote->user->id == ('App\Role')::where('name', 'instructor')->first()->id)
  //   echo $vote->user->fname."<br/>";
  // }
  // $users =  ('App\Reply')::find(1)->whoApproved();
  // if($users){
  //   foreach ($users as $user) {
  //     echo $user->id;
  //   }
  // }else{
  //   echo "not verified";
  // }


  // echo Auth::user()->role->name == "Instructor";
});
