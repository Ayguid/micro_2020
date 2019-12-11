<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Spatie\Permission\Models\Role;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    //old
    protected $redirectTo = '/home';

    //nuestro start
    // public function redirectTo(){
    //   if (auth()->user()->hasAnyRole(['superadmin', 'admin'])) {
    //     return 'admin/home';
    //   }else {
    //     return '/home';
    //   }
    // }
    //nuestro end


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
