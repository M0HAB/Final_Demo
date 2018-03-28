<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assdeliver extends Model
{

    protected $fillable = [
        'answer', 'file	','user_id','ass_id'
    ];

    public function assignment(){


        return $this->belongsTo('App\assignment','ass_id');

    }
    public function student(){


        return $this->belongsTo('App\User');

    }

}
