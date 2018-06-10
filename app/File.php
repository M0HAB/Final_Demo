<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
  protected $table = 'files';
  public $primaryKey = 'id';
  public $timestamps = true;
  protected $fillable = ['relate_id', 'relate_type', 'filename', 'type'];

  public function post()
  {
      return $this->belongsTo('App\Post', 'relate_id');
  }
  public function reply()
  {
      return $this->belongsTo('App\Reply', 'relate_id');
  }
}
