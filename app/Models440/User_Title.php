<?php

namespace App\Models440;

use Illuminate\Database\Eloquent\Model;

class User_Title extends Model
{
  protected $table='user_titles';

  protected $fillable = [
    'user_id',
    'title_id',
    'country_id',
    'contactable'
];


}
