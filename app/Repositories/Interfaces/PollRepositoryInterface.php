<?php

namespace App\Repositories\Interfaces;



use App\Repositories\Interfaces\BaseRepositoryInterface;

interface PollRepositoryInterface extends BaseRepositoryInterface
{
    public function getPollsByPost($postId);
    public function getPollsByAuteur($auteurId);
    public function vote($pollId, $userId, $voteValue);
    public function getUserVote($pollId, $userId);
    public function getVoteCount($pollId, $voteValue = null);
    public function getVotesDistribution($pollId);
}
