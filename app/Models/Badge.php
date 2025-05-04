<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Badge extends Model
{
    /** @use HasFactory<\Database\Factories\BadgeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'criteria',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'badge_user');
    }
}
