<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
  protected $table = 'discussions';
  public $primaryKey = 'id';
  public $timestamps = true;
  protected $fillable = [
      'course_id'
  ];

  public function posts()
  {
    return $this->hasMany('App\Post', 'discussion_id');
  }
  public function course()
  {
    return $this->belongsTo('App\Course', 'course_id');
  }
}
