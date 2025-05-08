<?php

namespace App\Services\Interfaces;

interface CommentServiceInterface
{
    public function getAllComments($perPage = 15);
    public function getCommentById($id);
    public function createComment($data);
    public function updateComment($id, $data);
    public function deleteComment($id);
    public function getCommentsByPost($postId);
    public function getCommentsByUser($userId);
    public function getRootCommentsByPost($postId);
    public function getCommentReplies($commentId);
    public function createReply($parentId, $data);
    public function isCommentAuthor($commentId, $userId);
    public function getCommentPath($commentId);
}
