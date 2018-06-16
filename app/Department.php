<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;
    protected $table = 'departments';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'name', 'Dep_Head_ID',
    ];
    protected $dates = ['deleted_at'];

    public function users(){
        return $this->hasMany('App\User', 'dep_id');
    }
    public function getStudents()
    {
      $role_id = ('App\Role')::where('name', 'student')->first()->id;
      return $this->users()->where('role_id', $role_id);
    }
    public function courses()
    {
        return $this->hasMany('App\Course', 'course_department');
    }
    public function specializations()
    {
        return $this->belongsToMany('App\Specialization','department_specialization', 'dep_id', 'spec_id');
    }
}
