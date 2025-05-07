<?php

namespace App\Services;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Services\Interfaces\PermissionServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;

class RoleService implements RoleServiceInterface
{
    protected $roleRepository;
    protected $permissionService;

    public function __construct(
        RoleRepositoryInterface $roleRepository,
        PermissionServiceInterface $permissionService
    ) {
        $this->roleRepository = $roleRepository;
        $this->permissionService = $permissionService;
    }

    public function getAllRoles()
    {
        return $this->roleRepository->all();
    }
    
    public function getAllRolesAlpha()
    {
        return $this->roleRepository->getAllRolesAlpha();
    }
    
    public function getRoleById($id)
    {
        return $this->roleRepository->find($id);
    }

    public function getRoleWithPermissions($id)
    {
        return $this->roleRepository->getRoleWithPermissions($id);
    }
    
    public function createRole($data)
    {
        $data['role_name'] = trim($data['role_name']);
        if ($this->roleRepository->roleExistsByName($data['role_name'])) {
            return $this->roleRepository->getRoleByName($data['role_name']);
        }
        $role = $this->roleRepository->create($data);
        if (isset($data['permissions']) && is_array($data['permissions'])) {
            $this->permissionService->attachPermissionsToRole($role->id, $data['permissions']);
        }
        return $role;
    }
    
    public function updateRole($id, $data)
    {
        if (isset($data['role_name'])) {
            $data['role_name'] = trim($data['role_name']);
        }
        
        $role = $this->roleRepository->update($id, $data);
        if (isset($data['permissions']) && is_array($data['permissions'])) {
            $this->updateRolePermissions($id, $data['permissions']);
        }
        return $role;
    }
    
    public function deleteRole($id)
    {
        return $this->roleRepository->delete($id);
    }
    
    public function getUsersByRole($roleId)
    {
        return $this->roleRepository->getUsersByRole($roleId);
    }
    
    public function getOrCreateRoleByName($roleName, $description = null)
    {
        $roleName = trim($roleName);
        if ($this->roleRepository->roleExistsByName($roleName)) {
            return $this->roleRepository->getRoleByName($roleName);
        }
        
        $data = [
            'role_name' => $roleName,
            'description' => $description,
        ];
        return $this->roleRepository->create($data);
    }
    
    public function assignRoleToUser($roleId, $userId)
    {
        return $this->roleRepository->assignRoleToUser($roleId, $userId);
    }
    
    public function addPermissionsToRole($roleId, $permissionIds)
    {
        return $this->permissionService->attachPermissionsToRole($roleId, $permissionIds);
    }
    
    public function updateRolePermissions($roleId, $permissionIds)
    {
        return $this->permissionService->syncRolePermissions($roleId, $permissionIds);
    }
}
