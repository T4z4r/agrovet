<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class WebShopController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        $shops = Shop::with('owner')->get();
        return view('shops.index', compact('shops'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        return view('shops.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
        ]);

        $data['owner_id'] = auth()->id();

        Shop::create($data);

        return redirect()->route('shops.index')->with('success', 'Shop created successfully');
    }

    public function show($id)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        $shop = Shop::with('owner')->findOrFail($id);
        return view('shops.show', compact('shop'));
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        $shop = Shop::findOrFail($id);
        return view('shops.edit', compact('shop'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        $shop = Shop::findOrFail($id);
        $shop->update($request->all());
        return redirect()->route('shops.index')->with('success', 'Shop updated successfully');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        Shop::findOrFail($id)->delete();
        return redirect()->route('shops.index')->with('success', 'Shop deleted successfully');
    }
}