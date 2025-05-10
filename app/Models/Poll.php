<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;


class Poll extends Model
{
    /** @use HasFactory<\Database\Factories\PollFactory> */
    use HasFactory;


    protected $fillable = [
        'auteur_id',
        'post_id',
        'typeVote',
    ];


    public function auteur()
    {
        return $this->belongsTo(User::class, 'auteur_id');
    }


    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function voters()
    {
        return $this->belongsToMany(User::class, 'poll_user', 'poll_id', 'user_id')
                    ->withPivot('vote_value')
                    ->withTimestamps();
    }

    public function options()
    {
        return $this->hasMany(PollOption::class)->orderBy('position');
    }


}
