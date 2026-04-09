<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:categories']);
        Category::create(['name' => $request->name, 'description' => $request->description ?? '']);
        return back()->with('success', 'Category added successfully.');
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return back()->with('success', 'Category removed.');
        } catch (\Exception $e) {
            return back()->with('error', 'Cannot delete. Category is in use by products.');
        }
    }
}
