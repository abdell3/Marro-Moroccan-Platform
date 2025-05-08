<?php

namespace App\Services;

use App\Repositories\Interfaces\ThreadRepositoryInterface;
use App\Services\Interfaces\ThreadServiceInterface;

class ThreadService implements ThreadServiceInterface
{
    protected $threadRepository;

    public function __construct(ThreadRepositoryInterface $threadRepository)
    {
        $this->threadRepository = $threadRepository;
    }

    public function getAllThreads()
    {
        return $this->threadRepository->all();
    }
    
    public function getThreadById($id)
    {
        return $this->threadRepository->find($id);
    }
    
    public function getThreadWithDetails($id)
    {
        return $this->threadRepository->getThreadWithDetails($id);
    }
    
    public function createThread($data)
    {
        $data['title'] = trim($data['title']);
        
        return $this->threadRepository->create($data);
    }
    
    public function updateThread($id, $data)
    {
        if (isset($data['title'])) {
            $data['title'] = trim($data['title']);
        }
        
        return $this->threadRepository->update($id, $data);
    }
    
    public function deleteThread($id)
    {
        return $this->threadRepository->delete($id);
    }
    
    public function getLatestThreads($limit = 10)
    {
        return $this->threadRepository->getLatestThreads($limit);
    }
    
    public function getThreadsByCommunity($communityId, $paginate = 15)
    {
        return $this->threadRepository->getThreadsByCommunity($communityId, $paginate);
    }
    
    public function getThreadsByUser($userId, $paginate = 15)
    {
        return $this->threadRepository->getThreadsByUser($userId, $paginate);
    }
    
    public function searchThreads($keyword, $paginate = 15)
    {
        return $this->threadRepository->searchThreads($keyword, $paginate);
    }
}
