<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class WebRoleController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role = Role::create(['name' => $data['name']]);
        if (isset($data['permissions'])) {
            $role->givePermissionTo($data['permissions']);
        }

        return redirect()->route('web.roles.index')->with('success', 'Role created successfully');
    }

    public function show($id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $role = Role::with('permissions')->findOrFail($id);
        return view('roles.show', compact('role'));
    }

    public function edit($id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $role = Role::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role->update(['name' => $data['name']]);
        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('web.roles.index')->with('success', 'Role updated successfully');
    }

    public function destroy($id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        Role::findOrFail($id)->delete();
        return redirect()->route('web.roles.index')->with('success', 'Role deleted successfully');
    }
}