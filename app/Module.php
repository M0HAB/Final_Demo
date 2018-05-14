<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'title', 'commitment', 'module_order', 'introduction', 'course_id'
    ];
}
