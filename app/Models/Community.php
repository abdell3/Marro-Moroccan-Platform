<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;
use App\Models\Thread;

class Community extends Model
{
    /** @use HasFactory<\Database\Factories\CommunityFactory> */
    use HasFactory;


    protected $fillable = [
        'creator_id',
        'theme_name',
        'description',
        'rules',
        'icon',
    ];


    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_community');
    }

    public function members()
    {
        return $this->followers();
    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }


    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
    
    public function getIconUrlAttribute()
    {
        if (!$this->icon) {
            return null;
        }
        return asset('storage/' . $this->icon);
    }
    
    public function bannedUsers()
    {
        return $this->hasMany(BannedUser::class);
    }
    
    public function isUserBanned($userId)
    {
        return $this->bannedUsers()
            ->where('user_id', $userId)
            ->where('banned_until', '>', now())
            ->exists();
    }
}
