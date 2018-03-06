<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\User;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname',
        'lname',
        'username',
        'email',
        'password',
        'dep_id',
        'gender',
        'role',
        'location',
        'level',
        'gpa',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setFnameAttribute($value)
    {
        return $this->attributes['fname'] = ucfirst($value);
    }

    public function setLnameAttribute($value)
    {
        return $this->attributes['lname'] = ucfirst($value);
    }


    public function isAdmin()
    {
        if (!$this->role == 'admin') 
        {
            return false;
        }
        return true;
    }
	
	public function department(){
		return $this->belongsTo('App\Department');
    }
}
