<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Auth\Guard;
class AuthenticateUserFront
{
    protected $auth;
    /**
     * Create a new filter instance.
     * @param  Guard  $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

 
    public function handle($request, Closure $next)
    { 
        if(\Auth::check()){
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
               if(\Auth::User()->user_type == 3 || \Auth::User()->user_type == 4){
                return redirect()->guest('/');
            }
            }
        }
    }
    else {
          $redirect_url = Route::currentRouteName();
          \Session::start();
          \Session::put('redirect_url', $redirect_url);
         
          return redirect()->route('login');
        }

        $currentRouteName = Route::currentRouteName();
        return $next($request);
    }
}
