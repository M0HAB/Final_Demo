<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Reply;
use Auth;

use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname',
        'lname',
        'username',
        'email',
        'password',
        'dep_id',
        'gender',
        'role_id',
        'location',
        'level',
        'gpa',
        'api_token'
    ];
    protected $dates = ['deleted_at'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'updated_at', 'role_id', 'role', 'permission','api_token'
    ];

    public function setFnameAttribute($value)
    {
        return $this->attributes['fname'] = ucfirst($value);
    }

    public function setLnameAttribute($value)
    {
        return $this->attributes['lname'] = ucfirst($value);
    }

    public function isAdmin()
    {
        if (!$this->role == 'admin')
        {
            return false;
        }
        return true;
    }
    public function isInstructor()
    {
      return ($this->role->name == 'Instructor' || $this->role->name == 'instructor');
    }
    public function isStudent()
    {
      return ($this->role->name == 'Student' || $this->role->name == 'student');
    }
    public static function getStudents()
    {
      $role_id = ('App\Role')::where('name', 'student')->first()->id;
      return User::where('role_id', $role_id);
    }
    public static function getInstructors()
    {
      $role_id = ('App\Role')::where('name', 'instructor')->first()->id;
      return User::where('role_id', $role_id);
    }


    public function actionlog()
    {
        return $this->hasMany('App\ActionLog', 'subject_id')->where('subject','user');
    }
    public function adminUserLog()
    {
        return ('App\ActionLog')::where(['type' => 'user', 'type_id' => $this->id]);
    }


  	public function department(){
  		return $this->belongsTo('App\Department', 'dep_id');
    }

    public function role(){
	     return $this->belongsTo('App\Role', 'role_id');
    }

    public function courses()
    {
        if(Auth::guard('admin')->check()){
            if($this->isStudent()){
                return $this->belongsToMany('App\Course', 'course_user', 'user_id', 'course_id')->withTimestamps();
            }else{
                return $this->hasMany('App\Course', 'instructor_id');
            }
        }
        if($this->isStudent()){
            return $this->belongsToMany('App\Course', 'course_user', 'user_id', 'course_id')->where('is_active', 1)->withTimestamps();
        }else{
            return $this->hasMany('App\Course', 'instructor_id');
        }
    }

    //Function to get messages between this user & friend ($friend_id)
    public function messages($friend_id)
    {
      if ($friend_id !== $this->id){
        //Get Sent messages of this user & friend ($friend_id)
        $sent = $this->hasMany('App\Message' , 'user_id')->where('friend_id', $friend_id);
        //Get Received messages of this user & friend ($friend_id)
        $received = $this->hasMany('App\Message' , 'friend_id')->where('user_id', $friend_id);
        //Union Both Sent & received then return the result
        $result = $received->union($sent)->orderBy('created_at', 'asc')->get();
        return $result;
      }else{
        return 0;
      }

    }

    public function msg_list(){
      $sent = $this->hasMany('App\Message', 'user_id')
      ->whereRaw('`messages`.`id` IN (SELECT MAX(`messages`.`id`) FROM `messages` GROUP BY `messages`.`friend_id`)');
      $received = $this->hasMany('App\Message', 'friend_id')
      ->whereRaw('`messages`.`id` IN (SELECT MAX(`messages`.`id`) FROM `messages` GROUP BY `messages`.`user_id`)');
      $result = $received->union($sent)->orderBy('created_at', 'asc')->limit(8);
      return $result;
    }

    public function posts()
    {
      return $this->hasMany('App\Post', 'user_id');
    }
    public function replies()
    {
      return $this->hasMany('App\Reply', 'user_id');
    }
    public function comments()
    {
      return $this->hasMany('App\Comment', 'user_id');
    }
    public function votes()
    {
      return $this->hasMany('App\Vote', 'user_id');
    }
    public function Voted(Reply $reply)
    {
      return (bool) $reply->votes
                          ->where('reply_id', $reply->id)
                          ->where('user_id', $this->id)
                          ->count();
    }

    /*Create a function to check if the user(student OR instructor) is enrolled to a specific course */
    public function checkIfUserTeachCourse($course_id){
        return (bool) DB::table('courses')
            ->leftjoin('users', 'users.id', '=', 'courses.instructor_id')
            ->where('courses.id', '=', $course_id)
            ->where('users.id', '=', $this->id)
            ->count();
    }

    public function checkIfUserEnrolled($course_id){
        return (bool) DB::table('courses')
            ->leftjoin('course_user', 'course_user.course_id', '=', 'courses.id')
            ->leftjoin('users', 'users.id', '=','course_user.user_id')
            ->where('course_user.user_id', '=', $this->id)
            ->where('course_user.course_id', '=', $course_id)
            ->where('course_user.is_passed', '=', 0)
            ->count();
    }

    /*Create a function to check if a student delivered an assignment */
    public function checkIfStudentDeliveredAss(assignment $assignment){
      return (bool)DB::table('assdelivers')
          ->where('ass_id', '=', $assignment->id)
          ->where('user_id', '=', $this->id)
          ->count();
    }

    /*Create a function to check if a student submitted a quiz */
    public function checkIfStudentSubmittedQuiz($quiz){
      return (bool)DB::table('quiz_user')
          ->where('quiz_id', '=', $quiz->id)
          ->where('user_id', '=', $this->id)
          ->count();
    }

    /*Create a function to check if a student assigned to course */
    public function checkIfStudentAssignedToCourse($course_id){
        return (bool) DB::table('course_user')
            ->where('course_id', '=', $course_id)
            ->where('user_id', '=', $this->id)
            ->first();
    }


}
