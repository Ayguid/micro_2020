<?php

namespace App\Http\Controllers\Admin;
use DB;
use Illuminate\Http\Request;
use App\Models440\Category;
use Illuminate\Support\Facades\Validator;
use App\Models440\Category_Attribute_Value;
use App\Models440\Attribute;
use App\Models440\Attribute_Value;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

    /**

  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */

  public function index()
  {
    //
    $data = [
      'categories'=>Category::all()->where('parent_id', null)
    ];
    return view('admin.categories.index')->with('data', $data);
  }


  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $category = Category::find($id);

    $data = [
      'category'=>$category,
      'products' => $category->products()->paginate(3)
    ];

    return view('admin.categories.show')->with('data', $data);
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    //
    $category = Category::find($id);
    return view('admin.categories.edit')->with('category', $category);
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    return DB::transaction(function () use ($request, $id) {
    $save = false;
    $validator = Validator::make($request->all(), [
      'title_es' => 'required|string|max:255',
      // 'desc_es' => 'required|string|max:255',
    ]);
    if ($validator->fails())
    {
      $save = false;
    }
    else if (!$validator->fails())
    {
      $cat = Category::find($id);
      $save = $cat->update($request->all());
    }
    if ($save)
    {
      $request->session()->flash('alert-success', 'Editaste con exito!');
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
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    return DB::transaction(function () use ($request) {
    // dd($request);

    $save = false;
    $validator = Validator::make($request->all(), [
      'title_es' => 'required|string|max:255',
      // 'desc_es' => 'required|string|max:255',
      // 'product_category' => 'required|integer|max:100',
    ]);
    if ($validator->fails())
    {
      $save = false;
    }
    else if (!$validator->fails())
    {
      $cat = new Category($request->all());
      $save =$cat->save();
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









  public function searchChildren($object)
  {
    $ids = [];
    foreach ($object->getSubCategories as $child) {
      $ids[] = $child->id;
      $ids = array_merge($ids, $this->searchChildren($child));
    }
    return $ids;
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
    $cat = Category::find($id);
    $array_of_ids = $this->searchChildren($cat);
    array_push($array_of_ids, $id);
    Category::destroy($array_of_ids);
    $cat->delete();
    \Session::flash('alert-success', 'Borraste con exito!');
    return redirect()->route('admin.dashboard');
    });
  }



  // public function addAttribute(Request $request)
  // {
  // return DB::transaction(function () use ($request) {
  //   // dd($request);
  //   $att= new Attribute($request->all());
  //   $att->save();
  //   return redirect()->back();
  //   });
  // }




}
