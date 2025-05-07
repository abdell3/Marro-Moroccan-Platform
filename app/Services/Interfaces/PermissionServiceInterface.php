<?php

namespace App\Services\Interfaces;

interface PermissionServiceInterface
{
    public function getAllPermissions();
    public function getAllPermissionsAlpha();
    public function getPermissionById($id);
    public function createPermission($data);
    public function updatePermission($id, $data);
    public function deletePermission($id);
    public function getPermissionsByRole($roleId);
    public function getOrCreatePermissionByName($name);
    public function attachPermissionsToRole($roleId, $permissionIds);
    public function detachPermissionsFromRole($roleId, $permissionIds);
    public function syncRolePermissions($roleId, $permissionIds);
}
