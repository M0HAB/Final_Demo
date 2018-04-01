<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission_role_default extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'permissions_role_default';
    public $timestamps = true;
    protected $fillable = [
        'role','permission',
    ];

}
