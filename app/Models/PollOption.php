<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'poll_id',
        'text',
        'position'
    ];

    /**
     * Get the poll that owns the option.
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    /**
     * Get the number of votes for this option.
     */
    public function getVotesCountAttribute()
    {
        return $this->poll->voters()->wherePivot('vote_value', $this->id)->count();
    }
}
