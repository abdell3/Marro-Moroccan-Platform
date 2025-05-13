<?php

namespace App\Repositories;

use App\Models\Badge;
use App\Repositories\Interfaces\BadgeRepositoryInterface;

class BadgeRepository extends BaseRepository implements BadgeRepositoryInterface
{
    public function __construct(Badge $model)
    {
        parent::__construct($model);
    }

    public function getBadgesWithUserCount()
    {
        return $this->model->withCount('users')->get();
    }

    public function findByName($name)
    {
        return $this->model->where('nom', $name)->first();
    }

    public function getBadgesByCriteria($criteria)
    {
        return $this->model->where('critere', 'like', "%{$criteria}%")->get();
    }
}
