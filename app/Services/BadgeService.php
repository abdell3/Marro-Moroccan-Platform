<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use App\Repositories\Interfaces\BadgeRepositoryInterface;
use App\Services\Interfaces\BadgeServiceInterface;

class BadgeService implements BadgeServiceInterface
{
    protected $badgeRepository;

    public function __construct(BadgeRepositoryInterface $badgeRepository = null)
    {
        $this->badgeRepository = $badgeRepository;
    }

    public function getAllBadges()
    {
        if ($this->badgeRepository) {
            return $this->badgeRepository->all();
        } else {
            return Badge::withCount('users')->get();
        }
    }

    public function getBadgeById($id)
    {
        if ($this->badgeRepository) {
            return $this->badgeRepository->find($id);
        } else {
            return Badge::findOrFail($id);
        }
    }

    public function createBadge(array $data)
    {
        if ($this->badgeRepository) {
            return $this->badgeRepository->create($data);
        } else {
            return Badge::create($data);
        }
    }

    public function updateBadge($id, array $data)
    {
        $badge = $this->getBadgeById($id);
        
        if ($this->badgeRepository) {
            return $this->badgeRepository->update($id, $data);
        } else {
            $badge->update($data);
            return $badge;
        }
    }

    public function deleteBadge($id)
    {
        $badge = $this->getBadgeById($id);
        $badge->users()->detach();
        if ($this->badgeRepository) {
            return $this->badgeRepository->delete($id);
        } else {
            return $badge->delete();
        }
    }

    public function assignBadgeToUser($badgeId, $userId)
    {
        $user = User::findOrFail($userId);
        $user->badges()->syncWithoutDetaching([$badgeId]);
        return true;
    }

    public function removeBadgeFromUser($badgeId, $userId)
    {
        $user = User::findOrFail($userId);
        $user->badges()->detach($badgeId);
        return true;
    }

    public function getBadgesByUser($userId)
    {
        $user = User::findOrFail($userId);
        return $user->badges;
    }

    public function getBadgesByCriteria($criteria)
    {
        return Badge::where('critere', 'like', "%{$criteria}%")->get();
    }
}
