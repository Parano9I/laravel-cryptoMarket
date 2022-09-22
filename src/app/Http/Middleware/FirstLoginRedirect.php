<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FirstLoginRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $isCurrentPagePreferences = $request->getPathInfo() === '/preferences';
        $isFirstLogin = Auth::user()->first_login;

        if ($isFirstLogin && !$isCurrentPagePreferences) {

            return redirect(('preferences'));
        }

        if (!$isFirstLogin && $isCurrentPagePreferences) {
            return redirect(('dashboard'));
        }


//        dd($request->user()->id);
        return $next($request);
    }
}
