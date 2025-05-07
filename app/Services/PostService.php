<?php

namespace App\Services;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\Interfaces\PostServiceInterface;

class PostService implements PostServiceInterface
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAllPosts($perPage = 15)
    {
        return $this->postRepository->paginate($perPage);
    }
    public function getPostById($id)
    {
        return $this->postRepository->find($id);
    }

    public function createPost($data)
    {
        if (!isset($data['datePublication'])) {
            $data['datePublication'] = now();
        }
        if (!isset($data['typeContenu'])) {
            if (isset($data['media_path'])) {
                $extension = pathinfo($data['media_path'], PATHINFO_EXTENSION);
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $data['typeContenu'] = 'image';
                    $data['media_type'] = 'image/' . $extension;
                } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                    $data['typeContenu'] = 'video';
                    $data['media_type'] = 'video/' . $extension;
                }
            } else {
                $data['typeContenu'] = 'text';
            }
        }
        
        if (!isset($data['like'])) {
            $data['like'] = 0;
        }
        return $this->postRepository->create($data);
    }
    
    public function updatePost($id, $data)
    {
        if (isset($data['media_path']) && !isset($data['typeContenu'])) {
            $extension = pathinfo($data['media_path'], PATHINFO_EXTENSION);
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $data['typeContenu'] = 'image';
                $data['media_type'] = 'image/' . $extension;
            } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                $data['typeContenu'] = 'video';
                $data['media_type'] = 'video/' . $extension;
            }
        }
        return $this->postRepository->update($id, $data);
    }
    
    public function deletePost($id)
    {
        return $this->postRepository->delete($id);
    }
    
    public function getDerniersPosts($limit = 10)
    {
        return $this->postRepository->getDerniersPosts($limit);
    }
    
    public function getPostsPopulaires($limit = 10)
    {
        return $this->postRepository->getPostsPopulaires($limit);
    }
    
    public function getPostsByCommunity($communityId, $paginate = 15)
    {
        return $this->postRepository->getPostsByCommunity($communityId, $paginate);
    }
    
    public function getPostsByUser($userId, $paginate = 15)
    {
        return $this->postRepository->getPostsByUser($userId, $paginate);
    }
    
    public function rechercherPosts($keyword, $paginate = 15)
    {
        return $this->postRepository->rechercherPosts($keyword, $paginate);
    }
    
    public function getPostsSauvegardes($userId, $paginate = 15)
    {
        return $this->postRepository->getPostsSauvegardes($userId, $paginate);
    }
    
    public function sauvegarderPost($postId, $userId)
    {
        return $this->postRepository->sauvegarderPost($postId, $userId);
    }
    
    public function enleverPostSauvegarde($postId, $userId)
    {
        return $this->postRepository->enleverPostSauvegarde($postId, $userId);
    }
    
    public function likePost($postId)
    {
        return $this->postRepository->ajouterLike($postId);
    }
    
    public function ajouterTag($postId, $tagId)
    {
        return $this->postRepository->ajouterTag($postId, $tagId);
    }
    
    public function enleverTag($postId, $tagId)
    {
        return $this->postRepository->enleverTag($postId, $tagId);
    }
}