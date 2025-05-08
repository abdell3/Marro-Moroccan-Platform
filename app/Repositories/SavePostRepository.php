<?php

namespace App\Repositories;

use App\Models\SavePost;
use App\Repositories\Interfaces\SavePostRepositoryInterface;

class SavePostRepository extends BaseRepository implements SavePostRepositoryInterface
{
    public function __construct(SavePost $model)
    {
        parent::__construct($model);
    }

    public function getSavedPostsByUser($userId)
    {
        return $this->model->where('user_id', $userId)
                         ->with('post')
                         ->get();
    }

    public function checkIfPostIsSaved($userId, $postId)
    {
        return $this->model->where('user_id', $userId)
                         ->where('post_id', $postId)
                         ->first();
    }
}
