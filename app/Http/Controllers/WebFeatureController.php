<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;

class WebFeatureController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $features = Feature::orderBy('name')->get();
            return response()->json([
                'data' => $features
            ]);
        }

        $features = Feature::orderBy('name')->get();
        return view('features.index', compact('features'));
    }

    public function create()
    {
        // Not used since we use modals
        abort(404);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:features,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        Feature::create($data);

        return response()->json(['success' => true, 'message' => 'Feature created successfully']);
    }

    public function show($id)
    {
        $feature = Feature::with('subscriptionPackages')->findOrFail($id);
        return view('features.show', compact('feature'));
    }

    public function edit($id)
    {
        $feature = Feature::findOrFail($id);
        return response()->json($feature);
    }

    public function update(Request $request, $id)
    {
        $feature = Feature::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:features,name,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $feature->update($data);

        return response()->json(['success' => true, 'message' => 'Feature updated successfully']);
    }

    public function destroy($id)
    {
        $feature = Feature::findOrFail($id);

        // Check if feature is used in packages
        if ($feature->subscriptionPackages()->exists()) {
            return response()->json(['success' => false, 'message' => 'Cannot delete feature that is assigned to subscription packages']);
        }

        $feature->delete();
        return response()->json(['success' => true, 'message' => 'Feature deleted successfully']);
    }
}
