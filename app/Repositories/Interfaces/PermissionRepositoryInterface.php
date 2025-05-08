<?php

namespace App\Repositories\Interfaces;
use App\Repositories\Interfaces\BaseRepositoryInterface;


interface PermissionRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllPermissionsAlpha();
    public function getPermissionsByRole($roleId);
    public function permissionExistsByName($name);
    public function getPermissionByName($name);
    public function attachPermissionsToRole($roleId, $permissionIds);
    public function detachPermissionsFromRole($roleId, $permissionIds);
}
