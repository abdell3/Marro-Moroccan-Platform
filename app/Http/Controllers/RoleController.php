<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\Interfaces\PermissionServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class RoleController extends Controller
{
    protected $roleService;
    protected $permissionService;
    
    public function __construct(
        RoleServiceInterface $roleService,
        PermissionServiceInterface $permissionService
    ) {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
        $this->middleware('check.role:Admin');
    }
    
    public function index()
    {
        $roles = $this->roleService->getAllRolesAlpha();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->permissionService->getAllPermissionsAlpha();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $data = $request->validated();
        $role = $this->roleService->createRole($data);
        return redirect()->route('roles.index')
            ->with('success', 'Le rôle a été créé avec succès!');
    }

    public function show(Role $role)
    {
        $role = $this->roleService->getRoleWithPermissions($role->id);
        $users = $this->roleService->getUsersByRole($role->id);
        return view('admin.roles.show', compact('role', 'users'));
    }

    public function edit(Role $role)
    {
        $role = $this->roleService->getRoleWithPermissions($role->id);
        $permissions = $this->permissionService->getAllPermissionsAlpha();
        $selectedPermissions = $role->permissions->pluck('id')->toArray();
        return view('admin.roles.edit', compact('role', 'permissions', 'selectedPermissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $data = $request->validated();
        $this->roleService->updateRole($role->id, $data);
        return redirect()->route('roles.index')
            ->with('success', 'Le rôle a été mis à jour avec succès!');
    }

    public function destroy(Role $role)
    {
        $users = $this->roleService->getUsersByRole($role->id);
        if ($users->count() > 0) {
            return redirect()->route('roles.index')
                ->with('error', 'Ce rôle ne peut pas être supprimé car il est assigné à des utilisateurs.');
        }
        
        $this->roleService->deleteRole($role->id);
        return redirect()->route('roles.index')
            ->with('success', 'Le rôle a été supprimé avec succès!');
    }
    
    public function assignPermissions(Role $role)
    {
        $role = $this->roleService->getRoleWithPermissions($role->id);
        $permissions = $this->permissionService->getAllPermissionsAlpha();
        $selectedPermissions = $role->permissions->pluck('id')->toArray();
        return view('admin.roles.permissions', compact('role', 'permissions', 'selectedPermissions'));
    }
    
    public function updatePermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);
        
        $permissions = $validated['permissions'] ?? [];
        $this->roleService->updateRolePermissions($role->id, $permissions);
        return redirect()->route('roles.show', $role->id)
            ->with('success', 'Les permissions ont été mises à jour avec succès!');
    }
}
