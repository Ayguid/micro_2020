<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // $permission = Permission::create(['name' => 'create users']);
      // $permission = Permission::create(['name' => 'edit users']);
      // $permissions = Permission::create(['name' => 'delete users']);

        $data =[
            'roles'=> Role::all(),
        ];

        return view('admin.roles.index')->with('data', $data);

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->buildData($id);
        $data['edit'] = false;
        return view('admin.roles.show')->with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      //se repite con el de arriba por mambos de middleware, revisar podria ser el mismo metodo
      $data = $this->buildData($id);
      $data['edit'] = true;
      return view('admin.roles.show')->with('data', $data);
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
        $role = Role::find($id);
        if ($role) {
          $role->syncPermissions($request['permissions']);
          $request->session()->flash('alert-success', 'Agregaste con exito!');
          return $this->edit($id);
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
        //
    }


    //helpers
    public function buildData($id)
    {
      return [
        'role'=>Role::find($id),
        'permissions'=>Permission::all()
      ];
    }

}
