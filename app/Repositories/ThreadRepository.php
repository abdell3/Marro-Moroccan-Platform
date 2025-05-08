<?php

namespace App\Repositories;

use App\Models\Thread;
use App\Repositories\Interfaces\ThreadRepositoryInterface;

class ThreadRepository extends BaseRepository implements ThreadRepositoryInterface
{
    public function __construct(Thread $model)
    {
        parent::__construct($model);
    }

    public function getLatestThreads($limit = 10)
    {
        return $this->model->with(['user', 'community'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
    
    public function getThreadsByCommunity($communityId, $paginate = 15)
    {
        return $this->model->with(['user', 'community'])
            ->where('community_id', $communityId)
            ->orderBy('created_at', 'desc')
            ->paginate($paginate);
    }
    
    public function getThreadsByUser($userId, $paginate = 15)
    {
        return $this->model->with(['user', 'community'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($paginate);
    }
    
    public function searchThreads($keyword, $paginate = 15)
    {
        return $this->model->with(['user', 'community'])
            ->where('title', 'like', "%{$keyword}%")
            ->orWhere('content', 'like', "%{$keyword}%")
            ->orderBy('created_at', 'desc')
            ->paginate($paginate);
    }
    
    public function getThreadWithDetails($id)
    {
        return $this->model->with(['user', 'community'])->findOrFail($id);
    }
}
