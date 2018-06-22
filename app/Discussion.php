<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Discussion extends Model
{
  use SoftDeletes;
  protected $table = 'discussions';
  public $primaryKey = 'id';
  public $timestamps = true;
  protected $fillable = [
      'course_id'
  ];
  protected $dates = ['deleted_at'];
  protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
  public function posts()
  {
    return $this->hasMany('App\Post', 'discussion_id');
  }
  public function course()
  {
    return $this->belongsTo('App\Course', 'course_id');
  }
}
