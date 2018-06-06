<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  protected $table = 'posts';
  public $primaryKey = 'id';
  public $timestamps = true;
  protected $fillable = [
      'discussion_id', 'user_id', 'module_id', 'title', 'body'
  ];

  public function discussion()
  {
    return $this->belongsTo('App\Discussion', 'discussion_id');
  }
  public function user()
  {
    return $this->belongsTo('App\User', 'user_id');
  }
  public function module()
  {
    return $this->belongsTo('App\Module', 'module_id');
  }
  public function replies()
  {
    return $this->hasMany('App\Reply', 'post_id')->orderBy('approved','desc');
  }
}
