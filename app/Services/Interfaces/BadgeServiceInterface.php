<?php

namespace App\Services\Interfaces;

interface BadgeServiceInterface
{
    public function getAllBadges();
    public function getBadgeById($id);
    public function createBadge(array $data);
    public function updateBadge($id, array $data);
    public function deleteBadge($id);
    public function assignBadgeToUser($badgeId, $userId);
    public function removeBadgeFromUser($badgeId, $userId);
    public function getBadgesByUser($userId);
    public function getBadgesByCriteria($criteria);
}
