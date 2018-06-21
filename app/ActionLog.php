<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    protected $table = 'action_log';
    public $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'subject', 'subject_id', 'action', 'type', 'type_id', 'object', 'object_id'
    ];
}
