<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPackage;
use App\Models\Feature;
use Illuminate\Http\Request;

class WebSubscriptionPackageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $packages = SubscriptionPackage::with('features')->orderBy('name')->get();
            return response()->json([
                'data' => $packages
            ]);
        }

        $packages = SubscriptionPackage::with('features')->orderBy('name')->get();
        $features = Feature::where('is_active', true)->get();
        return view('subscription-packages.index', compact('packages', 'features'));
    }

    public function create()
    {
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        $features = Feature::where('is_active', true)->get();
        return view('subscription-packages.create', compact('features'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
            'feature_ids' => 'nullable|array',
            'feature_ids.*' => 'exists:features,id',
            'is_active' => 'boolean'
        ]);

        $package = SubscriptionPackage::create($data);

        if ($request->has('feature_ids')) {
            $package->features()->sync($request->feature_ids);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Subscription package created successfully']);
        }

        return redirect()->route('admin.subscription-packages.index')->with('success', 'Subscription package created successfully');
    }

    public function show($id)
    {
        $package = SubscriptionPackage::with('features')->findOrFail($id);
        return view('subscription-packages.show', compact('package'));
    }

    public function edit($id)
    {
        $package = SubscriptionPackage::with('features')->findOrFail($id);
        if (request()->ajax()) {
            return response()->json($package);
        }
        $features = Feature::where('is_active', true)->get();
        return view('subscription-packages.edit', compact('package', 'features'));
    }

    public function update(Request $request, $id)
    {
        $package = SubscriptionPackage::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
            'feature_ids' => 'nullable|array',
            'feature_ids.*' => 'exists:features,id',
            'is_active' => 'boolean'
        ]);

        $package->update($data);

        if ($request->has('feature_ids')) {
            $package->features()->sync($request->feature_ids);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Subscription package updated successfully']);
        }

        return redirect()->route('admin.subscription-packages.index')->with('success', 'Subscription package updated successfully');
    }

    public function destroy($id)
    {
        $package = SubscriptionPackage::findOrFail($id);

        // Check if package has subscriptions
        if ($package->subscriptions()->exists()) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Cannot delete package that has subscriptions']);
            }
            return redirect()->route('admin.subscription-packages.index')->with('error', 'Cannot delete package that has subscriptions');
        }

        $package->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Subscription package deleted successfully']);
        }
        return redirect()->route('admin.subscription-packages.index')->with('success', 'Subscription package deleted successfully');
    }
}
