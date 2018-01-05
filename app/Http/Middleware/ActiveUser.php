<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::user() or (!Auth::user()->isActiveUser() and !Auth::user()->isAdmin()) ){
            return redirect()->route('welcome');
        }
        return $next($request);
    }
}
