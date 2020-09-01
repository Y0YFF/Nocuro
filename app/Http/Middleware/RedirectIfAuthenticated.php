<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard == "admin" && Auth::guard($guard)->check()) {

            notify()->success('すでに管理者ログインしています', '管理者ログイン済');
            
            return redirect(route('admins.index'));
        }

        if (Auth::guard($guard)->check()) {

            notify()->success('すでにログインしています', 'ログイン済');

            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
