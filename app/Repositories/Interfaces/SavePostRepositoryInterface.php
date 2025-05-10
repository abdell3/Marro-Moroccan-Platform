<?php

namespace App\Repositories\Interfaces;


use App\Repositories\Interfaces\BaseRepositoryInterface;

interface SavePostRepositoryInterface extends BaseRepositoryInterface
{
    public function getSavedPostsByUser($userId, $perPage = 15);
    public function checkIfPostIsSaved($userId, $postId);
}
