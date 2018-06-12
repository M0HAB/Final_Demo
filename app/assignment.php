<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assignment extends Model
{
    protected $fillable = [
        'title', 'description','file','	deadline','	module_id','full_mark'
    ];

    public function assdeliver(){

        return $this->hasMany('App\assdeliver','ass_id');   //one to many relationship


    }
}
