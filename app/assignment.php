<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assignment extends Model
{
    protected $fillable = [
        'title', 'description','file','	deadline','	module_id'
    ];
}
