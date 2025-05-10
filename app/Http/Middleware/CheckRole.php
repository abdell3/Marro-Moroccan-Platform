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
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        // Forcer le chargement de la relation rôle
        $request->user()->load('role');
        
        // Ajouter des logs détaillés pour savoir quels rôles sont testés
        \Illuminate\Support\Facades\Log::info('Vérification des rôles de l\'utilisateur', [
            'user_id' => $request->user()->id,
            'email' => $request->user()->email,
            'role_id' => $request->user()->role_id,
            'roles_requis' => $roles,
            'role_utilisateur' => $request->user()->role ? $request->user()->role->role_name : 'Aucun rôle',
            'role_object' => $request->user()->role ? json_encode($request->user()->role->toArray()) : 'null'
        ]);

        if (!$request->user()->hasAnyRole($roles)) {
            // Journaliser l'échec de la vérification des rôles
            \Illuminate\Support\Facades\Log::warning('Accès refusé: l\'utilisateur n\'a pas les rôles nécessaires', [
                'user_id' => $request->user()->id,
                'email' => $request->user()->email,
                'roles_requis' => $roles
            ]);
            
            abort(403, 'Accès refusé: Vous n\'avez pas les autorisations nécessaires.');
        }

        return $next($request);
    }
}