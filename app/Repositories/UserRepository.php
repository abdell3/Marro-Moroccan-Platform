<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getUsersByRole($roleId)
    {
        return $this->model->where('role_id', $roleId)->get();
    }

    public function getUsersWithStats($limit)
    {
        return $this->model->withCount(['posts', 'comments', 'communities'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getMostActiveUsers($limit)
    {
        return $this->model->withCount(['posts', 'comments'])
            ->orderByRaw('posts_count + comments_count DESC')
            ->limit($limit)
            ->get();
    }

    public function searchUsers($query, $perPage)
    {
        return $this->model->where('nom', 'like', "%{$query}%")
            ->orWhere('prenom', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->paginate($perPage);
    }

    public function getUserWithRelations($id, array $relations)
    {
        return $this->model->with($relations)->findOrFail($id);
    }
}
