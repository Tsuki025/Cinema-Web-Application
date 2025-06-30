<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->Rola == $role) {
            return $next($request);
        }

        
        return redirect('/')->with('error', 'Brak dostępu do tej strony');
    }
}
