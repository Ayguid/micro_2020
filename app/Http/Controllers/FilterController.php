<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models440\Category;
use App\Models440\Product_Attribute;
use App\Models440\Product;


class FilterController extends Controller
{



  //de valor siempre se usa value_es!!!!
  public function findProducts(Request $request)
  {

    //Info principal - Products en country y category
    $cat = Category::find($request->category);
    $prods = $cat->productsInCountry($request->country);
    

    //Arma data para menu builder ORIGINAL
    // $productAtts = Product_Attribute::where('attribute_id', '123123123123')->get();
    $productAtts=$this->plucker($prods);
    // return response()->json(['mandaste'=>$productAtts]);

    // Hace el query para buscar productos que cumplan con attributes
    if ($request->filterAtts) {
      foreach (json_decode($request->filterAtts, TRUE) as $key => $value) {
        if ($value != 'null') {
          $prods = $prods->whereHas('attributes', function($q) use($key, $value){
            $q->where('attribute_id', '=', $key)->where('value_es', '=', $value);
          });
        }
      }
      //Arma data para menu builder SHOW
      $productAttsShow=$this->plucker($prods);
      foreach ($productAtts as $key => $values) {
        foreach ($values as $v) {
          if (isset($productAttsShow[$key])) {
            foreach ($productAttsShow[$key] as $vs) {
              if ($v->value_es==$vs->value_es) {
                $v->disabled=false;
                $v->show=true;
              }
              if ($v->value_es!==$vs->value_es && !$v->show) {
                $v->disabled=true;
              }
            }
          }else {
            $v->disabled=true;
          }
        }
      }
    }
    //Arma el menu con la data que le pasamos
    $menuObj = new \stdClass;
    $menuObj->attributes = [] ;
    //
    foreach ($productAtts as $key => $values) {
      $prAtt= Product_Attribute::where('attribute_id', $key)->first()->attribute;
      if ($prAtt->filterable=='1') {
        $menuObj->attributes[$key] =$prAtt;
        $col=collect();
        foreach ($values as $v) {
          $col->add($v);
        }
        // $col->orderBy('value');
        $menuObj->attributes[$key]->uniqueValues=$col;
      }
    }

    //response con todo lo necesario
    return response()->json([
      'products'=>$prods->with('files', 'attributes.attribute')->paginate(16),
      'menuData'=>$menuObj
    ]);

  }





  public function plucker(&$collection)
  {
    return $collection
    ->with('attributes')
    ->get()
    ->pluck('attributes')
    ->flatten()
    ->groupBy('attribute_id')
    ->map(function ($array) {
      return collect($array)->unique('value_es')->sortBy('value_es')->all();
    });

  }











}
