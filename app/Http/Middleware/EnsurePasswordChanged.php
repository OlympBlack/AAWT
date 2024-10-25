<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsurePasswordChanged
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->password_change_required && !$request->routeIs('profile.show')) {
            return redirect()->route('profile.show')->with('warning', 'Veuillez changer votre mot de passe pour des raisons de sécurité.');
        }

        return $next($request);
    }
}
