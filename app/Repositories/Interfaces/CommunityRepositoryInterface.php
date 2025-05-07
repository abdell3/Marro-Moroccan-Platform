<?php

namespace App\Repositories\Interfaces;

interface CommunityRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllCommunitiesAlpha();
    public function getCommunitiesPopulaires($limit = 10);
    public function getCommunitiesByUser($userId);
    public function userFollowsCommunity($userId, $communityId);
    public function followCommunity($userId, $communityId);
    public function unfollowCommunity($userId, $communityId);
    public function countMembers($communityId);
    public function getPosts($communityId, $paginate = 15);
    public function getThreads($communityId, $paginate = 15);
}
