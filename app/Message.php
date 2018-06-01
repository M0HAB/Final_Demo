<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  protected $table = 'messages';
  public $primaryKey = 'id';
  public $timestamps = true;
  protected $fillable = [
      'user_id', 'friend_id', 'body', 'read'
  ];

  public function sender()
  {
    return $this->hasOne('App\User', 'id', 'user_id');
  }
  public function receiver()
  {
    return $this->hasOne('App\User', 'id', 'friend_id');
  }
}
