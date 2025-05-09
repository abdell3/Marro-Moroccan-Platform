<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show');
    }
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'preferences' => ['nullable', 'string', 'max:1000'],
        ]);
        
        // S'assurer que preferences est du JSON valide ou null
        if (!empty($validated['preferences'])) {
            try {
                // Convertir en JSON si ce n'est pas déjà du JSON
                if (!is_array($validated['preferences'])) {
                    // Encoder en JSON pour être sûr que c'est du JSON valide
                    $validated['preferences'] = json_encode([$validated['preferences']]);
                }
            } catch (\Exception $e) {
                // En cas d'erreur, mettre à null
                $validated['preferences'] = null;
            }
        } else {
            // Si vide, mettre à null
            $validated['preferences'] = null;
        }
        
        $user->update($validated);
        return redirect()->route('profile.show')->with('success', 'Profil mis à jour!');
    }
    public function avatar()
    {
        return view('profile.avatar');
    }
    public function avatarUpdate(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);
        
        $user = Auth::user();
        
        // Vérifier et créer le dossier s'il n'existe pas
        if (!file_exists(storage_path('app/public/avatars'))) {
            mkdir(storage_path('app/public/avatars'), 0755, true);
        }
        
        // Supprimer l'ancien avatar s'il existe et n'est pas l'avatar par défaut
        if ($user->avatar && $user->avatar != 'avatars/default-avatar.png') {
            try {
                if (Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            } catch (\Exception $e) {
                // Ne rien faire si le fichier n'existe pas
            }
        }
        
        // Générer un nom unique pour l'avatar
        $avatarName = 'avatar_' . $user->id . '_' . time() . '.' . $request->file('avatar')->getClientOriginalExtension();
        
        // Enregistrer l'avatar
        $path = $request->file('avatar')->storeAs('avatars', $avatarName, 'public');
        
        $user->avatar = $path;
        $user->save();
        
        return redirect()->route('profile.avatar')->with('success', 'Avatar changé!');
    }

    public function communities()
    {
        return view('profile.communities');
    }
    public function savedPosts()
    {
        return view('profile.saved-posts');
    }
    public function settings()
    {
        return view('profile.settings');
    }
}
