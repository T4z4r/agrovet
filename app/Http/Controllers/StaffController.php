<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $owner = auth()->user();

        // Get shops owned by the current user
        $ownedShopIds = $owner->shops()->pluck('id');

        // Query staff users in owned shops
        $query = User::whereIn('shop_id', $ownedShopIds)
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', ['seller', 'manager']);
            })
            ->with(['assignedShop', 'branch', 'roles']);

        // Filters
        if ($request->filled('shop_id')) {
            $query->where('shop_id', $request->shop_id);
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $staff = $query->paginate(15);

        // Get owned shops for filter dropdown
        $shops = $owner->shops;

        // Get branches for filter
        $branches = Branch::whereIn('shop_id', $ownedShopIds)->get();

        return view('staff.index', compact('staff', 'shops', 'branches'));
    }

    public function create()
    {
        $owner = auth()->user();
        $shops = $owner->shops;
        $branches = Branch::whereIn('shop_id', $shops->pluck('id'))->get();
        $roles = Role::whereIn('name', ['seller', 'manager'])->get();

        return view('staff.create', compact('shops', 'branches', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'shop_id' => 'required|exists:shops,id',
            'branch_id' => 'nullable|exists:branches,id',
            'role' => 'required|in:seller,manager',
        ]);

        $owner = auth()->user();

        // Ensure the shop is owned by the current user
        if (!$owner->shops()->where('id', $request->shop_id)->exists()) {
            abort(403, 'Unauthorized');
        }

        // If branch is specified, ensure it belongs to the shop
        if ($request->branch_id && !Branch::where('id', $request->branch_id)->where('shop_id', $request->shop_id)->exists()) {
            abort(403, 'Invalid branch');
        }

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'shop_id' => $request->shop_id,
                'branch_id' => $request->branch_id,
                'is_active' => true,
                'otp_verified' => true, // Assume verified for staff
            ]);

            $user->assignRole($request->role);
        });

        return redirect()->route('staff.index')->with('success', 'Staff member created successfully.');
    }

    public function show(User $user)
    {
        // Check if user is staff in owner's shops
        $owner = auth()->user();
        if (!$owner->shops()->where('id', $user->shop_id)->exists() || !$user->hasAnyRole(['seller', 'manager'])) {
            abort(403, 'Unauthorized');
        }

        $user->load(['assignedShop', 'branch', 'roles']);

        return view('staff.show', compact('user'));
    }

    public function edit(User $user)
    {
        // Check if user is staff in owner's shops
        $owner = auth()->user();
        if (!$owner->shops()->where('id', $user->shop_id)->exists() || !$user->hasAnyRole(['seller', 'manager'])) {
            abort(403, 'Unauthorized');
        }

        $shops = $owner->shops;
        $branches = Branch::whereIn('shop_id', $shops->pluck('id'))->get();
        $roles = Role::whereIn('name', ['seller', 'manager'])->get();

        return view('staff.edit', compact('user', 'shops', 'branches', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Check if user is staff in owner's shops
        $owner = auth()->user();
        if (!$owner->shops()->where('id', $user->shop_id)->exists() || !$user->hasAnyRole(['seller', 'manager'])) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'shop_id' => 'required|exists:shops,id',
            'branch_id' => 'nullable|exists:branches,id',
            'role' => 'required|in:seller,manager',
            'is_active' => 'boolean',
        ]);

        // Ensure the shop is owned by the current user
        if (!$owner->shops()->where('id', $request->shop_id)->exists()) {
            abort(403, 'Unauthorized');
        }

        // If branch is specified, ensure it belongs to the shop
        if ($request->branch_id && !Branch::where('id', $request->branch_id)->where('shop_id', $request->shop_id)->exists()) {
            abort(403, 'Invalid branch');
        }

        DB::transaction(function () use ($request, $user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'shop_id' => $request->shop_id,
                'branch_id' => $request->branch_id,
                'is_active' => $request->is_active ?? true,
            ]);

            // Update role
            $user->syncRoles([$request->role]);
        });

        return redirect()->route('staff.index')->with('success', 'Staff member updated successfully.');
    }

    public function destroy(User $user)
    {
        // Check if user is staff in owner's shops
        $owner = auth()->user();
        if (!$owner->shops()->where('id', $user->shop_id)->exists() || !$user->hasAnyRole(['seller', 'manager'])) {
            abort(403, 'Unauthorized');
        }

        $user->delete(); // Soft delete

        return redirect()->route('staff.index')->with('success', 'Staff member deleted successfully.');
    }

    public function assignRole(Request $request, User $user)
    {
        // Check if user is staff in owner's shops
        $owner = auth()->user();
        if (!$owner->shops()->where('id', $user->shop_id)->exists() || !$user->hasAnyRole(['seller', 'manager'])) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'role' => 'required|in:seller,manager',
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'Role assigned successfully.');
    }
}
