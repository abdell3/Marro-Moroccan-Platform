<?php

namespace App\Repositories\Interfaces;

interface CommentRepositoryInterface extends BaseRepositoryInterface
{
    public function getCommentsByPost($postId);
    public function getCommentsByUser($userId);
    public function getRootCommentsByPost($postId);
    public function getCommentReplies($commentId);
    public function isCommentAuthor($commentId, $userId);
    public function getCommentPath($commentId);
}
