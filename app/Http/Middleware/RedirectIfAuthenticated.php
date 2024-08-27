<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($guard === "employee" && Auth::guard($guard)->check()) {
            return redirect('/dashboard');
        }

        if ($guard === "candidate" && Auth::guard($guard)->check()) {
            return redirect('/candidate');
        }

        // else {
        //     return Redirect::to('http://127.0.0.1:8001/');
        // }
        if (Auth::guard($guard)->check()) {
            return Redirect::to('http://127.0.0.1:8001/');
            // return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
