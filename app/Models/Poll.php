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


    public function user()
    {
        return $this->belongsTo(User::class, 'auteur_id');
    }


    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }


}
