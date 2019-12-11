<?php

namespace App\Models440;

use Illuminate\Database\Eloquent\Model;



class File extends Model
{

  protected $table='files';


  public function fileable()
  {
    return $this->morphTo();
  }

  public function extension()
  {
    return $ext = pathinfo($this->file_path, PATHINFO_EXTENSION);
  }

}
