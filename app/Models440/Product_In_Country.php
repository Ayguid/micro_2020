<?php

namespace App\Models440;

use Illuminate\Database\Eloquent\Model;
use App\Models440\Country;
use App\Models440\Product;



class Product_In_Country extends Model
{
    //
    protected $table = 'products_in_countries';

    protected $fillable = [
    'product_id', 'country_id'
    ];




    public function country()
    {
      return $this->hasOne(Country::class, 'id', 'country_id');
    }



    public function product()
    {
      return $this->hasOne(Product::class);
    }





}
