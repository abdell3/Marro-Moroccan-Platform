<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Community;

class Thread extends Model
{
    /** @use HasFactory<\Database\Factories\ThreadFactory> */
    use HasFactory;


    protected $fillable = [
        'title', 
        'content', 
        'user_id',
        'community_id'
    ];



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function community()
    {
        return $this->belongsTo(Community::class);
    }
}





















