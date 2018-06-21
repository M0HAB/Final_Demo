<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'title', 'description', 'recap', 'privacy', 'url','module_id'
    ];
    protected $hidden = ['created_at', 'updated_at'];

}
