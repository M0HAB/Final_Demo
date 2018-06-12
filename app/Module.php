<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
<<<<<<< HEAD
  protected $fillable = [
      'title', 'commitment', 'module_order', 'introduction', 'course_id'
  ];
  public function assignments()
  {
      return $this->hasMany('App\assignment');
  }
  public function posts()
  {
      return $this->hasMany('App\post', 'module_id');
  }

=======
    protected $fillable = [
        'title', 'commitment', 'module_order', 'introduction', 'course_id'
    ];

    public function assignments()
    {
        return $this->hasMany('App\assignment');
    }
>>>>>>> course_assignment_module
}
