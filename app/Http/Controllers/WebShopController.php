<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class WebShopController extends Controller
{
    public function index()
    {


        $shops = Shop::with('owner')->get();
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
        return view('shops.show', compact('shop'));
    }

    public function edit($id)
    {


        $shop = Shop::findOrFail($id);
        return view('shops.edit', compact('shop'));
    }

    public function update(Request $request, $id)
    {


        $shop = Shop::findOrFail($id);
        $shop->update($request->all());
        return redirect()->route('web.shops.index')->with('success', 'Shop updated successfully');
    }

    public function destroy($id)
    {


        Shop::findOrFail($id)->delete();
        return redirect()->route('web.shops.index')->with('success', 'Shop deleted successfully');
    }
}
