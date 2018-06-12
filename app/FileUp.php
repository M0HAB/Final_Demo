<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class FileUp extends Model
{
  use SoftDeletes;
  protected $table = 'files';
  public $primaryKey = 'id';
  public $timestamps = true;
  protected $fillable = ['relate_id', 'relate_type', 'filename', 'type'];
  protected $dates = ['deleted_at'];
  protected static function boot()
  {
    parent::boot();
    static::deleting(function($files) {
       foreach ($files as $file) {
          $url = URL::to('/').$file->$filename;
          $contents = file_get_contents($url);
          $name = substr($url, strrpos($url, '/') + 1);
          Storage::disk('local')->put($name, $contents);
          $file->delete();
       }
    });
  }
  public function post()
  {
      return $this->belongsTo('App\Post', 'relate_id');
  }
  public function reply()
  {
      return $this->belongsTo('App\Reply', 'relate_id');
  }
}
