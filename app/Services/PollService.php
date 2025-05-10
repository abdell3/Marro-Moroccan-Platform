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
        if (isset($data['question']) && !empty($data['question'])) {
            $this->postRepository->update($data['post_id'], [
                'contenu' => $data['question']
            ]);
        }
        if (($data['typeVote'] ?? 'standard') === 'standard' && 
            (!isset($data['poll_options']) || 
            !is_array($data['poll_options']) || 
            count(array_filter($data['poll_options'])) < 2)) {
            throw new \InvalidArgumentException('Un sondage standard doit avoir au moins 2 options');
        }
        
        return $this->pollRepository->create($data);
    }

    public function vote($pollId, $voteValue, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        // Pour le type standard, vérifier que l'option existe
        $poll = $this->pollRepository->find($pollId);
        if (!$poll) {
            return false;
        }
        
        if ($poll->typeVote === 'standard') {
            $optionExists = $poll->options()->where('id', $voteValue)->exists();
            if (!$optionExists) {
                return false;
            }
        } else {
            if ($poll->typeVote === 'etoiles' && ($voteValue < 1 || $voteValue > 5)) {
                return false;
            } elseif ($poll->typeVote === 'pouces' && ($voteValue < 0 || $voteValue > 1)) {
                return false;
            }
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
        $totalVotes = 0;
        $results = [];
        
        if ($poll->typeVote === 'standard' && $poll->options()->count() > 0) {
            foreach ($distribution as $optionId => $data) {
                $totalVotes += $data['count'];
                $results[$optionId] = $data;
            }
            foreach ($results as $optionId => &$data) {
                $data['percentage'] = $totalVotes > 0 ? round(($data['count'] / $totalVotes) * 100, 2) : 0;
            }
        } else {
            $totalVotes = array_sum($distribution);
            foreach ($distribution as $value => $count) {
                $percentage = $totalVotes > 0 ? ($count / $totalVotes) * 100 : 0;
                $results[$value] = [
                    'count' => $count,
                    'percentage' => round($percentage, 2)
                ];
            }
        }
        
        return [
            'poll' => $poll,
            'results' => $results,
            'total_votes' => $totalVotes
        ];
    }
}
