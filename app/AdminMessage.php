<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminMessage extends Model
{
    protected $guard = 'admin';
    protected $table = 'admin_messages';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'user_id', 'subject', 'body'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
