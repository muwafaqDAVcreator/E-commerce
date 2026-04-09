<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:brands']);
        Brand::create(['name' => $request->name, 'description' => $request->description ?? '']);
        return back()->with('success', 'Brand added successfully.');
    }

    public function destroy(Brand $brand)
    {
        try {
            $brand->delete();
            return back()->with('success', 'Brand removed.');
        } catch (\Exception $e) {
            return back()->with('error', 'Cannot delete. Brand is in use by products.');
        }
    }
}
