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
        if ($user->avatar && $user->avatar != 'avatars/default.png') {
            Storage::disk('public')->delete($user->avatar);
        }
        $path = $request->file('avatar')->store('avatars', 'public');
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
