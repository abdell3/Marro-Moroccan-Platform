<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Permission;

class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;


    protected $fillable = [
        'role_name',
        'description'
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }


    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }



}
