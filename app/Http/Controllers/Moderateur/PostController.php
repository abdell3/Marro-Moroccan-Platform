<?php

namespace App\Http\Controllers\Moderateur;

use Illuminate\Routing\Controller;
use App\Models\Post;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\CommentServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    protected $postService;
    protected $commentService;
    
    public function __construct(
        PostServiceInterface $postService,
        CommentServiceInterface $commentService
    )
    {
        $this->postService = $postService;
        $this->commentService = $commentService;
        $this->middleware('auth');
        $this->middleware('role:Moderateur');
    }

    public function show(Post $post)
    {
        if ($post->community_id && !Gate::check('manageCommunity', $post->community)) {
            abort(403, 'Vous n\'êtes pas autorisé à gérer cette communauté.');
        }
        $comments = $this->commentService->getCommentsByPost($post->id);
        return view('moderateur.posts.show', compact('post', 'comments'));
    }
    
    public function destroy(Post $post)
    {
        if ($post->community_id && !Gate::check('manageCommunity', $post->community)) {
            abort(403, 'Vous n\'êtes pas autorisé à gérer cette communauté.');
        }

        $this->postService->deletePost($post->id);
        return redirect()->back()->with('success', 'Le post a été supprimé avec succès.');
    }
}
