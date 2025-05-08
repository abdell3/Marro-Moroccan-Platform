<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\CommunityServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;

class PostController extends Controller
{
    protected $postService;
    protected $communityService;

    public function __construct(
        PostServiceInterface $postService, 
        CommunityServiceInterface $communityService
    ) {
        $this->postService = $postService;
        $this->communityService = $communityService;
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $posts = $this->postService->getDerniersPosts(15);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $communities = $this->communityService->getAllCommunities();
        return view('posts.create', compact('communities'));
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['auteur_id'] = Auth::id();
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $path = $file->store('posts', 'public');
            $data['media_path'] = $path;
            
            $type = 'text';
            if (str_contains($file->getMimeType(), 'image')) {
                $type = 'image';
            } elseif (str_contains($file->getMimeType(), 'video')) {
                $type = 'video';
            }
            
            $data['typeContenu'] = $type;
            $data['media_type'] = $file->getMimeType();
        }
        $post = $this->postService->createPost($data);
        
        return redirect()->route('posts.show', $post->id)
            ->with('success', 'Le post a été créé avec succès!');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $communities = $this->communityService->getAllCommunities();
        return view('posts.edit', compact('post', 'communities'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();
        if ($request->hasFile('media')) {
            if ($post->media_path) {
                Storage::disk('public')->delete($post->media_path);
            }
            
            $file = $request->file('media');
            $path = $file->store('posts', 'public');
            $data['media_path'] = $path;
            
            $type = 'text';
            if (str_contains($file->getMimeType(), 'image')) {
                $type = 'image';
            } elseif (str_contains($file->getMimeType(), 'video')) {
                $type = 'video';
            }
            
            $data['typeContenu'] = $type;
            $data['media_type'] = $file->getMimeType();
        }
        $this->postService->updatePost($post->id, $data);
        
        return redirect()->route('posts.show', $post->id)
            ->with('success', 'Le post a été mis à jour avec succès!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        
        if ($post->media_path) {
            Storage::disk('public')->delete($post->media_path);
        }
        
        $this->postService->deletePost($post->id);
        return redirect()->route('posts.index')
            ->with('success', 'Le post a été supprimé avec succès!');
    }
    
    public function like(Post $post)
    {
        $this->postService->likePost($post->id);
        return back()->with('success', 'Post liké!');
    }
    
    public function save(Post $post)
    {
        $this->postService->sauvegarderPost($post->id, Auth::id());
        return back()->with('success', 'Post sauvegardé!');
    }
    
    public function unsave(Post $post)
    {
        $this->postService->enleverPostSauvegarde($post->id, Auth::id());
        return back()->with('success', 'Post retiré des favoris!');
    }
}