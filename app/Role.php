<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'roles';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'name', 'permission'
    ];

    public function getNameAttribute($value) {
        return ucfirst($value);
    }

    public function user(){
        return $this->hasMany('App\User');
    }

}
