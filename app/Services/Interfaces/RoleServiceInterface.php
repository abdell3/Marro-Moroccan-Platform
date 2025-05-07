<?php

namespace App\Services\Interfaces;

interface RoleServiceInterface
{
    public function getAllRoles();
    public function getAllRolesAlpha();
    public function getRoleById($id);
    public function getRoleWithPermissions($id);
    public function createRole($data);
    public function updateRole($id, $data);
    public function deleteRole($id);
    public function getUsersByRole($roleId);
    public function getOrCreateRoleByName($roleName, $description = null);
    public function assignRoleToUser($roleId, $userId);
    public function addPermissionsToRole($roleId, $permissionIds);
    public function updateRolePermissions($roleId, $permissionIds);
}
