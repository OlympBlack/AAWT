<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::check()) {
            $userRole = Auth::user()->role->wording;

            if ($userRole === $role) {
                return $next($request); // L'utilisateur a le bon rôle, il peut accéder à cette route
            }

            // Rediriger vers le tableau de bord spécifique à chaque rôle
            return $this->redirectToDashboard($userRole);
        }

        return redirect('/login'); // Rediriger les utilisateurs non authentifiés vers la page de connexion
    }

    /**
     * Rediriger vers le tableau de bord en fonction du rôle de l'utilisateur.
     *
     * @param  string  $role
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectToDashboard($role)
    {
        switch ($role) {
            case 'admin':
                return redirect('/admin/dashboard');
            case 'teacher':
                return redirect('/teacher/dashboard');
            case 'parent':
                return redirect('/parent/dashboard');
            case 'student':
                return redirect('/student/dashboard');
            default:
                return redirect('/'); // Rediriger vers la page d'accueil par défaut si le rôle est inconnu
        }
    }
}
