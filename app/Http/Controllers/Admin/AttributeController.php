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


class AttributeController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }


  public function addAttribute(Request $request)
  {
  return DB::transaction(function () use ($request) {
    $att= new Attribute($request->all());
    $att->save();
    return redirect()->back();
    });
  }



  public function edit($id)
  {
    $data=[
      'attribute'=>Attribute::find($id)
    ];

    return view('admin.attributes.edit')->with('data', $data);
  }




  public function update(Request $request)
  {
    return DB::transaction(function () use ($request) {

      // dd($request);
      $save = false;
      $validator = Validator::make($request->all(), [
        'name_es' => 'required|string|max:255',
      ]);

      if ($validator->fails())
      {
        $save = false;
      }
      else if (!$validator->fails())
      {
        $att= Attribute::find($request->attribute_id);
        $save = $att->update($request->all());
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



  public function destroy(Attribute $attribute, $id)
  {
     return DB::transaction(function () use ($attribute, $id) {
       $att=$attribute->find($id);
       $prodAttributes = $att->productAttributes;
       if ($prodAttributes->count()>0) {
         $prodAttributes->each->delete();
       }
       if ($att->delete()) {
         \Session::flash('alert-success', 'Borraste con exito!');
         return redirect()->route('showCategory',$att->category_id);
       }
       else
       {
         \Session::flash('alert-danger', 'OOppsss!');
         return redirect()->back();
       }
      });
  }

}
