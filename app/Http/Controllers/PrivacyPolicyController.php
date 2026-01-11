<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use App\Http\Resources\PrivacyPolicyResource;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $privacyPolicy = PrivacyPolicy::where('is_active', true)->first();

        return response()->json([
            'success' => true,
            'data' => new PrivacyPolicyResource($privacyPolicy),
            'message' => 'Privacy policy retrieved successfully'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $privacyPolicy = PrivacyPolicy::create($request->all());

        return response()->json([
            'success' => true,
            'data' => new PrivacyPolicyResource($privacyPolicy),
            'message' => 'Privacy policy created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $privacyPolicy = PrivacyPolicy::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => new PrivacyPolicyResource($privacyPolicy),
            'message' => 'Privacy policy retrieved successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $privacyPolicy = PrivacyPolicy::findOrFail($id);
        $privacyPolicy->update($request->all());

        return response()->json([
            'success' => true,
            'data' => new PrivacyPolicyResource($privacyPolicy),
            'message' => 'Privacy policy updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $privacyPolicy = PrivacyPolicy::findOrFail($id);
        $privacyPolicy->delete();

        return response()->json([
            'success' => true,
            'message' => 'Privacy policy deleted successfully'
        ]);
    }
}
