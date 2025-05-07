<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function getAllRolesAlpha()
    {
        return $this->model->orderBy('role_name', 'asc')->get();
    }
    
    public function getRoleWithPermissions($id)
    {
        return $this->model->with('permissions')->findOrFail($id);
    }
    
    public function getUsersByRole($roleId)
    {
        $role = $this->find($roleId);
        return $role->users;
    }
    
    public function roleExistsByName($roleName)
    {
        return $this->model->where('role_name', $roleName)->exists();
    }
    
    public function getRoleByName($roleName)
    {
        return $this->model->where('role_name', $roleName)->first();
    }
    
    public function assignRoleToUser($roleId, $userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return false;
        }
        $user->role_id = $roleId;
        $user->save();
        return true;
    }
}
