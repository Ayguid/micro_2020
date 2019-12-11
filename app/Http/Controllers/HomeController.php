<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // Role::create(['name'=>'god']);
        // Role::create(['name'=>'superadmin']);
        // Role::create(['name'=>'admin']);
        // Role::create(['name'=>'user']);
        // Permission::create(['name'=>'index users']);
        // Permission::create(['name'=>'create users']);
        // Permission::create(['name'=>'edit users']);
        // Permission::create(['name'=>'delete users']);

        // $permission = Permission::findById(1);
        // $role = Role::findById(3);
        // $role->givePermissionTo($permission);

        // auth()->user()->assignRole('superadmin');

        // return view('admin.home');

        return view('home');
    }
}
