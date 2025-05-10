<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Badge;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'dashboard', 'verifyEmail', 'resendVerificationEmail']);
        $this->middleware('auth')->only(['dashboard', 'verifyEmail', 'resendVerificationEmail']);
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $request->validated();
        $userRole = Role::where('role_name', 'Utilisateur')->first();
        $welcomeBadge = Badge::where('name', 'Welcome')->first();

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $userRole?->id ?? 3,
            'badge_id' => $welcomeBadge?->id,
            'avatar' => 'avatars/default.png',
        ]);

        event(new Registered($user));
        Auth::login($user);
        return $this->redirectBasedOnRole($user);
    }

    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $request->validated();
        $email = $request->email;
        $password = $request->password;
        $remember = $request->filled('remember');
        
        Log::info('Tentative de connexion', ['email' => $email]);
        
        // Déconnecter tout utilisateur déjà connecté
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        
        // Recherche directe de l'utilisateur
        $user = User::where('email', $email)->first();
        
        if ($user && Hash::check($password, $user->password)) {
            // Force le chargement de la relation rôle
            $user->load('role');
            
            Log::info('Utilisateur trouvé', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'role_name' => $user->role?->role_name ?? 'Aucun rôle'
            ]);
            
            // Connexion manuelle pour contourner le problème d'Auth::attempt
            Auth::login($user, $remember);
            $request->session()->regenerate();
            
            Log::info('Utilisateur authentifié manuellement', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'role_name' => $user->role?->role_name ?? 'Aucun rôle',
                'auth_id' => Auth::id()
            ]);
            
            $user->update(['last_login_at' => now()]);
            
            return $this->redirectBasedOnRole($user);
        }
        
        Log::warning('Échec de connexion', [
            'email' => $email,
            'user_existe' => $user ? 'oui' : 'non'
        ]);

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent à aucun compte.',
        ]);
    }

    public function logout(Request $request)
    {
        // Déconnecter l'utilisateur actuel
        Auth::logout();
        
        // Invalider la session
        $request->session()->invalidate();
        
        // Régénérer le jeton CSRF pour éviter les attaques
        $request->session()->regenerateToken();
        
        // Rediriger vers la page d'accueil avec un message de succès
        return redirect()->route('home')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }

   
    public function dashboard()
    {
        return view('dashboard');
    }

    private function redirectBasedOnRole(User $user)
    {
        Log::info('Redirection basée sur le rôle', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'role_name' => $user->role?->role_name ?? 'Aucun rôle'
        ]);
        
        $isAdmin = $user->hasRole('Admin');
        $isModerator = $user->hasRole('Moderateur');
        
        Log::info('Vérification des rôles', [
            'isAdmin' => $isAdmin ? 'oui' : 'non',
            'isModerator' => $isModerator ? 'oui' : 'non',
            'role_object' => $user->role ? json_encode($user->role->toArray()) : 'null'
        ]);
        
        if ($isAdmin) {
            return redirect()->route('admin.dashboard');
        }
        
        if ($isModerator) {
            Log::info('Redirection vers moderator.dashboard');
            return redirect()->route('moderator.dashboard');
        }
        
        return redirect()->route('dashboard');
    }
}