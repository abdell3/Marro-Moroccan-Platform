<?php

namespace App\Repositories\Interfaces;


use App\Repositories\Interfaces\BaseRepositoryInterface;

interface ThreadRepositoryInterface extends BaseRepositoryInterface
{
    public function getLatestThreads($limit = 10);
    public function getThreadsByCommunity($communityId, $paginate = 15);
    public function getThreadsByUser($userId, $paginate = 15);
    public function searchThreads($keyword, $paginate = 15);
    public function getThreadWithDetails($id); 
}
