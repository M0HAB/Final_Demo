<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
  protected $table = 'replies';
  public $primaryKey = 'id';
  public $timestamps = true;
  protected $fillable = [
      'post_id', 'user_id', 'approved', 'body'
  ];

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
  public function voteCount()
  {
    return $this->hasMany('App\Vote', 'reply_id')->count();
  }
  public function whoVerified()
  {
    $votes = $this->votes;
    $verifiers = array();
    foreach ($votes as $vote) {
      if($vote->user->role_id == ('App\Role')::where('name', 'instructor')->id){
        $verifiers.push($vote->user);
      }
    }
    return $verifiers;
  }

}
