<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use App\Models440\Category;
use App\Models440\Product;
use App\Models440\Product_Attribute;
use App\Models440\Product_In_Country;


class ProductController extends Controller
{

  public function __construct()
  {
    // $this->middleware('auth');
  }
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    //
  }


  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */


  public function create()
  {

  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    // dd($request);
    return DB::transaction(function () use ($request) {
      $save = false;
      $validator = Validator::make($request->all(), [
        'title_es' => 'required|string|max:255',
        'desc_es' => 'required|string|max:255',
        'product_code' => 'required|string|max:255',
      ]);
      if ($validator->fails())
      {
        $save = false;
      }
      else if (!$validator->fails())
      {
        $prod = new Product($request->all());
        $save = $prod->save();
        if ($request->country_id) {
          foreach ($request->country_id as $key => $value) {
            $prodInCt = new Product_In_Country();
            $prodInCt->country_id=$value;
            $prodInCt->product_id=$prod->id;
            $save = $prodInCt->save();
          }
        }
        if ($request['attributes']) {
          foreach ($request['attributes'] as $keyAtt => $valueAtt) {
            if ($valueAtt) {
              $prodAtt= new Product_Attribute();
              $prodAtt->product_id = $prod->id;
              $prodAtt->attribute_id = $keyAtt;
              $prodAtt->value = $valueAtt;
              $save = $prodAtt->save();
            }
          }
        }
      }
      if ($save)
      {
        $request->session()->flash('alert-success', 'Agregaste con exito!');
        return redirect()->back();
      }
      else
      {
        $request->session()->flash('alert-danger', 'Oops there was a problem!');
        return redirect()->back()->withInput($request->all())->withErrors($validator);
      }
    });
  }


  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {

    $product = Product::find($id);
    $cat = Category::find($product->category_id);
    $parents = collect([]);
    $parent = $cat->father;
    while(!is_null($parent)) {
      $parents->push($parent);
      $parent = $parent->father;
    }
    $original_cat= $parents[$parents->count()-1];
    $data = [
      'product'=>$product,
      'original_cat'=>$original_cat
    ];
    return view('admin.products.edit')->with('data', $data);
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request)
  {
    //
    $save=true;
    $validator = Validator::make($request->all(), [
      'title_es' => 'required|string|max:255',
      'desc_es' => 'required|string|max:255',
      'product_code' => 'required|string|max:255',
    ]);
    if ($validator->fails())
    {
      $save = false;
      return redirect()->back()->withInput($request->all())->withErrors($validator);
    }else if (!$validator->fails()) {

      return DB::transaction(function () use ($request) {
        $save = false;
        $prod = Product::find($request->product_id);
        $save = $prod->update($request->all());
        //delete
        foreach ($prod->possibleCountries() as $country) {
          $t = false;
          $y = false;
          if ($prod->isInCountry($country->id)) {
            if ($request->country_id) {
              foreach ($request->country_id as $key => $value) {
                ($value == $country->id)? $t=true : false;
              }
            }
            if (!$t) {
              $p = Product_In_Country::all()->where('country_id', '=', $country->id)->where('product_id', '=', $prod->id)->first();
              $save=$p->delete();
            }
          }
          //save
          if (!$prod->isInCountry($country->id)) {
            if ($request->country_id) {
              foreach ($request->country_id as $key => $value) {
                ($value == $country->id)? $y=true : false;
              }
              if ($y) {
                $prodInCt = new Product_In_Country();
                $prodInCt->country_id=$country->id;
                $prodInCt->product_id=$prod->id;
                $save = $prodInCt->save();
              }
            }
          }
        }

        if ($request['attributes'] ) {
          foreach ($request['attributes'] as $keyAtt => $valueAtt) {
            if ($valueAtt) {
              if ($pa = $prod->attributeValue($keyAtt)) {
                $pa->value_es = $valueAtt;
                $save = $pa->save();
              }
              else {
                $prodAttr= new Product_Attribute;
                $prodAttr->attribute_id=$keyAtt;
                $prodAttr->product_id=$prod->id;
                $prodAttr->value_es=$valueAtt;
                $save = $prodAttr->save();
              }
            }
            if (!$valueAtt && ($pd =  $prod->attributeValue($keyAtt))) {
              $save = $pd->delete();
            }
          }
        }

        if ($save)
        {
          $request->session()->flash('alert-success', 'Editaste con exito!');
          return redirect()->back();
        }
        else
        {
          $request->session()->flash('alert-danger', 'Oops there was a problem!');
          return redirect()->back();
        }
      });
    }

  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    return DB::transaction(function () use ($id) {
      $save = false;
      $prod=Product::find($id);
      $attributes=$prod->attributes;
      $save = $attributes->each->delete();
      if ($save) {
        $prAtt=Product_Attribute::where('product_id', $id)->get();
        $prdsInCts=Product_In_Country::where('product_id', $id)->get();
        $prdsInCts->each->delete();
        $save = $prAtt->each->delete();
      }
      $save = $prod->files->each->delete();
      $save = $prod->delete();
      if ($save){
        \Session::flash('alert-success', 'Borraste con exito!');
        return redirect()->route('showCategory', $prod->category_id);
      }else{
        \Session::flash('alert-danger', 'Oops there was a problem!');
        return redirect()->back();
      }
    });
  }




  public function find($query)
  {
    $products = Product::where('product_code', 'LIKE', '%'.$query.'%')
    ->orWhere('title_es', 'LIKE', '%'.$query.'%')
    ->orWhere('desc_es', 'LIKE', '%'.$query.'%')
    ->orWhere('title_en', 'LIKE', '%'.$query.'%')
    ->orWhere('desc_en', 'LIKE', '%'.$query.'%')
    ->orWhere('title_pt', 'LIKE', '%'.$query.'%')
    ->orWhere('desc_pt', 'LIKE', '%'.$query.'%')
    ->with('files', 'category.getTopCategories', 'attributes.attribute')
    ->paginate(5);
    $data=[
      'products'=>$products
    ];
    if ($products->total()==0) {
      return response('Not found', 200);
    }
    return view('admin.products-view')->with('data', $data);
  }


}
