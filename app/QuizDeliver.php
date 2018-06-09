<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizDeliver extends Model
{

    protected $table = 'quiz_user';

    protected $fillable = [
        'user_id', 'quiz_id', 'grade'
    ];
}
