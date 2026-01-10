<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;

class WebSubscriptionPackageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $packages = SubscriptionPackage::orderBy('name')->get();
            return response()->json([
                'data' => $packages
            ]);
        }

        $packages = SubscriptionPackage::orderBy('name')->get();
        return view('subscription-packages.index', compact('packages'));
    }

    public function create()
    {
        return view('subscription-packages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'is_active' => 'boolean'
        ]);

        SubscriptionPackage::create($data);

        return redirect()->route('admin.subscription-packages.index')->with('success', 'Subscription package created successfully');
    }

    public function show($id)
    {
        $package = SubscriptionPackage::findOrFail($id);
        return view('subscription-packages.show', compact('package'));
    }

    public function edit($id)
    {
        $package = SubscriptionPackage::findOrFail($id);
        return view('subscription-packages.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = SubscriptionPackage::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'is_active' => 'boolean'
        ]);

        $package->update($data);

        return redirect()->route('admin.subscription-packages.index')->with('success', 'Subscription package updated successfully');
    }

    public function destroy($id)
    {
        $package = SubscriptionPackage::findOrFail($id);

        // Check if package has subscriptions
        if ($package->subscriptions()->exists()) {
            return redirect()->route('admin.subscription-packages.index')->with('error', 'Cannot delete package that has subscriptions');
        }

        $package->delete();
        return redirect()->route('admin.subscription-packages.index')->with('success', 'Subscription package deleted successfully');
    }
}