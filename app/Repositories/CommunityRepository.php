<?php

namespace App\Repositories;

use App\Models\Community;
use App\Repositories\Interfaces\CommunityRepositoryInterface;

class CommunityRepository extends BaseRepository implements CommunityRepositoryInterface    
{
    public function __construct(Community $model)
    {
        parent::__construct($model);
    }

    public function getAllCommunitiesAlpha()
    {
        return $this->model->orderBy('theme_name', 'asc')->get();
    }
    
    public function getCommunitiesPopulaires($limit = 10)
    {
        return $this->model->withCount('followers')
            ->orderBy('followers_count', 'desc')
            ->limit($limit)
            ->get();
    }
    
    public function getCommunitiesByUser($userId)
    {
        return $this->model->whereHas('followers', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    }
    
    public function getCommunitiesCreatedByUserWithCounts($userId)
    {
        return $this->model
            ->where('creator_id', $userId)
            ->withCount(['followers', 'posts'])
            ->get();
    }
    
    public function userFollowsCommunity($userId, $communityId)
    {
        $community = $this->find($communityId);
        return $community->followers()->where('user_id', $userId)->exists();
    }
    
    public function followCommunity($userId, $communityId)
    {
        $community = $this->find($communityId);
        if ($this->userFollowsCommunity($userId, $communityId)) {
            return true; 
        }
        $community->followers()->attach($userId);
        return true;
    }
    
    public function unfollowCommunity($userId, $communityId)
    {
        $community = $this->find($communityId);
        $community->followers()->detach($userId);
        return true;
    }
    
    public function countMembers($communityId)
    {
        $community = $this->find($communityId);
        return $community->followers()->count();
    }
    
    public function getPosts($communityId, $paginate = 15)
    {
        $community = $this->find($communityId);
        return $community->posts()->with('auteur')->orderBy('created_at', 'desc')->paginate($paginate);
    }
    
    public function getThreads($communityId, $paginate = 15)
    {
        $community = $this->find($communityId);
        return $community->threads()->with('user')->orderBy('created_at', 'desc')->paginate($paginate);
    }
    
    public function getMostActiveCommunities($limit = 5)
    {
        return $this->model->withCount(['posts', 'followers as members_count'])
            ->orderBy('posts_count', 'desc')
            ->limit($limit)
            ->get();
    }
}
