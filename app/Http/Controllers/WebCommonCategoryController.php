<?php

namespace App\Http\Controllers;

use App\Models\CommonCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebCommonCategoryController extends Controller
{
    public function index(Request $request)
    {
        // Check if user has superadmin role
        if (!Auth::user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized');
        }

        $query = CommonCategory::query();

        if ($request->ajax()) {
            $categories = $query->orderBy('name')->get();
            return response()->json([
                'data' => $categories
            ]);
        }

        $categories = $query->orderBy('name')->get();
        return view('common-categories.index', compact('categories'));
    }

    public function create()
    {
        if (!Auth::user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized');
        }

        return view('common-categories.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:common_categories',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        CommonCategory::create($data);

        return redirect()->route('common-categories.index')->with('success', 'Common category created successfully');
    }

    public function show($id)
    {
        if (!Auth::user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized');
        }

        $category = CommonCategory::with('commonProducts')->findOrFail($id);
        return view('common-categories.show', compact('category'));
    }

    public function edit($id)
    {
        if (!Auth::user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized');
        }

        $category = CommonCategory::findOrFail($id);
        return view('common-categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized');
        }

        $category = CommonCategory::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:common_categories,name,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $category->update($data);

        return redirect()->route('common-categories.index')->with('success', 'Common category updated successfully');
    }

    public function destroy($id)
    {
        if (!Auth::user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized');
        }

        $category = CommonCategory::findOrFail($id);

        // Check if category has products
        if ($category->commonProducts()->exists()) {
            return redirect()->route('common-categories.index')->with('error', 'Cannot delete category that has products');
        }

        $category->delete();
        return redirect()->route('common-categories.index')->with('success', 'Common category deleted successfully');
    }
}