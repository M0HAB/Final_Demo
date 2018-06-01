<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'permissions';    
    public $primaryKey = 'index';
    public $timestamps = true;
    protected $fillable = [
        'name'
    ];


    
}
