<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Specialization extends Model
{
    use SoftDeletes;
    protected $table = 'specializations';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'name',
    ];
    protected $dates = ['deleted_at'];

    public function departments()
    {
        return $this->belongsToMany('App\Department', 'department_specialization', 'spec_id', 'dep_id');
    }
    public function courses()
    {
        return $this->hasMany('App\Course', 'course_specialization');
    }
}
