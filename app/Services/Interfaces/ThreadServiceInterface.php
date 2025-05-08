<?php

namespace App\Services\Interfaces;

interface ThreadServiceInterface
{
    public function getAllThreads();
    public function getThreadById($id);
    public function getThreadWithDetails($id);
    public function createThread($data);
    public function updateThread($id, $data);
    public function deleteThread($id);
    public function getLatestThreads($limit = 10);
    public function getThreadsByCommunity($communityId, $paginate = 15);
    public function getThreadsByUser($userId, $paginate = 15);
    public function searchThreads($keyword, $paginate = 15);
}
