<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
  protected $fillable = ['type_id', 'type', 'filename'];

  public function post()
  {
      return $this->belongsTo('App\Post', 'type_id');
  }
  public function reply()
  {
      return $this->belongsTo('App\Reply', 'type_id');
  }
}
