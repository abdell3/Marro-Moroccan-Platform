<?php

namespace App\Services\Interfaces;

interface CommunityServiceInterface
{
    public function getAllCommunities();
    public function getAllCommunitiesAlpha();
    public function getCommunityById($id);
    public function createCommunity($data);
    public function updateCommunity($id, $data);
    public function deleteCommunity($id);
    public function getCommunitiesPopulaires($limit = 10);
    public function getCommunitiesByUser($userId);
    public function userFollowsCommunity($userId, $communityId);
    public function followCommunity($userId, $communityId);
    public function unfollowCommunity($userId, $communityId);
    public function countMembers($communityId);
    public function getPosts($communityId, $paginate = 15);
    public function getThreads($communityId, $paginate = 15);
    public function searchCommunities($keyword, $paginate = 15);
    public function getCommunitiesCreatedByUserWithCounts($userId);
    public function getCommunityMembersWithStats($communityId, $perPage = 20);
    public function getPostsPerDay($communityId, $days = 30);
    public function getMembersPerDay($communityId, $days = 30);
    public function getTopMembers($communityId, $limit = 5);
    public function banUserFromCommunity($communityId, $userId, $moderatorId, $reason);
    public function getCommunitiesCreatedByUser($userId);
    public function countNewMembersByPeriod($userId, $days = 30, $communityId = null);
    public function countNewPostsByPeriod($userId, $days = 30, $communityId = null);
    public function getCommunityStatsByPeriod($userId, $days = 30, $communityId = null);
    public function getMembersCount($communityId);
    public function getCommunityMembersWithPostsCount($communityId, $perPage = 20);
    public function getPostsCount($communityId);
    public function getRecentPostsCount($communityId, $days = 30);
    public function getNewMembersCount($communityId, $days = 30);
    public function getTopMembersWithPostsCount($communityId, $limit = 5);
    public function getActiveCommunities($limit = 5);
}
