<?php

namespace App\Http\Controllers;

use App\Models\CommonProduct;
use App\Models\CommonCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebCommonProductController extends Controller
{
    public function index(Request $request)
    {
        // Check if user has admin role
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $query = CommonProduct::with('commonCategory');

        if ($request->ajax()) {
            $products = $query->orderBy('name')->get();
            return response()->json([
                'data' => $products
            ]);
        }

        $products = $query->orderBy('name')->get();
        return view('common-products.index', compact('products'));
    }

    public function create()
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $categories = CommonCategory::where('is_active', true)->orderBy('name')->get();
        return view('common-products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'default_cost_price' => 'nullable|numeric|min:0',
            'default_selling_price' => 'nullable|numeric|min:0',
            'common_category_id' => 'required|exists:common_categories,id',
            'default_minimum_quantity' => 'numeric|min:0',
            'barcode' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('common-products', 'public');
            $data['photo'] = $path;
        }

        CommonProduct::create($data);

        return redirect()->route('common-products.index')->with('success', 'Common product created successfully');
    }

    public function show($id)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $product = CommonProduct::with('commonCategory')->findOrFail($id);
        return view('common-products.show', compact('product'));
    }

    public function edit($id)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $product = CommonProduct::findOrFail($id);
        $categories = CommonCategory::where('is_active', true)->orderBy('name')->get();
        return view('common-products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $product = CommonProduct::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'default_cost_price' => 'nullable|numeric|min:0',
            'default_selling_price' => 'nullable|numeric|min:0',
            'common_category_id' => 'required|exists:common_categories,id',
            'default_minimum_quantity' => 'numeric|min:0',
            'barcode' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('common-products', 'public');
            $data['photo'] = $path;
        }

        $product->update($data);

        return redirect()->route('common-products.index')->with('success', 'Common product updated successfully');
    }

    public function destroy($id)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $product = CommonProduct::findOrFail($id);

        // Check if product is linked to products (via common_product_id)
        if ($product->products()->exists()) {
            return redirect()->route('common-products.index')->with('error', 'Cannot delete product that is linked to shop products');
        }

        $product->delete();
        return redirect()->route('common-products.index')->with('success', 'Common product deleted successfully');
    }
}