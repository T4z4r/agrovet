<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GuideController extends Controller
{
    /**
     * List guides for the authenticated user based on their role
     */
    public function index(Request $request): JsonResponse
    {
        $user = Auth::user();
        $language = $request->get('language', 'en'); // Default to English

        $query = Guide::inLanguage($language);

        // Filter by user's role
        if ($user->hasRole('owner')) {
            $query->forRole('owner');
        } elseif ($user->hasRole('seller')) {
            $query->forRole('seller');
        } else {
            // Admin can see all guides
            // No additional filtering needed
        }

        $guides = $query->with('creator:id,name')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json($guides);
    }

    /**
     * Create a new guide (Admin only)
     */
    public function store(Request $request): JsonResponse
    {
        // Check if user is admin
        if (!Auth::user()->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240', // 10MB max
            'language' => 'required|string|in:en,sw',
            'target_role' => 'required|in:owner,seller,both',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('guides', 'public');
        }

        $guide = Guide::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'file_path' => $filePath,
            'language' => $request->input('language'),
            'target_role' => $request->input('target_role'),
            'created_by' => Auth::id(),
        ]);

        return response()->json($guide->load('creator:id,name'), 201);
    }

    /**
     * Get a specific guide
     */
    public function show(Guide $guide): JsonResponse
    {
        $user = Auth::user();

        // Check if user can access this guide
        if (!$this->canAccessGuide($user, $guide)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($guide->load('creator:id,name'));
    }

    /**
     * Update a guide (Admin only)
     */
    public function update(Request $request, Guide $guide): JsonResponse
    {
        if (!Auth::user()->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240',
            'language' => 'sometimes|string|in:en,sw',
            'target_role' => 'sometimes|in:owner,seller,both',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $updateData = $request->only(['title', 'content', 'language', 'target_role']);

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($guide->file_path) {
                Storage::disk('public')->delete($guide->file_path);
            }
            $updateData['file_path'] = $request->file('file')->store('guides', 'public');
        }

        $guide->update($updateData);

        return response()->json($guide->load('creator:id,name'));
    }

    /**
     * Delete a guide (Admin only)
     */
    public function destroy(Guide $guide): JsonResponse
    {
        if (!Auth::user()->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete file if exists
        if ($guide->file_path) {
            Storage::disk('public')->delete($guide->file_path);
        }

        $guide->delete();

        return response()->json(['message' => 'Guide deleted successfully']);
    }

    /**
     * Download guide file
     */
    public function download(Guide $guide)
    {
        $user = Auth::user();

        if (!$this->canAccessGuide($user, $guide)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!$guide->file_path || !Storage::disk('public')->exists($guide->file_path)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        $filePath = Storage::disk('public')->path($guide->file_path);
        return response()->download($filePath, basename($guide->file_path));
    }

    /**
     * Check if user can access a guide
     */
    private function canAccessGuide($user, Guide $guide): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('owner') && ($guide->target_role === 'owner' || $guide->target_role === 'both')) {
            return true;
        }

        if ($user->hasRole('seller') && ($guide->target_role === 'seller' || $guide->target_role === 'both')) {
            return true;
        }

        return false;
    }
}
