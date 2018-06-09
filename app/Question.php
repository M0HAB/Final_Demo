<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question', 'first_choice', 'second_choice', 'third_choice','fourth_choice', 'correct_choice',
        'question_points', 'quiz_id'
    ];
}
