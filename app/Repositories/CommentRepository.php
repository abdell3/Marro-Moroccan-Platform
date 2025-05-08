<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    public function getCommentsByPost($postId)
    {
        return $this->model->where('post_id', $postId)
                          ->with(['auteur', 'replies'])
                          ->orderBy('created_at', 'desc')
                          ->get();
    }

    public function getCommentsByUser($userId)
    {
        return $this->model->where('auteur_id', $userId)
                          ->with(['post', 'parent'])
                          ->orderBy('created_at', 'desc')
                          ->get();
    }

    public function getRootCommentsByPost($postId)
    {
        return $this->model->where('post_id', $postId)
                          ->whereNull('parent_id')
                          ->with(['auteur', 'replies'])
                          ->orderBy('created_at', 'desc')
                          ->get();
    }

    public function getCommentReplies($commentId)
    {
        return $this->model->where('parent_id', $commentId)
                          ->with('auteur')
                          ->orderBy('created_at', 'asc')
                          ->get();
    }

    public function isCommentAuthor($commentId, $userId)
    {
        return $this->model->where('id', $commentId)
                          ->where('auteur_id', $userId)
                          ->exists();
    }

    public function getCommentPath($commentId)
    {
        $comment = $this->find($commentId);
        $path = [];
        
        while ($comment && $comment->parent_id) {
            array_unshift($path, $comment->parent_id);
            $comment = $this->model->find($comment->parent_id);
        }
        return $path;
    }
}
