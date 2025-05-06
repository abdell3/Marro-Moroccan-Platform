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
        $parametre = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($parametre, $remember)) {
            $request->session()->regenerate();
            /** @var \App\Models\User|null $user */
            $user = Auth::user();
            if ($user) {
                $user->update([
                    'last_login_at' => now()
                ]);
            }
            
            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent à aucun compte.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')->with('success', 'Vous avez été déconnecté avec succès.');
    }

   
    public function dashboard()
    {
        return view('dashboard');
    }

    private function redirectBasedOnRole(User $user)
    {
        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        }
        
        if ($user->hasRole('Moderateur')) {
            return redirect()->route('moderator.dashboard');
        }
        
        return redirect()->route('dashboard');
    }
}