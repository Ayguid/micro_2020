<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models440\Category;
use App\Models440\Country;
use App\Models440\Product;
use App\Models440\Product_Attribute;
use App\Models440\Attribute;
use App;

class LandingController extends Controller
{
  //
  public $paginate = 4;
  public $data = [];


  public function __construct()
  {
    // $this->middleware('CountryMiddleware');
    $this->data['categories'] = Category::where('parent_id', null)->get();
  }


  public function index()
  {
    return view('welcome');
  }

  public function setCountry($country_shortcode)
  {
    $country = Country::where('country_shortcode', '=',$country_shortcode)->first();
    session([
      'country' => $country,
    ]);
    // dd(session('country'));
    return redirect(route('countryLanding'));
  }


  public function countryLanding()
  {
    return view('country_landing')->with('data', $this->data);
  }

  public function getCategoryData($id)
  {
    $this->data['category']=Category::find($id);
    $this->data['category']->getTopCategories;
    return view('country_landing')->with('data', $this->data);
  }


  public function showProduct($id)
  {
    $this->data['product']= Product::with('attributes.attribute')->find($id);//vue
    $this->data['products']= '';
    $this->data['category']=Category::find($this->data['product']->category_id);
    return view('product-view')->with('data', $this->data);
  }



  public function find(Request $request, $country, $query=null)
  {
    $ctyId=session('country')->id;
    $this->data['products'] = Product::join('products_in_countries', 'products.id', '=', 'products_in_countries.product_id')
    ->where('product_code', 'LIKE', '%'.$query.'%')->where('products_in_countries.country_id', '=', $ctyId)
    ->orWhere('title_es', 'LIKE', '%'.$query.'%')->where('products_in_countries.country_id', '=', $ctyId)
    ->orWhere('desc_es', 'LIKE', '%'.$query.'%')->where('products_in_countries.country_id', '=', $ctyId)
    ->select('products.*')->with('files', 'category.getTopCategories', 'attributes.attribute')
    ->paginate($this->paginate);
    if ($this->data['products']->total()==0) {
      return response('Not found', 200);
    }
    else {
      return view('search_results')->with('data', $this->data);
    }
  }






}
