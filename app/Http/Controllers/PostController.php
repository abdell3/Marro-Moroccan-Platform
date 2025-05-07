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
        // CommunityServiceInterface $communityService
    ) {
        $this->postService = $postService;
        // $this->communityService = $communityService;
        
       
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Afficher la liste des posts
     */
    public function index()
    {
        $posts = $this->postService->getDerniersPosts(15);
        return view('posts.index', compact('posts'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $communities = $this->communityService->getAllCommunities();
        return view('posts.create', compact('communities'));
    }

    /**
     * Enregistrer un nouveau post
     */
    public function store(StorePostRequest $request)
    {
        // Récupérer les données validées
        $data = $request->validated();
        
        // Ajouter l'ID de l'utilisateur connecté
        $data['auteur_id'] = Auth::id();
        
        // Gérer le fichier média
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $path = $file->store('posts', 'public');
            $data['media_path'] = $path;
            
            // Déterminer le type de contenu
            $type = 'text';
            if (str_contains($file->getMimeType(), 'image')) {
                $type = 'image';
            } elseif (str_contains($file->getMimeType(), 'video')) {
                $type = 'video';
            }
            
            $data['typeContenu'] = $type;
            $data['media_type'] = $file->getMimeType();
        }
        
        // Créer le post
        $post = $this->postService->createPost($data);
        
        return redirect()->route('posts.show', $post->id)
            ->with('success', 'Le post a été créé avec succès!');
    }

    /**
     * Afficher un post
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Post $post)
    {
        // Vérifier l'autorisation
        $this->authorize('update', $post);
        
        $communities = $this->communityService->getAllCommunities();
        return view('posts.edit', compact('post', 'communities'));
    }

    /**
     * Mettre à jour un post
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        // Récupérer les données validées
        $data = $request->validated();
        
        // Gérer le fichier média
        if ($request->hasFile('media')) {
            // Supprimer l'ancien fichier
            if ($post->media_path) {
                Storage::disk('public')->delete($post->media_path);
            }
            
            // Uploader le nouveau fichier
            $file = $request->file('media');
            $path = $file->store('posts', 'public');
            $data['media_path'] = $path;
            
            // Déterminer le type de contenu
            $type = 'text';
            if (str_contains($file->getMimeType(), 'image')) {
                $type = 'image';
            } elseif (str_contains($file->getMimeType(), 'video')) {
                $type = 'video';
            }
            
            $data['typeContenu'] = $type;
            $data['media_type'] = $file->getMimeType();
        }
        
        // Mettre à jour le post
        $this->postService->updatePost($post->id, $data);
        
        return redirect()->route('posts.show', $post->id)
            ->with('success', 'Le post a été mis à jour avec succès!');
    }

    /**
     * Supprimer un post
     */
    public function destroy(Post $post)
    {
        // Vérifier l'autorisation
        $this->authorize('delete', $post);
        
        // Supprimer le fichier média
        if ($post->media_path) {
            Storage::disk('public')->delete($post->media_path);
        }
        
        // Supprimer le post
        $this->postService->deletePost($post->id);
        
        return redirect()->route('posts.index')
            ->with('success', 'Le post a été supprimé avec succès!');
    }
    
    /**
     * Liker un post
     */
    public function like(Post $post)
    {
        $this->postService->likePost($post->id);
        return back()->with('success', 'Post liké!');
    }
    
    /**
     * Sauvegarder un post
     */
    public function save(Post $post)
    {
        $this->postService->sauvegarderPost($post->id, Auth::id());
        return back()->with('success', 'Post sauvegardé!');
    }
    
    /**
     * Retirer un post des favoris
     */
    public function unsave(Post $post)
    {
        $this->postService->enleverPostSauvegarde($post->id, Auth::id());
        return back()->with('success', 'Post retiré des favoris!');
    }
}