<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


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
          'roles'=> Role::all()
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
          $request->session()->flash('alert-success', 'Agregaste con exito!');
          // return redirect()->back();//en vez de back deberia ir al recurso agregado
          return redirect()->route('admin.users');
        }
      }else {
        $request->session()->flash('alert-danger', $validator->errors());
        return redirect()->back()->withInput($request->all())->withErrors($validator);
      }

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
        $data = [
          'roles'=> Role::all(),
          'user'=>User::find($id)
        ];
        return view('admin.users.show')->with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data = [
        'roles'=> Role::all(),
        'user'=>User::find($id)
      ];
      return view('admin.users.edit')->with('data', $data);
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
        $user = User::find($id);
        $user->update($request->all());

        if ($user) {
          $user->syncRoles([$request['role']]);
          $request->session()->flash('alert-success', 'Agregaste con exito!');
          return redirect()->back();//en vez de back deberia ir al recurso agregado
        }
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
}
