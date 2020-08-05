<?php

namespace App\Models440;

use Illuminate\Database\Eloquent\Model;
use App\Models440\Product_Attribute;


class Attribute extends Model
{
  protected $table='attributes';

  protected $fillable = [
    'category_id',
    'name_es',
    'name_en',
    'name_pt',
    'filterable',
    'type',
    'order'

];





  public function productAttributes()
  {
    return $this->hasMany(Product_Attribute::class);
  }











public function types()
{
  return [
    'string',
    'int',
    'float',
    'date',
    'mail',
    'password',
    'textarea'
  ];
}





}
