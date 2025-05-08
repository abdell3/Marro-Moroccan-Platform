<?php

namespace App\Services;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\Interfaces\CommentServiceInterface;
use Illuminate\Support\Facades\Auth;

class CommentService implements CommentServiceInterface
{
    protected $commentRepository;
    protected $postRepository;

    public function __construct(
        CommentRepositoryInterface $commentRepository,
        PostRepositoryInterface $postRepository
    ) {
        $this->commentRepository = $commentRepository;
        $this->postRepository = $postRepository;
    }

    public function getAllComments($perPage = 15)
    {
        return $this->commentRepository->paginate($perPage);
    }
    
    public function getCommentById($id)
    {
        return $this->commentRepository->find($id);
    }
    
    public function createComment($data)
    {
        if (!$this->postRepository->find($data['post_id'])) {
            return null;
        }
        if (!isset($data['datePublication'])) {
            $data['datePublication'] = now();
        }
        if (!isset($data['auteur_id'])) {
            $data['auteur_id'] = Auth::id();
        }
        return $this->commentRepository->create($data);
    }
    
    public function updateComment($id, $data)
    {
        $comment = $this->commentRepository->find($id);
        
        if (!$comment) {
            return false;
        }
        return $this->commentRepository->update($id, $data);
    }
    
    public function deleteComment($id)
    {
        return $this->commentRepository->delete($id);
    }
    
    public function getCommentsByPost($postId)
    {
        return $this->commentRepository->getCommentsByPost($postId);
    }
    
    public function getCommentsByUser($userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        return $this->commentRepository->getCommentsByUser($userId);
    }
    
    public function getRootCommentsByPost($postId)
    {
        return $this->commentRepository->getRootCommentsByPost($postId);
    }
    
    public function getCommentReplies($commentId)
    {
        return $this->commentRepository->getCommentReplies($commentId);
    }
    
    public function createReply($parentId, $data)
    {
        $parentComment = $this->commentRepository->find($parentId);
        if (!$parentComment) {
            return null;
        }
        $replyData = [
            'post_id' => $parentComment->post_id,
            'parent_id' => $parentId,
            'contenu' => $data['contenu'],
            'datePublication' => now(),
            'auteur_id' => $data['auteur_id'] ?? Auth::id()
        ];
        return $this->commentRepository->create($replyData);
    }
    
    public function isCommentAuthor($commentId, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        return $this->commentRepository->isCommentAuthor($commentId, $userId);
    }
    
    public function getCommentPath($commentId)
    {
        return $this->commentRepository->getCommentPath($commentId);
    }
}
