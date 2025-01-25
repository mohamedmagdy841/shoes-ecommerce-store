<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageRoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role:Super Admin,admin'),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $roles = Role::paginate(5);
            return view('admin.role.index', compact('roles'));
        } catch (\Exception $e) {
            return redirect()->route('admin.roles.index')->withErrors('Failed to load roles.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $permissions = Permission::where('guard_name', 'admin')->get();
            return view('admin.role.create', compact('permissions'));
        } catch (\Exception $e) {
            return redirect()->route('admin.roles.index')->withErrors('Failed to load permissions.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        try {
            $data = $request->validated();
            $role = Role::create(['name' => $data['name'], 'guard_name' => 'admin']);
            if (isset($data['permissionArray'])) {
                foreach ($data['permissionArray'] as $permission => $value) {
                    $role->givePermissionTo($permission);
                }
            }

            notyf()->success('Role has been created');
            return redirect()->route('admin.roles.index');
        } catch (\Exception $e) {
            return redirect()->route('admin.roles.index')->withErrors('Failed to create role.');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        try {
            $permissions = Permission::where('guard_name', 'admin')->get();
            return view('admin.role.edit', compact('role', 'permissions'));
        } catch (\Exception $e) {
            return redirect()->route('admin.roles.index')->withErrors('Failed to load role data.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            $data = $request->validated();
            $role->update(['name' => $data['name'], 'guard_name' => 'admin']);
            $role->syncPermissions();
            if (isset($data['permissionArray'])) {
                foreach ($data['permissionArray'] as $permission => $value) {
                    $role->givePermissionTo($permission);
                }
            }

            notyf()->success('Role has been updated');
            return redirect()->route('admin.roles.index');
        } catch (\Exception $e) {
            return redirect()->route('admin.roles.index')->withErrors('Failed to update role.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            $role->syncPermissions();
            $role->delete();
            notyf()->success('Role has been deleted');
            return redirect()->route('admin.roles.index');
        } catch (\Exception $e) {
            return redirect()->route('admin.roles.index')->withErrors('Failed to delete role.');
        }
    }
}
