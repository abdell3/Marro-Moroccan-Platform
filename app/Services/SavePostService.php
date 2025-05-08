<?php

namespace App\Services;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\SavePostRepositoryInterface;
use App\Services\Interfaces\SavePostServiceInterface;
use Illuminate\Support\Facades\Auth;

class SavePostService implements SavePostServiceInterface
{
    protected $savePostRepository;
    protected $postRepository;

    public function __construct(
        SavePostRepositoryInterface $savePostRepository,
        PostRepositoryInterface $postRepository
    ) {
        $this->savePostRepository = $savePostRepository;
        $this->postRepository = $postRepository;
    }

    public function getAllSavedPosts($perPage = 15)
    {
        return $this->savePostRepository->paginate($perPage);
    }
    
    public function getSavedPostById($id)
    {
        return $this->savePostRepository->find($id);
    }
    
    public function getUserSavedPosts($userId = null, $perPage = 15)
    {
        $userId = $userId ?? Auth::id();
        
        return $this->savePostRepository->getSavedPostsByUser($userId);
    }

    public function savePost($postId, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        $post = $this->postRepository->find($postId);
        if (!$post) {
            return false;
        }
        if ($this->isPostSaved($postId, $userId)) {
            return true;
        }
        return $this->savePostRepository->create([
            'user_id' => $userId,
            'post_id' => $postId
        ]);
    }

    public function unsavePost($postId, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        $savedPost = $this->savePostRepository->checkIfPostIsSaved($userId, $postId);
        if (!$savedPost) {
            return false;
        }
        return $this->savePostRepository->delete($savedPost->id);
    }

    public function isPostSaved($postId, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        return $this->savePostRepository->checkIfPostIsSaved($userId, $postId) !== null;
    }
}
