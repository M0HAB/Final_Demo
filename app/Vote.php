<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
  protected $table = 'votes';
  public $primaryKey = 'id';
  public $timestamps = true;
  protected $fillable = [
      'reply_id', 'user_id'
  ];

  public function reply()
  {
    return $this->belongsTo('App\Reply', 'reply_id');
  }
  public function user()
  {
    return $this->belongsTo('App\User', 'user_id');
  }
  public function isByInstructor()
  {
    $role = Auth::user()->role->name;
    return $role == 'instructor';
  }
}
