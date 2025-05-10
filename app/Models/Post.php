<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;
use App\Models\Community;
use App\Models\Poll;
use App\Models\Report;
use App\Models\Tag;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;


    protected $fillable = [
        'titre',
        'contenu',
        'typeContenu',
        'media_path',
        'media_type',
        'datePublication',
        'auteur_id',
        'community_id',
        'like',
    ];

    protected $casts = [
        'datePublication' => 'datetime',
    ];


    public function auteur()
    {
        return $this->belongsTo(User::class, 'auteur_id');
    }



    public function community()
    {
        return $this->belongsTo(Community::class, 'community_id');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function polls()
    {
        return $this->hasMany(Poll::class);
    }


    public function savedBy()
    {
        return $this->belongsToMany(User::class, 'save_posts');
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    
    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }
    
    public function votes()
    {
        return $this->hasMany(PostVote::class);
    }
    
    public function hasVoted($userId)
    {
        return $this->votes()->where('user_id', $userId)->exists();
    }
    
    public function getUserVoteType($userId)
    {
        $vote = $this->votes()->where('user_id', $userId)->first();
        return $vote ? $vote->vote_type : null;
    }
}
