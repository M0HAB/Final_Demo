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


    public function user(){
        return $this->hasMany('App\User');
}
}
