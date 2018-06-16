<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
  protected $fillable = [
      'code', 'title', 'description', 'course_language', 'start_date', 'end_date',
      'course_specialization',  'commitment', 'course_department',
      'how_to_pass','instructor_id'
  ];
  public function modules()
  {
    return $this->hasMany('App\Module', 'course_id');
  }
	public function setTitleAttribute($value)
	{
		return $this->attributes['title'] = ucfirst($value);
	}

  public function department()
  {
      return $this->belongsTo('App\Department', 'course_department');
  }
  public function specialization()
  {
      return $this->belongsTo('App\Specialization', 'course_specialization');
  }
  public function instructor()
  {
      return $this->belongsTo('App\User','instructor_id');
  }

}
