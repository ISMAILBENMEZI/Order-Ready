<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.Categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        if ($validated->fails())
            return back()
                ->with('error', 'This category already exists, please choose another name');

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name . '-' . uniqid()),
            'description' => $request->description,
            'status' => 'active',
        ]);

        return back()->with('success', 'Category created successfully!');
    }

    public function toggleStatus(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete category because it contains products!');
        }

        $category->status = $category->status == 'active' ? 'inactive' : 'active';
        $category->save();

        return back()->with('success', 'Status updated!');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);
        return back()->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete category because it contains products!');
        }

        $category->delete();

        return back()->with('success', 'Category deleted successfully!');
    }
}
