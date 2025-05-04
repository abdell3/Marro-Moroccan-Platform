<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Report;
use App\Models\Post;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    protected $fillable = [
        'post_id',
        'auteur_id',
        'parent_id',
        'contenu',
        'datePublication',
    ];

    protected $casts = [
        'datePublication' => 'datetime',
    ];


    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function auteur()
    {
        return $this->belongsTo(User::class, 'auteur_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('auteur');
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}
