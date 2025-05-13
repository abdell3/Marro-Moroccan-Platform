<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\CommunityServiceInterface;
use App\Services\Interfaces\PollServiceInterface;
use App\Services\Interfaces\TagServiceInterface;
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
        $posts = $this->postService->getDerniersPostsPagines(10);
        return view('posts.index', compact('posts'));
    }

    public function create(Request $request)
    {
        $communityId = $request->query('community_id');
        $communities = $this->communityService->getAllCommunities();
        $tagService = app(TagServiceInterface::class);
        $existingTags = $tagService->getAllTagsAlpha();

        return view('posts.create', [
            'communities' => $communities,
            'selectedCommunityId' => $communityId,
            'existingTags' => $existingTags
        ]);
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['auteur_id'] = Auth::id();
        $communityId = $request->input('community_id');
        $community = $this->communityService->getCommunityById($communityId);
        
        if ($community && $community->isUserBanned(Auth::id())) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Vous êtes banni de cette communauté et ne pouvez pas publier de contenu.');
        }
        $postType = $request->input('post_type', 'text');
        $data['typeContenu'] = $postType;
        switch ($postType) {
            case 'media':
                if ($request->hasFile('media')) {
                    $file = $request->file('media');
                    $path = $file->store('posts', 'public');
                    $data['media_path'] = $path;
                    $data['media_type'] = $file->getMimeType();
                    if (str_contains($file->getMimeType(), 'image')) {
                        $data['typeContenu'] = 'image';
                    } elseif (str_contains($file->getMimeType(), 'video')) {
                        $data['typeContenu'] = 'video';
                    }
                    if ($request->filled('media_contenu')) {
                        $data['contenu'] = $request->input('media_contenu');
                    }
                }
                break;
                
            case 'link':
                if ($request->filled('link_url')) {
                    $data['contenu'] = $request->input('link_url');
                    if ($request->filled('link_contenu')) {
                        $data['contenu'] .= "\n\n" . $request->input('link_contenu');
                    }
                }
                break;
                
            case 'poll':
                if ($request->filled('poll_contenu')) {
                    $data['contenu'] = $request->input('poll_contenu');
                }
                break;
        }
        $tags = $request->input('tags');
        try {
            $post = $this->postService->createPost($data);
            if (!empty($tags)) {
                $tagService = app(TagServiceInterface::class);
                $tagService->attachTagsToPost($post->id, $tags);
            }
            if ($postType === 'poll') {
                $pollService = app(PollServiceInterface::class);
                $pollData = [
                    'post_id' => $post->id,
                    'auteur_id' => Auth::id(),
                    'typeVote' => $request->input('poll_type', 'standard'),
                    'question' => $request->input('question'),
                ];
                if ($request->input('poll_type') === 'standard') {
                    $pollData['poll_options'] = array_filter($request->input('poll_options', []), function($option) {
                        return !empty(trim($option));
                    });
                }
                try {
                    $poll = $pollService->createPoll($pollData);
                } catch (\Exception $e) {
                    return redirect()->route('posts.show', $post->id)
                        ->with('warning', 'Le post a été créé mais il y a eu un problème avec la création du sondage: ' . $e->getMessage());
                }
                if (!$poll) {
                    return redirect()->route('posts.show', $post->id)
                        ->with('warning', 'Le post a été créé mais il y a eu un problème avec la création du sondage.');
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création du post: ' . $e->getMessage());
        }
        return redirect()->route('posts.show', $post->id)
            ->with('success', 'Le post a été créé avec succès!');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        if (!Auth::check() || Auth::id() != $post->auteur_id) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier ce post.');
        }
        $communities = $this->communityService->getAllCommunities();
        $tagService = app(TagServiceInterface::class);
        $existingTags = $tagService->getAllTagsAlpha();
        return view('posts.edit', compact('post', 'communities', 'existingTags'));
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
        $tags = $request->input('tags');
        if (isset($tags)) {
            $tagService = app(TagServiceInterface::class);
            $tagService->attachTagsToPost($post->id, $tags);
        }
        return redirect()->route('posts.show', $post->id)
            ->with('success', 'Le post a été mis à jour avec succès!');
    }

    public function destroy(Post $post)
    {
        if (!Auth::check() || Auth::id() != $post->auteur_id) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer ce post.');
        }
        
        if ($post->media_path) {
            Storage::disk('public')->delete($post->media_path);
        }
        
        $this->postService->deletePost($post->id);
        return redirect()->route('posts.index')
            ->with('success', 'Le post a été supprimé avec succès!');
    }
    
    public function upvote(Post $post)
    {
        $updatedPost = $this->postService->upvotePost($post->id);
        $userId = auth()->id();
        $voteType = $post->getUserVoteType($userId);
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'likes' => $updatedPost->like,
                'vote_type' => $voteType
            ]);
        }
        return back()->with('success', 'Vote positif enregistré!');
    }
    
    public function downvote(Post $post)
    {
        $updatedPost = $this->postService->downvotePost($post->id);
        $userId = auth()->id();
        $voteType = $post->getUserVoteType($userId);
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'likes' => $updatedPost->like,
                'vote_type' => $voteType
            ]);
        }
        return back()->with('success', 'Vote négatif enregistré!');
    }
    
    public function like(Post $post)
    {
        $updatedPost = $this->postService->likePost($post->id);
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'likes' => $updatedPost->like
            ]);
        }
        return back()->with('success', 'Like ajouté!');
    }
    
    public function save(Post $post)
    {
        $result = $this->postService->sauvegarderPost($post->id, Auth::id());
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Post sauvegardé!'
            ]);
        }
        
        return back()->with('success', 'Post sauvegardé!');
    }
    
    public function unsave(Post $post)
    {
        $result = $this->postService->enleverPostSauvegarde($post->id, Auth::id());
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Post retiré des favoris!'
            ]);
        }
        
        return back()->with('success', 'Post retiré des favoris!');
    }
}