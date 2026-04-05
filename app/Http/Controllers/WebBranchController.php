<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Shop;
use Illuminate\Http\Request;

class WebBranchController extends Controller
{
    public function index()
    {
        $branches = Branch::with('shop')->get();
        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        $shops = Shop::all();
        return view('branches.create', compact('shops'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'name' => 'required|string',
            'location' => 'required|string',
        ]);

        Branch::create($data);

        return redirect()->route('web.branches.index')->with('success', 'Branch created successfully');
    }

    public function show($id)
    {
        $branch = Branch::with('shop')->findOrFail($id);
        return view('branches.show', compact('branch'));
    }

    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        $shops = Shop::all();
        return view('branches.edit', compact('branch', 'shops'));
    }

    public function update(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);
        $branch->update($request->all());
        return redirect()->route('web.branches.index')->with('success', 'Branch updated successfully');
    }

    public function destroy($id)
    {
        Branch::findOrFail($id)->delete();
        return redirect()->route('web.branches.index')->with('success', 'Branch deleted successfully');
    }
}
