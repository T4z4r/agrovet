<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Shop;
use App\Models\StockTransaction;
use App\Models\Supplier;
use App\Models\SupplierDebt;
use Illuminate\Http\Request;

class WebShopController extends Controller
{
    public function index()
    {


        $query = Shop::with('owner');

        // If user is owner, only show their own shops
        if (auth()->user()->hasRole('owner')) {
            $query->where('owner_id', auth()->id());
        }

        $shops = $query->get();
        return view('shops.index', compact('shops'));
    }

    public function create()
    {


        return view('shops.create');
    }

    public function store(Request $request)
    {


        $data = $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
        ]);

        $data['owner_id'] = auth()->id();

        Shop::create($data);

        return redirect()->route('web.shops.index')->with('success', 'Shop created successfully');
    }

    public function show($id)
    {


        $shop = Shop::with('owner', 'branches')->findOrFail($id);
        if (auth()->user()->hasRole('owner') && $shop->owner_id !== auth()->id()) {
            abort(403, 'You can only view your own shop.');
        }
        return view('shops.show', compact('shop'));
    }

    public function edit($id)
    {


        $shop = Shop::findOrFail($id);
        if (auth()->user()->hasRole('owner') && $shop->owner_id !== auth()->id()) {
            abort(403, 'You can only edit your own shop.');
        }
        return view('shops.edit', compact('shop'));
    }

    public function update(Request $request, $id)
    {


        $shop = Shop::findOrFail($id);
        if (auth()->user()->hasRole('owner') && $shop->owner_id !== auth()->id()) {
            abort(403, 'You can only update your own shop.');
        }
        $shop->update($request->all());
        return redirect()->route('web.shops.index')->with('success', 'Shop updated successfully');
    }

    public function destroy($id)
    {


        $shop = Shop::findOrFail($id);
        if (auth()->user()->hasRole('owner') && $shop->owner_id !== auth()->id()) {
            abort(403, 'You can only delete your own shop.');
        }

        // Prevent deletion if shop has linked data
        if ($shop->products()->exists() || $shop->branches()->exists() ||
            Supplier::where('shop_id', $shop->id)->exists() ||
            Sale::where('shop_id', $shop->id)->exists() ||
            StockTransaction::where('shop_id', $shop->id)->exists() ||
            SupplierDebt::where('shop_id', $shop->id)->exists()) {
            return redirect()->route('web.shops.index')->with('error', 'Cannot delete shop with linked data.');
        }

        $shop->delete();
        return redirect()->route('web.shops.index')->with('success', 'Shop deleted successfully');
    }
}
