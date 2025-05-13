<?php

namespace App\Services;

use App\Models\Community;
use App\Repositories\Interfaces\CommunityRepositoryInterface;
use App\Services\Interfaces\CommunityServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;

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
        if (!isset($data['creator_id']) || empty($data['creator_id'])) {
            $data['creator_id'] = auth()->id();
        }
        
        if (isset($data['icon_file']) && $data['icon_file']) {
            $file = $data['icon_file'];
            $fileName = 'community_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('community_icons', $fileName, 'public');
            $data['icon'] = 'community_icons/' . $fileName;
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
                try {
                    if (\Storage::disk('public')->exists($community->icon)) {
                        \Storage::disk('public')->delete($community->icon);
                    }
                } catch (\Exception $e) {
                }
            }
            $file = $data['icon_file'];
            $fileName = 'community_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('community_icons', $fileName, 'public');
            $data['icon'] = 'community_icons/' . $fileName;
            unset($data['icon_file']);
        }
        return $this->communityRepository->update($id, $data);
    }
    
    public function deleteCommunity($id)
    {
        $community = $this->getCommunityById($id);
        if ($community->icon) {
            try {
                if (\Storage::disk('public')->exists($community->icon)) {
                    \Storage::disk('public')->delete($community->icon);
                }
            } catch (\Exception $e) {
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
        return Community::where('theme_name', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->paginate($paginate);
    }
    
    public function getCommunitiesCreatedByUserWithCounts($userId)
    {
        return $this->communityRepository->getCommunitiesCreatedByUserWithCounts($userId);
    }
   
    public function getCommunityMembersWithStats($communityId, $perPage = 20)
    {
        $community = $this->getCommunityById($communityId);
        return $community->followers()
            ->withCount('posts')
            ->orderBy('prenom')
            ->paginate($perPage);
    }
    
    public function getPostsPerDay($communityId, $days = 30)
    {
        $community = $this->getCommunityById($communityId);
        return $community->posts()
            ->whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)', [$days])
            ->selectRaw('DATE(created_at) as date, count(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
   
    public function getMembersPerDay($communityId, $days = 30)
    {
        $community = $this->getCommunityById($communityId);
        return $community->followers()
            ->whereRaw('user_community.created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)', [$days])
            ->selectRaw('DATE(user_community.created_at) as date, count(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
    
    public function getTopMembers($communityId, $limit = 5)
    {
        $community = $this->getCommunityById($communityId);
        return $community->followers()
            ->withCount(['posts' => function($query) use ($communityId) {
                $query->where('community_id', $communityId);
            }])
            ->orderBy('posts_count', 'desc')
            ->limit($limit)
            ->get();
    }
    
    public function banUserFromCommunity($communityId, $userId, $moderatorId, $reason)
    {
        $community = $this->getCommunityById($communityId);
        
        if (!$community->followers()->where('user_id', $userId)->exists()) {
            return false;
        }
        $community->followers()->detach($userId);
        DB::table('community_bans')->insert([
            'community_id' => $communityId,
            'user_id' => $userId,
            'moderator_id' => $moderatorId,
            'reason' => $reason,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return true;
    }

    public function getCommunitiesCreatedByUser($userId)
    {
        return $this->communityRepository->model
            ->where('creator_id', $userId)
            ->orderBy('theme_name')
            ->get();
    }

    public function countNewMembersByPeriod($userId, $days = 30, $communityId = null)
    {
        $query = DB::table('user_community')
            ->join('communities', 'user_community.community_id', '=', 'communities.id')
            ->whereRaw('user_community.created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)', [$days])
            ->where('communities.creator_id', $userId);
        
        if ($communityId) {
            $query->where('communities.id', $communityId);
        }
        
        return $query->count();
    }

    public function countNewPostsByPeriod($userId, $days = 30, $communityId = null)
    {
        $query = DB::table('posts')
            ->join('communities', 'posts.community_id', '=', 'communities.id')
            ->whereRaw('posts.created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)', [$days])
            ->where('communities.creator_id', $userId);
        
        if ($communityId) {
            $query->where('communities.id', $communityId);
        }
        
        return $query->count();
    }

    public function getCommunityStatsByPeriod($userId, $days = 30, $communityId = null)
    {
        $query = Community::select('id', 'theme_name')
            ->where('creator_id', $userId);

        if ($communityId) {
            $query->where('id', $communityId);
        }

        $communities = $query->get();
        
        foreach ($communities as $community) {
            $community->members_count = DB::table('user_community')
                ->where('community_id', $community->id)
                ->count();
            
            $community->new_members_count = DB::table('user_community')
                ->where('community_id', $community->id)
                ->whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)', [$days])
                ->count();
            
            $community->posts_count = DB::table('posts')
                ->where('community_id', $community->id)
                ->count();
            
            $community->new_posts_count = DB::table('posts')
                ->where('community_id', $community->id)
                ->whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)', [$days])
                ->count();
            
            $oldMembersCount = $community->members_count - $community->new_members_count;
            if ($oldMembersCount > 0) {
                $community->growth_rate = ($community->new_members_count / $oldMembersCount) * 100;
            } else {
                $community->growth_rate = $community->new_members_count > 0 ? 100 : 0;
            }
        }
        return $communities;
    }
    
    public function getMembersCount($communityId)
    {
        return $this->communityRepository->countMembers($communityId);
    }
    
    public function getCommunityMembersWithPostsCount($communityId, $perPage = 20)
    {
        $community = $this->getCommunityById($communityId);
        if (!$community) {
            return collect([]);
        }
        
        return $community->followers()
            ->withCount(['posts' => function($query) use ($communityId) {
                $query->where('community_id', $communityId);
            }])
            ->orderBy('prenom')
            ->paginate($perPage);
    }
    
    public function getPostsCount($communityId)
    {
        $community = $this->getCommunityById($communityId);
        if (!$community) {
            return 0;
        }
        
        return $community->posts()->count();
    }
    
    public function getRecentPostsCount($communityId, $days = 30)
    {
        $community = $this->getCommunityById($communityId);
        if (!$community) {
            return 0;
        }
        
        return $community->posts()
            ->where('created_at', '>=', now()->subDays($days))
            ->count();
    }
    
    public function getNewMembersCount($communityId, $days = 30)
    {
        $community = $this->getCommunityById($communityId);
        if (!$community) {
            return 0;
        }
        
        return $community->followers()
            ->wherePivot('created_at', '>=', now()->subDays($days))
            ->count();
    }
    
    public function getTopMembersWithPostsCount($communityId, $limit = 5)
    {
        $community = $this->getCommunityById($communityId);
        if (!$community) {
            return collect([]);
        }
        
        return $community->followers()
            ->withCount(['posts' => function($query) use ($communityId) {
                $query->where('community_id', $communityId);
            }])
            ->orderByDesc('posts_count')
            ->limit($limit)
            ->get();
    }
    
    public function getActiveCommunities($limit = 5)
    {
        return $this->communityRepository->getMostActiveCommunities($limit);
    }
}
