<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'title', 'deadline', 'is_active','module_id', 'total_grade'
    ];
    protected $hidden = ['created_at', 'updated_at'];

}
