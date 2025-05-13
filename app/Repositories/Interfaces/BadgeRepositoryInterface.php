<?php

namespace App\Repositories\Interfaces;

interface BadgeRepositoryInterface extends BaseRepositoryInterface
{
    public function getBadgesWithUserCount();
    public function findByName($name);
    public function getBadgesByCriteria($criteria);
}
