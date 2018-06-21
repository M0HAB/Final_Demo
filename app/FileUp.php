<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

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
    static::deleted(function($file) {
      $oldname = $file->filename;
      try {
       $file->filename = Storage::putFile('/public/deleted', new File(public_path().$file->filename));
       $file->save();
      } catch (\Exception $e) {
      }
      try {
       unlink(public_path().$oldname);
      } catch (\Exception $e) {
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
