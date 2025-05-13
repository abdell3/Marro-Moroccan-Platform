<?php

namespace App\Services\Interfaces;

interface UserServiceInterface
{
    public function getAllUsers($perPage = 15);
    public function getUserById($id);
    public function getUserByEmail($email);
    public function getUsersWithRole($roleId, $perPage = 15);
    public function getUsersCreatedBetween($startDate, $endDate, $perPage = 15);
    public function searchUsers($query, $perPage = 15);
    public function updateUser($id, array $data);
    public function updateUserRole($id, $roleId);
    public function getUserStats($id);
    public function getRecentUsers($limit = 10);
    public function getUsersByActivity($limit = 10);
    public function deleteUser($id);
    public function banUser($userId, $adminId, $reason = null, $days = 30);
    public function unbanUser($userId);
}
