<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MyDataController extends Controller
{
    //
    //only for grl purpose only, pass, name etc

    public function indexMyData()
    {
      $data = Auth::user();
      return view ('myData')->with('data', $data);
    }


    public function updateMyData(Request $request)
    {
      return DB::transaction(function () use ($request) {

        $user = Auth::user();

        $validator =  Validator::make($request->all(), [
          'name' => ['required', 'string', 'max:255'],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
          'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!$validator->fails()) {
          // $user = User::create([
          //   'name' => $request['name'],
          //   'email' => $request['email'],
          //   'password' => Hash::make($request['password']),
          // ]);
          if ($user) {
            $user->fill($request->all());
            $user->password = Hash::make($request['password']);
            $user->save();
            // $user->assignRole($request['role']);
            // $this->buildTitles($request['job_title'], $user);
            $request->session()->flash('alert-success', 'Editaste con exito!');
            // // return redirect()->back();//en vez de back deberia ir al recurso agregado
            return redirect()->back();
          }
        }else {
          $request->session()->flash('alert-danger', $validator->errors());
          return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
      });
    }

}
