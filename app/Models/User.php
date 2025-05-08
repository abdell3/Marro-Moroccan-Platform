<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Badge;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Comment;
Use App\Models\Community;
use App\Models\Poll;
use App\Models\Post;
use App\Models\Report;
use App\Models\ReportType;
use App\Models\Thread;
use App\Models\SavePost;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role_id',
        'badge_id',
        'token',
        'avatar',
        'preferences'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    

    public function badges()
    {
        return $this->belongsToMany(Badge::class);
    }


    public function communities()
    {
        return $this->belongsToMany(Community::class, 'user_community');
    }


    public function posts()
    {
        return $this->hasMany(Post::class, 'auteur_id');
    }



    public function comments()
    {
        return $this->hasMany(Comment::class, 'auteur_id');
    }



    public function polls()
    {
        return $this->hasMany(Poll::class, 'auteur_id');
    }


    public function reports()
    {
        return $this->hasMany(Report::class, 'user_id');
    }

    public function savedPosts()
    {
        return $this->belongsToMany(Post::class, 'save_posts');
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }


    public function hasPermission(string $permission)
    {
        return $this->role?->permissions()->where('name', $permission)->exists() ?? false;
    }

    public function hasRole(string $roleName)
    {
        return $this->role?->role_name === $roleName;
    }

    public function hasAnyRole(array $roleNames)
    {
        if (!$this->role) {
            return false;
        }
        return in_array($this->role->role_name, $roleNames);
    }

    public function isAdmin()
    {
        return $this->hasRole('Admin');
    }

    public function isModerator()
    {
        return $this->hasRole('Moderateur');
    }


    public function voters()
    {
        return $this->belongsToMany(User::class, 'poll_user', 'poll_id', 'user_id')
                    ->withPivot('vote_value')
                    ->withTimestamps();
    }
}
