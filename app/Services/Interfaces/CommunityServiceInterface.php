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
}
