<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{
  use SoftDeletes;
  protected $table = 'replies';
  public $primaryKey = 'id';
  public $timestamps = true;
  protected $fillable = [
      'post_id', 'user_id', 'approved', 'body'
  ];
  protected $dates = ['deleted_at'];
  public function photos()
  {
    return $this->hasMany('App\Photo', 'type_id')->where('type', 'reply');
  }
  public function post()
  {
    return $this->belongsTo('App\Post', 'post_id');
  }
  public function user()
  {
    return $this->belongsTo('App\User', 'user_id');
  }
  public function votes()
  {
    return $this->hasMany('App\Vote', 'reply_id');
  }
  public function comments()
  {
    return $this->hasMany('App\Comment', 'reply_id');
  }

  public function whoApproved()
  {
    if($this->approved == true){
      //get the votes Object
      $votes = $this->votes;
      //init an empty array
      $approvers = array();
      //loop on votes Object
      foreach ($votes as $vote ) {
        //check if the vote user is an instructor if he is add user object into array
        if($vote->user->isInstructor()){
            array_push($approvers,$vote->user);
          }
      }
      //return array
      return $approvers;
      //to call use the whoApproved() because it returns an array not a class;
    }
    return [];
    //return empty array to get to count of 0 on call

  }

}
