<?php

namespace App\Services;

use App\Repositories\Interfaces\PollRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\Interfaces\PollServiceInterface;
use Illuminate\Support\Facades\Auth;

class PollService implements PollServiceInterface
{
    protected $pollRepository;
    protected $postRepository;

    public function __construct(
        PollRepositoryInterface $pollRepository,
        PostRepositoryInterface $postRepository
    ) {
        $this->pollRepository = $pollRepository;
        $this->postRepository = $postRepository;
    }

    public function getAllPolls($perPage = 15)
    {
        return $this->pollRepository->paginate($perPage);
    }
    
    public function getPollById($id)
    {
        return $this->pollRepository->find($id);
    }
    
    public function getPostPolls($postId)
    {
        $post = $this->postRepository->find($postId);
        if (!$post) {
            return collect();
        }
        return $this->pollRepository->getPollsByPost($postId);
    }

    public function getUserPolls($userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        return $this->pollRepository->getPollsByAuteur($userId);
    }

    public function createPoll($data)
    {
        if (isset($data['post_id'])) {
            $post = $this->postRepository->find($data['post_id']);
            
            if (!$post) {
                return null;
            }
        }
        
        if (!isset($data['auteur_id'])) {
            $data['auteur_id'] = Auth::id();
        }
        return $this->pollRepository->create($data);
    }

    public function vote($pollId, $voteValue, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        if ($voteValue < 0 || $voteValue > 5) {
            return false;
        }

        $poll = $this->pollRepository->find($pollId);
        if (!$poll) {
            return false;
        }
        return $this->pollRepository->vote($pollId, $userId, $voteValue);
    }

    public function getUserVote($pollId, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        $poll = $this->pollRepository->find($pollId);
        if (!$poll) {
            return null;
        }
        
        $userVote = $this->pollRepository->getUserVote($pollId, $userId);
        if (!$userVote || !isset($userVote->pivot)) {
            return null;
        }
        return $userVote->pivot->vote_value;
    }

    public function getPollResults($pollId)
    {
        $poll = $this->pollRepository->find($pollId);
        
        if (!$poll) {
            return null;
        }
        $distribution = $this->pollRepository->getVotesDistribution($pollId);
        $totalVotes = array_sum($distribution);

        $results = [];
        foreach ($distribution as $value => $count) {
            $percentage = $totalVotes > 0 ? ($count / $totalVotes) * 100 : 0;
            $results[$value] = [
                'count' => $count,
                'percentage' => round($percentage, 2)
            ];
        }
        return [
            'poll' => $poll,
            'results' => $results,
            'total_votes' => $totalVotes
        ];
    }
}
