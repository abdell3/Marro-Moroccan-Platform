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
            'preferences' => 'json',
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
        // Forcer le chargement de la relation rôle si elle n'est pas déjà chargée
        if (!$this->relationLoaded('role')) {
            $this->load('role');
        }
        
        // Vérifier si le rôle existe et si son nom correspond, en ignorant la casse
        if (!$this->role) {
            \Illuminate\Support\Facades\Log::warning('Utilisateur sans rôle', [
                'user_id' => $this->id, 
                'email' => $this->email,
                'role_id' => $this->role_id
            ]);
            return false;
        }
        
        $hasRole = strtolower($this->role->role_name) === strtolower($roleName);
        \Illuminate\Support\Facades\Log::info('Vérification du rôle', [
            'user_id' => $this->id,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'user_role' => $this->role->role_name,
            'requested_role' => $roleName,
            'match' => $hasRole ? 'oui' : 'non'
        ]);
        
        return $hasRole;
    }

    public function hasAnyRole(array $roleNames)
    {
        if (!$this->role) {
            return false;
        }
        
        foreach ($roleNames as $roleName) {
            if (strtolower($this->role->role_name) === strtolower($roleName)) {
                return true;
            }
        }
        
        return false;
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
    
    public function postVotes()
    {
        return $this->hasMany(PostVote::class);
    }
}
