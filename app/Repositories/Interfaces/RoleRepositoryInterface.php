<?php

namespace App\Repositories\Interfaces;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllRolesAlpha();
    public function getRoleWithPermissions($id);
    public function getUsersByRole($roleId);
    public function roleExistsByName($roleName);
    public function getRoleByName($roleName);
    public function assignRoleToUser($roleId, $userId);
}
