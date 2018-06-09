<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pindex extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'pindexes';
    public $primaryKey = 'index';
    public $timestamps = true;
    protected $fillable = [
        'name'
    ];



}
