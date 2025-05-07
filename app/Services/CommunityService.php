<?php

namespace App\Services;

use App\Repositories\Interfaces\CommunityRepositoryInterface;
use App\Services\Interfaces\CommunityServiceInterface;

class CommunityService implements CommunityServiceInterface
{
    protected $communityRepository;

    public function __construct(CommunityRepositoryInterface $communityRepository)
    {
        $this->communityRepository = $communityRepository;
    }

    public function getAllCommunities()
    {
        return $this->communityRepository->all();
    }
    
    public function getAllCommunitiesAlpha()
    {
        return $this->communityRepository->getAllCommunitiesAlpha();
    }
    
    public function getCommunityById($id)
    {
        return $this->communityRepository->find($id);
    }
    
    public function createCommunity($data)
    {
        $data['theme_name'] = trim($data['theme_name']);
        if (isset($data['icon_file']) && $data['icon_file']) {
            $file = $data['icon_file'];
            $fileName = 'community_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/community_icons', $fileName);
            $data['icon'] = 'storage/community_icons/' . $fileName;
            unset($data['icon_file']);
        }
        
        return $this->communityRepository->create($data);
    }
    
    public function updateCommunity($id, $data)
    {
        if (isset($data['theme_name'])) {
            $data['theme_name'] = trim($data['theme_name']);
        }
        if (isset($data['icon_file']) && $data['icon_file']) {
            $community = $this->getCommunityById($id);
            if ($community->icon) {
                $oldPath = str_replace('storage/', 'public/', $community->icon);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $file = $data['icon_file'];
            $fileName = 'community_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/community_icons', $fileName);
            $data['icon'] = 'storage/community_icons/' . $fileName;
            unset($data['icon_file']);
        }
        return $this->communityRepository->update($id, $data);
    }
    
    public function deleteCommunity($id)
    {
        $community = $this->getCommunityById($id);
        if ($community->icon) {
            $path = str_replace('storage/', 'public/', $community->icon);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        return $this->communityRepository->delete($id);
    }
    
    public function getCommunitiesPopulaires($limit = 10)
    {
        return $this->communityRepository->getCommunitiesPopulaires($limit);
    }
    
    public function getCommunitiesByUser($userId)
    {
        return $this->communityRepository->getCommunitiesByUser($userId);
    }
    
    public function userFollowsCommunity($userId, $communityId)
    {
        return $this->communityRepository->userFollowsCommunity($userId, $communityId);
    }
    
    public function followCommunity($userId, $communityId)
    {
        return $this->communityRepository->followCommunity($userId, $communityId);
    }
    
    public function unfollowCommunity($userId, $communityId)
    {
        return $this->communityRepository->unfollowCommunity($userId, $communityId);
    }
    
    public function countMembers($communityId)
    {
        return $this->communityRepository->countMembers($communityId);
    }
    
    public function getPosts($communityId, $paginate = 15)
    {
        return $this->communityRepository->getPosts($communityId, $paginate);
    }
    
    public function getThreads($communityId, $paginate = 15)
    {
        return $this->communityRepository->getThreads($communityId, $paginate);
    }
    
    public function searchCommunities($keyword, $paginate = 15)
    {
        return $this->communityRepository->model
            ->where('theme_name', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->paginate($paginate);
    }
}
