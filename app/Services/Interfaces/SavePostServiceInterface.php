<?php

namespace App\Services\Interfaces;

interface SavePostServiceInterface
{
    public function getAllSavedPosts($perPage = 15);
    public function getSavedPostById($id);
    public function getUserSavedPosts($userId = null, $perPage = 15);
    public function savePost($postId, $userId = null);
    public function unsavePost($postId, $userId = null);
    public function isPostSaved($postId, $userId = null);
}
