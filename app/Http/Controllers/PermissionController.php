<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Services\Interfaces\PermissionServiceInterface;
use Illuminate\Routing\Controller;


class PermissionController extends Controller
{
    protected $permissionService;
    
    public function __construct(PermissionServiceInterface $permissionService)
    {
        $this->permissionService = $permissionService;
        $this->middleware('check.role:Admin');
    }
   
    public function index()
    {
        $permissions = $this->permissionService->getAllPermissionsAlpha();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        $data = $request->validated();
        $permission = $this->permissionService->createPermission($data);
        return redirect()->route('permissions.index')
            ->with('success', 'La permission a été créée avec succès!');
    }

    public function show(Permission $permission)
    {
        $roles = $permission->roles;
        return view('admin.permissions.show', compact('permission', 'roles'));
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $data = $request->validated();
        $this->permissionService->updatePermission($permission->id, $data);
        return redirect()->route('permissions.index')
            ->with('success', 'La permission a été mise à jour avec succès!');
    }

    public function destroy(Permission $permission)
    {
        $this->permissionService->deletePermission($permission->id);
        return redirect()->route('permissions.index')
            ->with('success', 'La permission a été supprimée avec succès!');
    }
}
