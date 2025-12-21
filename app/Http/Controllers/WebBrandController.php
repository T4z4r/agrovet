<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebBrandController extends Controller
{
    public function edit()
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        $brand = Brand::first() ?? new Brand();
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024',
            'primary_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
        ]);

        $brand = Brand::first();
        if (!$brand) {
            $brand = new Brand();
        }

        $brand->name = $request->name;
        $brand->primary_color = $request->primary_color ?: '#696cff';

        if ($request->hasFile('logo')) {
            if ($brand->logo_path && Storage::disk('public')->exists($brand->logo_path)) {
                Storage::disk('public')->delete($brand->logo_path);
            }
            $brand->logo_path = $request->file('logo')->store('brands', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($brand->favicon_path && Storage::disk('public')->exists($brand->favicon_path)) {
                Storage::disk('public')->delete($brand->favicon_path);
            }
            $brand->favicon_path = $request->file('favicon')->store('brands', 'public');
        }

        $brand->save();

        return redirect()->route('web.admin.brands.edit')->with('success', 'Brand settings updated successfully');
    }
}
