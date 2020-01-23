<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;

class adminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /*public function handle($request, Closure $next)
    {
        return $next($request);
    }*/
    public function handle($request, Closure $next)
    {

            // $roles = DB::table('rights')->join('users','users.rightID', '=', 'rights.id')->where('users.employeeID', '=', Auth::user()->employeeID)->where('rights.rightID', '=', Auth::user()->rightID);

        if (Auth::user() && Auth::user()->rightID == 2) {
            // return $next($request);
            // return $next($request);
            // return redirect('/admin/dashboard');
            return $next($request);


        }
        // else{
        //     return redirect('/home');
        // }

        return redirect('/home');
    }
}
