<?php

namespace App\Models440;

use Illuminate\Database\Eloquent\Model;
use App\Models440\Attribute;
use App\Models440\Product;



class Product_Attribute extends Model
{

    protected $table='products_attributes';

    protected $fillable = [
    'product_id', 'attribute_id', 'value', 'sequence'
    ];


    public function product()
    {
      return $this->belongsTo(Product::class);
    }


    public function attribute()
    {
      return $this->belongsTo(Attribute::class);
    }


    // public function uniquePossibleValues($catId, $ctyId, $prods=null)
    // {
    //   return $this->where('attribute_id', $this->attribute_id)
    //   ->join('products', 'products.id', '=', 'products_attributes.product_id')
    //   ->where('products.category_id', '=', $catId)
    //   ->join('products_in_countries', 'products.id', '=', 'products_in_countries.product_id')
    //   ->where('products_in_countries.country_id', '=',  $ctyId)->select('products_attributes.*')->orderBy('value')
    //   ->get()->unique('value');
    //   $this->active=false;
    // }



}
