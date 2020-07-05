<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models440\Country;
use App\Models440\Job_Title;
use App\Models440\User_Title;

class UserController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */

  public function __construct()
  {
    // $this->middleware('role:superadmin');
  }

  public function index()
  {

    $data =[
      'superadmins'=> User::role('superadmin')->orderBy('name')->get(),
      'admins'=> User::role('admin')->orderBy('name')->get(),
      'users'=> User::role('user')->orderBy('name')->get()
    ];

    return view('admin.users.index')->with('data', $data);

    //
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //
    $data = [
      'roles'=> Role::all(),
      'job_titles'=>Job_Title::all(),
      'countries' =>Country::all()
    ];

    return view('admin.users.create')->with('data', $data);
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

      $validator =  Validator::make($request->all(), [
        'role' => ['required'],
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
      ]);

      if (!$validator->fails()) {
        $user = User::create([
          'name' => $request['name'],
          'email' => $request['email'],
          'password' => Hash::make($request['password']),
        ]);
        if ($user) {
          $user->assignRole($request['role']);
          $this->buildTitles($request['job_title'], $user);
          $request->session()->flash('alert-success', 'Agregaste con exito!');
          // return redirect()->back();//en vez de back deberia ir al recurso agregado
          return redirect()->route('admin.users');
        }
      }else {
        $request->session()->flash('alert-danger', $validator->errors());
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
  { //se repite con edit por mambos de middleware, revisar podria ser el mismo metodo
    $data = $this->buildData($id);
    $data['edit'] = false;
    return view('admin.users.show')->with('data', $data);
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  { //se repite con show por mambos de middleware, revisar podria ser el mismo metodo
    $data = $this->buildData($id);
    $data['edit'] = true;
    return view('admin.users.show')->with('data', $data);
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
    $user = User::find($id);
    $validator =  Validator::make($request->all(), [
      'role' => ['required'],
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
    ]);

    if (!$validator->fails()) {
      return DB::transaction(function () use ($request, $user) {
        $user->update($request->all());
        if ($user) {
          $this->buildTitles($request['job_title'], $user);
          $user->syncRoles([$request['role']]);
          $request->session()->flash('alert-success', 'Agregaste con exito!');
          return redirect()->back();//en vez de back deberia ir al recurso agregado
        }
      });
    }else {
      $request->session()->flash('alert-danger', $validator->errors());
      return redirect()->back()->withInput($request->all())->withErrors($validator);
    }
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy(Request $request, $id)
  {
    $user = User::find($id);
    $user->syncRoles([]);
    $user->delete();
    $request->session()->flash('alert-success', 'Eliminaste con exito!');
    return redirect()->route('admin.users');
  }


  //helpers//

  public function buildTitles($titlesArray, &$user)
  { //ayuda a asignarle job titles al user
    if($user->titles())$user->titles->each->delete();//emprolijar, validar mejor
    if ($titlesArray) {
      foreach ($titlesArray as $key=> $userTitle) {
        $t = explode(",", $userTitle);
        $userJobTitle = new User_Title();
        $userJobTitle->user_id = $user->id;
        $userJobTitle->country_id = $t[0];
        $userJobTitle->title_id = $t[1];
        $userJobTitle->contactable = false;
        $userJobTitle->save();
      }
    }
  }


  public function buildData($id)
  {
    return [
      'roles' => Role::all(),
      'user' => User::find($id),
      'job_titles' => Job_Title::all(),
      'countries' => Country::all(),
    ];
  }

}
