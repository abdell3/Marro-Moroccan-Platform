<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function getUsersByRole($roleId);
    public function getUsersWithStats($limit);
    public function getMostActiveUsers($limit);
    public function searchUsers($query, $perPage);
    public function getUserWithRelations($id, array $relations);
}
