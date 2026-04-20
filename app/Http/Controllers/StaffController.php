<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $owner = auth()->user();

        // Query staff users in the authenticated user's shop
        $query = User::where('shop_id', $owner->shop_id)
            ->whereIn('role', ['owner', 'seller']);

        // Filters
        if ($request->filled('shop_id')) {
            $query->where('shop_id', $request->shop_id);
        }

        // if ($request->filled('branch_id')) {
        //     $query->where('branch_id', $request->branch_id);
        // }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $staff = $query->paginate(15);

        // Get owned shops for filter dropdown
        $shops = $owner->shops;

        // Get branches for filter
        // $branches = Branch::whereIn('shop_id', $ownedShopIds)->get();

        return view('staff.index', compact('staff', 'shops'));
    }

    public function create()
    {
        $owner = auth()->user();
        $shops = collect([$owner->assignedShop]);
        $branches = Branch::whereIn('shop_id', $shops->pluck('id'))->get();

        return view('staff.create', compact('shops', 'branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:owner,seller',
            'shop_id' => 'required|exists:shops,id',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        $owner = auth()->user();

        // Ensure the shop is the user's shop
        if ($request->shop_id != $owner->shop_id) {
            abort(403, 'Unauthorized');
        }

        // If branch is specified, ensure it belongs to the shop
        if ($request->branch_id && ! Branch::where('id', $request->branch_id)->where('shop_id', $request->shop_id)->exists()) {
            abort(403, 'Invalid branch');
        }

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'shop_id' => $request->shop_id,
                'branch_id' => $request->branch_id,
                'is_active' => true,
                'otp_verified' => true, // Assume verified for staff
            ]);
        });

        return redirect()->route('staff.index')->with('success', 'Staff member created successfully.');
    }

    public function show(User $staff)
    {
        // Check if user is staff in owner's shops
        $owner = auth()->user();
        if (! $owner->shops()->where('id', $staff->shop_id)->exists() || ! in_array($staff->role, ['owner', 'seller'])) {
            abort(403, 'Unauthorized');
        }

        $staff->load(['assignedShop', 'branch']);

        return view('staff.show', ['user' => $staff]);
    }

    public function edit(User $staff)
    {
        // Check if user is staff in the user's shop
        $owner = auth()->user();
        if ($staff->shop_id != $owner->shop_id || ! in_array($staff->role, ['owner', 'seller'])) {
            abort(403, 'Unauthorized');
        }

        $shops = collect([$owner->assignedShop]);
        $branches = Branch::whereIn('shop_id', $shops->pluck('id'))->get();

        return view('staff.edit', ['user' => $staff, 'shops' => $shops, 'branches' => $branches]);
    }

    public function update(Request $request, User $staff)
    {
        // Check if user is staff in the user's shop
        $owner = auth()->user();
        if ($staff->shop_id != $owner->shop_id || ! in_array($staff->role, ['owner', 'seller'])) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$staff->id,
            'role' => 'required|in:owner,seller',
            'shop_id' => 'required|exists:shops,id',
            'branch_id' => 'nullable|exists:branches,id',
            'is_active' => 'boolean',
        ]);

        // Ensure the shop is the user's shop
        if ($request->shop_id != $owner->shop_id) {
            abort(403, 'Unauthorized');
        }

        // If branch is specified, ensure it belongs to the shop
        if ($request->branch_id && ! Branch::where('id', $request->branch_id)->where('shop_id', $request->shop_id)->exists()) {
            abort(403, 'Invalid branch');
        }

        DB::transaction(function () use ($request, $staff) {
            $staff->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'shop_id' => $request->shop_id,
                'branch_id' => $request->branch_id,
                'is_active' => $request->is_active ?? true,
            ]);
        });

        return redirect()->route('staff.index')->with('success', 'Staff member updated successfully.');
    }

    public function destroy(User $staff)
    {
        // Check if user is staff in the user's shop
        $owner = auth()->user();
        if ($staff->shop_id != $owner->shop_id || ! in_array($staff->role, ['owner', 'seller'])) {
            abort(403, 'Unauthorized');
        }

        $staff->delete(); // Soft delete

        return redirect()->route('staff.index')->with('success', 'Staff member deleted successfully.');
    }
}
