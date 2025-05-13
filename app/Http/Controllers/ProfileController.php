<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\SavePostServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        $activeTab = $request->query('tab', 'posts'); 
        
        $user->load('badges');
        
        $posts = ($activeTab === 'posts') ? $this->getUserPosts($user->id, 10) : null;
        $comments = ($activeTab === 'comments') ? $user->comments()->with('post')->latest()->paginate(10) : null;
        $communities = ($activeTab === 'communities') ? $user->communities()->paginate(10) : null;
        $savedPosts = ($activeTab === 'saved') ? app(SavePostServiceInterface::class)->getUserSavedPosts($user->id, 10) : null;
        
        if ($posts instanceof LengthAwarePaginator) {
            $posts->appends(['tab' => 'posts']);
        }
        
        if ($comments instanceof LengthAwarePaginator) {
            $comments->appends(['tab' => 'comments']);
        }
        
        if ($communities instanceof LengthAwarePaginator) {
            $communities->appends(['tab' => 'communities']);
        }
        
        if ($savedPosts instanceof LengthAwarePaginator) {
            $savedPosts->appends(['tab' => 'saved']);
        }
        
        return view('profile.show', compact('posts', 'comments', 'communities', 'savedPosts', 'activeTab'));
    }
    
    private function getUserPosts($userId, $perPage = 10)
    {
        $postService = app(PostServiceInterface::class);
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

        if (!empty($validated['preferences'])) {
            try {
                if (!is_array($validated['preferences'])) {
                    $validated['preferences'] = json_encode([$validated['preferences']]);
                }
            } catch (\Exception $e) {
                $validated['preferences'] = null;
            }
        } else {
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
        if (!file_exists(storage_path('app/public/avatars'))) {
            mkdir(storage_path('app/public/avatars'), 0755, true);
        }
        
        if ($user->avatar && $user->avatar != 'avatars/default-avatar.png') {
            try {
                if (Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            } catch (\Exception $e) {
            }
        }
        
        $avatarName = 'avatar_' . $user->id . '_' . time() . '.' . $request->file('avatar')->getClientOriginalExtension();
        $path = $request->file('avatar')->storeAs('avatars', $avatarName, 'public');
        $user->avatar = $path;
        $user->save();
        return redirect()->route('profile.avatar')->with('success', 'Avatar changé!');
    }

    public function communities()
    {
        return view('profile.communities');
    }
    public function badges()
    {
        $user = Auth::user();
        $user->load('badges'); 
        return view('profile.badges');
    }
    
    public function savedPosts()
    {
        $user = Auth::user();
        $savedPostService = app(SavePostServiceInterface::class);
        $savedPosts = $savedPostService->getUserSavedPosts($user->id, 10);
        if ($savedPosts instanceof LengthAwarePaginator) {
            $savedPosts->withQueryString()->withPath('');
        }
        
        return view('profile.saved-posts', compact('savedPosts'));
    }
    
}
