<?php

namespace App\Services\Interfaces;

interface PollServiceInterface
{
    public function getAllPolls($perPage = 15);
    public function getPollById($id);
    public function getPostPolls($postId);
    public function getUserPolls($userId = null);
    public function createPoll($data);
    public function vote($pollId, $voteValue, $userId = null);
    public function getUserVote($pollId, $userId = null);
    public function getPollResults($pollId);
}
