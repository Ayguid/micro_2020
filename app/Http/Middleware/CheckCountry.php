<?php

namespace App\Http\Middleware;

use Closure;

class CheckCountry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)

    {

      if (session('country')) {
        // dd($request);
        return $next($request);
      }else {
        return redirect('/');
        // code...
      }
        // return back();


    }
}
