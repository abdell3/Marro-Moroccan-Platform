<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyCommentRequest;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Post;
use App\Services\Interfaces\CommentServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use AuthorizesRequests;
    
    protected $commentService;

    public function __construct(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('viewAny', Comment::class);
        $comments = $this->commentService->getCommentsByUser(Auth::id());
        return view('comments.index', compact('comments'));
    }

    public function store(StoreCommentRequest $request)
    {
        $validated = $request->validated();
        $validated['auteur_id'] = Auth::id();
        
        $comment = $this->commentService->createComment($validated);
        
        if (!$comment) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Impossible de créer le commentaire.');
        }

        return redirect()->back()
            ->with('success', 'Commentaire ajouté avec succès!');
    }

    public function show(Comment $comment)
    {
        $this->authorize('view', $comment);
        $replies = $this->commentService->getCommentReplies($comment->id);
        return view('comments.show', compact('comment', 'replies'));
    }

    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        return view('comments.edit', compact('comment'));
    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        $validated = $request->validated();
        
        $result = $this->commentService->updateComment($comment->id, $validated);
        
        if (!$result) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Impossible de mettre à jour le commentaire.');
        }
        return redirect()->route('posts.show', $comment->post_id)
            ->with('success', 'Commentaire mis à jour avec succès!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $postId = $comment->post_id;
        
        $result = $this->commentService->deleteComment($comment->id);
        
        if (!$result) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer le commentaire.');
        }
        
        return redirect()->route('posts.show', $postId)
            ->with('success', 'Commentaire supprimé avec succès!');
    }

    public function reply(ReplyCommentRequest $request, Comment $comment)
    {
        $this->authorize('reply', $comment);
        
        $validated = $request->validated();
        $validated['auteur_id'] = Auth::id();
        
        $reply = $this->commentService->createReply($comment->id, $validated);
        
        if (!$reply) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Impossible de répondre au commentaire.');
        }
        
        return redirect()->back()
            ->with('success', 'Réponse ajoutée avec succès!');
    }

    public function byPost(Post $post)
    {
        $this->authorize('viewAny', Comment::class);
        $comments = $this->commentService->getRootCommentsByPost($post->id);
        return view('comments.by_post', compact('post', 'comments'));
    }
}
