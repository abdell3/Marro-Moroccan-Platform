<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }
        $request->user()->load('role');
        if ($request->user()->hasRole('Admin')) {
            return $next($request);
        }
        
        if (in_array('User', $roles) && $request->user()->hasRole('Moderateur')) {
            return $next($request);
        }
        
        // \Illuminate\Support\Facades\Log::debug('Vérification des rôles', [
        //     'utilisateur' => $request->user()->email,
        //     'rôle_utilisateur' => $request->user()->role->role_name ?? 'Aucun rôle',
        //     'rôles_requis' => $roles
        // ]);
        
        if (in_array('User', $roles) && !$request->user()->hasAnyRole(['Admin', 'Moderateur'])) {
            return $next($request);
        }
        
        if (!$request->user()->hasAnyRole($roles)) {
            abort(403, 'Accès refusé: Vous n\'avez pas les autorisations nécessaires.');
        }
        return $next($request);
    }
}