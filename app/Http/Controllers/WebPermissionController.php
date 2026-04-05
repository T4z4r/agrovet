<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class WebPermissionController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        return view('permissions.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'name' => 'required|string|unique:permissions,name'
        ]);

        Permission::create(['name' => $data['name']]);

        return redirect()->route('web.permissions.index')->with('success', 'Permission created successfully');
    }

    public function show($id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $permission = Permission::findOrFail($id);
        return view('permissions.show', compact('permission'));
    }

    public function edit($id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $permission = Permission::findOrFail($id);
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $permission = Permission::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $id
        ]);

        $permission->update(['name' => $data['name']]);

        return redirect()->route('web.permissions.index')->with('success', 'Permission updated successfully');
    }

    public function destroy($id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        Permission::findOrFail($id)->delete();
        return redirect()->route('web.permissions.index')->with('success', 'Permission deleted successfully');
    }
}