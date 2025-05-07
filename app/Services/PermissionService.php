<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Services\Interfaces\PermissionServiceInterface;

class PermissionService implements PermissionServiceInterface
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAllPermissions()
    {
        return $this->permissionRepository->all();
    }
    
    public function getAllPermissionsAlpha()
    {
        return $this->permissionRepository->getAllPermissionsAlpha();
    }
    
    public function getPermissionById($id)
    {
        return $this->permissionRepository->find($id);
    }
    
    public function createPermission($data)
    {
        $data['name'] = trim($data['name']);
        if ($this->permissionRepository->permissionExistsByName($data['name'])) {
            return $this->permissionRepository->getPermissionByName($data['name']);
        }
        return $this->permissionRepository->create($data);
    }

    public function updatePermission($id, $data)
    {
        if (isset($data['name'])) {
            $data['name'] = trim($data['name']);
        }
        return $this->permissionRepository->update($id, $data);
    }
    
    public function deletePermission($id)
    {
        return $this->permissionRepository->delete($id);
    }
    
    public function getPermissionsByRole($roleId)
    {
        return $this->permissionRepository->getPermissionsByRole($roleId);
    }
    
    public function getOrCreatePermissionByName($name)
    {
        $name = trim($name);
        if ($this->permissionRepository->permissionExistsByName($name)) {
            return $this->permissionRepository->getPermissionByName($name);
        }
        $data = [
            'name' => $name,
        ];
        return $this->permissionRepository->create($data);
    }
    
    public function attachPermissionsToRole($roleId, $permissionIds)
    {
        return $this->permissionRepository->attachPermissionsToRole($roleId, $permissionIds);
    }
    
    public function detachPermissionsFromRole($roleId, $permissionIds)
    {
        return $this->permissionRepository->detachPermissionsFromRole($roleId, $permissionIds);
    }
    
    public function syncRolePermissions($roleId, $permissionIds)
    {   
        $role = Role::find($roleId);
        if (!$role) {
            return false;
        }
        $role->permissions()->sync($permissionIds);
        return true;
    }
}
