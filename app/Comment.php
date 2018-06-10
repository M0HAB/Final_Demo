<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  protected $table = 'comments';
  public $primaryKey = 'id';
  public $timestamps = true;
  protected $fillable = [
      'reply_id', 'user_id', 'body'
  ];

  public function reply()
  {
    return $this->belongsTo('App\Reply', 'reply_id');
  }
  public function user()
  {
    return $this->belongsTo('App\User', 'user_id');
  }

}
