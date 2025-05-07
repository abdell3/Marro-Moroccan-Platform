<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Role;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }
    public function getAllPermissionsAlpha()
    {
        return $this->model->orderBy('name', 'asc')->get();
    }
    
    public function getPermissionsByRole($roleId)
    {
        $role = Role::find($roleId);
        if (!$role) {
            return collect();
        }
        return $role->permissions;
    }
    
    public function permissionExistsByName($name)
    {
        return $this->model->where('name', $name)->exists();
    }
    
    public function getPermissionByName($name)
    {
        return $this->model->where('name', $name)->first();
    }
    
    public function attachPermissionsToRole($roleId, $permissionIds)
    {
        $role = Role::find($roleId);
        if (!$role) {
            return false;
        }
        $role->permissions()->attach($permissionIds);
        return true;
    }
    
    public function detachPermissionsFromRole($roleId, $permissionIds)
    {
        $role = Role::find($roleId);
        if (!$role) {
            return false;
        }
        $role->permissions()->detach($permissionIds);
        return true;
    }
}
