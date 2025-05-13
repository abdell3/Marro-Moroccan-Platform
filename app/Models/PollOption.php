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

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function getVotesCountAttribute()
    {
        return $this->poll->voters()->wherePivot('vote_value', $this->id)->count();
    }
}
