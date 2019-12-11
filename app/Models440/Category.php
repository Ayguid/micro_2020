<?php

namespace App\Models440;

use Illuminate\Database\Eloquent\Model;
use App\Models440\Product;
use App\Models440\Attribute;


class Category extends Model
{

    protected $table = 'categories';

    protected $fillable = [
    'parent_id', 'title_es', 'title_en', 'title_pt', 'desc_es', 'desc_en', 'desc_pt', 'image_path'
    ];


    public function attributes()
    {
      return $this->hasMany(Attribute::class, 'category_id');
    }


    //
    public function children()
    {
      return $this->hasMany($this, 'parent_id');
    }
    //
    public function getSubCategories()
    {
      return $this->children()->with('getSubCategories');
    }



    //
    public function father()
    {
      return $this->belongsTo($this,'parent_id', 'id');
    }
    //
    public function getTopCategories()
    {
      return $this->father()->with('getTopCategories');
    }


    //
    public function products()
    {
      return $this->hasMany(Product::class);
    }



    public function productsInCountry($id)
    {
      $products=$this->products();
      return $products->join('products_in_countries', 'products_in_countries.product_id', '=', 'products.id')
      ->where('products_in_countries.country_id','=', $id)
      ->select('products.*');
    }



    public function grandParent()
    {
      $parents = collect([]);
      $parent = $this->father;
      while(!is_null($parent)) {
        $parents->push($parent);
        $parent = $parent->father;
      }
      return $original_cat= $parents[$parents->count()-1];
    }






}
