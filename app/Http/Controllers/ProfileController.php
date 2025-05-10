<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        $activeTab = $request->query('tab', 'posts'); // Paramètre d'URL au lieu de fragment
        
        // Récupérer les données en fonction de l'onglet actif
        $posts = ($activeTab === 'posts') ? $this->getUserPosts($user->id, 10) : null;
        $comments = ($activeTab === 'comments') ? $user->comments()->with('post')->latest()->paginate(10) : null;
        $communities = ($activeTab === 'communities') ? $user->communities()->paginate(10) : null;
        $savedPosts = ($activeTab === 'saved') ? app(\App\Services\Interfaces\SavePostServiceInterface::class)->getUserSavedPosts($user->id, 10) : null;
        
        // Pagination
        if ($posts instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $posts->appends(['tab' => 'posts']);
        }
        
        if ($comments instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $comments->appends(['tab' => 'comments']);
        }
        
        if ($communities instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $communities->appends(['tab' => 'communities']);
        }
        
        if ($savedPosts instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $savedPosts->appends(['tab' => 'saved']);
        }
        
        return view('profile.show', compact('posts', 'comments', 'communities', 'savedPosts', 'activeTab'));
    }
    
    private function getUserPosts($userId, $perPage = 10)
    {
        // Utilisation du PostService pour obtenir les posts paginés
        $postService = app(\App\Services\Interfaces\PostServiceInterface::class);
        return $postService->getPostsByUser($userId, $perPage);
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
        $user = Auth::user();
        $savedPostService = app(\App\Services\Interfaces\SavePostServiceInterface::class);
        $savedPosts = $savedPostService->getUserSavedPosts($user->id, 10);
        
        // Assurons-nous que la pagination est maintenue
        if ($savedPosts instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $savedPosts->withQueryString()->withPath('');
        }
        
        return view('profile.saved-posts', compact('savedPosts'));
    }
    public function settings()
    {
        return view('profile.settings');
    }
}
