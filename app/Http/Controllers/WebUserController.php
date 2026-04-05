<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sale;
use App\Models\Expense;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class WebUserController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $users = User::whereDoesntHave('roles', function($q) {
            $q->where('name', 'owner');
        })->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function show($id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:6|confirmed',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        User::findOrFail($id)->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    public function block($id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'unblocked' : 'blocked';

        return redirect()->route('users.index')->with('success', "User {$status} successfully");
    }

    public function sellerReport($id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($id);

        $start = request('start');
        $end = request('end');

        $sales = Sale::with('items.product')
            ->where('seller_id', $id)
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereBetween('sale_date', [$start, $end]);
            })
            ->get();

        $totalSales = $sales->sum('total');

        $expenses = Expense::where('recorded_by', $id)
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereBetween('date', [$start, $end]);
            })
            ->get();

        $totalExpenses = $expenses->sum('amount');

        $stockTransactions = StockTransaction::with('product', 'supplier')
            ->where('recorded_by', $id)
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereBetween('date', [$start, $end]);
            })
            ->get();

        return view('users.report', compact('user', 'sales', 'totalSales', 'expenses', 'totalExpenses', 'stockTransactions'));
    }

    public function roles($id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.roles', compact('user', 'roles'));
    }

    public function assignRole(Request $request, $id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($id);
        $role = Role::findByName($request->role);
        $user->assignRole($role);

        return redirect()->back()->with('success', 'Role assigned successfully');
    }

    public function removeRole($userId, $roleId)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($userId);
        $role = Role::findOrFail($roleId);
        $user->removeRole($role);

        return redirect()->back()->with('success', 'Role removed successfully');
    }

    public function permissions($id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($id);
        $permissions = Permission::all();
        return view('users.permissions', compact('user', 'permissions'));
    }

    public function givePermission(Request $request, $id)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($id);
        $permission = Permission::findByName($request->permission);
        $user->givePermissionTo($permission);

        return redirect()->back()->with('success', 'Permission granted successfully');
    }

    public function revokePermission($userId, $permissionId)
    {
        if (!auth()->user()->hasAnyRole(['owner', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($userId);
        $permission = Permission::findOrFail($permissionId);
        $user->revokePermissionTo($permission);

        return redirect()->back()->with('success', 'Permission revoked successfully');
    }
}
