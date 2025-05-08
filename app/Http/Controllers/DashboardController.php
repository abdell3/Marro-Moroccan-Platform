<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'recent');
        if ($filter === 'popular') {
            $posts = Post::with(['auteur', 'community'])
                        ->orderBy('like', 'desc')
                        ->take(10)
                        ->get();
        } elseif ($filter === 'following') {
            $communityIds = Auth::user()->communities->pluck('id');
            $posts = Post::with(['auteur', 'community'])
                        ->whereIn('community_id', $communityIds)
                        ->orderBy('created_at', 'desc')
                        ->take(10)
                        ->get();
        } else {
            $posts = Post::with(['auteur', 'community'])
                        ->orderBy('created_at', 'desc')
                        ->take(10)
                        ->get();
        }
        $savedPosts = Auth::user()->savedPosts ?? collect();
        $userCommunities = Auth::user()->communities->take(5);
        return view('dashboard', compact(
            'posts', 
            'filter', 
            'savedPosts',
            'userCommunities'
        ));
    }
}
