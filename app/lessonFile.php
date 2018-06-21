<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lessonFile extends Model
{
    protected $fillable = [
        'title', 'description', 'path', 'module_id'
    ];
    protected $hidden = ['created_at', 'updated_at'];

}
