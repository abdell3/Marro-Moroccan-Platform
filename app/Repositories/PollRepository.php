<?php

namespace App\Repositories;

use App\Models\Poll;
use App\Repositories\Interfaces\PollRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PollRepository extends BaseRepository implements PollRepositoryInterface
{
    public function __construct(Poll $model)
    {
        parent::__construct($model);
    }

    public function getPollsByPost($postId)
    {
        return $this->model->where('post_id', $postId)
                          ->with('voters')
                          ->get();
    }

    public function getPollsByAuteur($auteurId)
    {
        return $this->model->where('auteur_id', $auteurId)
                          ->with('post')
                          ->get();
    }

    public function vote($pollId, $userId, $voteValue)
    {
        $poll = $this->find($pollId);
        $existingVote = $poll->voters()->where('user_id', $userId)->first();
        
        if ($existingVote) {
            $poll->voters()->updateExistingPivot($userId, [
                'vote_value' => $voteValue,
                'updated_at' => now()
            ]);
        } else {
            $poll->voters()->attach($userId, [
                'vote_value' => $voteValue,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        return true;
    }

    public function getUserVote($pollId, $userId)
    {
        $poll = $this->find($pollId);
        return $poll->voters()->where('user_id', $userId)->first();
    }

    public function getVoteCount($pollId, $voteValue = null)
    {
        $poll = $this->find($pollId);
        $query = $poll->voters();
        
        if (!is_null($voteValue)) {
            $query->wherePivot('vote_value', $voteValue);
        }
        
        return $query->count();
    }
    
    public function getVotesDistribution($pollId)
    {
        $poll = $this->find($pollId);
        $votes = $poll->voters()
            ->select('vote_value')
            ->selectRaw('count(*) as count')
            ->groupBy('vote_value')
            ->pluck('count', 'vote_value')
            ->toArray();
            
        $distribution = [];
        for ($i = 0; $i <= 5; $i++) {
            $distribution[$i] = $votes[$i] ?? 0;
        }
        
        return $distribution;
    }
}
