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

    public function create(array $attributes = [])
    {
        $poll = $this->model->create([
            'auteur_id' => $attributes['auteur_id'],
            'post_id' => $attributes['post_id'],
            'typeVote' => $attributes['typeVote'] ?? 'standard',
        ]);
        if (isset($attributes['poll_options']) && is_array($attributes['poll_options'])) {
            $position = 0;
            foreach ($attributes['poll_options'] as $optionText) {
                if (!empty($optionText)) {
                    $poll->options()->create([
                        'text' => $optionText,
                        'position' => $position++
                    ]);
                }
            }
        }
        
        return $poll;
    }

    public function getPollsByPost($postId)
    {
        return $this->model->where('post_id', $postId)
                          ->with(['voters', 'options'])
                          ->get();
    }

    public function getPollsByAuteur($auteurId)
    {
        return $this->model->where('auteur_id', $auteurId)
                          ->with(['post', 'options'])
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
        if ($poll->typeVote === 'standard' && $poll->options()->count() > 0) {
            $options = $poll->options()->orderBy('position')->get();
            $result = [];
            
            foreach ($options as $option) {
                $count = $poll->voters()->wherePivot('vote_value', $option->id)->count();
                $result[$option->id] = [
                    'option' => $option->text,
                    'count' => $count
                ];
            }
            
            return $result;
        }
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
