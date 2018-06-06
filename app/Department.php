<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'departments';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'name', 'Dep_Head_ID',
    ];


    public function users(){
        return $this->hasMany('App\User', 'dep_id');
    }
    public function getStudents()
    {
      $role_id = ('App\Role')::where('name', 'student')->first()->id;
      return $this->users()->where('role_id', $role_id);
    }
}
