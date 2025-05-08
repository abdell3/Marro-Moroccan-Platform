<?php

namespace App\Repositories\Interfaces;


use App\Repositories\Interfaces\BaseRepositoryInterface;


interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllRolesAlpha();
    public function getRoleWithPermissions($id);
    public function getUsersByRole($roleId);
    public function roleExistsByName($roleName);
    public function getRoleByName($roleName);
    public function assignRoleToUser($roleId, $userId);
}
