<?php

namespace App\Http\Controllers\Moderateur;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Moderateur');
    }

    public function show()
    {
        $user = Auth::user();
        return view('moderateur.profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('moderateur.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
        ]);
        
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->save();
        
        return redirect()->route('moderator.profile.show')
            ->with('success', 'Votre profil a été mis à jour avec succès.');
    }
    
    public function avatar()
    {
        $user = Auth::user();
        return view('moderateur.profile.avatar', compact('user'));
    }
    
    public function avatarUpdate(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($user->avatar && $user->avatar != 'avatars/default-avatar.png') {
            try {
                if (Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            } catch (\Exception $e) {
            }
        }
        
        $avatarName = 'avatar_' . $user->id . '_' . time() . '.' . $request->avatar->extension();
        $path = $request->file('avatar')->storeAs('avatars', $avatarName, 'public');
        $user->avatar = $path;
        $user->save();
        return redirect()->route('moderator.profile.show')
            ->with('success', 'Votre avatar a été mis à jour avec succès.');
    }
}
