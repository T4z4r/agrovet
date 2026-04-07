<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\CommonProduct;
use App\Exports\ProductExport;
use App\Exports\ProductImportTemplate;
use App\Imports\ProductImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class WebProductController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Product::with('branch');

        if (!$user->hasRole('superadmin')) {
            $query->where('shop_id', $user->shop_id);
        }

        if ($request->ajax()) {
            $products = $query->orderBy('name')->get();
            return response()->json([
                'data' => $products
            ]);
        }

        $products = $query->orderBy('name')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $commonProducts = CommonProduct::where('is_active', true)->with('commonCategory')->get();
        return view('products.create', compact('commonProducts'));
    }

    public function getCommonProduct(Request $request)
    {
        $commonProduct = CommonProduct::findOrFail($request->id);
        return response()->json([
            'name' => $commonProduct->name,
            'unit' => $commonProduct->unit,
            'category' => $commonProduct->commonCategory->name ?? '',
            'cost_price' => $commonProduct->default_cost_price,
            'selling_price' => $commonProduct->default_selling_price,
            'minimum_quantity' => $commonProduct->default_minimum_quantity,
            'barcode' => $commonProduct->barcode,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => 'required',
            'unit' => 'required',
            'category' => 'required',
            'stock' => 'required',
            'minimum_quantity' => 'nullable',
            'cost_price' => 'required',
            'selling_price' => 'required',
            'barcode' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'shop_id' => 'nullable|exists:shops,id'
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('products', 'public');
            $data['photo'] = $path;
        }

        if (!$user->hasRole('superadmin')) {
            $data['shop_id'] = $user->shop_id;
        }
        // if ($user->role !== 'owner' && $user->branch_id) {
        //     $data['branch_id'] = $user->branch_id;
        // }

        $product = Product::create($data);

        // Create stock transaction if initial stock > 0
        if ($data['stock'] > 0) {
            StockTransaction::create([
                // 'branch_id' => $product->branch_id,
                'product_id' => $product->id,
                'type' => 'stock_in',
                'quantity' => $data['stock'],
                'supplier_id' => null,
                'recorded_by' => Auth::id(),
                'date' => now()->toDateString(),
                'remarks' => 'Initial stock on product creation'
            ]);
        }

        return redirect()->route('web.products.index')->with('success', 'Product created successfully');
    }

    public function show($id)
    {
        $product = Product::with('stockTransactions.supplier', 'stockTransactions.user')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $oldStock = $product->stock;

        $data = $request->validate([
            'common_product_id' => 'nullable|exists:common_products,id',
            'name' => 'required',
            'unit' => 'required',
            'category' => 'required',
            'stock_change' => 'required|numeric',
            'minimum_quantity' => 'nullable',
            'cost_price' => 'required',
            'selling_price' => 'required',
            'barcode' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'shop_id' => 'nullable|exists:shops,id'
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('products', 'public');
            $data['photo'] = $path;
        }

        // Update other fields
        $product->update(collect($data)->except('stock_change')->toArray());

        // Update stock using the old implementation pattern
        $product = $product->fresh();
        $product->stock = ($product->stock ?? 0) + $data['stock_change'];
        $product->save();
        $newStock = $product->stock;

        // Create stock transaction
        $stockDifference = $data['stock_change'];
        if ($stockDifference != 0) {
            StockTransaction::create([
                // 'branch_id' => $product->branch_id,
                'product_id' => $product->id,
                'type' => $stockDifference > 0 ? 'stock_in' : 'stock_out',
                'quantity' => abs($stockDifference),
                'supplier_id' => null,
                'recorded_by' => Auth::id(),
                'date' => now()->toDateString(),
                'remarks' => 'Stock adjustment on product update'
            ]);
        }

        return redirect()->route('web.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Check if product is linked to sales
        if ($product->saleItems()->exists()) {
            return redirect()->route('web.products.index')->with('error', 'Cannot delete product that has been sold');
        }

        // Check if product has stock transactions
        if ($product->stockTransactions()->exists()) {
            return redirect()->route('web.products.index')->with('error', 'Cannot delete product that has stock transactions');
        }

        $product->delete();
        return redirect()->route('web.products.index')->with('success', 'Product deleted successfully');
    }

    public function commonProductsList()
    {
        $commonProducts = CommonProduct::where('is_active', true)
            ->with('commonCategory')
            ->orderBy('name')
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category_name' => $product->commonCategory->name ?? null,
                    'unit' => $product->unit,
                    'default_cost_price' => $product->default_cost_price,
                    'default_selling_price' => $product->default_selling_price,
                ];
            });

        return response()->json($commonProducts);
    }

    public function addFromCommonProducts(Request $request)
    {
        $request->validate([
            'common_product_ids' => 'required|array|min:1',
            'common_product_ids.*' => 'exists:common_products,id',
        ]);

        $user = Auth::user();
        $commonProducts = CommonProduct::with('commonCategory')
            ->whereIn('id', $request->common_product_ids)
            ->where('is_active', true)
            ->get();

        $added = 0;

        foreach ($commonProducts as $commonProduct) {
            $data = [
                'shop_id' => $user->shop_id,
                'name' => $commonProduct->name,
                'unit' => $commonProduct->unit,
                'category' => $commonProduct->commonCategory->name ?? '',
                'stock' => 0,
                'cost_price' => $commonProduct->default_cost_price ?? 0,
                'selling_price' => $commonProduct->default_selling_price ?? 0,
                'minimum_quantity' => $commonProduct->default_minimum_quantity ?? 0,
                'barcode' => $commonProduct->barcode,
            ];

            if ($user->role !== 'owner' && $user->branch_id) {
                $data['branch_id'] = $user->branch_id;
            }

            Product::create($data);
            $added++;
        }

        return redirect()->route('web.products.index')
            ->with('success', $added . ' product(s) added from common products successfully.');
    }

    public function downloadTemplate()
    {
        return Excel::download(new ProductImportTemplate, 'product_import_template.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $import = new ProductImport();
        Excel::import($import, $request->file('file'));

        $errors = $import->getErrors();

        if (!empty($errors)) {
            return redirect()->route('web.products.index')->with('error', 'Import completed with errors: ' . implode(', ', $errors));
        }

        return redirect()->route('web.products.index')->with('success', 'Products imported successfully');
    }
}